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
          <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
              <span>Borrow</span> 
            </a>
            <ul class="sidebar-submenu">
              <li>
                <a href="/borrower-form"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Borrow equipments</a>
              </li>
              <li>
                <a href="/return-equipment"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Return equipments</a>
              </li>
              </li>
            </ul>
          </li>
        @endif
        @if (auth()->user()->type === 'facility manager' || auth()->user()->type === 'admin')
            <li>
                <a href="/users">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Users</span>
                </a>
            </li>
        @endif
        <li>
          <a href="/profile">
            <iconify-icon icon="flowbite:user-outline" class="menu-icon"></iconify-icon>
            <span>Profile</span>
          </a>
        </li>
        <li class="dropdown">
          <a href="javascript:void(0)">
              <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
            <span>Reports</span> 
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="invoice-list.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Available equipments</a>
            </li>
            <li>
              <a href="/borrowed-equipments"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Borrowed equipments</a>
            </li>
            <li>
              <a href="invoice-add.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>In maintenance equipments</a>
            </li>
            <li>
              <a href="invoice-edit.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>In repair equipments</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </aside>