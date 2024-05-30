<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">Distribution Menu</li>
            <li class="nav-item">
                <a href="{{ url('/verifikator/distribusi') }}" class="nav-link {{ $activeMenu == 'distribusi' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-bookmark"></i>
                    <p>Distribusi Barang JTI</p>
                </a>
            </li>
            <li class="nav-header">User Settings</li>
            <li class="nav-item">
                <a href="{{ url('/verifikator/profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profile</p>
                </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('logout') }}" class="nav-link">
                  <p>Logout</p>
              </a>
          </li>
        </ul>
    </nav>
</div>

