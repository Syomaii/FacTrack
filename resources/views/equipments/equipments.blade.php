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
            <div class="card-body">
                <table class="table bordered-table mb-0" data-page-length='10'>
                    <form action="">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Search" name="q"
                                    value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}">
                            </div>
                            <div class="col-md-4">
                                <select name="category" id="" class="form-control">
                                    <option value="" hidden>Category</option>
                                    <option
                                        {{ isset($_GET['category']) && $_GET['category'] == 'Available' ? 'selected' : '' }}>
                                        Available</option>
                                    <option
                                        {{ isset($_GET['category']) && $_GET['category'] == 'Maintenance' ? 'selected' : '' }}>
                                        Maintenance</option>
                                    <option
                                        {{ isset($_GET['category']) && $_GET['category'] == 'Borrowed' ? 'selected' : '' }}>
                                        Borrowed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="e" id="" class="form-control">
                                    <option value="10" hidden>Entries per page</option>
                                    <option {{ isset($_GET['e']) && $_GET['e'] == 10 ? 'selected' : '' }}>10</option>
                                    <option {{ isset($_GET['e']) && $_GET['e'] == 25 ? 'selected' : '' }}>25</option>
                                    <option {{ isset($_GET['e']) && $_GET['e'] == 50 ? 'selected' : '' }}>50</option>
                                    <option {{ isset($_GET['e']) && $_GET['e'] == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
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
                                <td><a href="javascript:void(0)" class="text-primary-600">#{{ $equipment->id }}</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $equipment->image }}" alt=""
                                            class="flex-shrink-0 me-12 radius-8" width="50">
                                    </div>
                                </td>
                                <td>{{ $equipment->brand }}</td> <!-- Brand Data -->
                                <td>{{ $equipment->name }}</td>
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
                                            class="bg-warning-focus px-24 py-4 rounded-pill fw-medium text-sm">{{ $equipment->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/equipment-details/{{ $equipment->code }}"
                                        class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center view-equipment"
                                        data-id="{{ $equipment->id }}">
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
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
                {{ $equipments->links() }}
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

                    <!-- Status -->
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
                var status = button.dataset.status;
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
                document.getElementById('equipmentStatus').value = status;
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
</script>
