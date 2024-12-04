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
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('addEquipmentSuccessfully') }}
                </div>
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
                            <a href="javascript:void(0)"
                                class="btn btn-success text-base radius-8 px-20 py-11 edit-equipment"
                                data-id="{{ $equipments->id }}" data-name="{{ $equipments->name }}"
                                data-description="{{ $equipments->description }}"
                                data-acquired_date="{{ $equipments->acquired_date }}"
                                data-facility="{{ $equipments->facility->name }}"
                                data-brand="{{ $equipments->brand }}"
                                data-serial_no="{{ $equipments->serial_no }}">Edit
                                Equipment
                            </a>
                            <a href="javascript:void(0)"
                                class="btn btn-danger text-base radius-8 px-20 py-11 delete-equipment"
                                data-id="{{ $equipments->id }}">Delete Equipment
                            </a>

                            <button type="button" class="btn btn-primary text-base radius-8 px-20 py-11"
                                onclick="printInvoice()">
                                Print QR Code
                            </button>

                            <form id="delete-form-{{ $equipments->id }}"
                                action="{{ route('delete_equipment', $equipments->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

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

                    // For Borrowed status: filter unique borrower entries by name and department
                    $uniqueBorrowers =
                        $entry->status === 'Borrowed' && $entry->equipment->borrows->isNotEmpty()
                            ? $entry->equipment->borrows->unique(function ($borrow) {
                                return $borrow->borrowers_name . '|' . $borrow->department;
                            })
                            : collect();
                @endphp

                <div class="timeline-item {{ $loop->even ? 'below' : 'above' }}"
                    style="border-left: 5px solid {{ $color }}; padding-left: 10px; margin-bottom: 20px; background: #f9f9f9; border-radius: 5px; padding: 15px;">
                    <p>{{ 'The status of the equipment is ' . $entry->status }}</p>

                    @if ($entry->status == 'Borrowed')
                        @forelse ($uniqueBorrowers as $borrower)
                            <p>{{ 'Borrower: ' . ucwords($borrower->borrowers_name) }}</p>
                            <p>{{ 'Department: ' . ucwords($borrower->department) }}</p>
                        @empty
                            <p>{{ 'No borrower found' }}</p>
                        @endforelse
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
                    <p>{{ 'Operated by ' . $entry->user->firstname . ' ' . ucwords($entry->user->lastname) }}</p>
                </div>
            @endforeach
        </div>


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
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="equipmentId">

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="equipmentName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="equipmentName" name="name" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Brand -->
                        <div class="mb-3">
                            <label for="equipmentBrand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="equipmentBrand" name="brand" required>
                            @error('brand')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Serial Number -->
                        <div class="mb-3">
                            <label for="equipmentSerialNo" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="equipmentSerialNo" name="serial_no" required>
                            @error('serial_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="equipmentDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="equipmentDescription" name="description" required></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Acquired Date -->
                        <div class="mb-3">
                            <label for="equipmentAcquiredDate" class="form-label">Acquired Date</label>
                            <input type="datetime-local" class="form-control" id="equipmentAcquiredDate"
                                name="acquired_date" required>
                            @error('acquired_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Facility -->
                        <div class="mb-3">
                            <label for="equipmentFacility" class="form-label">Facility</label>
                            <input type="text" class="form-control" id="equipmentFacility" name="facility"
                                required>
                            @error('facility')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('templates.footer')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-equipment')) {
                var button = e.target.closest('.edit-equipment');
                var id = button.dataset.id;
                var name = button.dataset.name;
                var brand = button.dataset.brand;
                var serial_no = button.dataset.serial_no;
                var description = button.dataset.description;
                var acquired_date = button.dataset.acquired_date;
                var facility = button.dataset.facility;

                var formattedDate = new Date(acquired_date).toISOString().slice(0, 16);

                document.getElementById('equipmentId').value = id;
                document.getElementById('equipmentName').value = name;
                document.getElementById('equipmentBrand').value = brand;
                document.getElementById('equipmentSerialNo').value = serial_no;
                document.getElementById('equipmentDescription').value = description;
                document.getElementById('equipmentAcquiredDate').value = formattedDate;
                document.getElementById('equipmentFacility').value = facility;

                var editModal = new bootstrap.Modal(document.getElementById('editEquipmentModal'));
                editModal.show();
            }

            if (e.target.closest('.delete-equipment')) {
                var button = e.target.closest('.delete-equipment');
                var id = button.dataset.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            }
        });
    });

    function printInvoice() {
        var printContents = document.getElementById('qrCode').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
