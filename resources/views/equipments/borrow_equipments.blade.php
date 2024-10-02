@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Borrow Equipment</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Borrow Equipment</li>
            </ul>
        </div>

        @if (session('borrowEquipmentSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('borrowEquipmentSuccessfully') }}
                </div>
            </div>
        @endif

        
        <div class="card h-100% p-0 radius-12">
            <div class="card-body p-24">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-xl-8 col-lg-10">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <form action="{{ url('/borrow-equipment/{code}') }}" method="post" id="borrowEquipmentForm">
                                    @csrf
                                    <input type="hidden" name="borrowed_date" value="{{ now()->format('Y-m-d\TH:i') }}">
                                    <input type="hidden" name="borrower_code" id="borrower_code">

                                    <!-- Borrower's Name -->
                                    <div class="mb-3">
                                        <label for="borrowers_name"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Borrower's
                                            Name</label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('borrowers_name') ? 'is-invalid' : '' }}"
                                            id="borrowers_name" name="borrowers_name" placeholder="Enter Borrower's Name"
                                            value="{{ old('borrowers_name') }}">
                                        <small class="text-danger">{{ $errors->first('borrowers_name') }}</small>
                                    </div>

                                    <!-- Borrower's ID Number -->
                                    <div class="mb-3">
                                        <label for="borrower_id"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Borrower's ID</label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('borrowers_id_no') ? 'is-invalid' : '' }}"
                                            id="borrowers_id_no" name="borrowers_id_no" placeholder="Enter Borrower's ID"
                                            value="{{ old('borrowers_id_no') }}">
                                        <small class="text-danger">{{ $errors->first('borrowers_id_no') }}</small>
                                    </div>

                                    <!-- Expected Return Date -->
                                    <div class="mb-3">
                                        <label for="expected_return_date"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Expected Return
                                            Date</label>
                                        <input type="datetime-local"
                                            class="form-control radius-8 {{ $errors->has('expected_return_date') ? 'is-invalid' : '' }}"
                                            id="expected_return_date" name="expected_return_date" value="{{ old('expected_return_date') }}">
                                        <small class="text-danger">{{ $errors->first('expected_return_date') }}</small>
                                    </div>


                                    <!-- Scan Button Triggering Modal -->
                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-primary px-5 py-2" data-bs-toggle="modal" data-bs-target="#scanModal">
                                            Scan QR Code
                                        </button>
                                        <a href="/equipments" class="btn btn-outline-danger px-5 py-2">Cancel</a>
                                    </div>

                                    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true" id="scanModal">
                                        <div class="modal-dialog modal-dialog-centered ">
                                            <div class="modal-content background-color-blue">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scanModalLabel">Scan QR Code</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="preview" class="display-flex align-items-center justify-content-center scan-code" 
                                                        style="width: 100%; height: 400px; border: 2px dashed #ccc;">
                                                        <!-- QR code scanner will be displayed here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal for QR Code Scanning -->
        

                
        

        

            {{-- <div class="col-md-6">
                <div class="card h-100 p-0 radius-12">
                    <div class="card-body p-24">
                        <div class="mb-2 text-end">
                            <div class="form-control fw-bold text-primary-light radius-8 border-0"
                                style="font-size: 1.5rem;">{{ $equipment->name }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="radius-5 overflow-hidden">
                                <img src="{{ asset($equipment->image) }}" alt="Equipment Image" class="img-fluid"
                                    style="max-width: 100%; height: 100%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-primary-light text-sm mb-8">Equipment
                                        ID</label>
                                    <div class="form-control radius-8 border-0">{{ $equipment->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-primary-light text-sm mb-8">Status</label>
                                    <div class="form-control radius-8 border-0">{{ $equipment->status }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="mb-3">
                                    {!! QrCode::size(100)->generate($equipment->code) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        
    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')
