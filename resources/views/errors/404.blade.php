@include('templates.header')

<div class="full-page-container">
    <div class="card basic-data-table full-page-card">
        <div class="card-body py-80 px-32 text-center">
            <img src="/assets/images/404.png" alt="" class="mb-24">
            <h6 class="mb-16">Error 404 - Page not Found</h6>
            <p class="text-secondary-light">Sorry, the page you are looking for doesn’t exist </p>
            @if(auth()->user()->type != 'student')
                <a href="/dashboard" class="btn btn-primary-600 radius-8 px-20 py-11">Back to Home</a>
            @elseif (auth()->user()->type === 'student')
                <a href="/student-dashboard" class="btn btn-primary-600 radius-8 px-20 py-11">Back to Home</a>
            @endif
        </div>
    </div>
</div>

    



@include('templates.footer')
