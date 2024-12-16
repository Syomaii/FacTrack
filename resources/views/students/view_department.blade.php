@include('templates.header')

<style>
    /* Responsive input group and buttons */
    @media (max-width: 768px) {
        .input-group {
            width: 100%;
            /* Make input group full width */
        }

        .btn {
            width: 100%;
            /* Make buttons full width */
        }
    }

    /* Dropdown container positioning */
    .dropdown {
        position: relative;
        /* Ensures proper positioning of the dropdown menu */
    }

    /* Dropdown menu styling */
    .dropdown-menu {
        z-index: 1050;
        /* Ensures dropdown appears above all other elements */
        position: absolute;
        /* Prevents the dropdown from affecting layout */
        top: 100%;
        /* Aligns dropdown below its parent */
        left: 0;
        /* Aligns dropdown to the left of the parent container */
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        /* Optional: adds a slight shadow */
        border-radius: 8px;
        /* Optional: rounded corners */
        overflow: hidden;
        /* Prevents content overflow */
    }

    /* Dropdown link styling */
    .dropdown-menu a {
        padding: 10px 20px;
        /* Add spacing for links */
        display: block;
        /* Ensures links span the full dropdown width */
        color: #333;
        /* Text color */
        text-decoration: none;
        /* Removes underline */
    }

    /* Hover effect for dropdown links */
    .dropdown-menu a:hover {
        background-color: #f1f1f1;
        /* Light gray background on hover */
        color: #007bff;
        /* Highlight text color */
    }

    /* Scrollable content styling */
    .scrollable-content {
        overflow-y: auto;
        overflow-x: hidden;
        max-height: 700px;
        /* Prevents content from overflowing the page */
    }
</style>

<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Students Department</h6>
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
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-24" style="z-index:0">
            <!-- Search Bar -->
            <div class="input-group flex-grow-1 flex-sm-grow-0 mb-3 mb-sm-0" style="max-width: 650px; z-index=0">
                <input type="text" id="departmentSearch" class="form-control" placeholder="Search Department" aria-label="Search Department">
                <button class="btn btn-primary" type="button" style="z-index:0">
                    <iconify-icon icon="ic:baseline-search" class="icon" style="z-index=0"></iconify-icon>
                </button>
            </div>

            <div class="d-flex flex-wrap justify-content-end gap-2">
                @if (Auth::user()->type != 'operator')
                <a href="/students" class="btn btn-primary text-base radius-8 px-20 py-11 w-sm-auto">
                    Import Excel File
                </a>
                @endif
                <a href="{{ route('add-student') }}" class="btn btn-primary text-base radius-8 px-20 py-11 w-sm-auto">
                    Add New Student
                </a>
            </div>
        </div>
        
        <!-- Department Group By-->
        <div class="scrollable-content" style="overflow-y: auto; overflow-x: hidden; max-height: 700px;">
            <div class="row gy-4" id="studentList">
                @if ($students->isNotEmpty())
                    @foreach ($students as $department => $group)
                        <div class="col-12 department-item">
                            <div class="card h-100 radius-12 text-center" style="max-width: 100%; margin: 0 auto;">
                                <div class="card-body p-24">
                                    <!-- Department Name -->
                                    <h5 class="mb-16">{{ ucwords($department) }}</h5>

                                    <!-- Students in Department -->
                                    @foreach ($group as $student)
                                        <p>{{ $student->name }}</p>
                                    @endforeach

                                    <a href="{{ route('view-department-students', $department) }}"
                                        class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                        View students in this department <iconify-icon icon="iconamoon:arrow-right-2"
                                            class="text-xl"></iconify-icon>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex justify-content-center align-items-center" style="height: 55vh; width: 100vw;">
                        <strong class="text-center p-3" style="font-size: 20px">There are no students yet.</strong>
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
