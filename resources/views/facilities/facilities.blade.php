@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Facilities</h6>

            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Facilities</li>
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
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <a href="#"
            class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2 mb-3"
            style="width: 170px" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
            Add New Facility
        </a>

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
                                <input type="text" class="form-control" id="facilityName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="facilityDescription" class="form-label">Facility Description</label>
                                <textarea class="form-control" id="facilityDescription" name="description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Facility</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row gy-4" id="facilityList">
            @foreach ($facilities as $facility)
                <div class="col-xxl-3 col-sm-6">
                    <div class="card h-100 radius-12 text-center">
                        <div class="card-body p-24">
                            <div
                                class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-info-200 text-primary-600 mb-16 radius-12">
                                <iconify-icon icon="{{ $facility->getIconClass() }}" class="h5 mb-0"></iconify-icon>
                            </div>
                            <h6 class="mb-8">{{ $facility->name }}</h6>
                            <a href="/facility-equipment/{{ $facility->id }}"
                                class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                View Facility <iconify-icon icon="iconamoon:arrow-right-2"
                                    class="text-xl"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <script>
        document.getElementById('addFacilityForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let facilityName = document.getElementById('facilityName').value;
            let facilityDescription = document.getElementById('facilityDescription').value;

            document.querySelector('#facilityList').insertAdjacentHTML('beforeend', facilityCard);

            document.querySelector('#addFacilityModal form').reset();
        });
    </script>

    @include('templates.footer_inc')
</main>
@include('templates.footer')