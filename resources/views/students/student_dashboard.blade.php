@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    @if (session('newUser'))
        <div
            class="alert alert-warning bg-warning-100 text-warning-600 border-warning-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                {{ session('newUser') }}
            </div>
        </div>
    @elseif (session('loginUserSuccessfully'))
        <div
            class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                {{ session('loginUserSuccessfully') }}
            </div>
        </div>
    @endif




    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
            </ul>
        </div>

        <div class="d-flex w-100 row gy-4 w-100">
            <div class="col-lg-8">
                <div class="d-flex justify-content-start align-items-end radius-10 bg-white" style="height: 20vh; width: 80">
                    <h5 class="" style="margin-left: 8rem; margin-bottom: 5.5rem">Welcome, {{ $student->firstname }}</h5>
                </div>
                
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    
                </div>
            </div>
              
        </div>
        

        
    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')

