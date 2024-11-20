@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reserve Equipment</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="/dashboard" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Reserve Equipment</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- Main Section -->
        <div class="row g-3">
            <!-- Equipment Details Section -->
            <div class="col-lg-7">
                <div class="card shadow rounded p-3">
                    <h5 class="fw-semibold mb-3">Equipment Results</h5>

                    <div id="equipmentDetails">
                        <p class="text-muted text-center">Please search for equipment to view results.</p>
                    </div>

                    <!-- Pagination Controls -->
                    <div id="paginationControls" class="d-flex justify-content-between mt-3" style="display: none;">
                        <button id="prevPage" class="btn btn-sm btn-secondary" disabled>Previous</button>
                        <button id="nextPage" class="btn btn-sm btn-secondary">Next</button>
                    </div>
                </div>
            </div>

            <!-- Reservation Form Section -->
            <div class="col-lg-5">
                <div class="card shadow rounded p-3">
                    <h5 class="fw-semibold mb-3">Reserve Equipment</h5>
                    <form action="{{ route('students.reserved') }}" method="POST">
                        @csrf

                        <!-- Hidden Equipment ID -->
                        <input type="hidden" id="equipment_id" name="equipment_id"
                            value="{{ old('equipment_id', $selectedEquipment->id ?? '') }}">

                        <!-- Searchable Equipment Input -->
                        <div class="mb-3">
                            <label for="equipmentSearch" class="form-label">Search Equipment</label>
                            <input type="text" id="equipmentSearch" name="equipment_query" class="form-control"
                                placeholder="Type to search..." autocomplete="off">
                            <div id="searchMessage" class="text-danger mt-2" style="display: none;"></div>
                        </div>

                        <!-- Equipment Details Section -->
                        <div id="equipmentDetails">
                            @if ($selectedEquipment)
                                <div class="mb-3 p-2 border rounded">
                                    <div class="text-center mb-3">
                                        <img src="{{ $selectedEquipment->image }}" alt="{{ $selectedEquipment->name }}"
                                            class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                    <p><strong>Name:</strong> {{ $selectedEquipment->name }}</p>
                                    <p><strong>Brand:</strong> {{ $selectedEquipment->brand }}</p>
                                    <p><strong>Status:</strong> {{ $selectedEquipment->status }}</p>
                                    <p><strong>Serial Number:</strong> {{ $selectedEquipment->serial_no }}</p>
                                    <p><strong>Facility:</strong> {{ $selectedEquipment->facility->name }}</p>
                                    <p><strong>Description:</strong> {{ $selectedEquipment->description }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Purpose -->
                        <div class="mb-3">
                            <label for="purpose" class="form-label">Purpose</label>
                            <textarea id="purpose" name="purpose" class="form-control" placeholder="State the purpose for reservation" required></textarea>
                        </div>

                        <!-- Reservation Date -->
                        <div class="mb-3">
                            <label for="reservationDate" class="form-label">Reservation Date</label>
                            <input type="text" id="reservationDate" name="reservation_date" class="form-control"
                                placeholder="Select reservation date" required>
                        </div>

                        <div class="mb-3">
                            <label for="expectedReturnDate" class="form-label">Expected Return Date</label>
                            <input type="text" id="expectedReturnDate" name="expected_return_date"
                                class="form-control" placeholder="Select expected return date" required>
                        </div>


                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mt-3">Reserve Equipment</button>
                    </form>



                </div>
            </div>
        </div>
    </div>

    @include('templates.footer_inc')
</main>

<!-- Include Scripts -->
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr for start and end date inputs
        flatpickr("#reservationDate", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        flatpickr("#expectedReturnDate", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        // Handle Equipment Search
        const equipmentSearch = document.getElementById('equipmentSearch');
        const equipmentDetails = document.getElementById('equipmentDetails');
        const searchMessage = document.getElementById('searchMessage');
        const paginationControls = document.getElementById('paginationControls');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');

        let currentPage = 1;

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
                            <div class="text-center mb-3">
                                <img src="${equipment.image}" alt="${equipment.name}" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                            <p><strong>Name:</strong> ${equipment.name}</p>
                            <p><strong>Brand:</strong> ${equipment.brand}</p>
                            <p><strong>Status:</strong> ${equipment.status}</p>
                            <p><strong>Serial Number:</strong> ${equipment.serial_no}</p>
                            <p><strong>Facility:</strong> ${equipment.facility}</p>
                            <p><strong>Description:</strong> ${equipment.description}</p>
                            <button class="btn btn-primary select-equipment" 
                                    onclick="selectEquipment(${equipment.id}, '${equipment.name}', '${equipment.image}', '${equipment.brand}', '${equipment.status}', '${equipment.serial_no}', '${equipment.facility}')">
                                Select Equipment
                            </button>
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
        window.selectEquipment = function(id, name, image, brand, status, serial_no, facility) {
            // Update the hidden input field with the selected equipment ID
            const equipmentIdField = document.getElementById('equipment_id');
            equipmentIdField.value = id;

            // Display the selected equipment details
            const equipmentDetails = document.getElementById('equipmentDetails');
            equipmentDetails.innerHTML = `
        <div class="mb-3 p-2 border rounded">
            <div class="text-center mb-3">
                <img src="${image}" alt="${name}" class="img-fluid rounded" style="max-height: 200px;">
            </div>
            <p><strong>Name:</strong> ${name}</p>
            <p><strong>Brand:</strong> ${brand}</p>
            <p><strong>Status:</strong> ${status}</p>
            <p><strong>Serial Number:</strong> ${serial_no}</p>
            <p><strong>Facility:</strong> ${facility}</p>
            <p class="text-success">This equipment has been selected for reservation.</p>
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

@include('templates.footer')
