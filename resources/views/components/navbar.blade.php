<div class="navbar-header">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-4">
                <button type="button" class="sidebar-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                </button>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <button type="button" data-bs-toggle="modal" data-bs-target="#scanModal"
                    class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"
                    id="scanCode">
                    <iconify-icon icon="tabler:line-scan" class="text-primary-light text-2xl"></iconify-icon>
                </button>


                <div class="dropdown">
                    <button
                        class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"
                        type="button" data-bs-toggle="dropdown">
                        <iconify-icon icon="iconoir:bell" class="text-primary-light text-2xl""></iconify-icon>
                        @if ($notifications->whereNull('read_at')->count() > 0)
                            <span class="position-absolute top-0 start-50 translate-middle-y badge rounded-pill bg-danger-600 border-0">
                                {{ $notifications->whereNull('read_at')->count() }}
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-lg p-0">
                        <div
                            class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
                            </div>
                            <span
                                class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center">
                                {{ $notifications->whereNull('read_at')->count() }}
                            </span>
                        </div>

                        <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                            @foreach ($notifications as $notification)
                                <a href="{{ route('redirect', $notification->id) }}"
                                    class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-blue {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                                    <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                                        <span class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                            <iconify-icon icon="bitcoin-icons:verify-outline" class="icon text-xxl"></iconify-icon>
                                        </span>
                                        <div>
                                            <h6 class="text-md fw-semibold mb-4">
                                                {{ $notification->data['title'] ?? 'Notification Title' }}</h6>
                                            <p class="mb-0 text-sm text-secondary-light text-w-200-px">
                                                {{ $notification->data['message'] ?? 'Notification Message' }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="text-sm text-secondary-light flex-shrink-0">{{ $notification->created_at->diffForHumans() }}</span>
                                </a>
                            @endforeach


                        </div>

                        <div class="text-center py-12 px-16">
                            <a href="/notifications" class="text-primary-600 fw-semibold text-md">See All
                                Notifications</a>
                        </div>
                    </div>
                </div>

                <!-- Notification dropdown end -->

                <div class="dropdown">
                    <button class="d-flex justify-content-center align-items-center rounded-circle" type="button"
                        data-bs-toggle="dropdown">
                        <img src="/{{ auth()->user()->image }}" alt="image"
                            class="w-40-px h-40-px object-fit-cover rounded-circle">
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-sm">
                        <div
                            class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg text-primary-light fw-semibold mb-2">
                                    {{ ucwords(auth()->user()->firstname) }}</h6>

                                <span
                                    class="text-secondary-light fw-medium text-sm">{{ ucwords(auth()->user()->type) }}</span>
                            </div>
                            <button type="button" class="hover-text-danger">
                                <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                            </button>
                        </div>
                        <ul class="to-top-list">
                            @if (auth()->user()->type != 'student')
                                <li>
                                    <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                        href="{{ route('profile', ['id' => Auth::user()->id]) }}">
                                        <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My
                                        Profile</a>
                                </li>
                            @endif
                            @if (auth()->user()->type === 'student')
                                <li>
                                    <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                        href="/student-profile/{{ auth()->user()->student_id }}"">
                                        <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My
                                        Profile</a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3"
                                    href="/logout">
                                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out</a>
                            </li>
                        </ul>
                    </div>
                </div><!-- Profile dropdown end -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content background-color-blue">
            <div class="modal-header">
                <h5 class="modal-title" id="scanModalLabel">Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" name="borrower_code" id="borrower_code">
            <div class="modal-body">
                <div id="preview" class="display-flex align-items-center justify-content-center scan-code"
                    style="width: 100%; height: 400px; border: 2px dashed #ccc;">
                    <!-- QR code scanner will be displayed here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/assets/js/lib/html5-qrcode.min.js"></script>
<script>
    let scanner;
    let scannerActive = false;

    function startScanner() {
        if (!scanner) {
            scanner = new Html5Qrcode("preview");
        }

        scanner.start({
                facingMode: "environment"
            }, {
                fps: 20,
                qrbox: {
                    width: 300,
                    height: 300
                }
            },
            success,
            error
        ).then(() => {
            scannerActive = true;
        }).catch(err => {
            console.log("Error starting scanner:", err);
        });
    }

    function stopScanner() {
        if (scanner) {
            scanner.stop().then(() => {
                console.log("Scanner stopped.");
                scannerActive = false;
            }).catch(err => {
                console.log("Error stopping scanner:", err);
            });
        }
    }

    function success(result) {
        console.log("Scan result:", result);
        $('#borrower_code').val(result);

        stopScanner();
        window.location.href = "/equipment-details/" + result;
    }

    function error(err) {
        console.log("Scanning error:", err);
    }

    $(document).ready(function() {
        $('#scanCode').on('click', function() {
            if (!scannerActive) {
                startScanner();
                $('#scanModal').modal('show');
            }
        });

        $('#scanModal').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            stopScanner();
        });

        $(window).on('beforeunload', function() {
            stopScanner();
        });
    });
</script>
