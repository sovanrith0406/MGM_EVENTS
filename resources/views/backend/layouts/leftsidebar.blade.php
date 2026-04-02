<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="{{ url('dashboard') }}" class="brand-link text-center" style="padding: 10px 0;">
    <img src="{{ asset('assets/dist/img/logo.png') }}" alt="MGM Event Logo"
         style="width: 80%; max-height: 45px; object-fit: contain;">
  </a>

  <div class="sidebar">

    {{-- User Panel --}}
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(auth()->user()->avatar_url)
          <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}"
               class="img-circle elevation-2"
               style="width:35px; height:35px; object-fit:cover;" alt="User Image">
        @else
          <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}"
               class="img-circle elevation-2"
               style="width:35px; height:35px; object-fit:cover;" alt="User Image">
        @endif
      </div>
      <div class="info">
        <a href="{{ route('profile.index') }}" class="d-block">
          {{ auth()->user()->full_name }}
        </a>
        <span class="badge badge-{{ auth()->user()->isAdmin() ? 'danger' : (auth()->user()->isSupplier() ? 'warning' : 'info') }}">
          {{ auth()->user()->role->role_name ?? 'Unknown' }}
        </span>
      </div>
    </div>

    {{-- Search --}}
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- Dashboard — all roles --}}
        <li class="nav-item @yield('d_menu-open')">
          <a href="{{ url('/dashboard') }}" class="nav-link @yield('d_active')">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        {{-- Events — Admin + User --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isUser())
        <li class="nav-item @yield('e_menu-open')">
          <a href="{{ route('events.index') }}" class="nav-link @yield('e_active')">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Events</p>
          </a>
        </li>
        @endif

        {{-- Speakers — Admin + User --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isUser())
        <li class="nav-item @yield('s_menu-open')">
          <a href="{{ url('/speakers') }}" class="nav-link @yield('s_active')">
            <i class="nav-icon fas fa-microphone"></i>
            <p>Speakers <span class="right badge badge-danger">New</span></p>
          </a>
        </li>
        @endif

        {{-- Schedule — Admin + User --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isUser())
        <li class="nav-item @yield('sc_menu-open')">
          <a href="{{ url('/schedule') }}" class="nav-link @yield('sc_active')">
            <i class="nav-icon fas fa-copy"></i>
            <p>Schedule</p>
          </a>
        </li>
        @endif

        {{-- Sponsors — Admin + User --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isUser())
        <li class="nav-item @yield('sp_menu-open')">
          <a href="{{ url('/sponsors') }}" class="nav-link @yield('sp_active')">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>Sponsors</p>
          </a>
        </li>
        @endif

        {{-- Booking — Admin + Supplier --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isSupplier())
        <li class="nav-item @yield('b_menu-open')">
          <a href="{{ url('/supplier_booking') }}" class="nav-link @yield('b_active')">
            <i class="nav-icon fas fa-edit"></i>
            <p>Booking</p>
          </a>
        </li>
        @endif

        {{-- Users — Admin only --}}
        @if(auth()->user()->isAdmin())
        <li class="nav-item @yield('u_menu-open')">
          <a href="{{ url('/users') }}" class="nav-link @yield('u_active')">
            <i class="nav-icon fas fa-users"></i>
            <p>User</p>
          </a>
        </li>
        @endif

        {{-- Mailbox — all roles --}}
        <li class="nav-item @yield('mb_menu-open')">
          <a href="{{ route('mailbox.index') }}" class="nav-link @yield('mb_active')">
            <i class="nav-icon fas fa-envelope"></i>
            <p>Mailbox</p>
          </a>
        </li>

        {{-- Reports — Admin + User --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isUser())
        <li class="nav-item @yield('r_menu-open')">
          <a href="{{ route('reports.booking') }}" class="nav-link @yield('r_active')">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Reports</p>
          </a>
        </li>
        @endif

        {{-- Setting --}}
        <li class="nav-header">Setting</li>
        <li class="nav-item @yield('p_menu-open')">
          <a href="#" class="nav-link @yield('p_active')">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>Setting Profile <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('/profile') }}" class="nav-link @yield('profile_sub_active')">
                <i class="far fa-user nav-icon"></i>
                <p>Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon text-danger"></i>
                <p>Logout</p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
              </form>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</aside>