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

        @if (session('updateFacilitySuccess'))
            <div class="alert alert-success">
                {{ session('updateFacilitySuccess') }}
            </div>
        @elseif (session('addEquipmentSuccessfully'))
            <div class="alert alert-success">
                {{ session('addEquipmentSuccessfully') }}
            </div>
        @endif

        <!-- Search Bar and Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-24">
            <div class="input-group" style="max-width: 350px;">
                <input type="text" id="equipmentSearch" class="form-control radius-8 border-0 shadow-sm"
                    placeholder="Search equipment...">
                <button class="btn btn-outline-success-600 radius-8 px-3 py-2">
                    <iconify-icon icon="ic:baseline-search" class="icon text-xl"></iconify-icon>
                </button>
            </div>

            <div class="d-flex gap-3">
                <button type="button" class="btn rounded-pill btn-outline-warning-600 radius-8 px-20 py-11"
                    id="updateFacilityBtn">Update</button>
                <button type="button" class="btn rounded-pill btn-outline-danger-600 radius-8 px-20 py-11"
                    id="deleteFacilityBtn">Delete</button>
                <a href="/add-equipment/{{ $facility->id }}">
                    <button type="button" class="btn rounded-pill btn-outline-success-600 radius-8 px-20 py-11"
                        id="addEquipmentBtn">+</button>
                </a>
            </div>
        </div>

        <!-- No equipment message -->
        <div class="row gy-4" id="equipmentList">
            @if ($equipments->isNotEmpty())
                @foreach ($equipments as $facEquipment)
                    <div class="col-xxl-3 col-sm-6 equipment-card">
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
            @else
                <div class="d-flex justify-content-center align-items-center" style="height: 55vh; width: 100vw;">
                    <strong class="text-center">There is no equipment yet in this facility.</strong>
                </div>
            
            @endif
        </div>

    </div>

    @include('templates.footer')
</main>

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
                <form id="editFacilityForm" action="{{ route('updateFacility', $facility->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $facility->id }}">
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

<!-- Delete Facility Form -->
<form id="deleteFacilityForm" action="{{ route('deleteFacility', $facility->id) }}" method="POST"
    style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var equipmentList = document.getElementById('equipmentList');
        var searchInput = document.getElementById('equipmentSearch');

        // Search Equipment Functionality
        searchInput.addEventListener('input', function() {
            var filter = searchInput.value.toLowerCase();
            var equipmentCards = equipmentList.querySelectorAll('.col-xxl-3');

            equipmentCards.forEach(function(card) {
                var equipmentName = card.querySelector('h6').innerText.toLowerCase();
                if (equipmentName.includes(filter)) {
                    card.style.display = ''; // Show matching card
                } else {
                    card.style.display = 'none'; // Hide non-matching card
                }
            });
        });

        // Update and Delete Facility Handlers
        document.getElementById('updateFacilityBtn').addEventListener('click', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editFacilityModal'));
            editModal.show();
        });

        document.getElementById('deleteFacilityBtn').addEventListener('click', function() {
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

        // Handle click events for the equipment actions
        equipmentList.addEventListener('click', function(e) {
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
