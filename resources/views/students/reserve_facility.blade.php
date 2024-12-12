@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reserve Facility</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('student.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Reserve Facility</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- Main Section -->
        <div class="d-flex justify-content-between align-items-center mb-24">
            <div class="input-group" style="width: 100%; max-width: 650px;">
                <input type="text" id="equipmentSearch" class="form-control radius-8 border-0 shadow-sm"
                    placeholder="Search facilities...">
                <button class="btn btn-primary" type="button" style="z-index: 0"><iconify-icon icon="ic:baseline-search"
                        class="icon" ></iconify-icon></button>
            </div>
        </div>

        <!-- No facilities message -->
        <div class="row gy-4" id="equipmentList">
            @if (!$facilities->isEmpty())
                @foreach ($facilities as $facility)
                    <div class="col-xxl-3 col-sm-6 equipment-card">
                        <div class="card h-100 radius-12 text-center">
                            <div class="card-body p-24">
                                <div class="d-flex flex-column align-items-center">
                                    <div
                                        class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-info-200 text-primary-600 mb-16 radius-12">
                                        <iconify-icon icon="{{ $facility->getIconClass() }}"
                                            class="h5 mb-0"></iconify-icon>
                                    </div>
                                    <h6 class="mb-8">{{ $facility->name }}</h6>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('facility_equipment', ['id' => $facility->id]) }}"
                                            class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                                            @if ($facility->type == 'laboratory')
                                                View Laboratory
                                            @elseif ($facility->type == 'office')
                                                View Office
                                            @elseif ($facility->type == 'room')
                                                View Room
                                            @endif <iconify-icon icon="iconamoon:arrow-right-2"
                                                class="text-xl"></iconify-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="d-flex justify-content-center align-items-center" style="height: 55vh; width: 100vw;">
                    <strong class="text-center p-3">There are no facilities available for reservation</strong>
                </div>
            @endif
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')