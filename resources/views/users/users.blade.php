@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Users</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('users') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Users
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
        @elseif (session('deleteEquipmentSuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('deleteEquipmentSuccessfully') }}
                </div>
            </div>
        @endif

        <div class="card h-100 p-0 radius-12">
            <div
                class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <form class="navbar-search" method="GET" action="{{ route('search-user') }}">
                        <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search"
                            value="{{ request('search') }}">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </form>
                    <select name="status" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                        <option value="">Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>
                <a href="/add-user"
                    class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                    Add New User
                </a>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Office</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Role</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr data-status="{{ strtolower($user->status) }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->image }}" alt=""
                                                class="flex-shrink-0 me-12 radius-8" width="50">
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                            {{ ucwords($user->firstname) }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ ucwords($user->lastname) }}
                                        </h6>
                                    </td>
                                    <td>
                                        <span
                                            class="text-md mb-0 fw-normal text-secondary-light">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-md mb-0 fw-normal text-secondary-light">{{ $user->mobile_no }}</span>
                                    </td>
                                    <td>
                                        {{ ucwords($user->office) ? ucwords($user->office->name) : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ ucwords($user->designation) ? ucwords($user->designation->name) : 'N/A' }}
                                    </td>
                                    <td>{{ ucwords($user->type) }}</td>
                                    <td class="text-center">
                                        <span class="{{ $user->status == 'inactive' ? 'bg-danger text-white border border-danger-main' : 'bg-success-focus border border-success-main' }} px-24 py-4 radius-4 fw-medium text-sm">
                                            {{ ucwords($user->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('profile', ['id' => $user->id]) }}">
                                                <button type="button"
                                                    class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line"
                                                        class="icon text-xl"></iconify-icon>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                    <div id="no-users-message" class="text-center" style="display: none;">
                                        <strong class="text-center p-3" style="font-size: 20px">No users found with the
                                            selected status.</strong>
                                    </div>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No users found from your office/department.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($totalUsers > 0)
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                        <span>Showing {{ $start }} to {{ $end }} of {{ $totalUsers }}
                            entries</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                                    href="{{ $users->previousPageUrl() }}" aria-disabled="{{ $users->onFirstPage() }}">
                                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                </a>
                            </li>
                        
                            <!-- Pagination Pages -->
                            @if ($users->lastPage() > 1)
                                <!-- Show first page if not too close to current -->
                                @if ($users->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $users->url(1) }}">1</a>
                                    </li>
                                    @if ($users->currentPage() > 4)
                                        <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                    @endif
                                @endif

                                @for ($i = max(1, $users->currentPage() - 1); $i <= min($users->lastPage(), $users->currentPage() + 1); $i++)
                                    <li class="page-item">
                                        <a class="page-link {{ $i === $users->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-300 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $users->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($users->currentPage() < $users->lastPage() - 2)
                                    @if ($users->currentPage() < $users->lastPage() - 3)
                                        <li class="page-item">...</li> <!-- Ellipsis for skipped pages -->
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                                            href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a>
                                    </li>
                                @endif
                            @else   
                                    
                            @endif
                        
                            <!-- Next Page Link -->
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                                    href="{{ $users->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const userRows = document.querySelectorAll('tbody tr');
        const noUsersMessage = document.getElementById('no-users-message');

        statusSelect.addEventListener('change', function() {
            const selectedStatus = this.value.toLowerCase();
            let hasVisibleUsers = false; // Flag to check if there are visible users

            userRows.forEach(row => {
                const userStatus = row.getAttribute('data-status');

                if (selectedStatus === '' || userStatus === selectedStatus) {
                    row.style.display = ''; // Show the row
                    hasVisibleUsers = true; // Set flag to true if a user is visible
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });

            // Show the no users message if no users are visible
            if (!hasVisibleUsers) {
                noUsersMessage.style.display = 'block'; // Show message if no users are visible
            } else {
                noUsersMessage.style.display = 'none'; // Hide message if users are visible
            }
        });
    });
</script>
