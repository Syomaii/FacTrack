@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Donated Equipments</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Reports</li>
                <li>-</li>
                <li class="fw-medium">Donated Items</li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                    <button type="button" id="editButton"
                        class="btn btn-sm btn-success radius-8 d-inline-flex align-items-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#editDateRangeModal">
                        <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon> Edit Date Range
                    </button>

                    <button type="button" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1"
                        onclick="printInvoice()">
                        <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                        Print
                    </button>
                </div>
            </div>

            <div class="card-body py-40">
                <div class="row justify-content-center" id="invoice">
                    <div class="col-lg-8">
                        <div class="shadow-4 border radius-8">
                            <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                <div>
                                    <h3 class="text-xl">Donated Equipment Report</h3>
                                    <p class="mb-1 text-sm">Date Issued: {{ now()->format('Y-m-d') }}</p>
                                </div>
                                <div>
                                    <img src="/assets/images/logo.png" alt="University Logo" class="mb-8">
                                    <p class="mb-1 text-sm">University of Cebu Lapu-lapu and Mandaue</p>
                                    <p class="mb-1 text-sm">A.C. Cortes Ave., Mandaue City, Cebu, 6014</p>
                                    <p class="mb-0 text-sm">{{ auth()->user()->email }},
                                        {{ auth()->user()->mobile_no }}
                                    </p>
                                </div>
                            </div>

                            <div class="py-28 px-20">
                                <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                    <div>
                                        <h6 class="text-md">Donor Information:</h6>
                                        <table class="text-sm text-secondary-light">
                                            <tbody>
                                                <tr>
                                                    <td>Name</td>
                                                    <td class="ps-8">: {{ ucwords(auth()->user()->firstname) }}
                                                        {{ ucwords(auth()->user()->lastname) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td class="ps-8">: 6014, UCLM, CCS, Computer Lab 1</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td class="ps-8">: {{ auth()->user()->mobile_no }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <table class="text-sm text-secondary-light">
                                            <tbody>
                                                <tr>
                                                    <td>Issue Date</td>
                                                    <td class="ps-8">: {{ now()->format('Y-m-d') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order ID</td>
                                                    <td class="ps-8">: N/A</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-24">
                                    <div class="table-responsive scroll-sm">
                                        @if ($reportData->isNotEmpty())
                                            <table class="table bordered-table text-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-sm">Equipment ID</th>
                                                        <th scope="col" class="text-sm">Equipment Name</th>
                                                        <th scope="col" class="text-sm">Quantity</th>
                                                        <th scope="col" class="text-sm">Date Donated</th>
                                                        <th scope="col" class="text-sm">Condition</th>
                                                        <th scope="col" class="text-sm">Recipient</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="donatedEquipmentsTable">
                                                    @foreach ($reportData as $brand => $equipments)
                                                        @foreach ($equipments as $data)
                                                            <tr>
                                                                <!-- Equipment ID -->
                                                                <td>{{ $data['equipment_id'] }}</td>

                                                                <!-- Equipment Name -->
                                                                <td>{{ strtoupper($data['equipment_name']) }}</td>

                                                                <!-- Quantity -->
                                                                <td>{{ $data['quantity'] }}</td>

                                                                <!-- Date Donated -->
                                                                <td>{{ $data['donated_date'] }}</td>

                                                                <!-- Condition -->
                                                                <td>{{ $data['condition'] }}</td>

                                                                <!-- Recipient -->
                                                                <td>{{ $data['recipient'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-center text-secondary-light text-sm fw-semibold">No donated
                                                equipment found.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-64">
                                    <p class="text-center text-secondary-light text-sm fw-semibold" id="end-of-report">
                                        End of Report
                                    </p>
                                </div>

                                <div
                                    class="d-flex flex-wrap justify-content-between align-items-end mt-64 signature-container">
                                    <div class="text-sm border-top d-inline-block px-12" id="technician-signature">
                                        Signature of Technician</div>
                                    <div class="text-sm border-top d-inline-block px-12" id="supervisor-signature">
                                        Signature of Supervisor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Date Range Modal -->
        <div class="modal fade" id="editDateRangeModal" tabindex="-1" aria-labelledby="editDateRangeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDateRangeModalLabel">Set Date Range</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="dateRangeForm">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('templates.footer_inc')
</main>
@include('templates.footer')

<script>
    document.getElementById('dateRangeForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        if (startDate > endDate) {
            alert('Start date must not be later than end date.');
            return;
        }

        fetch(
                `/donated-equipment-reports?start=${encodeURIComponent(startDate)}&end=${encodeURIComponent(endDate)}`
            )
            .then(response => response.json())
            .then(data => {
                updateEquipmentTable(data);
                var modal = bootstrap.Modal.getInstance(document.getElementById('editDateRangeModal'));
                modal.hide();
            })
            .catch(error => {
                alert('An error occurred while fetching data.');
            });
    });

    function updateEquipmentTable(data) {
        var tableBody = document.getElementById('donatedEquipmentsTable');
        tableBody.innerHTML = ''; // Clear previous data

        if (Array.isArray(data) && data.length) {
            data.forEach(item => {
                // Ensure item is valid
                if (item) {
                    var equipmentId = item.equipment_id || 'N/A';
                    var equipmentName = item.equipment_name ? item.equipment_name.toUpperCase() : 'N/A';
                    var quantity = item.quantity != null ? item.quantity : 'N/A';
                    var donatedDate = item.donated_date != null ? item.donated_date : 'N/A';
                    var condition = item.condition != null ? item.condition : 'N/A';
                    var recipient = item.recipient != null ? item.recipient : 'N/A';

                    var row = `<tr>
                     <td>${equipmentId}</td>
                        <td>${equipmentName}</td>
                        <td>${quantity}</td>
                        <td>${donatedDate}</td>
                        <td>${condition}</td>
                        <td>${recipient}</td>
                    </tr>`;

                    tableBody.innerHTML += row;
                } else {
                    console.warn("Item is missing equipment:", item);
                }
            });
        } else {
            tableBody.innerHTML =
                `<tr><td colspan="6" class="text-center text-secondary-light text-sm fw-semibold">No data found.</td></tr>`;
        }
    }

    function printInvoice() {
        // Get the content to print
        var contentToPrint = document.getElementById("invoice").innerHTML;

        // Create a new window for printing
        var printWindow = window.open('', '', 'height=600,width=800');

        // Write the content to the new window
        printWindow.document.write('<html><head><title>Reports and Summary</title>');

        // Add print styles
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
        printWindow.document.write('.chart-container { display: block; margin-bottom: 20px; }');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
        printWindow.document.write('th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }');
        printWindow.document.write('@page { margin: 20mm; }');
        printWindow.document.write('@media print { #printButton { display: none; } }');

        printWindow.document.write(
            '@media print { h6.text-md { font-size: 18px; font-weight: bold; } }');
        printWindow.document.write(
            '@media print { #end-of-report { text-align: center; font-size: 12px; font-weight: bold; display: block; margin: 25px 0; } }'
        );
        printWindow.document.write(
            '@media print { .signature-container { display: flex; justify-content: space-between; } }');
        printWindow.document.write(
            '@media print { #technician-signature { font-size: 12px; font-weight: bold; margin: 20px 0; } }'
        );
        printWindow.document.write(
            '@media print { #supervisor-signature { font-size: 12px; font-weight: bold; margin: 20px 0; } }');
        printWindow.document.write('</style>');

        printWindow.document.write('</head><body>');

        printWindow.document.write(contentToPrint);
        printWindow.document.write('</body></html>');

        // Close the document and trigger print
        printWindow.document.close();
        printWindow.print();
    }
</script>
