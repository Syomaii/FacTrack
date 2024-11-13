@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Add Student</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li class="fw-medium">-</li>
                <li class="fw-medium">
                    <a href="{{ route('view-department') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Departments
                    </a>
                </li>
                <li class="fw-medium">-</li>
                <li class="fw-medium">Add Student</li>

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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('add-studentPost') }}" method="POST" enctype="multipart/form-data" id="userForm">
            @csrf
            <div class="card h-100 p-0 radius-12 pb-5 pt-5">
                <div class="card-body p-24">
                    <div class="row justify-content-center">
                        <div class="col-xxl-6 col-xl-8 col-lg-10">
                            <div class="card border">
                                <div class="card-body pb-5">
                                    <div class="card-body p-24">
                                        <div class="d-flex justify-content-center">
                                            <h4 class="text-ld text-primary-light mb-16">Student Profile</h4>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="id_no"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">ID Number</label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('id_no') ? 'is-invalid' : '' }}"
                                            id="id_no" name="id_no" placeholder="Enter ID Number"
                                            value="{{ old('id_no') }}">
                                        <small class="text-danger">{{ $errors->first('id_no') }}</small>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="firstname"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">First
                                                Name</label>
                                            <input type="text"
                                                class="form-control radius-8 {{ $errors->has('firstname') ? 'is-invalid' : '' }}"
                                                id="firstname" name="firstname" placeholder="Enter First Name"
                                                value="{{ old('firstname') }}">
                                            <small class="text-danger">{{ $errors->first('firstname') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="lastname"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Last
                                                Name</label>
                                            <input type="text"
                                                class="form-control radius-8 {{ $errors->has('lastname') ? 'is-invalid' : '' }}"
                                                id="lastname" name="lastname" placeholder="Enter Last Name"
                                                value="{{ old('lastname') }}">
                                            <small class="text-danger">{{ $errors->first('lastname') }}</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3 col-md-6">
                                            <label
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Gender</label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check custom-radio">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="gender_m" value="M"
                                                        {{ old('gender') == 'M' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gender_m">Male</label>
                                                </div>
                                                <div class="form-check custom-radio">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="gender_f" value="F"
                                                        {{ old('gender') == 'F' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gender_f">Female</label>
                                                </div>
                                            </div>
                                            <small class="text-danger">{{ $errors->first('gender') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="email"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                                            <input type="email"
                                                class="form-control radius-8 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                id="email" name="email" placeholder="Enter Email"
                                                value="{{ old('email') }}">
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="course"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Course</label>
                                            <input type="text"
                                                class="form-control radius-8 {{ $errors->has('course') ? 'is-invalid' : '' }}"
                                                id="course" name="course" placeholder="Enter Course"
                                                value="{{ old('course') }}">
                                            <small class="text-danger">{{ $errors->first('course') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="department"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Department</label>
                                            <input type="text"
                                                class="form-control radius-8 {{ $errors->has('department') ? 'is-invalid' : '' }}"
                                                id="department" name="department" placeholder="Enter Department"
                                                value="{{ old('department') }}">
                                            <small class="text-danger">{{ $errors->first('department') }}</small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center gap-3 mt-5">
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">Add
                                            Student</button>
                                        <a href="/students">
                                            <button type="button"
                                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">Cancel</button>
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
        @include('templates.footer_inc')
</main>
@include('templates.footer')

<!-- Add custom CSS for radio button styling -->
<style>
    .form-check.custom-radio .form-check-input {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #007bff;
        transition: all 0.3s ease;
    }

    .form-check.custom-radio .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .form-check.custom-radio .form-check-input:focus {
        box-shadow: none;
    }

    .form-check.custom-radio .form-check-label {
        margin-left: 8px;
        font-weight: normal;
    }
</style>
