@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Borrowers Log</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="/dashboard" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Borrowers Log</li>
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

        <div class="card h-100 p-0 radius-12">
            <div
                class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                    <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                    <form class="navbar-search">
                        <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </form>
                </div>

            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Borrowers ID</th>
                                <th scope="col">Borrower Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Equipment Name</th>
                                <th scope="col">Borrow Date</th>
                                <th scope="col">Return Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($borrows as $borrow)
                                <tr>
                                    <td>{{ $borrow->user->name }}</td>
                                    <td>{{ $borrow->equipment->name }}</td>
                                    <td>{{ $borrow->borrow_date->format('Y-m-d') }}</td>
                                    <td>{{ $borrow->return_date ? $borrow->return_date->format('Y-m-d') : 'Not Returned' }}
                                    </td>
                                    <td>{{ $borrow->status }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <button type="button"
                                                class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="majesticons:eye-line"
                                                    class="icon text-xl"></iconify-icon>
                                            </button>
                                            <button type="button"
                                                class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="fluent:delete-24-regular"
                                                    class="menu-icon"></iconify-icon>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No borrows at the moment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                    <span>Showing 1 to {{ $borrows->count() }} of {{ $borrows->total() }} entries</span>
                    {{ $borrows->links() }} <!-- For pagination -->
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
