@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reserve Facility</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('student.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">{{ $facility->name }}</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <strong>{{ session('error') }}</strong>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>{{ $errors->first() }}</strong>
            </div>
        @endif
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body py-5">
                        <!-- Centered Facility Info -->
                        <div class="d-flex justify-content-center mb-4">
                            <div class="card radius-12 shadow-sm text-center w-100" style="width: 400px;">
                                <div class="card-body">
                                    <!-- Centered and Enlarged Icon -->
                                    <div class="d-flex justify-content-center mb-3 w-100">
                                        <iconify-icon icon="{{ $facility->getIconClass() }}" class="text-primary"
                                            style="font-size: 80px;"></iconify-icon>
                                    </div>
                                    <!-- Facility Name and Description -->
                                    <h5 class="fw-semibold mb-2">{{ $facility->name }}</h5>
                                    <p class="text-muted">{{ $facility->description }}</p>
                                </div>
                            </div>
                        </div>


                        <!-- Reservation Form -->
                        <div class="card radius-12 shadow-sm">
                            <div class="card-body">
                                <form action="{{ route('submit_reservation') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="facility_id" value="{{ $facility->id }}">
                                    <!-- Reservation Date -->
                                    <div class="mb-3">
                                        <label for="reservation_date" class="form-label">Reservation Date & Time</label>
                                        <input type="datetime-local" id="reservation_date" name="reservation_date" class="form-control">
                                        <small class="text-danger">{{ $errors->first('reservation_date') }}</small>
                                    </div>

                                    <div class="row">
                                        <!-- Time In -->
                                    <div class="col-md-6 mb-3">
                                        <label for="time_in" class="form-label">Time In</label>
                                        <input type="time" id="time_in" name="time_in" class="form-control"
                                            value="{{ old('time_in') }}">
                                        <small class="text-danger">{{ $errors->first('time_in') }}</small>
                                    </div>

                                    <!-- Time Out -->
                                    <div class="col-md-6 mb-3">
                                        <label for="time_out" class="form-label">Time Out</label>
                                        <input type="time" id="time_out" name="time_out" class="form-control"
                                            value="{{ old('time_out') }}">
                                            <small class="text-danger">{{ $errors->first('time_out') }}</small>
                                    </div>
                                    </div>

                                    <!-- Purpose -->
                                    <div class="mb-3">
                                        <label for="purpose" class="form-label">Purpose</label>
                                        <textarea id="purpose" name="purpose" class="form-control" rows="2"
                                            placeholder="Enter purpose of reservation...">{{ old('purpose') }}</textarea>
                                    </div>

                                    <!-- Expected Audience -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="expected_audience_no" class="form-label">Expected Number of Audience</label>
                                            <input type="text" id="expected_audience_no" name="expected_audience_no" class="form-control"
                                                placeholder="Enter number of people" value="{{ old('expected_audience_no') }}">
                                                <small class="text-danger">{{ $errors->first('expected_audience_no') }}</small>
                                        </div>

                                        <!-- Stage Performers -->
                                        <div class="col-md-6 mb-3">
                                            <label for="stage_performers" class="form-label">Stage Performers</label>
                                            <input type="text" id="stage_performers" name="stage_performers" class="form-control"
                                                placeholder="Enter number of performers" value="{{ old('stage_performers') }}">
                                                <small class="text-danger">{{ $errors->first('stage_performers') }}</small>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-center m-3 gap-3">
                                        <a href="/reserve-facility"><button type="submit" class="btn btn-danger">Cancel
                                                Reservation</button></a>
                                        <button type="submit" class="btn btn-primary">Submit Reservation</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body py-5">
                        <div class="" id="pills-reservations" role="tabpanel"
                            aria-labelledby="pills-reservations-tab" tabindex="0">
                            <h6 class="text-xl mb-16">Reservations</h6>
                            @if ($facilityReservations->isEmpty())
                                <div class="d-flex justify-content-center align-items-center w-100 mt-5">
                                    <strong class="text-center p-3" style="font-size: 20px">No reservations found
                                        for this facility.</strong>
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
                                                    {{-- onclick="window.location='{{ route('reservation_details', ['id' => $reservation->id]) }}'"> --}}

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
