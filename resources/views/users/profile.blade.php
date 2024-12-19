@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">User Profile</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li class="fw-medium">-</li>
                <li class="fw-medium">
                    <a href="{{ url()->previous() }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Users
                    </a>
                </li>
                <li class="fw-medium">-</li>
                <li class="fw-medium">
                    {{ ucwords($user->firstname) }} {{ ucwords($user->lastname) }}
                </li>
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
        @elseif(session('successResetPassword'))
            <div
                class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('successResetPassword') }}
                </div>
            </div>
        {{-- @elseif($errors->any())
            <div
                class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div> --}}
        @endif
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="{{ asset('assets/images/user-grid/uc.jpg') }}" alt=""
                        class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16 mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0 ">
                            <img src="/{{ auth()->user()->image }}" alt=""
                                class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover"  style="z-index: 999">
                            <h6 class="mb-0 mt-16">{{ ucwords($user->firstname) }} {{ ucwords($user->lastname) }}</h6>
                            <span class="text-secondary-light mb-16">{{ $user->email }}</span>
                        </div>
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Phone Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $user->mobile_no }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Designation</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ optional($user->designation)->name ?? 'Not specified' }}</span>
                                </li>
                                @if ($user->designation->name === 'Dean')
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Department</span>
                                        <span class="w-70 text-secondary-light fw-medium">:
                                            {{ optional($user->office)->name ?? 'Not specified' }}</span>
                                    </li>
                                @else
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Office</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ optional($user->office)->name ?? 'Not specified' }}</span>
                                </li>
                                @endif
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Status</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ ucwords($user->status) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24 active"
                                    id="pills-edit-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-edit-profile" type="button" role="tab"
                                    aria-controls="pills-edit-profile" aria-selected="true">
                                    Edit Profile
                                </button>
                            </li>
                            @if (
                                !(auth()->id() !== $user->id &&
                                    (auth()->user()->type === 'facility manager' || auth()->user()->type === 'operator')
                                ))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex align-items-center px-24"
                                        id="pills-change-password-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-change-password" type="button" role="tab"
                                        aria-controls="pills-change-password" aria-selected="false" tabindex="-1">
                                        Change Password
                                    </button>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Edit Profile Form -->
                            <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel"
                                aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                

                                <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <h6 class="text-md text-primary-light mb-16">Profile Image</h6>
                                    <div class="mb-24 mt-16">
                                        <div class="d-flex justify-content-start">
                                            <div class="uploaded-img position-relative h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 d-none">
                                                <button type="button"
                                                    class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                                    <iconify-icon icon="radix-icons:cross-2"
                                                        class="text-xl text-danger-600"></iconify-icon>
                                                </button>
                                                <img id="uploaded-img__preview" class="w-100 h-100 object-fit-cover"
                                                    src="/{{ auth()->user()->image }}" alt="image">
                                            </div>

                                            <label class="upload-file h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1"
                                                for="upload-file">
                                                <iconify-icon icon="solar:camera-outline"
                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                <span class="fw-semibold text-secondary-light">Upload</span>
                                                <input id="upload-file" type="file" name="image" hidden>

                                            </label>
                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="firstName"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    First Name <span class="text-danger-600">*</span>
                                                </label>
                                                <input type="text" class="form-control radius-8" id="firstname"
                                                    name="firstname" value="{{ ucwords($user->firstname) }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="lastName"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Last Name <span class="text-danger-600">*</span>
                                                </label>
                                                <input type="text" class="form-control radius-8" id="lastname"
                                                    name="lastname" value="{{ ucwords($user->lastname) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="email"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Email <span class="text-danger-600">*</span>
                                                </label>
                                                <input type="text" class="form-control radius-8" id="email"
                                                    name="email" value="{{ old('email', $user->email) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="phone"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Phone <span class="text-danger-600">*</span>
                                                </label>
                                                <input type="text" class="form-control radius-8" id="mobile_no"
                                                    name="mobile_no" value="{{ $user->mobile_no }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="designation"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                    Designation <span class="text-danger-600">*</span>
                                                </label>
                                                <select class="form-control radius-8 form-select" id="designation"
                                                    name="designation_id">
                                                    @foreach ($designations as $designation)
                                                        <option value="{{ $designation->id }}"
                                                            {{ $user->designation_id == $designation->id ? 'selected' : '' }}>
                                                            {{ $designation->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center gap-3 mt-5">
                                        @if (auth()->user()->id === $user->id ||
                                                (auth()->user()->type === 'facility manager' && $user->type === 'operator') ||
                                                (auth()->user()->type === 'admin' && $user->type === 'operator'))
                                            <button type="button" class="btn btn-danger border border-danger-600 text-md px-56 py-12 radius-8" id="cancelBtn" disabled>
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" id="saveBtn" disabled>
                                                Save
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Change Password Form -->
                            <div class="tab-pane fade" id="pills-change-password" role="tabpanel"
                                aria-labelledby="pills-change-password-tab" tabindex="0">
                                @if (auth()->user()->type === 'admin' && auth()->id() !== $user->id)
                                    <!-- Reset Password Button for Admin -->
                                    <form action="{{ route('users.reset_password', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" id="reset-password-btn" class="btn btn-primary">Reset
                                            Password</button>
                                    </form>
                                @else
                                    <form action="{{ route('change_password', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-20">
                                            <label for="current-password"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                Current Password <span class="text-danger-600">*</span>
                                            </label>
                                            <div class="position-relative">
                                                <input type="password" class="form-control radius-8"
                                                    id="current-password" name="current_password" required
                                                     placeholder="Enter Current Password">
                                                <span
                                                    class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                    data-toggle="#current-password"></span>
                                            </div>
                                            @error('current_password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-20">
                                            <label for="new-password"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                New Password <span class="text-danger-600">*</span>
                                            </label>
                                            <div class="position-relative">
                                                <input type="password" class="form-control radius-8"
                                                    id="new-password" name="password" required
                                                    placeholder="Enter New Password">
                                                <span
                                                    class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                    data-toggle="#new-password"></span>
                                            </div>
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-20">
                                            <label for="confirm-password"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                Confirm Password <span class="text-danger-600">*</span>
                                            </label>
                                            <div class="position-relative">
                                                <input type="password" class="form-control radius-8"
                                                    id="confirm-password" name="password_confirmation" required
                                                    placeholder="Confirm Password">
                                                <span
                                                    class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                    data-toggle="#confirm-password"></span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center mt-5">
                                            <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8 " id="savePassBtn" >Save Password</button>
                                        </div>

                                    </form>
                                @endif
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
    document.addEventListener('DOMContentLoaded', function() {
        const resetPasswordBtn = document.getElementById('reset-password-btn');
        const resetPasswordForm = document.getElementById(
            'reset-password-form'); // Ensure this ID matches your form

        resetPasswordBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    resetPasswordForm.submit(); // Submit the form only if confirmed
                    Swal.fire(
                        'Reset!',
                        'The password for reset has been sent.',
                        'success'
                    );
                }
            });
        });

        // Toggle password visibility
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


