@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reserve Equipment</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <a href="{{ route('facility_equipment', ['id' => $equipment->facility_id]) }}">
                    {{ $equipment->facility->name }}
                </a>
                <li>-</li>
                <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                    Reserve Equipment
                </a>
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- Main Content -->
        <div class="row g-4">
            <!-- Left Side: Reservation Form -->
            <div class="col-md-6">
                <div class="card shadow-sm radius-12">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-4">Reservation Form</h5>
                        <form action="{{ route('reserve.equipment.store', $equipment->code) }}" method="POST">
                            @csrf

                            <!-- Purpose -->
                            <div class="mb-4">
                                <label for="purpose" class="form-label">Purpose</label>
                                <textarea class="form-control" id="purpose" name="purpose" rows="3" required>{{ old('purpose') }}</textarea>
                            </div>


                            <!-- Reservation Date and Time -->
                            <div class="mb-4">
                                <label for="reservation_date" class="form-label">Reservation Date and Time</label>
                                <input type="datetime-local" class="form-control" id="reservation_date"
                                    name="reservation_date" required>
                            </div>

                            <!-- Expected Return Date and Time -->
                            <div class="mb-4">
                                <label for="expected_return_date" class="form-label">Expected Return Date and
                                    Time</label>
                                <input type="datetime-local" class="form-control" id="expected_return_date"
                                    name="expected_return_date" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 m-1">Reserve</button>
                        </form>
                    </div>
                </div>
            </div>

<<<<<<< HEAD
            <!-- Right Side: Equipment Image and Details -->
            <div class="col-md-6">
                <div class="card shadow-sm radius-12">
                    <div class="card-body text-center">
                        <!-- Equipment Image -->
                        <div class="mb-5">
                            <img src="{{ asset($equipment->image) }}" alt="{{ $equipment->name }}" class="img-fluid"
                                style="max-height: 200px;">
=======
            <!-- Reservation Form Section -->
            <div class="col-lg-5">
                <div class="card shadow rounded p-3">
                    <h5 class="fw-semibold mb-3">Reserve Equipment</h5>
                    <form action="{{ route('students.reserved') }}" method="POST">
                        @csrf
                        <!-- Equipment Details Section -->
                        <div id="equipmentDetails">
                            @if ($selectedEquipment)
                                <div class="mb-3 p-2 border rounded">
                                    {{-- <div class="text-center mb-3">
                                        <img src="{{ $selectedEquipment->image }}" alt="{{ $selectedEquipment->name }}"
                                            class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                    <p><strong>Name:</strong> {{ $selectedEquipment->name }}</p>
                                    <p><strong>Brand:</strong> {{ $selectedEquipment->brand }}</p>
                                    <p><strong>Status:</strong> {{ $selectedEquipment->status }}</p>
                                    <p><strong>Serial Number:</strong> {{ $selectedEquipment->serial_no }}</p>
                                    <p><strong>Facility:</strong> {{ $selectedEquipment->facility->name }}</p>
                                    <p><strong>Description:</strong> {{ $selectedEquipment->description }}</p> --}}
                                    <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>{{ $selectedEquipment->id }}</strong></div>
                                    <div class="text-center mb-3">
                                        <img src="{{ $selectedEquipment->image }}" alt="{{ $selectedEquipment->name }}" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                    <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Brand:</strong></div>
                                    <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $selectedEquipment->brand }}</div>
                                    <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Model:</strong></div>
                                    <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $selectedEquipment->name }}</div>
                                    <div class="d-flex" style="margin-left: 4rem; margin-top: 15px"><strong>Status:</strong></div>
                                    <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $selectedEquipment->status }}</div>
                                    <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Serial Number:</strong></div>
                                    <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $selectedEquipment->serial_no  }}</div>   
                                    <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Facility:</strong></div>
                                    <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $selectedEquipment->facility->name  }}</div>   
                                    <div class="d-flex" style="margin-left: 4rem; margin-top: 18px"><strong>Office:</strong></div>
                                    <div class="d-flex mt-4" style="margin-left: 4rem;">{{ $selectedEquipment->facility->office->name  }}</div>
                                    <input type="hidden" id="equipment_id" name="equipment_id" value="{{ old('equipment_id', $selectedEquipment->id ?? '') }}">
                                    @if ($selectedEquipment->status !== 'Available')
                                        <div class="text-center mt-4 mb-4 pb-4">
                                            <button class="btn btn-primary select-equipment disabled" 
                                                    onclick="selectEquipment('${equipment.id}', '${capitalizeFirstLetter(equipment.name)}', '${equipment.image}', '${capitalizeFirstLetter(equipment.brand)}', '${capitalizeFirstLetter(equipment.status)}', '${equipment.serial_no}', '${capitalizeFirstLetter(equipment.facility)}')">
                                                Select Equipment
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        

                        <!-- Purpose -->
                        <div class="mb-3">
                            <label for="purpose" class="form-label">Purpose</label>
                            <textarea id="purpose" name="purpose" class="form-control" placeholder="State the purpose for reservation" required>{{ old('purpose') }}</textarea>
                            <small class="text-danger">{{ $errors->first('purpose') }}</small>
                        </div>
                        <input type="hidden" id="equipment_id" name="equipment_id" value="{{ old('equipment_id', $selectedEquipment->id ?? '') }}">
                        <!-- Reservation Date -->
                        <div class="mb-3">
                            <label for="reservationDate" class="form-label">Reservation Date</label>
                            <input type="date" id="reservationDate" name="reservation_date" class="form-control" value="{{ old('reservation_date') }}" required >
                            <small class="text-danger">{{ $errors->first('reservation_date') }}</small>
