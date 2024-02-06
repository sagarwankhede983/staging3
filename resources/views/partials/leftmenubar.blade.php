<style type="text/css">
    .sb-sidenav-dark .sb-sidenav-menu .nav-link .sb-nav-link-icon {

        color: rgba(247, 241, 241, 0.93);

    }

    .sb-sidenav-dark .sb-sidenav-menu .nav-link:hover {
        color: #ffc107;
    }
</style>

<?php
$tdate = date('m-d-Y');
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <?php
    $user_role_session=session()->get('userrole');
    if($user_role_session!="User")

    {
      ?>
        <!-- Super Admin & Admin Left Side Bar  -->
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="/bypassauth2">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsMenu"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    {{ trans('global.manageMenu.title') }}
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsMenu" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?php
                                if($todayDate=="" || $todayDate==$tdate){
                                ?>
                        <a class="nav-link" href="/fromDashboardTodayMenu"> {{ trans('global.todayMenu.title') }}</a>
                        <?php
                                }
                                else
                                {
                                ?>
                        <a class="nav-link" href="/fromDashboardOnDateMenu/{{ base64_encode($todayDate) }}">Menus</a>
                        <?php
                                }
                                ?>
                        <a class="nav-link" href="/fromDashboardOnDateMenu">On Date Menu</a>
                        <a class="nav-link" href="/fromDashboardWeeklyMenu">
                            {{ trans('global.betweenDateMenu.title') }}</a>
                    </nav>
                </div>
                <?php
                if($user_role_session!="Admin")
                {
                  ?>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsUser"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    {{ trans('global.manageUser') }}
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsUser" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="/addnewuserpage">{{ trans('global.addUser') }}</a>
                        <a class="nav-link" href="/edituserpage"> {{ trans('global.editUser') }}</a>
                        <a class="nav-link" href="/viewallusers"> {{ trans('global.viewUser') }}</a>
                    </nav>
                </div>
                <?php
                }
                ?>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsHunt"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Hunting Reservation
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsHunt" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?php
                                if($todayDate=="" || $todayDate==$tdate){
                                ?>
                        <a class="nav-link" href="/fromDashboardTodayGuideReservation">Today's Reservation</a>
                        <?php
                                }
                                else
                                {
                                ?>
                        <a class="nav-link" href="/fromDashboardTodayGuideReservation">Reservation</a>
                        <?php
                                }
                                ?>

                        <a class="nav-link" href="/fromDashboardOnDateGuideReservation"> On Date Reservation</a>
                        <a class="nav-link" href="/fromDashboardGuideShedule"> Guide Schedule</a>
                        <a class="nav-link" href="/fromDashboardHuntingcalenderRevised/Calender"> Calendar</a>
                        <a class="nav-link" href="/fromDashboardHuntingcalenderRevised/Extract"> Extract Hunting
                            Data</a>
                    </nav>
                </div>
                <?php
                                if($todayDate=="" || $todayDate==$tdate){
                                ?>
                <a class="nav-link" href="/fromDashboardTodayBreakfast">
                    <div class="sb-nav-link-icon"><i class="fa fa-coffee"></i></div>
                    {{ trans('global.todaybreakfast') }}
                </a>
                <a class="nav-link" href="/fromDashboardTodayLunch">
                    <div class="sb-nav-link-icon">
                        <img src="{{ url('/images/lunch.png') }}" height="15" width="15"
                            style="margin-bottom:3%"></img>
                    </div>
                    {{ trans('global.todaylunch') }}
                </a>
                <a class="nav-link" href="/fromDashboardTodayDinner">
                    <div class="sb-nav-link-icon"><img src="{{ url('/images/dinner.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></div>
                    {{ trans('global.todaydinner') }}
                </a>
                <a class="nav-link" href="/fromDashboardTodayAppetizer">
                    <div class="sb-nav-link-icon"><i class="fa fa-cocktail"></i></div>
                    Today's Cocktails
                </a>
                <?php
                                }
                                else
                                {
                                ?>
                <a class="nav-link" href="/fromDashboardOnDateBreakfast/{{ base64_encode($todayDate) }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-coffee"></i></div>
                    Breakfast
                </a>
                <a class="nav-link" href="/fromDashboardOnDateLunch/{{ base64_encode($todayDate) }}">
                    <div class="sb-nav-link-icon"> <img src="{{ url('/images/lunch.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></i></div>
                    Lunch
                </a>
                <a class="nav-link" href="fromDashboardOnDateDinner/{{ base64_encode($todayDate) }}">
                    <div class="sb-nav-link-icon"><img src="{{ url('/images/dinner.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></div>
                    Dinner
                </a>
                <a class="nav-link" href="/fromDashboardOnDateAppetizer/{{ base64_encode($todayDate) }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-cocktail"></i></div>
                    Cocktails
                </a>
                <?php
                                }
                                ?>
                <a class="nav-link" href="/fromDashboardWeeklyMenu">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                    Calendar
                </a>
                <!-- <a class="nav-link" href="/gallary">
                    <div class="sb-nav-link-icon"><img src="{{ url('/images/gallary.png') }}" height="15" width="15"
                            style="margin-bottom:3%"></img></div>
                    Gallery
                </a> -->
                {{-- Code Added On 02-01-2024 --}}
                <a class="nav-link" href="/fromDashboardStaffBooking">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Staff Booking
                </a>
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseItemOption" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><img src="{{ url('/images/itemListIcon.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></div>
                    Items
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseItemOption" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        {{-- 18/08/2023 --}}
                        <?php
                        if($user_role_session!="Admin")
                        {
                          ?> <a class="nav-link" href="/dailyEmailSetup">Scheduler Email Setup</a>
                          <?php } ?>
                        <a class="nav-link" href="/getItemListFromMater"> Item List</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseCustomersOption" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Customers
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCustomersOption" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="/getpmschargedbycodefoliodetails">PMS Charge by Code</a>
                        <a class="nav-link" href="/goToCustomerMatchFun">Customers without Customer Code</a>
                        <a class="nav-link" href="/pmsRoomNoNightsBlank">PMS-Room Reservation List</a>
                        <a class="nav-link" href="/pmsRoomReservationOnCalendar">PMS-Room Reservation Calendar</a>
                        <a class="nav-link" href="/cateringRoomNoNightsBlank">Catering-Room Reservation List</a>
                        <a class="nav-link" href="/catRoomReservationOnCalendar">Catering-Room Reservation
                            Calendar</a>
                    </nav>
                </div>

                <a class="nav-link" href="/logoutfromdashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    {{ trans('global.logout') }}
                </a>
            </div>
        </div>
        <?php
    }
    else
    {
      $user_sub_role_session=session()->get('sub_role');
      if($user_role_session=='User' && $user_sub_role_session=='Hunting-Reservation')
      {
        ?>
        <!-- Hunting User left Side Bar -->
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="/bypassauth2">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseLayoutsHunt" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Hunting Reservation
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsHunt" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?php
                                if($todayDate=="" || $todayDate==$tdate){
                                ?>
                        <a class="nav-link" href="/fromDashboardTodayGuideReservation">Today's Reservation</a>
                        <?php
                                }
                                else
                                {
                                ?>
                        <a class="nav-link" href="">Reservation</a>
                        <?php
                                }
                                ?>
                        <a class="nav-link" href="/fromDashboardOnDateGuideReservation"> On Date Reservation</a>
                        <a class="nav-link" href="/fromDashboardGuideShedule"> Guide Schedule</a>
                    </nav>
                </div>
                {{-- //Change on 15-05-2023 --}}
                <a class="nav-link" href="/fromDashboardHuntingcalenderRevised/Calender">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                    Calendar
                </a>
                <a class="nav-link" href="/fromDashboardHuntingcalenderRevised/Extract">
                    <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                    Extract Hunting Data
                </a>
                <a class="nav-link" href="/logoutfromdashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    {{ trans('global.logout') }}
                </a>
            </div>
        </div>
        <?php
      }
      else
      {
        ?>
        <!-- Catering User left Side bar -->
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="/bypassauth2">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseLayoutsMenu" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    {{ trans('global.manageMenu.title') }}
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutsMenu" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?php
                                if($todayDate=="" || $todayDate==$tdate){
                                ?>
                        <a class="nav-link" href="/fromDashboardTodayMenu"> {{ trans('global.todayMenu.title') }}</a>
                        <?php
                                }
                                else
                                {
                                ?>
                        <a class="nav-link" href="/fromDashboardOnDateMenu/{{ base64_encode($todayDate) }}">Menus</a>
                        <?php
                                }
                                ?>
                        <a class="nav-link" href="/fromDashboardOnDateMenu">On Date Menu</a>
                        <a class="nav-link" href="/fromDashboardWeeklyMenu">
                            {{ trans('global.betweenDateMenu.title') }}</a>
                    </nav>
                </div>
                <?php
                                if($todayDate=="" || $todayDate==$tdate){
                                ?>
                <a class="nav-link" href="/fromDashboardTodayBreakfast">
                    <div class="sb-nav-link-icon"><i class="fa fa-coffee"></i></div>
                    {{ trans('global.todaybreakfast') }}
                </a>
                <a class="nav-link" href="/fromDashboardTodayLunch">
                    <div class="sb-nav-link-icon"> <img src="{{ url('/images/lunch.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></div>
                    {{ trans('global.todaylunch') }}
                </a>
                <a class="nav-link" href="/fromDashboardTodayDinner">
                    <div class="sb-nav-link-icon"><img src="{{ url('/images/dinner.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></div>
                    {{ trans('global.todaydinner') }}
                </a>
                <a class="nav-link" href="/fromDashboardTodayAppetizer">
                    <div class="sb-nav-link-icon"><i class="fa fa-cocktail"></i></div>
                    Today's Cocktails
                </a>
                <?php
                                }
                                else
                                {
                                ?>
                <a class="nav-link" href="/fromDashboardOnDateBreakfast/{{ base64_encode($todayDate) }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-coffee"></i></div>
                    Breakfast
                </a>
                <a class="nav-link" href="/fromDashboardOnDateLunch/{{ base64_encode($todayDate) }}">
                    <div class="sb-nav-link-icon"> <img src="{{ url('/images/lunch.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></div>
                    Lunch
                </a>
                <a class="nav-link" href="/fromDashboardOnDateDinner/{{ base64_encode($todayDate) }}">
                    <div class="sb-nav-link-icon"><img src="{{ url('/images/dinner.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></div>
                    Dinner
                </a>
                <a class="nav-link" href="/fromDashboardOnDateAppetizer/{{ base64_encode($todayDate) }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-cocktail"></i></div>
                    Cocktails
                </a>
                <?php
                                }
                                ?>
                <a class="nav-link" href="/fromDashboardWeeklyMenu">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                    Calender
                </a>
                <!-- <a class="nav-link" href="/gallary">
                    <div class="sb-nav-link-icon"><img src="{{ url('/images/gallary.png') }}" height="15" width="15"
                            style="margin-bottom:3%"></img></div>
                    Gallery
                </a> -->
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseItemOption" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><img src="{{ url('/images/itemListIcon.png') }}" height="15"
                            width="15" style="margin-bottom:3%"></img></div>
                    Items
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseItemOption" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        {{-- 18/8/2023 --}}
                        {{-- <a class="nav-link" href="/dailyEmailSetup">Scheduler Email Setup</a> --}}
                        <a class="nav-link" href="/getItemListFromMater"> Item List</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseCustomersOption" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Customers
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCustomersOption" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="/getpmschargedbycodefoliodetails">PMS Charge by Code</a>
                        <a class="nav-link" href="/goToCustomerMatchFun">Customers without Customer Code</a>
                        <a class="nav-link" href="/pmsRoomNoNightsBlank">PMS-Room Reservation List</a>
                        <a class="nav-link" href="/pmsRoomReservationOnCalendar">PMS-Room Reservation Calendar</a>
                        <a class="nav-link" href="/cateringRoomNoNightsBlank">Catering-Room Reservation List</a>
                        <a class="nav-link" href="/catRoomReservationOnCalendar">Catering-Room Reservation
                            Calendar</a>
                    </nav>
                </div>
                <a class="nav-link" href="/logoutfromdashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    {{ trans('global.logout') }}
                </a>

            </div>
        </div>
        <?php
      }
    }
?>
    </nav>
</div>
