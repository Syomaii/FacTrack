@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div>
                <h6 class="fw-semibold mb-0">{{ $office->name }}</h6>
                <h8 class="fw-medium">{{ $office->description }}</h8>
            </div>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">{{ $office->name }}</li>
            </ul>
        </div>

        @if (session('updateOfficeSuccess'))
            <div class="alert alert-success">
                {{ session('updateOfficeSuccess') }}
            </div>
        @elseif (session('addfacilitiesuccessfully'))
            <div class="alert alert-success">
                {{ session('addfacilitiesuccessfully') }}
            </div>
        @endif

        <!-- Search Bar and Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-24">
            <div class="input-group" style="max-width: 350px;">
                <input type="text" id="facilitiesearch" class="form-control radius-8 border-0 shadow-sm"
                    placeholder="Search equipment...">
                <button class="btn btn-outline-success-600 radius-8 px-3 py-2">
                    <iconify-icon icon="ic:baseline-search" class="icon text-xl"></iconify-icon>
                </button>
            </div>

            <div class="d-flex gap-3">
                <button type="button" class="btn rounded-pill btn-outline-warning-600 radius-8 px-20 py-11"
                    id="updateOfficeBtn">Edit Office</button>
                <button type="button" class="btn rounded-pill btn-outline-danger-600 radius-8 px-20 py-11"
                    id="deleteOfficeBtn">Delete Office</button>
                {{-- <a href="/add-equipment/{{ $office->id }}">
                    <button type="button" class="btn rounded-pill btn-outline-success-600 radius-8 px-20 py-11"
                        id="addFacilityBtn">Add Office</button>
                </a> --}}
            </div>
        </div>

        <!-- No equipment message -->
        <div class="row gy-4" id="equipmentList">
            @if ($facilities->isNotEmpty())
                @foreach ($facilities as $facility)
                    <div class="col-xxl-3 col-sm-6 equipment-card">
                        <div class="card h-100 radius-12 text-center">
                            <div class="card-body p-24">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{ asset($facility->image) }}" alt="{{ $facility->name }}"
                                        class="img-fluid rounded mb-3 max-img-size" />
                                    <h6 class="mb-8">{{ $facility->name }}</h6>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="javascript:void(0)"
                                            class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center view-equipment"
                                            data-id="{{ $facility->id }}">
                                            <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center edit-equipment"
                                            data-id="{{ $facility->id }}" data-name="{{ $facility->name }}"
                                            data-description="{{ $facility->description }}"
                                            data-acquired_date="{{ $facility->acquired_date }}"
                                            data-status="{{ $facility->status }}"
                                            data-Office="{{ $facility->Office }}">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center delete-equipment"
                                            data-id="{{ $facility->id }}">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
                                        <form id="delete-form-{{ $facility->id }}"
                                            action="{{ route('delete_equipment', $facility->id) }}" method="POST"
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
                    <strong class="text-center p-3">There are no facilities yet in this Office.</strong>
                </div>
            
            @endif
        </div>

    </div>

    @include('templates.footer')
</main>

<!-- Edit Office Modal -->
<div class="modal fade" id="editOfficeModal" tabindex="-1" aria-labelledby="editOfficeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOfficeModalLabel">Edit Office</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOfficeForm" action="{{ route('updateOffice', $Office->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $Office->id }}">
                    <div class="mb-3">
                        <label for="OfficeName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="OfficeName" name="name"
                            value="{{ $Office->name }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="OfficeDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="OfficeDescription" name="description" required>{{ $Office->description }}</textarea>
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

<!-- Delete Office Form -->
<form id="deleteOfficeForm" action="{{ route('deleteOffice', $Office->id) }}" method="POST"
    style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var equipmentList = document.getElementById('equipmentList');
        var searchInput = document.getElementById('facilitiesearch');

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

        // Update and Delete Office Handlers
        document.getElementById('updateOfficeBtn').addEventListener('click', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editOfficeModal'));
            editModal.show();
        });

        document.getElementById('deleteOfficeBtn').addEventListener('click', function() {
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
                    document.getElementById('deleteOfficeForm').submit();
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
