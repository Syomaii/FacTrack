@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Maintenance</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Maintenance</li>
            </ul>
        </div>

        @if (session('maintenanceSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('maintenanceSuccessfully') }}
                </div>
            </div>
        @endif

        <div class="card h-100% p-0 radius-12">
            <div class="card-body p-24">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-xl-8 col-lg-10">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <form action="{{ route('maintenance_equipment') }}" method="post"
                                    id="maintenanceEquipmentForm">
                                    @csrf

                                    <input type="hidden" name="maintenance_date" id="maintenance_date"
                                        value="{{ now()->format('Y-m-d') }}">

                                    <div class="mb-3">
                                        <label for="issue_note" class="form-label">Issue Note</label>
                                        <textarea name="issue_note" id="issue_note" class="form-control" rows="3"
                                            placeholder="Describe the issue here..."></textarea>
                                    </div>

                                    <!-- Scan Button Triggering Modal -->

                                    <div class="d-flex justify-content-center gap-3 py-2 ">
                                        <a href="/equipments" class="">
                                            <button type="button"
                                            class="btn btn-danger border border-danger-600 text-md px-56 py-12 radius-8" id="cancelBtn">
                                            Cancel
                                        </button></a>
                                        <button type="button" class="btn btn-primary px-20 py-11 " data-bs-toggle="modal"
                                            data-bs-target="#scanModalMaintenance" id="scanCodeMaintenance">
                                            Scan QR Code
                                        </button>
                                        
                                    </div>

                                    <!-- Modal for QR Code Scanning -->
                                    <div class="modal fade" id="scanModalMaintenance" tabindex="-1"
                                        aria-labelledby="scanModalMaintenanceLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scanModalMaintenanceLabel">Maintenance Equipment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="previewMaintenance"
                                                        class="display-flex align-items-center justify-content-center scan-code"
                                                        style="width: 100%; height: auto; border: 2px dashed #ccc;">
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

