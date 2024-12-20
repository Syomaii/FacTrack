<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        @if (Auth::user()->type === 'student')
            <a href="/student-dashboard" class="sidebar-logo">
                <img src="/assets/images/logo.png" alt="site logo" class="light-logo">
                <img src="/assets/images/logo-light.png" alt="site logo" class="dark-logo">
                <img src="/assets/images/logo-icon.png" alt="site logo" class="logo-icon">
            </a>
        @elseif(Auth::user()->type === 'faculty')
            <a href="/faculty-dashboard" class="sidebar-logo">
                <img src="/assets/images/logo.png" alt="site logo" class="light-logo">
                <img src="/assets/images/logo-light.png" alt="site logo" class="dark-logo">
                <img src="/assets/images/logo-icon.png" alt="site logo" class="logo-icon">
            </a>
        @else
            <a href="/dashboard" class="sidebar-logo">
                <img src="/assets/images/logo.png" alt="site logo" class="light-logo">
                <img src="/assets/images/logo-light.png" alt="site logo" class="dark-logo">
                <img src="/assets/images/logo-icon.png" alt="site logo" class="logo-icon">
            </a>
        @endif
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            @if (Auth::user()->type !== 'student' && Auth::user()->type !== 'faculty')
                <li>
                    <a href="/dashboard">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->type === 'admin')
                <li>
                    <a href="/offices">
                        <iconify-icon icon="ci:house-01" class="menu-icon"></iconify-icon>
                        <span>Offices</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->type === 'facility manager' || Auth::user()->type === 'operator')
                <li>
                    <a href="/facilities">
                        <iconify-icon icon="mingcute:storage-line" class="menu-icon"></iconify-icon>
                        <span>Facilities</span>
                    </a>
                </li>
                <li>
                    <a href="/equipments">
                        <iconify-icon icon="mingcute:computer-line" class="menu-icon"></iconify-icon>
                        <span>Equipments</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->type === 'facility manager' || Auth::user()->type === 'admin')
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>Users</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="/users">
                                <i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i>
                                <span>All</span>
                            </a>
                        </li>
                        @if (auth()->user()->type === 'facility manager' || auth()->user()->type === 'admin')
                            <li>
                                <a href="/view-students">
                                    <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                    <span>Students</span>
                                </a>
                            </li>
                            <li>
                                <a href="/view-faculties">
                                    <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    <span>Faculty</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            {{-- @if (auth()->user()->type != 'student' && auth()->user()->type != 'faculty')
            @endif --}}
            @if (Auth::user()->type === 'facility manager' || Auth::user()->type === 'operator')
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="mingcute:clipboard-line" class="menu-icon"></iconify-icon>
                        <span>Logs</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <!-- Borrow Equipments -->
                        <li>
                            <a href="/borrowers-log"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i>
                                Borrows
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logs.equipment_reservations') }}">
                                <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Equipment Reservation
                            </a>
                        </li>
                        @if (Auth::user()->designation->name === 'Office Head')
                            <li>
                                <a href="{{ route('logs.facility_reservations') }}">
                                    <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Facility Reservation
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->designation->name === 'Maintenance Personnel')
                            <li>
                                <a href="{{ route('logs.in_maintenance_equipment_log') }}">
                                    <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Maintenance Equipment Log
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logs.in_repair_equipment_log') }}">
                                    <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Repair Equipment Log
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                        <span>Operation</span>
                    </a>

                    <!-- Simplified Sidebar Menu -->
                    <ul class="sidebar-submenu">
                        <!-- Borrow Equipments -->
                        <li>
                            <a href="/borrow-equipment">
                                {{-- <iconify-icon icon="icon-park-outline:hold-interface"></iconify-icon> --}}
                                <i class="ri-circle-fill circle-icon text-orange w-auto"></i>
                                Borrow Equipments
                            </a>
                        </li>

                        <!-- Maintenance Equipments -->
                        <li>
                            <a href="/maintenance-equipment">
                                {{-- <iconify-icon icon="icon-park-outline:hold-interface"></iconify-icon> --}}
                                <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                Maintenance Equipments
                            </a>
                        </li>

                        <!-- Repair Equipments -->
                        <li>
                            <a href="/repair-equipment">
                                {{-- <iconify-icon icon="mdi:box-check-outline"></iconify-icon> --}}
                                <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                                Repair Equipments
                            </a>
                        </li>

                        <!-- Donate Equipments -->
                        <li>
                            <a href="/donate-equipment">
                                {{-- <iconify-icon icon="icon-park-outline:hold-interface"></iconify-icon> --}}
                                <i class="ri-circle-fill circle-icon text-pink w-auto"></i>
                                Donate Equipments
                            </a>
                        </li>

                        <!-- Dispose Equipments -->
                        <li>
                            <a href="/dispose-equipment">
                                {{-- <iconify-icon icon="icon-park-outline:hold-interface"></iconify-icon> --}}
                                <i class="ri-circle-fill circle-icon text-black w-auto"></i>
                                Dispose Equipments
                            </a>
                        </li>

                        <!-- Return Equipments -->
                        <li>
                            <a href="/return-equipment">
                                {{-- <iconify-icon icon="mdi:box-check-outline"></iconify-icon> --}}
                                <i class="ri-circle-fill circle-icon text-success w-auto"></i>
                                Return Equipments
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->type != 'student' && Auth::user()->type != 'faculty')
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                        <span>Reports</span>
                    </a>
                    <ul class="sidebar-submenu">
                        @if (Auth::user()->type === 'admin')
                            <li>
                                <a href="/user-reports">
                                    <i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i>
                                    Users
                                </a>
                            </li>
                        @elseif (Auth::user()->type === 'facility manager' || Auth::user()->type === 'operator')
                            <li>
                                <a href="/borrowed-equipments">
                                    <i class="ri-circle-fill circle-icon text-orange w-auto"></i>
                                    Borrowed Equipments
                                </a>
                            </li>
                            <li>
                                <a href="/maintenanced-equipments">
                                    <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    In Maintenance Equipments
                                </a>
                            </li>
                            <li>
                                <a href="/repaired-equipments">
                                    <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                                    In Repair Equipments
                                </a>
                            </li>
                            <li>
                                <a href="/donated-equipments">
                                    <i class="ri-circle-fill circle-icon text-pink w-auto"></i>
                                    Donated Equipments
                                </a>
                            </li>
                            <li>
                                <a href="/disposed-equipments">
                                    <i class="ri-circle-fill circle-icon text-black w-auto"></i>
                                    Disposed Equipments
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (Auth::user()->type === 'student' || Auth::user()->type === 'faculty')
                @if (Auth::user()->type === 'student')
                    <li>
                        <a href="/student-dashboard">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @elseif(Auth::user()->type === 'faculty')
                    <li>
                        <a href="/faculty-dashboard">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endif
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="tabler:calendar-filled" class="menu-icon"></iconify-icon>
                        <span>Reserve</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="/offices">
                                <iconify-icon icon="mingcute:computer-line" class="menu-icon"></iconify-icon>
                                Reserve Equipment
                            </a>
                        </li>
                        <li>
                            <a href="/reserve-facility">
                                <iconify-icon icon="mingcute:storage-line" class="menu-icon"></iconify-icon>
                                Reserve Facility
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</aside>
