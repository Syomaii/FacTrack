@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Disposed Equipment Details</h6>
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
                                <h4>Review Disposed Details</h4>
                                <ul>
                                    <li><strong>Equipment ID:</strong> {{ $disposed_id_no }}</li>
                                    <li><strong>Equipment Name:</strong> {{ $equipment->name }}</li>
                                    <li><strong>Equipment Code:</strong> {{ $equipment->code }}</li>
                                    <li><strong>Recieved By:</strong> {{ $recievedBy }}</li>
                                    <li><strong>Remarks:</strong> {{ $remarks }}</li>
                                    <li><strong>Disposed Date:</strong> {{ $disposed_date }}</li>
                                    <li><strong>Equipment Status:</strong> {{ $equipment->status }}</li>
                                </ul>

                                <!-- Submit and Cancel Buttons -->
                                <form action="{{ route('disposed-equipment-post', $equipment->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="disposed_id_no" value="{{ $disposed_id_no }}">
                                    <input type="hidden" name="remarks" value="{{ $remarks }}">
                                    <input type="hidden" name="disposed_date" value="{{ $disposed_date }}">
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

    @include('templates.footer_inc')
</main>
@include('templates.footer')
