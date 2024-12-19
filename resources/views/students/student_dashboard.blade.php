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
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-24">
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

        <div class="d-flex w-100 row gy-4 w-100">
            <div class="col-lg-8">
                <div class="d-flex justify-content-start align-items-center radius-10 bg-white" style="height: 20vh; padding: 1rem; position: relative;">
                    <div style="margin-left: 2rem; flex-grow: 1;">
                        <h5 style="margin-top: 1rem; font-size: 1.2rem;">Hi! {{ $student->firstname }} {{ $student->lastname }}</h5>
                        <p style="font-size: 0.9rem; color: #666;">{{ now()->format('F d, Y') }}</p>
                        <p style="color: #999; font-size: 0.85rem;">Welcome to FacTrack</p>
                    </div>
                    <div style="width: 50px; height: 50px; background-color: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <iconify-icon icon="akar-icons:person" class="icon text-xl"></iconify-icon>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100 p-2">
                    <div class="calendar">
                        <!-- Header with Month and Year -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2">&lt;</button>
                            <h6 class="fw-semibold text-center mb-0" style="font-size: 0.9rem;">{{ date('F Y') }}</h6>
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2">&gt;</button>
                        </div>

                        <!-- Days of the Week -->
                        <div class="d-flex justify-content-between text-center text-secondary fw-semibold mb-1" style="font-size: 0.70rem;">
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                            <div>Sun</div>
                        </div>

                        <!-- Calendar Days -->
                        <div class="d-flex flex-wrap">
                            <?php
                                $currentYear = date('Y');
                                $currentMonth = date('m');
                                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                                $firstDayOfMonth = date('N', strtotime("$currentYear-$currentMonth-01")); // 1 (Monday) to 7 (Sunday)
                                
                                // Empty cells before the first day of the month
                                for ($i = 1; $i < $firstDayOfMonth; $i++) {
                                    echo '<div style="width: 14.28%; height: 30px;"></div>';
                                }

                                // Days of the month
                                for ($day = 1; $day <= $daysInMonth; $day++) {
                                    echo '<div style="width: 14.28%; height: 30px; text-align: center; line-height: 30px; font-size: 0.8rem;">' . $day . '</div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <p>My Schedule</p>
        </div>

        <div class="d-flex w-100 row gy-4 w-100">
            <div class="col-lg-8">
                <div class="d-flex justify-content-start align-items-center radius-10 bg-white" style="height: 20vh; padding: 1rem; position: relative;">
                    <div style="margin-left: 2rem; flex-grow: 1;">
                        <h6 style="margin-top: 1rem; font-size: 1.2rem;">Projector</h6>

                    </div>
                </div>
            </div>

        </div>
    </div>
    
    
    @include('templates.footer_inc')
</main>
@include('templates.footer')
