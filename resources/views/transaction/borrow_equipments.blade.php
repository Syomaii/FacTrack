@include('templates.header')
<style>
    .suggestions-list {
        position: absolute;
        border: 1px solid #ddd;
        background: #fff;
        width: 100%;
        max-height: 150px;
        overflow-y: auto;
        z-index: 1000;
    }
    .suggestion-item {
        padding: 8px;
        cursor: pointer;
    }
    .suggestion-item:hover {
        background-color: #f0f0f0;
    }

</style>
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Borrow Equipment</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
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
                    <iconify-icon icon="codicon:error" class="icon text-xl"></iconify-icon>
                    {{ session('borrowEquipmentSuccessfully') }}
                </div>
            </div>
        @endif
        @if ($errors->has('msg'))
            <div
                class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="codicon:error" class="icon text-xl"></iconify-icon>
                    {{ $errors->first('msg') }}
                </div>
            </div>
        @endif

        <div class="card h-100% p-0 radius-12">
            <div class="card-body p-24">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-xl-8 col-lg-10">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <form action="{{ url('/borrow-equipment/{code}') }}" method="post"
                                    id="borrowEquipmentForm">
                                    @csrf
                                    
                                    <input type="hidden" name="borrowed_date"
                                        value="{{ now()->format('Y-m-d\TH:i') }}">
                                    <input type="hidden" name="borrowed_date" value="{{ now()->format('Y-m-d\TH:i') }}">
                                    <input type="hidden" name="borrower_code" id="borrower_code">
                                    
                                    <!-- Borrower's ID Number -->
                                    <div class="mb-3 position-relative">
                                        <label for="borrowers_id_no" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Borrower's ID
                                        </label>
                                        <input type="text" class="form-control radius-8" id="borrowers_id_no" name="borrowers_id_no"
                                               placeholder="Enter Borrower's ID" autocomplete="off" autofocus>
                                        <!-- Suggestions dropdown -->
                                        <div id="idSuggestions" class="position-absolute bg-white border rounded mt-1 w-100" style="z-index: 1000; display: none; max-height: 200px; overflow-y: auto;"></div>
                                    </div>
                                    
                                    <!-- Borrower's Name -->
                                    <div class="mb-3">
                                        <label for="borrowers_name"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Borrower's
                                            Name</label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('borrowers_name') ? 'is-invalid' : '' }}"
                                            id="borrowers_name" name="borrowers_name"
                                            placeholder="Enter Borrower's Name" value="{{ old('borrowers_name') }}">
                                        <small class="text-danger">{{ $errors->first('borrowers_name') }}</small>
                                    </div>

                                    <!-- Department -->
                                    <div class="mb-3">
                                        <label for="department"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Course/Department</label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('department') ? 'is-invalid' : '' }}"
                                            id="department" name="department"
                                            placeholder="Course/Department" value="{{ old('department') }}">
                                        <small class="text-danger">{{ $errors->first('department') }}</small>
                                    </div>

                                    <!-- Purpose of borrowing -->
                                    <div class="mb-3">
                                        <label for="purpose"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Purpose</label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('purpose') ? 'is-invalid' : '' }}"
                                            id="purpose" name="purpose"
                                            placeholder="Purpose of Borrowing" value="{{ old('purpose') }}">
                                        <small class="text-danger">{{ $errors->first('purpose') }}</small>
                                    </div>

                                    <!-- Expected Return Date -->
                                    <div class="mb-3">
                                        <label for="expected_return_date"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Expected
                                            Return Date</label>
                                        <input type="datetime-local"
                                            class="form-control radius-8 {{ $errors->has('expected_return_date') ? 'is-invalid' : '' }}"
                                            id="expected_return_date" name="expected_return_date"
                                            value="{{ old('expected_return_date') }}">
                                        <small class="text-danger">{{ $errors->first('expected_return_date') }}</small>
                                    </div>

                                    <!-- Scan Button Triggering Modal -->
                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-primary px-5 py-2" data-bs-toggle="modal"
                                            data-bs-target="#scanModalBorrow" id="scanCodeBorrow">
                                            Scan QR Code
                                        </button>
                                        <a href="/equipments" class="btn btn-outline-danger px-5 py-2">Cancel</a>
                                    </div>

                                    <div class="modal fade" id="scanModalBorrow" tabindex="-1"
                                        aria-labelledby="scanModalBorrowLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered ">
                                            <div class="modal-content background-color-blue">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scanModalBorrowLabel">Borrow Equipment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="previewBorrow"
                                                        class="display-flex align-items-center justify-content-center scan-code"
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
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')

