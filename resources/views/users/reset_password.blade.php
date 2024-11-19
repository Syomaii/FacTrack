@include('templates.header')

<section class="auth bg-base d-flex flex-wrap">
    <div class="auth-left d-lg-block d-none">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="assets/images/auth/auth-img.png" alt="">
        </div>
    </div>
    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
        <div class="max-w-464-px mx-auto w-100">
            <div>
                <a href="index.html" class="mb-40 max-w-290-px">
                    <img src="assets/images/logo.png" alt="">
                </a>
                <h4 class="mb-12">Reset Your Password</h4>
                <p class="mb-32 text-secondary-light text-lg">Enter your new password to reset your account</p>
            </div>
            @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @error('password')
                <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between mb-3"
                    role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon>
                        <p style="margin: 0; padding: 0; font-size: 15px">{{ $message }}</p>
                    </div>
                </div>
            @enderror
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="icon-field form-group mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" name="password"
                        class="form-control h-56-px bg-neutral-50 radius-12 @error('password') is-invalid @enderror"
                        placeholder="New Password" required>
                </div>
                <div class="icon-field form-group mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" name="password_confirmation"
                        class="form-control h-56-px bg-neutral-50 radius-12 @error('password_confirmation') is-invalid @enderror"
                        placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">
                    Reset Password
                </button>
            </form>
            {{-- <div class="text-center mt-16">
                <a href="{{ route('users/index') }}" class="text-primary-600 fw-medium">
                    Return to Login Page
                </a>
            </div> --}}
        </div>
    </div>
</section>

@include('templates.footer')
