@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Student Profile</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <a href="{{ redirect()->back() }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    Student Profile
                </a>
                <li>-</li>
                <li class="fw-medium">{{ $student->id_no }}</li>
            </ul>
        </div>
        @if (session('updateprofilesuccessfully'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('updateprofilesuccessfully') }}
                </div>
            </div>
        @endif
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="{{ asset('assets/images/user-grid/uc.jpg') }}" alt="" class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16 mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0 pt-5 mt-5">
                            <h6 class="mb-0 mt-16">{{ Str::title($student->firstname) }} {{ Str::title($student->lastname) }}</h6>
                            <span class="text-secondary-light mb-16">{{ $student->email }}</span>
                        </div>
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ Str::title($student->firstname) }}
                                        {{ Str::title($student->lastname) }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">ID Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $student->id_no }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Email</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $student->email }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Course / Year</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $student->course }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Department</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $student->department }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <h6 class="text-xl mb-16">Borrow History</h6>
                        
                        @forelse ($studentBorrowHistory as $borrowHistory)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item</th>
                                            <th scope="col">Borrow Date</th>
                                            <th scope="col">Return Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $borrowHistory->equipment->name }}</td>
                                            <td>{{ $borrowHistory->borrowed_date }}</td>
                                            <td>{{ $borrowHistory->returned_date ? $borrowHistory->returned_date : 'N/A' }}</td>
                                            <td>
                                                @if ($borrowHistory->equipment->status == 'Available')
                                                    <span class="badge bg-success">Returned</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @empty
                            <div class="d-flex justify-content-center align-items-center">
                                <strong class="text-s mb-16 text-center ">This student hasn't borrowed anything yet.</strong>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    @include('templates.footer_inc')
    @include('templates.footer')
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');

        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const passwordInput = document.querySelector(button.getAttribute(
                    'data-toggle'));
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' :
                    'password';
                passwordInput.setAttribute('type', type);
                button.classList.toggle('ri-eye-off-line');
            });
        });
    });
</script>