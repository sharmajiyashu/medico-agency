


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="{{ route('dashboard') }}">
                    <h2 class="brand-text">Medico Agencies</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {{ \Request::is('/') ? 'active' : ''  }}"><a class="d-flex align-items-center" href="{{ url('/') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a>
                
            </li>

            <li class=" nav-item "><a class="d-flex align-items-center" href=""><i data-feather="shopping-bag"></i><span class="menu-title text-truncate" data-i18n="Invoice">Master</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{ route('payment-status.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop"> Payment Status</span></a>
                    </li>
                    
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">Order Status</span></a>
                    </li>

                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">Payment Mode</span></a>
                    </li>
                </ul>
        </li>
        
        </ul>
    </div>
</div>
<!-- END: Main Menu-->