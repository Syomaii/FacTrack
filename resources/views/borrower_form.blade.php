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

        <div class="row">
            <div class="col-md-6">
                <form action="/borrower-form" method="post">
                    @csrf
                    <div class="card h-100 p-0 radius-12">
                        <div class="card-body p-24">
                            <input type="hidden" name="borrowed_date" value="{{ now()->format('Y-m-d\TH:i') }}">
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
                            <div class="mb-3">
                                <label for="borrower_id"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Borrower's ID</label>
                                <input type="text"
                                    class="form-control radius-8 {{ $errors->has('borrowers_id_no') ? 'is-invalid' : '' }}"
                                    id="borrowers_id_no" name="borrowers_id_no" placeholder="Enter Borrower's ID"
                                    value="{{ old('borrowers_id_no') }}">
                                <small class="text-danger">{{ $errors->first('borrowers_id_no') }}</small>
                            </div>
                            {{-- <div class="mb-3">
                                 <label for="user_id"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">User ID</label> 
                                <input type="text"
                                    class="form-control radius-8 {{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                    id="user_id" name="user_id" placeholder="Enter User ID"
                                    value="{{ auth()->user()->id }}" hidden>
                                <small class="text-danger">{{ $errors->first('user_id') }}</small>
                            </div> --}}
                            {{-- <div class="mb-3">
                                <label for="borrowed_date"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Borrowed Date</label>
                                <input type="datetime-local"
                                    class="form-control radius-8 {{ $errors->has('borrowed_date') ? 'is-invalid' : '' }}"
                                    id="borrowed_date" name="borrowed_date"
                                    value="{{ old('borrowed_date', now()->format('Y-m-d')) }}">
                                <small class="text-danger">{{ $errors->first('borrowed_date') }}</small>
                            </div> --}}
                            <div class="mb-3">
                                <label for="returned_date"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Expected Return
                                    Date</label>
                                <input type="datetime-local"
                                    class="form-control radius-8 {{ $errors->has('returned_date') ? 'is-invalid' : '' }}"
                                    id="returned_date" name="returned_date" value="{{ old('returned_date') }}">
                                <small class="text-danger">{{ $errors->first('returned_date') }}</small>
                            </div>

                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <a href="/equipments">
                                    <button type="button"
                                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                        Cancel
                                    </button>
                                </a>
                                <button type="submit"
                                    class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                    Borrow Equipment
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

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

        
    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')
