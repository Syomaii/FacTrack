@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Students</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                        Students
                    </a>
                </li>
            </ul>
        </div>

        @if (session('success'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div
                class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:warning" class="icon text-xl"></iconify-icon>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div
                class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:warning" class="icon text-xl"></iconify-icon>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            </div>
        @endif

        @if (session()->has('failures'))
            <pre>{{ print_r(session('failures'), true) }}</pre> <!-- Debug output -->
            <table class="table table-danger">
                <thead>
                    <tr>
                        <th>Row</th>
                        <th>Attribute</th>
                        <th>Errors</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('failures') as $failure)
                        <tr>
                            <td>{{ $failure->row() }}</td>
                            <td>{{ $failure->attribute() }}</td>
                            <td>
                                <ul>
                                    @foreach ($failure->errors() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $failure->values()[$failure->attribute()] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="card h-100 p-0 radius-12">
            <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <h5 class="mb-0">Upload Student File</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('import.file') }}" method="POST" enctype="multipart/form-data" class="p-3">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Select File (CSV/XLSX)</label>
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-primary w-100" id="previewBtn">Preview</button>
                    <button type="submit" class="btn btn-success w-100 mt-3" id="submitBtn" style="display: none;" disabled>Confirm and Submit</button>
                </form>
            </div>

            <div class="dashboard-main-body pt-4">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">ID No.</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Course/Year</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @empty
                                <tr>
                                    <td colspan="10" class="text-center">No students found from your office/department.</td>
                                </tr>
                            @endforelse --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.getElementById('previewBtn').addEventListener('click', function() {
        var fileInput = document.getElementById('file');
        var file = fileInput.files[0];
        
        if (file && (file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || file.type === 'application/vnd.ms-excel')) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { type: 'array' });
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                var sheetData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
                
                // Clear previous table content
                var tableBody = document.querySelector('table tbody');
                tableBody.innerHTML = ""; 
                
                // Process headers and rows for display
                var headers = sheetData[0];
                sheetData.slice(1).forEach(function(row) {
                    var newRow = document.createElement('tr');
                    
                    headers.forEach((header, index) => {
                        var cell = document.createElement('td');
                        cell.textContent = row[index] || ''; // Fallback to empty if cell data is missing
                        newRow.appendChild(cell);
                    });
                    
                    tableBody.appendChild(newRow);
                });
                
                // Enable and display the submit button after preview
                var submitBtn = document.getElementById('submitBtn');
                submitBtn.style.display = 'block';
                submitBtn.disabled = false;

                var previewBtn = document.getElementById('previewBtn');
                previewBtn.style.display = 'none';
                previewBtn.disabled = true;
            };
            
            reader.readAsArrayBuffer(file);
        } else {
            alert('Please upload a valid Excel file (XLSX or XLS).');
        }
    });



</script>