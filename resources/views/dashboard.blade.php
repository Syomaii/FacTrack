@include('templates.header')
<x-sidebar />

  <main class="dashboard-main">
    <x-navbar />

    @if (session('loginUserSuccessfully'))
        <div
            class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                {{ session('loginUserSuccessfully') }}
            </div>
        </div>
    @endif

    <div class="dashboard-main-body">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
          <li class="fw-medium">
            <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
              <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
              Dashboard
            </a>
          </li>
        </ul>
      </div>

      <div class="row row-cols-xxxl-4 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4">
        <div class="col">
          <div class="card shadow-none border bg-gradient-start-1 h-100">
            <div class="card-body p-20">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                  <p class="fw-medium text-primary-light mb-1">Total Users</p>
                  <h6 class="mb-0">{{ $userCount }}</h6>
                </div>
                <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                  <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl mb-0"></iconify-icon>
                </div>
              </div>
            </div>
          </div><!-- card end -->
        </div>
        <div class="col">
          <div class="card shadow-none border bg-gradient-start-2 h-100">
            <div class="card-body p-20">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                  <p class="fw-medium text-primary-light mb-1">Total Equipments</p>
                  <h6 class="mb-0">{{ $equipmentCount }}</h6>
                </div>
                <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                  <iconify-icon icon="mingcute:computer-line" class="text-white text-2xl mb-0"></iconify-icon>
                </div>
              </div>
            </div>
          </div><!-- card end -->
        </div>
        <div class="col">
          <div class="card shadow-none border bg-gradient-start-3 h-100">
            <div class="card-body p-20">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                  <p class="fw-medium text-primary-light mb-1">Total Borrowed Equipments</p>
                  <h6 class="mb-0">28</h6>
                </div>
                <div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                  <iconify-icon icon="solar:document-text-outline" class="text-white text-2xl mb-0"></iconify-icon>
                </div>
              </div>
            </div>
          </div><!-- card end -->
        </div>
        <div class="col">
          <div class="card shadow-none border bg-gradient-start-4 h-100">
            <div class="card-body p-20">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                  <p class="fw-medium text-primary-light mb-1">Total In Repair Equipments </p>
                  <h6 class="mb-0">42</h6>
                </div>
                <div
                  class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                  <iconify-icon icon="mingcute:tool-line" class="text-white text-2xl mb-0"></iconify-icon>
                </div>
              </div>
            </div>
          </div><!-- card end -->
        </div>
      </div>

      <div class="row gy-4 mt-1">
        <div class="col-xxl-12 col-xl-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h6 class="text-lg mb-0">Borrowed Equipments Per Month</h6>
              </div>
              <div id="chart" class="pt-28 apexcharts-tooltip-style-1"></div>
            </div>
          </div>
        </div>

        <div class="col-xxl-9 col-xl-12">
          <div class="card h-100 p-0 radius-12">
            <div
              class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
              <div class="d-flex align-items-center flex-wrap gap-3">
                <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                  <option>6</option>
                  <option>7</option>
                  <option>8</option>
                  <option>9</option>
                  <option>10</option>
                </select>
                <form class="navbar-search">
                  <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search">
                  <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
                <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                  <option>Status</option>
                  <option>Active</option>
                  <option>Inactive</option>
                </select>
              </div>
            </div>
            <div class="card-body p-24">
              <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Designation</th>
                      <th scope="col" class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="flex-grow-1">
                            @if (auth()->check())
                              <span class="text-md mb-0 fw-normal text-secondary-light">{{ auth()->user()->firstname }}</span>
                            @endif
                          </div>
                        </div>
                      </td>
                      <td><span class="text-md mb-0 fw-normal text-secondary-light">janettetanquis@gmail.com</span></td>
                      <td>Dean</td>
                      <td class="text-center">
                        <span
                          class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Active</span>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>

              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                <span>Showing 1 to 10 of 12 entries</span>
                <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                  <li class="page-item">
                    <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                      href="javascript:void(0)"><iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon></a>
                  </li>
                  <li class="page-item">
                    <a class="page-link text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md bg-primary-600 text-white"
                      href="javascript:void(0)">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"
                      href="javascript:void(0)">2</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                      href="javascript:void(0)">3</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                      href="javascript:void(0)">4</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                      href="javascript:void(0)">5</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"
                      href="javascript:void(0)"> <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon> </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                <h6 class="mb-2 fw-bold text-lg mb-0">Last Login</h6>
              </div>

              <div class="mt-32">

                <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                      <h6 class="text-md mb-0 fw-medium">Paul Ngujo</h6>
                    </div>
                  </div>
                  <span class="text-sm text-secondary-light fw-medium">1 min ago</span>
                </div>

                <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                      <h6 class="text-md mb-0 fw-medium">Glyka Oscar</h6>
                    </div>
                  </div>
                  <span class="text-sm text-secondary-light fw-medium">28 mins ago</span>
                </div>

                <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                      <h6 class="text-md mb-0 fw-medium">Christian Putol</h6>
                    </div>
                  </div>
                  <span class="text-sm text-secondary-light fw-medium">20 hrs ago</span>
                </div>

                <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                      <h6 class="text-md mb-0 fw-medium">Juje Sultan</h6>
                    </div>
                  </div>
                  <span class="text-sm text-secondary-light fw-medium">1 day ago</span>
                </div>

                <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                      <h6 class="text-md mb-0 fw-medium">Kent Dumagpi</h6>
                    </div>
                  </div>
                  <span class="text-sm text-secondary-light fw-medium">5 days ago</span>
                </div>


        

              </div>

            </div>
          </div>
        </div>
        
      </div>
    </div>  
@include('templates.footer_inc')
@include('templates.footer')