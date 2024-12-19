@include('templates.header')
<x-sidebar />

<main class="dashboard-main">
    <x-navbar />

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Notifications</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li class="fw-medium">-</li>
                <li class="fw-medium">Notifications</li>
            </ul>
        </div>
        <div class="">
            <form method="GET" action="{{ route('notifications-filter') }}">
                <div class="d-flex flex-wrap align-items-between justify-content-between gap-3 mb-24 w-100" style="max-width: 100%;">
                    <!-- Read All Notifications Link -->
                    <button type="submit" name="mark_all_as_read" value="1" class="text-primary text-hover-green" role="button" aria-label="Read all notifications">Read All Notifications</button>
        
                    <!-- Filter Notifications -->
                    <div class="d-flex flex-wrap align-items-between justify-content-end gap-3 mb-24">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Filter</option>
                            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        

        @foreach ($notifications as $notification)
            <div class="d-flex flex-column gap-2 alert {{ $notification->read_at ? 'alert-success text-black' : 'alert-primary text-black' }} border-gray-300 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-20 fw-semibold text-lg radius-4 pb-5"
                role="alert">
                <a href="{{ route('redirect', $notification->id) }}"
                    class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                    <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                        <div>
                            <h6 class="text-xl fw-semibold mb-4">
                                {{ $notification->data['title'] ?? 'Notification Title' }}
                            </h6>
                            <span class="mb-0 text-md text-secondary-light"
                                style="white-space: normal; overflow: visible; text-overflow: clip;">
                                {{ $notification->data['message'] ?? 'Notification Message' }}
                            </span>
                        </div>
                    </div>
                    <span
                        class="text-sm text-secondary-light flex-shrink-0">{{ $notification->created_at->format('M-d-y') }}<br>{{ $notification->created_at->diffForHumans() }}</span>
                </a>
            </div>
        @endforeach
    </div>




    </div>

    @include('templates.footer_inc')
</main>
@include('templates.footer')
