@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Return Equipment</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Return Equipment</li>
            </ul>
        </div>

        <div class="container">
            <!-- Tabs Section -->
            <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center px-24 active" id="borrow-tab"
                        data-bs-toggle="pill" data-bs-target="#borrow" type="button" role="tab"
                        aria-controls="borrow" aria-selected="true">
                        Borrow
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center px-24" id="maintenance-tab" data-bs-toggle="pill"
                        data-bs-target="#maintenance" type="button" role="tab" aria-controls="maintenance"
                        aria-selected="false">
                        In Maintenance
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center px-24" id="repair-tab" data-bs-toggle="pill"
                        data-bs-target="#repair" type="button" role="tab" aria-controls="repair"
                        aria-selected="false">
                        Repair
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-4" id="equipmentTabContent">
                <!-- Borrow Tab -->
                <div class="tab-pane fade show active" id="borrow" role="tabpanel" aria-labelledby="borrow-tab">
                    <div class="card p-3">
                        <div id="preview-borrow" style="width: 300px; height: 50px;"></div>
                        <textarea class="form-control mt-3" placeholder="Remarks" id="borrow_remarks"></textarea>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button type="button" class="btn btn-primary px-5 py-2" data-bs-toggle="modal"
                                data-bs-target="#scanModalBorrow">
                                Scan QR Code
                            </button>
                            <a href="/equipments" class="btn btn-outline-danger px-5 py-2">Cancel</a>
                        </div>
                    </div>
                </div>

                <!-- Maintenance Tab -->
                <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="maintenance-tab">
                    <div class="card p-3">
                        <div id="preview-maintenance" style="width: 300px; height: 50px;"></div>
                        <select class="form-control mb-3" id="maintenance_issue">
                            <option value="" selected disabled>Problems Encountered</option>
                            <option value="System Failure">System Failure</option>
                            <option value="HDD Failure">HDD Failure</option>
                            <option value="FDD Failure">FDD Failure</option>
                            <option value="Memory error">Memory error</option>
                            <option value="Other">Other</option>
                        </select>
                        <textarea class="form-control mb-3" placeholder="Action Taken" id="maintenance_action_taken"></textarea>
                        <textarea class="form-control mb-3" placeholder="Remarks" id="maintenance_remarks"></textarea>
                        <textarea class="form-control mb-3" placeholder="Recommendations" id="maintenance_recommendations"></textarea>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button type="button" class="btn btn-primary px-5 py-2" data-bs-toggle="modal"
                                data-bs-target="#scanModalMaintenance">
                                Scan QR Code
                            </button>
                            <a href="/equipments" class="btn btn-outline-danger px-5 py-2">Cancel</a>
                        </div>
                    </div>
                </div>

                <!-- Repair Tab -->
                <div class="tab-pane fade" id="repair" role="tabpanel" aria-labelledby="repair-tab">
                    <div class="card p-3">
                        <div id="preview-repair" style="width: 300px; height: 50px;"></div>
                        <select class="form-control mb-3" id="repair_issue">
                            <option value="" selected disabled>Problems Encountered</option>
                            <option value="System Failure">System Failure</option>
                            <option value="HDD Failure">HDD Failure</option>
                            <option value="FDD Failure">FDD Failure</option>
                            <option value="Memory error">Memory error</option>
                            <option value="Other">Other</option>
                        </select>
                        <textarea class="form-control mb-3" placeholder="Action Taken" id="repair_action_taken"></textarea>
                        <textarea class="form-control mb-3" placeholder="Remarks" id="repair_remarks"></textarea>
                        <textarea class="form-control mb-3" placeholder="Recommendations" id="repair_recommendations"></textarea>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button type="button" class="btn btn-primary px-5 py-2" data-bs-toggle="modal"
                                data-bs-target="#scanModalRepair">
                                Scan QR Code
                            </button>
                            <a href="/equipments" class="btn btn-outline-danger px-5 py-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')

<!-- Modals for Each QR Scanner -->
<div class="modal fade" id="scanModalBorrow" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code (Borrow)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="preview-borrow-scan" style="width: 100%; height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="scanModalMaintenance" tabindex="-1" aria-labelledby="scanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code (Maintenance)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="preview-maintenance-scan" style="width: 100%; height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="scanModalRepair" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code (Repair)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="preview-repair-scan" style="width: 100%; height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- QR Scanner JavaScript for Each Tab -->
<script src="/assets/js/lib/html5-qrcode.min.js"></script>
<script>
    function initScanner(previewId, successCallback) {
        const scanner = new Html5QrcodeScanner(previewId, {
            qrbox: {
                width: 300,
                height: 300
            },
            fps: 20,
        });
        scanner.render(successCallback, console.error);
    }

    // Common function to handle AJAX request after scanning
    function handleReturnEquipment(result, status, additionalParams = {}) {
        let url = `/return-equipment/${encodeURIComponent(result)}`;

        // Prepare form data
        const formData = {
            status: status,
            ...additionalParams
        };

        // Use AJAX to send the data
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle success response, e.g., show a message or update the UI
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    }

    // Borrow scanner
    $('#scanModalBorrow').on('shown.bs.modal', function() {
        initScanner("preview-borrow-scan", function(result) {
            console.log(result);
            $('#borrow_remarks').val(result);

            // Get current date and time for the returned date
            var now = new Date();
            var returnedDate = now.toISOString();

            // Construct additional parameters for borrow
            const additionalParams = {
                returned_date: returnedDate
            };

            handleReturnEquipment(result, 'Borrowed', additionalParams);
            $('#scanModalBorrow').modal('hide');
        });
    });

    // Maintenance scanner
    $('#scanModalMaintenance').on('shown.bs.modal', function() {
        initScanner("preview-maintenance-scan", function(result) {
            console.log(result);
            var maintenanceIssue = $('#maintenance_issue').val();
            var actionTaken = $('#maintenance_action_taken').val();
            var remarks = $('#maintenance_remarks').val();
            var recommendations = $('#maintenance_recommendations').val();

            var now = new Date();
            var returnedDate = now.toISOString();

            // Construct additional parameters for maintenance
            const additionalParams = {
                issue_note: maintenanceIssue,
                returned_date: returnedDate,
                action_taken: actionTaken,
                remarks: remarks,
                recommendations: recommendations
            };

            handleReturnEquipment(result, 'In Maintenance', additionalParams);
            $('#scanModalMaintenance').modal('hide');
        });
    });

    // Repair scanner
    $('#scanModalRepair').on('shown.bs.modal', function() {
        initScanner("preview-repair-scan", function(result) {
            console.log(result);
            var repairIssue = $('#repair_issue').val();
            var actionTaken = $('#repair_action_taken').val();
            var remarks = $('#repair_remarks').val();
            var recommendations = $('#repair_recommendations').val();

            // Get current date and time for the repair date
            var now = new Date();
            var returnedDate = now.toISOString();

            const additionalParams = {
                repair_issue_note: repairIssue,
                returned_date: returnedDate,
                action_taken: actionTaken,
                remarks: remarks,
                recommendations: recommendations
            };

            handleReturnEquipment(result, 'In Repair', additionalParams);
            $('#scanModalRepair').modal('hide');
        });
    });
</script>
