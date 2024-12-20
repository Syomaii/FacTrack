@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    @if (session('newUser'))
        <div class="alert alert-warning d-flex align-items-center justify-content-between">
            <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
            {{ session('newUser') }}
        </div>
    @elseif (session('loginUserSuccessfully'))
        <div class="alert alert-success d-flex align-items-center justify-content-between">
            <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
            {{ session('loginUserSuccessfully') }}
        </div>
    @endif

    <div class="dashboard-main-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 text-muted">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
            </ul>
        </div>

        <div class="row gy-4">
            <div class="col-lg-14">
                <div class="card shadow-sm p-3 rounded" style="background-color: #ffff;">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-black">{{ now()->format('F d, Y') }}</p>
                            <h3 class="mb-1 text-black">Welcome, {{ $student->firstname }} !</h3>
                            <!-- Random Message Display -->
                            @php
                                $messages = [
                                    "What are you up to today?",
                                    "What's on your schedule today?",
                                    "How's your day looking?",
                                    "You're doing great! Keep up the good work!",
                                    "Anything exciting planned for today?"
                                ];
                                $randomMessage = $messages[array_rand($messages)];   
                            @endphp
                            <h5 style="color: black;">{{ $randomMessage }}</h5>
                        </div>
                        <div class="profile-icon d-flex align-items-center justify-content-center" style="position: relative; left: -50px; width: 500px; height: 250px; border-radius: 8px; background-color: #ffff;">
                             <img src="{{ asset('images/student.png') }}" alt="Profile Image" class="icon text-l rectangle" style="width: 100%; height: 100%; object-fit: cover;">
                        </div> 
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-8">
                    <!-- My Schedule Card -->
                    <div class="mb-4 mt-n5">
                        
                        <div class="card shadow-sm p-3 rounded w-100">
                            <h6>Reservations</h6>
                            <p>Here are your reservations for today!</p>

                            <div class="d-flex w-50">
                                <div class="card shadow-sm p-3 rounded w-100">
                                    @foreach ($studentReservations as $reservations)
                                        @if ($reservations->reservation_date === now()->format('Y-m-d'))
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="fw-semibold mb-0">{{ $reservations->equipment->name }}</h6>
                                                <p class="fw-semibold mb-0">{{ $reservations->purpose }}</p>
                                                <a href="{{ route('reservation_details', ['id' => $reservations->id]) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            </div>
                                            
                                        @endif
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm p-3 rounded">
                    <div class="calendar">
                        <!-- Header with Month and Year -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button id="prev-month" class="btn btn-sm btn-outline-secondary py-0 px-2">&lt;</button>
                            <h6 id="calendar-month" class="fw-semibold mb-0">{{ date('F Y') }}</h6>
                            <button id="next-month" class="btn btn-sm btn-outline-secondary py-0 px-2">&gt;</button>
                        </div>

                        <!-- Days of the Week -->
                        <div class="d-flex justify-content-between text-center text-muted fw-semibold mb-1" style="font-size: 0.85rem;">
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                            <div>Sun</div>
                        </div>

                        <!-- Calendar Days -->
                        <div id="calendar-days" class="d-flex flex-wrap"></div>
                    </div>
                </div>

               <!-- Pending Approval Card -->
                <div class="card shadow-sm p-3 mt-4 rounded">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-semibold mb-0">Pending Facility Reservation</h6>
                    </div>
                    <div class="mt-2">
                        <!-- Dynamically list pending approvals -->
                        @if ($studentReservations->isEmpty())
                            <p class="text-muted">You have no pending requests for approval.</p>
                        @else
                            <ul class="list-unstyled">
                                @foreach ($studentReservations as $reservation)
                                    @if ($reservation->status === 'pending')
                                        <div class="card d-flex justify-content-between mb-2 p-3">
                                            <span><strong>{{ $reservation->facility->name }}</strong></span>
                                            <span>{{ $reservation->purpose }}</span>
                                            <a href="{{ route('reservation_details', ['id' => $reservation->id]) }}">
                                                <button class="btn btn-sm btn-warning d-flex justify-content-end">View</button>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        
    @include('templates.footer_inc')
</main>
@include('templates.footer')

<!-- Add this CSS to your existing stylesheet -->
<style>
/* Calendar days style */
.calendar-day {
    width: 14.28%; /* Ensures 7 days per row */
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    text-align: center;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.calendar-day:hover {
    background-color: #f1f1f1; /* Light background when hovering */
    cursor: pointer;
}

/* Highlight today's date with a square or rectangular background */
.calendar-day.today {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    border-radius: 4px; /* Square corners */
    padding: 5px;
}

/* Additional styles to make the layout clean */
.profile-icon {
    width: 50px;
    height: 50px;
    background-color: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.card {
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.card h6 {
    font-size: 1.1rem;
    color: #333;
}

.text-muted {
    color: #666;
}

.text-secondary {
    color: #999;
}

.list-unstyled {
    padding-left: 0;
}

.list-unstyled li {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.list-unstyled button {
    font-size: 0.8rem;
    padding: 5px 10px;
}
</style>

<!-- Add this JavaScript to make the calendar interactive -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentYear = new Date().getFullYear();
        let currentMonth = new Date().getMonth(); // 0 = January, 11 = December
        let today = new Date();
        let todayDay = today.getDate();

        function renderCalendar(year, month) {
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const firstDayOfMonth = new Date(year, month, 1).getDay(); // 0 (Sunday) to 6 (Saturday)
            const daysInMonth = new Date(year, month + 1, 0).getDate(); // Last day of the month

            // Update the month-year label
            document.getElementById('calendar-month').textContent = `${monthNames[month]} ${year}`;

            // Clear previous days
            const calendarDays = document.getElementById('calendar-days');
            calendarDays.innerHTML = '';

            // Add empty cells before the first day of the month
            for (let i = 0; i < firstDayOfMonth; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('calendar-day');
                calendarDays.appendChild(emptyCell);
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('div');
                dayCell.classList.add('calendar-day');
                if (day === todayDay && month === today.getMonth() && year === today.getFullYear()) {
                    dayCell.classList.add('today');
                }
                dayCell.textContent = day;
                calendarDays.appendChild(dayCell);
            }
        }

        // Next and Previous buttons
        document.getElementById('next-month').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentYear, currentMonth);
        });

        document.getElementById('prev-month').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentYear, currentMonth);
        });

        renderCalendar(currentYear, currentMonth);
    });
</script>
