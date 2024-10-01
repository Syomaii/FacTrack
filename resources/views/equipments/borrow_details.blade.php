@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Borrow Equipment Details</h6>
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


        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-xl-8 col-lg-10">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <h4>Review Borrow Details</h4>
                                <ul>
                                    <li><strong>Borrower's Name:</strong> {{ $borrowers_name }}</li>
                                    <li><strong>Borrower's ID:</strong> {{ $borrowers_id_no }}</li>
                                    <li><strong>Expected Return Date:</strong> {{ $expected_return_date }}</li>
                                    <li><strong>Equipment Name:</strong> {{ $equipment->name }}</li>
                                    <li><strong>Equipment Code:</strong> {{ $equipment->code }}</li>
                                    <li><strong>Equipment Status:</strong> {{ $equipment->status }}</li>
                                </ul>

                                <!-- Submit and Cancel Buttons -->
                                <form action="{{ route('borrow-equipment-post', $equipment->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="borrowers_name" value="{{ $borrowers_name }}">
                                    <input type="hidden" name="borrowers_id_no" value="{{ $borrowers_id_no }}">
                                    <input type="hidden" name="expected_returned_date"
                                        value="{{ $expected_return_date }}">
                                    <button type="submit" class="btn btn-primary px-5 py-2">Submit</button>
                                </form>


                                <a href="/equipments" class="btn btn-outline-danger px-5 py-2">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
