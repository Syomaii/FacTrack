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
                <h4 class="mb-12">Sign In to your Account</h4>
                <p class="mb-32 text-secondary-light text-lg">Welcome back! please enter your detail</p>
            </div>
            @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @error('email')
                <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between mb-3"
                    role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon>
                        <p style="margin: 0; padding: 0; font-size: 15px">{{ $message }}</p>
                    </div>
                </div>
            @enderror
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="icon-field form-group mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input id="email" type="email"
                        class="form-control h-56-px bg-neutral-50 radius-12 @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email', Cookie::get('email')) }}" required autocomplete="email"
                        placeholder="Email" required autofocus autocomplete="email">
                </div>
                <div class="position-relative form-group mb-20">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span>
                        <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" id="your-password"
                            name="password" placeholder="Password" required
                            autocomplete="current-password">
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span
                        class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                        data-toggle="#your-password"></span>
                </div>
                <div class="">
                    <div class="d-flex justify-content-between gap-2">
                        <div class="form-check style-check d-flex align-items-center">
                            <input class="form-check-input border border-neutral-300" type="checkbox" name = "remember"
                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me </label>
                        </div>
                        <a href="forgot-password.html" class="text-primary-600 fw-medium">Forgot Password?</a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">
                    Sign
                    In</button>

            </form>
        </div>
    </div>
</section>

@include('templates.footer')
