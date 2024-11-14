@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Donate</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Donate</li>
            </ul>
        </div>

        @if (session('donatedSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('donatedSuccessfully') }}
                </div>
            </div>
        @endif

        <div class="card h-100% p-0 radius-12">
            <div class="card-body p-24">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-xl-8 col-lg-10">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <form action="{{ route('donated_equipment') }}" method="post"
                                    id="donatedEquipmentForm">
                                    @csrf

                                    <input type="hidden" name="donated_date" id="donated_date"
                                        value="{{ now()->format('Y-m-d') }}">

                                    <!-- Condition Dropdown -->
                                    <div class="mb-3">
                                        <label for="condition" class="form-label">Condition</label>
                                        <select name="condition" id="condition" class="form-select">
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>

                                    <!-- Recipient Input -->
                                    <div class="mb-3">
                                        <label for="recipient" class="form-label">Recipient</label>
                                        <input type="text" name="recipient" id="recipient" class="form-control"
                                            placeholder="Enter recipient's name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Add some remarks here..."></textarea>
                                    </div>

                                    <!-- Scan Button Triggering Modal -->
                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-primary px-5 py-2" data-bs-toggle="modal"
                                            data-bs-target="#scanModalDonate" id="scanCodeDonate">
                                            Scan QR Code
                                        </button>
                                        <a href="/equipments" class="btn btn-outline-danger px-5 py-2">Cancel</a>
                                    </div>

                                    <!-- Modal for QR Code Scanning -->
                                    <div class="modal fade" id="scanModalDonate" tabindex="-1"
                                        aria-labelledby="scanModalDonateLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scanModalDonateLabel">Donate Equipment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="previewDonate"
                                                        class="display-flex align-items-center justify-content-center scan-code"
                                                        style="width: 100%; height: 400px; border: 2px dashed #ccc;">
                                                        <!-- QR code scanner will be displayed here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
