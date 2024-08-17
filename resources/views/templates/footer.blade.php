</main>
<!-- jQuery library js -->
<script src="/assets/js/lib/jquery-3.7.1.min.js"></script>
<!-- Bootstrap js -->
<script src="/assets/js/lib/bootstrap.bundle.min.js"></script>
<!-- Apex Chart js -->
<script src="/assets/js/lib/apexcharts.min.js"></script>
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
<script type="text/javascript" src="/assets/js/lib/instascan.min.js"></script>
<script src="/assets/js/homeTwoChart.js"></script>

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
@if (url()->current() == url('scan-code'))
    <script src="/assets/js/lib/html5-qrcode.min.js"></script>
    <script>
        // console.log(Html5QrcodeScanner);
        const scanner = new Html5QrcodeScanner('preview', {
            qrbox: {
                width: 300,
                height: 300,
            },
            fps: 20,
        });

        scanner.render(success, error);

        function success(result) {
            // console.log(result);
            // window.location.href = "http://localhost:8000/equipment-details/"+result;
            // window.location.href = result;

            $('#code').val(result)
            $('#scanId').submit()

            scanner.clear();
            document.getElementById('reader').remove();
        }

        function error(err) {
            console.log(err);
        }

        $('#b123').click(function() {
            $('#preview').css('opacity', 1)
        })
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
</body>

</html>
