{{-- <style>
    /* Dropdown styles */
    .dropdown {
        max-width: 13em;
        margin: 80px auto 0;
        position: relative;
        width: 100%;
    }

    .dropdown-btn {
        background: #1d1f24;
        font-size: 18px;
        width: 100%;
        border: none;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7em 0.5em;
        border-radius: 0.5em;
        cursor: pointer;
    }

    .arrow {
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 6px solid #fff;
        transition: transform ease-in-out 0.3s;
    }

    .dropdown-content {
        list-style: none;
        position: absolute;
        top: 3.2em;
        width: 100%;
        visibility: hidden;
        overflow: hidden;
        background: #2f3238;
        /* Background for dropdown */
        border-radius: 0.5em;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .dropdown-content li {
        transition: 0.5s;
    }

    .dropdown:focus-within .dropdown-content {
        visibility: visible;
    }

    .dropdown:focus-within .dropdown-btn>.arrow {
        transform: rotate(180deg);
    }

    .dropdown-content li:hover {
        background: #1d1f24;
        /* Change background on hover */
    }

    .dropdown-content li a {
        display: block;
        padding: 0.7em 0.5em;
        color: #fff;
        margin: 0.1em 0;
        text-decoration: none;
    }

    /* Base styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: "Segoe UI", sans-serif;
        color: #333;
    }
</style> --}}
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
{{-- 
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form action="{{ route('addUserPost') }}" method="POST" enctype="multipart/form-data" id="userForm">
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
                                                <div
                                                    class="uploaded-img position-relative h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 d-none">
                                                    <button type="button"
                                                        class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                                        <iconify-icon icon="radix-icons:cross-2"
                                                            class="text-xl text-danger-600"></iconify-icon>
                                                    </button>
                                                    <img id="uploaded-img__preview" class="w-100 h-100 object-fit-cover"
                                                        src="assets/images/user.png" alt="image">
                                                </div>

                                                <label
                                                    class="upload-file h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1"
                                                    for="upload-file">
                                                    <iconify-icon icon="solar:camera-outline"
                                                        class="text-xl text-secondary-light"></iconify-icon>
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
                                            <label for="firstname"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Firstname</label>
                                            <div class="icon-field has-validation">
                                                <span class="icon">
                                                    <iconify-icon icon="f7:person"></iconify-icon>
                                                </span>
                                                <input type="text"
                                                    class="form-control radius-8 {{ $errors->has('firstname') ? 'is-invalid' : '' }}"
                                                    id="firstname" name="firstname" placeholder="Enter First Name"
                                                    value="{{ old('firstname') }}" autofocus>
                                            </div>
                                            <small class="text-danger">{{ $errors->first('firstname') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="lastname"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Lastname</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="f7:person"></iconify-icon>
                                                </span>
                                                <input type="text"
                                                    class="form-control radius-8 {{ $errors->has('lastname') ? 'is-invalid' : '' }}"
                                                    id="lastname" name="lastname" placeholder="Enter Last Name"
                                                    value="{{ old('lastname') }}">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('lastname') }}</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="email"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="mage:email"></iconify-icon>
                                                </span>
                                                <input id="email" type="email"
                                                    class="form-control radius-8 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                    name="email" value="{{ old('email') }}"
                                                    placeholder="Enter email">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="mobile_no"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Phone
                                                Number</label>
                                            <div class="icon-field">
                                                <span class="icon">
                                                    <iconify-icon icon="solar:phone-calling-linear"></iconify-icon>
                                                </span>
                                                <input id="mobile_no" type="text"
                                                    class="form-control radius-8 {{ $errors->has('mobile_no') ? 'is-invalid' : '' }}"
                                                    name="mobile_no" value="{{ old('mobile_no') }}" required
                                                    placeholder="09xxxxxxxxx">
                                            </div>
                                            <small class="text-danger">{{ $errors->first('mobile_no') }}</small>
                                        </div>
                                    </div>

                                    

                                    @if ($userType === 'admin')
                                        <!-- Office/Department Radio Buttons -->
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-6">
                                                <label class="fw-semibold text-primary-light text-sm mb-2">Select Type</label>
                                                <div class="row g-3">
                                                    <div class="col-md-3" style="margin-top: 1.8rem">
                                                        <div class="form-check d-flex align-items-center gap-2">
                                                            <input type="radio" id="office" name="select_type"
                                                                value="office" class="form-check-input" checked>
                                                            <label for="office"
                                                                class="form-check-label d-flex align-items-center gap-2">
                                                                Office
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3" style="margin-top: 1.8rem">
                                                        <div class="form-check d-flex align-items-center gap-2">
                                                            <input type="radio" id="department" name="select_type"
                                                                value="department" class="form-check-input">
                                                            <label for="department"
                                                                class="form-check-label d-flex align-items-center gap-2">
                                                                Department
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3" style="margin-top: 1.8rem">
                                                        <div class="form-check d-flex align-items-center gap-2 ms-5">
                                                            <input type="radio" id="avr" name="select_type"
                                                                value="avr" class="form-check-input">
                                                            <label for="avr"
                                                                class="form-check-label d-flex align-items-center gap-2">
                                                                Others
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <!-- Office Dropdown -->
                                            <div class="form-group mb-3 col-md-6" id="office-dropdown">
                                                <label for="office_id"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Select
                                                    Office</label>
                                                <select class="form-control radius-8 {{ $errors->has('office_id') ? 'is-invalid' : '' }}" id="office_id"
                                                    name="office_id">
                                                    <option value="" disabled selected>Select an Office</option>
                                                    <!-- This option is not scrollable -->
                                                    @foreach ($offices as $office)
                                                        @if ($office->type == 'office')
                                                            <option value="{{ $office->id }}">{{ $office->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                
                                            </div>
    
                                            <!-- Department Dropdown -->
                                            <div class="form-group mb-3 col-md-6" id="department-dropdown"
                                                style="display: none;">
                                                <label for="department"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Select
                                                    Department</label>
                                                <select class="form-control radius-8" id="department"
                                                    name="department">
                                                    <option value="" disabled selected>Select a Department</option>
                                                    <!-- This option is not scrollable -->
                                                    @foreach ($offices as $office)
                                                        @if ($office->type == 'department')
                                                            <option value="{{ $office->id }}">{{ $office->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-3 col-md-6" id="avr-dropdown"
                                                style="display: none;">
                                                <label for="avr"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Select
                                                    Other Amenities</label>
                                                <select class="form-control radius-8" id="avr"
                                                    name="avr">
                                                    <option value="" disabled selected>Choose from other amenities</option>
                                                    <!-- This option is not scrollable -->
                                                    @foreach ($offices as $office)
                                                        @if ($office->type != 'office' && $office->type != 'department')
                                                            <option value="{{ $office->id }}">{{ $office->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        
                                    @endif
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="type"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Type</label>
                                                <div class="icon-field">
                                                    <span class="icon">
                                                        <iconify-icon icon="f7:person"></iconify-icon>
                                                    </span>
                                                    <select
                                                        class="form-control radius-8 {{ $errors->has('type') ? 'is-invalid' : '' }}"
                                                        id="type" name="type">
                                                        <option value="" disabled selected>Select a role</option>

                                                        <option value="facility manager"
                                                            {{ old('type') == 'Facility manager' ? 'selected' : '' }}>
                                                            Facility Manager
                                                        </option>
                                                        <option value="operator"
                                                            {{ old('type') == 'Operator' ? 'selected' : '' }}> Operator
                                                        </option>

                                                    </select>
                                                </div>
                                                <small class="text-danger">{{ $errors->first('type') }}</small>
                                            </div>
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="designation_id"
                                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Designation</label>
                                                <div class="icon-field">
                                                    <span class="icon">
                                                        <iconify-icon icon="f7:person"></iconify-icon>
                                                    </span>
                                                    <select
                                                        class="form-control radius-8 {{ $errors->has('designation_id') ? 'is-invalid' : '' }}"
                                                        id="designation_id" name="designation_id">
                                                        <option value="" disabled selected>Select a designation
                                                        </option>
                                                        @foreach ($designations as $designation)
                                                            @if (($userType == 'admin' || ($userType != 'facility_manager' && $designation->name != 'Dean')) && $designation->id != 3 && $designation->id != 4 && $designation->id != 6 )
                                                                <option value="{{ $designation->id  }}"
                                                                    {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                                    {{ $designation->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small class="text-danger">{{ $errors->first('designation') }}</small>
                                            </div>

                                            
                                        </div>
                                    <div class="d-flex align-items-center justify-content-center gap-3 mt-3 mb-5">
                                        <a href="/users">
                                            <button type="button"
                                                class="btn btn-danger text-md px-56 py-11 radius-8">Cancel</button>
                                        </a>
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" style="max-width: 200px">Add
                                            User</button>
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

    // Toggle office/department fields based on radio button selection
    document.querySelectorAll('input[name="select_type"]').forEach(function(elem) {
        elem.addEventListener('change', function() {
            const officeDropdown = document.getElementById('office-dropdown');
            const departmentDropdown = document.getElementById('department-dropdown');
            const avrDropdown = document.getElementById('avr-dropdown');

            if (this.value === 'office') {
                officeDropdown.style.display = 'block';
                departmentDropdown.style.display = 'none';
                avrDropdown.style.display = 'none';
            } else if (this.value === 'department') {
                departmentDropdown.style.display = 'block';
                officeDropdown.style.display = 'none';
                avrDropdown.style.display = 'none';
            } else if (this.value === 'avr') {
                departmentDropdown.style.display = 'none';
                officeDropdown.style.display = 'none';
                avrDropdown.style.display = 'block';
            }
        });
    });
</script>
