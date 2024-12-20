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
                        <div class="card shadow-sm radius-12">
                            <div class="card-body text-center">
                                <!-- Equipment Image -->
                                <div class="mb-5">
                                    <img src="{{ asset($equipment->image) }}" alt="{{ $equipment->name }}" class="img-fluid"
                                        style="max-height: 200px;">
                                </div>
        
                                <!-- Equipment Details -->
                                <div class="row g-4 px-5">
                                    <div class="col-6 text-start ">
                                        <p class="mb-3 fw-bold">Model: <span
                                                class="fw-normal">{{ ucwords($equipment->name) }}</span></p>
                                        <p class="mb-3 fw-bold">Status: <span
                                                class="fw-normal">{{ ucwords($equipment->status) }}</span></p>
                                        <p class="mb-3 fw-bold">Facility: <span
                                                class="fw-normal">{{ ucwords($equipment->facility->name) }}</span></p>
                                    </div>
                                    <div class="col-6 text-start ps-3">
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
                        <h5 class="fw-semibold mb-4 mt-5">Reservation Form</h5>  
                        <form action="{{ route('reserve.equipment.store', $equipment->code) }}" method="POST">
                            @csrf
                            <!-- Purpose -->
                            <div class="mb-4">
                                <label for="purpose" class="form-label">Purpose</label>
                                <textarea class="form-control" id="purpose" name="purpose" rows="3" autofocus>{{ old('purpose') }}</textarea>
                            </div>

                            <!-- Reservation Date and Time -->
                            <div class="mb-4">
                                <label for="reservation_date" class="form-label">Reservation Date and Time</label>
                                <input type="datetime-local" class="form-control" id="reservation_date"
                                    name="reservation_date">
                                    <small class="text-danger">{{ $errors->first('reservation_date') }}</small>
                            </div>

                            <!-- Expected Return Date and Time -->
                            <div class="mb-4">
                                <label for="expected_return_date" class="form-label">Expected Return Date and
                                    Time</label>
                                <input type="datetime-local" class="form-control" id="expected_return_date"
                                    name="expected_return_date">
                                    <small class="text-danger">{{ $errors->first('expected_return_date') }}</small>
                            </div>
                            <div class="d-flex justify-content-center m-3 gap-3">
                                <a href="{{ url()->previous() }}">
                                    <button type="button" class="btn btn-danger m-1 px-56 py-12">Cancel</button>

                                </a>
                                <button type="submit" class="btn btn-primary m-1 px-56 py-12">Reserve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Equipment Image and Details -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body py-5">
                        <h6 class="text-xl mb-16">Reservations</h6>
                        @if ($equipmentReservations->isEmpty())
                            <div class="d-flex justify-content-center align-items-center w-100 mt-5">
                                <strong class="text-center p-3" style="font-size: 20px">No reservation records are found for this equipment.</strong>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Equipment</th>
                                            <th scope="col">Reservation Date</th>
                                            <th scope="col">Expected Return Date</th>
                                            <th scope="col">Purpose</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipmentReservations as $reservation)
                                            <tr>
                                                {{-- onclick="window.location='{{ route('reservation_details', ['id' => $reservation->id]) }}'"> --}}

                                                <td>{{ $reservation->equipment->name }}</td>
                                                <td>{{ $reservation->reservation_date }}</td>
                                                <td>{{ $reservation->expected_return_date }}</td>
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

    @include('templates.footer_inc')
</main>
@include('templates.footer')
