<?php

namespace App\Http\Controllers;

use DateTime;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use DB;
use Illuminate\Http\Request;
use MYSQLI;
use PHPExcel;
use PHPExcel_IOFactory;

class EventController extends Controller
{
    public function createEvent()
    {
        return view('WeeklyMenu/weeklymenu');
    }
    public function calender()
    {
        $todayDate = date('m-d-Y');
        $fromdate = $todayDate;
        $todate = $todayDate;
        $tempTdayDate = explode("-", $todayDate);
        $fromdate = $tempTdayDate[0] . "-" . "01" . "-" . $tempTdayDate[2];
        $todate = $tempTdayDate[0] . "-" . "31" . "-" . $tempTdayDate[2];
        $value = session()->get('id');
        if ($value != "") {
            $data = DB::Select("select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from DEV.VR_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vci.item_type='Meal' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY') between '$fromdate' and '$todate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type");
            //and TO_CHAR(vce.start_datetime,'MM-DD-YYYY') between '12-01-2021' and '12-30-2021'
            $data_ar = json_decode(json_encode($data), true);
            $i = 0;
            $events = [];
            $color = '';
            foreach ($data_ar as $id => $eventcount) {
                $item_count = $data_ar[$i]['event_count'];
                $start_datetime = $data_ar[$i]['start_datetime'];
                $event_type = $data_ar[$i]['cat_event_type'];
                switch ($event_type) {

                    case "Breakfast":
                        $color = '#FFA500';
                        break;
                    case "Hunting - Oscar Longoria":
                        $color = '#FFCC66';
                        break;
                    case "Hunting":
                        $color = '#FF0000';
                        break;
                    case "Kineno":
                        $color = '#660099';
                        break;
                    case "Brush Management":
                        $color = '#FF0000';
                        break;
                    case "Birding":
                        $color = '#FFFFFF';
                        break;
                    case "Cocktail Cruise":
                        $color = '#00FFFF';
                        break;
                    case "Recreation":
                        $color = '#FFB6C1';
                        break;
                    case "Hunting - Jimmy McBee":
                        $color = '#FF7F50';
                        break;
                    case "Meeting":
                        $color = '#FFA500';
                        break;
                    case "Hunting - Phillip Winter":
                        $color = '#33CCFF';
                        break;
                    case "Lunch":
                        $color = '#32CD32';
                        break;
                    case "Cocktails":
                        $color = '#CCFFFF';
                        break;
                    case "Hunting - Joey Salazar":
                        $color = '#00FA99';
                        break;
                    case "Box Lunch":
                        $color = '#0000FF';
                        break;
                    case "Appetizers":
                        $color = '#00FA9A';
                        break;
                    case "Dessert":
                        $color = '#F0E68C';
                        break;
                    case "Skeet Shooting":
                        $color = '#FF8C00';
                        break;
                    case "Dinner":
                        $color = '#FFFF00';
                        break;
                    case "Hunting - Weston Koehler":
                        $color = '#9370DB';
                        break;
                    case "Buisness":
                        $color = '#B0E0E6';
                        break;
                    case "Hunting - Hayden Johnson":
                        $color = '#F0FFFF';
                        break;
                    case "Brunch":
                        $color = '#48D1CC';
                        break;
                    default:
                        $color = '#48D1CC';
                }
                if ($event_type == "Breakfast" || $event_type == "Lunch" || $event_type == "Dinner") {
                    if ($event_type == 'Breakfast') {
                        $item_data = DB::Select("Select sum(count_item) as itemcount from(Select distinct vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty as count_item from dev.vr_cat_sales vcs inner join
                                dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                                TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$start_datetime' and vce.cat_event_type='$event_type' and vci.item_type='Meal' and vci.item_id between 2000 and 2003)");
                    }
                    if ($event_type == 'Lunch') {
                        $item_data = DB::Select("Select sum(count_item) as itemcount from(Select distinct vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty as count_item from dev.vr_cat_sales vcs inner join
                                dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                                TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$start_datetime' and vce.cat_event_type='$event_type' and vci.item_type='Meal' and vci.item_id between 6000 and 6035)");
                    }
                    if ($event_type == 'Dinner') {
                        $item_data = DB::Select("Select sum(count_item) as itemcount from(Select distinct vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty as count_item from dev.vr_cat_sales vcs inner join
                                dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                                TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$start_datetime' and vce.cat_event_type='$event_type' and vci.item_type='Meal' and vci.item_id between 4033 and 4040)");
                    }
                } else {
                    $item_data = DB::Select("Select sum(count_item) as itemcount from(Select distinct vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty as count_item from dev.vr_cat_sales vcs inner join
                                dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                                TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$start_datetime' and vce.cat_event_type='$event_type' and vci.item_type='Meal')");
                }



                $item_data_ar = json_decode(json_encode($item_data), true);
                $itemc = $item_data_ar[0]['itemcount'];
                if (empty($itemc)) {
                    $itemc = 0;
                }
                if (empty($event_type)) {
                    $event_type = "Other";
                }
                $events[] = Calendar::event(
                    "$event_type:$item_count [Total:$itemc]",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($start_datetime . '-1 day'),
                    null,
                    // Add color
                    [
                        'color' => "$color",
                        'textColor' => '#0e0f0e',
                        'url' => "/ondatemenusfromcalendar/" . base64_encode($start_datetime) . "/" . base64_encode($event_type),
                    ]
                );
                $i++;
            }
            $calendar = Calendar::addEvents($events);
            return view('GuideReservationHunting/WeeklyHunting', compact('calendar', 'todayDate', 'fromdate', 'todate'));
        } else {
            return view('auth.login');
        }
    }
    public function HuntingCalendar()
    {
        $todayDate = date('m-d-Y');
        $fromdate = $todayDate;
        $todate = $todayDate;
        $tempTdayDate = explode("-", $todayDate);
        $fromdate = $tempTdayDate[0] . "-" . "01" . "-" . $tempTdayDate[2];
        $todate = $tempTdayDate[0] . "-" . "31" . "-" . $tempTdayDate[2];

        $value = session()->get('id');
        if ($value != "") {
            $data = DB::Select("select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from DEV.VR_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id
                    where vci.item_type='Guide' and vce.cat_event_type LIKE '%Hunting%' and
                    TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') between '$fromdate' and '$todate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type");
            $data_ar = json_decode(json_encode($data), true);
            $i = 0;
            $events = [];
            $color = '';
            $type_data = "";
            // return $data_ar;
            foreach ($data_ar as $id => $eventcount) {
                $item_count = $data_ar[$i]['event_count'];
                $start_datetime = $data_ar[$i]['start_datetime'];
                $date_var = $start_datetime;
                $event_type = $data_ar[$i]['cat_event_type'];
                $type_data = "AllEVENTS";
                switch ($event_type) {
                    case "Hunting":
                        $color = '#FF0000';
                        break;
                    default:
                        $color = '#48D1CC';
                }

                if (empty($event_type)) {
                    $event_type = "Other";
                }
                $events[] = Calendar::event(
                    "Total Event:$item_count",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($start_datetime . '-1 day'),
                    null,
                    // Add color
                    [
                        'color' => "#00BFFF",
                        'textColor' => '#0e0f0e',
                        'url' => "/oncalenderhuntingeventsinfo/" . base64_encode($start_datetime) . "/" . base64_encode($type_data),
                    ]
                );
                $assigned_data = DB::Select("Select Count(cm) as event_count from (Select COUNT(distinct vce.event_id) as cm from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'DD-MM-YYYY')='$date_var' and vce.cat_event_type LIKE '%Hunting%' and vci.item_name NOT LIKE '%(Unassigned)%' and vci.item_type='Guide' group by vce.event_id)");
                $assigned_data_ar = json_decode(json_encode($assigned_data), true);
                if (empty($assigned_data_ar)) {
                    $count = 0;
                } else {
                    //$explodValue=(explode(" ",$assigned_data));
                    $count = $assigned_data_ar[0]['event_count'];
                }

                $type_data = "ASSIGNEDEVENTS";
                $events[] = Calendar::event(
                    "Assigned Event:$count",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($start_datetime . '-1 day'),
                    null,
                    // Add color
                    [
                        'color' => "#00FF00",
                        'textColor' => '#0e0f0e',
                        'url' => "/oncalenderhuntingeventsinfo/" . base64_encode($start_datetime) . "/" . base64_encode($type_data),
                    ]
                );
                $unasignedcount = $item_count - $count;
                $type_data = "UNASSIGNEDEVENTS";
                $events[] = Calendar::event(
                    "Unassigned Event:$unasignedcount",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($start_datetime . '-1 day'),
                    null,
                    // Add color
                    [
                        'color' => "#FFFF00",
                        'textColor' => '#0e0f0e',
                        'url' => "/oncalenderhuntingeventsinfo/" . base64_encode($start_datetime) . "/" . base64_encode($type_data),
                    ]
                );
                $i++;
            }
            $calendar = Calendar::addEvents($events);
            return view('WeeklyMenu/weeklymenu', compact('calendar', 'todayDate', 'fromdate', 'todate'));
        } else {
            return view('auth.login');
        }
    }

    //Newlly changed

    // change on 15-05-2023
    //Revised Calender For hunting Start
    public function HuntingCalendarRevised(Request $request)
    {
        $flag = $request['flag'];

        $todayDate = date('Y-m-d');
        $fromdate = $todayDate;
        $todate = $todayDate;
        $tempTdayDate = explode("-", $todayDate);
        $fromdate = $tempTdayDate[0] . "-" . $tempTdayDate[1] . "-" . "01";
        $todate = $tempTdayDate[0] . "-" . $tempTdayDate[1] . "-" . "31";
        $value = session()->get('id');
        if ($value != "") {
            if ($flag == 'Calender') {
                $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                from (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                from DEV.VR_CAT_EVENT vce
                                inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                                inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                                where vce.cat_event_type LIKE '%Hunting%' and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate') rs
                left join dev.vr_cat_items vci on rs.item_id=vci.item_id");
                $data_ar = json_decode(json_encode($data), true);
                $i = 0;
                $events = [];
                $color = '';
                $type_data = "";
                // return $data_ar;
                foreach ($data_ar as $id => $eventcount) {
                    $start_datetime = $data_ar[$i]['start_datetime'];
                    $date_var = $start_datetime;
                    $company_party_name = $data_ar[$i]['company_party_name'];
                    $customer = $data_ar[$i]['customer'];
                    $cat_sales_stage = $data_ar[$i]['cat_sales_stage'];
                    if ($data_ar[$i]['guide_name'] == NULL) {
                        $guide = "NA";
                    } else {
                        $guide = $data_ar[$i]['guide_name'];
                    }

                    $event_id = $data_ar[$i]['event_id'];

                    $events[] = Calendar::event(
                        "$company_party_name|$customer|$cat_sales_stage|$guide",

                        true,
                        new \DateTime($start_datetime),
                        new \DateTime($start_datetime . '-1 day'),
                        null,
                        // Add color
                        [
                            'color' => "#20a8d8",
                            'textColor' => '#ffffff',
                            'url' => "/oncalenderhuntingeventsinforevised/" . base64_encode($start_datetime) . "/" . base64_encode($event_id) . "/" . base64_encode($guide),
                        ]
                    );

                    $i++;
                }
                // $calendar = Calendar::addEvents($events);
                $calendar = Calendar::addEvents($events)->setOptions(['firstDay' => 0])->setCallbacks([
                    'eventRender' => 'function(event,jqEvent,view){jqEvent.tooltip({placement: "top",title: event.title});}'
                ]);
            } else {
                // Miltary date format change start 26/09/2023
                $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                from
                  (Select vc.name as customer_name,vcs.cat_sales_stage, TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY HH:MM AM') As start_datetime,TO_CHAR(vce.END_DATETIME,'MM-DD-YYYY HH:MM AM') As end_datetime
                            ,vce.company_party_name as type_of_hunt,vcs.market_code, vc.main_phone as customer_phone_no, TO_CHAR(vcs.folio_open_date,'MM-DD-YYYY') as HuntStart, TO_CHAR(vcs.folio_close_date,'MM-DD-YYYY') as HuntEnd, vc.vip_level,vcs.item_id,vcs.folio_id,vce.room,vce.event_id,vce.group_folio_id
                            from DEV.VR_CAT_EVENT vce
                            inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                            inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                            where vce.cat_event_type LIKE '%Hunting%'
                            and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate') rs
                left join dev.vr_cat_items vci on rs.item_id=vci.item_id");
                // Miltary date format change end 26/09/2023
                $data_ar = json_decode(json_encode($data), true);
                $i = 0;
                foreach ($data_ar as $id => $eventcount) {
                    $folioid = $data_ar[$i]['folio_id'];
                    $paymentInfo = DB::select("select amount,txn_date from dev.vr_cat_payments where folio_id=$folioid");
                    $paymentInfo_ar = json_decode(json_encode($paymentInfo), true);
                    if (count($paymentInfo_ar) > 0) {
                        $data_ar[$i]['amount'] = $paymentInfo_ar[$i]['amount'];
                        $data_ar[$i]['txn_date'] = $paymentInfo_ar[$i]['txn_date'];
                    } else {
                        $data_ar[$i]['amount'] = "NA";
                        $data_ar[$i]['txn_date'] = "NA";
                    }
                    $groupfolioid = $data_ar[$i]['group_folio_id'];
                    $marketcode = DB::select("select market_code from dev.vr_cat_sales where folio_id=$groupfolioid");
                    $marketcode_ar = json_decode(json_encode($marketcode), true);
                    $data_ar[$i]['market_code'] = $marketcode_ar[0]['market_code'];
                    $i++;
                }
            }
            // dd($data_ar);
            $todayDate = date('m-d-Y');
            $fromdate = $todayDate;
            $todate = $todayDate;
            $tempTdayDate = explode("-", $todayDate);
            $fromdate = $tempTdayDate[0] . "-" . "01" . "-" . $tempTdayDate[2];
            $todate = $tempTdayDate[0] . "-" . "31" . "-" . $tempTdayDate[2];

            // $calendar = Calendar::addEvents($events)->setOptions(['firstDay'=>0])->setCallbacks([
            //         'eventMouseover'=>'function(event,jsEvent,view){alert(event.title)}']);


            //Change On 24/05/2023
            //for dropdown of guide
            $listOfAllTheGuides = DB::Select("SELECT distinct item_name,ROWNUM AS item_id
            FROM
            (select distinct REGEXP_REPLACE(item_name,' -.*$','') as item_name
            FROM DEV.vr_cat_items
            where item_type = 'Guide' and item_name NOT LIKE '%(Unassigned)%'
            )
            Order By item_name");
            $listOfAllTheGuides_ar = json_decode(json_encode($listOfAllTheGuides), true);
            $countq = count($listOfAllTheGuides_ar);

            $listOfAllTheGuides_ar[0] = array();
            $listOfAllTheGuides_ar[0]['item_id'] = '0';
            $listOfAllTheGuides_ar[0]['item_name'] = 'All';

            $guide_id = 'All';

            // $hunt_type = 'ALL';
            // for dropdown of Hunt Type
            // $listOfAllTheHuntType = DB::Select("Select distinct VIP_LEVEL from DEV.vr_customers");
            // $listOfAllTheHuntType_ar = json_decode(json_encode($listOfAllTheHuntType), true);
            // $countqh = count($listOfAllTheHuntType_ar);

            // $listOfAllTheHuntType_ar[0] = array();
            // $listOfAllTheHuntType_ar[0]['vip_level'] = 'All';

            // for dropdown of Hunt Type
            $market_code = 'All';

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "kingranchum";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * from marketcodesetup";
            $market_code_list = $conn->query($sql);
            $market_code_list_ar[] = "";
            if ($market_code_list->num_rows > 0) {
                $i = 0;
                while ($row = $market_code_list->fetch_assoc()) {
                    $market_code_list_ar[$i] = $row;
                    $i = $i + 1;
                }
            }
            $conn->close();
            // $listOfAllTheHuntType_ar = json_decode(json_encode($listOfAllTheHuntType), true);
            $countqh = count($market_code_list_ar);

            $market_code_list_ar[$countqh] = array();
            $market_code_list_ar[$countqh]['id'] = $countqh + 1;
            $market_code_list_ar[$countqh]['market_code'] = 'All';
            // dd($market_code_list_ar);

            if ($flag == 'Calender') {
                // return view('WeeklyMenu/weeklymenurevised', compact('calendar', 'todayDate', 'fromdate', 'hunt_type', 'todate', 'listOfAllTheGuides_ar', 'listOfAllTheHuntType_ar', 'guide_id'));
                return view('WeeklyMenu/weeklymenurevised', compact('calendar', 'todayDate', 'fromdate', 'market_code', 'todate', 'listOfAllTheGuides_ar', 'market_code_list_ar', 'guide_id'));
            } else {
                // return view('extracthuntingdatarevised', compact('data_ar', 'todayDate', 'listOfAllTheGuides_ar', 'listOfAllTheHuntType_ar', 'guide_id', 'hunt_type', 'fromdate', 'todate'));
                return view('extracthuntingdatarevised', compact('data_ar', 'todayDate', 'listOfAllTheGuides_ar', 'market_code_list_ar', 'guide_id', 'market_code', 'fromdate', 'todate'));
            }
        } else {
            return view('auth.login');
        }
    }
    public function HuntingCalendarFilterRevised(Request $request)
    {
        $flag = base64_decode($request['flag']);

        $todayDate = date('m-d-Y');
        $fromdate = base64_decode($request['fromdate']);
        $todate = base64_decode($request['todate']);

        $tempTdayDate = explode("-", $fromdate);
        $fromdate = $tempTdayDate[2] . "-" . $tempTdayDate[0] . "-" . $tempTdayDate[1];
        $tempTdayDate = explode("-", $todate);
        $todate = $tempTdayDate[2] . "-" . $tempTdayDate[0] . "-" . $tempTdayDate[1];

        $value = session()->get('id');
        $guide_id = base64_decode($request['guide_id']);
        $market_code = base64_decode($request['hunt_type']);
        // dd($hunt_type);
        if ($value != "") {
            if ($flag == 'Calender') {
                if ($guide_id == 'All' && $market_code == "All") {
                    $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                    from (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                    REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                    from DEV.VR_CAT_EVENT vce
                                    inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                                    inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                                    where vce.cat_event_type LIKE '%Hunting%' and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate') rs
                    left join dev.vr_cat_items vci on rs.item_id=vci.item_id");
                } else if ($guide_id != 'All' && $market_code == "All") {
                    $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                    from (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                    REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                    from DEV.VR_CAT_EVENT vce
                                    inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                                    inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                                    where vce.cat_event_type LIKE '%Hunting%' and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate') rs
                    left join dev.vr_cat_items vci on rs.item_id=vci.item_id
                    where vci.item_name like '%$guide_id%'");
                } else if ($guide_id == "All" && $market_code != "All") {
                    $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                    from
                        (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                    REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                    from (select vcev.*
                                  from dev.vr_cat_event vcev
                                  inner join dev.vr_cat_sales vcsa on vcev.group_folio_id=vcsa.folio_id
                                  where vcsa.market_code='$market_code') vce
                            inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                            inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                            where vce.cat_event_type LIKE '%Hunting%'
                            and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate')rs
                    left join dev.vr_cat_items vci on rs.item_id=vci.item_id");
                } else {
                    $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                    from
                        (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                    REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                    from (select vcev.*
                                  from dev.vr_cat_event vcev
                                  inner join dev.vr_cat_sales vcsa on vcev.group_folio_id=vcsa.folio_id
                                  where vcsa.market_code='$market_code') vce
                            inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                            inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                            where vce.cat_event_type LIKE '%Hunting%'
                            and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate')rs
                    left join dev.vr_cat_items vci on rs.item_id=vci.item_id
                    where vci.item_name like '%$guide_id%'");
                }

                $data_ar = json_decode(json_encode($data), true);
                $i = 0;
                $events = [];
                $color = '';
                $type_data = "";
                // return $data_ar;
                foreach ($data_ar as $id => $eventcount) {
                    $start_datetime = $data_ar[$i]['start_datetime'];
                    $date_var = $start_datetime;
                    $company_party_name = $data_ar[$i]['company_party_name'];
                    $customer = $data_ar[$i]['customer'];
                    $cat_sales_stage = $data_ar[$i]['cat_sales_stage'];
                    if ($data_ar[$i]['guide_name'] == NULL) {
                        $guide = "NA";
                    } else {
                        $guide = $data_ar[$i]['guide_name'];
                    }
                    $event_id = $data_ar[$i]['event_id'];
                    $events[] = Calendar::event(
                        "$company_party_name|$customer|$cat_sales_stage|$guide",

                        true,
                        new \DateTime($start_datetime),
                        new \DateTime($start_datetime . '-1 day'),
                        null,
                        // Add color
                        [
                            'color' => "#20a8d8",
                            'textColor' => '#ffffff',
                            'url' => "/oncalenderhuntingeventsinforevised/" . base64_encode($start_datetime) . "/" . base64_encode($event_id) . "/" . base64_encode($guide),
                        ]
                    );

                    $i++;
                }
                // $calendar = Calendar::addEvents($events);
                $calendar = Calendar::addEvents($events)->setOptions(['firstDay' => 0])->setCallbacks([
                    'eventRender' => 'function(event,jqEvent,view){jqEvent.tooltip({placement: "top",title: event.title});}'
                ]);
            } else {
                if ($guide_id == 'All' && $market_code == 'All') {
                    $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                    from
                      (Select vc.name as customer_name,vcs.cat_sales_stage, TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY HH:MM AM') As start_datetime,TO_CHAR(vce.END_DATETIME,'MM-DD-YYYY HH:MM AM') As end_datetime
                                ,vce.company_party_name as type_of_hunt,vcs.market_code, vc.main_phone as customer_phone_no, TO_CHAR(vcs.folio_open_date,'MM-DD-YYYY') as HuntStart, TO_CHAR(vcs.folio_close_date,'MM-DD-YYYY') as HuntEnd, vc.vip_level,vcs.item_id,vcs.folio_id,vce.room,vce.event_id,vce.group_folio_id
                                from DEV.VR_CAT_EVENT vce
                                inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                                inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                                where vce.cat_event_type LIKE '%Hunting%'
                                and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate') rs
                    left join dev.vr_cat_items vci on rs.item_id=vci.item_id");
                } else if ($guide_id != 'All' && $market_code == "All") {
                    $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                    from
                      (Select vc.name as customer_name,vcs.cat_sales_stage, TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY HH:MM AM') As start_datetime,TO_CHAR(vce.END_DATETIME,'MM-DD-YYYY HH:MM AM') As end_datetime
                                ,vce.company_party_name as type_of_hunt,vcs.market_code, vc.main_phone as customer_phone_no, TO_CHAR(vcs.folio_open_date,'MM-DD-YYYY') as HuntStart, TO_CHAR(vcs.folio_close_date,'MM-DD-YYYY') as HuntEnd, vc.vip_level,vcs.item_id,vcs.folio_id,vce.room,vce.event_id,vce.group_folio_id
                                from DEV.VR_CAT_EVENT vce
                                inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                                inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                                where vce.cat_event_type LIKE '%Hunting%'
                                and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate') rs
                    left join dev.vr_cat_items vci on rs.item_id=vci.item_id
                    where vci.item_name like '%$guide_id%'");
                } else if ($guide_id == 'All' && $market_code != "All") {
                    $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                    from
                            (Select vc.name as customer_name,vcs.cat_sales_stage, TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY HH:MM AM') As start_datetime,TO_CHAR(vce.END_DATETIME,'MM-DD-YYYY HH:MM AM') As end_datetime
                                    ,vce.company_party_name as type_of_hunt,vcs.market_code, vc.main_phone as customer_phone_no, TO_CHAR(vcs.folio_open_date,'MM-DD-YYYY') as HuntStart, TO_CHAR(vcs.folio_close_date,'MM-DD-YYYY') as HuntEnd, vc.vip_level,vcs.item_id,vcs.folio_id,vce.room,vce.event_id,vce.group_folio_id
                            from (select vcev.*
                                  from dev.vr_cat_event vcev
                                  inner join dev.vr_cat_sales vcsa on vcev.group_folio_id=vcsa.folio_id
                                  where vcsa.market_code='$market_code') vce
                            inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                            inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                            where vce.cat_event_type LIKE '%Hunting%'
                            and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate')rs
                    left join dev.vr_cat_items vci on rs.item_id=vci.item_id");
                } else {
                    $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                    from
                            (Select vc.name as customer_name,vcs.cat_sales_stage, TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY HH:MM AM') As start_datetime,TO_CHAR(vce.END_DATETIME,'MM-DD-YYYY HH:MM AM') As end_datetime
                                    ,vce.company_party_name as type_of_hunt,vcs.market_code, vc.main_phone as customer_phone_no, TO_CHAR(vcs.folio_open_date,'MM-DD-YYYY') as HuntStart, TO_CHAR(vcs.folio_close_date,'MM-DD-YYYY') as HuntEnd, vc.vip_level,vcs.item_id,vcs.folio_id,vce.room,vce.event_id,vce.group_folio_id
                            from (select vcev.*
                                  from dev.vr_cat_event vcev
                                  inner join dev.vr_cat_sales vcsa on vcev.group_folio_id=vcsa.folio_id
                                  where vcsa.market_code='$market_code') vce
                            inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                            inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                            where vce.cat_event_type LIKE '%Hunting%'
                            and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate')rs
                    left join dev.vr_cat_items vci on rs.item_id=vci.item_id
                    where vci.item_name like '%$guide_id%'");
                }

                $data_ar = json_decode(json_encode($data), true);
                $i = 0;
                foreach ($data_ar as $id => $eventcount) {
                    $folioid = $data_ar[$i]['event_id'];
                    $paymentInfo = DB::select("select amount,txn_date from dev.vr_cat_payments where folio_id=$folioid");
                    $paymentInfo_ar = json_decode(json_encode($paymentInfo), true);
                    if (count($paymentInfo_ar) > 0) {
                        $data_ar[$i]['amount'] = $paymentInfo_ar[$i]['amount'];
                        $data_ar[$i]['txn_date'] = $paymentInfo_ar[$i]['txn_date'];
                    } else {
                        $data_ar[$i]['amount'] = "NA";
                        $data_ar[$i]['txn_date'] = "NA";
                    }

                    $groupfolioid = $data_ar[$i]['group_folio_id'];
                    $marketcode = DB::select("select market_code from dev.vr_cat_sales where folio_id=$groupfolioid");
                    $marketcode_ar = json_decode(json_encode($marketcode), true);
                    $data_ar[$i]['market_code'] = $marketcode_ar[0]['market_code'];

                    $i++;
                }
            }
            $todayDate = date('m-d-Y');
            $tempTdayDate = explode("-", $fromdate);
            $fromdate = $tempTdayDate[1] . "-" . $tempTdayDate[2] . "-" . $tempTdayDate[0];

            $tempTdayDate = explode("-", $todate);
            $todate = $tempTdayDate[1] . "-" . $tempTdayDate[2] . "-" . $tempTdayDate[0];

            //Change On 24/05/2023
            //for dropdown of guide
            $listOfAllTheGuides = DB::Select("SELECT distinct item_name,ROWNUM AS item_id
            FROM
            (select distinct REGEXP_REPLACE(item_name,' -.*$','') as item_name
            FROM DEV.vr_cat_items
            where item_type = 'Guide' and item_name NOT LIKE '%(Unassigned)%'
            )
            Order By item_name");
            $listOfAllTheGuides_ar = json_decode(json_encode($listOfAllTheGuides), true);
            $countq = count($listOfAllTheGuides_ar);

            $listOfAllTheGuides_ar[0] = array();
            $listOfAllTheGuides_ar[0]['item_id'] = '0';
            $listOfAllTheGuides_ar[0]['item_name'] = 'All';
            //for dropdown of Hunt
            // $listOfAllTheHuntType = DB::Select("Select distinct VIP_LEVEL from DEV.vr_customers");
            // $listOfAllTheHuntType_ar = json_decode(json_encode($listOfAllTheHuntType), true);
            // $countqh = count($listOfAllTheHuntType_ar);

            // $listOfAllTheHuntType_ar[0] = array();
            // $listOfAllTheHuntType_ar[0]['vip_level'] = 'All';

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "kingranchum";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * from marketcodesetup";
            $market_code_list = $conn->query($sql);
            $market_code_list_ar[] = "";
            if ($market_code_list->num_rows > 0) {
                $i = 0;
                while ($row = $market_code_list->fetch_assoc()) {
                    $market_code_list_ar[$i] = $row;
                    $i = $i + 1;
                }
            }
            $conn->close();
            // $listOfAllTheHuntType_ar = json_decode(json_encode($listOfAllTheHuntType), true);
            $countqh = count($market_code_list_ar);

            $market_code_list_ar[$countqh] = array();
            $market_code_list_ar[$countqh]['id'] = $countqh + 1;
            $market_code_list_ar[$countqh]['market_code'] = 'All';
            // dd($market_code_list_ar);

            if ($flag == 'Calender') {
                // return view('WeeklyMenu/weeklymenurevised', compact('calendar', 'todayDate', 'fromdate', 'todate', 'guide_id', 'hunt_type', 'listOfAllTheGuides_ar', 'listOfAllTheHuntType_ar', 'guideid'));
                return view('WeeklyMenu/weeklymenurevised', compact('calendar', 'todayDate', 'fromdate', 'todate', 'guide_id', 'market_code', 'listOfAllTheGuides_ar', 'market_code_list_ar', 'guideid'));
            } else {
                // return view('extracthuntingdatarevised', compact('data_ar', 'todayDate', 'listOfAllTheGuides_ar', 'listOfAllTheHuntType_ar', 'guide_id', 'hunt_type', 'fromdate', 'todate'));
                return view('extracthuntingdatarevised', compact('data_ar', 'todayDate', 'listOfAllTheGuides_ar', 'market_code_list_ar', 'guide_id', 'market_code', 'fromdate', 'todate'));
            }
        } else {
            return view('auth.login');
        }
    }
    public function calenderMenuOnBtnClick(Request $request)
    {
        $todayDate = date('m-d-Y');
        $fromdate = $request['fromdate'];
        $todate = $request['todate'];

        $value = session()->get('id');
        if ($value != "") {
            $data = DB::Select("select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from DEV.VR_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where vci.item_type='Meal' and TO_CHAR(vce.start_datetime,'MM-DD-YYYY') between '$fromdate' and '$todate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type");
            $data_ar = json_decode(json_encode($data), true);
            $i = 0;
            $events = [];
            $color = '';
            foreach ($data_ar as $id => $eventcount) {
                $item_count = $data_ar[$i]['event_count'];
                $start_datetime = $data_ar[$i]['start_datetime'];
                $event_type = $data_ar[$i]['cat_event_type'];
                switch ($event_type) {

                    case "Breakfast":
                        $color = '#FFA500';
                        break;
                    case "Hunting - Oscar Longoria":
                        $color = '#FFCC66';
                        break;
                    case "Hunting":
                        $color = '#FF0000';
                        break;
                    case "Kineno":
                        $color = '#660099';
                        break;
                    case "Brush Management":
                        $color = '#FF0000';
                        break;
                    case "Birding":
                        $color = '#FFFFFF';
                        break;
                    case "Cocktail Cruise":
                        $color = '#00FFFF';
                        break;
                    case "Recreation":
                        $color = '#FFB6C1';
                        break;
                    case "Hunting - Jimmy McBee":
                        $color = '#FF7F50';
                        break;
                    case "Meeting":
                        $color = '#FFA500';
                        break;
                    case "Hunting - Phillip Winter":
                        $color = '#33CCFF';
                        break;
                    case "Lunch":
                        $color = '#32CD32';
                        break;
                    case "Cocktails":
                        $color = '#CCFFFF';
                        break;
                    case "Hunting - Joey Salazar":
                        $color = '#00FA99';
                        break;
                    case "Box Lunch":
                        $color = '#0000FF';
                        break;
                    case "Appetizers":
                        $color = '#00FA9A';
                        break;
                    case "Dessert":
                        $color = '#F0E68C';
                        break;
                    case "Skeet Shooting":
                        $color = '#FF8C00';
                        break;
                    case "Dinner":
                        $color = '#FFFF00';
                        break;
                    case "Hunting - Weston Koehler":
                        $color = '#9370DB';
                        break;
                    case "Buisness":
                        $color = '#B0E0E6';
                        break;
                    case "Hunting - Hayden Johnson":
                        $color = '#F0FFFF';
                        break;
                    case "Brunch":
                        $color = '#48D1CC';
                        break;
                    default:
                        $color = '#48D1CC';
                }
                if ($event_type == "Breakfast" || $event_type == "Lunch" || $event_type == "Dinner") {
                    if ($event_type == 'Breakfast') {
                        $item_data = DB::Select("Select sum(count_item) as itemcount from(Select distinct vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty as count_item from dev.vr_cat_sales vcs inner join
                                dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                                TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$start_datetime' and vce.cat_event_type='$event_type' and vci.item_type='Meal' and vci.item_id between 2000 and 2003)");
                    }
                    if ($event_type == 'Lunch') {
                        $item_data = DB::Select("Select sum(count_item) as itemcount from(Select distinct vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty as count_item from dev.vr_cat_sales vcs inner join
                                dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                                TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$start_datetime' and vce.cat_event_type='$event_type' and vci.item_type='Meal' and vci.item_id between 6000 and 6035)");
                    }
                    if ($event_type == 'Dinner') {
                        $item_data = DB::Select("Select sum(count_item) as itemcount from(Select distinct vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty as count_item from dev.vr_cat_sales vcs inner join
                                dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                                TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$start_datetime' and vce.cat_event_type='$event_type' and vci.item_type='Meal' and vci.item_id between 4033 and 4040)");
                    }
                } else {
                    $item_data = DB::Select("Select sum(count_item) as itemcount from(Select distinct vcs.item_id,vci.item_name,vcs.item_desc,vcs.qty as count_item from dev.vr_cat_sales vcs inner join
                                dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                                TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$start_datetime' and vce.cat_event_type='$event_type' and vci.item_type='Meal')");
                }



                $item_data_ar = json_decode(json_encode($item_data), true);
                $itemc = $item_data_ar[0]['itemcount'];
                if (empty($itemc)) {
                    $itemc = 0;
                }
                if (empty($event_type)) {
                    $event_type = "Other";
                }
                $events[] = Calendar::event(
                    "$event_type:$item_count [Total:$itemc]",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($start_datetime . '-1 day'),
                    null,
                    // Add color
                    [
                        'color' => "$color",
                        'textColor' => '#0e0f0e',
                        'url' => "/ondatemenusfromcalendar/" . base64_encode($start_datetime) . "/" . base64_encode($event_type)
                    ]
                );
                $i++;
            }
            $calendar = Calendar::addEvents($events);
            return view('GuideReservationHunting/WeeklyHunting', compact('calendar', 'todayDate', 'fromdate', 'todate'));
            // return $calendar;
        } else {
            return view('auth.login');
        }
    }
    public function HuntingCalendarOnButtonClick(Request $request)
    {
        $todayDate = date('m-d-Y');
        $fromdate = $request['fromdate'];
        $todate = $request['todate'];
        $value = session()->get('id');
        if ($value != "") {
            $data = DB::Select("select sum(eventcount) as event_count,start_datetime,cat_event_type from(Select COUNT(distinct vce.event_id) As eventcount,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,vce.cat_event_type as cat_event_type from DEV.VR_CAT_EVENT vce inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id
                            where vci.item_type='Guide' and vce.cat_event_type LIKE '%Hunting%' and
                            TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') between '$fromdate' and '$todate' GROUP BY vce.cat_event_type,TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY'),vce.event_id,vce.cat_event_type) Group by start_datetime,cat_event_type");
            $data_ar = json_decode(json_encode($data), true);
            $i = 0;
            $events = [];
            $color = '';
            $type_data = "";
            // return $data_ar;
            foreach ($data_ar as $id => $eventcount) {
                $item_count = $data_ar[$i]['event_count'];
                $start_datetime = $data_ar[$i]['start_datetime'];
                $date_var = $start_datetime;
                $event_type = $data_ar[$i]['cat_event_type'];
                $type_data = "AllEVENTS";
                switch ($event_type) {
                    case "Hunting":
                        $color = '#FF0000';
                        break;
                    default:
                        $color = '#48D1CC';
                }

                if (empty($event_type)) {
                    $event_type = "Other";
                }
                $events[] = Calendar::event(
                    "Total Event:$item_count",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($start_datetime . '-1 day'),
                    null,
                    // Add color
                    [
                        'color' => "#00BFFF",
                        'textColor' => '#0e0f0e',
                        'url' => "/oncalenderhuntingeventsinfo/" . base64_encode($start_datetime) . "/" . base64_encode($type_data),
                    ]
                );
                $assigned_data = DB::Select("Select Count(cm) as event_count from (Select COUNT(distinct vce.event_id) as cm from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'DD-MM-YYYY')='$date_var' and vce.cat_event_type LIKE '%Hunting%' and vci.item_name NOT LIKE '%(Unassigned)%' and vci.item_type='Guide' group by vce.event_id)");
                $assigned_data_ar = json_decode(json_encode($assigned_data), true);
                if (empty($assigned_data_ar)) {
                    $count = 0;
                } else {
                    //$explodValue=(explode(" ",$assigned_data));
                    $count = $assigned_data_ar[0]['event_count'];
                }

                $type_data = "ASSIGNEDEVENTS";
                $events[] = Calendar::event(
                    "Assigned Event:$count",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($start_datetime . '-1 day'),
                    null,
                    // Add color
                    [
                        'color' => "#00FF00",
                        'textColor' => '#0e0f0e',
                        'url' => "/oncalenderhuntingeventsinfo/" . base64_encode($start_datetime) . "/" . base64_encode($type_data),
                    ]
                );
                $unasignedcount = $item_count - $count;
                $type_data = "UNASSIGNEDEVENTS";
                $events[] = Calendar::event(
                    "Unassigned Event:$unasignedcount",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($start_datetime . '-1 day'),
                    null,
                    // Add color
                    [
                        'color' => "#FFFF00",
                        'textColor' => '#0e0f0e',
                        'url' => "/oncalenderhuntingeventsinfo/" . base64_encode($start_datetime) . "/" . base64_encode($type_data),
                    ]
                );
                $i++;
            }
            $calendar = Calendar::addEvents($events);
            return view('WeeklyMenu/weeklymenu', compact('calendar', 'todayDate', 'fromdate', 'todate'));
        } else {
            return view('auth.login');
        }
    }

    // change on 15-05-2023
    public function HuntingCalendarOnButtonClickRevised(Request $request)
    {

        $todayDate = date('m-d-Y');
        $fromdate = base64_decode($request['fromdate']);
        $todate = base64_decode($request['todate']);

        $tempTdayDate = explode("-", $fromdate);
        $fromdate = $tempTdayDate[2] . "-" . $tempTdayDate[0] . "-" . $tempTdayDate[1];

        $tempTdayDate = explode("-", $todate);
        $todate = $tempTdayDate[2] . "-" . $tempTdayDate[0] . "-" . $tempTdayDate[1];

        // dd($fromdate." ".$todate);

        $value = session()->get('id');
        if ($value != "") {
            $guide_id = base64_decode($request['guide_id']);
            // $market_code = base64_decode($request['hunt_type']);
            $market_code = 'All';
            // dd($request['hunt_type']);
            if ($guide_id == 'All' && $market_code == "All") {
                $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                from (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                from DEV.VR_CAT_EVENT vce
                                inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                                inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                                where vce.cat_event_type LIKE '%Hunting%' and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate') rs
                left join dev.vr_cat_items vci on rs.item_id=vci.item_id");
            } else if ($guide_id != 'All' && $market_code == "All") {
                $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                from (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                from DEV.VR_CAT_EVENT vce
                                inner join dev.vr_cat_sales vcs on vce.event-id=vcs.folio_id
                                inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                                where vce.cat_event_type LIKE '%Hunting%' and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate') rs
                left join dev.vr_cat_items vci on rs.item_id=vci.item_id
                where vci.item_name like '%$guide_id%'");
            } else if ($guide_id == "All" && $market_code != "All") {
                $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                from
                    (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                from (select vcev.*
                              from dev.vr_cat_event vcev
                              inner join dev.vr_cat_sales vcsa on vcev.group_folio_id=vcsa.folio_id
                              where vcsa.market_code='$market_code') vce
                        inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                        inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                        where vce.cat_event_type LIKE '%Hunting%'
                        and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate')rs
                left join dev.vr_cat_items vci on rs.item_id=vci.item_id");
            } else {
                $data = DB::select("select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
                from
                    (Select TO_CHAR(vce.START_DATETIME,'DD-MM-YYYY') As start_datetime,TO_CHAR(vce.END_DATETIME,'DD-MM-YYYY') As end_datetime,vce.event_id,vce.cat_event_type as cat_event_type,
                                REPLACE(vce.company_party_name,'COMMERCIAL','') as company_party_name ,vcs.cat_sales_stage,vcs.market_code, vc.name as customer,vcs.item_id
                                from (select vcev.*
                              from dev.vr_cat_event vcev
                              inner join dev.vr_cat_sales vcsa on vcev.group_folio_id=vcsa.folio_id
                              where vcsa.market_code='$market_code') vce
                        inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
                        inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
                        where vce.cat_event_type LIKE '%Hunting%'
                        and TO_CHAR(vce.START_DATETIME,'YYYY-MM-DD') between '$fromdate' and '$todate')rs
                left join dev.vr_cat_items vci on rs.item_id=vci.item_id
                where vci.item_name like '%$guide_id%'");
            }
            // $data = DB::select();
            $data_ar = json_decode(json_encode($data), true);
            $i = 0;
            $events = [];
            $color = '';
            $type_data = "";
            // return $data_ar;
            foreach ($data_ar as $id => $eventcount) {
                $start_datetime = $data_ar[$i]['start_datetime'];
                $end_datetime = $data_ar[$i]['end_datetime'];
                $date_var = $start_datetime;
                $company_party_name = $data_ar[$i]['company_party_name'];
                $customer = $data_ar[$i]['customer'];
                $cat_sales_stage = $data_ar[$i]['cat_sales_stage'];

                if ($data_ar[$i]['guide_name'] == NULL) {
                    $guide = "NA";
                } else {
                    $guide = $data_ar[$i]['guide_name'];
                }
                $event_id = $data_ar[$i]['event_id'];

                $events[] = Calendar::event(
                    "$company_party_name|$customer|$cat_sales_stage|$guide",

                    true,
                    new \DateTime($start_datetime),
                    new \DateTime($end_datetime . '1 day'),
                    null,
                    // Add color
                    [
                        'color' => "#20a8d8",
                        'textColor' => 'white',
                        'url' => "/oncalenderhuntingeventsinforevised/" . base64_encode($start_datetime) . "/" . base64_encode($event_id) . "/" . base64_encode($guide),
                    ]
                );

                $i++;
            }
            $todayDate = date('m-d-Y');
            $tempTdayDate = explode("-", $fromdate);
            $fromdate = $tempTdayDate[1] . "-" . $tempTdayDate[2] . "-" . $tempTdayDate[0];

            $tempTdayDate = explode("-", $todate);
            $todate = $tempTdayDate[1] . "-" . $tempTdayDate[2] . "-" . $tempTdayDate[0];
            // $calendar = Calendar::addEvents($events);

            $calendar = Calendar::addEvents($events)->setOptions(['firstDay' => 0])->setCallbacks([
                'eventRender' => 'function(event,jqEvent,view){jqEvent.tooltip({placement: "top",title: event.title});}'
            ]);

            $listOfAllTheGuides = DB::Select("SELECT distinct item_name,ROWNUM AS item_id
            FROM
            (select distinct REGEXP_REPLACE(item_name,' -.*$','') as item_name
            FROM DEV.vr_cat_items
            where item_type = 'Guide' and item_name NOT LIKE '%(Unassigned)%'
            )
            Order By item_name");
            $listOfAllTheGuides_ar = json_decode(json_encode($listOfAllTheGuides), true);
            $countq = count($listOfAllTheGuides_ar);

            $listOfAllTheGuides_ar[0] = array();
            $listOfAllTheGuides_ar[0]['item_id'] = '0';
            $listOfAllTheGuides_ar[0]['item_name'] = 'All';

            // $listOfAllTheHuntType = DB::Select("Select distinct VIP_LEVEL from DEV.vr_customers");
            // $listOfAllTheHuntType_ar = json_decode(json_encode($listOfAllTheHuntType), true);
            // $countqh = count($listOfAllTheHuntType_ar);

            // $listOfAllTheHuntType_ar[0] = array();
            // $listOfAllTheHuntType_ar[0]['vip_level'] = 'All';
            $market_code = 'All';

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "kingranchum";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * from marketcodesetup";
            $market_code_list = $conn->query($sql);
            $market_code_list_ar[] = "";
            if ($market_code_list->num_rows > 0) {
                $i = 0;
                while ($row = $market_code_list->fetch_assoc()) {
                    $market_code_list_ar[$i] = $row;
                    $i = $i + 1;
                }
            }
            $conn->close();
            // $listOfAllTheHuntType_ar = json_decode(json_encode($listOfAllTheHuntType), true);
            $countqh = count($market_code_list_ar);

            $market_code_list_ar[$countqh] = array();
            $market_code_list_ar[$countqh]['id'] = $countqh + 1;
            $market_code_list_ar[$countqh]['market_code'] = 'All';


            // return view('WeeklyMenu/weeklymenurevised', compact('calendar', 'todayDate', 'fromdate', 'todate', 'hunt_type', 'listOfAllTheHuntType_ar', 'listOfAllTheGuides_ar', 'guide_id'));
            return view('WeeklyMenu/weeklymenurevised', compact('calendar', 'todayDate', 'fromdate', 'todate', 'market_code', 'market_code_list_ar', 'listOfAllTheGuides_ar', 'guide_id'));
        } else {
            return view('auth.login');
        }
    }

    public function StaffBookingRevised()
    {
        $todayDate = date('Y-m-d');
        $fromdate = $todayDate;
        $todate = $todayDate;
        $tempTdayDate = explode("-", $todayDate);
        $fromdate = $tempTdayDate[0] . "-" . "01" . "-" . "01";
        $todate = $tempTdayDate[0] . "-" . "12" . "-" . "31";
        $value = session()->get('id');
        if ($value != "") {
            $todayDate = date('m-d-Y');
            $tempTdayDate = explode("-", $fromdate);
            $fromdate = $tempTdayDate[1] . "-" . $tempTdayDate[2] . "-" . $tempTdayDate[0];

            $tempTdayDate = explode("-", $todate);
            $todate = $tempTdayDate[1] . "-" . $tempTdayDate[2] . "-" . $tempTdayDate[0];
            $year = Date('Y');
            return view('staffbookingRevised', compact('todayDate', 'fromdate', 'todate', 'year'));
        }
    }


    public function getData(Request $request)
    {

        $draw                 =         $request->get('draw'); // Internal use
        $start                 =         $request->get("start"); // where to start next records for pagination
        $rowPerPage         =         $request->get("length"); // How many recods needed per page for pagination

        $orderArray        =         $request->get('order');
        $columnNameArray     =         $request->get('columns'); // It will give us columns array

        $searchArray         =         $request->get('search');
        $columnIndex         =         $orderArray[0]['column'];  // This will let us know,
        // which column index should be sorted
        // 0 = id, 1 = name, 2 = email , 3 = created_at

        $columnName         =         $columnNameArray[$columnIndex]['data']; // Here we will get column name,
        // Base on the index we get

        $columnSortOrder     =         $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue         =         $searchArray['value']; // This is search value


        // $fromdate = date('Y-m-d', strtotime('2023-01-01'));
        // $todate = date('Y-m-d', strtotime('2023-12-31'));
        $fromdate = $request->input('param1');
        $todate = $request->input('param2');
        $tempTdayDate = explode("-", $fromdate);
        $fromdate = $tempTdayDate[2] . "-" . $tempTdayDate[0] . "-" . $tempTdayDate[1];
        $tempTdayDate = explode("-", $todate);
        $todate = $tempTdayDate[2] . "-" . $tempTdayDate[0] . "-" . $tempTdayDate[1];
        $events =  DB::table('dev.vr_cat_event as vce')
            ->select(
                'vce.*',
                DB::raw("TO_CHAR(vce.start_datetime, 'HH:MI AM') AS Event_Time_Start"),
                DB::raw("TO_CHAR(vce.end_datetime, 'HH:MI AM') AS Event_Time_End"),
                'vcs.folio_id',
                'vcs.folio_subtotal',
                'vcs.folio_surcharges',
                'vcs.folio_total',
                'vcs.folio_payments',
                'vcs.folio_balance',
                'vcs.folio_settled',
                'vcs.folio_open_date',
                'vcs.folio_close_date',
                'vcs.folio_operating_day',
                'vcs.folio_staff_id',
                'vcs.folio_customer_id',
                'vcs.folio_location',
                'vcs.folio_item_id',
                'vcs.item_id',
                'vcs.item_name',
                'vcs.price',
                'vcs.qty',
                'vcs.discount',
                'vcs.disc_type',
                'vcs.ext_price',
                'vcs.price_with_surcharges',
                'vcs.item_charge_code',
                'vcs.item_staff_id',
                'vcs.item_txn_date',
                'vcs.item_customer_id',
                'vcs.cost_at_purchase',
                'vcs.deferred',
                'vcs.folio_item_detail_id',
                'vcs.detail_charge_code',
                'vcs.has_value',
                'vcs.charge_code_amount',
                'vcs.est_arrival_date'
            )
            ->join('dev.vr_cat_sales as vcs', 'vce.event_id', '=', 'vcs.folio_id')
            ->join('dev.vr_customers as vc', 'vc.customer_id', '=', 'vcs.folio_customer_id')
            ->whereRaw("TO_CHAR(vce.START_DATETIME, 'YYYY-MM-DD') BETWEEN ? AND ?", [$fromdate, $todate]);

        $total = $events->count();

        $totalFilter =  DB::table('dev.vr_cat_event as vce')
            ->select(
                'vce.*',
                DB::raw("TO_CHAR(vce.start_datetime, 'HH:MI AM') AS Event_Time_Start"),
                DB::raw("TO_CHAR(vce.end_datetime, 'HH:MI AM') AS Event_Time_End"),
                'vcs.folio_id',
                'vcs.folio_subtotal',
                'vcs.folio_surcharges',
                'vcs.folio_total',
                'vcs.folio_payments',
                'vcs.folio_balance',
                'vcs.folio_settled',
                'vcs.folio_open_date',
                'vcs.folio_close_date',
                'vcs.folio_operating_day',
                'vcs.folio_staff_id',
                'vcs.folio_customer_id',
                'vcs.folio_location',
                'vcs.folio_item_id',
                'vcs.item_id',
                'vcs.item_name',
                'vcs.price',
                'vcs.qty',
                'vcs.discount',
                'vcs.disc_type',
                'vcs.ext_price',
                'vcs.price_with_surcharges',
                'vcs.item_charge_code',
                'vcs.item_staff_id',
                'vcs.item_txn_date',
                'vcs.item_customer_id',
                'vcs.cost_at_purchase',
                'vcs.deferred',
                'vcs.folio_item_detail_id',
                'vcs.detail_charge_code',
                'vcs.has_value',
                'vcs.charge_code_amount',
                'vcs.est_arrival_date'
            )
            ->join('dev.vr_cat_sales as vcs', 'vce.event_id', '=', 'vcs.folio_id')
            ->join('dev.vr_customers as vc', 'vc.customer_id', '=', 'vcs.folio_customer_id')
            ->whereRaw("TO_CHAR(vce.START_DATETIME, 'YYYY-MM-DD') BETWEEN ? AND ?", [$fromdate, $todate]);

        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('vce.event_id', 'like', '%' . $searchValue . '%');
            $totalFilter = $totalFilter->orWhere('vce.group_folio_id', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData =  DB::table('dev.vr_cat_event as vce')
            ->select(
                'vce.*',
                DB::raw("TO_CHAR(vce.start_datetime, 'HH:MI AM') AS Event_Time_Start"),
                DB::raw("TO_CHAR(vce.end_datetime, 'HH:MI AM') AS Event_Time_End"),
                'vcs.folio_id',
                'vcs.folio_subtotal',
                'vcs.folio_surcharges',
                'vcs.folio_total',
                'vcs.folio_payments',
                'vcs.folio_balance',
                'vcs.folio_settled',
                'vcs.folio_open_date',
                'vcs.folio_close_date',
                'vcs.folio_operating_day',
                'vcs.folio_staff_id',
                'vcs.folio_customer_id',
                'vcs.folio_location',
                'vcs.folio_item_id',
                'vcs.item_id',
                'vcs.item_name',
                'vcs.price',
                'vcs.qty',
                'vcs.discount',
                'vcs.disc_type',
                'vcs.ext_price',
                'vcs.price_with_surcharges',
                'vcs.item_charge_code',
                'vcs.item_staff_id',
                'vcs.item_txn_date',
                'vcs.item_customer_id',
                'vcs.cost_at_purchase',
                'vcs.deferred',
                'vcs.folio_item_detail_id',
                'vcs.detail_charge_code',
                'vcs.has_value',
                'vcs.charge_code_amount',
                'vcs.est_arrival_date'
            )
            ->join('dev.vr_cat_sales as vcs', 'vce.event_id', '=', 'vcs.folio_id')
            ->join('dev.vr_customers as vc', 'vc.customer_id', '=', 'vcs.folio_customer_id')
            ->whereRaw("TO_CHAR(vce.START_DATETIME, 'YYYY-MM-DD') BETWEEN ? AND ?", [$fromdate, $todate]);

        $arrData = $arrData->skip($start)->take($rowPerPage);
        // $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('vce.event_id', 'like', '%' . $searchValue . '%');
            $arrData = $arrData->orWhere('vce.group_folio_id', 'like', '%' . $searchValue . '%');
        }

        $arrData = $arrData->get();

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

    public function PMSStaffBookingRevised()
    {
        // dd("Inside PMS");
        $todayDate = date('Y-m-d');
        $fromdate = $todayDate;
        $todate = $todayDate;
        $tempTdayDate = explode("-", $todayDate);
        $fromdate = $tempTdayDate[0] . "-" . "01" . "-" . "01";
        $todate = $tempTdayDate[0] . "-" . "12" . "-" . "31";

        $value = session()->get('id');
        if ($value != "") {
            $todayDate = date('m-d-Y');
            $tempTdayDate = explode("-", $fromdate);
            $fromdate = $tempTdayDate[1] . "-" . $tempTdayDate[2] . "-" . $tempTdayDate[0];

            $tempTdayDate = explode("-", $todate);
            $todate = $tempTdayDate[1] . "-" . $tempTdayDate[2] . "-" . $tempTdayDate[0];
            $year = Date('Y');
            return view('pmsstaffbooking', compact('todayDate', 'fromdate', 'todate', 'year'));
        }
    }


    public function getDataPMS(Request $request)
    {
        $draw                 =         $request->get('draw'); // Internal use
        $start                 =         $request->get("start"); // where to start next records for pagination
        $rowPerPage         =         $request->get("length"); // How many recods needed per page for pagination

        $orderArray        =         $request->get('order');
        $columnNameArray     =         $request->get('columns'); // It will give us columns array

        $searchArray         =         $request->get('search');
        $columnIndex         =         $orderArray[0]['column'];  // This will let us know,
        // which column index should be sorted
        // 0 = id, 1 = name, 2 = email , 3 = created_at

        $columnName         =         $columnNameArray[$columnIndex]['data']; // Here we will get column name,
        // Base on the index we get

        $columnSortOrder     =         $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue         =         $searchArray['value']; // This is search value


        // $fromdate = date('Y-m-d', strtotime('2023-01-01'));
        // $todate = date('Y-m-d', strtotime('2023-12-31'));
        $fromdate = $request->input('param1');
        $todate = $request->input('param2');
        $tempTdayDate = explode("-", $fromdate);
        $fromdate = $tempTdayDate[2] . "-" . $tempTdayDate[0] . "-" . $tempTdayDate[1];
        $tempTdayDate = explode("-", $todate);
        $todate = $tempTdayDate[2] . "-" . $tempTdayDate[0] . "-" . $tempTdayDate[1];
        $events = DB::table('dev.vr_customers as vc')
            ->select(
                'vc.customer_id',
                'vps.folio_customer_id',
                'vc.name',
                DB::raw("TO_CHAR(vps.checkin_date,'YYYY-MM-DD') AS checkin_date"),
                DB::raw("TO_CHAR(vps.checkout_date,'YYYY-MM-DD') AS checkout_date"),
                DB::raw("TO_CHAR(vps.arrival_date,'YYYY-MM-DD') AS arrival_date"),
                DB::raw("TO_CHAR(vps.departure_date,'YYYY-MM-DD') AS departure_date"),
                'vps.num_nights',
                'vps.room_number',
                'vps.room_type',
                'vps.folio_id',
                'vps.folio_status',
                'vps.folio_settled',
                'vps.folio_staff_id',
                'vps.account_name',
                'vps.billing'
            )
            ->join('dev.VR_PMS_SALES as vps', 'vc.Customer_id', '=', 'vps.folio_customer_id')
            ->where('vps.num_nights', '>', 0)
            ->where(function ($query) use ($fromdate, $todate) {
                $query->whereBetween(DB::raw("TO_CHAR(vps.arrival_date, 'YYYY-MM-DD')"), [$fromdate, $todate])
                    ->orWhereBetween(DB::raw("TO_CHAR(vps.departure_date, 'YYYY-MM-DD')"), [$fromdate, $todate]);
            })
            ->orderBy('vc.customer_id');


        $total = $events->count();

        $totalFilter =  DB::table('dev.vr_customers as vc')
            ->select(
                'vc.customer_id',
                'vps.folio_customer_id',
                'vc.name',
                DB::raw("TO_CHAR(vps.checkin_date,'YYYY-MM-DD') AS checkin_date"),
                DB::raw("TO_CHAR(vps.checkout_date,'YYYY-MM-DD') AS checkout_date"),
                DB::raw("TO_CHAR(vps.arrival_date,'YYYY-MM-DD') AS arrival_date"),
                DB::raw("TO_CHAR(vps.departure_date,'YYYY-MM-DD') AS departure_date"),
                'vps.num_nights',
                'vps.room_number',
                'vps.room_type',
                'vps.folio_id',
                'vps.folio_status',
                'vps.folio_settled',
                'vps.folio_staff_id',
                'vps.account_name',
                'vps.billing'
            )
            ->join('dev.VR_PMS_SALES as vps', 'vc.Customer_id', '=', 'vps.folio_customer_id')
            ->where('vps.num_nights', '>', 0)
            ->where(function ($query) use ($fromdate, $todate) {
                $query->whereBetween(DB::raw("TO_CHAR(vps.arrival_date, 'YYYY-MM-DD')"), [$fromdate, $todate])
                    ->orWhereBetween(DB::raw("TO_CHAR(vps.departure_date, 'YYYY-MM-DD')"), [$fromdate, $todate]);
            })
            ->orderBy('vc.customer_id');

        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('vc.customer_id', 'like', '%' . $searchValue . '%');
            $totalFilter = $totalFilter->orWhere('vps.folio_customer_id', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();

        $arrData =  DB::table('dev.vr_customers as vc')
            ->select(
                'vc.customer_id',
                'vps.folio_customer_id',
                'vc.name',
                DB::raw("TO_CHAR(vps.checkin_date,'YYYY-MM-DD') AS checkin_date"),
                DB::raw("TO_CHAR(vps.checkout_date,'YYYY-MM-DD') AS checkout_date"),
                DB::raw("TO_CHAR(vps.arrival_date,'YYYY-MM-DD') AS arrival_date"),
                DB::raw("TO_CHAR(vps.departure_date,'YYYY-MM-DD') AS departure_date"),
                'vps.num_nights',
                'vps.room_number',
                'vps.room_type',
                'vps.folio_id',
                'vps.folio_status',
                'vps.folio_settled',
                'vps.folio_staff_id',
                'vps.account_name',
                'vps.billing'
            )
            ->join('dev.VR_PMS_SALES as vps', 'vc.Customer_id', '=', 'vps.folio_customer_id')
            ->where('vps.num_nights', '>', 0)
            ->where(function ($query) use ($fromdate, $todate) {
                $query->whereBetween(DB::raw("TO_CHAR(vps.arrival_date, 'YYYY-MM-DD')"), [$fromdate, $todate])
                    ->orWhereBetween(DB::raw("TO_CHAR(vps.departure_date, 'YYYY-MM-DD')"), [$fromdate, $todate]);
            })
            ->orderBy('vc.customer_id');

        $arrData = $arrData->skip($start)->take($rowPerPage);
        // $arrData = $arrData->orderBy($columnName, $columnSortOrder);
        if (!empty($searchValue)) {
            $arrData = $arrData->where('vc.customer_id', 'like', '%' . $searchValue . '%');
            $arrData = $arrData->orWhere('vps.folio_customer_id', 'like', '%' . $searchValue . '%');
        }
        // dd($arrData);
        $arrData = $arrData->get();

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );


        return response()->json($response);
    }
}
