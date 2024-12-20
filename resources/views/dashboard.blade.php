@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    @if (session('newUser'))
        <div
            class="alert alert-warning bg-warning-100 text-warning-600 border-warning-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                {{ session('newUser') }}
            </div>
        </div>
    @elseif (session('loginUserSuccessfully'))
        <div
            class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                {{ session('loginUserSuccessfully') }}
            </div>
        </div>
    @endif

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
            </ul>
        </div>

        <div class="row row-cols-xxxl-4 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4">
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Users</p>
                                <h6 class="mb-0">{{ $userCount }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="gridicons:multiple-users"
                                    class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Equipments</p>
                                <h6 class="mb-0">{{ $equipmentCount }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mingcute:computer-line"
                                    class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-3 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Borrowed Equipments</p>
                                <h6 class="mb-0">{{ $totalBorrowedEquipments }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:document-text-outline"
                                    class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total In Repair Equipments</p>
                                <h6 class="mb-0">{{ $totalInRepairEquipments }}</h6>
                            </div>
                            <div
                                class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mingcute:tool-line" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mt-1 mb-3">
            <div class="col-xxl-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                        <h6 class="text-lg fw-semibold mb-0">Borrowed Equipments Per Month</h6>
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <select id="yearFilter" class="form-select" onchange="updateChart()">
                                <option value="">Select Year</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="card-body p-24">
                        <div id="borrowedEquipmentPerMonth" class=""></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-9 col-xl-12">
                <div class="card h-100 p-0 radius-12">
                    <div
                        class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <span class="text-md fw-medium text-secondary-light mb-0">Show</span>

                            <form class="navbar-search d-flex align-items-center flex-grow-1" method="GET"
                                action="{{ route('dashboard-search-user') }}">
                                <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search"
                                    value="{{ request('search') }}">
                                <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table sm-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="user-row">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <span
                                                            class="text-md mb-0 fw-normal text-secondary-light user-name">{{ $user->firstname }}
                                                            {{ $user->lastname }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span
                                                    class="text-md mb-0 fw-normal text-secondary-light user-email">{{ $user->email }}</span>
                                            </td>
                                            <td class="user-designation">
                                                {{ $user->designation ? $user->designation->name : 'N/A' }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Active</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="user-row">
                                            <td colspan="10" class="text-center"><strong>No users found from your
                                                    office/department.</strong></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($userCount > 0)
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                                <span>Showing {{ $start }} to {{ $end }} of {{ $userCount }}
                                    entries</span>
                                <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                                    <!-- Previous Page Link -->
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                                            href="{{ $users->previousPageUrl() }}"
                                            aria-disabled="{{ $users->onFirstPage() }}">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </a>
                                    </li>

                                    <!-- Pagination Pages -->
                                    @if ($users->lastPage() > 1)
                                        <!-- Show first page if not too close to current -->
                                        @if ($users->currentPage() > 3)
                                            <li class="page-item">
                                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                                    href="{{ $users->url(1) }}">1</a>
                                            </li>
                                            @if ($users->currentPage() > 4)
                                                <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                            @endif
                                        @endif

                                        @for ($i = max(1, $users->currentPage() - 1); $i <= min($users->lastPage(), $users->currentPage() + 1); $i++)
                                            <li class="page-item">
                                                <a class="page-link {{ $i === $users->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-300 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                                    href="{{ $users->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        @if ($users->currentPage() < $users->lastPage() - 2)
                                            @if ($users->currentPage() < $users->lastPage() - 3)
                                                <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                                    href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a>
                                            </li>
                                        @endif
                                    @else
                                    @endif

                                    <!-- Next Page Link -->
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                                            href="{{ $users->nextPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>


            <!-- Recent Users Section -->
            <div class="col-xxl-3 col-xl-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg mb-0">Recent Logged-in Users</h6>
                        </div>

                        <div class="mt-32">
                            @foreach ($recentLoggedIn as $lastLoggedIn)
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            @if (!is_null($lastLoggedIn->last_login_at))
                                                <h6 class="text-md mb-0 fw-medium">
                                                    {{ ucwords($lastLoggedIn->firstname) }}
                                                    {{ ucwords($lastLoggedIn->lastname) }}</h6>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-sm text-secondary-light fw-medium">
                                        @if (!is_null($lastLoggedIn->last_login_at))
                                            {{ $lastLoggedIn->last_login_at->diffForHumans() }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const borrowedPerMonthData = @json($borrowedPerMonth);
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Initialize data structure for all months
        const dataMap = Array.from({ length: 12 }, (_, index) => ({
            x: months[index],
            y: 0 // Default to 0 if no data is provided for the month
        }));

        // Populate the chart with initial data for the first year (or all data)
        let currentYear = new Date().getFullYear(); // Default to current year
        updateChart(currentYear);

        // Function to update chart with filtered data for the selected year
        function updateChart(year = currentYear) {
            // Filter data for the selected year
            const filteredData = borrowedPerMonthData.filter(data => data.year === year);

            // Reset dataMap to 0s for each month
            const newDataMap = Array.from({ length: 12 }, (_, index) => ({
                x: months[index],
                y: 0
            }));

            // Fill in the data for the selected year
            filteredData.forEach(data => {
                const monthIndex = data.month - 1; // `data.month` is 1-based, array is 0-based
                if (monthIndex >= 0 && monthIndex < 12) {
                    newDataMap[monthIndex].y = data.total;
                }
            });

            // Update the chart series with the filtered data
            const maxYValue = Math.max(...newDataMap.map(d => d.y), 10); // Ensure minimum Y max is 10
            const yAxisMax = Math.ceil(maxYValue / 10) * 10;

            const options = {
                series: [{
                    name: "Borrowed Equipments",
                    data: newDataMap
                }],
                chart: {
                    type: 'bar',
                    height: 264,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 8,
                        columnWidth: '23%',
                        endingShape: 'rounded',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'gradient',
                    colors: ['#487FFF'],
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.5,
                        gradientToColors: ['#487FFF'],
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100],
                    }
                },
                grid: {
                    show: true,
                    borderColor: '#D1D5DB',
                    strokeDashArray: 4,
                    position: 'back',
                },
                xaxis: {
                    type: 'category',
                    categories: months, 
                },
                yaxis: {
                    min: 0,
                    max: yAxisMax,
                    tickAmount: yAxisMax / 4,
                    labels: {
                        formatter: function(value) {
                            return value.toFixed(0);
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' borrows';
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#borrowedEquipmentPerMonth"), options);
            chart.render();
        }

        // Handle year filter change
        document.getElementById('yearFilter').addEventListener('change', function() {
            const selectedYear = this.value;
            if (selectedYear) {
                currentYear = selectedYear;
                updateChart(currentYear); // Update chart with data for the selected year
            }
        });
    });

</script>
