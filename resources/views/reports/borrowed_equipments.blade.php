    @include('templates.header')
    <x-sidebar />

    <main class="dashboard-main">
        <x-navbar />

        <div class="dashboard-main-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Borrowed Equipments</h6>
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
                    <li class="fw-medium">Borrowed Items</li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                        <a href="{{ route('reports.edit') }}"
                            class="btn btn-sm btn-success radius-8 d-inline-flex align-items-center gap-1">
                            <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon> Edit
                        </a>

                        <a href="javascript:void(0)" onclick="downloadInvoice()"
                            class="btn btn-sm btn-warning radius-8 d-inline-flex align-items-center gap-1">
                            <iconify-icon icon="solar:download-linear" class="text-xl"></iconify-icon>
                            Download
                        </a>


                        <button type="button"
                            class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1"
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
                                        <h3 class="text-xl">Borrowed Equipment Report</h3>
                                        <p class="mb-1 text-sm">Date Issued: {{ now()->format('Y-m-d') }}</p>
                                    </div>
                                    <div>
                                        <img src="assets/images/logo1.png" alt="University Logo" class="mb-8">
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
                                            <h6 class="text-md">Report Details:</h6>
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
                                            @if ($borrowedEquipments->isNotEmpty())
                                                <table class="table bordered-table text-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-sm">Equipment ID</th>
                                                            <th scope="col" class="text-sm">Equipment Name</th>
                                                            <th scope="col" class="text-sm">Quantity</th>
                                                            <th scope="col" class="text-sm">Date Borrowed</th>
                                                            <th scope="col" class="text-sm">Date Returned</th>
                                                            <th scope="col" class="text-end text-sm">Times Borrowed
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($borrowedEquipments as $model => $equipments)
                                                            @foreach ($equipments as $equipment)
                                                                <tr>
                                                                    <!-- Equipment ID -->
                                                                    <td>{{ $equipment->id }}</td>

                                                                    <!-- Equipment Name -->
                                                                    <td>{{ $equipment->name }}</td>

                                                                    <!-- Total Quantity from borrows -->
                                                                    <td>{{ $borrowedEquipments->where('model', $equipment->model)->first()->total_quantity ?? 'N/A' }}
                                                                    </td>

                                                                    <!-- Date Borrowed -->
                                                                    <td>{{ optional($equipment->borrows->first())->date_borrowed ?? 'N/A' }}
                                                                    </td>

                                                                    <!-- Date Returned -->
                                                                    <td>{{ optional($equipment->borrows->last())->date_returned ?? 'N/A' }}
                                                                    </td>

                                                                    <!-- Times Borrowed -->
                                                                    <td class="text-end">
                                                                        {{ $equipment->borrows->count() }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach

                                                    </tbody>

                                                </table>
                                            @else
                                                <p class="text-center text-secondary-light text-sm fw-semibold">No
                                                    borrowed
                                                    equipment found.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-64">
                                        <p class="text-center text-secondary-light text-sm fw-semibold">End of Report
                                        </p>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between align-items-end mt-64">
                                        <div class="text-sm border-top d-inline-block px-12">Signature of Borrower</div>
                                        <div class="text-sm border-top d-inline-block px-12">Signature of Authorized
                                            Person
                                        </div>
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

    <script>
        function printInvoice() {
            var printContents = document.getElementById('invoice').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        function downloadInvoice() {
            var element = document.getElementById('invoice');

            var opt = {
                margin: 0.5,
                filename: 'Borrowed_Equipment_Report.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'landscape'
                }
            };

            // Convert and download the PDF
            html2pdf().set(opt).from(element).save();
        }
    </script>
