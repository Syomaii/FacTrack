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
        if (selectElement.value === 'Others') {
            otherInput.classList.remove('d-none');
        } else {
            otherInput.classList.add('d-none');
        }
    }
</script>
