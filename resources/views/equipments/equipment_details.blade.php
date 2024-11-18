@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Equipment Details</h6>
            <ul class="breadcrumb d-flex align-items-center gap-2">
                <li>
                    <a href="/dashboard" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                @if (auth()->user()->type != 'admin')
                    <li>
                        <a href="/equipments" class="d-flex align-items-center gap-1 hover-text-primary">Equipments</a>
                    </li>
                @endif
                <li>-</li>
                <li>{{ $equipments->name }}</li>
            </ul>
        </div>

        <!-- Success Alert -->
        @if (session('addEquipmentSuccessfully'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                <iconify-icon icon="akar-icons:double-check" class="icon me-2"></iconify-icon>
                {{ session('addEquipmentSuccessfully') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Equipment Details Card -->
        <div class="card bg-white shadow rounded-3 p-3 mb-4">
            <div class="row g-0">
                <!-- Image Section -->
                <div class="col-md-6 text-center">
                    <p class="ename">{{ ucwords($equipments->name) }}</p>
                    <img src="{{ asset($equipments->image) }}" class="img-fluid rounded"
                        alt="{{ ucwords($equipments->name) }}">
                </div>

                <!-- Details Section -->
                <div class="col-md-6">
                    <div class="row">
                        @foreach ([
        'Brand' => $equipments->brand,
        'Status' => $equipments->status,
        'Serial Number' => $equipments->serial_no,
        'Facility' => $equipments->facility->name,
        'Acquisition Date' => date('d M Y', strtotime($equipments->acquired_date)),
    ] as $label => $value)
                            <div class="col-md-6 mb-3">
                                <strong>{{ $label }}:</strong>
                                <p>{{ $value }}</p>
                            </div>
                        @endforeach
                        <div class="col-md-6">
                            <strong>QR Code:</strong>
                            <div id="qrCode">{!! QrCode::size(100)->generate($equipments->code) !!}</div>
                        </div>
                    </div>

                    @if (auth()->user()->type === 'facility manager')
                        <div class="mt-4">
                            @if (!in_array($equipments->status, ['Donated', 'Disposed']))
                                <a href="javascript:void(0)" class="btn btn-success edit-equipment"
                                    data-id="{{ $equipments->id }}" data-name="{{ $equipments->name }}"
                                    data-description="{{ $equipments->description }}"
                                    data-status="{{ $equipments->status }}"
                                    data-facility="{{ $equipments->facility->name }}"
                                    data-brand="{{ $equipments->brand }}"
                                    data-serial_no="{{ $equipments->serial_no }}">
                                    Edit Equipment
                                </a>
                                <button type="button" class="btn btn-primary" onclick="printInvoice()">
                                    Print QR Code
                                </button>
                            @endif
                            <a href="javascript:void(0)" class="btn btn-danger delete-equipment"
                                data-id="{{ $equipments->id }}">
                                Delete Equipment
                            </a>
                            <form id="delete-form-{{ $equipments->id }}"
                                action="{{ route('delete_equipment', $equipments->id) }}" method="POST"
                                style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="timeline-horizontal">
            @foreach ($timeline->sortByDesc('created_at') as $entry)
                @php
                    // Determine the background color based on the status
                    $statusColors = [
                        'Available' => 'green',
                        'In Maintenance' => 'yellow',
                        'Borrowed' => 'orange',
                        'In Repair' => 'red',
                        'Donated' => 'brown',
                        'Disposed' => 'black',
                    ];
                    $color = $statusColors[$entry->status] ?? 'gray';
                @endphp

                <div class="timeline-item {{ $loop->even ? 'below' : 'above' }}"
                    style="border-left: 5px solid {{ $color }}; padding-left: 10px;">
                    <p>{{ 'The status of the equipment is ' . $entry->status }}</p>

                    @if ($entry->status == 'Borrowed')
                        @if ($entry->equipment->borrows->isNotEmpty())
                            @foreach ($entry->equipment->borrows as $borrower)
                                <p>{{ 'Borrower: ' . ucwords($borrower->borrowers_name) }}</p>
                                <p>{{ 'Borrower Department: ' . ucwords($borrower->department) }}</p>
                            @endforeach
                        @else
                            <p>{{ 'No borrower found' }}</p>
                        @endif
                    @elseif($entry->status == 'In Maintenance')
                        @if ($entry->equipment->maintenance->isNotEmpty())
                            @foreach ($entry->equipment->maintenance as $maintenance)
                                <p>{{ 'Issue: ' . ucwords($maintenance->issue) }}</p>
                            @endforeach
                        @else
                            <p>{{ 'No issue found' }}</p>
                        @endif
                    @elseif($entry->status == 'In Repair')
                        @if ($entry->equipment->repairs->isNotEmpty())
                            @foreach ($entry->equipment->repairs as $repair)
                                <p>{{ 'Issue: ' . ucwords($repair->issue) }}</p>
                            @endforeach
                        @else
                            <p>{{ 'No issue found' }}</p>
                        @endif
                    @elseif($entry->status == 'Donated')
                        @if ($entry->equipment->donated->isNotEmpty())
                            @foreach ($entry->equipment->donated as $donates)
                                <p>{{ 'Condition: ' . ucwords($donates->condition) }}</p>
                                <p>{{ 'Recipient: ' . ucwords($donates->recipient) }}</p>
                            @endforeach
                        @endif
                    @elseif($entry->status == 'Disposed')
                        @if ($entry->equipment->disposed->isNotEmpty())
                            @foreach ($entry->equipment->disposed as $disposes)
                                <p>{{ 'Disposed By: ' . ucwords($disposes->user->firstname) . ' ' . ucwords($disposes->user->lastname) }}
                                </p>
                            @endforeach
                        @else
                            <p>{{ 'No disposal record found' }}</p>
                        @endif
                    @endif
                    <p>{{ $entry->remarks . ' at ' . $entry->created_at }}</p>
                    <p>{{ 'Operated by ' . ucwords($entry->user->firstname) . ' ' . ucwords($entry->user->lastname) }}
                    </p>
                </div>
            @endforeach
        </div>

        @include('templates.footer_inc')

        <!-- Edit Equipment Modal -->
        <div class="modal fade" id="editEquipmentModal" tabindex="-1" aria-labelledby="editEquipmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEquipmentModalLabel">Edit Equipment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editEquipmentForm" action="{{ route('update_equipment') }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="id" id="equipmentId">
                            @foreach ([
        'Name' => 'equipmentName',
        'Brand' => 'equipmentBrand',
        'Serial Number' => 'equipmentSerialNo',
        'Description' => 'equipmentDescription',
        'Acquired Date' => 'equipmentAcquiredDate',
        'Facility' => 'equipmentFacility',
    ] as $label => $id)
                                <div class="mb-3">
                                    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
                                    <input type="{{ $id === 'equipmentAcquiredDate' ? 'datetime-local' : 'text' }}"
                                        class="form-control" id="{{ $id }}"
                                        name="{{ strtolower(str_replace(' ', '_', $label)) }}" required>
                                    @error(strtolower(str_replace(' ', '_', $label)))
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
    </div>
                @php
                    // Determine the background color based on the status
                    $statusColors = [
                        'Available' => 'green',
                        'In Maintenance' => 'yellow',
                        'Borrowed' => 'orange',
                        'Missing' => 'red',
                    ];
                    $color = $statusColors[$entry->status] ?? 'gray'; // Default to gray if status not in array
                @endphp

        
    

    <!-- Edit Equipment Modal -->
    <div class="modal fade" id="editEquipmentModal" tabindex="-1" aria-labelledby="editEquipmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEquipmentModalLabel">Edit Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEquipmentForm" action="{{ route('update_equipment') }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="id" id="equipmentId">
                        @foreach ([
                            'Name' => 'equipmentName',
                            'Brand' => 'equipmentBrand',
                            'Serial Number' => 'equipmentSerialNo',
                            'Description' => 'equipmentDescription',
                            'Acquired Date' => 'equipmentAcquiredDate',
                            'Facility' => 'equipmentFacility',
                        ] as $label => $id)
                            <div class="mb-3">
                                <label for="equipmentStatus" class="form-label">Status</label>
                                <select class="form-control" id="equipmentStatus" name="status" required>
                                    <option value="Available">Available</option>
                                    <option value="In Maintenance">In Maintenance</option>
                                    <option value="In Repair">In Repair</option>
                                    <option value="Borrowed">Borrowed</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD
=======
    </div>
    @include('templates.footer_inc')
>>>>>>> 2c8075e47dbeeea5cb86e2095ed799736f4ffcc1
</main>
@include('templates.footer')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Adjust spacing for the QR Code section
        const qrCodeContainer = document.getElementById('qrCode');
        if (qrCodeContainer) {
            qrCodeContainer.style.marginBottom = '20px'; // Add space between the QR code and buttons
            qrCodeContainer.style.marginTop = '10px'; // Ensure space above the QR code
        }

        // Adjust spacing for the button container
        const buttonContainer = document.querySelector('.mt-4');
        if (buttonContainer) {
            buttonContainer.style.marginTop = '30px'; // Create space between the QR code and the buttons
            buttonContainer.style.display = 'flex'; // Arrange buttons in a row
            buttonContainer.style.justifyContent = 'flex-start'; // Align buttons to the left
            buttonContainer.style.gap = '10px'; // Add space between each button
        }

        // Adjust spacing for each button (optional, if additional individual button tweaks are needed)
        const buttons = buttonContainer?.querySelectorAll('a, button');
        if (buttons) {
            buttons.forEach((button) => {
                button.style.padding = '10px 15px'; // Ensure consistent button padding
            });
        }

        document.addEventListener('click', (e) => {
            const button = e.target.closest('.edit-equipment') || e.target.closest('.delete-equipment');
            if (button) {
                if (button.classList.contains('edit-equipment')) {
                    showEditModal(button.dataset);
                } else {
                    confirmDelete(button.dataset.id);
                }
            }
        });
    });

    function printInvoice() {
        const printContents = document.getElementById('qrCode').innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        location.reload();
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(delete - form - $ {
                    id
                }).submit();
            }
        });
    }
</script>

<<<<<<< HEAD
@include('templates.footer')
=======
>>>>>>> 2c8075e47dbeeea5cb86e2095ed799736f4ffcc1
