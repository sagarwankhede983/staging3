<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;
use Charts;
class HomeController

{
    public function index()
    {
        $todayDate=date('d-m-Y');
        //$data=DB::Select("Select COUNT(Distinct vci.Item_id) as eventCount from VR_CAT_EVENT vce inner join VR_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join VR_CAT_ITEMS vci on vci.item_id=vcs.item_id where START_DATETIME='31-08-19' and vci.ITEM_CATEGORY IN ('Breakfast','Lunch','Dinner') ORDER BY(vci.ITEM_CATEGORY)");
        $data=DB::Select("Select COUNT(Distinct vci.Item_id) as eventCount from VR_CAT_EVENT vce inner join VR_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join VR_CAT_ITEMS vci on vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'DD-MM-YYYY')='31-08-2019' and vce.cat_event_type IN ('Breakfast','Lunch','Dinner') ORDER BY(vce.cat_event_type)");
        $breakfast=DB::Select("Select COUNT(Distinct vci.Item_id) as eventCount from VR_CAT_EVENT vce inner join VR_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join VR_CAT_ITEMS vci on vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'DD-MM-YYYY')='31-08-2019' and vce.cat_event_type='Breakfast' ORDER BY(vce.cat_event_type)");  
        $lunch=DB::Select("Select COUNT(Distinct vci.Item_id) as eventCount from VR_CAT_EVENT vce inner join VR_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join VR_CAT_ITEMS vci on vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'DD-MM-YYYY')='31-08-2019' and vce.cat_event_type='Lunch' ORDER BY(vce.cat_event_type)");   
        $dinner=DB::Select("Select COUNT(Distinct vci.Item_id) as eventCount from VR_CAT_EVENT vce inner join VR_CAT_SALES vcs on vce.EVENT_ID=vcs.FOLIO_ID inner join VR_CAT_ITEMS vci on vci.item_id=vcs.item_id where TO_CHAR(START_DATETIME,'DD-MM-YYYY')='31-08-2019' and vce.cat_event_type='Dinner' ORDER BY(vce.cat_event_type)");   
        $data_ar = json_decode(json_encode($data),true);
        $breakfast_ar = json_decode(json_encode($breakfast),true);
        $lunch_ar = json_decode(json_encode($lunch),true);
        $dinner_ar = json_decode(json_encode($dinner),true);
        $todaymenu=$data_ar[0]['eventcount'];
        $todaybreakfast=$breakfast_ar[0]['eventcount'];
        $todaylunch=$lunch_ar[0]['eventcount'];
        $todaydinner=$dinner_ar[0]['eventcount'];
        $event_data=DB::Select("select COUNT(cat_event_type) As count,cat_event_type from VR_CAT_EVENT where TO_CHAR(start_datetime,'DD-MM-YYYY')='31-08-2019' Group By cat_event_type");
        $event_list_ar = json_decode(json_encode($event_data),true);
        $todays_event_data=DB::Select("Select COUNT(vci.item_category) As count,vci.item_category from VR_CAT_ITEMS vci inner join VR_CAT_SALES vcs on vcs.item_id=vci.item_id inner join VR_CAT_EVENT vce on vce.event_id=vcs.folio_id where vce.cat_event_type IN('Breakfast','Lunch','Dinner') and TO_CHAR(vce.start_datetime,'DD-MM-YYYY')='31-08-2019' GROUP BY vci.item_category");
        $todays_event_data_ar = json_decode(json_encode($todays_event_data),true);
        return view('home',compact('todaymenu','todaybreakfast','todaylunch','todaydinner','event_list_ar','todays_event_data_ar'));
       
        
    }
}