<script>
    let scanner;

    function startScanner() {
        const previewElement = document.getElementById('preview'); 
        scanner = new QrScanner(previewElement, result => {
            scanner.stop();

            $.ajax({
                url: '/validate-equipment-status',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", 
                    code: result 
                },
                success: function(response) {
                    if (response.available) {
                        document.getElementById('borrower_code').value =
                            result; 
                        $('#scanModal').modal('hide'); 
                    } else {
                        alert('Error: This equipment is not available for borrowing.');
                        $('#scanModal').modal('hide'); 
                        startScanner(); 
                    }
                },
                error: function() {
                    alert('Error: Could not validate equipment status.');
                    startScanner(); 
                }
            });
        });
        scanner.start(); 
    }

    $(document).ready(function() {
        $('#scanCodeBorrow').on('click', function() {
            startScanner();
            $('#scanModalBorrow').modal('show');
        });

        $('#scanModalBorrow').on('hidden.bs.modal', function() {
            stopScanner();
        });

        $(window).on('beforeunload', function() {
            stopScanner();
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>
    function capitalizeFirstLetters(name) {
        return name
            .toLowerCase() // Convert the whole string to lowercase
            .split(' ') // Split the string into an array of words
            .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalize the first letter of each word
            .join(' '); // Join the words back into a string
    }

    $(document).ready(function() {
        var route = "{{ route('search.students') }}"; 

        let typingTimer; // Timer identifier
        const typingDelay = 500; // half second delay

        $('#borrowers_id_no').on('input', function() {
            clearTimeout(typingTimer); // Clear the timer on every input
            const query = $(this).val();

            // Reset input fields when no query
            if (query.length === 0) {
                $('#borrowers_name').val('').prop('readonly', false);
                $('#department').val('').prop('readonly', false);
                $('#idSuggestions').empty().hide();
                return; // Exit early
            }

            // Set a new timer to trigger the search after 2 seconds
            typingTimer = setTimeout(function() {
                if (query.length > 1) { // Check if the query is long enough
                    $.get(route, { id: query }, function(data) {
                        $('#idSuggestions').empty().hide(); // Reset suggestions

                        if (data.length) {
                            data.forEach(function(item) {
                                $('#idSuggestions').append('<div class="suggestion-item">' + item + '</div>');
                            });
                            $('#idSuggestions').show();
                        }
                    });
                }
            }, typingDelay);
        });

        $(document).on('click', '.suggestion-item', function() {
            var selectedId = $(this).text();
            $('#borrowers_id_no').val(selectedId); 

            $.ajax({
                url: '/get-student-details/' + selectedId,
                type: 'GET',
                success: function(data) {
                    if (data.error) {
                        alert(data.error); 
                    } else {
                        var fullName = data.firstname + ' ' + data.lastname; 
                        var formattedName = capitalizeFirstLetters(fullName); 
                        $('#borrowers_name').val(formattedName).prop('readonly', true);
                        $('#department').val(data.department).prop('readonly', true); 
                    }
                },
                error: function() {
                    alert('Error fetching student details.'); 
                }
            });

            $('#idSuggestions').empty().hide(); 
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('#idSuggestions, #borrowers_id_no').length) {
                $('#idSuggestions').hide(); 
            }
        });
    });




</script>
