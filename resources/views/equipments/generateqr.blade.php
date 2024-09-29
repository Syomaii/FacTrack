@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">QR Code</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">QR Code</li>
            </ul>
        </div>

        <div class="card bg-white shadow rounded-3 p-3 border-0 align-items-center justify-content-center">
            <div class="img-container col-md-6">
                <div>{!! QrCode::size(60)->generate($equipments->code) !!}</div>
            </div>
            <div class="details-container col-md-6">
                <div class="row">
                    <div class="details-item col-md-4 mt-5">
                        <div>
                            <strong>Name:</strong>
                            <p>{{ $equipments->name }}</p>
                        </div>
                    </div>
                    <div class="details-item col-md-4 mt-5">
                        <div>
                            <strong>Status:</strong>
                            <p>{{ $equipments->status }}</p>
                        </div>
                    </div>
                    <div class="details-item col-md-4 mt-5">
                        <div>
                            <strong>Facility:</strong>
                            <p>{{ $equipments->facility }}</p>
                        </div>
                    </div>
                    <div class="details-item col-md-4">
                        <div>
                            <strong>QR No:</strong>
                            <p>{{ $equipments->code }}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <a href="javascript:void(0)" class="btn btn-success text-base radius-8 px-20 py-11"
                        data-id="{{ $equipments->id }}" data-name="{{ $equipments->name }}"
                        data-description="{{ $equipments->description }}"
                        data-acquired_date="{{ $equipments->acquired_date }}"
                        data-status="{{ $equipments->status }}"
                        data-facility="{{ $equipments->facility }}">Edit Equipment
                    </a>
                    <a href="/borrow" class="btn btn-danger text-base radius-8 px-20 py-11">Delete Equipment</a>
                    <a href="/borrower-form/{{ $equipments->id }}" class="btn btn-neutral-900 text-base radius-8 px-20 py-11 borrow">Borrow Equipment</a>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>

<!-- Edit Equipment Modal -->

@include('templates.footer')

