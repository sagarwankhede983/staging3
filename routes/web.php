<?php
use Illuminate\Support\Facades\Route;
 Route::redirect('/', '/login');

 Route::redirect('/home', '/admin');

 Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    Route::resource('users', 'UsersController');

    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');

    Route::resource('products', 'ProductsController');
});
Route::get('fromDashboardTodayMenu','TodayMenuController@getDetailForAllTodayMenu');
Route::get('fromDashboardTodayBreakfast','TodayMenuController@getDetailForAllTodayBreakfast');
Route::get('fromDashboardTodayLunch','TodayMenuController@getDetailForAllTodayLunch');
Route::get('/getItemListFromMater','TodayMenuController@getItemList');
Route::get('fromDashboardTodayDinner','TodayMenuController@getDetailForAllTodayDinner');
Route::get('fromDashboardOnDateMenu','TodayMenuController@openPageForOnDateMenu');
Route::post('/ondateitempageajaxcall','TodayMenuController@openPageForOnDateMenu2');

Route::get('/fromDashboardWeeklyMenu','EventController@calender');
Route::get('viewDetailFromDashboard/{item_id}/{item_name}/{item_desc}/{start_datetime}','TodayMenuController@openViewDetail');
Route::get('/viewCustomerDetailFromItemDetail/{customer_id}/{date}','TodayMenuController@openCustomerDetail');
Route::post('/viewCustomerDetailFromItemDetailOnDate','TodayMenuController@openCustomerDetailOnDate');
// Route::get('generate-pdf','HomeController@generatePDF');
Route::get('/customers/pdf','TodayMenuController@export_pdf');
Route::post('/verifypasswordandconfirmpassword','EmailPasswordConfirm@verifyPassword');
Route::get('/admin/viewUsers','Admin\UsersController@viewuser');
Route::get('/ondatemenusfromcalendar/{filterdate}/{type}','TodayMenuController@openPageForOnDateMenu3');
Route::get('/fromDashboarditem','TodayMenuController@itemPage');
Route::get('/fromDashboarditem2/{item_id}','TodayMenuController@itemRefreshPage');
Route::get('/fromDashboardEvents','TodayMenuController@eventsDetail');
Route::get('/fromDashboardCustomers','TodayMenuController@customerDetail');
Route::post('/bypassauth','TodayMenuController@bypass');
Route::get('/bypassauth2','TodayMenuController@bypass2');
Route::get('/fromDashboardTodayAppetizer','TodayMenuController@getDetailForAllTodayAppetizer');
Route::get('/fromDashboardTodayOtherEvent/{event_type}','TodayMenuController@getDetailForAllTodayOtherEvents');
Route::post('/ondatedashboardchange','TodayMenuController@dashboardOnDateChange');
Route::get('/fromDashboardOnDateMenu/{date}','TodayMenuController@onDateAllMenu');
Route::get('/fromDashboardOnDateBreakfast/{date}','TodayMenuController@onDateAllBreakfast');
Route::get('/fromDashboardOnDateDinner/{date}','TodayMenuController@onDateAllDinner');
Route::get('/fromDashboardOnDateLunch/{date}','TodayMenuController@onDateAllLunch');
Route::get('/fromDashboardOnDateAppetizer/{date}','TodayMenuController@onDateAllAppetizer');
Route::get('/fromDashboardOnDateOtherEvent/{event_type}/{date}','TodayMenuController@onDateAllOtherEvent');
Route::get('/fromDashboardOnDateEvents/{date}','TodayMenuController@onDateAllEvents');
Route::get('/addnewuserpage','UserManagmentController@addNewUserPage');
Route::post('/addUserData','UserManagmentController@addNewUser');
Route::get('/edituserpage','UserManagmentController@editUserPage');
Route::get('/editUserById/{user_id}','UserManagmentController@editUserById');
Route::post('/updateuserinfo','UserManagmentController@updateUserInfo');
Route::get('/deleteuserinfo/{uid}','UserManagmentController@deleteUserInfo');
Route::get('/viewallusers','UserManagmentController@viewAllUserList');
Route::get('/gallary','TodayMenuController@galary');
Route::post('/firsttimeuserchangepassword','TodayMenuController@firstTimeUserPassword');
Route::post('/gallaryondate','TodayMenuController@galary');
Route::get('/logoutfromdashboard','TodayMenuController@logout');
Route::get('/testpdf','TodayMenuController@testPdf');
Route::post('/testpdfonclick','TodayMenuController@testPdf2');