<script>
    document.getElementById('upload-file').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('uploaded-img__preview').src = e.target.result;
                document.querySelector('.uploaded-img').classList.remove('d-none');
                document.querySelector('.upload-file').classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    document.querySelector('.uploaded-img__remove').addEventListener('click', function() {
        document.getElementById('uploaded-img__preview').src = 'assets/images/user.png';
        document.querySelector('.uploaded-img').classList.add('d-none');
        document.querySelector('.upload-file').classList.remove('d-none');
        document.getElementById('upload-file').value = null;
    });
</script>

<script>
    $(document).ready(function () {
        let originalData = $('form').serialize();
        let originalFile = $('#upload-file').val();

        const cancelButton = $('#cancelBtn');
        const saveButton = $('#saveBtn');
        const savePass = $('#savePassBtn');

        // Function to check if the form has changed
        function checkChanges() {
            const currentData = $('form').serialize();
            const currentFile = $('#upload-file').val();

            if (currentData !== originalData || currentFile !== originalFile) {
                cancelButton.prop('disabled', false);
                saveButton.prop('disabled', false);
            } else {
                cancelButton.prop('disabled', true);
                saveButton.prop('disabled', true);
            }
        }

        $('input, select').on('input change', function () {
            checkChanges();
        });

        $('#upload-file').on('change', function () {
            checkChanges();
        });
        
        cancelButton.on('click', function () {
            $('form')[0].reset(); 
            $('#upload-file').val(''); 
            originalData = $('form').serialize(); 
            originalFile = $('#upload-file').val(); 
            cancelButton.prop('disabled', true); 
            saveButton.prop('disabled', true);
        });
    });
</script>

<script>
    // ================== Password Show Hide Js Start ==========
    function initializePasswordToggle(toggleSelector) {
        $(toggleSelector).on('click', function() {
            $(this).toggleClass("ri-eye-off-line");
            var input = $($(this).attr("data-toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    }

    // Call the function
    initializePasswordToggle('.toggle-password');

    // ========================= Password Show Hide Js End ===========================
</script>