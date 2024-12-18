@include('templates.header')



<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Faculty Department</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Departments</li>
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-24">
            <!-- Search Bar -->
            <div class="input-group flex-grow-1 flex-sm-grow-0 mb-3 mb-sm-0" style="max-width: 650px;">
                <input type="text" id="departmentSearch" class="form-control" placeholder="Search Department" aria-label="Search Department">
                <button class="btn btn-primary" type="button">
                    <iconify-icon icon="ic:baseline-search" class="icon"></iconify-icon>
                </button>
            </div>

            <div class="d-flex flex-wrap justify-content-start gap-3">
                @if (Auth::user()->type != 'operator')
                <a href="/faculties" >
                    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 px-20 py-11">Import Excel File</button>
                </a>
                @endif
                <a href="{{ route('add-faculty') }}" >
                    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 px-20 py-11">Add New Faculty</button>
                </a>
            </div>
        </div>
        
        <!-- Department Group By-->
        <div class="scrollable-content" style="overflow-y: auto; overflow-x: hidden; max-height: 700px;">
            <div class="row gy-4" id="facultyList">
                @if ($faculty->isNotEmpty())
                    @foreach ($faculty as $department => $group)
                        <div class="col-12 department-item">
                            <div class="card h-100 radius-12 text-center" style="max-width: 100%; margin: 0 auto;">
                                <div class="card-body p-24">
                                    <!-- Department Name -->
                                    <h5 class="mb-16">{{ ucwords($department) }}</h5>

                                    <!-- Students in Department -->
                                    @foreach ($group as $faculties)
                                        <p>{{ $faculties->name }}</p>
                                    @endforeach

                                    <a href="{{ route('view-department-faculties', $department) }}"
                                        class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                        View faculty members in this department <iconify-icon icon="iconamoon:arrow-right-2"
                                            class="text-xl"></iconify-icon>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex justify-content-center align-items-center" style="height: 55vh; width: 100vw;">
                        <strong class="text-center p-3" style="font-size: 20px">There are no faculty members yet.</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
<script>
    // Search Filter
    document.getElementById('departmentSearch').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let department = document.querySelectorAll('.department-item');

        department.forEach(function(department) {
            let departmentName = department.querySelector('h5').textContent.toLowerCase();
            if (departmentName.includes(filter)) {
                department.style.display = '';
            } else {
                department.style.display = 'none';
            }
        });
    });
</script>
@include('templates.footer')
