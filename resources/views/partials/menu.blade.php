<div class="sidebar" style="display:block !important;">
    <nav class="sidebar-nav" style="display:block !important;">
  @php
$currentRoute = request()->route()->getName();
$isTenantsQuery = request()->query('q') ;
$isBoreholeQuery = request()->query('b') ;

 
@endphp
        <ul class="nav">
            @can('dashboard_access')
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ request()->is('dashboard') || request()->is('dashboard/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-dashboard nav-icon">

                        </i>
                        DASHBOARD
                    </a>
                </li>
            @endcan
            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ strtoupper(trans('cruds.userManagement.title')) }}
                    </a>
                    <ul class="nav-dropdown-items">

                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}"
                                    class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }} 
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul> 
                </li>
            @endcan


            <li class="nav-item nav-dropdown {{$isBoreholeQuery=='borehole' ? 'show open' : ''}}"> 
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-file nav-icon">

                    </i>
                    BOREHOLE WATER
                </a>
                <ul class="nav-dropdown-items">

                    @can('client_access')
                        <li class="nav-item">
                            <a href="{{ route('client.index') }}?b=borehole"
                                class="nav-link {{  $currentRoute=='client.index' && $isBoreholeQuery=='borehole' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('areas.index') }}?b=borehole"
                                class="nav-link {{ $currentRoute=='areas.index' && $isBoreholeQuery=='borehole' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                                Locations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('meter_reading_/4013/1') }}"
                                class="nav-link {{ request()->is('meter') || request()->is('meter/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                                Meter Readings
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="{{ route('billing.index') }}"
                                class="nav-link {{ request()->is('billing') || request()->is('billing/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Bills
                            </a>
                        </li> --}}

                       <li class="nav-item">
                            <a href="{{ route('mobile_transactions.index') }}?b=borehole"
                                class="nav-link {{  $currentRoute=='mobile_transactions.index' && $isBoreholeQuery=='borehole' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Paybill Payments
                            </a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('payment.index') }}"
                                class="nav-link {{ $currentRoute=='payment.index' && $isTenantsQuery=='borehole' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Direct Payments
                            </a>
                        </li>                    
                        

                        <li class="nav-item">
                            <a href="{{ route('balances') }}?b=borehole"
                                class="nav-link {{ $currentRoute=='balances' && $isTenantsQuery=='borehole' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Balances
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('statement.index', ['start' => date('Y-m') . '-01', 'end' => date('Y-m-t', strtotime(date('Y-m-d')))]) }}"
                                class="nav-link {{ request()->is('payment') || request()->is('payment/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Customer Reports
                            </a>
                        </li>                    
                        

                        <li class="nav-item">
                            <a href="{{ route('dashboard.monthly') }}?b=borehole"
                                class="nav-link {{ $currentRoute=='dashboard.monthly' && $isTenantsQuery=='borehole' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Monthly Reports
                            </a>
                        </li>
                    </ul>
                @endcan

        <li class="nav-item nav-dropdown {{$isTenantsQuery=='tenants' ? 'show open' : ''}}">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-file nav-icon">

                    </i>
                   TENANTS
                </a>
                <ul class="nav-dropdown-items">

                    @can('client_access')
                        <li class="nav-item">
                            <a href="{{ route('tenant.index') }}"
                                class="nav-link {{ request()->is('tenants') || request()->is('tenants/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('areas.index') }}?q=tenants"
                                class="nav-link {{ $currentRoute=='areas.index' && $isTenantsQuery=='tenants' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                                Locations
                            </a>
                        </li>
                   

                    <li class="nav-item">
    <a href="{{ route('mobile_transactions.index') }}?q=tenants"
        class="nav-link {{ ($currentRoute=='mobile_transactions.index' && $isTenantsQuery=='tenants') ? 'active' : '' }}">
        <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
        Paybill Payments
    </a>
</li>


                        <!--li class="nav-item">
                            <a href="{{ route('payment.index') }}"
                                class="nav-link {{ request()->is('payment') || request()->is('payment/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Direct Payments
                            </a>
                        </li-->                    
                        

                        <li class="nav-item">
                            <a href="{{ route('balances') }}?q=tenants"
                                class="nav-link {{ $currentRoute=='balances' && $isTenantsQuery=='tenants' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Balances
                            </a>
                        </li>

                        <!--li class="nav-item">
                            <a href="{{ route('statement.index', ['start' => date('Y-m') . '-01', 'end' => date('Y-m-t', strtotime(date('Y-m-d')))]) }}"
                                class="nav-link {{ request()->is('payment') || request()->is('payment/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Customer Reports
                            </a>
                        </li-->                    
                        

                        <li class="nav-item">
                            <a href="{{ route('dashboard.monthly') }}?q=tenants"
                                class="nav-link {{ $currentRoute=='dashboard.monthly' && $isTenantsQuery=='tenants' ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Monthly Reports
                            </a>
                        </li>
                    </ul>
                @endcan

            <li class="nav-item">
                <a href="{{ url('logout-user') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>



    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
