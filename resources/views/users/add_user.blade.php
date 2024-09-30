@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Add User</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add User</li>
            </ul>
        </div>

        {{-- @if (session('addUserSuccessfully'))
            <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('addUserSuccessfully') }}
                </div>
            </div>
        @endif --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action=""{{ route('add-user') }}" method="POST">
            @csrf
            <div class="card h-100 p-0 radius-12">
                <div class="card-body p-24">
                    <div class="row justify-content-center">
                        <div class="col-xxl-6 col-xl-8 col-lg-10">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="card-body p-24">
                                        <div class="d-flex justify-content-center">
                                            <div class="upload-image-wrapper d-flex align-items-center gap-3">
                                                <div class="uploaded-img position-relative h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 d-none">
                                                    <button type="button" class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                                        <iconify-icon icon="radix-icons:cross-2" class="text-xl text-danger-600"></iconify-icon>
                                                    </button>
                                                    <img id="uploaded-img__preview" class="w-100 h-100 object-fit-cover" src="assets/images/user.png" alt="image">
                                                </div>

                                                <label class="upload-file h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1" for="upload-file">
                                                    <iconify-icon icon="solar:camera-outline" class="text-xl text-secondary-light"></iconify-icon>
                                                    <span class="fw-semibold text-secondary-light">Upload</span>
                                                    <input id="upload-file" type="file" name="image" hidden>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <h6 class="text-md text-primary-light mb-16">User profile</h6>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group icon-field mb-3 col-md-6">
                                            <label for="firstname" class="form-label fw-semibold text-primary-light text-sm mb-8">Firstname</label>
                                            <div class="icon-field has-validation">
                                                <span class="icon">
                                                    <iconify-icon icon="f7:person"></iconify-icon>
                                                </span>
                                                <input type="text" class="form-control radius-8 {{ $errors->has('firstname') ? 'is-invalid' : '' }}" id="firstname" name="firstname" placeholder="Enter First Name" value="{{ old('firstname') }}">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('firstname') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="lastname" class="form-label fw-semibold text-primary-light text-sm mb-8">Lastname</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="f7:person"></iconify-icon>
                                                </span>
                                                <input type="text" class="form-control radius-8 {{ $errors->has('lastname') ? 'is-invalid' : '' }}" id="lastname" name="lastname" placeholder="Enter Last Name" value="{{ old('lastname') }}">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('lastname') }}</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="mage:email"></iconify-icon>
                                                </span>
                                                <input id="email" type="email" class="form-control radius-8 {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter email">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="mobile_no" class="form-label fw-semibold text-primary-light text-sm mb-8">Phone Number</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="solar:phone-calling-linear"></iconify-icon>
                                                </span>
                                                <input id="mobile_no" type="text" class="form-control radius-8 {{ $errors->has('mobile_no') ? 'is-invalid' : '' }}" name="mobile_no" value="{{ old('mobile_no') }}" required autocomplete="phone" placeholder="09xxxxxxxxx">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('mobile_no') }}</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">Password</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                                </span>
                                                <input id="password" type="password" class="form-control radius-8 {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required placeholder="********">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('password') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="password_confirmation" class="form-label fw-semibold text-primary-light text-sm mb-8">Confirm Password</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                                </span>
                                                <input id="password_confirmation" type="password" class="form-control radius-8 {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation" required placeholder="********">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="designation_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Designation</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="f7:person"></iconify-icon>
                                                </span>
                                                <select class="form-control radius-8 {{ $errors->has('designation_id') ? 'is-invalid' : '' }}" id="designation_id" name="designation_id">
                                                    <option value="" disabled selected>Select a designation</option>
                                                    @foreach($designations as $designation)
                                                        @if(($userType == 'admin') || ($userType != 'facility_manager' && $designation->name != 'Dean'))
                                                            <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                                {{ $designation->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <small class="text-danger">{{ $errors->first('designation') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="type" class="form-label fw-semibold text-primary-light text-sm mb-8">Type</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="f7:person"></iconify-icon>
                                                </span>
                                                <select class="form-control radius-8 {{ $errors->has('type') ? 'is-invalid' : '' }}" id="type" name="type">
                                                    <option value="" disabled selected>Select a role</option>
                                                    @if($userType === 'admin')
                                                        <option value="facility manager" {{ old('type') == 'Facility manager' ? 'selected' : '' }}>Facility manager</option>
                                                    @elseif($userType === 'facility manager')
                                                        <option value="facility manager" {{ old('type') == 'Facility manager' ? 'selected' : '' }}>Facility manager</option>
                                                        <option value="operator" {{ old('type') == 'Operator' ? 'selected' : '' }}>Operator</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <small class="text-danger">{{ $errors->first('designation') }}</small>
                                        </div>
                                    </div>

                                    @if ($userType === 'admin')
                                        <div class="form-group mb-3">
                                            <label for="office" class="form-label fw-semibold text-primary-light text-sm mb-8">Office</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="f7:building"></iconify-icon>
                                                </span>
                                                <select class="form-control radius-8 {{ $errors->has('office_id') ? 'is-invalid' : '' }}" id="office" name="office_id">
                                                    <option value="" disabled selected>Select an office</option>
                                                    @foreach($offices as $office)
                                                        @if(($userType == 'admin') || ($userType != 'facility_manager' && $office->name != 'Dean'))
                                                            <option value="{{ $office->id }}" {{ old('office') == $office->id ? 'selected' : '' }}>
                                                                {{ $office->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <small class="text-danger">{{ $errors->first('office_id') }}</small>
                                        </div>
                                    @else
                                        <input type="hidden" name="office_id" value="{{ $officeId }}">
                                    @endif

                                    <div class="d-flex align-items-center justify-content-center gap-3 mt-5">
                                        <a href="/users">
                                            <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">Cancel</button>
                                        </a>
                                            <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">Add User</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>

        @include('templates.footer_inc')
</main>
@include('templates.footer')

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