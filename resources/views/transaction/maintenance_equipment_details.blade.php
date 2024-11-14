@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Maintenance Equipment Details</h6>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row g-4">
            <!-- Borrow Details Section -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body" style="padding-top: 100px">
                        <form action="{{ route('maintenance-equipment-post', $equipment->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="maintenance_id_no" value="{{ $maintenance_id_no }}">
                            <div class="mb-3">
                                <label class="form-label">Issue</label>
                                <input type="text" class="form-control w-100" style="max-width: 1000vh" name="issue_note" value="{{ $issue_note }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Maintenance Date</label>
                                <input type="text" class="form-control w-100" style="max-width: 1000vh" name="maintenance_date" value="{{ $maintenance_date }}" readonly>
                            </div>
                            <div class="d-flex justify-content-center gap-4" style="padding-top: 25px">
                                <a href="/equipments" class="btn btn-outline-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
            <!-- Equipment Details Section -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <h4 class="fw-bold d-flex justify-content-end mt-5" style="margin-right: 75px">{{ ucwords($equipment->name) }}</h4>
                    <div class="card-body text-center">
                        <img src="/{{ $equipment->image }}" alt="Equipment Image" class="img-fluid rounded mb-3 bg-light w-100" style="max-width: 620px;">
                        <div class="row gy-4">
                            <div class="col-lg-6">
                                <div class="d-flex mt-3" style="margin-left: 4rem;"><strong>Equipment code:</strong></li></div>
                                <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $equipment->code }}</div>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <div class="d-flex" style="margin-top: 1.0rem; margin-right: 5rem">{!! QrCode::size(60)->generate($equipment->code) !!}</div>
                            </div>
                        </div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Status:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $equipment->status }}</div>
                        <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Serial Number:</strong></div>
                        <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $equipment->serial_no }}</div>   

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
