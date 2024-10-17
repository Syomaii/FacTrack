@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Offices</h6>

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
            </ul>

        </div>

        @if (session('addOfficeSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('addOfficeSuccessfully') }}
                </div>
            </div>
        @elseif (session('deleteOfficeSuccess'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('deleteOfficeSuccess') }}
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

        <!-- Search Bar -->
        <div class="input-group mb-3">
            <input type="text" id="officeSearch" class="form-control" placeholder="Search Offices"
                aria-label="Search Offices">
            <button class="btn btn-primary" type="button"><iconify-icon icon="ic:baseline-search"
                    class="icon"></iconify-icon></button>
        </div>

        <a href="#"
            class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2 mb-3"
            style="width: 170px" data-bs-toggle="modal" data-bs-target="#addOfficeModal">
            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
            Add New Office
        </a>

        <!-- Add Office Modal -->
        <div class="modal fade" id="addOfficeModal" tabindex="-1" aria-labelledby="addOfficeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('addOffice') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addOfficeModalLabel">Add New Office</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="officeName" class="form-label">Office Name</label>
                                <input type="text" class="form-control" id="officeName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="officeDescription" class="form-label">Office Description</label>
                                <textarea class="form-control" id="officeDescription" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="officeType" class="form-label">Type</label>
                                <select class="form-control" id="officeType" name="type" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="office">Office</option>
                                    <option value="department">Department</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Office</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Office List -->
        <div class="row gy-4" id="officeList">
            @foreach ($offices as $office)
                <div class="col-xxl-3 col-sm-6 office-item">
                    <div class="card h-100 radius-12 text-center">
                        <div class="card-body p-24">
                            <div
                                class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-info-200 text-primary-600 mb-16 radius-12">
                                <iconify-icon icon="{{ $office->getIconClass() }}" class="h5 mb-0"></iconify-icon>
                            </div>
                            <h6 class="mb-8">{{ $office->name }}</h6>
                            <a href="/office/{{ $office->id }}"
                                class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                View Office <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <script>
        // Search Filter
        document.getElementById('officeSearch').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let offices = document.querySelectorAll('.office-item');

            offices.forEach(function(office) {
                let officeName = office.querySelector('h6').textContent.toLowerCase();
                if (officeName.includes(filter)) {
                    office.style.display = '';
                } else {
                    office.style.display = 'none';
                }
            });
        });
    </script>

    @include('templates.footer_inc')

</main>
@include('templates.footer')
