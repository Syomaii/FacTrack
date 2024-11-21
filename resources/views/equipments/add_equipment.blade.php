@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Equipments</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium"><a href="{{ url()->previous() }}" class="d-flex align-items-center gap-1 hover-text-primary">Facility Equipments</a></li>
                <li>-</li>
                <li class="fw-medium">Add Equipment</li>
            </ul>
        </div>

        

        <form action="{{ route('add_equipment', ['id' => $facility->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="text" hidden name="facility" value="{{ $facility->id }}">
            <div class="card h-100 p-0 radius-12">
                <div class="card-body p-24">
                    <div class="row justify-content-center">
                        <div class="col-xxl-6 col-xl-8 col-lg-10">
                            <div class="card border">
                                <div class="card-body">

                                    <!-- Upload Image Start -->
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
                                                    <span class="fw-semibold text-secondary-light">Uploads</span>
                                                    <input id="upload-file" type="file" name="image" hidden>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <h6 class="text-md text-primary-light mb-16">Equipment Image</h6>
                                        </div>
                                        <small class="text-danger">{{ $errors->first('image') }}</small>
                                    </div>
                                    <!-- Upload Image End -->

                                    <!-- Form Fields -->

                                    <!-- Brand Name -->
                                    <div class="mb-3">
                                        <label for="brand"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Brand</label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('brand') ? 'is-invalid' : '' }}"
                                            id="brand" name="brand" placeholder="Enter Equipment Brand Name"
                                            value="{{ old('brand') }}">
                                        <small class="text-danger">{{ $errors->first('brand') }}</small>
                                    </div>

                                    <!-- Model Name -->
                                    <div class="mb-3">
                                        <label for="name"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Model
                                        </label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="name" name="name" placeholder="Enter Equipment Model Name"
                                            value="{{ old('name') }}">
                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label for="description"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                                        <textarea class="form-control radius-8 {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description"
                                            name="description" placeholder="Write description...">{{ old('description') }}</textarea>
                                        <small class="text-danger">{{ $errors->first('description') }}</small>
                                    </div>

                                    <!-- Serial Number -->
                                    <div class="mb-3">
                                        <label for="serial_no"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Serial
                                            Number</label>
                                        <input type="text"
                                            class="form-control radius-8 {{ $errors->has('serial_no') ? 'is-invalid' : '' }}"
                                            id="serial_no" name="serial_no" placeholder="Enter Equipment Serial No"
                                            value="{{ old('serial_no') }}">
                                        <small class="text-danger">{{ $errors->first('serial_no') }}</small>
                                    </div>

                                    <!-- Acquired Date -->
                                    <div class="mb-3">
                                        <label for="acquired_date"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Acquired
                                            Date</label>
                                        <input type="date"
                                            class="form-control radius-8 {{ $errors->has('acquired_date') ? 'is-invalid' : '' }}"
                                            id="acquired_date" name="acquired_date" value="{{ old('acquired_date') }}">
                                        <small class="text-danger">{{ $errors->first('acquired_date') }}</small>
                                    </div>


                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="Available"
                                                {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                            <option value="In Maintenance"
                                                {{ old('status') == 'In Maintenance' ? 'selected' : '' }}>In
                                                Maintenance</option>
                                            <option value="In Repair"
                                                {{ old('status') == 'In Repair' ? 'selected' : '' }}>In Repair</option>
                                            <option value="Borrowed"
                                                {{ old('status') == 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="mb-3">
                                        <label for="ownedby" class="form-label fw-semibold text-primary-light text-sm mb-8">Owned by University</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input class="form-check-input" type="radio" name="radio1" id="radio1-yes" value="University" checked>
                                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="radio1-yes">Yes</label>    
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-check-input" type="radio" name="radio1" id="radio1-no">
                                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="radio1-no">No</label>    
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="mb-3" id="owned-by-container">
                                        <label for="owned_by"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Owned
                                            by</label>
                                        <select
                                            class="form-control radius-8 {{ $errors->has('owned_by') ? 'is-invalid' : '' }}"
                                            id="owned_by" name="owned_by" onchange="handleOwnedByChange()">
                                            <option value="" hidden>Owned By</option>
                                            <option value="University"
                                                {{ old('owned_by') == 'University' ? 'selected' : '' }}>University
                                            </option>
                                            <option value="Department"
                                                {{ old('owned_by') == 'Department' ? 'selected' : '' }}>Department
                                            </option>
                                            <option value="Faculty"
                                                {{ old('owned_by') == 'Faculty' ? 'selected' : '' }}>Faculty</option>
                                            <option value="Student Organization"
                                                {{ old('owned_by') == 'Student Organization' ? 'selected' : '' }}>
                                                Student Organization</option>
                                            <option value="Others"
                                                {{ old('owned_by') == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>

                                        <!-- Textbox that will appear when "Others" is selected -->
                                        <input type="text" class="form-control radius-8 mt-2 d-none" id="owned_by_other" name="owned_by_other" placeholder="Please specify" value="{{ old('owned_by_other') }}" />


                                        <small class="text-danger">{{ $errors->first('owned_by') }}</small>
                                    </div>


                                    <div class="d-flex align-items-center justify-content-center gap-3 mb-4 mt-4">
                                        <a href="/facility-equipments/{id}">
                                            <button type="button"
                                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                                Cancel
                                            </button>
                                        </a>
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                            Add Equipment
                                        </button>
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

    function handleOwnedByChange() {
        var selectElement = document.getElementById('owned_by');
        var otherInput = document.getElementById('owned_by_other');

        // Show or hide the textbox based on the selected value
        if (ownedBySelect.value === 'Others') {
            ownedByOtherInput.classList.remove('d-none');
        }

        // Listen for changes to the dropdown
        ownedBySelect.addEventListener('change', function() {
            if (ownedBySelect.value === 'Others') {
                ownedByOtherInput.classList.remove('d-none');
            } else {
                ownedByOtherInput.classList.add('d-none');
                ownedByOtherInput.value = '';  // Reset the input value when not "Others"
            }
        });
    }
</script>
