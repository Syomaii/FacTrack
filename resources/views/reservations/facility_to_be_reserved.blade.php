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
        @elseif ($errors->any())
            <div class="alert alert-danger">
                <strong>{{ $errors->first() }}</strong>
            </div>
        @endif

        <!-- Centered Facility Info -->
        <div class="d-flex justify-content-center mb-4">
            <div class="card radius-12 shadow-sm text-center" style="width: 400px;">
                <div class="card-body">
                    <!-- Centered and Enlarged Icon -->
                    <div class="d-flex justify-content-center mb-3">
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
                    </div>

                    <!-- Time In -->
                    <div class="mb-3">
                        <label for="time_in" class="form-label">Time In</label>
                        <input type="time" id="time_in" name="time_in" class="form-control"
                            value="{{ old('time_in') }}">
                    </div>

                    <!-- Time Out -->
                    <div class="mb-3">
                        <label for="time_out" class="form-label">Time Out</label>
                        <input type="time" id="time_out" name="time_out" class="form-control"
                            value="{{ old('time_out') }}">
                    </div>

                    <!-- Purpose -->
                    <div class="mb-3">
                        <label for="purpose" class="form-label">Purpose</label>
                        <textarea id="purpose" name="purpose" class="form-control" rows="2"
                            placeholder="Enter purpose of reservation...">{{ old('purpose') }}</textarea>
                    </div>

                    <!-- Expected Audience -->
                    <div class="mb-3">
                        <label for="expected_audience_no" class="form-label">Expected Audience Number</label>
                        <input type="text" id="expected_audience_no" name="expected_audience_no" class="form-control"
                            placeholder="Enter number of people" value="{{ old('expected_audience_no') }}">
                    </div>

                    <!-- Stage Performers -->
                    <div class="mb-3">
                        <label for="stage_performers" class="form-label">Stage Performers</label>
                        <input type="text" id="stage_performers" name="stage_performers" class="form-control"
                            placeholder="Enter number of performers" value="{{ old('stage_performers') }}">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>

@include('templates.footer')
