@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Facility Reservation Log</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="/dashboard" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
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
        <div class="card h-100 p-0 radius-12">
            <div
                class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <form class="navbar-search d-flex align-items-center flex-grow-1">
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
                                <th scope="col">Reservers ID</th>
                                <th scope="col">Reservers Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Facility Name</th>
                                <th scope="col">Reservation Date</th>
                                <th scope="col">Time In</th>
                                <th scope="col">Time Out</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservations as $reservation)
                                <tr class="reservation-row">
                                    <td>{{ $reservation->reservers_id_no }}</td>
                                    <td>
                                        @if ($reservation->student)
                                            {{ ucwords($reservation->student->firstname) }}
                                            {{ ucwords($reservation->student->lastname) }}
                                        @elseif($reservation->faculty)
                                            {{ ucwords($reservation->facult->firstname) }}
                                            {{ ucwords($reservation->faculty->lastname) }}
                                        @else
                                            <span class="text-danger">Reserver Not Found</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($reservation->offices)
                                            {{ ucwords($reservation->offices->name) }}
                                            <!-- Displaying the office name -->
                                        @else
                                            <span class="text-danger">Office Not Found</span>
                                        @endif
                                    </td>
                                    <td>{{ ucwords($reservation->facility->name) }}</td>
                                    <td>{{ $reservation->reservation_date }}</td>
                                    <td>{{ $reservation->time_in }}</td>
                                    <td>{{ $reservation->time_out }}</td>
                                    <td>{{ ucwords($reservation->status) }}</td>
                                    <td>
                                        <a href="{{ route('facility_reservation_log', $reservation->id) }}"
                                            class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center view-equipment">
                                            <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No reservations at the moment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt -24">
                    <span>Showing {{ $reservations->firstItem() }} to {{ $reservations->lastItem() }} of
                        {{ $reservations->total() }} entries</span>

                    @if ($reservations->total() > 0)
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                    href="{{ $reservations->previousPageUrl() }}"
                                    aria-disabled="{{ $reservations->onFirstPage() }}">
                                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                </a>
                            </li>

                            <!-- Pagination Pages -->
                            @if ($reservations->lastPage() > 1)
                                @if ($reservations->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $reservations->url(1) }}">1</a>
                                    </li>
                                    @if ($reservations->currentPage() > 4)
                                        <li class="page-item">...</li>
                                    @endif
                                @endif

                                @for ($i = max(1, $reservations->currentPage() - 1); $i <= min($reservations->lastPage(), $reservations->currentPage() + 1); $i++)
                                    <li class="page-item">
                                        <a class="page-link {{ $i === $reservations->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-300 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $reservations->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($reservations->currentPage() < $reservations->lastPage() - 2)
                                    @if ($reservations->currentPage() < $reservations->lastPage() - 3)
                                        <li class="page-item">...</li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $reservations->url($reservations->lastPage()) }}">{{ $reservations->lastPage() }}</a>
                                    </li>
                                @endif
                            @else
                                <span>Page 1</span>
                            @endif

                            <!-- Next Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                    href="{{ $reservations->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    @else
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
        let rows = document.querySelectorAll('.reservation-row');

        rows.forEach(function(row) {
            let name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            let department = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            let facilityName = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            if (name.includes(filter) || department.includes(filter) || facilityName.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
