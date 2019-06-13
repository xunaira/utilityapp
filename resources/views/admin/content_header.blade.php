<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <form class="form-header" action="" method="POST">
                    
                </form>
                <div class="header-button">
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        @if($bal == 0)
                            <span class="badge badge-primary mr-3" style="font-size: 16px; font-weight: 500; padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem;">System Balance: &#8358; 0</span>
                        @else
                            <span class="badge badge-primary mr-3" style="font-size: 16px; font-weight: 500; padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem;">System Balance: &#8358; {{$bal}}</span>
                        @endif
                    @elseif(Auth::user()->role_id == 3)
                        <span class="badge badge-primary mr-3" style="font-size: 16px; font-weight: 500; padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem;">System Balance: &#8358; {{$bal}}</span>
                    @endif
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="{{Storage::url($pic->pic)}}" alt="John Doe" />
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#">{{Auth::user()->name}} </a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#">{{Auth::user()->name}}</a>
                                        </h5>
                                        <span class="email">{{Auth::user()->email}}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-settings"></i>Setting
                                        </a>
                                    </div>                                    
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="{{url('admin/logout')}}">
                                        <i class="zmdi zmdi-power"></i>Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>