>>>>>>> 7c680703265f16dcce01ff91f5f1b219041c6b46
                        </div>

                        <!-- Equipment Details -->
                        <div class="row g-4 px-2">
                            <div class="col-6 text-start">
                                <p class="mb-3 fw-bold">Model: <span
                                        class="fw-normal">{{ ucwords($equipment->name) }}</span></p>
                                <p class="mb-3 fw-bold">Status: <span
                                        class="fw-normal">{{ ucwords($equipment->status) }}</span></p>
                                <p class="mb-3 fw-bold">Facility: <span
                                        class="fw-normal">{{ ucwords($equipment->facility->name) }}</span></p>
                            </div>
                            <div class="col-6 text-start">
                                <p class="mb-3 fw-bold">Brand: <span
                                        class="fw-normal">{{ ucwords($equipment->brand) }}</span></p>
                                <p class="mb-3 fw-bold">Serial Number: <span
                                        class="fw-normal">{{ $equipment->serial_no }}</span></p>
                                <p class="mb-3 fw-bold">Description: <span
                                        class="fw-normal">{{ ucfirst($equipment->description) }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>
<<<<<<< HEAD
=======

<!-- Include Scripts -->
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr for start and end date inputs

        // Handle Equipment Search
        const equipmentSearch = document.getElementById('equipmentSearch');
        const equipmentDetails = document.getElementById('equipmentDetails');
        const searchMessage = document.getElementById('searchMessage');
        const paginationControls = document.getElementById('paginationControls');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');

        let currentPage = 1;

        function capitalizeFirstLetter(str) {
            if (!str) return ""; 
            return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
        }

        function loadEquipment(query, page = 1) {
            fetch(`/api/search-equipment?query=${query}&page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.equipments && data.equipments.length > 0) {
                        searchMessage.style.display = 'none';
                        equipmentDetails.innerHTML = '';
                        data.equipments.forEach(equipment => {
                            equipmentDetails.innerHTML += `
                        <div class="mb-3 p-2 border rounded">
                            <!-- Image Section -->
                            <div class="text-center mb-3 mt-3">
                                <img src="${equipment.image}" alt="${capitalizeFirstLetter(equipment.name)}" class="img-fluid rounded p-3 w-100" style="max-height: 300px; width: 800px; max-width: 800px">
                            </div>

                            <!-- Details Section -->
                            <div class="row">
                                <!-- Brand -->
                                <div class="mb-3 col-md-6">
                                    <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Brand: </strong>${capitalizeFirstLetter(equipment.brand)}</span></div>
                                </div>

                                <!-- Model -->
                                <div class="mb-3 col-md-6">
                                    <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Model: </strong>${capitalizeFirstLetter(equipment.name)}</span></div>
                                    
                                </div>
                            </div>

                            <!-- Status and Serial Number -->
                            <div class="row">
                                <!-- Status -->
                                <div class="mb-3 col-md-6">
                                    <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Status: </strong>${capitalizeFirstLetter(equipment.status)}</span></div>
                                </div>

                                <!-- Serial Number -->
                                <div class="mb-3 col-md-6">
                                    <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Serial Number: </strong>${equipment.serial_no}</span></div>
                                </div>
                            </div>

                            <!-- Facility and Description -->
                            <div class="row">
                                
                                <!-- Office -->
                                <div class="mb-3 col-md-6">
                                    <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Office/Department: </strong>${equipment.office}</span></div>
                                    
                                </div>
                                <!-- Facility -->
                                <div class="mb-3 col-md-6">
                                    <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Facility: </strong>${capitalizeFirstLetter(equipment.facility)}</span></div>
                                    
                                </div>
                            </div>

                            <!-- Select Equipment Button -->
                            <div class="text-center mt-4 mb-4 pb-4">
                                <button class="btn btn-primary select-equipment" 
                                        onclick="selectEquipment('${equipment.id}', '${capitalizeFirstLetter(equipment.name)}', '${equipment.image}', '${capitalizeFirstLetter(equipment.brand)}', '${capitalizeFirstLetter(equipment.status)}', '${equipment.serial_no}', '${equipment.office}', '${capitalizeFirstLetter(equipment.facility)}')">
                                    Select Equipment
                                </button>
                            </div>
                        </div>
                    `;
                        });

                        // Update pagination controls
                        paginationControls.style.display = 'flex';
                        prevPage.disabled = !data.prevPage;
                        nextPage.disabled = !data.nextPage;
                    } else {
                        equipmentDetails.innerHTML = `
                    <p class="text-muted text-center">No equipment found for the searched query. Please try another search.</p>
                `;
                        paginationControls.style.display = 'none';
                    }
                })
                .catch(() => {
                    searchMessage.style.display = 'block';
                    searchMessage.textContent = 'An error occurred. Please try again.';
                });
        }


        equipmentSearch.addEventListener('input', function() {
            const query = equipmentSearch.value.trim();

            if (query.length > 1) { // Start searching after 3 characters
                currentPage = 1;
                loadEquipment(query, currentPage);
            } else {
                equipmentDetails.innerHTML = `
                <p class="text-muted text-center">Please search for equipment to view results.</p>
            `;
                paginationControls.style.display = 'none';
                searchMessage.style.display = 'none';
            }
        });

        prevPage.addEventListener('click', function() {
            currentPage--;
            loadEquipment(equipmentSearch.value.trim(), currentPage);
        });

        nextPage.addEventListener('click', function() {
            currentPage++;
            loadEquipment(equipmentSearch.value.trim(), currentPage);
        });

        // Function to handle equipment selection
        window.selectEquipment = function(id, name, image, brand, status, serial_no, office, facility) {
            // Update the hidden input field with the selected equipment ID
            const equipmentIdField = document.getElementById('equipment_id');
            equipmentIdField.value = id;

            // Display the selected equipment details
            const equipmentDetails = document.getElementById('equipmentDetails');
            equipmentDetails.innerHTML = `
                <div class="mb-3 p-2 border rounded">
                    <!-- Image Section -->
                    <div class="text-center mb-3 mt-3">
                        <img src="${image}" alt="${capitalizeFirstLetter(name)}" class="img-fluid rounded p-3" style="max-height: 300px; width: 800px; max-width: 800px">
                    </div>

                    <!-- Details Section -->
                    <div class="row">
                        <!-- Brand -->
                        <div class="mb-3 col-md-6">
                            <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Brand: </strong>${capitalizeFirstLetter(brand)}</span></div>
                        </div>

                        <!-- Model -->
                        <div class="mb-3 col-md-6">
                            <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Model: </strong>${capitalizeFirstLetter(name)}</span></div>
                            
                        </div>
                    </div>

                    <!-- Status and Serial Number -->
                    <div class="row">
                        <!-- Status -->
                        <div class="mb-3 col-md-6">
                            <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Status: </strong>${capitalizeFirstLetter(status)}</span></div>
                        </div>

                        <!-- Serial Number -->
                        <div class="mb-3 col-md-6">
                            <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Serial Number: </strong>${serial_no}</span></div>
                        </div>
                    </div>

                    <!-- Facility and Description -->
                    <div class="row">
                        <!-- Office -->
                        
                        <div class="mb-3 col-md-6">
                            <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Office/Department: </strong>${office}</span></div>

                        </div>
                        <!-- Facility -->
                        <div class="mb-3 col-md-6">
                            <div class="d-flex text-xl" style="margin-left: 5rem; margin-top: 15px"><span><strong>Facility: </strong>${capitalizeFirstLetter(facility)}</span></div>

                        </div>
                    </div>

                    <div class="text-center mt-4 mb-4 pb-4">
                        <p class="text-success text-m">This equipment has been selected for reservation.</p>
                    </div>
                </div>
            `;

            console.log(`Equipment selected: ID ${id}, Name ${name}`);
        };



        equipmentSearch.addEventListener('input', function() {
            const query = equipmentSearch.value.trim();
            if (query.length > 1) {
                loadEquipment(query);
            }
        });


    });
</script>

>>>>>>> 7c680703265f16dcce01ff91f5f1b219041c6b46
@include('templates.footer')
