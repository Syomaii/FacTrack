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
                                <form action="{{ route('maintenance-equipment') }}" method="post"
                                    id="maintenanceEquipmentForm">
                                    @csrf

                                    <input type="hidden" name="maintenance_date"
                                        value="{{ now()->format('Y-m-d\TH:i') }}">
                                    <input type="text" name="maintenance_code" id="maintenance_code" hidden>

                                    <div class="text-center mb-4">
                                        <h5 class="text-primary">Do you want your equipment to be maintained? Just SCAN!
                                        </h5>
                                    </div>

                                    <!-- Scan Button Triggering Modal -->
                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-primary px-5 py-2" data-bs-toggle="modal"
                                            data-bs-target="#scanModal">
                                            Scan QR Code
                                        </button>
                                        <a href="/equipments" class="btn btn-outline-danger px-5 py-2">Cancel</a>
                                    </div>

                                    <!-- Modal for QR Code Scanning -->
                                    <div class="modal fade" id="scanModal" tabindex="-1"
                                        aria-labelledby="scanModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scanModalLabel">Scan QR Code</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="preview"
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

<!-- QR Scanner JavaScript -->
<script src="/assets/js/lib/html5-qrcode.min.js"></script>
<script>
    const scanner = new Html5QrcodeScanner('preview', {
        qrbox: {
            width: 300,
            height: 300,
        },
        fps: 20,
    });

    scanner.render(success, error);

    function success(result) {
        console.log(result);

        var maintenance_id_no = $('#maintenance_id_no').val();
        var maintenance_description = $('#maintenance_description').val();
        var maintenance_date = $('#maintenance_date').val();

        window.location.href = "/maintenance-equipment-details/" + result +
            "?maintenance_id_no=" + encodeURIComponent(maintenance_id_no) +
            "&maintenance_description=" + encodeURIComponent(maintenance_description) +
            "&maintenance_date=" + encodeURIComponent(maintenance_date);
    }

    function error(err) {
        console.log(err);
    }
</script>
