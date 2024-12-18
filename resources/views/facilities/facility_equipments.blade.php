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
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                @if (auth()->user()->type === 'facility manager')
                    <li>-</li>
                    <a href="{{ route('facilities') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Facilities
                    </a>
                @elseif (auth()->user()->type === 'admin')
                    <li>-</li>
                    <a href="{{ route('offices') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Offices
                    </a>
                    <li>-</li>
                    <a href="{{ route('officeFacilities', ['id' => $facility->office->id]) }}"
                        class="d-flex align-items-center gap-1 hover-text-primary">
                        {{ $facility->office->name }}
                    </a>
                @endif
                <li>-</li>
                <a href="{{ route('facility_equipment', ['id' => $facility->id]) }}"
                    class="d-flex align-items-center gap-1 hover-text-primary">
                    {{ $facility->name }}
                </a>
            </ul>

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
            </div>
        @elseif (session('success'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('success') }}
                </div>
            </div>
        @elseif ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                    role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="mingcute:delete-2-line" class="icon text-xl"></iconify-icon>
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Search Bar and Buttons -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-24">
            <!-- Search Bar -->
            <div class="input-group flex-grow-1 flex-sm-grow-0 mb-3 mb-sm-0" style="max-width: 650px;">
                <input type="text" id="equipmentSearch" class="form-control radius-8 border-0 shadow-sm"
                    placeholder="Search equipment...">
                <button class="btn btn-primary" type="button" style="z-index: 0">
                    <iconify-icon icon="ic:baseline-search" class="icon"></iconify-icon>
                </button>
            </div>

            <!-- Buttons -->
            <div class="d-flex flex-wrap justify-content-start gap-3">
                @if (auth()->user()->type === 'facility manager')
                    <button type="button" class="btn btn-danger text-sm btn-sm px-12 py-12 radius-8 px-20 py-11"
                        id="deleteFacilityBtn">Delete Facility</button>
                    <button type="button" class="btn btn-warning text-sm btn-sm px-12 py-12 radius-8 px-20 py-11"
                        id="updateFacilityBtn">Edit Facility</button>
                    <a href="/add-equipment/{{ $facility->id }}">
                        <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 px-20 py-11"
                            id="addEquipmentBtn">Add Equipment</button>
                    </a>
                @endif
            </div>
        </div>



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
                                        @if (auth()->user()->type === 'student' || auth()->user()->type === 'faculty' )
                                            <a href="/reserve-equipment/{{ $facEquipment->code }}"
                                                class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                                Reserve Equipment <iconify-icon icon="iconamoon:arrow-right-2"
                                                    class="text-xl"></iconify-icon>
                                            </a>
                                        @else
                                            <a href="/equipment-details/{{ $facEquipment->code }}"
                                                class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                                View Equipment <iconify-icon icon="iconamoon:arrow-right-2"
                                                    class="text-xl"></iconify-icon>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="d-flex justify-content-center align-items-center" style="height: 55vh; width: 100vw;">
                    <strong class="text-center p-3" style="font-size: 20px">There are no equipments yet in this
                        facility.</strong>
                </div>

            @endif
        </div>

    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')

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

                    <!-- Facility Name -->
                    <div class="mb-3">
                        <label for="facilityName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="facilityName" name="name"
                            value="{{ $facility->name }}" required>
                    </div>

                    <!-- Facility Description -->
                    <div class="mb-3">
                        <label for="facilityDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="facilityDescription" name="description" required>{{ $facility->description }}</textarea>

                    </div>

                    <!-- Facility Type -->
                    <div class="mb-3">
                        <label for="facilityType" class="form-label">Type</label>
                        <select class="form-control" id="facilityType" name="type" required>
                            <option value="laboratory" {{ $facility->type == 'laboratory' ? 'selected' : '' }}>
                                Laboratory</option>
                            <option value="office" {{ $facility->type == 'office' ? 'selected' : '' }}>Office</option>
                            <option value="room" {{ $facility->type == 'room' ? 'selected' : '' }}>Room</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
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
            // Check if the facility has any equipment
            fetch("{{ route('facility.checkEquipment', ['id' => $facility->id]) }}")
                .then(response => response.json())
                .then(data => {
                    if (data.hasEquipment) {
                        // Display warning if there is equipment in the facility
                        Swal.fire({
                            title: 'Cannot delete facility',
                            text: 'Please transfer the equipments to another facility before deleting this facility.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Proceed with deletion confirmation if no equipment is found
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This action cannot be undone!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Submit delete form if confirmed
                                document.getElementById('deleteFacilityForm').submit();
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Unable to check the equipment status. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
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
