</main>
<!-- jQuery library js -->
<script src="/assets/js/lib/jquery-3.7.1.min.js"></script>
<!-- Bootstrap js -->
<script src="/assets/js/lib/bootstrap.bundle.min.js"></script>
{{-- <!-- Apex Chart js -->
<script src="/assets/js/lib/apexcharts.min.js"></script> --}}
<!-- Data Table js -->
<script src="/assets/js/lib/dataTables.min.js"></script>
<!-- Iconify Font js -->
<script src="/assets/js/lib/iconify-icon.min.js"></script>
<!-- jQuery UI js -->
<script src="/assets/js/lib/jquery-ui.min.js"></script>
<!-- Vector Map js -->
<script src="/assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
<script src="/assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
<!-- Popup js -->
<script src="/assets/js/lib/magnifc-popup.min.js"></script>
<!-- Slick Slider js -->
<script src="/assets/js/lib/slick.min.js"></script>
<!-- main js -->
<script src="/assets/js/app.js"></script>
<script>
    let table = new DataTable('#dataTable');
</script>
{{-- <script type="text/javascript" src="/assets/js/lib/instascan.min.js"></script> --}}
{{-- <script src="/assets/js/homeTwoChart.js"></script> --}}

@if (url()->current() == 'http://localhost:8000')
    :
    <script>
        // ================== Password Show Hide Js Start ==========
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on('click', function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }

        // Call the function
        initializePasswordToggle('.toggle-password');

        // ========================= Password Show Hide Js End ===========================
    </script>
@endif


@if (url()->current() == url('borrow-equipment'))
<script src="/assets/js/lib/html5-qrcode.min.js"></script>
<script>
    let borrowScanner;

    function startBorrowScanner() {
        if (scannerActive) return; // Prevent new scanner if one is active

        if (!borrowScanner) {
            borrowScanner = new Html5Qrcode("previewBorrow");
        }

        borrowScanner.start(
            { facingMode: "environment" },
            { fps: 20, qrbox: { width: 300, height: 300 } },
            successBorrow,
            errorBorrow
        ).then(() => {
            scannerActive = true; // Set active when scanner starts
        }).catch(err => {
            console.log("Error starting scanner:", err);
        });
    }

    function stopBorrowScanner() {
        if (borrowScanner && scannerActive) {
            borrowScanner.stop().then(() => {
                console.log("Scanner stopped.");
                scannerActive = false; // Reset active flag on stop
            }).catch(err => {
                console.log("Error stopping scanner:", err);
            });
        }
    }

    function successBorrow(result) {
        console.log(result);

        $('#borrower_code').val(result);

        // Additional logic for borrow-equipment page
        var borrowers_id_no = $('#borrowers_id_no').val();
        var borrowers_name = $('#borrowers_name').val();
        var department = $('#department').val();
        var purpose = $('#purpose').val();
        var expected_return_date = $('#expected_return_date').val();

        stopBorrowScanner();

        if (borrowers_name !== " " && borrowers_id_no !== " " && expected_return_date !== " ") {
            window.location.href = "/borrow-details/" + result +
                "?borrowers_id_no=" + encodeURIComponent(borrowers_id_no) +
                "&borrowers_name=" + encodeURIComponent(borrowers_name) +
                "&department=" + encodeURIComponent(department) +
                "&purpose=" + encodeURIComponent(purpose) +
                "&expected_return_date=" + encodeURIComponent(expected_return_date);
        } else {
            window.location.href = "/borrow-equipment";
        }
    }

    function errorBorrow(err) {
        console.log(err);
    }

    $(document).ready(function() {
        $('#scanCodeBorrow').on('click', function() {
            if (!scannerActive) { // Only start if no other scanner is running
                startBorrowScanner();
                $('#scanModalBorrow').modal('show');
            }
        });

        $('#scanModalBorrow').on('hidden.bs.modal', function() {
            stopBorrowScanner();
        });

        $(window).on('beforeunload', function() {
            stopBorrowScanner();
        });
    });
