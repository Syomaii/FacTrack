<style>

    #infoModal {
        display: none; 
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); 
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow-y: auto; 
    }
    
    .modal-content {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        max-width: 800px;
        width: 90%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        animation: fadeIn 0.3s ease-in-out;
        position: relative; 
    }
    
    .modal-content .close {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 24px;
        color: #333;
        background: none;
        border: none;
        cursor: pointer;
    }
    
    .modal-content h5 {
        font-size: 1.2em;
        margin-top: 15px;
        color: #333;
    }
    
    .modal-content p {
        font-size: 0.95em;
        color: #555;
    }
    
    .modal-content img {
        width: 100%;
        height: auto;
        margin: 15px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    </style>
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
                    <li class="fw-medium">-</li>
                    <li class="fw-medium">
                        <a href="{{ route('view-faculties') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                            Faculties
                        </a>
                    </li>
                    <li class="fw-medium">-</li>
                    <li class="fw-medium">Import File</li>
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
    
    
            {{-- @if (session()->has('failures'))
                <!-- Debug output -->
                
            @endif --}}
    
            <div class="card h-100 p-0 radius-12">
                <div
                    class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <h5 class="mb-0">Import Excel File for Faculty List 
                        <button type="button" class="tooltip-button text-primary-600 magnefic-photo" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" data-bs-placement="right" id="openModalButton"><iconify-icon icon="mdi:question-mark-circle-outline" class="icon text-md opacity-75 text-primary-light"></iconify-icon> </button> 
                        <div class="my-tooltip tip-content hidden text-start shadow">
                            <h6 class="text-white text-sm mt-3">Excel Format</h6>
                            <p class="text-white">Click to view format</p>
                        </div>
                    </h5>
                </div>
                
                <div id="infoModal" class="modal hidden mb-5">
                    <div class="modal-content ">
                        <span class="close cursor-pointer">&times;</span>
                        <h5>Excel Format Instructions</h5>
                        <p>Ensure your Excel file matches the required format to avoid errors before uploading.</p>
                        <h5>Faculty list</h5>
                        <img src="/images/excel-format-faculty.png" alt="">
                    </div>
                </div>
    
                <div class="card-body">
                    <form action="{{ route('import.file') }}" method="POST" enctype="multipart/form-data" class="p-3">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label fw-semibold">Select File (XLSX/XLS)</label>
                            <input type="file" name="file" id="file"
                                class="form-control @error('file') is-invalid @enderror" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (auth()->user()->type === 'admin')
                            <div class="form-group mb-3 col-md-12">
                                <label for="department" class="form-label fw-semibold">Select
                                    Department</label>
                                <select class="form-control radius-8" id="department" name="department">
                                    <option value="" disabled selected>Select a Department</option>
                                    @foreach ($offices as $office)
                                        @if ($office->type == 'department')
                                            <!-- Adjusted condition -->
                                            <option value="{{ $office->name }}">{{ $office->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <button type="button" class="btn btn-primary w-100" id="previewBtn">Preview</button>
                        <button type="submit" class="btn btn-success w-100 mt-3" id="submitBtn" style="display: none;"
                            disabled>Confirm and Submit</button>
                    </form>
                </div>
    
                <div class="dashboard-main-body pt-4" style="display: none" id="previewTable">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">ID No.</th>
                                    <th scope="col">Lastname</th>
                                    <th scope="col">Firstname</th>
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
    
            if (file && (file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || file
                    .type === 'application/vnd.ms-excel')) {
                var reader = new FileReader();
    
                reader.onload = function(e) {
                    var data = new Uint8Array(e.target.result);
                    var workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    var sheetData = XLSX.utils.sheet_to_json(firstSheet, {
                        header: 1
                    });
    
                    // Clear previous table content
                    var tableBody = document.querySelector('table tbody');
                    tableBody.innerHTML = "";
    
                    // Process headers and rows for display
                    var headers = sheetData[0];
                    sheetData.slice(1).forEach(function(row) {
                        var newRow = document.createElement('tr');
    
                        headers.forEach((header, index) => {
                            var cell = document.createElement('td');
                            cell.textContent = row[index] ||
                                ''; // Fallback to empty if cell data is missing
                            newRow.appendChild(cell);
                        });
    
                        tableBody.appendChild(newRow);
                    });
    
                    // Enable and display the submit button after preview
                    var submitBtn = document.getElementById('submitBtn');
                    var previewTable = document.getElementById('previewTable');
                    submitBtn.style.display = 'block';
                    previewTable.style.display = 'block';
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
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]'); 
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl)); 
    
        // Boxed Tooltip
        $(document).ready(function() {
            $('.tooltip-button').each(function () {
                var tooltipButton = $(this);
                var tooltipContent = $(this).siblings('.my-tooltip').html(); 
        
                // Initialize the tooltip
                tooltipButton.tooltip({
                    title: tooltipContent,
                    trigger: 'hover',
                    html: true
                });
        
                // Optionally, reinitialize the tooltip if the content might change dynamically
                tooltipButton.on('mouseenter', function() {
                    tooltipButton.tooltip('dispose').tooltip({
                        title: tooltipContent,
                        trigger: 'hover',
                        html: true
                    }).tooltip('show');
                });
            });
        });
    
    </script>
    <script>
        $(document).ready(function () {
            const $modal = $('#infoModal').hide();
    
            // Open the modal
            $('#openModalButton').on('click', function () {
                $modal.show();
            });
    
            // Close the modal
            $modal.find('.close').on('click', function () {
                $modal.hide();
            });
    
            // Close the modal when clicking outside of it
            $(window).on('click', function (event) {
                if ($(event.target).is($modal)) {
                    $modal.hide();
                }
            });
        });
    </script>