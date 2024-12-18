@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reservation Details</h6>
            <ul class="d-flex align-items-center gap-2">
                @if (auth()->user()->type === 'operator' || auth()->user()->type === 'facility manager')
                    <li class="fw-medium">
                        <a href="/reservations-log" class="d-flex align-items-center gap-1 hover-text-primary">
                            Reservation Logs
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        @if ($errors->any())
            <div
                class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ $errors->all() }}
                </div>
            </div>
        @endif
        @if (session('success'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('success') }}
                </div>
            </div>
        @endif


        <div class="row g-4">
            <!-- Borrow Details Section -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body py-5">
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
                                <div class="d-flex justify-content-center gap-4" style="padding-top: 25px">
                                    <form action="{{ route('reservation.decline', $reservation->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Decline</button>
                                    </form>
                                    <form action="{{ route('reservation.accept', $reservation->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Accept</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Equipment Details Section -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <h4 class="fw-bold d-flex justify-content-end mt-5" style="margin-right: 75px">
                        {{ ucwords($reservation->equipment->name) }}</h4>
                    <div class="card-body text-center">
                        <img src="/{{ $reservation->equipment->image }}" alt="Equipment Image"
                            class="img-fluid rounded mb-3 bg-light w-100" style="max-width: 620px;">
                        <div class="row gy-4">
                            <div class="col-lg-6">
                                <div class="d-flex mt-3" style="margin-left: 4rem;"><strong>Equipment code:</strong>
                                    </li>
                                </div>
                                <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->equipment->code }}
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <div class="d-flex" style="margin-top: 1.0rem; margin-right: 5rem">
                                    {!! QrCode::size(60)->generate($reservation->equipment->code) !!}</div>
                            </div>
                        </div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Status:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->equipment->status }}</div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Serial Number:</strong>
                        </div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $reservation->equipment->serial_no }}
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
