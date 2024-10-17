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
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <a href="{{ route('offices') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    Offices
                </a>
                <li>-</li>
                <a href="{{ route('officeFacilities', ['id' => $office->id]) }}"
                    class="d-flex align-items-center gap-1 hover-text-primary">
                    {{ $office->name }}
                </a>
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
            <div class="input-group" style="max-width: 650px;">
                <input type="text" id="equipmentSearch" class="form-control radius-8 border-0 shadow-sm"
                    placeholder="Search facilities...">
                <button class="btn btn-primary" type="button"><iconify-icon icon="ic:baseline-search"
                        class="icon"></iconify-icon></button>
            </div>

            <div class="d-flex gap-3">
                <button type="button" class="btn btn-warning text-sm btn-sm px-12 py-12 radius-8 px-20 py-11"
                    id="updateOfficeBtn">Edit Office</button>
                <button type="button" class="btn btn-danger text-sm btn-sm px-12 py-12 radius-8 px-20 py-11"
                    id="deleteOfficeBtn">Delete Office</button>
            </div>
        </div>

        <!-- No facilities message -->
        <div class="row gy-4" id="equipmentList">
            @if ($facilities->isNotEmpty())
                @foreach ($facilities as $facility)
                    <div class="col-xxl-3 col-sm-6 equipment-card">
                        <div class="card h-100 radius-12 text-center">
                            <div class="card-body p-24">
                                <div class="d-flex flex-column align-items-center">
                                    <div
                                        class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-info-200 text-primary-600 mb-16 radius-12">
                                        <iconify-icon icon="{{ $office->getIconClass() }}"
                                            class="h5 mb-0"></iconify-icon>
                                    </div>
                                    <h6 class="mb-8">{{ $facility->name }}</h6>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('facility_equipment', ['id' => $facility->id]) }}"
                                            class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                            View Facility <iconify-icon icon="iconamoon:arrow-right-2"
                                                class="text-xl"></iconify-icon>
                                        </a>
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
<div class="modal fade" id="editOfficeModal" tabindex="-1" aria-labelledby="editOfficeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOfficeModalLabel">Edit Office</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOfficeForm" action="{{ route('updateOffice', $office->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $office->id }}">
                    <div class="mb-3">
                        <label for="OfficeName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="OfficeName" name="name"
                            value="{{ $office->name }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="OfficeDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="OfficeDescription" name="description" required>{{ $office->description }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="OfficeType" class="form-label">Type</label>
                        <select class="form-control" id="OfficeType" name="type" required>
                            <option value="office" {{ $office->type == 'office' ? 'selected' : '' }}>Office</option>
                            <option value="department" {{ $office->type == 'department' ? 'selected' : '' }}>Department
                            </option>
                        </select>
                        @error('type')
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
<form id="deleteOfficeForm" action="{{ route('deleteOffice', $office->id) }}" method="POST"
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

        // Update Office Handler
        document.getElementById('updateOfficeBtn').addEventListener('click', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editOfficeModal'));
            editModal.show();
        });

        // Delete Office Handler
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

    });
</script>

@include('templates.footer')
