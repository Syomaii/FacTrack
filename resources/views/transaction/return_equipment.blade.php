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
            <div class="card bg-white shadow rounded-3 p-3 border-0 align-items-center justify-content-center"
                style="height: 80vh;">
                
                <!-- Form to submit the equipment code -->
                <form id="scanId" action="{{ route('return.equipment') }}" method="post"> <!-- Ensure the route matches the controller -->
                    @csrf <!-- Include CSRF protection in forms -->
                    
                    <div class="form-group">
                        <input class="form-control" type="text" id="code" name="code" required>
                    </div>
                    
                </form>
                
                <div class="d-flex align-items-center justify-content-center" style="width: 200px">
                    <div id="return" class="d-flex align-items-center justify-content-center"
                        style="width: 100%; height: 500px">
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')
