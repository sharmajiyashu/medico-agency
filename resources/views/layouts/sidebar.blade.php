


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

            <li class=" nav-item {{ Request::routeIs('master.payment-status.index', 'master.payment-status.edit','master.payment-status.create','master.payment-mode.index', 'master.payment-mode.edit','master.payment-mode.create','master.order-status.index', 'master.order-status.edit','master.order-status.create') ? 'has-sub open' : '' }} "><a class="d-flex align-items-center" href=""><i data-feather="shopping-bag"></i><span class="menu-title text-truncate" data-i18n="Invoice">Master</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center {{ Request::routeIs('master.payment-status.index', 'master.payment-status.edit','master.payment-status.create') ? 'active' : '' }} " href="{{ route('master.payment-status.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop"> Payment Status</span></a>
                    </li>
                    
                    <li><a class="d-flex align-items-center {{ Request::routeIs('master.payment-mode.index', 'master.payment-mode.edit','master.payment-mode.create') ? 'active' : '' }} " href="{{ route('master.payment-mode.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">Payment Mode</span></a>
                    </li>

                    <li><a class="d-flex align-items-center {{ Request::routeIs('master.order-status.index', 'master.order-status.edit','master.order-status.create') ? 'active' : '' }}" href="{{ Route('master.order-status.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">Order Status</span></a>
                    </li>
                </ul>
            </li>

            @php
                $product_count = DB::table('products')->whereNull('deleted_at')->count();
                $user_count = DB::table('users')->where('role','2')->whereNull('deleted_at')->count();
                $orders = DB::table('orders')->whereNull('deleted_at')->get();
                $orders_count = 0;
                foreach ($orders as $key => $value) {
                    $check_user = Db::table('users')->whereNull('deleted_at')->where('id',$value->user_id)->first();
                    if($check_user){
                        $orders_count ++;
                    }
                }

            @endphp
            <li class=" nav-item {{ Request::routeIs('products.index', 'products.edit','products.create') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('products.index') }}"><i data-feather="box"></i><span class="menu-title text-truncate" >Products</span><span class="badge badge-light-white rounded-pill ms-auto me-1">{{ $product_count }}</span></a>
                
            </li>

            <li class=" nav-item {{ Request::routeIs('users.index', 'users.edit','users.create') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('users.index') }}"><i data-feather="user"></i><span class="menu-title text-truncate" >Customer</span><span class="badge badge-light-white rounded-pill ms-auto me-1">{{ $user_count }}</span></a>
                
            </li>

            <li class=" nav-item {{ Request::routeIs('orders.index', 'orders.show','orders.create') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('orders.index') }}"><i data-feather="shopping-cart"></i><span class="menu-title text-truncate" >Orders</span><span class="badge badge-light-white rounded-pill ms-auto me-1">{{ $orders_count }}</span></a>
                
            </li>
        
        </ul>
    </div>
</div>
<!-- END: Main Menu-->