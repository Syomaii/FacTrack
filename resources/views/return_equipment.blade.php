@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Return Equipment</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Return Equipment</li>
            </ul>
        </div>
        <div class="container">
            <div class="card bg-white shadow rounded-3 p-3 border-0 align-items-center justify-content-center"
                style="height: 80vh;">
                <form id="scanId" method="get">
                    <input class="form-control" type="hidden" id="code" name="code">
                </form>
                <button id="b123" class="btn btn-primary">Scan</button>
                <div id="preview" class="display-flex align-items-center justify-content-center"
                    style="width: 500px; opacity: 0;"></div>
            </div>
        </div>
    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')
