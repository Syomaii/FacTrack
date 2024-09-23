@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div>
                <h6 class="fw-semibold mb-0">{{ $facility->name }}</h6>
                <h8 class="fw-medium">{{ $facility->description }}</h8>
            </div>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">{{ $facility->name }}</li>
            </ul>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-3 mb-24">
            <button type="button" class="btn rounded-pill btn-outline-warning-600 radius-8 px-20 py-11"
                id="updateFacilityBtn">Update</button>
            <button type="button" class="btn rounded-pill btn-outline-danger-600 radius-8 px-20 py-11"
                id="deleteFacilityBtn">Delete</button>
            <a href="/add-equipment/{{ $facility->id }}"><button type="button" class="btn rounded-pill btn-outline-success-600 radius-8 px-20 py-11"
                id="addEquipmentBtn">+</button></a>
        </div>

        @if (session('updateFacilitySuccess'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('updateFacilitySuccess') }}
                </div>
            </div>
        @elseif (session('addEquipmentSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('addEquipmentSuccessfully') }}
                </div>
            </div>sdsd
        @endif

        <div class="row gy-4" id="equipmentList">
            @foreach ($equipments as $facEquipment)
                <div class="col-xxl-3 col-sm-6">
                    <div class="card h-100 radius-12 text-center">
                        <div class="card-body p-24">
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{ asset($facEquipment->image) }}" alt="{{ $facEquipment->name }}"
                                    class="img-fluid rounded mb-3 max-img-size" />
                                <h6 class="mb-8">{{ $facEquipment->name }}</h6>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="javascript:void(0)"
                                        class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center view-equipment"
                                        data-id="{{ $facEquipment->id }}">
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center edit-equipment"
                                        data-id="{{ $facEquipment->id }}" data-name="{{ $facEquipment->name }}"
                                        data-description="{{ $facEquipment->description }}"
                                        data-acquired_date="{{ $facEquipment->acquired_date }}"
                                        data-status="{{ $facEquipment->status }}"
                                        data-facility="{{ $facEquipment->facility }}">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center delete-equipment"
                                        data-id="{{ $facEquipment->id }}">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                                    <form id="delete-form-{{ $facEquipment->id }}"
                                        action="{{ route('delete_equipment', $facEquipment->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    @include('templates.footer')
</main>

<!-- Add Equipment Modal Start -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEquipmentModalLabel">Add Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/add-equipment" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="facility" value="{{ $facility->id }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            id="name" name="name" placeholder="Enter Equipment Name"
                            value="{{ old('name') }}">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description"
                            name="description" placeholder="Write description...">{{ old('description') }}</textarea>
                        <small class="text-danger">{{ $errors->first('description') }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="acquired_date" class="form-label">Acquired Date</label>
                        <input type="date"
                            class="form-control {{ $errors->has('acquired_date') ? 'is-invalid' : '' }}"
                            id="acquired_date" name="acquired_date" value="{{ old('acquired_date') }}">
                        <small class="text-danger">{{ $errors->first('acquired_date') }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" id="status"
                            name="status">
                            <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="In maintenance" {{ old('status') == 'In maintenance' ? 'selected' : '' }}>
                                In maintenance</option>
                            <option value="In repair" {{ old('status') == 'In repair' ? 'selected' : '' }}>In repair
                            </option>
                            <option value="Borrowed" {{ old('status') == 'Borrowed' ? 'selected' : '' }}>Borrowed
                            </option>
                        </select>
                        <small class="text-danger">{{ $errors->first('status') }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                            id="image" name="image">
                        <small class="text-danger">{{ $errors->first('image') }}</small>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Equipment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Equipment Modal End -->

<!-- Edit Facility Modal -->
<div class="modal fade" id="editFacilityModal" tabindex="-1" aria-labelledby="editFacilityModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFacilityModalLabel">Edit Facility</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateFacility', $facility->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="facilityId" value="{{ $facility->id }}">
                    <div class="mb-3">
                        <label for="facilityName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="facilityName" name="name"
                            value="{{ $facility->name }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="facilityDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="facilityDescription" name="description" required>{{ $facility->description }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
                    <div class="mb-3">
                        <label for="equipmentName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="equipmentName" name="name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="equipmentDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="equipmentDescription" name="description" required></textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="equipmentAcquiredDate" class="form-label">Acquired Date</label>
                        <input type="datetime-local" class="form-control" id="equipmentAcquiredDate"
                            name="acquired_date">
                        @error('acquired_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="equipmentFacility" class="form-label">Facility</label>
                        <input type="text" class="form-control" id="equipmentFacility" name="facility">
                        @error('facility')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="equipmentStatus" class="form-label">Status</label>
                        <select class="form-control" id="equipmentStatus" name="status" required>
                            <option value="Available" selected>Available</option>
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

<!-- Delete Facility Form -->
<form id="deleteFacilityForm" action="{{ route('deleteFacility', $facility->id) }}" method="POST"
    style="display: none;">
    @csrf
    @method('DELETE')
</form>

@include('templates.footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var updateFacilityBtn = document.getElementById('updateFacilityBtn');
        var deleteFacilityBtn = document.getElementById('deleteFacilityBtn');
        var addEquipmentBtn = document.getElementById('addEquipmentBtn');
        var equipmentList = document.getElementById('equipmentList');

        updateFacilityBtn.addEventListener('click', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editFacilityModal'));
            editModal.show();
        });

        deleteFacilityBtn.addEventListener('click', function() {
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
                    document.getElementById('deleteFacilityForm').submit();
                }
            });
        });

        // addEquipmentBtn.addEventListener('click', function() {
        //     var addModal = new bootstrap.Modal(document.getElementById('addEquipmentModal'));
        //     addModal.show();
        // });

        equipmentList.addEventListener('click', function(e) {
            if (e.target.closest('.view-equipment')) {
                var button = e.target.closest('.view-equipment');
                var id = button.dataset.id;
                window.location.href = `/borrower-form/${id}`;
            }

            if (e.target.closest('.edit-equipment')) {
                var button = e.target.closest('.edit-equipment');
                var id = button.dataset.id;
                var name = button.dataset.name;
                var description = button.dataset.description;
                var acquired_date = button.dataset.acquired_date;
                var status = button.dataset.status;
                var facility = button.dataset.facility;

                var formattedDate = new Date(acquired_date).toISOString().slice(0, 16);

                document.getElementById('equipmentId').value = id;
                document.getElementById('equipmentName').value = name;
                document.getElementById('equipmentDescription').value = description;
                document.getElementById('equipmentAcquiredDate').value = formattedDate;
                document.getElementById('equipmentStatus').value = status;
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
</script>
