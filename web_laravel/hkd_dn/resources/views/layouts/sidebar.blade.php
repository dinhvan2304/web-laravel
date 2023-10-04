<nav class="main-header navbar navbar-expand navbar-{{setting('app_theme')}}">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link desktop-toggle" id="toggleClose" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      <a class="nav-link mobile-toggle" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    </li>
  </ul>

  @role('admin')
  <!-- SEARCH FORM -->
  <div class="d-none d-md-block d-lg-block d-xl-block">
    <form method="GET" action="/user" class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" name="search" placeholder="Search users"
          aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
  @endrole

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    @impersonating
    <li class="nav-item">
      <a class="nav-link text-danger btn btn-none btn-outline-primary" href="{{ route('impersonate.leave') }}">
        <p><i class="fa fa-ban mr-2" aria-hidden="true"></i>{{'Exit Impersonation'}}</p>
      </a>
    </li>
    @endImpersonating
    @role('admin')
    <li class="nav-item">
      <div class="dropdown show">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Hệ thống khác
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          @foreach ($menus as $aMenu)
            <a class="dropdown-item" href="{{$aMenu->link}}">{{$aMenu->menu}}</a>
          @endforeach
        </div>
      </div>
    </li>
    @endrole
    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <img src="{{Auth::user()->avatar?Auth::user()->avatar:asset('uploads/avatar/avatar.png')}}" width="28px"
          class="img img-circle  img-responsive" alt="User Image">
        {{auth()->user()->fullname}}
        <i class="fa fa-angle-down right"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        <div class="dropdown-divider"></div>
        <a href="/profile" class="dropdown-item">
          <i class="fa fa-user mr-2"></i> {{ __('app.profile') }}
        </a>

        <a href="/activity-log" class="dropdown-item">
          <i class="fa fa-list mr-2"></i> {{ __('app.activity_log') }}
        </a>

        @role('admin')
        <a href="/settings" class="dropdown-item">
          <i class="fa fa-gear mr-2"></i> {{ __('app.application_settings') }}
        </a>
        @endrole

        <div class="dropdown-divider"></div>
        <a href="/logout" class="dropdown-item dropdown-footer bg-gray"><i class="fa fa-sign-out mr-2"></i> {{
          __('app.logout') }}</a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-{{setting('app_sidebar')}}-light elevation-4">
  <!-- Brand Logo -->
  <div class="navbar-brand d-flex justify-content-center">
    <a class="nav-link toggleopen display-none" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    <a href="/" class="app-logo brand-link">
      @if(setting('app_dark_logo')||setting('app_light_logo'))
      <img
        src="{{(setting('app_sidebar')=='light')? asset('uploads/appLogo/app-logo-dark.png'):asset('uploads/appLogo/app-logo-light.png')}}"
        alt="App Logo" class=" img brand-image img-responsive opacity-8">

      @else
      <img
        src="{{(setting('app_sidebar')=='light')? asset('uploads/appLogo/logo-dark.png'):asset('uploads/appLogo/logo-light.png')}}"
        alt="App Logo" class="img brand-image img-responsive opacity-8">

      @endif
    </a>

  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <a href="/profile"><img src="{{Auth::user()->avatar?Auth::user()->avatar:asset('uploads/avatar/avatar.png')}}"
            width="40px" class="img img-circle  img-responsive" alt="User Image"></a>
      </div>
      <div class="info">
        <a href="/profile" class="d-block">{{Auth::user()->firstname}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <!-- <li class="nav-item">
          <a href="/dashboard" class="nav-link {{request()->is('dashboard')? 'sidebar-active':''}}">
            <i class="nav-icon fa fa-home"></i>
            <p>
              {{ __('app.dashboard') }}
            </p>
          </a>
        </li> -->
        <!--  -->
        @hasanyrole('admin')<li class="nav-item {{request()->is('hkd')? 'menu-open':''}}">
          <a href="/hkd" class="nav-link {{request()->is('/hkd')? 'sidebar-active':''}}">
          <i class="nav-icon fa fa-search"></i>
            <p>
              Tra cứu dữ liệu HKD
            </p>
          </a>
        </li>
        <li class="nav-item {{request()->is('vnptthuebao')? 'menu-open':''}}">
          <a href="/vnptthuebao" class="nav-link {{request()->is('/vnptthuebao')? 'sidebar-active':''}}">
          <i class="nav-icon fa fa-search"></i>
            <p>
              Tra Thuê bao VNPT theo d/vụ
            </p>
          </a>
        </li>
        @endrole
		@hasanyrole('admin|users')
        <li class="nav-item {{request()->is('dashboard/ca-service')? 'menu-open':''}}">
          <a href="/dashboard/ca-service" class="nav-link {{request()->is('/dashboard/ca-service')? 'sidebar-active':''}}">
          <i class="nav-icon fa fa-search"></i>
            <p>
              Dashboard dịch vụ CA
            </p>
          </a>
        </li>
        @endrole
        @hasanyrole('admin')
        <!-- <li class="nav-item {{request()->is('dashboard/ca-revenue')? 'menu-open':''}}">
          <a href="/dashboard/ca-revenue" class="nav-link {{request()->is('/dashboard/ca-revenue')? 'sidebar-active':''}}">
          <i class="nav-icon fa fa-search"></i>
            <p>
              Dashboard doanh thu CA
            </p>
          </a>
        </li> -->
        @endrole
        <li class="nav-item {{request()->is('dashboard/statistic*')? 'menu-open':''}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-line-chart"></i>
            <p>
              Thống kê
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
            <ul class="nav nav-treeview">
            @hasanyrole('admin|users')
              <li class="nav-item">
                <a href="/dashboard/statistic-vnptthuebao" class="nav-link {{request()->is('dashboard/statistic-vnptthuebao')? 'sidebar-active':''}}">
                  <p>
                    Thuê bao theo địa bàn
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/dashboard/statistic-newclients" class="nav-link {{request()->is('dashboard/statistic-newclients')? 'sidebar-active':''}}">
                  <p>
                    Doanh nghiệp mới thành lập
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/dashboard/statistic-sme" class="nav-link {{request()->is('dashboard/statistic-sme')? 'sidebar-active':''}}">
                  <p>
                    Doanh nghiệp theo địa bàn
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/dashboard/statistic" class="nav-link {{request()->is('dashboard/statistic')? 'sidebar-active':''}}">
                  <p>
                    Hộ kinh doanh theo địa bàn
                  </p>
                </a>
              </li>
            @endrole
          </ul>
        </li>
        
        @role('admin')

        <li class="nav-header">Admin</li>
        
        @endrole


        @role('admin')
        <li class="nav-item">
          <a href="{{route('settings.index')}}" class="nav-link {{request()->is('settings')? 'sidebar-active':''}}">
            <i class="nav-icon fa fa-gear"></i>
            <p>
              {{ __('app.application_settings') }}
            </p>
          </a>
        </li>
        @endrole
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
