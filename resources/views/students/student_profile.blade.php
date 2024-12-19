@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Student Profile</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ url()->previous() }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        {{ $student->department }}
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">{{ $student->id }}</li>
            </ul>
        </div>
        @if (session('updateprofilesuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('updateprofilesuccessfully') }}
                </div>
            </div>
        @endif
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="{{ asset('assets/images/user-grid/uc.jpg') }}" alt=""
                        class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16 mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0 pt-5 mt-5">
                            <h6 class="mb-0 mt-16">{{ ucwords($student->firstname) }} {{ ucwords($student->lastname) }}
                            </h6>
                            <span class="text-secondary-light mb-16">{{ $student->email }}</span>
                        </div>
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ ucwords($student->firstname) }}
                                        {{ ucwords($student->lastname) }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">ID Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $student->id }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Course / Year</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $student->course }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Department</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $student->department }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24 active"
                                    id="pills-borrow-history-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-borrow-history" type="button" role="tab"
                                    aria-controls="pills-borrow-history" aria-selected="true">
                                    Borrow History </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24" id="pills-reservations-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-reservations" type="button"
                                    role="tab" aria-controls="pills-reservations" aria-selected="false"
                                    tabindex="-1">
                                    Reservations
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Borrow History Tab -->
                            <div class="tab-pane fade show active" id="pills-borrow-history" role="tabpanel"
                                aria-labelledby="pills-borrow-history-tab" tabindex="0">
                                <h6 class="text-xl mb-16">Borrow History</h6>

                                @if ($studentBorrowHistory->isEmpty())
                                    @if (auth()->user()->type != 'student')
                                        <div class="d-flex justify-content-center align-items-center w-100 mt-5">
                                            <strong class="text-center p-3" style="font-size: 20px">This student hasn't
                                                borrowed anything yet.</strong>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center align-items-center w-100 mt-5">
                                            <strong class="text-center p-3" style="font-size: 20px">No data
                                                found.</strong>
                                        </div>
                                    @endif
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Equipment</th>
                                                    <th scope="col">Borrow Date</th>
                                                    <th scope="col">Expected Return Date</th>
                                                    <th scope="col">Return Date</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($studentBorrowHistory as $borrowHistory)
                                                    <tr>
                                                        <td>{{ $borrowHistory->equipment->name }}</td>
                                                        <td>{{ $borrowHistory->borrowed_date }}</td>
                                                        <td>{{ $borrowHistory->expected_returned_date }}</td>
                                                        <td>{{ $borrowHistory->returned_date ? $borrowHistory->returned_date : 'N/A' }}
                                                        </td>
                                                        <td>
                                                            @if (!is_null($borrowHistory->returned_date))
                                                                <span class="badge bg-success">Returned</span>
                                                            @else
                                                                <span class="badge bg-warning">Not returned </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            <!-- Reservations Tab -->
                            <div class="tab-pane fade" id="pills-reservations" role="tabpanel"
                                aria-labelledby="pills-reservations-tab" tabindex="0">
                                <h6 class="text-xl mb-16">Reservations</h6>
                                @if ($studentReservations->isEmpty())
                                    <div class="d-flex justify-content-center align-items-center w-100 mt-5">
                                        <strong class="text-center p-3" style="font-size: 20px">No reservations found
                                            for this student.</strong>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Equipment</th>
                                                    <th scope="col">Reservation Date</th>
                                                    <th scope="col">Expected Return Date</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($studentReservations as $reservation)
                                                    <tr
                                                        onclick="window.location='{{ route('reservation_details', ['id' => $reservation->id]) }}'">
                                                        <td>{{ $reservation->equipment->name }}</td>
                                                        <td>{{ $reservation->reservation_date }}</td>
                                                        <td>{{ $reservation->expected_return_date }}</td>
                                                        <td>
                                                            @if ($reservation->status === 'approved')
                                                                <span class="badge bg-success">Approved</span>
                                                            @else
                                                                <span class="badge bg-warning">Pending</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
    @include('templates.footer')
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        togglePasswordButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML =
                        '<iconify-icon icon="ph:eye-slash-light" class="icon"></iconify-icon>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML =
                        '<iconify-icon icon="ph:eye-light" class="icon"></iconify-icon>';
                }
            });
        });
    });
</script>
