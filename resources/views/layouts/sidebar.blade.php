  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
<!--       <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light pl-2">
        <strong style="font-weight: 700; font-size: 15px !important">
          Complaint Management System
        </strong>
      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(Auth::user()->role == 'sa')
            <img src="{{ asset('img/avatars/avatar-male.png') }}" class="img-circle elevation-2" alt="User Image">
          @else
            @if(Auth::user()->role == 'admin')
              <img src="{{ asset('img/avatars/avatar-male.png') }}" class="img-circle elevation-2" alt="User Image">
            @else
              @if(Auth::user()->patient['gender'] == "Male")
                <img src="{{ asset('/img/avatars/avatar-male.png') }}" class="img-circle elevation-2" alt="User Image">
              @else
                <img src="{{ asset('/img/avatars/avatar-female.png') }}" class="img-circle elevation-2" alt="User Image">
              @endif
            @endif
          @endif
        </div>
        <div class="info">
          @if(Auth::user()->role == 'sa')
            <a href="#" class="d-block">Admin</a>
          @elseif(Auth::user()->role == 'admin')
            <a href="#" class="d-block user_name">Admin</a>
          @else
            <a href="#" class="d-block user_name">{{ Auth::user()->patient['first_name'] .' ' .Auth::user()->patient['last_name']}}</a>
            <small class="user_name" style="color: #fff !important">Patient</small>
          @endif
        </div>
      </div>

      <!-- SidebarSearch Form -->
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

      <!-- Sidebar Menu -->
      @if(Auth::user()->role == 'sa' || Auth::user()->role == 'admin')
        @include('layouts.menu')
      @else
        @include('layouts.patient_menu')
      @endif
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>