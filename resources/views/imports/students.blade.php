@include('templates.header')
<x-sidebar />
<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Students</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                        Students
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
        @elseif (session('error'))
            <div
                class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:warning" class="icon text-xl"></iconify-icon>
                    {{ session('error') }}
                </div>
            </div>
        @elseif (isset($errors) && $errors->any())
            <div
                class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:warning" class="icon text-xl"></iconify-icon>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            </div>
        @endif

        <div class="card h-100 p-0 radius-12">
            <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <h5 class="mb-0">Upload Student File</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('import.file') }}" method="POST" enctype="multipart/form-data" class="p-3">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Select File (CSV/XLSX)</label>
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload</button>
                </form>
            </div>

            <div class="dashboard-main-body pt-4">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">FirstName</th>
                                <th scope="col">LastName</th>
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
                                <tr>
                                    <td>
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1"></h6>
                                    </td>
                                    <td>
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1"></h6>
                                    </td>
                                    <td>
                                        <span class="text-md mb-0 fw-normal text-secondary-light"></span>
                                    </td>
                                    <td>
                                        <span class="text-md mb-0 fw-normal text-secondary-light"></span>
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td></td>
                                    <td class="text-center">
                                        <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Active</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="#">
                                                <button type="button"
                                                        class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line"
                                                                class="icon text-xl"></iconify-icon>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            {{-- @empty
                                <tr>
                                    <td colspan="10" class="text-center">No students found from your office/department.</td>
                                </tr>
                            @endforelse --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
