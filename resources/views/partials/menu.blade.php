<style>
.nav .open>a,
.nav .open>a:focus,
.nav .open>a:hover {
    background-color: #20a8d8;
    border-color: #337ab7;
    border-left-color: rgb(51, 122, 183);
}
</style>

<div class="sidebar">
    <nav class="sidebar-nav ps ps--active-y">
        <ul class="nav">
        <?php
            $user_role_session=session()->get('userrole');
            $user_sub_role_session=session()->get('sub_role');
            if($user_role_session=='User' && $user_sub_role_session=='Hunting-Reservation')
            {
                ?>
                    <li class="nav-item">
                        <a href="/bypassauth2" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt">
                            </i>
                            {{ trans('global.dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fromDashboardTodayGuideReservation">
                        <i class="nav-icon fas fa fa-product-hunt"></i>Today's Reservation
                        </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/fromDashboardOnDateGuideReservation">
                      <i class="nav-icon fas fa fa-product-hunt"></i>On Date Reservation
                        </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/fromDashboardGuideShedule">
                      <i class="nav-icon fas fa fa-product-hunt"></i>Guide Schedule
                        </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/fromDashboardHuntingcalender">
                      <i class="nav-icon fa fa-calendar">

                    </i>
                      Calendar
                        </a>
                    </li>
                <?php
            }
            else
            {
                ?>
                     <li class="nav-item">
                <a href="/bypassauth2" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt">
                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="nav-icon fas fa fa-cutlery"></i> {{ trans('global.manageMenu.title') }}
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/fromDashboardTodayMenu">
                            {{ trans('global.todayMenu.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/fromDashboardOnDateMenu">
                            On Date Menus
                        </a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" href="/fromDashboardWeeklyMenu">
                            {{ trans('global.betweenDateMenu.title') }}
                        </a>
                    </li>
                </ul>
            </li>
            
            <?php
            $user_role_session=session()->get('userrole');
            if($user_role_session!="User")
                    {
                    ?>
                    <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="nav-icon fas fa fa-cutlery"></i> Hunting Reservation
                </a>

                <ul class="nav-dropdown-items">
                        <li class="nav-item">
                                <a class="nav-link" href="/fromDashboardTodayGuideReservation">
                                <i class="nav-icon fas fa fa-product-hunt"></i>Today's Reservation
                                </a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="/fromDashboardOnDateGuideReservation">
                            <i class="nav-icon fas fa fa-product-hunt"></i>On Date Reservation
                                </a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="/fromDashboardGuideShedule">
                            <i class="nav-icon fas fa fa-product-hunt"></i>Guide Schedule
                                </a>
                        </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="nav-icon fas fa-user-plus"></i>{{ trans('global.manageUser') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/addnewuserpage">
                            {{ trans('global.addUser') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/edituserpage">
                           {{trans('global.editUser') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/viewallusers">
                            {{trans('global.viewUser') }}
                        </a>
                    </li>

                </ul>
            </li>
                    <?php 
                }
            ?>             
            <li class="nav-item">
                <a href="/fromDashboardWeeklyMenu" class="nav-link">
                    <i class="nav-icon fa fa-calendar">

                    </i>
                    Calendar
                </a>
            </li>
            <li class="nav-item">
                <a href="/fromDashboardTodayBreakfast" class="nav-link">
                    <i class="nav-icon fa fa-coffee">

                    </i>
                    {{ trans('global.todaybreakfast') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="/fromDashboardTodayLunch" class="nav-link">
                    <i class="nav-icon fa fa-cutlery">

                    </i>
                    {{ trans('global.todaylunch') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="/fromDashboardTodayDinner" class="nav-link">
                    <i class="nav-icon fa fa-cutlery">

                    </i>
                    {{ trans('global.todaydinner') }}
                </a>
            </li>
             <li class="nav-item">
                <a href="/fromDashboardTodayAppetizer" class="nav-link">
                    <i class="nav-icon fa fa-cutlery">

                    </i>
                    Today's Cocktails
                </a>
            </li>
            <li class="nav-item">
                <a href="/gallary" class="nav-link">
                    <i class="nav-icon fas fa fa-file-image-o"></i>
                Gallery</a>
            </li>
           <li class="nav-item">
                <?php
            }
           ?>
                <a href="/logoutfromdashboard" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>



        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 869px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 415px;"></div>
        </div>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>