</script>
@endif
@if (url()->current() == url('maintenance-equipment'))
<script src="/assets/js/lib/html5-qrcode.min.js"></script>
<script>
    let maintenanceScanner;

    function startMaintenanceScanner() {
        if (scannerActive) return; 

        if (!maintenanceScanner) {
            maintenanceScanner = new Html5Qrcode("previewMaintenance");
        }

        maintenanceScanner.start(
            { facingMode: "environment" },
            { fps: 20, qrbox: { width: 300, height: 300 } },
            successMaintenance,
            errorMaintenance
        ).then(() => {
            scannerActive = true; 
        }).catch(err => {
            console.log("Error starting scanner:", err);
        });
    }

    function stopMaintenanceScanner() {
        if (maintenanceScanner && scannerActive) {
            maintenanceScanner.stop().then(() => {
                console.log("Scanner stopped.");
                scannerActive = false; 
            }).catch(err => {
                console.log("Error stopping scanner:", err);
            });
        }
    }

    function successMaintenance(result) {
        console.log("Scan result:", result);
        $('#maintenance_code').val(result);

        var maintenance_id_no = $('#maintenance_id_no').val();
        var issue_note = $('#issue_note').val();
        var maintenance_date = $('#maintenance_date').val();

        stopMaintenanceScanner();

        window.location.href = "/maintenance-equipment-details/" + result +
            "?maintenance_id_no=" + encodeURIComponent(maintenance_id_no) +
            "&issue_note=" + encodeURIComponent(issue_note) +
            "&maintenance_date=" + encodeURIComponent(maintenance_date);
    }

    function errorMaintenance(err) {
        console.log("Scanning error:", err);
    }

    $(document).ready(function() {
        $('#scanCodeMaintenance').on('click', function() {
            if (!scannerActive) { 
                startMaintenanceScanner();
                $('#scanModalMaintenance').modal('show');
            }
        });

        $('#scanModalMaintenance').on('hidden.bs.modal', function() {
            stopMaintenanceScanner();
        });

        $(window).on('beforeunload', function() {
            stopMaintenanceScanner();
        });
    });
</script>
@endif
@if (url()->current() == url('repair-equipment'))
<script src="/assets/js/lib/html5-qrcode.min.js"></script>
<script>
    let repairScanner;

    function startRepairScanner() {
        if (scannerActive) return; // Prevent starting if another scanner is active

        if (!repairScanner) {
            repairScanner = new Html5Qrcode("previewRepair");
        }

        repairScanner.start(
            { facingMode: "environment" },
            { fps: 20, qrbox: { width: 300, height: 300 } },
            successRepair,
            errorRepair
        ).then(() => {
            scannerActive = true; // Mark scanner as active
        }).catch(err => {
            console.log("Error starting scanner:", err);
        });
    }

    function stopRepairScanner() {
        if (repairScanner && scannerActive) {
            repairScanner.stop().then(() => {
                console.log("Scanner stopped.");
                scannerActive = false; // Reset active flag on stop
            }).catch(err => {
                console.log("Error stopping scanner:", err);
            });
        }
    }

    function successRepair(result) {
        console.log(result);

        var repair_id_no = $('#repair_id_no').val();
        var issue_note = $('#issue_note').val();
        var repair_date = $('#repair_date').val();

        stopRepairScanner();

        window.location.href = "/repair-equipment-details/" + result +
            "?repair_id_no=" + encodeURIComponent(repair_id_no) +
            "&issue_note=" + encodeURIComponent(issue_note) +
            "&repair_date=" + encodeURIComponent(repair_date);
    }

    function errorRepair(err) {
        console.log(err);
    }

    $(document).ready(function() {
        $('#scanCodeRepair').on('click', function() {
            if (!scannerActive) { // Start only if no other scanner is running
                startRepairScanner();
                $('#scanModalRepair').modal('show');
            }
        });

        $('#scanModalRepair').on('hidden.bs.modal', function() {
            stopRepairScanner();
        });

        $(window).on('beforeunload', function() {
            stopRepairScanner();
        });
    });
