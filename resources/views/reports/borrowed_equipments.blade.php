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
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary-600 radius-8 d-inline-flex align-items-center gap-1">
                        <iconify-icon icon="pepicons-pencil:paper-plane" class="text-xl"></iconify-icon>
                        Send
                    </a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-warning radius-8 d-inline-flex align-items-center gap-1">
                        <iconify-icon icon="solar:download-linear" class="text-xl"></iconify-icon>
                        Download
                    </a>
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
                                    <h3 class="text-xl">Borrowed Equipment Report</h3>
                                    <p class="mb-1 text-sm">Date Issued: {{ now()->format('Y-m-d') }}</p>
                                </div>
                                <div>
                                    <img src="assets/images/logo1.png" alt="University Logo" class="mb-8">
                                    <p class="mb-1 text-sm">University of Cebu Lapu-lapu and Mandaue</p>
                                    <p class="mb-1 text-sm">A.C. Cortes Ave., Mandaue City, Cebu, 6014</p>
                                    <p class="mb-0 text-sm">{{ auth()->user()->email }}, {{ auth()->user()->mobile_no }}</p>
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
                                                    <td class="ps-8">: {{ ucwords(auth()->user()->firstname) }} {{ ucwords(auth()->user()->lastname) }}</td>
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
                                        <table class="table bordered-table text-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-sm">Equipment ID</th>
                                                    <th scope="col" class="text-sm">Equipment Name</th>
                                                    <th scope="col" class="text-sm">Quantity</th>
                                                    <th scope="col" class="text-sm">Date Borrowed</th>
                                                    <th scope="col" class="text-sm">Date Returned</th>
                                                    <th scope="col" class="text-end text-sm">Times Borrowed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>01</td>
                                                    <td>Projector</td>
                                                    <td>2</td>
                                                    <td>2024-10-15</td>
                                                    <td>2024-10-22</td>
                                                    <td class="text-end">3</td>
                                                </tr>
                                                <tr>
                                                    <td>02</td>
                                                    <td>Laptop</td>
                                                    <td>1</td>
                                                    <td>2024-10-16</td>
                                                    <td>N/A</td>
                                                    <td class="text-end">5</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-64">
                                    <p class="text-center text-secondary-light text-sm fw-semibold">End of Report</p>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between align-items-end mt-64">
                                    <div class="text-sm border-top d-inline-block px-12">Signature of Borrower</div>
                                    <div class="text-sm border-top d-inline-block px-12">Signature of Authorized Person</div>
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
