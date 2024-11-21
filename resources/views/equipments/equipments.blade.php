@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Equipments</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Equipments</li>
            </ul>
        </div>
        @if (session('updateEquipmentSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('updateEquipmentSuccessfully') }}
                </div>
            </div>
        @elseif (session('deleteEquipmentSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('deleteEquipmentSuccessfully') }}
                </div>
            </div>
        @elseif (session('borrowedSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('borrowedSuccessfully') }}
                </div>
            </div>
        @endif

        <div class="card basic-data-table">

            <div
                class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <form class="navbar-search" method="GET" action="{{ route('equipment_search') }}">
                        <input type="text" class="bg-base h-40-px w-auto" name="search" id="equipmentSearch"
                            placeholder="Search" value="{{ request('search') }}">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </form>
                    <select name="status" id="statusFilter"
                        class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                        <option value="">Status</option>
                        <option value="Available">Available</option>
                        <option value="Borrowed">Borrowed</option>
                        <option value="In Maintenance">In Maintenance</option>
                        <option value="In Repair">In Repair</option>
                        <option value="Donated">Donated</option>
                        <option value="Disposed">Disposed</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <table class="table bordered-table mb-0" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">Item No.</th>
                            <th class="col"></th>
                            <th scope="col">Brand</th> <!-- Brand First -->
                            <th scope="col">Name</th>
                            <th scope="col">Serial No.</th> <!-- Serial Number Column -->
                            <th scope="col">Facility</th>
                            <th scope="col">Code</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipments as $equipment)
                            <tr>
                                <td><a href="javascript:void(0)" class="text-primary-600">#{{ $equipment->id }}</a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $equipment->image }}" alt=""
                                            class="flex-shrink-0 me-12 radius-8" width="50">
                                    </div>
                                </td>
                                <td>{{ ucwords($equipment->brand) }}</td> <!-- Brand Data -->
                                <td>{{ ucwords($equipment->name) }}</td>
                                <td>{{ $equipment->serial_no }}</td> <!-- Serial Number Data -->
                                <td>{{ $equipment->facility->name }}</td>
                                <td>{!! QrCode::size(100)->generate($equipment->code) !!}</td>
                                <td>
                                    @if ($equipment->status === 'Available')
                                        <span
                                            class="bg-success-focus px-24 py-4 rounded-pill fw-medium text-sm">{{ $equipment->status }}</span>
                                    @elseif($equipment->status === 'In Maintenance')
                                        <span
                                            class="bg-info px-24 py-4 rounded-pill fw-medium text-sm">{{ $equipment->status }}</span>
                                    @elseif($equipment->status === 'In Repair')
                                        <span
                                            class="bg-danger-focus px-24 py-4 rounded-pill fw-medium text-sm">{{ $equipment->status }}</span>
                                    @elseif($equipment->status === 'Borrowed')
                                        <span
                                            class="bg-black text-white px-24 py-4 rounded-pill fw-medium text-sm">{{ $equipment->status }}</span>
                                    @elseif($equipment->status === 'Disposed')
                                        <span
                                            class="bg-danger-focus px-24 py-4 rounded-pill fw-medium text-sm">{{ $equipment->status }}</span>
                                    @elseif($equipment->status === 'Donated')
                                        <span
                                            class="bg-brown text-white px-24 py-4 rounded-pill fw-medium text-sm">{{ $equipment->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/equipment-details/{{ $equipment->code }}"
                                        class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center view-equipment"
                                        data-id="{{ $equipment->id }}">
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                    @if ($equipment->status !== 'Donated' && $equipment->status !== 'Disposed')
                                        <a href="javascript:void(0)"
                                            class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center edit-equipment"
                                            data-id="{{ $equipment->id }}" data-name="{{ $equipment->name }}"
                                            data-brand="{{ $equipment->brand }}"
                                            data-serial_no="{{ $equipment->serial_no }}"
                                            data-description="{{ $equipment->description }}"
                                            data-acquired_date="{{ $equipment->acquired_date }}"
                                            data-status="{{ $equipment->status }}"
                                            data-facility="{{ $equipment->facility->name }}">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>
                                    @endif
                                    <a href="javascript:void(0)"
                                        class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center delete-equipment"
                                        data-id="{{ $equipment->id }}">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                                    <form id="delete-form-{{ $equipment->id }}"
                                        action="{{ route('delete_equipment', $equipment->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center"><strong>No equipments found from your
                                        office/department.</strong></td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                    <span>Showing {{ $equipments->firstItem() }} to {{ $equipments->lastItem() }} of
                        {{ $equipments->total() }} entries</span>

                    @if ($equipments->total() > 0)
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                    href="{{ $equipments->previousPageUrl() }}"
                                    aria-disabled="{{ $equipments->onFirstPage() }}">
                                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                </a>
                            </li>

                            <!-- Pagination Pages -->
                            @if ($equipments->lastPage() > 1)
                                <!-- Show first page if not too close to current -->
                                @if ($equipments->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $equipments->url(1) }}">1</a>
                                    </li>
                                    @if ($equipments->currentPage() > 4)
                                        <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                    @endif
                                @endif

                                @for ($i = max(1, $equipments->currentPage() - 1); $i <= min($equipments->lastPage(), $equipments->currentPage() + 1); $i++)
                                    <li class="page-item">
                                        <a class="page-link {{ $i === $equipments->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-300 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $equipments->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($equipments->currentPage() < $equipments->lastPage() - 2)
                                    @if ($equipments->currentPage() < $equipments->lastPage() - 3)
                                        <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $equipments->url($equipments->lastPage()) }}">{{ $equipments->lastPage() }}</a>
                                    </li>
                                @endif
                            @else
                                <!-- If there's only one page -->
                                <span>Page 1</span>
                            @endif

                            <!-- Next Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                    href="{{ $equipments->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    @else
                        <!-- Display message if no entries -->
                        <span>No entries found.</span>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @include('templates.footer_inc')
</main>

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
                        <input type="text" class="form-control" id="equipmentFacility" name="facility" required>
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

@include('templates.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var table = document.querySelector('table');

        // Edit Equipment Modal
        table.addEventListener('click', function(e) {
            if (e.target.closest('.edit-equipment')) {
                var button = e.target.closest('.edit-equipment');
                var id = button.dataset.id;
                var name = button.dataset.name;
                var brand = button.dataset.brand;
                var serial_no = button.dataset.serial_no;
                var description = button.dataset.description;
                var acquired_date = button.dataset.acquired_date;
                var facility = button.dataset.facility;

                // Format acquired date for input field
                var formattedDate = new Date(acquired_date).toISOString().slice(0, 16);

                // Populate modal with data
                document.getElementById('equipmentId').value = id;
                document.getElementById('equipmentName').value = name;
                document.getElementById('equipmentBrand').value = brand;
                document.getElementById('equipmentSerialNo').value = serial_no;
                document.getElementById('equipmentDescription').value = description;
                document.getElementById('equipmentAcquiredDate').value = formattedDate;
                document.getElementById('equipmentFacility').value = facility;

                // Show the modal
                var editModal = new bootstrap.Modal(document.getElementById('editEquipmentModal'));
                editModal.show();
            }

            // Delete Equipment Confirmation
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

    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('statusFilter');
        const tableRows = document.querySelectorAll('tbody tr');

        // Function to filter table rows based on selected status
        statusFilter.addEventListener('change', function() {
            const selectedStatus = statusFilter.value.toLowerCase();

            tableRows.forEach(row => {
                const statusCell = row.cells[7].innerText
                    .toLowerCase(); // Assuming status is in the 8th column (index 7)
                if (selectedStatus === '' || statusCell.includes(selectedStatus)) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        });
    });
</script>
