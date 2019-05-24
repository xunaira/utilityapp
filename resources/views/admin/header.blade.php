<header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="images/icon/logo.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
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
                        @endif
                    </ul>
                </div>
            </nav>
        </header>