@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Equipment Detail</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Equipment</li>
                <li>-</li>
                <li class="fw-medium">Equipment Detail</li>
                <li>-</li>
                <li class="fw-medium">{{ $equipments->name }}</li>
            </ul>
        </div>

        <div class="card bg-white shadow rounded-3 p-3 border-0 edetails">
            <div class="row g-0">
                <div class="img-container col-md-6">
                    <p class="ename">{{ $equipments->name }}</p>
                    <img src="{{ asset($equipments->image) }}" class="img-fluid" alt="{{ $equipments->name }}">
                </div>
                <div class="details-container col-md-6">
                    <div class="row">
                        <div class="details-item col-md-4 mt-5">
                            <div>
                                <strong>Status:</strong>
                                <p>{{ $equipments->status }}</p>
                            </div>
                        </div>
                        <div class="details-item col-md-4 mt-5">
                            <div>
                                <strong>Facility:</strong>
                                <p>{{ $equipments->facility->name }}</p>
                            </div>
                        </div>
                        <div class="details-item col-md-4">
                            <div>
                                <strong>QR No:</strong>
                                <p>{{ $equipments->code }}</p>
                            </div>
                        </div>
                        <div class="details-item col-md-4">
                            <div>
                                <strong>QR Code:</strong>
                                <div>{!! QrCode::size(60)->generate($equipments->code) !!}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <a href="javascript:void(0)" class="btn btn-success text-base radius-8 px-20 py-11"
                            data-id="{{ $equipments->id }}" data-name="{{ $equipments->name }}"
                            data-description="{{ $equipments->description }}"
                            data-acquired_date="{{ $equipments->acquired_date }}"
                            data-status="{{ $equipments->status }}"
                            data-facility="{{ $equipments->facility }}">Edit Equipment
                        </a>
                        <a href="/borrow" class="btn btn-danger text-base radius-8 px-20 py-11">Delete Equipment</a>
                        <a href="/borrower-form/{{ $equipments->id }}" class="btn btn-neutral-900 text-base radius-8 px-20 py-11 borrow">Borrow Equipment</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="timeline-horizontal ">
            <div class="timeline-item above">
                <p>Date Acquired</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item below">
                <p>Next Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <div class="timeline-item above">
                <p>Last Maintenance</p>
                <p>{{ $equipments->acquired_date }}</p>
            </div>
            <!-- Add more timeline items as needed -->
        </div>
        
        
    
    </div>
    @include('templates.footer_inc')

<div class="modal fade" id="editEquipmentModal" tabindex="-1" aria-labelledby="editEquipmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEquipmentModalLabel">Edit Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEquipmentForm" action="{{ route('update_equipment') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="equipmentId">
                    <div class="mb-3">
                        <label for="equipmentName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="equipmentName" name="name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="equipmentDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="equipmentDescription" name="description" required></textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="equipmentAcquiredDate" class="form-label">Acquired Date</label>
                        <input type="datetime-local" class="form-control" id="equipmentAcquiredDate"
                            name="acquired_date">
                        @error('acquired_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="equipmentFacility" class="form-label">Facility</label>
                        <input type="text" class="form-control" id="equipmentFacility" name="facility">
                        @error('facility')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="equipmentStatus" class="form-label">Status</label>
                        <select class="form-control" id="equipmentStatus" name="status" required>
                            <option value="Available" selected>Available</option>
                            <option value="In Maintenance">In Maintenance</option>
                            <option value="In Repair">In Repair</option>
                            <option value="Borrowed">Borrowed</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var table = document.querySelector('#dataTable');

        table.addEventListener('click', function(e) {
            if (e.target.closest('.view-equipment')) {
                var button = e.target.closest('.view-equipment');
                var id = button.dataset.id;
                window.location.href = `/borrower-form/${id}`;
            }
            if (e.target.closest('.edit-equipment')) {
                var button = e.target.closest('.edit-equipment');
                var id = button.dataset.id;
                var name = button.dataset.name;
                var description = button.dataset.description;
                var acquired_date = button.dataset.acquired_date;
                var status = button.dataset.status;
                var facility = button.dataset.facility;

                var formattedDate = new Date(acquired_date).toISOString().slice(0, 16);

                document.getElementById('equipmentId').value = id;
                document.getElementById('equipmentName').value = name;
                document.getElementById('equipmentDescription').value = description;
                document.getElementById('equipmentAcquiredDate').value = formattedDate;
                document.getElementById('equipmentStatus').value = status;
                document.getElementById('equipmentFacility').value = facility;

                var editModal = new bootstrap.Modal(document.getElementById(
                    'editEquipmentModal'));
                editModal.show();
            }

            if (e.target.closest('.delete-equipment')) {
                var button = e.target.closest('.delete-equipment');
                var id = button.dataset.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            }
        });
    });
</script>
@include('templates.footer')
