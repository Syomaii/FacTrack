@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Notifications</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li class="fw-medium">-</li>
                <li class="fw-medium">Notifications</li>
            </ul>
        </div>

        <div class="alert alert-primary bg-primary-50 text-primary-600 border-primary-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4" role="alert">
            <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span>
                        hehe
                    </span>
                </div>
                <small class="text-muted text-primary-600">
                    hehe
                </small>
            </div>
        </div>

    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')