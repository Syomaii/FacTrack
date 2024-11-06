@include('templates.header')
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
                <a href="{{ route('view-department') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    Students
                </a>
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
        <button type="button" class="btn btn-primary text-base radius-8 px-20 py-11 mb-3" onclick="printInvoice()">
            <a href="/students">Import Excel File</a>
        </button>
        <!-- Students List Grouped by Department -->
        <div class="row gy-4" id="studentList">
            @if ($students->isNotEmpty())
                @foreach ($students as $department => $group)
                    <div class="col-12 department-item">
                        <div class="card h-100 radius-12 text-center">
                            <div class="card-body p-24">
                                <!-- Department Name -->
                                <h5 class="mb-16">{{ $department }}</h5>

                                <!-- Students in Department -->
                                @foreach ($group as $student)
                                    <p>{{ $student->name }}</p>
                                @endforeach

                                <a href="{{ route('view-department-students', $department) }}"
                                    class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                    View Department Students <iconify-icon icon="iconamoon:arrow-right-2"
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

    @include('templates.footer_inc')
</main>
@include('templates.footer')
