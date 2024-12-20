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
                <div class="card h-100">
                    <div class="card-body py-5">
                        <h5 class="mb-0 ms-5">Reservation Details</h5>

                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Reservers Id:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->reservers_id_no}}</div>

                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Reservers Name:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">
                            @if ($reservation->student)
                                {{ $reservation->student->firstname }} {{ $reservation->student->lastname }}
                            @elseif ($reservation->faculty)
                                {{ $reservation->faculty->firstname }} {{ $reservation->faculty->lastname }}
                            @endif
                        </div>

                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Reservation Date:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->reservation_date }}</div>
                        
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Time In:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->time_in }}</div>

                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Time Out:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->time_out }}</div>

                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Expected number of audience:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->expected_audience_no }}</div>

                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Stage performers if present</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->stage_performers }}</div>

                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Status:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->status }}</div>

                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Purpose:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->purpose }}</div>
                        
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
                <!-- Facility Details Card -->
                <div class="card mb-4"> <!-- Add 'mb-4' for spacing -->
                    <div class="card-body text-center pb-5">
                        <h5 class="mb-0">{{ ucwords($reservation->facility->name) }}</h5>
                        <div class="d-flex justify-content-center mb-4">
                            <iconify-icon icon="mdi:home" style="font-size: 80px; color: #6c757d;"></iconify-icon>
                        </div>
                        <p><strong>Description:</strong> {{ $reservation->facility->description }}</p>
                    </div>
                </div>
            
                <!-- Reservations Card -->
                <div class="card">
                    <div class="card-body py-5">
                        <div id="pills-reservations" role="tabpanel" aria-labelledby="pills-reservations-tab" tabindex="0">
                            <h6 class="text-xl mb-16">Reservations</h6>
                            @if ($facilityReservations->isEmpty())
                                <div class="d-flex justify-content-center align-items-center w-100 mt-5">
                                    <strong class="text-center p-3" style="font-size: 20px">No reservations found for this facility.</strong>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Facility</th>
                                                <th scope="col">Reservation Date</th>
                                                <th scope="col">Purpose</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($facilityReservations as $reservation)
                                                <tr>
                                                    <td>{{ $reservation->facility->name }}</td>
                                                    <td>{{ $reservation->reservation_date }}</td>
                                                    <td>{{ $reservation->purpose }}</td>
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
    

    @include('templates.footer_inc')
</main>
@include('templates.footer')
