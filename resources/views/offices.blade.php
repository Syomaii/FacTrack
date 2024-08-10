@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Offices</h6>
            
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Offices</li>
            </ul>
            
        </div>
        <a href="/facilities/add-facility" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2 mb-3" style="width: 170px"> 
            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
            Add New Office
        </a>
        <div class="row gy-4">

            <div class="col-xxl-3 col-sm-6">
                <div class="card h-100 radius-12 text-center">
                    <div class="card-body p-24">
                        <div
                            class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-info-200 text-primary-600 mb-16 radius-12">
                            <iconify-icon icon="ri:computer-fill" class="h5 mb-0"></iconify-icon>
                        </div>
                        <h6 class="mb-8">Cisco Lab</h6>
                        <a href="facility-equipment.html"
                            class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                            View Facility <iconify-icon icon="iconamoon:arrow-right-2"
                                class="text-xl"></iconify-icon>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    
@include('templates.footer_inc')

</main>
@include('templates.footer')