// Guide Reservation For hunting Start
Route::get('/fromDashboardTodayGuideReservation','HuntingReservationController@TodayHuntingGuideResevationDetail');
Route::get('/fromDashboardOnDateGuideReservation','HuntingReservationController@OnDateHuntingGuideResevationDetail');
Route::get('/fromDashboardGuideShedule','HuntingReservationController@GuideWiseResevationInfo');
Route::get('/getGuideShedule/{guide_id}','HuntingReservationController@getGuideShedule');
Route::post('/ondateHuntingFromPage','HuntingReservationController@OnDateFromCalendarHuntingGuideResevationDetail');
Route::post('/ondateHuntingDashboardChange','HuntingReservationController@onDateHuntingDash');
Route::get('/fromdashbordtodayscheduleDashChange/{date}','HuntingReservationController@todayRservationOnDashChange');
Route::get('/fromdashboardOndateDashboradChange/{date}','HuntingReservationController@ondateReservationOnDashChange');
Route::get('/fromDashboardTodaysHuntingevents/{date}','HuntingReservationController@HuntingEventsInfo');
Route::get('/fromDashboardTodaysGuideAssignedHuntingevents/{date}','HuntingReservationController@GuidedHuntingEventInfo');
Route::get('/fromDashboardTodaysUnuideAssignedHuntingevents/{date}','HuntingReservationController@UnuidedHuntingEventInfo');
Route::get('/fromDashboardstotalGuide','HuntingReservationController@getTotalGuidesInDB');
Route::get('/fromDashboardAssignedGuide/{date}','HuntingReservationController@getAssignedGuideInDB');
Route::get('/fromDashboardUnassignedGuide/{date}','HuntingReservationController@getUnassignedGuideInDB');
Route::get('/fromDashboardHuntingcalender','EventController@HuntingCalendar');
//Change on 15-05-2023
Route::get('/fromDashboardHuntingcalenderRevised/{flag}', 'EventController@HuntingCalendarRevised');
//
Route::get('/oncalenderhuntingeventsinfo/{date}/{type}','HuntingReservationController@FromHuntingCalender');
Route::post('/sendItemListOnEmail','TodayMenuController@getIteListOnEmail');
Route::get('/dailyEmailSetup','TodayMenuController@enterEmailSetup');
Route::post('/addEmailSetUp','TodayMenuController@addEmailSetupData');
Route::get('/deleteUserEmailFromSetUp/{email_id}','TodayMenuController@deleteEmailSetupData');
// Guide Reservation For hunting End
//Chnage on 01/09/2021
Route::get('/goToCustomerMatchFun','UserManagmentController@getCustomersComparedResult');
Route::get('/pmsRoomNoNightsBlank','UserManagmentController@getNoNightsInPMSSalesBlankPage');
Route::post('/getPMSCustomerNoNightsData','UserManagmentController@getNoNightsInPMSSalesonSubmit');
Route::get('/pmsRoomReservationByCustomerDetail/{folio_customer_id}/{toDateFromPMSCustPage}/{fromDateFromPMSCustPage}/{rateTypeFilter}','UserManagmentController@getPMSRoomBookingDetails');
Route::get('/pmsRoomReservationOnCalendar','UserManagmentController@pmsRoomReservationOnCalendar');
Route::get('/pmsRoomReservationOnCaledarSelectedId/{customerIdFilter}/{rateTypeFilter}','UserManagmentController@pmsRoomReservationOnCalendarByCustomerOption');
Route::get('/pmsRoomReservationFromCalendar/{from_date}/{to_date}/{cust_id}/{rateTypeFilter}','UserManagmentController@pmsRoomReservationDetailOnCalendarClick');


Route::get('/cateringRoomNoNightsBlank','UserManagmentController@getNoNightsInCateringSalesBlankPage');

Route::post('/getCatCustomerNoNightsData','UserManagmentController@getNoNightsCateringSalesOnSubmit');
Route::get('/getCatCustomerNoNightsDataOnViewDetails/{customer_id}/{market_code}/{event_type}/{from_date}/{to_date}','UserManagmentController@getNoNightsCateringSalesOnViewDetail');
Route::get('/catRoomReservationOnCalendar','UserManagmentController@catRoomReservationOnCalendar');

Route::get('/catRoomReservationOnCaledarSelectedId/{cust_id}/{market_code}/{event_type}','UserManagmentController@catRoomReservationOnCalendarByFilter');

Route::get('/getpmschargedbycodefoliodetails','UserManagmentController@folioPMSChargedByCode');
Route::post('/getpmschargebycodefoliodetailsonsubmitclick','UserManagmentController@folioPMSChargeByCodeOnSubmit');

//pending to change from here encode decode
Route::get('/fromDashboardWeeklyMenuBtnPress/{fromdate}/{todate}','EventController@calenderMenuOnBtnClick');
Route::get('/fromDashboardWeeklyHuntingBtnPress/{fromdate}/{todate}','EventController@HuntingCalendarOnButtonClick');
// change on 15-05-2023
//Guide and Hunt
Route::get('/fromDashboardWeeklyHuntingBtnPressRevised/{fromdate}/{todate}/{guide_id}/{hunt_type}', 'EventController@HuntingCalendarOnButtonClickRevised');
// Till Above 3 routes are pending
Route::get('/getSheduleFilterR/{fromdate}/{todate}/{guide_id}/{hunt_type}/{flag}','EventController@HuntingCalendarFilterRevised');

//change on 05/06/2023
 Route::get('/oncalenderhuntingeventsinforevised/{date}/{eventid}/{guide}','HuntingReservationController@FromHuntingCalenderRevised');

 //change on 05/12/2023
 Route::get('/oncalenderhuntingeventsinforevised1/{date}','HuntingReservationController@FromHuntingCalenderMultipleRevised');
 Route::post('/ondateHuntingFromPageRevised','HuntingReservationController@OnDateFromCalendarHuntingGuideResevationDetailRevised');

//  Code Added On 02-01-2024

 Route::get('/fromDashboardStaffBookingRevised', 'EventController@StaffBookingRevised');
 Route::post('/users-data','EventController@getData');
