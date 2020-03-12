<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <!--<a href="index.html" class="logo">-->
                    <!--Zircos-->
                <!--</a>-->
                <!-- Image Logo -->
                <!-- <a href="index.html" class="logo">
                    <img src="assets/images/logo.png" alt="" height="30">
                </a> -->
                <a href="javascript:void(0);" class="logo">
                   <i class="mdi mdi-airplane-takeoff"></i> SR TOURS & TRAVELS <i class="mdi mdi-airplane-landing"></i>
                </a>

            </div>
            <!-- End Logo container-->


            <div class="menu-extras">

                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="navbar-c-items">
                        <form role="search" class="navbar-left app-search pull-left hidden-xs">
                             <input type="text" placeholder="Search..." class="form-control">
                             <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>

                    <li class="dropdown navbar-c-items">
                         <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                            <i class="mdi mdi-email"></i>
                            <span class="badge up bg-danger">8</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">
                            <li class="text-center">
                                <h5>Messages</h5>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="avatar">
                                        <img src="assets/images/users/avatar-2.jpg" alt="">
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Patricia Beach</span>
                                        <span class="desc">There are new settings available</span>
                                        <span class="time">2 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="avatar">
                                        <img src="assets/images/users/avatar-3.jpg" alt="">
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Connie Lucas</span>
                                        <span class="desc">There are new settings available</span>
                                        <span class="time">2 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="avatar">
                                        <img src="assets/images/users/avatar-4.jpg" alt="">
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Margaret Becker</span>
                                        <span class="desc">There are new settings available</span>
                                        <span class="time">2 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="all-msgs text-center">
                                <p class="m-0"><a href="#">See all Messages</a></p>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown navbar-c-items">
                         <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                            <i class="mdi mdi-bell"></i>
                            <span class="badge up bg-success">4</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">
                            <li class="text-center">
                                <h5>Notifications</h5>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="icon bg-info">
                                        <i class="mdi mdi-account"></i>
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">New Signup</span>
                                        <span class="time">5 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="icon bg-danger">
                                        <i class="mdi mdi-comment"></i>
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">New Message received</span>
                                        <span class="time">1 day ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="icon bg-warning">
                                        <i class="mdi mdi-settings"></i>
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Settings</span>
                                        <span class="time">1 day ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="all-msgs text-center">
                                <p class="m-0"><a href="#">See all Notification</a></p>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown navbar-c-items">
                        <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                            <li class="text-center">
                                <h5>Hi,  {{ Auth::user()->name }}</h5>
                            </li>
                            <li><a href="javascript:void(0)"><i class="ti-user m-r-5"></i> Profile</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Settings</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-lock m-r-5"></i> Lock screen</a></li>
                            <li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>

                    </li>
                </ul>
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
            <!-- end menu-extras -->

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="navbar-custom">
        <div class="container">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li class="has-submenu">
                        <a href="{{ route('dashboard.index') }}"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ route('crm.index') }}"><i class="mdi mdi-new-box"></i>CRM</a>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-airplane-takeoff"></i>FLIGHT</a>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-hotel"></i>HOTEL</a>
                    </li>
                    <!-- <li class="has-submenu"><a href="{{ route('paxprofile.index') }}"><i class="mdi mdi-account-multiple"></i>PAX PROFILE</a></li> -->
                    <li class="has-submenu">
                        <a href="{{ route('paxprofile.index') }}"><i class="mdi mdi-layers"></i>PAX PROFILE</a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li>
                                        <span>Client Details</span>
                                    </li>
                                     <li><a href="{{ route('passport.index')}}">Passport</a></li>
                                    <li><a href="{{ route('membershipcard.index')}}">Membership Card</a></li>
                                    <li><a href="javascript:void(0);">Other Document</a></li>
                                    <li><a href="javascript:void(0);">Insurance Document</a></li>
                                    <li><a href="javascript:void(0);">Visa Document</a></li>
                                </ul>
                            </li>
                            <li>
                                <ul>
                                    <li>
                                        <span>Travel History</span>
                                    </li>
                                    <li><a href="ui-notifications.html">Travel History</a></li>
                                    <li><a href="ui-alerts.html">Hotel History</a>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ route('protector.index') }}"><i class="mdi mdi-lock"></i>LOGIN PROTECTOR</a>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ route('accountopen.index') }}"><i class="mdi mdi-lock"></i>ACCOUNT OPEN</a>
                    </li>
                   <!--  <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-diamond"></i>Components</a>
                        <ul class="submenu">
                            <li class="has-submenu">
                                <a href="#">Forms</a>
                                <ul class="submenu">
                                    <li><a href="form-elements.html">Form Elements</a></li>
                                    <li><a href="form-advanced.html">Form Advanced</a></li>
                                    <li><a href="form-validation.html">Form Validation</a></li>
                                    <li><a href="form-pickers.html">Form Pickers</a></li>
                                    <li><a href="form-wizard.html">Form Wizard</a></li>
                                    <li><a href="form-mask.html">Form Masks</a></li>
                                    <li><a href="form-summernote.html">Summernote</a></li>
                                    <li><a href="form-wysiwig.html">Wysiwig Editors</a></li>
                                    <li><a href="form-uploads.html">Multiple File Upload</a></li>
                                </ul>
                            </li>

                        </ul>
                    </li> -->
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->
