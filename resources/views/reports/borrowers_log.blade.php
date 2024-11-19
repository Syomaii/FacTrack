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
                <a href="{{ route('borrowersLog') }}">Borrower's Log</a>
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
                    <form class="navbar-search">
                        <input type="text" class="bg-base h-40-px w-auto" name="search" id="borrowerSearch"
                            placeholder="Search">
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
                                <th scope="col">Returned Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($borrows as $borrow)
                                <tr class="borrower-row">
                                    <td>{{ $borrow->borrowers_id_no }}</td>
                                    <td>{{ ucwords($borrow->borrowers_name) }}</td>
                                    <td>{{ ucwords($borrow->department) }}</td>
                                    <td>{{ ucwords($borrow->equipment->name) }}
                                        ({{ ucwords($borrow->equipment->brand) }})
                                    </td>
                                    <td>{{ $borrow->borrowed_date }}</td>
                                    <td>{{ $borrow->returned_date ? $borrow->returned_date : 'Not Yet Returned' }}
                                    </td>
                                    <td>{{ $borrow->status }}</td>
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
                    <span>Showing {{ $borrows->firstItem() }} to {{ $borrows->lastItem() }} of
                        {{ $borrows->total() }} entries</span>

                    @if ($borrows->total() > 0)
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                    href="{{ $borrows->previousPageUrl() }}"
                                    aria-disabled="{{ $borrows->onFirstPage() }}">
                                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                </a>
                            </li>

                            <!-- Pagination Pages -->
                            @if ($borrows->lastPage() > 1)
                                <!-- Show first page if not too close to current -->
                                @if ($borrows->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $borrows->url(1) }}">1</a>
                                    </li>
                                    @if ($borrows->currentPage() > 4)
                                        <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                    @endif
                                @endif

                                @for ($i = max(1, $borrows->currentPage() - 1); $i <= min($borrows->lastPage(), $borrows->currentPage() + 1); $i++)
                                    <li class="page-item">
                                        <a class="page-link {{ $i === $borrows->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-300 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $borrows->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($borrows->currentPage() < $borrows->lastPage() - 2)
                                    @if ($borrows->currentPage() < $borrows->lastPage() - 3)
                                        <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $borrows->url($borrows->lastPage()) }}">{{ $borrows->lastPage() }}</a>
                                    </li>
                                @endif
                            @else
                                <!-- If there's only one page -->
                                <span>Page 1</span>
                            @endif

                            <!-- Next Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                    href="{{ $borrows->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    @else
                        <!-- Display message if no entries -->
                        <span>No entries found.</span>
                    @endif
                </div>


            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
<script>
    document.getElementById('borrowerSearch').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.borrower-row'); // Select all borrower rows

        rows.forEach(function(row) {
            // Get the text content of the relevant columns (borrower's name, department, and equipment name)
            let name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            let department = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            let equipmentName = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            // Check if the filter matches any of the fields
            if (name.includes(filter) || department.includes(filter) || equipmentName.includes(
                    filter)) {
                row.style.display = ''; // Show the row
            } else {
                row.style.display = 'none'; // Hide the row
            }
        });
    });
</script>
