<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="index.html" class="sidebar-logo">
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
            @endif

            @if (auth()->user()->type === 'facility manager' || auth()->user()->type === 'operator')
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                        <span>Transaction</span>
                    </a>

                    <!-- Borrow -->
                    <ul class="sidebar-submenu">
                        <li class="dropdown">
                            <a href="javascript:void(0)">
                                <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                                <span>Borrow</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="/borrow-equipment"><iconify-icon icon="icon-park-outline:hold-interface"
                                            class="menu-icon"></iconify-icon></i>Borrow equipments</a>
                                </li>
                                <li>
                                    <a href="/return-equipment"><iconify-icon icon="mdi:box-check-outline"
                                            class="menu-icon"></iconify-icon></i>Return equipments</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Maintenance -->
                    <ul class="sidebar-submenu">
                        <li class="dropdown">
                            <a href="javascript:void(0)">
                                <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                                <span>Maintenance</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="/borrow-equipment"><iconify-icon icon="icon-park-outline:hold-interface"
                                            class="menu-icon"></iconify-icon></i>Maintenance equipments</a>
                                </li>
                                <li>
                                    <a href="/return-equipment"><iconify-icon icon="mdi:box-check-outline"
                                            class="menu-icon"></iconify-icon></i>Return equipments</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Repair -->
                    <ul class="sidebar-submenu">
                        <li class="dropdown">
                            <a href="javascript:void(0)">
                                <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                                <span>Maintenance</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="/borrow-equipment"><iconify-icon icon="icon-park-outline:hold-interface"
                                            class="menu-icon"></iconify-icon></i>Maintenance equipments</a>
                                </li>
                                <li>
                                    <a href="/return-equipment"><iconify-icon icon="mdi:box-check-outline"
                                            class="menu-icon"></iconify-icon></i>Return equipments</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Dispose -->
                    <ul class="sidebar-submenu">
                        <li class="dropdown">
                            <a href="javascript:void(0)">
                                <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                                <span>Dispose</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="/borrow-equipment"><iconify-icon icon="icon-park-outline:hold-interface"
                                            class="menu-icon"></iconify-icon></i>Dispose equipments</a>
                                </li>
                                <li>
                                    <a href="/borrow-equipment"><iconify-icon icon="icon-park-outline:hold-interface"
                                            class="menu-icon"></iconify-icon></i>Donate equipments</a>
                                </li>
                            </ul>
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
                        <a href="/borrowed-equipments"><iconify-icon icon="mdi:box-clock-outline"
                                class="menu-icon"></iconify-icon></iconify-icon></i>Borrowed equipments</a>
                    </li>
                    <li>
                        <a href="/maintainanced-equipments"><iconify-icon icon="carbon:calendar-tools"
                                class="menu-icon"></iconify-icon></i>In maintenance equipments</a>
                    </li>
                    <li>
                        <a href="/repaired-equipments"><iconify-icon icon="mdi:scheduled-maintenance"
                                class="menu-icon"></iconify-icon></i>In repair equipments</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
