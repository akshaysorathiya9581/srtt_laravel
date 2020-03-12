  <!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <ul>
                	<li class="menu-title">Navigation</li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span class="label label-success pull-right">2</span> <span> Dashboard </span> </a>
                        <ul class="list-unstyled">
                            <li><a href="index.html">Dashboard 1</a></li>
                            <li><a href="dashboard_2.html">Dashboard 2</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-email"></i><span> AIRLINE </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('airlienList.index') }}">AIRLINE LIST</a></li>
                            <li><a href="{{ route('airlineGroup.index') }}">AIRLINE GROUP</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-email"></i><span> USERS </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('users.index') }}">USERS</a></li>
                            <li><a href="{{ route('roles.index') }}">ROLES</a></li>
                            <li><a href="{{ route('permissions.index') }}">PERMISSION</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-email"></i><span> ACCOUNT </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('under.index') }}">UNDER</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('services.index') }}" class="waves-effect"><i class="mdi mdi-calendar"></i><span> SERVICES </span></a></li>
                </ul>

        </div>
        <!-- Sidebar -left -->
    </div>
</div>
    <!-- Left Sidebar End -->
