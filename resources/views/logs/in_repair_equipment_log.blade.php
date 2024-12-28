@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">In Repair Equipment Log</h6>
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
                    <form class="navbar-search d-flex align-items-center flex-grow-1" method="GET"
                        action="{{ route('in_repair_search') }}">
                        <input type="text" class="bg-base h-40-px w-auto" name="search" id="inMaintenanceSearch"
                            placeholder="Search" value="{{ request('search') }}">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </form>
                </div>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Equipment ID</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Issue</th>
                                <th scope="col">Action Taken</th>
                                <th scope="col">Recommendations</th>
                                <th scope="col">Technician</th>
                                <th scope="col">Repaired Date</th>
                                <th scope="col">Returned Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($repair as $log)
                                <tr class="reservation-row">
                                    <td>{{ $log->equipment->id }}</td>
                                    <td>{{ $log->remarks }}</td>
                                    <td>{{ $log->issue }}</td>
                                    <td>{{ $log->action_taken ? $log->action_taken : 'N/A' }}</td>
                                    <td>{{ $log->recommendations ? $log->recommendations : 'N/A' }}</td>
                                    <td>{{ $log->technician ? $log->technician : 'N/A' }}</td>
                                    <td>{{ $log->repaired_date ? $log->repaired_date : 'Not Yet Repaired' }}</td>
                                    <td>{{ $log->returned_date ? $log->returned_date : 'Not Yet Returned' }}</td>
                                    <td>{{ ucwords($log->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8 " class="text-center">No repair logs at the moment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                    <span>Showing {{ $repair->firstItem() }} to {{ $repair->lastItem() }} of
                        {{ $repair->total() }} entries</span>

                    @if ($repair->total() > 0)
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                    href="{{ $repair->previousPageUrl() }}"
                                    aria-disabled="{{ $repair->onFirstPage() }}">
                                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                </a>
                            </li>

                            <!-- Pagination Pages -->
                            @if ($repair->lastPage() > 1)
                                @if ($reapair->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $reapair->url(1) }}">1</a>
                                    </li>
                                    @if ($reapair->currentPage() > 4)
                                        <li class="page-item">...</li>
                                    @endif
                                @endif

                                @for ($i = max(1, $reapair->currentPage() - 1); $i <= min($reapair->lastPage(), $reapair->currentPage() + 1); $i++)
                                    <li class="page-item">
                                        <a class="page-link {{ $i === $reapair->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-300 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $reapair->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($reapair->currentPage() < $reapair->lastPage() - 2)
                                    @if ($reapair->currentPage() < $reapair->lastPage() - 3)
                                        <li class="page-item">...</li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $reapair->url($reapair->lastPage()) }}">{{ $reapair->lastPage() }}</a>
                                    </li>
                                @endif
                            @else
                                <span>Page 1</span>
                            @endif

                            <!-- Next Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                    href="{{ $repair->nextPageUrl() }}">
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
