<?php

namespace App\Http\Controllers;
use DB;
use PDF;
use MYSQLI;
use Session;
use Illuminate\Http\Request;
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class TodayMenuController extends Controller
{
    //after login first process
    public function bypass(Request $request){
        $emailf=$request['email'];
        $passwordf=$request['password'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kingranchum";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        $sql1 = "SELECT * from USERS WHERE EMAIL='$emailf' ";
        $verifyResult = $conn->query($sql1);

         if ($verifyResult->num_rows > 0) {
            $fetched_row = $verifyResult->fetch_assoc();
           // return $fetched_row;
            $decryptedpassword=decrypt($fetched_row['PASSWORD']);
           // dd($decryptedpassword);
            $id=$fetched_row['ID'];
            $uname=$fetched_row['NAME'];
            if($fetched_row['EMAIL']==$emailf && $passwordf==$decryptedpassword)
            {
                if($fetched_row['FIRST_TIME_FLAG']=="Y")
            {
                $massage="Matched";
                session()->put('useremail',$emailf);
                session()->put('userrole',$fetched_row['ROLE']);
                session()->put('sub_role',$fetched_row['SUBROLE']);
                session()->put('id',$id);
                session()->put('uname',$uname);
                session()->save();

               if($fetched_row['SUBROLE']!="Hunting-Reservation")
               {
                $conn->close();
                $todayDate=date('m-d-Y');
                $data=DB::Select("select sum(event_count) as eventcount,start_datetime from(Select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vci.item_type='Meal' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type) Group By start_datetime");
                $breakfast=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vce.cat_event_type='Breakfast' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
                $lunch=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vce.cat_event_type='Lunch' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
                $dinner=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vce.cat_event_type='Dinner' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
                $appetizer=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vce.cat_event_type='Cocktails' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
                $appetizer_first_item_count=DB::Select(" Select distinct vcs.folio_id,vcs.item_id,vcs.qty from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type='Cocktails' and vci.item_type='Meal' Order by vcs.folio_id");
                $data_ar = json_decode(json_encode($data),true);
                $breakfast_ar = json_decode(json_encode($breakfast),true);
                $lunch_ar = json_decode(json_encode($lunch),true);
                $dinner_ar = json_decode(json_encode($dinner),true);
                $appetizer_ar=json_decode(json_encode($appetizer),true);
                $appetizer_first_item_count_ar=json_decode(json_encode($appetizer_first_item_count),true);
                $index_app_first_item=0;
                $previous_fid="";
                $total_count_app_first_item=0;
                foreach($appetizer_first_item_count_ar as $id=>$data)
                {
                    $fid=$appetizer_first_item_count_ar[$index_app_first_item]['folio_id'];
                    $qty=$appetizer_first_item_count_ar[$index_app_first_item]['qty'];
                    if($previous_fid!=$fid)
                    {
                        $total_count_app_first_item=$total_count_app_first_item+$qty;
                        $previous_fid=$fid;
                    }
                    $index_app_first_item=$index_app_first_item+1;
                }
                if(!empty($data))
                {
                $todaymenu=$data_ar[0]['eventcount'];
                }
                else{
                $todaymenu=0;
                }
                if(!empty($breakfast))
                {
                $todaybreakfast=$breakfast_ar[0]['eventcount'];
                }
                else{
                $todaybreakfast=0;
                }
                if(!empty($lunch))
                {
                $todaylunch=$lunch_ar[0]['eventcount'];
                }
                else{
                $todaylunch=0;
                }
                if(!empty($dinner))
                {
                $todaydinner=$dinner_ar[0]['eventcount'];
                }
                else{
                $todaydinner=0;
                }
                if(!empty($appetizer)){
                $todayappetizer=$appetizer_ar[0]['eventcount'];
                }
                else{
                $todayappetizer=0;
                }

                if(!empty($appetizer_first_item_count)){
                $appetizer_first_item=$total_count_app_first_item;
                }
                else{
                $appetizer_first_item=0;
                }
                $event_data=DB::Select("select count(distinct vce.event_id) as count,vce.cat_event_type from dev.vr_cat_event vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vci.item_id=vcs.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' group by vce.cat_event_type");
                $event_list_ar = json_decode(json_encode($event_data),true);
                $todays_event_data=DB::Select("Select sum(itemcount) as count,cat_event_type from(Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,
                cat_event_type from(Select distinct vcs.folio_id,vce.cat_event_type,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
                TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on
                vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate'
                and vci.item_type='Meal') Group By item_id,item_category,item_name,start_datetime,cat_event_type) Group by cat_event_type");
                $todays_event_data_ar = json_decode(json_encode($todays_event_data),true);
                $datatodayevent=DB::Select("select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vci.item_type='Meal' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type");
                $datatodayevent_ar = json_decode(json_encode($datatodayevent),true);
                $todayChargebalItemCount=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and (vci.item_id between 4033 and 4040 or vci.item_id between 6000 and 6035 or vci.item_id between 2000 and 2003))");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCount_ar =json_decode(json_encode($todayChargebalItemCount),true);
                $todayChargebalItemCount_ar =$todayChargebalItemCount_ar[0]['totl'];
                $todayChargebalItemCountBre=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Breakfast' and vci.item_id between 2000 and 2003)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountBre_ar =json_decode(json_encode($todayChargebalItemCountBre),true);
                $todayChargebalItemCountBre_ar =$todayChargebalItemCountBre_ar[0]['totl'];
                $todayChargebalItemCountLunch=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Lunch' and vci.item_id between 6000 and 6035)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountLunch_ar =json_decode(json_encode($todayChargebalItemCountLunch),true);
                $todayChargebalItemCountLunch_ar =$todayChargebalItemCountLunch_ar[0]['totl'];
                $todayChargebalItemCountDinner=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Dinner' and vci.item_id between 4033 and 4040)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountDinner_ar =json_decode(json_encode($todayChargebalItemCountDinner),true);
                $todayChargebalItemCountDinner_ar =$todayChargebalItemCountDinner_ar[0]['totl'];
                if(empty($todayChargebalItemCount_ar)){
                    $todayChargebalItemCount_ar=0;
                }
                if(empty($todayChargebalItemCountBre_ar)){
                    $todayChargebalItemCountBre_ar=0;
                }
                if(empty($todayChargebalItemCountLunch_ar)){
                    $todayChargebalItemCountLunch_ar=0;
                }
                if(empty($todayChargebalItemCountDinner_ar)){
                    $todayChargebalItemCountDinner_ar=0;
                }
              //  return $datatodayevent_ar;
                return view('home',compact('todayDate','todaymenu','todaybreakfast','todaylunch','todaydinner','event_list_ar','todays_event_data_ar','todayappetizer','datatodayevent_ar','appetizer_first_item','todayChargebalItemCount_ar','todayChargebalItemCountBre_ar','todayChargebalItemCountLunch_ar','todayChargebalItemCountDinner_ar'));
            }
               else{
               // sagar
                $value = session()->get('id');
                if($value!=""){
                    $todayDate=date('m-d-Y');
                    $todayHuntingEventNum=DB::Select("Select count(ec) as count from (Select COUNT(vce.event_id) as ec,vce.event_id,vce.cat_event_type from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' group by vce.event_id,vce.cat_event_type)");
                    $todayHuntingEventNum_ar = json_decode(json_encode($todayHuntingEventNum),true);
                    $todayGuidedEventNum=DB::Select("Select Count(cm) as count from (Select COUNT(distinct vce.event_id) as cm from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_name NOT LIKE '%(Unassigned)%' and vci.item_type='Guide' group by vce.event_id)");
                    $todayGuidedEventNum_ar = json_decode(json_encode($todayGuidedEventNum),true);
                    $todayGuideUnassignedEventNum=DB::Select("Select Count(cm) as count from (Select COUNT(distinct vce.event_id) as cm from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_name LIKE '%(Unassigned)%' and vci.item_type='Guide' group by vce.event_id)");
                    $todayGuideUnassignedEventNum_ar=json_decode(json_encode($todayGuideUnassignedEventNum),true);
                    $totalNumGuide=DB::Select("Select Count(distinct item_id) as count from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
                    $totalNumGuide_ar = json_decode(json_encode($totalNumGuide),true);
                    $totalAsignedGuide=DB::Select("Select COUNT(DISTINCT vci.item_id) as count from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
                    $totalAsignedGuide_ar=json_decode(json_encode($totalAsignedGuide),true);
                    $todayHuntingEventInfo=DB::Select(" Select vce.event_id,vce.cat_event_type,vcs.item_name,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' ");
                    $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo),true);
                    $totalAsignedGuideInfo=DB::Select("Select distinct vci.item_id,vci.item_name,vce.name,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
                    $totalAsignedGuideInfo_ar=json_decode(json_encode($totalAsignedGuideInfo),true);
                    $totalUnasignedGuideInfo=DB::Select("Select distinct vci.item_id,vci.item_name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id!=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
                    $totalUnasignedGuideInfo_ar=json_decode(json_encode($totalUnasignedGuideInfo),true);
                    return view('GuideReservationHunting.homeForReservation',compact('todayHuntingEventNum_ar','todayGuidedEventNum_ar','totalNumGuide_ar','totalAsignedGuide_ar','todayHuntingEventInfo_ar','totalAsignedGuideInfo_ar','totalUnasignedGuideInfo_ar','todayDate','todayGuideUnassignedEventNum_ar'));
                }
                else{
                  return view('auth/login');
                }
               }
                   }

                else
                {
                    //First time user login
                    return view('changeFirstTimePassword',compact('id'));
                }
            }
           else{
               $massage="Incorrect Username or Password.";
               return view('Auth/loginerror',compact('massage'));
            }
        }
        else {
            $conn->close();
            $massage="User not found";
            return view('Auth/loginerror',compact('massage'));
        }
    }
    //Get Detail For All Today's Menu
    public function getDetailForAllTodayMenu()
    {
        $value = session()->get('id');
        if($value!=""){
            $todayDate=date('m-d-Y');
        $dataoftodaysitemstocook=DB::Select("Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,
            cat_event_type,item_desc from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,
            vci.item_category,vce.cat_event_type as cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY HH24:MI:SS') as start_time from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs
            on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where
            TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal') Group By item_name,item_id,item_desc,
            item_category,start_datetime,cat_event_type Order By cat_event_type");
        $dataoftodaysitemstocook_ar = json_decode(json_encode($dataoftodaysitemstocook),true);
        return view('TodayMenu/todaymenu',compact('dataoftodaysitemstocook_ar','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    //Get Todays breakfast details
    public function getDetailForAllTodayBreakfast()
    {
        $value = session()->get('id');
        if($value!=""){
            $todayDate=date('m-d-Y');
        // $todayDate='05-10-2019';
        $breakfast=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
            from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
            vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
            vce.cat_event_type='Breakfast' and vci.item_type='Meal') Group By item_category,item_name,
            start_datetime,item_id,item_desc");
        $breakfast_ar = json_decode(json_encode($breakfast),true);
        return view('TodayMenu/todaybreakfast',compact('breakfast_ar','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
     //Get Todays Lunch Details
    public function getDetailForAllTodayLunch()
    {
        $value = session()->get('id');
        if($value!=""){
        $todayDate=date('m-d-Y');
        // $todayDate='05-10-2019';
        $lunch=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
            from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
            vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
            vce.cat_event_type='Lunch' and vci.item_type='Meal') Group By item_category,item_name,
            start_datetime,item_id,item_desc");
        $lunch_ar = json_decode(json_encode($lunch),true);
        return view('TodayMenu/todaylunch',compact('lunch_ar','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
     //Get Todays Dinner details
    public function getDetailForAllTodayDinner()
    {
        $value = session()->get('id');
        if($value!=""){
        $todayDate=date('m-d-Y');
        $dinner=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
            from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
            vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
            vce.cat_event_type='Dinner' and vci.item_type='Meal') Group By item_category,item_name,
            start_datetime,item_id,item_desc");
        $dinner_ar = json_decode(json_encode($dinner),true);
        return view('TodayMenu/todaydinner',compact('dinner_ar','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    //Get Todays Appetizer Details
    public function getDetailForAllTodayAppetizer()
    {
        $value = session()->get('id');
        if($value!=""){
        $todayDate=date('m-d-Y');
        // $todayDate='05-10-2019';
        $appetizer=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
            from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
            vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
            vce.cat_event_type='Cocktails' and vci.item_type='Meal') Group By item_category,item_name,
            start_datetime,item_id,item_desc");
        $appetizer_ar = json_decode(json_encode($appetizer),true);
        return view('TodayMenu/todayappetizer',compact('appetizer_ar','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    //Get Todays Other Event Details
    public function getDetailForAllTodayOtherEvents(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
            $todayDate=date('m-d-Y');
        // $todayDate='05-10-2019';
        $event_type=base64_decode($request['event_type']);
        $event_info=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
            from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
            vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
            vce.cat_event_type='$event_type' and vci.item_type='Meal') Group By item_category,item_name,
            start_datetime,item_id,item_desc");
        $event_info_ar = json_decode(json_encode($event_info),true);
      //  return $event_info_ar;
        return view('TodayMenu/todayotherevent',compact('event_info_ar','event_type','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    //Get On date Menu
    public function openPageForOnDateMenu()
    {
        $value = session()->get('id');
        if($value!=""){
        $date=date('m-d-Y');
        $todayDate=date('m-d-Y');
        $dataoftodaysitemstocook=DB::Select("Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,cat_event_type,item_desc
        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,vce.cat_event_type as cat_event_type,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime,TO_CHAR(vce.start_datetime,'MM-DD-YYYY HH24:MI:SS') as start_time
        from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
        vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$date' and vci.item_type='Meal')
        Group By item_name,item_id,item_category,start_datetime,cat_event_type,item_desc Order By cat_event_type");
        $dataoftodaysitemstocook_ar = json_decode(json_encode($dataoftodaysitemstocook),true);
        $itemcountforgraph=DB::Select("Select sum(itemcount) as count,cat_event_type from(Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,cat_event_type
        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,vce.cat_event_type as cat_event_type,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime,TO_CHAR(vce.start_datetime,'MM-DD-YYYY HH24:MI:SS') as start_time from
        dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id
        where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$date' and vci.item_type='Meal') Group By item_name,item_id,item_category,start_datetime,
        cat_event_type Order By cat_event_type)Group By cat_event_type");
        $itemcountforgraph_ar = json_decode(json_encode($itemcountforgraph),true);
        return view('OnDateMenu/ondatemenu',compact('dataoftodaysitemstocook_ar','date','itemcountforgraph_ar','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    //Get On date menu after change date from same date
    public function openPageForOnDateMenu2(Request $request)
    {
            $value = session()->get('id');
            if($value!="")
            {
                $date=$request['filterdate'];
                $todayDate=$request['filterdate'];
                $dataoftodaysitemstocook=DB::Select("Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,cat_event_type,item_desc
                from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,vce.cat_event_type as cat_event_type,
                TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime,TO_CHAR(vce.start_datetime,'MM-DD-YYYY HH24:MI:SS') as start_time
                from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
                vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$date' and vci.item_type='Meal')
                Group By item_name,item_id,item_category,start_datetime,cat_event_type,item_desc Order By cat_event_type");

                $dataoftodaysitemstocook_ar = json_decode(json_encode($dataoftodaysitemstocook),true);
                // return $dataoftodaysitemstocook_ar;
                $itemcountforgraph=DB::Select("Select sum(itemcount) as count,cat_event_type from(Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,cat_event_type
                from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,vce.cat_event_type as cat_event_type,
                TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime,TO_CHAR(vce.start_datetime,'MM-DD-YYYY HH24:MI:SS') as start_time from
                dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id
                where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$date' and vci.item_type='Meal') Group By item_name,item_id,item_category,start_datetime,
                cat_event_type Order By cat_event_type)Group By cat_event_type");
                $itemcountforgraph_ar = json_decode(json_encode($itemcountforgraph),true);

                return view('OnDateMenu/ondatemenu',compact('dataoftodaysitemstocook_ar','date','itemcountforgraph_ar','todayDate'));
            }
            else
            {
              return view('auth/login');
            }
    }
    //Get On Date menu from calender or weekly menu from
    public function openPageForOnDateMenu3(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
        $date=base64_decode($request['filterdate']);
        $date=date('m-d-Y',strtotime($date));
        $todayDate=$date;
        $type=base64_decode($request['type']);
        if($type=="Other"){
                $data=DB::Select("Select sum(qty) as eventcount,item_id,item_category,item_name,start_datetime,item_desc
        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs
        on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where
        TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$date' and vce.cat_event_type IS NULL and vci.item_type='Meal')
        Group By item_id,item_name,item_desc,item_category,start_datetime");
        }else{
                $data=DB::Select("Select sum(qty) as eventcount,item_id,item_category,item_name,start_datetime,item_desc
        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs
        on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where
        TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$date' and vce.cat_event_type='$type' and vci.item_type='Meal')
        Group By item_id,item_name,item_desc,item_category,start_datetime");
        }
        $data_ar = json_decode(json_encode($data),true);
        return view('OnDateMenu/ondatemenufromcalender',compact('data_ar','date','type','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    //Calender opens
    public function weklyMenus(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){

        return view('WeeklyMenu/weeklymenu');
        }
        else{
          return view('auth/login');
        }
    }
    // view Item Detail Form
    public function openViewDetail(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
        $item_id=base64_decode($request['item_id']);
        $date=base64_decode($request['start_datetime']);
        $dateArray=(explode(" ",$date));
        $dateSingle=$dateArray[0];
        $item_name=base64_decode($request['item_name']);
        $item_desc=base64_decode($request['item_desc']);
        $todayDate=$date;
        if($item_desc!="NA"){
            // Miltary date format change start 25/09/2023
        $data=DB::Select("select distinct vce.event_id,(vcs.qty) as itemcount,TO_CHAR(start_datetime,'MM-DD-YYYY') As dateofevent,
        TO_CHAR(start_datetime,'HH:MI AM') As eventstarttime,TO_CHAR(end_datetime,'HH:MI AM')As eventendtime,vce.event_id,vce.cat_event_type,
        vc.name,vce.room,vcs.item_id,vc.customer_id,vci.item_name from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs
        on vce.event_id=vcs.folio_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id inner join
        dev.vr_CAT_ITEMS vci on vcs.item_id=vci.item_id where vcs.item_id='$item_id' and vcs.item_desc='$item_desc' and vci.item_name='$item_name' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' ");
        //return $data;
        }
        else{
          $data=DB::Select("select distinct vce.event_id,(vcs.qty) as itemcount,TO_CHAR(start_datetime,'MM-DD-YYYY') As dateofevent,
        TO_CHAR(start_datetime,'HH:MI AM') As eventstarttime,TO_CHAR(end_datetime,'HH:MI AM')As eventendtime,vce.event_id,vce.cat_event_type,
        vc.name,vce.room,vcs.item_id,vc.customer_id,vci.item_name from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs
        on vce.event_id=vcs.folio_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id inner join
        dev.vr_CAT_ITEMS vci on vcs.item_id=vci.item_id where vcs.item_id='$item_id' and vci.item_name='$item_name' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' ");
        }
        // Miltary date format change end 25/09/2023
        $data_ar = json_decode(json_encode($data),true);
        return view('viewitemDetailPage',compact('data_ar','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    //View Customer detail from Item detail Form
    public function openCustomerDetail(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
        // $customer_id=$request['customer_id'];
        // 05/18/2023
        $customer_id=base64_decode($request['customer_id']);
        // $date=$request['date'];
        // 05/18/2023
        $date=base64_decode($request['date']);
        $todayDate=$date;
        // Miltary date format change start 25/09/2023
        $customer_data=DB::Select("Select DISTINCT(vce.event_id),vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.cat_event_type,TO_CHAR(vce.start_datetime,'HH:MI AM') As start_time,vce.qty_est,vce.qty_gtd,TO_CHAR(vce.end_datetime,'HH:MI AM') As end_time from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vcs.folio_id=vce.event_id inner join dev.vr_CUSTOMERS vc on vcs.folio_customer_id=vc.customer_id where vc.customer_id='$customer_id' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' order by start_time");
        // Miltary date format change end 25/09/2023
        $customer_data_ar = json_decode(json_encode($customer_data),true);
        $customer_event_data=DB::Select("Select distinct vcs.item_id,vcs.item_desc,vcs.qty,vce.event_id,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.cat_event_type,TO_CHAR(vce.start_datetime,'HH:MI AM') As start_time,vce.qty_est,vci.item_name,vce.qty_gtd,TO_CHAR(vce.end_datetime,'HH:MI AM') As end_time from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vcs.folio_id=vce.event_id inner join dev.vr_CUSTOMERS vc on vcs.folio_customer_id=vc.customer_id inner join dev.vr_CAT_ITEMS vci on vcs.item_id=vci.item_id where vc.customer_id='$customer_id' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' Order by vce.cat_event_type,start_time");
        $customer_event_data_ar = json_decode(json_encode($customer_event_data),true);
        $customer_on_date=DB::Select("Select DISTINCT(TO_CHAR(vce.start_datetime,'MM-DD-YYYY')) As alldates from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.event_id=vcs.folio_id inner join dev.vr_CUSTOMERS vc on vcs.folio_customer_id=vc.customer_id where vc.customer_id='$customer_id'");
        $customer_on_date_ar = json_decode(json_encode($customer_on_date),true);
        //return($customer_on_date_ar);
        return view('customerdetail/customerdetailtabularview',compact('customer_data_ar','customer_event_data_ar','date','customer_on_date_ar','customer_id','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    public function openCustomerDetailOnDate(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
                    $customer_id=$request['customer_id'];
        $date=$request['date'];
        $customer_data=DB::Select("Select DISTINCT(vce.event_id),vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,vce.cat_event_type,TO_CHAR(vce.start_datetime,'HH24:MI:SS') As start_time,vce.qty_est,vce.qty_gtd,TO_CHAR(vce.end_datetime,'HH24:MI:SS') As end_time from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vcs.folio_id=vce.event_id inner join dev.vr_CUSTOMERS vc on vcs.folio_customer_id=vc.customer_id where vc.customer_id='$customer_id' and TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$date' order by start_time");
        $customer_data_ar = json_decode(json_encode($customer_data),true);
        $customer_event_data=DB::Select("Select distinct vcs.item_id,vcs.item_desc,vcs.qty,vce.event_id,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,vce.cat_event_type,TO_CHAR(vce.start_datetime,'HH24:MI:SS') As start_time,vce.qty_est,vci.item_name,vce.qty_gtd,TO_CHAR(vce.end_datetime,'HH24:MI:SS') As end_time from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vcs.folio_id=vce.event_id inner join dev.vr_CUSTOMERS vc on vcs.folio_customer_id=vc.customer_id inner join dev.vr_CAT_ITEMS vci on vcs.item_id=vci.item_id where vc.customer_id='$customer_id' and TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$date' Order by vce.cat_event_type,start_time");
        $customer_event_data_ar = json_decode(json_encode($customer_event_data),true);
         $customer_on_date=DB::Select("Select DISTINCT(TO_CHAR(vce.start_datetime,'DD-MM-YYYY')) As alldates from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.event_id=vcs.folio_id inner join dev.vr_CUSTOMER vc on vcs.folio_customer_id=vc.customer_id where vc.customer_id='$customer_id'");
         $customer_on_date_ar = json_decode(json_encode($customer_on_date),true);
        //return($customer_on_date_ar);
        return view('customerdetail/customerdetailtabularview',compact('customer_data_ar','customer_event_data_ar','date','customer_on_date_ar','customer_id'));
        }
        else{
          return view('auth/login');
        }
    }
    public function export_pdf()
    {
        $value = session()->get('id');
        if($value!=""){
            // Send data to the view using loadView function of PDF facade
      $data[]=["h","i"];
      $pdf = PDF::loadView('customerdetail.customerdetailDownload',$data);
      // If you want to store the generated pdf to the server then you can use the store function
      $pdf->save(storage_path().'_filename.pdf');
      // Finally, you can download the file using download function
      return $pdf->download('customers.pdf');
        }
        else{
          return view('auth/login');
        }
    }
    public function itemPage(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
                    $item_data=DB::Select("Select COUNT(vci.item_id) As count,vci.item_category,vci.item_id, vci.item_name,vci.item_category,vci.charge_code,TO_CHAR(vce.start_datetime,'HH24:MI:SS') AS eventstartat,TO_CHAR(vce.end_datetime,'HH24:MI:SS') AS eventendat From dev.vr_CAT_ITEMS vci inner join dev.vr_CAT_SALES vcs on vcs.item_id=vci.item_id inner join dev.vr_CAT_EVENT vce on vcs.folio_id=vce.event_id inner join dev.vr_CUSTOMER vc on vc.customer_id=vcs.folio_customer_id where vci.item_type='Meal' Group By vci.item_id,vci.item_category,vci.item_name,vci.item_category,vci.charge_code,vce.start_datetime,vce.end_datetime");
        $item_list_ar = json_decode(json_encode($item_data),true);
        $item_data_ar="";
        $selected_id="";
        // return $item_list_ar;
        return view('itempage',compact('item_data_ar','item_list_ar','selected_id'));
        }
        else{
          return view('auth/login');
        }
    }
    public function itemRefreshPage(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
        $selected_id=base64_decode($request['item_id']);
        $item_list=DB::Select("Select COUNT(vci.item_id) As count,vci.item_category,vci.item_id, vci.item_name,vci.item_category,vci.charge_code,TO_CHAR(vce.start_datetime,'HH24:MI:SS') AS eventstartat,TO_CHAR(vce.end_datetime,'HH24:MI:SS') AS eventendat From dev.vr_CAT_ITEMS vci inner join dev.vr_CAT_SALES vcs on vcs.item_id=vci.item_id inner join dev.vr_CAT_EVENT vce on vcs.folio_id=vce.event_id inner join dev.vr_CUSTOMER vc on vc.customer_id=vcs.folio_customer_id where vci.item_type='Meal' Group By vci.item_id,vci.item_category,vci.item_name,vci.item_category,vci.charge_code,vce.start_datetime,vce.end_datetime");
        $item_data=DB::Select("Select COUNT(vci.item_id) As count,vci.item_category,vci.item_id, vci.item_name,vci.item_category,vci.charge_code,TO_CHAR(vce.start_datetime,'HH24:MI:SS') AS eventstartat,TO_CHAR(vce.end_datetime,'HH24:MI:SS') AS eventendat From dev.vr_CAT_ITEMS vci inner join dev.vr_CAT_SALES vcs on vcs.item_id=vci.item_id inner join dev.vr_CAT_EVENT vce on vcs.folio_id=vce.event_id inner join dev.vr_CUSTOMER vc on vc.customer_id=vcs.folio_customer_id where TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='31-08-2019' and vci.item_id='$selected_id' Group By vci.item_id,vci.item_name,vci.item_category,vci.charge_code,vce.start_datetime,vce.end_datetime");
        $item_data_ar = json_decode(json_encode($item_data),true);
        $item_list_ar = json_decode(json_encode($item_list),true);
        return view('itempage',compact('item_data_ar','item_list_ar','selected_id'));
        }
        else{
          return view('auth/login');
        }
    }
    //Today Event Detail
    public function eventsDetail(Request $request){
        $value = session()->get('id');
        if($value!=""){
            $todayDate=date('m-d-Y');
        // Miltary date format change start 25/09/2023
        $event_data=DB::Select("Select TO_CHAR(start_datetime,'MM-DD-YYYY') as date_value,TO_CHAR(start_datetime,'HH:MI AM') as start_time,TO_CHAR(end_datetime,'HH:MI AM') as end_time,event_id,room,cat_event_type,name from dev.vr_CAT_EVENT where TO_CHAR(start_datetime,'MM-DD-YYYY')='$todayDate'");
        // Miltary date format change end 25/09/2023
        $event_data_ar = json_decode(json_encode($event_data),true);
        return view('Events.todaysEvents',compact('event_data_ar','todayDate'));
        }
        else{
          return view('auth/login');
        }
    }
    public function customerDetail(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
            $customer_detail=DB::Select("Select DISTINCT(vr.customer_id),vr.name,vr.home_phone,vr.email_address,vce.start_datetime,GROUP_CONCAT(vce.cat_event_type) As event_type FROM dev.vr_Customer vr inner join dev.vr_CAT_SALES vcs on vr.customer_id=vcs.folio_customer_id inner join dev.vr_CAT_EVENT vce on vcs.folio_id=vce.event_id where TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='31-08-2019' GROUP BY vr.customer_id");
        $customer_detail_ar=json_decode(json_encode($customer_detail),true);
        return view('customerdetail.todayscustomers',compact('customer_detail_ar'));
        }
        else{
          return view('auth/login');
        }
    }
    public function dashboardOnDateChange(Request $request)
    {
            $value = session()->get('id');
            if($value!=""){
            $currentdate=date('m-d-Y');
            $todayDate=$request['filterdate'];
            $data=DB::Select("select sum(event_count) as eventcount,start_datetime from(Select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vci.item_type='Meal' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type) Group By start_datetime");
            $breakfast=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime
            from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci
            on vcs.item_id=vci.item_id where vce.cat_event_type='Breakfast' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate'
            and vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
            $lunch=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime
            from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on
            vcs.item_id=vci.item_id where vce.cat_event_type='Lunch' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and
            vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
            $dinner=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime
            from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on
            vcs.item_id=vci.item_id where vce.cat_event_type='Dinner' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and
            vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
            $appetizer=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime
            from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on
            vcs.item_id=vci.item_id where vce.cat_event_type='Cocktails' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and
            vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
            $appetizer_first_item_count=DB::Select(" Select distinct vcs.folio_id,vcs.item_id,vcs.qty from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate'  and
            vce.cat_event_type='Cocktails' and vci.item_type='Meal' Order by vcs.folio_id");
            $data_ar = json_decode(json_encode($data),true);
            $breakfast_ar = json_decode(json_encode($breakfast),true);
            $lunch_ar = json_decode(json_encode($lunch),true);
            $dinner_ar = json_decode(json_encode($dinner),true);
            $appetizer_ar=json_decode(json_encode($appetizer),true);
            $appetizer_first_item_count_ar=json_decode(json_encode($appetizer_first_item_count),true);
            $index_app_first_item=0;
            $previous_fid="";
            $total_count_app_first_item=0;
            foreach($appetizer_first_item_count_ar as $id=>$data)
            {
            $fid=$appetizer_first_item_count_ar[$index_app_first_item]['folio_id'];
            $qty=$appetizer_first_item_count_ar[$index_app_first_item]['qty'];
            if($previous_fid!=$fid)
            {
            $total_count_app_first_item=$total_count_app_first_item+$qty;
            $previous_fid=$fid;
            }
            $index_app_first_item=$index_app_first_item+1;
            }
            if(!empty($data))
            {
            $todaymenu=$data_ar[0]['eventcount'];
            }
            else{
            $todaymenu=0;
            }
            if(!empty($breakfast))
            {
            $todaybreakfast=$breakfast_ar[0]['eventcount'];
            }
            else{
            $todaybreakfast=0;
            }
            if(!empty($lunch))
            {
            $todaylunch=$lunch_ar[0]['eventcount'];
            }
            else{
            $todaylunch=0;
            }
            if(!empty($dinner))
            {
            $todaydinner=$dinner_ar[0]['eventcount'];
            }
            else{
            $todaydinner=0;
            }
            if(!empty($appetizer)){
            $todayappetizer=$appetizer_ar[0]['eventcount'];
            }
            else{
            $todayappetizer=0;
            }

            if(!empty($appetizer_first_item_count)){
            $appetizer_first_item=$total_count_app_first_item;
            }
            else{
            $appetizer_first_item=0;
            }

            $event_data=DB::Select("select count(distinct vce.event_id) as count,vce.cat_event_type from dev.vr_cat_event vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vci.item_id=vcs.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' group by vce.cat_event_type");
            $event_list_ar = json_decode(json_encode($event_data),true);
            $todays_event_data=DB::Select("Select sum(itemcount) as count,cat_event_type from(Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,
            cat_event_type from(Select distinct vcs.folio_id,vce.cat_event_type,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on
            vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate'
            and vci.item_type='Meal') Group By item_id,item_category,item_name,start_datetime,cat_event_type) Group by cat_event_type");
            $todays_event_data_ar = json_decode(json_encode($todays_event_data),true);
            $datatodayevent=DB::Select("select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vci.item_type='Meal' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type");
            $datatodayevent_ar = json_decode(json_encode($datatodayevent),true);

            //Sagar23
            $todayChargebalItemCount=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and (vci.item_id between 4033 and 4040 or vci.item_id between 6000 and 6035 or vci.item_id between 2000 and 2003))");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCount_ar =json_decode(json_encode($todayChargebalItemCount),true);
                $todayChargebalItemCount_ar =$todayChargebalItemCount_ar[0]['totl'];
                $todayChargebalItemCountBre=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Breakfast' and vci.item_id between 2000 and 2003)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountBre_ar =json_decode(json_encode($todayChargebalItemCountBre),true);
                $todayChargebalItemCountBre_ar =$todayChargebalItemCountBre_ar[0]['totl'];
                $todayChargebalItemCountLunch=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Lunch' and vci.item_id between 6000 and 6035)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountLunch_ar =json_decode(json_encode($todayChargebalItemCountLunch),true);
                $todayChargebalItemCountLunch_ar =$todayChargebalItemCountLunch_ar[0]['totl'];
                $todayChargebalItemCountDinner=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Dinner' and vci.item_id between 4033 and 4040)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountDinner_ar =json_decode(json_encode($todayChargebalItemCountDinner),true);
                $todayChargebalItemCountDinner_ar =$todayChargebalItemCountDinner_ar[0]['totl'];
                if(empty($todayChargebalItemCount_ar)){
                    $todayChargebalItemCount_ar=0;
                }
                if(empty($todayChargebalItemCountBre_ar)){
                    $todayChargebalItemCountBre_ar=0;
                }
                if(empty($todayChargebalItemCountLunch_ar)){
                    $todayChargebalItemCountLunch_ar=0;
                }
                if(empty($todayChargebalItemCountDinner_ar)){
                    $todayChargebalItemCountDinner_ar=0;
                }
            if($todayDate==$currentdate)
            {
            return view('home',compact('todayDate','todaymenu','todaybreakfast','todaylunch','todaydinner','event_list_ar','todays_event_data_ar','todayappetizer','datatodayevent_ar','appetizer_first_item','todayChargebalItemCount_ar','todayChargebalItemCountBre_ar','todayChargebalItemCountLunch_ar','todayChargebalItemCountDinner_ar'));
            }
            else{
            return view('homeondatechange',compact('todayDate','todaymenu','todaybreakfast','todaylunch','todaydinner','event_list_ar','todays_event_data_ar','todayappetizer','datatodayevent_ar','appetizer_first_item','todayChargebalItemCount_ar','todayChargebalItemCountBre_ar','todayChargebalItemCountLunch_ar','todayChargebalItemCountDinner_ar'));
            }

            // return view('home',compact('todayDate','todaymenu','event_list_ar','todays_event_data_ar','datatodayevent_ar'));

            }
            else{
            return view('auth/login');
            }
    }
    // On Dashboard change all events and menus
    public function onDateAllMenu(Request $request)
    {
        $value = session()->get('id');
            if($value!=""){
                    $todayDate=base64_decode($request['date']);
        $dataoftodaysitemstocook=DB::Select("Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,cat_event_type,item_desc
                        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,vce.cat_event_type as cat_event_type,
                        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime,TO_CHAR(vce.start_datetime,'MM-DD-YYYY HH24:MI:SS') as start_time
                        from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
                        vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal')
                        Group By item_name,item_id,item_desc,item_category,start_datetime,cat_event_type Order By cat_event_type");
            $dataoftodaysitemstocook_ar = json_decode(json_encode($dataoftodaysitemstocook),true);
            return view('TodayMenu/todaymenu',compact('dataoftodaysitemstocook_ar','todayDate'));
            }
            else{
              return view('auth/login');
            }
    }
    // On Dashboard Change Breakfast
    public function onDateAllBreakfast(Request $request)
    {
        $value = session()->get('id');
            if($value!=""){
        $todayDate=base64_decode($request['date']);
        $breakfast=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
        dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
        vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
        vce.cat_event_type='Breakfast' and vci.item_type='Meal') Group By item_category,item_name,
        start_datetime,item_id,item_desc");
            $breakfast_ar = json_decode(json_encode($breakfast),true);
            return view('TodayMenu/todaybreakfast',compact('breakfast_ar','todayDate'));
            }
            else{
              return view('auth/login');
            }
    }
    // On dashboard Chnage Dinner
    public function onDateAllDinner(Request $request)
    {
        $value = session()->get('id');
            if($value!=""){
                $todayDate=base64_decode($request['date']);
        $dinner=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
        dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
        vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
        vce.cat_event_type='Dinner' and vci.item_type='Meal') Group By item_category,item_name,
        start_datetime,item_id,item_desc");
            $dinner_ar = json_decode(json_encode($dinner),true);
           // return $dinner_ar;
            return view('TodayMenu/todaydinner',compact('dinner_ar','todayDate'));
            }
            else{
              return view('auth/login');
            }
    }
    // On dashboard Change Lunch
    public function onDateAllLunch(Request $request)
    {
        $value = session()->get('id');
            if($value!=""){

        $todayDate=base64_decode($request['date']);
         $lunch=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
        dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
        vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
        vce.cat_event_type='Lunch' and vci.item_type='Meal') Group By item_category,item_name,
        start_datetime,item_id,item_desc");
            $lunch_ar = json_decode(json_encode($lunch),true);
            return view('TodayMenu/todaylunch',compact('lunch_ar','todayDate'));
            }
            else{
              return view('auth/login');
            }
    }
    // On Dashboard Chnage Appetizer
    public function onDateAllAppetizer(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
        $todayDate=base64_decode($request['date']);
        $appetizer=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
        from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
        dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
        vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
        vce.cat_event_type='Cocktails' and vci.item_type='Meal') Group By item_category,item_name,
        start_datetime,item_id,item_desc");
            $appetizer_ar = json_decode(json_encode($appetizer),true);
            return view('TodayMenu/todayappetizer',compact('appetizer_ar','todayDate'));
            }
        else{
          return view('auth/login');
        }
    }
    // On Dashboard Change Other Events
    public function onDateAllOtherEvent(Request $request){
            $value = session()->get('id');
                if($value!=""){
            $todayDate=base64_decode($request['date']);
            $event_type=base64_decode($request['event_type']);
            if($event_type=="Other"){
             $event_info=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
            from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
            vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
            vce.cat_event_type IS NULL and vci.item_type='Meal') Group By item_category,item_name,
            start_datetime,item_id,item_desc");
            }
            else{
            $event_info=DB::Select("Select sum(qty) as itemcount,item_desc,item_id,item_category,item_name,start_datetime
            from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
            vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate' and
            vce.cat_event_type='$event_type' and vci.item_type='Meal') Group By item_category,item_name,
            start_datetime,item_id,item_desc");
            }

                $event_info_ar = json_decode(json_encode($event_info),true);
              //  return $event_info_ar;
                return view('TodayMenu/todayotherevent',compact('event_info_ar','event_type','todayDate'));
                }
                else{
                  return view('auth/login');
                }
    }
    // On Dashboard Change All Events
    public function onDateAllEvents(Request $request){
        $value = session()->get('id');
            if($value!=""){

        $todayDate=base64_decode($request['date']);
        // Miltary date format change start 25/09/2023
        $event_data=DB::Select("Select TO_CHAR(start_datetime,'MM-DD-YYYY') as date_value,TO_CHAR(start_datetime,'HH:MI AM') as start_time,TO_CHAR(end_datetime,'HH:MI AM') as end_time,event_id,room,cat_event_type,name from dev.vr_CAT_EVENT where TO_CHAR(start_datetime,'MM-DD-YYYY')='$todayDate'");
        // Miltary date format change end 25/09/2023
        $event_data_ar = json_decode(json_encode($event_data),true);
            return view('Events.todaysEvents',compact('event_data_ar','todayDate'));
            }
            else{
              return view('auth/login');
            }
    }
    // Dashboard 2
    public function bypass2(Request $request)
    {
            $value = session()->get('id');
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "kingranchum";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            $sql1 = "SELECT * from USERS WHERE ID='$value' ";
            $verifyResult = $conn->query($sql1);
            if ($verifyResult->num_rows > 0) {
            $fetched_row = $verifyResult->fetch_assoc();
            }
            if($fetched_row['SUBROLE']!="Hunting-Reservation")

            {
            $value = session()->get('id');
            if($value!=""){
            $todayDate=date('m-d-Y');
            // $todayDate='05-10-2019';
            $data=DB::Select("select sum(event_count) as eventcount,start_datetime from(Select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vci.item_type='Meal' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type) Group By start_datetime");
            $breakfast=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime
            from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci
            on vcs.item_id=vci.item_id where vce.cat_event_type='Breakfast' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate'
            and vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
            $lunch=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime
            from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on
            vcs.item_id=vci.item_id where vce.cat_event_type='Lunch' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and
            vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
            $dinner=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime
            from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on
            vcs.item_id=vci.item_id where vce.cat_event_type='Dinner' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and
            vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
            $appetizer=DB::Select("Select COUNT( distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime
            from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on
            vcs.item_id=vci.item_id where vce.cat_event_type='Cocktails' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and
            vci.item_type='Meal' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY')");
            $appetizer_first_item_count=DB::Select(" Select distinct vcs.folio_id,vcs.item_id,vcs.qty from dev.vr_CAT_EVENT vce inner join
            dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate'  and
            vce.cat_event_type='Cocktails' and vci.item_type='Meal' Order by vcs.folio_id");
            $data_ar = json_decode(json_encode($data),true);
            $breakfast_ar = json_decode(json_encode($breakfast),true);
            $lunch_ar = json_decode(json_encode($lunch),true);
            $dinner_ar = json_decode(json_encode($dinner),true);
            $appetizer_ar=json_decode(json_encode($appetizer),true);
            $appetizer_first_item_count_ar=json_decode(json_encode($appetizer_first_item_count),true);
            $index_app_first_item=0;
            $previous_fid="";
            $total_count_app_first_item=0;
            foreach($appetizer_first_item_count_ar as $id=>$data)
            {
            $fid=$appetizer_first_item_count_ar[$index_app_first_item]['folio_id'];
            $qty=$appetizer_first_item_count_ar[$index_app_first_item]['qty'];
            if($previous_fid!=$fid)
            {
            $total_count_app_first_item=$total_count_app_first_item+$qty;
            $previous_fid=$fid;
            }
            $index_app_first_item=$index_app_first_item+1;
            }

            if(!empty($data))
            {
            $todaymenu=$data_ar[0]['eventcount'];
            }
            else{
            $todaymenu=0;
            }
            if(!empty($breakfast))
            {
            $todaybreakfast=$breakfast_ar[0]['eventcount'];
            }
            else{
            $todaybreakfast=0;
            }
            if(!empty($lunch))
            {
            $todaylunch=$lunch_ar[0]['eventcount'];
            }
            else{
            $todaylunch=0;
            }
            if(!empty($dinner))
            {
            $todaydinner=$dinner_ar[0]['eventcount'];
            }
            else{
            $todaydinner=0;
            }
            if(!empty($appetizer)){
            $todayappetizer=$appetizer_ar[0]['eventcount'];
            }
            else{
            $todayappetizer=0;
            }
            if(!empty($appetizer_first_item_count)){
            $appetizer_first_item=$total_count_app_first_item;
            }
            else{
            $appetizer_first_item=0;
            }
            $event_data=DB::Select("select count(distinct vce.event_id) as count,vce.cat_event_type from dev.vr_cat_event vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vci.item_id=vcs.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' group by vce.cat_event_type");
            $event_list_ar = json_decode(json_encode($event_data),true);
            $todays_event_data=DB::Select("Select sum(itemcount) as count,cat_event_type from(Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,
            cat_event_type from(Select distinct vcs.folio_id,vce.cat_event_type,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on
            vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$todayDate'
            and vci.item_type='Meal') Group By item_id,item_category,item_name,start_datetime,cat_event_type) Group by cat_event_type");
            $todays_event_data_ar = json_decode(json_encode($todays_event_data),true);
            $datatodayevent=DB::Select("select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from dev.vr_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vci.item_type='Meal' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type");
            $datatodayevent_ar = json_decode(json_encode($datatodayevent),true);
            $todayChargebalItemCount=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and (vci.item_id between 4033 and 4040 or vci.item_id between 6000 and 6035 or vci.item_id between 2000 and 2003))");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCount_ar =json_decode(json_encode($todayChargebalItemCount),true);
                $todayChargebalItemCount_ar =$todayChargebalItemCount_ar[0]['totl'];
                $todayChargebalItemCountBre=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Breakfast' and vci.item_id between 2000 and 2003)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountBre_ar =json_decode(json_encode($todayChargebalItemCountBre),true);
                $todayChargebalItemCountBre_ar =$todayChargebalItemCountBre_ar[0]['totl'];
                $todayChargebalItemCountLunch=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Lunch' and vci.item_id between 6000 and 6035)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountLunch_ar =json_decode(json_encode($todayChargebalItemCountLunch),true);
                $todayChargebalItemCountLunch_ar =$todayChargebalItemCountLunch_ar[0]['totl'];
                $todayChargebalItemCountDinner=DB::Select("Select sum(qty) as totl from ( Select distinct vcs.folio_id,vci.item_id,vcs.qty as qty from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vci.item_type='Meal' and vce.cat_event_type='Dinner' and vci.item_id between 4033 and 4040)");
               // return $todayChargebalItemCount[0];
                $todayChargebalItemCountDinner_ar =json_decode(json_encode($todayChargebalItemCountDinner),true);
                $todayChargebalItemCountDinner_ar =$todayChargebalItemCountDinner_ar[0]['totl'];
                if(empty($todayChargebalItemCount_ar)){
                    $todayChargebalItemCount_ar=0;
                }
                if(empty($todayChargebalItemCountBre_ar)){
                    $todayChargebalItemCountBre_ar=0;
                }
                if(empty($todayChargebalItemCountLunch_ar)){
                    $todayChargebalItemCountLunch_ar=0;
                }
                if(empty($todayChargebalItemCountDinner_ar)){
                    $todayChargebalItemCountDinner_ar=0;
                }
            return view('home',compact('todayDate','todaymenu','todaybreakfast','todaylunch','todaydinner','event_list_ar','todays_event_data_ar','todayappetizer','datatodayevent_ar','appetizer_first_item','todayChargebalItemCount_ar','todayChargebalItemCountBre_ar','todayChargebalItemCountLunch_ar','todayChargebalItemCountDinner_ar'));
            }
            else{
            return view('auth/login');
            }
            }
            //ese for hunting users
            else{

            $value = session()->get('id');
            if($value!=""){
            $todayDate=date('d-m-Y');
            $todayHuntingEventNum=DB::Select("Select count(ec) as count from (Select COUNT(distinct vce.event_id) as ec,vce.event_id,vce.cat_event_type from
                  dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join
                  dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                  To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' group by
                  vce.event_id,vce.cat_event_type)");
            $todayHuntingEventNum_ar = json_decode(json_encode($todayHuntingEventNum),true);

            $todayGuidedEventNum=DB::Select("Select Count(cm) as count from (Select COUNT(distinct vce.event_id) as cm from
                    dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci
                    on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and
                    vce.cat_event_type LIKE '%Hunting%' and vci.item_name NOT LIKE '%(Unassigned)%' and vci.item_type='Guide'
                    group by vce.event_id)");
            $todayGuidedEventNum_ar = json_decode(json_encode($todayGuidedEventNum),true);

            $totalNumGuide=DB::Select("Select Count(distinct item_id) as count from dev.vr_cat_items where
            item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            $totalNumGuide_ar = json_decode(json_encode($totalNumGuide),true);

            $totalAsignedGuide=DB::Select("Select COUNT(DISTINCT vci.item_id) as count from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
            inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
            vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuide_ar=json_decode(json_encode($totalAsignedGuide),true);

            $todayHuntingEventInfo=DB::Select(" Select vce.event_id,vce.cat_event_type,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name from
            dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where
            To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' ");
            $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo),true);

            $totalAsignedGuideInfo=DB::Select("Select distinct vci.item_id,vci.item_name,vce.name,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
            inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
            vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)'");
            $totalAsignedGuideInfo_ar=json_decode(json_encode($totalAsignedGuideInfo),true);

            $totalUnasignedGuideInfo=DB::Select("Select distinct vci.item_id,vci.item_name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
            inner join dev.vr_cat_items vci on vcs.item_id!=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
            vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalUnasignedGuideInfo_ar=json_decode(json_encode($totalUnasignedGuideInfo),true);

             $todayGuideUnassignedEventNum=DB::Select("Select Count(cm) as count from (Select COUNT(distinct vce.event_id) as cm from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_name LIKE '%(Unassigned)%' and vci.item_type='Guide' group by vce.event_id)");
                    $todayGuideUnassignedEventNum_ar=json_decode(json_encode($todayGuideUnassignedEventNum),true);
            return view('GuideReservationHunting.homeForReservation',compact('todayHuntingEventNum_ar','todayGuidedEventNum_ar','totalNumGuide_ar','totalAsignedGuide_ar','todayHuntingEventInfo_ar','totalAsignedGuideInfo_ar','totalUnasignedGuideInfo_ar','todayDate','todayGuideUnassignedEventNum_ar'));
            }
            else{
            return view('auth/login');
            }

            }
    }
    // Galary
    public function galary()
    {
        $value = session()->get('id');
            if($value!=""){
                $date="08-31-2019";
                $todayDate=$date;
            $dataoftodaysitemstocook=DB::Select("Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,cat_event_type,item_desc
            from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,vci.item_category,vce.cat_event_type as cat_event_type,
            TO_CHAR(vce.start_datetime,'MM-DD-YYYY') As start_datetime,TO_CHAR(vce.start_datetime,'MM-DD-YYYY HH24:MI:SS') as start_time
            from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on
            vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'MM-DD-YYYY')='$date' and vci.item_type='Meal')
            Group By item_name,item_id,item_category,start_datetime,cat_event_type,item_desc Order By cat_event_type");
             $dataoftodaysitemstocook_ar = json_decode(json_encode($dataoftodaysitemstocook),true);
          //  return $dataoftodaysitemstocook_ar;
        return view('galary',compact('dataoftodaysitemstocook_ar','date','todayDate'));
            }
            else{
              return view('auth/login');
            }
    }
    public function firstTimeUserPassword(Request $request)
    {
            $id=$request['id'];
            $passwordchange=$request['passwordchange'];
            $passwordchange2=encrypt($passwordchange);
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "kingranchum";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            $sql = "UPDATE USERS SET PASSWORD = '$passwordchange2',FIRST_TIME_FLAG='Y' WHERE ID = $id;";
            $update = $conn->query($sql);

            $conn->close();
            return view('auth/login');
                // return view('admin.users.index', compact('users'));
            }

    public function logout()
    {
            session()->flush();
            // return view('auth/login');
            // change on 15-05-2023
            return redirect('/');
    }
    public function testPdf()
        {

            //  $todayDate='05-09-2019';
            // new added : start
            $dataoftodaysitemstocook=DB::Select("Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,
                cat_event_type,item_desc from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,
                vci.item_category,vce.cat_event_type as cat_event_type,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,
                TO_CHAR(vce.start_datetime,'DD-MM-YYYY HH24:MI:SS') as start_time from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs
                on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id ) Group By item_name,item_id,item_desc,
                item_category,start_datetime,cat_event_type Order By cat_event_type");
            $appetizer_ar = json_decode(json_encode($dataoftodaysitemstocook),true);
            return view('TodayMenu/AlldayMenu',compact('appetizer_ar','todayDate'));
            }
            public function testPdf2(Request $request)
            {
            $fromdate=$request['filterdate'];
            $todate=$request['filterdate2'];

            //  $todayDate='05-09-2019';
            // new added : start
            $dataoftodaysitemstocook=DB::Select("Select sum(qty) as itemcount,item_id,item_category,item_name,start_datetime,
                cat_event_type,item_desc from(Select distinct vcs.folio_id,vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty,
                vci.item_category,vce.cat_event_type as cat_event_type,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,
                TO_CHAR(vce.start_datetime,'DD-MM-YYYY HH24:MI:SS') as start_time from dev.vr_CAT_EVENT vce inner join dev.vr_CAT_SALES vcs
                on vce.EVENT_ID=vcs.FOLIO_ID inner join dev.vr_CAT_ITEMS vci on vci.item_id=vcs.item_id where TO_CHAR(vce.start_datetime,'DD-MM-YYYY') between '$fromdate' and '$todate') Group By item_name,item_id,item_desc,
                item_category,start_datetime,cat_event_type Order By cat_event_type");
            $appetizer_ar = json_decode(json_encode($dataoftodaysitemstocook),true);
            return view('TodayMenu/AlldayMenu',compact('appetizer_ar','todayDate'));
            }
public function getItemList()
    {
        $value = session()->get('id');
        if($value!=""){
        $todayDate=date('m-d-Y');
        $cat_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_CAT_ITEMS order by item_id");
        $cat_item_list_ar = json_decode(json_encode($cat_item_list),true);
        $pms_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_PMS_ITEMS order by item_id");
        $pms_item_list_ar = json_decode(json_encode($pms_item_list),true);
        $emailSend="";
        return view('items/displayItemList',compact('cat_item_list_ar','pms_item_list_ar','todayDate','emailSend'));
        }
        else{
          return view('auth/login');
        }
    }
    public function getIteListOnEmail()
    {
       $value = session()->get('id');
        if($value!=""){
              $spreadsheet = new Spreadsheet();
              $sheet = $spreadsheet->getActiveSheet();
              $cat_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_CAT_ITEMS order by item_id");
              $cat_item_list_ar=json_decode(json_encode($cat_item_list), true);
              $sheet->setCellValue('A1', "SR.NO.");
              $sheet->setCellValue('B1',"Item ID");
              $sheet->setCellValue('C1',"Item Name");
              $sheet->setCellValue('D1',"Charge Code");
              $i=0;
              $j=2;
              foreach($cat_item_list_ar as $id => $itemList)  {
              $item_id=$cat_item_list_ar[$i]['item_id'];
              $item_name=$cat_item_list_ar[$i]['item_name'];
              $item_charge_code=$cat_item_list_ar[$i]['charge_code'];
              $sheet->setCellValue('A' . $j, $i+1);
              $sheet->setCellValue('B' . $j, $item_id);
              $sheet->setCellValue('C' . $j, $item_name);
              $sheet->setCellValue('D' . $j, $item_charge_code);
              $i++;
              $j++;
              }
              $writer = new Xlsx($spreadsheet);
              $cat_item_excel_path="Item_List_Excel\Catering_Items_".date('d-M-Y-H-i-s').".xlsx";
              $writer->save($cat_item_excel_path);

              $spreadsheet_pms = new Spreadsheet();
              $sheet_pms = $spreadsheet_pms->getActiveSheet();
              $pms_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_PMS_ITEMS order by item_id");
              $pms_item_list_ar=json_decode(json_encode($pms_item_list), true);
              $sheet_pms->setCellValue('A1', "SR.NO.");
              $sheet_pms->setCellValue('B1',"Item ID");
              $sheet_pms->setCellValue('C1',"Item Name");
              $sheet_pms->setCellValue('D1',"Charge Code");
              $i=0;
              $j=2;
              foreach($pms_item_list_ar as $id => $itemList)  {
              $item_id_pms=$pms_item_list_ar[$i]['item_id'];
              $item_name_pms=$pms_item_list_ar[$i]['item_name'];
              $item_charge_code_pms=$pms_item_list_ar[$i]['charge_code'];
              $sheet_pms->setCellValue('A' . $j, $i+1);
              $sheet_pms->setCellValue('B' . $j, $item_id_pms);
              $sheet_pms->setCellValue('C' . $j, $item_name_pms);
              $sheet_pms->setCellValue('D' . $j, $item_charge_code_pms);
              $i++;
              $j++;
              }
              $writer = new Xlsx($spreadsheet_pms);
              $pms_item_excel_path="Item_List_Excel\PMS_Items_".date('d-M-Y-H-i-s').".xlsx";
              $writer->save($pms_item_excel_path);

              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "kingranchum";
              $conn = new mysqli($servername, $username, $password, $dbname);
              if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
              }
              $sql1 = "SELECT * from USERS WHERE ID='$value' ";
              $verifyResult = $conn->query($sql1);
              if ($verifyResult->num_rows > 0) {
              $fetched_row = $verifyResult->fetch_assoc();

              $to_email_id_variable=$fetched_row['EMAIL'];
              $to_uname=$fetched_row['NAME'];
              $namet=strtok($to_uname, " ");
              }
              $mail = new PHPMailer();
              $msg="<p>Hi ".$namet.",</p>
              Please find the attached sheet of Catering Items and PMS Items.<br>
             <p style='color: red'>Note: Please do not reply to this message. This is a unmonitored Mailbox.</p> ";
              $mail->IsSMTP();
             // $mail->SMTPDebug=1;
              $mail->Mailer = "smtp";
              $mail->SMTPAuth = true;
              $mail->SMTPSecure = "tls";
              $mail->Port = 587;
              $mail->Host = "smtp.office365.com";
              $mail->Username = "rsdashboard@king-ranch.com";
              $mail->Password = "kptnrgwfnwmxzkhs";
              $mail->IsHTML(true);
              $mail->From = "rsdashboard@king-ranch.com";
              $mail->FromName = "King-Ranch (Resort Suite)";
              $mail->Subject = "Catering & PMS items";
              $mail->addAttachment($pms_item_excel_path);
              $mail->addAttachment($cat_item_excel_path);
              $mail->MsgHTML($msg);
              $mail->addAddress($to_email_id_variable);

              if (!$mail->send()) {
                // change on 15-05-2023
            //   echo "error";
            $emailSend="Sorry! Something Went wrong! please try again!";
              }
              else{
                          $todayDate=date('m-d-Y');
                  $cat_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_CAT_ITEMS order by item_id");
        $cat_item_list_ar = json_decode(json_encode($cat_item_list),true);
        $pms_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_PMS_ITEMS order by item_id");
        $pms_item_list_ar = json_decode(json_encode($pms_item_list),true);
        $emailSend="Email has been sent successfully.";
        return view('items/displayItemList',compact('cat_item_list_ar','pms_item_list_ar','todayDate','emailSend'));
              }
        }
        else{
          return view('auth/login');
        }
    }
    public function enterEmailSetup(){
        $this->validateUser();
      $value = session()->get('id');
        if($value!=""){
            $email_error="";
    	$todayDate=date('m-d-Y');
    	$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "kingranchum";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT * from emailsetup";
		$role = $conn->query($sql);
         //dd($role->num_rows);
		// $users[]="";
			$i=0;
			while($row = $role->fetch_assoc()) {
			$users[$i]=$row;
			$i=$i+1;
			}
            if($i==0){
                $users=Array();
            }
		$conn->close();
			 return view('items/emailSetupPage', compact('users','todayDate','email_error'));



        //  return view('items/emailSetupPage' ,compact('todayDate'));
        }
         else{
          return view('auth/login');
        }
    }
     public function addEmailSetupData(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
        $email_error="";
    	$todayDate=date('m-d-Y');
    	$namef=$request['emailtoadd'];
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "kingranchum";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		}

		$sql_check_mail = "SELECT * FROM EMAILSETUP WHERE UserEmail='$namef';";
		$role_check_mail = $conn->query($sql_check_mail);
		if($role_check_mail->num_rows > 0)
		{
        $email_error="Email already exists";
        }
        else{
        $sql = "INSERT INTO EMAILSETUP (UserEmail, UpdatedBy,UpdatedAt) VALUES ('$namef', '$value', '$todayDate');";
        $result = $conn->query($sql);
        }

        $sql2 = "SELECT * from emailsetup";
		$result2 = $conn->query($sql2);
         //dd($role->num_rows);
		// $users[]="";
			$i=0;
			while($row = $result2->fetch_assoc()) {
			$users[$i]=$row;
			$i=$i+1;
			}
            if($i==0){
                            $users=Array();
                        }

		$conn->close();
			 return view('items/emailSetupPage', compact('users','todayDate','email_error'));


        }
         else{
          return view('auth/login');
        }
    }
    public function deleteEmailSetupData(Request $request)
    {
        $value = session()->get('id');
        if($value!=""){
        $email_error="";
    	$todayDate=date('m-d-Y');
		$email_id=base64_decode($request['email_id']);
    	$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "kingranchum";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		}
		$sql = "DELETE FROM EMAILSETUP WHERE uniqueId='$email_id';";
		$delete = $conn->query($sql);
        $sql2 = "SELECT * from emailsetup";
		$result2 = $conn->query($sql2);
         //dd($role->num_rows);
		// $users[]="";
			$i=0;
			while($row = $result2->fetch_assoc()) {
			$users[$i]=$row;
			$i=$i+1;
			}

            if($i==0){
                $users=Array();
            }

		$conn->close();
			 return view('items/emailSetupPage', compact('users','todayDate','email_error'));
        }
         else{
          return view('auth/login');
        }
    }
    public function sendEmailByConsol()
    {
         $spreadsheet = new Spreadsheet();
              $sheet = $spreadsheet->getActiveSheet();
              $cat_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_CAT_ITEMS order by item_id");
              $cat_item_list_ar=json_decode(json_encode($cat_item_list), true);
              $sheet->setCellValue('A1', "SR.NO.");
              $sheet->setCellValue('B1',"Item ID");
              $sheet->setCellValue('C1',"Item Name");
              $sheet->setCellValue('D1',"Charge Code");
              $i=0;
              $j=2;
              foreach($cat_item_list_ar as $id => $itemList)  {
              $item_id=$cat_item_list_ar[$i]['item_id'];
              $item_name=$cat_item_list_ar
              [$i]['item_name'];
              $item_charge_code=$cat_item_list_ar[$i]['charge_code'];
              $sheet->setCellValue('A' . $j, $i+1);
              $sheet->setCellValue('B' . $j, $item_id);
              $sheet->setCellValue('C' . $j, $item_name);
              $sheet->setCellValue('D' . $j, $item_charge_code);
              $i++;
              $j++;
              }
              $writer = new Xlsx($spreadsheet);
              $cat_item_excel_path="Item_List_Excel\Catering_Items_'.date('d-M-Y-H-i-s').'.xlsx";
              $writer->save($cat_item_excel_path);

              $spreadsheet_pms = new Spreadsheet();
              $sheet_pms = $spreadsheet_pms->getActiveSheet();
              $pms_item_list=DB::Select("Select Item_ID,Item_Name,charge_code from DEV.VR_PMS_ITEMS order by item_id");
              $pms_item_list_ar=json_decode(json_encode($pms_item_list), true);
              $sheet_pms->setCellValue('A1', "SR.NO.");
              $sheet_pms->setCellValue('B1',"Item ID");
              $sheet_pms->setCellValue('C1',"Item Name");
              $sheet_pms->setCellValue('D1',"Charge Code");
              $i=0;
              $j=2;
              foreach($pms_item_list_ar as $id => $itemList)  {
              $item_id_pms=$pms_item_list_ar[$i]['item_id'];
              $item_name_pms=$pms_item_list_ar[$i]['item_name'];
              $item_charge_code_pms=$pms_item_list_ar[$i]['charge_code'];
              $sheet_pms->setCellValue('A' . $j, $i+1);
              $sheet_pms->setCellValue('B' . $j, $item_id_pms);
              $sheet_pms->setCellValue('C' . $j, $item_name_pms);
              $sheet_pms->setCellValue('D' . $j, $item_charge_code_pms);
              $i++;
              $j++;
              }
              $writer = new Xlsx($spreadsheet_pms);
              $pms_item_excel_path="Item_List_Excel\PMS_Items_'.date('d-M-Y-H-i-s').'.xlsx";
              $writer->save($pms_item_excel_path);

              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "kingranchum";
              $conn = new mysqli($servername, $username, $password, $dbname);
              if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
              }
              $sql1 = "SELECT * from emailsetup";
              $verifyResult = $conn->query($sql1);

              $mail = new PHPMailer();
              $msg="<p>Hello,</p>
              Please find the attached sheet of Catering Items and PMS Items.<br>
              <p style='color: red'>Note: Please do not reply to this message. This is a unmonitored Mailbox.</p> ";

              $mail->IsSMTP();
              //$mail->SMTPDebug=1;
              $mail->Mailer = "smtp";
              $mail->SMTPAuth = true;
              $mail->SMTPSecure = "tls";
              $mail->Port = 587;
              $mail->Host = "smtp.office365.com";
              $mail->Username = "rsdashboard@king-ranch.com";
              $mail->Password = "kptnrgwfnwmxzkhs";
              $mail->IsHTML(true);
              $mail->From = "rsdashboard@king-ranch.com";
              $mail->FromName = "King-Ranch";
              $mail->Subject = "Catering & PMS Items";
              $mail->addAttachment($pms_item_excel_path);
              $mail->addAttachment($cat_item_excel_path);
              $mail->MsgHTML($msg);
              if ($verifyResult->num_rows > 0) {
             while($fetched_row = $verifyResult->fetch_assoc()){
              $to_email_id_variable=$fetched_row['EMAIL'];
              $mail->addAddress($to_email_id_variable);
             }
            }
            if (!$mail->send()) {
              echo "error";
              }
    }
    public function validateUser(){
        $user_role_session = session()->get('userrole');
        if ($user_role_session != "Super Admin") {
            abort(403, 'Unauthorized action.');
        }
    }
}
