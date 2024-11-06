<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="/dashboard" class="sidebar-logo">
            <img src="/assets/images/logo.png" alt="site logo" class="light-logo">
            <img src="/assets/images/logo-light.png" alt="site logo" class="dark-logo">
            <img src="/assets/images/logo-icon.png" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="/dashboard">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            @if (auth()->user()->type === 'admin')
                <li>
                    <a href="/offices">
                        <iconify-icon icon="ci:house-01" class="menu-icon"></iconify-icon>
                        <span>Offices</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->type === 'facility manager' || auth()->user()->type === 'operator')
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
                <li>
                    <a href="/borrowers-log">
                        <iconify-icon icon="mingcute:clipboard-line" class="menu-icon"></iconify-icon>
                        <span>Borrowers Log</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->type === 'facility manager' || auth()->user()->type === 'admin')
                <li>
                    <a href="/users">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="/view-department">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>Students</span>
                    </a>
                </li>
                
            @endif

            @if (auth()->user()->type === 'facility manager' || auth()->user()->type === 'operator')
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                        <span>Transaction</span>
                    </a>

                    <!-- Simplified Sidebar Menu -->
                    <ul class="sidebar-submenu">
                        <!-- Borrow Equipments -->
                        <li>
                            <a href="/borrow-equipment">
                                <iconify-icon icon="icon-park-outline:hold-interface" class="menu-icon"></iconify-icon>
                                Borrow Equipments
                            </a>
                        </li>

                        <!-- Maintenance Equipments -->
                        <li>
                            <a href="/maintenance-equipment">
                                <iconify-icon icon="icon-park-outline:hold-interface" class="menu-icon"></iconify-icon>
                                Maintenance Equipments
                            </a>
                        </li>

                        <!-- Repair Equipments -->
                        <li>
                            <a href="/repair-equipment">
                                <iconify-icon icon="mdi:box-check-outline" class="menu-icon"></iconify-icon>
                                Repair Equipments
                            </a>
                        </li>

                        <!-- Dispose Equipments -->
                        <li>
                            <a href="/dispose-equipment">
                                <iconify-icon icon="icon-park-outline:hold-interface" class="menu-icon"></iconify-icon>
                                Dispose Equipments
                            </a>
                        </li>

                        <!-- Donate Equipments -->
                        <li>
                            <a href="/donate-equipment">
                                <iconify-icon icon="icon-park-outline:hold-interface" class="menu-icon"></iconify-icon>
                                Donate Equipments
                            </a>
                        </li>

                        <!-- Return Equipments -->
                        <li>
                            <a href="/return-equipment">
                                <iconify-icon icon="mdi:box-check-outline" class="menu-icon"></iconify-icon>
                                Return Equipments
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                    <span>Reports</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="/borrowed-equipments">
                            <i class="ri-circle-fill circle-icon text-lilac-600 w-auto" class="menu-icon"></i>
                            Borrowed Equipments
                        </a>
                    </li>
                    <li>
                        <a href="/maintenanced-equipments">
                            <i class="ri-circle-fill circle-icon text-warning-main w-auto" class="menu-icon"></i>
                            In Maintenance Equipments
                        </a>
                    </li>
                    <li>
                        <a href="/repaired-equipments">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto" class="menu-icon"></i>
                            In Repair Equipments
                        </a>
                    </li>
                    <li>
                        <a href="/donated-equipments">
                            <i class="ri-circle-fill circle-icon text-info-main w-auto" class="menu-icon"></i>
                            Donated Equipments
                        </a>
                    </li>
                    <li>
                        <a href="/disposed-equipments">
                            <i class="ri-circle-fill circle-icon text-danger-main w-auto" class="menu-icon"></i>
                            Disposed Equipments
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
