@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Facilities</h6>

            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <a href="{{ route('facilities') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    Facilities
                </a>
            </ul>
        </div>

        @if (session('addFacilitySuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('addFacilitySuccessfully') }}
                </div>
            </div>
        @elseif (session('deleteFacilitySuccess'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('deleteFacilitySuccess') }}
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

        <!-- Search Bar -->

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-24">
            <!-- Search Bar -->
            <div class="input-group flex-grow-1 flex-sm-grow-0 mb-3 mb-sm-0" style="max-width: 650px;">
                <input type="text" id="facilitySearch" class="form-control" placeholder="Search Facilities" aria-label="Search Facilities">
                <button class="btn btn-primary" type="button" style="z-index: 0">
                    <iconify-icon icon="ic:baseline-search" class="icon"></iconify-icon>
                </button>
            </div>
        
            <!-- Add Facility Button -->
            @if (auth()->user()->type === 'facility manager')
                <div class="d-flex flex-wrap justify-content-start gap-2" style="width: 100%; max-width: 170px;">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#addFacilityModal" class="w-100">
                        <button type="button" class="btn btn-primary text-sm btn-sm w-100 radius-8 px-12 py-12 radius-8 px-20 py-11">Add Facility</button>
                    </a>
                </div>
            @endif
        </div>
        




        <!-- Add Facility Modal -->
        <div class="modal fade" id="addFacilityModal" tabindex="-1" aria-labelledby="addFacilityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('addFacility') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFacilityModalLabel">Add New Facility</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="facilityName" class="form-label">Facility Name</label>
                                <input type="text" class="form-control" id="facilityName" name="name"
                                    value ="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="facilityDescription" class="form-label">Facility Description</label>
                                <textarea class="form-control" id="facilityDescription" name="description" rows="3" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="facilityType" class="form-label">Facility Type</label>
                                <select class="form-control" id="facilityType" name="type" required>
                                    <option value="" disabled selected>Select Facility Type</option>
                                    <option value="laboratory">Laboratory</option>
                                    <option value="office">Office</option>
                                    <option value="room">Room</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Facility</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Facility List -->
        <div class="row gy-4" id="facilityList">
            @if ($facilities->isNotEmpty())
                @foreach ($facilities as $facility)
                    <div class="col-xxl-3 col-sm-6 facility-item">
                        <div class="card h-100 radius-12 text-center">
                            <div class="card-body p-24">
                                <div
                                    class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-info-200 text-primary-600 mb-16 radius-12">
                                    <iconify-icon icon="{{ $facility->getIconClass() }}" class="h5 mb-0"></iconify-icon>
                                </div>
                                <h6 class="mb-8">{{ ucwords($facility->name) }}</h6>
                                <a href="/facility-equipment/{{ ucwords($facility->id) }}"
                                    class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                    @if ($facility->type == 'laboratory')
                                        View Laboratory
                                    @elseif ($facility->type == 'office')
                                        View Office
                                    @elseif ($facility->type == 'room')
                                        View Room
                                    @endif <iconify-icon icon="iconamoon:arrow-right-2"
                                        class="text-xl"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="d-flex justify-content-center align-items-center" style="height: 55vh; width: 100vw;">
                    <strong class="text-center p-3" style="font-size: 20px">There are no facilities yet.</strong>
                </div>
            @endif
        </div>

    </div>

    <script>
        // Search Filter
        document.getElementById('facilitySearch').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let facilities = document.querySelectorAll('.facility-item');

            facilities.forEach(function(facility) {
                let facilityName = facility.querySelector('h6').textContent.toLowerCase();
                if (facilityName.includes(filter)) {
                    facility.style.display = '';
                } else {
                    facility.style.display = 'none';
                }
            });
        });
    </script>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
