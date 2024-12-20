@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <h6 class="fw-semibold mb-0">Facility Reservation Details</h6>

            <ul class="d-flex align-items-center gap-3">
                @if (auth()->user()->type === 'operator' || auth()->user()->type === 'facility manager')
                    <li>
                        <a href="{{ route('logs.facility_reservations') }}" class="text-secondary text-decoration-none">
                            <i class="bi bi-journal-text"></i> Facility Reservation Logs
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center mb-3">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <!-- Reservation Details -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body py-5">
                        <h5 class="mb-0">Reservation Details</h5>
                        <p><strong>Reservers ID:</strong> {{ $reservation->reservers_id_no }}</p>
                        <p><strong>Reservers Name:</strong>
                            @if ($reservation->student)
                                {{ $reservation->student->firstname }} {{ $reservation->student->lastname }}
                            @elseif ($reservation->faculty)
                                {{ $reservation->faculty->firstname }} {{ $reservation->faculty->lastname }}
                            @endif
                        </p>
                        <p><strong>Purpose:</strong> {{ $reservation->purpose }}</p>
                        <p><strong>Reservation Date:</strong> {{ $reservation->reservation_date }}</p>
                        <p><strong>Time In:</strong> {{ $reservation->time_in }}</p>
                        <p><strong>Time Out:</strong> {{ $reservation->time_out }}</p>
                        <p><strong>Expected Audience:</strong> {{ $reservation->expected_audience_no }}</p>
                        <p><strong>Stage Performers:</strong> {{ $reservation->stage_performers }}</p>
                        <p><strong>Status:</strong>
                            <span
                                class="badge 
                                {{ $reservation->status === 'pending' ? 'bg-warning' : ($reservation->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </p>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Reservers Id:</strong>
                        </div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->reservers_id_no}}</div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Student Name:</strong>
                        </div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->student->firstname }}
                            {{ $reservation->student->lastname }}</div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Department:</strong>
                        </div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->offices->name }}</div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Status:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->status }}</div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Purpose:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->purpose }}</div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Reservation
                                Date:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->reservation_date }}</div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Expected Return
                                Date:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->expected_return_date }}
                        </div>
                        @if (auth()->user()->type === 'operator' || auth()->user()->type === 'facility manager')
                            @if ($reservation->status === 'pending')
                                <div class="mt-4 d-flex justify-content-center gap-3">
                                    <form action="{{ route('reservation.declineFacility', $reservation->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger px-56 py-12">Decline</button>
                                    </form>
                                    <form action="{{ route('reservation.acceptFacility', $reservation->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary px-56 py-12">Accept</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Facility Details -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white text-center">
                        <h5 class="mb-0">{{ ucwords($reservation->facility->name) }}</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-center mb-4">
                            <iconify-icon icon="mdi:home" style="font-size: 80px; color: #6c757d;"></iconify-icon>
                        </div>
                        <p><strong>Description:</strong> {{ $reservation->facility->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
