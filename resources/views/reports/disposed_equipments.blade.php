@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Disposed Equipments</h6>
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
                <li class="fw-medium">Disposed Items</li>
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
                                    <h3 class="text-xl">Disposed Equipment Report</h3>
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
                                        <h6 class="text-md">Disposed Information:</h6>
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
                                                        <th scope="col" class="text-sm">Date Disposed</th>
                                                        <th scope="col" class="text-sm">Reason for Disposal</th>
                                                        <th scope="col" class="text-sm">Disposed By</th>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="disposedEquipmentsTable">
                                                    @foreach ($reportData as $model => $equipments)
                                                        @foreach ($equipments as $data)
                                                            <tr>
                                                                <!-- Equipment ID -->
                                                                <td>{{ $data['equipment_id'] }}</td>

                                                                <!-- Equipment Name -->
                                                                <td>{{ strtoupper($data['equipment_name']) }}</td>

                                                                <!-- Quantity of the Equipment -->
                                                                <td>{{ $data['quantity'] }}</td>

                                                                <!-- Date Disposed-->
                                                                <td>{{ $data['disposed_date'] }}</td>

                                                                <!-- Reason for Disposal -->
                                                                <td>{{ $data['remarks'] }}</td>

                                                                <!-- Disposed By -->
                                                                <td>{{ $data['user_name'] }}</td>

                                                            </tr>
                                                        @endforeach
                                                    @endforeach

                                                </tbody>

                                            </table>
                                        @else
                                            <p class="text-center text-secondary-light text-sm fw-semibold">No
                                                repaired
                                                equipment found.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-64">
                                    <p class="text-center text-secondary-light text-sm fw-semibold">End of Report
                                    </p>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between align-items-end mt-64">
                                    <div class="text-sm border-top d-inline-block px-12">Signature of Technician</div>
                                    <div class="text-sm border-top d-inline-block px-12">Signature of Supervisor
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
                `/disposed-equipment-reports?start=${encodeURIComponent(startDate)}&end=${encodeURIComponent(endDate)}`
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
        var tableBody = document.getElementById('disposedEquipmentsTable');
        tableBody.innerHTML = ''; // Clear previous data

        if (Array.isArray(data) && data.length) {
            data.forEach(item => {
                // Ensure item is valid
                if (item) {
                    var equipmentId = item.equipment_id || 'N/A';
                    var equipmentName = item.equipment_name ? item.equipment_name.toUpperCase() : 'N/A';
                    var quantity = item.quantity || 'N/A';
                    var disposedDate = item.disposed_date || 'N/A';
                    var remarks = item.remarks || 'N/A';
                    var userName = item.user_name || 'N/A';


                    var row = `<tr>
                    <td>${equipmentId}</td>
                    <td>${equipmentName}</td>
                    <td>${quantity}</td>
                    <td>${disposedDate}</td>
                    <td>${remarks}</td>
                    <td>${userName}</td>
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
        var printContents = document.getElementById('invoice').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
