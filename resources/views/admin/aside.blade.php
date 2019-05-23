<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="images/icon/logo.png" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                        @if (\Request::is('admin/dashboard')) 
                            <li class="active">
                                <a class="js-arrow" href="{{url('admin/dashboard')}}">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            </li>
                            <li>
                                <a href="{{url('admin/products')}}">
                                    <i class="fas fa-chart-bar"></i>Products</a>
                            </li>
                            <li>
                                <a href="{{url('admin/agents')}}">
                                    <i class="fas fa-users"></i>Agents</a>
                            </li>
                            <li>
                                <a href="{{url('admin/users')}}">
                                    <i class="fas fa-users"></i>Users</a>
                            </li>
                            <li>
                                <a href="{{url('admin/agent-sales')}}">
                                    <i class="fas fa-users"></i>Agent Sales</a>
                            </li>
                        @elseif (\Request::is('admin/products') || \Request::is('admin/products/*'))
                            <li>
                                <a class="js-arrow" href="{{url('admin/dashboard')}}">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            </li> 
                            <li class="active">
                                <a href="{{url('admin/products')}}">
                                    <i class="fas fa-chart-bar"></i>Products</a>
                            </li>
                            <li>
                                <a href="{{url('admin/agents')}}">
                                    <i class="fas fa-users"></i>Agents</a>
                            </li>
                            <li>
                                <a href="{{url('admin/users')}}">
                                    <i class="fas fa-users"></i>Users</a>
                            </li>
                            <li>
                                <a href="{{url('admin/agent-sales')}}">
                                    <i class="fas fa-users"></i>Agent Sales</a>
                            </li>
                        @elseif (\Request::is('admin/agents') || \Request::is('admin/agents/*'))
                            <li>
                                <a class="js-arrow" href="{{url('admin/dashboard')}}">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            </li> 
                            <li>
                                <a href="{{url('admin/products')}}">
                                    <i class="fas fa-chart-bar"></i>Products</a>
                            </li>
                            <li class="active">
                                <a href="{{url('admin/agents')}}">
                                    <i class="fas fa-users"></i>Agents</a>
                            </li>
                            <li>
                                <a href="{{url('admin/users')}}">
                                    <i class="fas fa-users"></i>Users</a>
                            </li>
                            <li>
                                <a href="{{url('admin/agent-sales')}}">
                                    <i class="fas fa-users"></i>Agent Sales</a>
                            </li>
                        @elseif (\Request::is('admin/users') || \Request::is('admin/users/*'))
                            <li>
                                <a class="js-arrow" href="{{url('admin/dashboard')}}">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            </li> 
                            <li>
                                <a href="{{url('admin/products')}}">
                                    <i class="fas fa-chart-bar"></i>Products</a>
                            </li>
                            <li>
                                <a href="{{url('admin/agents')}}">
                                    <i class="fas fa-users"></i>Agents</a>
                            </li>
                            <li class="active">
                                <a href="{{url('admin/users')}}">
                                    <i class="fas fa-users"></i>Users</a>
                            </li>
                            <li>
                                <a href="{{url('admin/agent-sales')}}">
                                    <i class="fas fa-users"></i>Agent Sales</a>
                            </li>
                            @elseif (\Request::is('admin/agent-sales') || \Request::is('admin/users/*'))
                            <li>
                                <a class="js-arrow" href="{{url('admin/dashboard')}}">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            </li> 
                            <li>
                                <a href="{{url('admin/products')}}">
                                    <i class="fas fa-chart-bar"></i>Products</a>
                            </li>
                            <li>
                                <a href="{{url('admin/agents')}}">
                                    <i class="fas fa-users"></i>Agents</a>
                            </li>
                            <li>
                                <a href="{{url('admin/users')}}">
                                    <i class="fas fa-users"></i>Users</a>
                            </li>
                            <li class="active">
                                <a href="{{url('admin/agent-sales')}}">
                                    <i class="fas fa-users"></i>Agent Sales</a>
                            </li>
                        @endif
                        
                        
                    </ul>
                </nav>
            </div>
        </aside>