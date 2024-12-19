@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reserve Equipment</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <a href="{{ route('facility_equipment', ['id' => $equipment->facility_id]) }}">
                    {{ $equipment->facility->name }}
                </a>
                <li>-</li>
                <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                    Reserve Equipment
                </a>
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

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Left Side: Reservation Form -->
            <div class="col-md-6">
                <div class="card shadow-sm radius-12">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-4">Reservation Form</h5>
                        <form action="{{ route('reserve.equipment.store', $equipment->code) }}" method="POST">
                            @csrf
                            <!-- Purpose -->
                            <div class="mb-4">
                                <label for="purpose" class="form-label">Purpose</label>
                                <textarea class="form-control" id="purpose" name="purpose" rows="3">{{ old('purpose') }}</textarea>
                            </div>

                            <!-- Reservation Date and Time -->
                            <div class="mb-4">
                                <label for="reservation_date" class="form-label">Reservation Date and Time</label>
                                <input type="datetime-local" class="form-control" id="reservation_date"
                                    name="reservation_date">
                            </div>

                            <!-- Expected Return Date and Time -->
                            <div class="mb-4">
                                <label for="expected_return_date" class="form-label">Expected Return Date and
                                    Time</label>
                                <input type="datetime-local" class="form-control" id="expected_return_date"
                                    name="expected_return_date">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 m-1">Reserve</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Equipment Image and Details -->
            <div class="col-md-6">
                <div class="card shadow-sm radius-12">
                    <div class="card-body text-center">
                        <!-- Equipment Image -->
                        <div class="mb-5">
                            <img src="{{ asset($equipment->image) }}" alt="{{ $equipment->name }}" class="img-fluid"
                                style="max-height: 200px;">
                        </div>

                        <!-- Equipment Details -->
                        <div class="row g-4 px-2">
                            <div class="col-6 text-start">
                                <p class="mb-3 fw-bold">Model: <span
                                        class="fw-normal">{{ ucwords($equipment->name) }}</span></p>
                                <p class="mb-3 fw-bold">Status: <span
                                        class="fw-normal">{{ ucwords($equipment->status) }}</span></p>
                                <p class="mb-3 fw-bold">Facility: <span
                                        class="fw-normal">{{ ucwords($equipment->facility->name) }}</span></p>
                            </div>
                            <div class="col-6 text-start">
                                <p class="mb-3 fw-bold">Brand: <span
                                        class="fw-normal">{{ ucwords($equipment->brand) }}</span></p>
                                <p class="mb-3 fw-bold">Serial Number: <span
                                        class="fw-normal">{{ $equipment->serial_no }}</span></p>
                                <p class="mb-3 fw-bold">Description: <span
                                        class="fw-normal">{{ ucfirst($equipment->description) }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
