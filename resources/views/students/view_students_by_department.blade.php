@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Students in {{ $department }}</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('view-students') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Departments
                    </a>
                </li>
                <li class="fw-medium">-</li>
                <li class="fw-medium">{{ ucwords($department) }}</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div
                class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <div class="d-flex flex-grow-1 flex-wrap align-items-center gap-3">
                    <!-- Search Input -->
                    <form class="navbar-search d-flex align-items-center flex-grow-1" method="GET"
                        action="{{ route('search-student') }}">
                        <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search"
                            value="{{ request('search') }}">
                        <input type="hidden" name="department" value="{{ $department }}">
                        <!-- Use the department variable passed from the controller -->
                        <button type="submit">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </button>
                    </form>

                    <!-- Year Filter -->
                    <form method="GET" action="{{ route('search-student') }}">
                        <select name="year" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Year</option>
                            <option value="1st Year" {{ request('year') === '1st Year' ? 'selected' : '' }}>1st Year
                            </option>
                            <option value="2nd Year" {{ request('year') === '2nd Year' ? 'selected' : '' }}>2nd Year
                            </option>
                            <option value="3rd Year" {{ request('year') === '3rd Year' ? 'selected' : '' }}>3rd Year
                            </option>
                            <option value="4th Year" {{ request('year') === '4th Year' ? 'selected' : '' }}>4th Year
                            </option>
                            <input type="hidden" name="department" value="{{ $department }}">
                            <!-- Set this value based on the current department -->
                        </select>
                    </form>

                    <!-- Sort by Name Filter -->
                    <form method="GET" action="{{ route('search-student') }}">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Sort by Name</option>
                            <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Descending
                            </option>
                            <input type="hidden" name="department" value="{{ $department }}">
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID No</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Email</th>
                                <th scope="col">Course</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr class="student-row">
                                    <td>
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $student->id }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                            {{ Str::title($student->firstname) }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                            {{ Str::title($student->lastname) }}</h6>
                                    </td>
                                    <td>
                                        <span
                                            class="text-md mb-0 fw-normal text-secondary-light">{{ $student->gender }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-md mb-0 fw-normal text-secondary-light">{{ $student->email }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-md mb-0 fw-normal text-secondary-light">{{ $student->course }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('student.show_profile', $student->id) }}"
                                            class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center view-equipment">
                                            <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No students found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($totalStudents > 0)
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                        <span>Showing {{ $start }} to {{ $end }} of {{ $totalStudents }}
                            entries</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                                    href="{{ $students->previousPageUrl() }}"
                                    aria-disabled="{{ $students->onFirstPage() }}">
                                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                </a>
                            </li>

                            <!-- Pagination Pages -->
                            @if ($students->lastPage() > 1)
                                <!-- Show first page if not too close to current -->
                                @if ($students->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $students->url(1) }}">1</a>
                                    </li>
                                    @if ($students->currentPage() > 4)
                                        <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                    @endif
                                @endif

                                @for ($i = max(1, $students->currentPage() - 1); $i <= min($students->lastPage(), $students->currentPage() + 1); $i++)
                                    <li class="page-item">
                                        <a class="page-link {{ $i === $students->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-300 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $students->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($students->currentPage() < $students->lastPage() - 2)
                                    @if ($students->currentPage() < $students->lastPage() - 3)
                                        <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $students->url($students->lastPage()) }}">{{ $students->lastPage() }}</a>
                                    </li>
                                @endif
                            @else
                            @endif

                            <!-- Next Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                                    href="{{ $students->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')