</script>
@endif
@if (url()->current() == url('dispose-equipment'))
<script src="/assets/js/lib/html5-qrcode.min.js"></script>
<script>
    let disposeScanner;

    function startDisposeScanner() {
        if (scannerActive) return; // Prevent starting if another scanner is active

        if (!disposeScanner) {
            disposeScanner = new Html5Qrcode("previewDispose");
        }

        disposeScanner.start(
            { facingMode: "environment" },
            { fps: 20, qrbox: { width: 300, height: 300 } },
            successDispose,
            errorDispose
        ).then(() => {
            scannerActive = true; 
        }).catch(err => {d
            console.log("Error starting scanner:", err);
        });
    }

    function stopDisposeScanner() {
        if (disposeScanner && scannerActive) {
            disposeScanner.stop().then(() => {
                console.log("Scanner stopped.");
                scannerActive = false; // Reset active flag on stop
            }).catch(err => {
                console.log("Error stopping scanner:", err);
            });
        }
    }

    function successDispose(result) {
        console.log(result);

        var disposed_id_no = $('#disposed_id_no').val();
        var remarks = $('#remarks').val();
        var disposed_date = $('#disposed_date').val();

        stopDisposeScanner();

        window.location.href = "/disposed-equipment-details/" + result +
            "?disposed_id_no=" + encodeURIComponent(disposed_id_no) +
            "&remarks=" + encodeURIComponent(remarks) +
            "&disposed_date=" + encodeURIComponent(disposed_date);
    }

    function errorDispose(err) {
        console.log(err);
    }

    $(document).ready(function() {
        $('#scanCodeDispose').on('click', function() {
            if (!scannerActive) { // Only start if no other scanner is active
                startDisposeScanner();
                $('#scanModalDispose').modal('show');
            }
        });

        $('#scanModalDispose').on('hidden.bs.modal', function() {
            stopDisposeScanner();
        });

        $(window).on('beforeunload', function() {
            stopDisposeScanner();
        });
    });
</script>
@endif
@if (url()->current() == url('donate-equipment'))
<script src="/assets/js/lib/html5-qrcode.min.js"></script>
<script>
    let donateScanner;

    function startDonateScanner() {
        if (scannerActive) return; // Prevent starting if another scanner is active

        if (!donateScanner) {
            donateScanner = new Html5Qrcode("previewDonate");
        }

        donateScanner.start(
            { facingMode: "environment" },
            { fps: 20, qrbox: { width: 300, height: 300 } },
            successDonate,
            errorDonate
        ).then(() => {
            scannerActive = true; // Mark scanner as active
        }).catch(err => {
            console.log("Error starting scanner:", err);
        });
    }

    function stopDonateScanner() {
        if (donateScanner && scannerActive) {
            donateScanner.stop().then(() => {
                console.log("Scanner stopped.");
                scannerActive = false; 
            }).catch(err => {
                console.log("Error stopping scanner:", err);
            });
        }
    }

    function successDonate(result) {
        console.log(result);

        var donated_id_no = $('#donated_id_no').val();
        var condition = $('#condition').val();
        var recipient = $('#recipient').val();
        var remarks = $('#remarks').val();
        var donated_date = $('#donated_date').val();

        stopDonateScanner();

        window.location.href = "/donated-equipment-details/" + result +
            "?donated_id_no=" + encodeURIComponent(donated_id_no) +
            "&condition=" + encodeURIComponent(condition) +
            "&recipient=" + encodeURIComponent(recipient) +
            "&remarks=" + encodeURIComponent(remarks) +
            "&donated_date=" + encodeURIComponent(donated_date);
    }

    function errorDonate(err) {
        console.log(err);
    }

    $(document).ready(function() {
        $('#scanCodeDonate').on('click', function() {
            if (!scannerActive) { // Only start if no other scanner is active
                startDonateScanner();
                $('#scanModalDonate').modal('show');
            }
        });

        $('#scanModalDonate').on('hidden.bs.modal', function() {
            stopDonateScanner();
        });

        $(window).on('beforeunload', function() {
            stopDonateScanner();
        });
    });
</script>
@endif


<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut(400, function() {
                $(this).remove(); // Remove the alert element from the DOM
            });
        }, 2000);
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</body>

</html>
