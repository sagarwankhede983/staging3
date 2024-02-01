<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use MYSQLI;
use Session;
use Illuminate\Http\Request;


class HuntingReservationController extends Controller
{
    // Reserve/Unreserve Guide for hunting on day
    public function TodayHuntingGuideResevationDetail()
    {
        $value = session()->get('id');
        if ($value != "") {
            $todayDate = date('m-d-Y');

            $todayHuntingEventInfo = DB::Select(" Select vce.event_id,vce.cat_event_type,vcs.item_name,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name,vce.room from
            dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
            To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' ");
            $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo), true);
            $totalAsignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
            inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
            vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuideInfo_ar = json_decode(json_encode($totalAsignedGuideInfo), true);

            $assignedGuideInfo = DB::Select("Select distinct vci.item_id from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                  inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $assignedGuideInfo_ar = json_decode(json_encode($assignedGuideInfo), true);
            $i = 0;
            $araay = [];
            foreach ($assignedGuideInfo_ar as $data) {
                $araay[$i] = $assignedGuideInfo_ar[$i]['item_id'];
                $i++;
            }
            $itemsinquery = implode(",", $araay);
            if ($itemsinquery != "") {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%' and item_id not in ($itemsinquery)");
            } else {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            }

            //$guideInitemtable_ar=json_decode(json_encode($guideInitemtable),true);
            $totalUnasignedGuideInfo_ar = json_decode(json_encode($guideInitemtable), true);

            return view('GuideReservationHunting.TodayHuntingReservation', compact('todayHuntingEventInfo_ar', 'totalAsignedGuideInfo_ar', 'totalUnasignedGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Reserve/Unreserve Guide for hunting on date
    public function OnDateHuntingGuideResevationDetail()
    {
        $value = session()->get('id');
        if ($value != "") {
            $todayDate = date('m-d-Y');
            $date = $todayDate;

            $todayHuntingEventInfo = DB::Select(" Select vce.event_id,vce.cat_event_type,vcs.item_name,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name,vce.room from
            dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where
            To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%'");
            $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo), true);

            $totalAsignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
            inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
            vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuideInfo_ar = json_decode(json_encode($totalAsignedGuideInfo), true);

            $assignedGuideInfo = DB::Select("Select distinct vci.item_id from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                  inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $assignedGuideInfo_ar = json_decode(json_encode($assignedGuideInfo), true);
            $i = 0;
            $araay = [];
            foreach ($assignedGuideInfo_ar as $data) {
                $araay[$i] = $assignedGuideInfo_ar[$i]['item_id'];
                $i++;
            }
            $itemsinquery = implode(",", $araay);
            if ($itemsinquery != "") {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%' and item_id not in ($itemsinquery)");
            } else {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            }

            // $guideInitemtable_ar=json_decode(json_encode($guideInitemtable),true);
            $totalUnasignedGuideInfo_ar = json_decode(json_encode($guideInitemtable), true);

            return view('GuideReservationHunting.OnDateHuntingReservation', compact('date', 'todayHuntingEventNum_ar', 'todayGuidedEventNum_ar', 'totalNumGuide_ar', 'totalAsignedGuide_ar', 'todayHuntingEventInfo_ar', 'totalAsignedGuideInfo_ar', 'totalUnasignedGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Reserve/Unreserve Guide for hunting on date
    public function OnDateFromCalendarHuntingGuideResevationDetail(Request $request)
    {

        $value = session()->get('id');
        if ($value != "") {
            $todayDate = $request['filterdate'];
            $date = $todayDate;

            $todayHuntingEventInfo = DB::Select("Select vce.event_id,vce.cat_event_type,vcs.item_name,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name,vce.room from
             dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
             To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' ");
            $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo), true);

            $totalAsignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
             inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
             vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuideInfo_ar = json_decode(json_encode($totalAsignedGuideInfo), true);

            $assignedGuideInfo = DB::Select("Select distinct vci.item_id from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                  inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $assignedGuideInfo_ar = json_decode(json_encode($assignedGuideInfo), true);
            $i = 0;
            $araay = [];
            foreach ($assignedGuideInfo_ar as $data) {
                $araay[$i] = $assignedGuideInfo_ar[$i]['item_id'];
                $i++;
            }
            $itemsinquery = implode(",", $araay);
            if ($itemsinquery != "") {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%' and item_id not in ($itemsinquery)");
            } else {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            }

            // $guideInitemtable_ar=json_decode(json_encode($guideInitemtable),true);
            $totalUnasignedGuideInfo_ar = json_decode(json_encode($guideInitemtable), true);

            return view('GuideReservationHunting.OnDateHuntingReservation', compact('date', 'todayHuntingEventNum_ar', 'todayGuidedEventNum_ar', 'totalNumGuide_ar', 'totalAsignedGuide_ar', 'todayHuntingEventInfo_ar', 'totalAsignedGuideInfo_ar', 'totalUnasignedGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Guide Shecdule
    public function GuideWiseResevationInfo()
    {
        $todayDate = date('m-d-Y');
        $value = session()->get('id');
        if ($value != "") {
            $guide_id = 50001;
            $listOfAllTheGuides = DB::Select(" Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            $listOfAllTheGuides_ar = json_decode(json_encode($listOfAllTheGuides), true);

            $guideshedule = DB::Select(" Select distinct vci.item_id,vci.item_name,vce.event_id,vce.cat_event_type,
          TO_CHAR(vce.start_datetime,'MM-DD_YYYY') as start_datetime,vc.name,vce.room from
            dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where
            vci.item_id='$guide_id' and vce.cat_event_type LIKE '%Hunting%' ");
            $guideshedule_ar = json_decode(json_encode($guideshedule), true);

            return view('GuideReservationHunting.GuideShedule', compact('listOfAllTheGuides_ar', 'guideshedule_ar', 'guide_id', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Guide Shecdule
    public function getGuideShedule(Request $request)
    {
        $todayDate = date('d-m-Y');
        $value = session()->get('id');
        if ($value != "") {
            $guide_id = base64_decode($request['guide_id']);
            $listOfAllTheGuides = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            $listOfAllTheGuides_ar = json_decode(json_encode($listOfAllTheGuides), true);

            $guideshedule = DB::Select("Select distinct vci.item_id,vci.item_name,vce.event_id,vce.cat_event_type,vce.room,vc.name,
        TO_CHAR(vce.start_datetime,'MM-DD-YYYY') as start_datetime from
          dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where
          vci.item_id='$guide_id' and vce.cat_event_type LIKE '%Hunting%' order by start_datetime");
            $guideshedule_ar = json_decode(json_encode($guideshedule), true);

            return view('GuideReservationHunting.GuideShedule', compact('listOfAllTheGuides_ar', 'guideshedule_ar', 'guide_id', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    //OndateDashChange
    public function onDateHuntingDash(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $todayDate = $request['filterdate'];

            $todayHuntingEventNum = DB::Select(" Select count(ec) as count from (Select COUNT(distinct vce.event_id) as ec,vce.event_id,vce.cat_event_type from
                  dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join
                  dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                  To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' group by
                  vce.event_id,vce.cat_event_type)");
            $todayHuntingEventNum_ar = json_decode(json_encode($todayHuntingEventNum), true);

            $todayGuidedEventNum = DB::Select("Select Count(cm) as count from (Select COUNT(distinct vce.event_id) as cm from
                    dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci
                    on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and
                    vce.cat_event_type LIKE '%Hunting%' and vci.item_name NOT LIKE '%(Unassigned)%' and vci.item_type='Guide'
                    group by vce.event_id)");
            $todayGuidedEventNum_ar = json_decode(json_encode($todayGuidedEventNum), true);

            $totalNumGuide = DB::Select("Select Count(distinct item_id) as count from dev.vr_cat_items where
          item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            $totalNumGuide_ar = json_decode(json_encode($totalNumGuide), true);

            $totalAsignedGuide = DB::Select("Select COUNT(DISTINCT vci.item_id) as count from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
          inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
          vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuide_ar = json_decode(json_encode($totalAsignedGuide), true);

            $todayHuntingEventInfo = DB::Select(" Select vce.event_id,vce.cat_event_type,vcs.item_name,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name from
          dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where
          To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' ");
            $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo), true);

            $totalAsignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name,vce.name,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
          inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
          vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuideInfo_ar = json_decode(json_encode($totalAsignedGuideInfo), true);

            $totalUnasignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
          inner join dev.vr_cat_items vci on vcs.item_id!=vci.item_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
          vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalUnasignedGuideInfo_ar = json_decode(json_encode($totalUnasignedGuideInfo), true);


            $todayGuideUnassignedEventNum = DB::Select("Select Count(cm) as count from (Select COUNT(distinct vce.event_id) as cm,vci.item_name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_name LIKE '%(Unassigned)%' and vci.item_type='Guide' group by vce.event_id,vci.item_name)");
            $todayGuideUnassignedEventNum_ar = json_decode(json_encode($todayGuideUnassignedEventNum), true);
            return view('GuideReservationHunting.homeForReservation', compact('todayHuntingEventNum_ar', 'todayGuidedEventNum_ar', 'totalNumGuide_ar', 'totalAsignedGuide_ar', 'todayHuntingEventInfo_ar', 'totalAsignedGuideInfo_ar', 'totalUnasignedGuideInfo_ar', 'todayDate', 'todayGuideUnassignedEventNum_ar'));
        }
    }
    //today reservation on dashboard change
    public function todayRservationOnDashChange(Request $request)
    {
        $todayDate = base64_decode($request['date']);
        $value = session()->get('id');
        if ($value != "") {

            $todayHuntingEventInfo = DB::Select(" Select vce.event_id,vce.cat_event_type,vcs.item_name,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name,vce.room from
            dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
            To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' ");
            $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo), true);

            $totalAsignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.room,vc.name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
            inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
            vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuideInfo_ar = json_decode(json_encode($totalAsignedGuideInfo), true);

            $assignedGuideInfo = DB::Select("Select distinct vci.item_id from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                  inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $assignedGuideInfo_ar = json_decode(json_encode($assignedGuideInfo), true);
            $i = 0;
            $araay = [];
            foreach ($assignedGuideInfo_ar as $data) {
                $araay[$i] = $assignedGuideInfo_ar[$i]['item_id'];
                $i++;
            }
            $itemsinquery = implode(",", $araay);
            if ($itemsinquery != "") {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%' and item_id not in ($itemsinquery)");
            } else {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            }

            // $guideInitemtable_ar=json_decode(json_encode($guideInitemtable),true);
            $totalUnasignedGuideInfo_ar = json_decode(json_encode($guideInitemtable), true);

            return view('GuideReservationHunting.TodayHuntingReservation', compact('todayHuntingEventNum_ar', 'todayGuidedEventNum_ar', 'totalNumGuide_ar', 'totalAsignedGuide_ar', 'todayHuntingEventInfo_ar', 'totalAsignedGuideInfo_ar', 'totalUnasignedGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    //ondate reservation on dashboard change
    public function ondateReservationOnDashChange(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $todayDate = base64_decode($request['date']);
            $date = $todayDate;
            $todayHuntingEventInfo = DB::Select("Select vce.event_id,vce.cat_event_type,vcs.item_name,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name,vce.room from
              dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
              To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' ");
            $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo), true);

            $totalAsignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
              inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$todayDate' and vce.cat_event_type LIKE '%Hunting%' and
              vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuideInfo_ar = json_decode(json_encode($totalAsignedGuideInfo), true);

            $assignedGuideInfo = DB::Select("Select distinct vci.item_id from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                  inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $assignedGuideInfo_ar = json_decode(json_encode($assignedGuideInfo), true);
            $i = 0;
            $araay = [];
            foreach ($assignedGuideInfo_ar as $data) {
                $araay[$i] = $assignedGuideInfo_ar[$i]['item_id'];
                $i++;
            }
            $itemsinquery = implode(",", $araay);
            if ($itemsinquery != "") {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%' and item_id not in ($itemsinquery)");
            } else {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            }

            //$guideInitemtable_ar=json_decode(json_encode($guideInitemtable),true);
            $totalUnasignedGuideInfo_ar = json_decode(json_encode($guideInitemtable), true);

            return view('GuideReservationHunting.OnDateHuntingReservation', compact('date', 'todayHuntingEventNum_ar', 'todayGuidedEventNum_ar', 'totalNumGuide_ar', 'totalAsignedGuide_ar', 'todayHuntingEventInfo_ar', 'totalAsignedGuideInfo_ar', 'totalUnasignedGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Hunting Event Info
    public function HuntingEventsInfo(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $date = base64_decode($request['date']);
            $todayDate = $date;
            $todayHuntingEventInfo = DB::Select("Select vce.event_id,vce.cat_event_type,vcs.item_name,vcs.item_id,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vc.name,vce.room from
              dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
              To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide'");
            $todayHuntingEventInfo_ar = json_decode(json_encode($todayHuntingEventInfo), true);
            return view('GuideReservationHunting.HuntingEventInfo', compact('todayHuntingEventInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Guided Hunting Event Info
    public function GuidedHuntingEventInfo(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $date = base64_decode($request['date']);
            $todayDate = $date;
            $totalAsignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime,vce.event_id,vce.cat_event_type from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                    inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' and vce.cat_event_type LIKE '%Hunting%' and
                    vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalAsignedGuideInfo_ar = json_decode(json_encode($totalAsignedGuideInfo), true);
            return view('GuideReservationHunting.GuideAssignedEventInfo', compact('totalAsignedGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Unguided Hunting Event Info
    public function UnuidedHuntingEventInfo(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $date = base64_decode($request['date']);
            $todayDate = $date;
            $totalUnasignedGuideInfo = DB::Select("Select distinct vce.event_id,vce.cat_event_type,vci.item_id,vci.item_name,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                    inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' and vce.cat_event_type LIKE '%Hunting%' and
                    vci.item_type='Guide' and vci.item_name LIKE '%(Unassigned)%'");
            $totalUnasignedGuideInfo_ar = json_decode(json_encode($totalUnasignedGuideInfo), true);
            return view('GuideReservationHunting.UnguidedEventInfo', compact('totalUnasignedGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Total Guides
    public function getTotalGuidesInDB(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $date = $request['date'];
            $todayDate = $date;
            $totalGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name from dev.vr_cat_items vci where vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $totalGuideInfo_ar = json_decode(json_encode($totalGuideInfo), true);
            return view('GuideReservationHunting.TotalGuideInfo', compact('totalGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Assigned Guides
    public function getAssignedGuideInDB(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $date = base64_decode($request['date']);
            $todayDate = $date;
            $assignedGuideInfo = DB::Select("Select distinct vci.item_id,vci.item_name,vc.name,vce.room,TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY') As start_datetime from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                            inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where
                              TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $assignedGuideInfo_ar = json_decode(json_encode($assignedGuideInfo), true);
            return view('GuideReservationHunting.AssignedGuideInfo', compact('assignedGuideInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    // Unssigned Guides
    public function getUnassignedGuideInDB(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $date = base64_decode($request['date']);
            $todayDate = $date;
            $assignedGuideInfo = DB::Select("Select distinct vci.item_id from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id
                  inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id where
                  TO_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date' and vce.cat_event_type LIKE '%Hunting%' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
            $assignedGuideInfo_ar = json_decode(json_encode($assignedGuideInfo), true);
            $i = 0;
            $araay = [];
            foreach ($assignedGuideInfo_ar as $data) {
                $araay[$i] = $assignedGuideInfo_ar[$i]['item_id'];
                $i++;
            }
            $itemsinquery = implode(",", $araay);
            if ($itemsinquery != "") {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%' and item_id not in ($itemsinquery)");
            } else {
                $guideInitemtable = DB::Select("Select distinct item_id,item_name from dev.vr_cat_items where item_type='Guide' and item_name NOT LIKE '%(Unassigned)%'");
            }

            $guideInitemtable_ar = json_decode(json_encode($guideInitemtable), true);
            return view('GuideReservationHunting.UnassignedGuide', compact('guideInitemtable_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
    public function FromHuntingCalender(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $date = base64_decode($request['date']);
            $todayDate = $date;
            $type = base64_decode($request['type']);
            if ($type == "AllEVENTS") {
                $heading = "Event";
                $HuntingEventInfo = DB::Select(" Select vce.event_id,vc.name,vce.room,vci.item_id,vci.item_name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where vce.cat_event_type LIKE '%Hunting%' and TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$date' and vci.item_type='Guide'");
                $HuntingEventInfo_ar = json_decode(json_encode($HuntingEventInfo), true);
            }
            if ($type == "ASSIGNEDEVENTS") {
                $heading = "Guide Assigned Event";
                $HuntingEventInfo = DB::Select(" Select vce.event_id,vc.name,vce.room,vci.item_id,vci.item_name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where vce.cat_event_type LIKE '%Hunting%' and TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$date' and vci.item_type='Guide' and vci.item_name NOT LIKE '%(Unassigned)%'");
                $HuntingEventInfo_ar = json_decode(json_encode($HuntingEventInfo), true);
            }
            if ($type == "UNASSIGNEDEVENTS") {
                $heading = "Guide Unassigned Event";
                $HuntingEventInfo = DB::Select(" Select vce.event_id,vc.name,vce.room,vci.item_id,vci.item_name from dev.vr_cat_sales vcs inner join dev.vr_cat_event vce on vcs.folio_id=vce.event_id inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id inner join dev.vr_customers vc on vcs.folio_customer_id=vc.customer_id where vce.cat_event_type LIKE '%Hunting%' and TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='$date' and vci.item_type='Guide' and vci.item_name LIKE '%(Unassigned)%'");
                $HuntingEventInfo_ar = json_decode(json_encode($HuntingEventInfo), true);
            }

            return view('GuideReservationHunting.FromCalenderEventInfo', compact('heading', 'HuntingEventInfo_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }

    //change on 05/06/2023
    public function FromHuntingCalenderRevised(Request $request)
    {
        $value = session()->get('id');
        if ($value != "") {
            $date = base64_decode($request['start_datetime']);
            $todayDate = $date;
            $eventid = base64_decode($request['eventid']);
            $guide = base64_decode($request['guide']);
            // Miltary date format change start 26/09/2023
            $query = "select rs.*,REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME
            from (Select vc.name as customer_name,vcs.cat_sales_stage, TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY HH:MM AM') As start_datetime,TO_CHAR(vce.END_DATETIME,'MM-DD-YYYY HH:MM AM') As end_datetime,vce.company_party_name as type_of_hunt,vcs.market_code, vc.main_phone as customer_phone_no, TO_CHAR(vcs.folio_open_date,'MM-DD-YYYY') as HuntStart, TO_CHAR(vcs.folio_close_date,'MM-DD-YYYY') as HuntEnd, vc.vip_level,vcs.folio_id,vce.room,vce.event_id,vcs.item_id,vce.group_folio_id
            from DEV.VR_CAT_EVENT vce
            inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
            inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
            where  vce.cat_event_type LIKE '%Hunting%'
            and vce.event_id=$eventid) rs
            left join dev.vr_cat_items vci on rs.item_id=vci.item_id";
// Miltary date format change end 26/09/2023
            if ($guide != 'NA') {
                $query = $query . " where vci.item_name like '%$guide%'";
            }
// dd($query);
            $data = DB::select($query);
            $data_ar = json_decode(json_encode($data), true);
            // dd($data_ar);
            $folioid = $data_ar[0]['event_id'];

            $paymentInfo = DB::select("select amount,txn_date from dev.vr_cat_payments where folio_id=$folioid");

            $paymentInfo_ar = json_decode(json_encode($paymentInfo), true);
            if (count($paymentInfo_ar) > 0) {
                $data_ar[0]['amount'] = $paymentInfo_ar[0]['amount'];
                $data_ar[0]['txn_date'] = $paymentInfo_ar[0]['txn_date'];
            } else {
                $data_ar[0]['amount'] = "NA";
                $data_ar[0]['txn_date'] = "NA";
            }

            $groupfolioid = $data_ar[0]['group_folio_id'];
            $marketcode = DB::select("select market_code from dev.vr_cat_sales where folio_id=$groupfolioid");
            $marketcode_ar = json_decode(json_encode($marketcode), true);
            $data_ar[0]['market_code'] = $marketcode_ar[0]['market_code'];

            return view('GuideReservationHunting.HuntingEventInfoRevised2', compact('data_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }

    //change on 12/06/2023
    // Reserve/Unreserve Guide for hunting on date Revised

    public function FromHuntingCalenderMultipleRevised(Request $request)
    {

        $value = session()->get('id');
        if ($value != "") {
            $todayDate = $request['date'];
            $date = $todayDate;
            $data = DB::select("Select vc.name as customer_name,vcs.cat_sales_stage, TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY HH:MM:ss') As start_datetime,TO_CHAR(vce.END_DATETIME,'MM-DD-YYYY HH:MM:ss') As end_datetime
              ,vce.company_party_name as type_of_hunt,  REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME, vc.main_phone as customer_phone_no, TO_CHAR(vcs.folio_open_date,'MM-DD-YYYY') as HuntStart, TO_CHAR(vcs.folio_close_date,'MM-DD-YYYY') as HuntEnd, vc.vip_level,vci.item_id,vcs.folio_id,vce.room
              from DEV.VR_CAT_EVENT vce
              inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
              inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id
              inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
              where vci.item_type='Guide' and vce.cat_event_type LIKE '%Hunting%' and vci.item_name NOT LIKE '%(Unassigned)%'
              and  To_CHAR(vce.start_datetime,'DD-MM-YYYY')='$date'");

            $data_ar = json_decode(json_encode($data), true);

            if (count($data_ar) > 0) {
                $folioid = $data_ar[0]['folio_id'];

                $paymentInfo = DB::select("select amount,txn_date from dev.vr_cat_payments where folio_id=$folioid");

                $paymentInfo_ar = json_decode(json_encode($paymentInfo), true);
                if (count($paymentInfo_ar) > 0) {
                    $data_ar[0]['amount'] = $paymentInfo_ar[0]['amount'];
                    $data_ar[0]['txn_date'] = $paymentInfo_ar[0]['txn_date'];
                } else {
                    $data_ar[0]['amount'] = "NA";
                    $data_ar[0]['txn_date'] = "NA";
                }
            }
            // dd($data_ar);
            return view('GuideReservationHunting.HuntingEventInfoRevised3', compact('data_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }

    public function OnDateFromCalendarHuntingGuideResevationDetailRevised(Request $request)
    {

        $value = session()->get('id');
        if ($value != "") {
            $todayDate = ($request['date']);
            $date = $todayDate;

            $data = DB::select("Select vc.name as customer_name,vcs.cat_sales_stage, TO_CHAR(vce.START_DATETIME,'MM-DD-YYYY HH:MM:ss') As start_datetime,TO_CHAR(vce.END_DATETIME,'MM-DD-YYYY HH:MM:ss') As end_datetime
              ,vce.company_party_name as type_of_hunt,  REGEXP_REPLACE(vci.item_name,' -.*$','') as GUIDE_NAME, vc.main_phone as customer_phone_no, TO_CHAR(vcs.folio_open_date,'MM-DD-YYYY') as HuntStart, TO_CHAR(vcs.folio_close_date,'MM-DD-YYYY') as HuntEnd, vc.vip_level,vci.item_id,vcs.folio_id,vce.room
              from DEV.VR_CAT_EVENT vce
              inner join dev.vr_cat_sales vcs on vce.event_id=vcs.folio_id
              inner join dev.vr_cat_items vci on vcs.item_id=vci.item_id
              inner join dev.vr_customers vc on vc.customer_id=vcs.folio_customer_id
              where vci.item_type='Guide' and vce.cat_event_type LIKE '%Hunting%' and vci.item_name NOT LIKE '%(Unassigned)%'
              and  To_CHAR(vce.start_datetime,'MM-DD-YYYY')='$date'");

            $data_ar = json_decode(json_encode($data), true);

            if (count($data_ar) > 0) {
                $folioid = $data_ar[0]['folio_id'];

                $paymentInfo = DB::select("select amount,txn_date from dev.vr_cat_payments where folio_id=$folioid");

                $paymentInfo_ar = json_decode(json_encode($paymentInfo), true);
                if (count($paymentInfo_ar) > 0) {
                    $data_ar[0]['amount'] = $paymentInfo_ar[0]['amount'];
                    $data_ar[0]['txn_date'] = $paymentInfo_ar[0]['txn_date'];
                } else {
                    $data_ar[0]['amount'] = "NA";
                    $data_ar[0]['txn_date'] = "NA";
                }
            }else{
                $data_ar[0]['start_datetime'] = $date;
                $data_ar[0]['customer_name'] = "";
            }
            return view('GuideReservationHunting.HuntingEventInfoRevised3', compact('data_ar', 'todayDate'));
        } else {
            return view('auth/login');
        }
    }
}
