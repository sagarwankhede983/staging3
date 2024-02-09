<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}" />
    <script type="text/javascript" src="{{ asset('/css/chartjs.js') }}"></script>
    <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css') }}" />
    <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.min.js') }}"></script>
    @include('layouts.dataTablesRequiredJS')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        .container1 {
            display: flex;
            /* justify-content: space-between; */
            align-items: center;
        }

        .left {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }

        .right {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
        }

        label {
            padding-left: 8%;
        }

        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- import sidebar navigation header -->
    @include('partials.navbarheader')
    <div id="layoutSidenav">
        <!-- import left sidebar here -->
        @include('partials.leftmenubar')
        <div id="layoutSidenav_content">
            <main>

                {{-- @if (count($data_ar) >= 5000)
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong></strong> This data is too larger to show on grid so you can view only 5000 rows but
                        when you click it will download all data in given date range will be downloaded.
                    </div>
                @endif --}}
                <div class="container-fluid">
                    <div class="container1"
                        style="margin-bottom:2%;margin-top: 2%;padding-left:1.5rem;padding-right:1.5rem">
                        <div class="left">
                            <div class="child">
                                <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
                            </div>
                        </div>
                        <?php $dateP = $fromdate;
                        $date = strtok($dateP, ' '); ?>
                        <?php if($date==""){
                                                                   ?>
                        <label>From Date:<br>
                            <input name="dateF" id="demodateF" style="width: 100px;">&nbsp;&nbsp;</label>
                        <label>To Date:<br>
                            <input name="dateT" id="demodateT" style="width: 100px;">&nbsp;&nbsp;</label>
                        <?php
                                                               }
                                                               else{
                                                                   ?>
                        <label>From Date:<br>
                            <input name="dateF" id="demodateF" value="<?php echo $date; ?>"
                                style="width: 130px;">&nbsp;&nbsp;</label>
                        <label>To Date:<br>
                            <input name="dateT" id="demodateT" value="<?php echo $todate; ?>"
                                style="width: 130px;">&nbsp;&nbsp;</label>
                        <?php
                                                               }
                                                               ?>
                        {{-- <div> --}}
                        <label>Year :&nbsp;<br>
                            <select class="chosen" id="dynamic_select" style="width:200px">
                                {{-- <option value="2023" selected>2023</option> --}}
                            </select>&nbsp;&nbsp;
                        </label>
                        {{-- </div> --}}
                    </div>

                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            {{ trans('Staff Booking Data') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-hover datatable"
                                    style="table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">EVENT_ID</th>
                                            <th class="text-left">GROUP_FOLIO_ID</th>
                                            <th class="text-left">Event_Time_Start</th>
                                            <th class="text-left">Event_Time_End</th>
                                            <th class="text-left">QTY_EST</th>
                                            <th class="text-left">QTY_GTD</th>
                                            <th class="text-left">QTY_SHOW</th>
                                            <th class="text-left">QTY_BILL</th>
                                            <th class="text-left">COMPANY_PARTY_NAME</th>
                                            <th class="text-left">ROOM</th>
                                            <th class="text-left">CAT_EVENT_TYPE</th>
                                            <th class="text-left">CAT_ROOM_SETUP</th>
                                            <th class="text-left">START_DATETIME</th>
                                            <th class="text-left">END_DATETIME</th>
                                            <th class="text-left">NAME</th>
                                            <th class="text-left">EVENT_TIME_START</th>
                                            <th class="text-left">EVENT_TIME_END</th>
                                            <th class="text-left">FOLIO_ID</th>
                                            {{-- <th class="text-left">GROUP_FOLIO_ID_1</th> --}}
                                            <th class="text-left">FOLIO_SUBTOTAL</th>
                                            <th class="text-left">FOLIO_SURCHARGES</th>
                                            <th class="text-left">FOLIO_TOTAL</th>
                                            <th class="text-left">FOLIO_PAYMENTS</th>
                                            <th class="text-left">FOLIO_BALANCE</th>
                                            <th class="text-left">FOLIO_SETTLED</th>
                                            <th class="text-left">FOLIO_OPEN_DATE</th>
                                            <th class="text-left">FOLIO_CLOSE_DATE</th>
                                            <th class="text-left">FOLIO_OPERATING_DAY</th>
                                            <th class="text-left">FOLIO_STAFF_ID</th>
                                            <th class="text-left">FOLIO_CUSTOMER_ID</th>
                                            <th class="text-left">FOLIO_LOCATION</th>
                                            <th class="text-left">FOLIO_ITEM_ID</th>
                                            <th class="text-left">ITEM_ID</th>
                                            <th class="text-left">ITEM_NAME</th>
                                            <th class="text-left">PRICE</th>
                                            <th class="text-left">QTY</th>
                                            <th class="text-left">DISCOUNT</th>
                                            <th class="text-left">DISC_TYPE</th>
                                            <th class="text-left">EXT_PRICE</th>
                                            <th class="text-left">PRICE_WITH_SURCHARGES</th>
                                            <th class="text-left">ITEM_CHARGE_CODE</th>
                                            <th class="text-left">ITEM_STAFF_ID</th>
                                            <th class="text-left">ITEM_TXN_DATE</th>
                                            <th class="text-left">ITEM_CUSTOMER_ID</th>
                                            <th class="text-left">COST_AT_PURCHASE</th>
                                            <th class="text-left">DEFERRED</th>
                                            <th class="text-left">FOLIO_ITEM_DETAIL_ID</th>
                                            <th class="text-left">DETAIL_CHARGE_CODE</th>
                                            <th class="text-left">HAS_VALUE</th>
                                            <th class="text-left">CHARGE_CODE_AMOUNT</th>
                                            <th class="text-left">EST_ARRIVAL_DATE</th>
                                            <th class="text-left">CAT_SALES_STAGE</th>
                                            <th class="text-left">FOLIO_LOCK_DATETIME</th>
                                            <th class="text-left">TAX_EXEMPT_TYPE</th>
                                            <th class="text-left">LAST_MODIFIED_DATE</th>
                                            <th class="text-left">ITEM_TYPE</th>
                                            <th class="text-left">PACKAGE_ITEM</th>
                                            <th class="text-left">PACKAGE_ORDER</th>
                                            <th class="text-left">MARKET_CODE</th>
                                            {{-- <th class="text-left">COMPANY_PARTY_NAME_1</th> --}}
                                            <th class="text-left">ITEM_DESC</th>
                                            {{-- <th class="text-left">QTY_EST_1</th>
                                            <th class="text-left">QTY_GTD_1</th>
                                            <th class="text-left">QTY_SHOW_1</th>
                                            <th class="text-left">QTY_BILL_1</th> --}}
                                            <th class="text-left">CUSTOMER_ID</th>
                                            <th class="text-left">FIRST_NAME</th>
                                            <th class="text-left">LAST_NAME</th>
                                            <th class="text-left">COMPANY_NAME</th>
                                            <th class="text-left">SALUTATION</th>
                                            {{-- <th class="text-left">NAME_1</th> --}}
                                            <th class="text-left">ADDRESS</th>
                                            <th class="text-left">ADDRESS_LINE_2</th>
                                            <th class="text-left">CITY</th>
                                            <th class="text-left">STATE_PROV</th>
                                            <th class="text-left">POSTAL_CODE</th>
                                            <th class="text-left">COUNTRY</th>
                                            <th class="text-left">HOME_PHONE</th>
                                            <th class="text-left">WORK_PHONE</th>
                                            <th class="text-left">WORK_EXT</th>
                                            <th class="text-left">OTHER_PHONE</th>
                                            <th class="text-left">FAX_NUMBER</th>
                                            <th class="text-left">MAIN_PHONE</th>
                                            <th class="text-left">PHONE_MAIN</th>
                                            <th class="text-left">EMAIL_ADDRESS</th>
                                            <th class="text-left">CUSTOMER_SINCE</th>
                                            <th class="text-left">BIRTH_DATE</th>
                                            <th class="text-left">GENDER</th>
                                            <th class="text-left">CREATED_IN_APP</th>
                                            <th class="text-left">TOTAL_PURCHASED</th>
                                            <th class="text-left">CAT_PURCHASED</th>
                                            <th class="text-left">GLF_PURCHASED</th>
                                            <th class="text-left">FIT_PURCHASED</th>
                                            <th class="text-left">POS_PURCHASED</th>
                                            <th class="text-left">PMS_PURCHASED</th>
                                            <th class="text-left">RET_PURCHASED</th>
                                            <th class="text-left">SKI_PURCHASED</th>
                                            <th class="text-left">SPA_PURCHASED</th>
                                            <th class="text-left">SPA_PRODUCTS</th>
                                            <th class="text-left">SPA_SERVICES</th>
                                            <th class="text-left">OCCUPATION</th>
                                            <th class="text-left">IS_GROUP</th>
                                            <th class="text-left">GROUP_ID</th>
                                            <th class="text-left">RELATIONSHIP</th>
                                            <th class="text-left">SOURCE</th>
                                            <th class="text-left">REFERRED_BY_ID</th>
                                            <th class="text-left">APPROVED_BY</th>
                                            <th class="text-left">DIRECT_BILL</th>
                                            <th class="text-left">MARKET_SOURCE</th>
                                            <th class="text-left">CUSTOMER_TYPE</th>
                                            <th class="text-left">CREATED_IN_LOC</th>
                                            <th class="text-left">NO_CALL</th>
                                            <th class="text-left">NO_MAIL</th>
                                            <th class="text-left">NO_EMAIL</th>
                                            <th class="text-left">SOURCE_CUST_ID</th>
                                            <th class="text-left">OLD_CAT_PURCHASED</th>
                                            <th class="text-left">OLD_GLF_PURCHASED</th>
                                            <th class="text-left">OLD_FIT_PURCHASED</th>
                                            <th class="text-left">OLD_POS_PURCHASED</th>
                                            <th class="text-left">OLD_PMS_PURCHASED</th>
                                            <th class="text-left">OLD_SKI_PURCHASED</th>
                                            <th class="text-left">OLD_SPA_PURCHASED</th>
                                            <th class="text-left">OLD_SPA_PRODUCTS</th>
                                            <th class="text-left">OLD_SPA_SERVICES</th>
                                            <th class="text-left">CREATED_DATE</th>
                                            <th class="text-left">CREATE_STAFF_ID</th>
                                            <th class="text-left">CHANGE_STAFF_ID</th>
                                            <th class="text-left">CUSTOMER_CODE</th>
                                            <th class="text-left">VIP_LEVEL</th>
                                            <th class="text-left">DEFAULT_DISCOUNT</th>
                                            <th class="text-left">DEFAULT_DISCOUNT_EXP</th>
                                            <th class="text-left">DEFAULT_DISCOUNT_EFF</th>
                                            <th class="text-left">EXCLUDE_LOYALTY</th>
                                            <th class="text-left">CC_TYPE</th>
                                            <th class="text-left">CC_EXPIRY</th>
                                            <th class="text-left">OTHER_ADDRESS</th>
                                            <th class="text-left">OTHER_ADDRESS_LINE_2</th>
                                            <th class="text-left">OTHER_CITY</th>
                                            <th class="text-left">OTHER_STATE_PROV</th>
                                            <th class="text-left">OTHER_POSTAL_CODE</th>
                                            <th class="text-left">OTHER_COUNTRY</th>
                                            <th class="text-left">SOURCE_IFACE</th>
                                            <th class="text-left">SOURCE_SYS_ID</th>
                                            <th class="text-left">SOURCE_SYS_NAME</th>
                                            <th class="text-left">LANGUAGE</th>
                                            <th class="text-left">LAST_VISIT_DATE</th>
                                            <th class="text-left">DEMOGRAPHIC</th>
                                            <th class="text-left">DEFAULT_PLAYER_TYPE</th>
                                            <th class="text-left">ALL_CUSTOMER_GUID</th>
                                            {{-- <th class="text-left">LAST_MODIFIED_DATE_1</th> --}}
                                            <th class="text-left">CC_CHANGE_DATE</th>
                                            <th class="text-left">SEND_METHOD</th>
                                            <th class="text-left">CLUB_PROSPECT</th>
                                            <th class="text-left">CLUB_REFERENCE</th>
                                            {{-- <th class="text-left">TAX_EXEMPT_TYPE_1</th> --}}
                                            <th class="text-left">HOME_COUNTRY_CODE</th>
                                            <th class="text-left">WORK_COUNTRY_CODE</th>
                                            <th class="text-left">MOBILE_COUNTRY_CODE</th>
                                            <th class="text-left">OTHER_COUNTRY_CODE</th>
                                            <th class="text-left">MAIN_COUNTRY_CODE</th>
                                            <th class="text-left">MOBILE_PHONE</th>
                                            <th class="text-left">CLUB_ACTIVATION_DATE</th>
                                            <th class="text-left">PMS_NUM_VISITS</th>
                                            <th class="text-left">PMS_OLD_NUM_VISITS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                              $i=0;
                                              foreach($data_ar as $id => $eventcount)  {
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{ $i + 1 }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['group_folio_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_time_start'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_time_end'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_est'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_gtd'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_show'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_bill'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['company_party_name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['room'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['cat_event_type'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['cat_room_setup'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['start_datetime'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['end_datetime'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_time_start'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_time_end'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_id'] }}</td>
                                            {{-- <td class="text-left">{{ $data_ar[$i]['group_folio_id_1'] }}</td> --}}
                                            <td class="text-left">{{ $data_ar[$i]['folio_subtotal'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_surcharges'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_total'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_payments'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_balance'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_settled'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_open_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_close_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_operating_day'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_staff_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_customer_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_location'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_item_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['item_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['item_name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['price'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['discount'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['disc_type'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['ext_price'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['price_with_surcharges'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['item_charge_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['item_staff_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['item_txn_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['item_customer_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['cost_at_purchase'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['deferred'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_item_detail_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['detail_charge_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['has_value'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['charge_code_amount'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['est_arrival_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['cat_sales_stage'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_lock_datetime'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['tax_exempt_type'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['last_modified_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['item_type'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['package_item'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['package_order'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['market_code'] }}</td>
                                            {{-- <td class="text-left">{{ $data_ar[$i]['company_party_name_1'] }}</td> --}}
                                            <td class="text-left">{{ $data_ar[$i]['item_desc'] }}</td>
                                            {{-- <td class="text-left">{{ $data_ar[$i]['qty_est_1'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_gtd_1'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_show_1'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_bill_1'] }}</td> --}}
                                            <td class="text-left">{{ $data_ar[$i]['customer_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['first_name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['last_name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['company_name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['salutation'] }}</td>
                                            {{-- <td class="text-left">{{ $data_ar[$i]['name_1'] }}</td> --}}
                                            <td class="text-left">{{ $data_ar[$i]['address'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['address_line_2'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['city'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['state_prov'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['postal_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['country'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['home_phone'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['work_phone'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['work_ext'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['other_phone'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['fax_number'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['main_phone'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['phone_main'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['email_address'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['customer_since'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['birth_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['gender'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['created_in_app'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['total_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['cat_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['glf_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['fit_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['pos_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['pms_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['ret_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['ski_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['spa_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['spa_products'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['spa_services'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['occupation'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['is_group'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['group_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['relationship'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['source'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['referred_by_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['approved_by'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['direct_bill'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['market_source'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['customer_type'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['created_in_loc'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['no_call'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['no_mail'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['no_email'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['source_cust_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_cat_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_glf_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_fit_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_pos_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_pms_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_ski_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_spa_purchased'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_spa_products'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['old_spa_services'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['created_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['create_staff_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['change_staff_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['customer_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['vip_level'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['default_discount'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['default_discount_exp'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['default_discount_eff'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['exclude_loyalty'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['cc_type'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['cc_expiry'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['other_address'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['other_address_line_2'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['other_city'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['other_state_prov'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['other_postal_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['other_country'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['source_iface'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['source_sys_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['source_sys_name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['language'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['last_visit_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['demographic'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['default_player_type'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['all_customer_guid'] }}</td>
                                            {{-- <td class="text-left">{{ $data_ar[$i]['last_modified_date_1'] }}</td> --}}
                                            <td class="text-left">{{ $data_ar[$i]['cc_change_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['send_method'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['club_prospect'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['club_reference'] }}</td>
                                            {{-- <td class="text-left">{{ $data_ar[$i]['tax_exempt_type_1'] }}</td> --}}
                                            <td class="text-left">{{ $data_ar[$i]['home_country_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['work_country_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['mobile_country_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['other_country_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['main_country_code'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['mobile_phone'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['club_activation_date'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['pms_num_visits'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['pms_old_num_visits'] }}</td>
                                        </tr>
                                        <?php
                                                  $i++;
                                                  }
                                                 ?>
                                                 {{-- {{ dd($data_ar) }} --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="../js/scripts.js"></script>
    <script>
        $('.datatable').DataTable({
            scrollX: true,
            scrollY: "600px",
            scrollCollapse: true,

            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'csv',
                    title: 'staffbookingdata'
                },
                {
                    extend: 'excel',
                    title: 'staffbookingdata'
                },
                {
                    extend: 'pdf',
                    title: 'staffbookingdata',
                    orientation: 'landscape'
                },
                'print',
                // {
                //     text: 'Download Excel',
                //     className: 'custom-excel-button',
                //     action: function(e, dt, node, config) {
                //         $('#hiddenDownloadButton').click();
                //     }
                // }
            ],
            pageLength: 10
        });
        // $(document).ready(function() {
        //     // Assign an ID to the custom Excel button
        //     $('.custom-excel-button').attr('id', 'download');
        // });
    </script>
    <script>
        $(document).ready(function() {
            $(function() {
                $("#demodateF").datepicker({
                    dateFormat: 'mm-dd-yy',
                    onSelect: function(selectedDate) {
                        var fromDate = new Date(selectedDate);
                        var toDate = new Date(fromDate);
                        toDate.setFullYear(fromDate.getFullYear() + 1);
                        $("#demodateT").datepicker("option", "minDate", selectedDate);
                        $("#demodateT").datepicker("option", "maxDate", toDate);
                        // Refresh the "to" date Datepicker
                        $("#demodateT").datepicker("refresh");
                        $('#demodateF').trigger('change');
                    }
                });
            });

            $(function() {
                $("#demodateT").datepicker({
                    dateFormat: 'mm-dd-yy',
                    beforeShow: function(input, inst) {
                        var minDate = $("#demodateF").datepicker("getDate");
                        if (minDate) {
                            var maxDate = new Date(minDate);
                            maxDate.setFullYear(minDate.getFullYear() + 1);
                            $(this).datepicker("option", "minDate", minDate);
                            $(this).datepicker("option", "maxDate", maxDate);
                        }
                    }
                });
            });
        });

        var year = <?php echo $year; ?>;

        var select = document.getElementById("dynamic_select");
        var currentYear = new Date().getFullYear();
        if(year != currentYear){
            currentYear = year;
        }
        var startYear = currentYear - 10; // Adjust as needed
        var endYear = currentYear + 10;

        for (var year = startYear; year <= endYear; year++) {
            var option = document.createElement("option");
            option.value = year;
            option.text = year;
            if (year === currentYear) { // Select the current year by default
                option.selected = true;
            }
            select.appendChild(option);
        }

        function updateDates() {
            var selectedYear = select.value;
            var formattedFromDate = `01-01-${selectedYear}`;
            var formattedToDate = `31-12-${selectedYear}`;
            document.getElementById("demodateF").value = formattedFromDate;
            document.getElementById("demodateT").value = formattedToDate;
            $('#demodateF').trigger('change');
        }

        // Attach event listener to the select element
        select.addEventListener("change", updateDates);

        // Initial update of the dates based on the default selected year
        fromdate = document.getElementById("demodateF").value;
        todate = document.getElementById("demodateT").value;
        if(fromdate.getFullYear() === year && todate.getFullYear() === year){
            updateDates();
        }

    </script>
    <script>
        function fun1() {

            var headerMonthYear = $('.fc-center h2').html();
            var myHeadermonthYearArray = headerMonthYear.split(" ");

            var intMonthNumb = 0;
            switch (myHeadermonthYearArray[0]) {
                case "January":
                    intMonthNumb = 1;
                    break;
                case "February":
                    intMonthNumb = 2;
                    break;
                case "March":
                    intMonthNumb = 3;
                    break;
                case "April":
                    intMonthNumb = 4;
                    break;
                case "May":
                    intMonthNumb = 5;
                    break;
                case "June":
                    intMonthNumb = 6;
                    break;
                case "July":
                    intMonthNumb = 7;
                    break;
                case "August":
                    intMonthNumb = 8;
                    break;
                case "September":
                    intMonthNumb = 9;
                    break;
                case "October":
                    intMonthNumb = 10;
                    break;
                case "November":
                    intMonthNumb = 11;
                    break;
                case "December":
                    intMonthNumb = 12;
                    break;
                default: {
                    break;
                }
            }
            intMonthNumb = intMonthNumb - 1;
            if (intMonthNumb == 0) {
                intMonthNumb = 12;
                myHeadermonthYearArray[1] = myHeadermonthYearArray[1] - 1;
            }
            if (intMonthNumb < 10) {
                var temp = "";
                temp = temp.concat("0");
                temp = temp.concat(intMonthNumb);
                intMonthNumb = temp;
            }

            var tempDate = "";
            tempDate = tempDate.concat(intMonthNumb);
            tempDate = tempDate.concat("/");
            tempDate = tempDate.concat("01");
            tempDate = tempDate.concat("/");
            tempDate = tempDate.concat(myHeadermonthYearArray[1]);
            // alert(tempDate);
            var date = new Date(tempDate);
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            var firstDayFormated = "";
            var lastDayFormated = "";
            firstDayFormated = convert(firstDay);
            lastDayFormated = convert(lastDay);

            function convert(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [mnth, day, date.getFullYear()].join("-");
            }

            document.getElementById("fromdateinput").value = btoa(firstDayFormated);
            document.getElementById("todateinput").value = btoa(lastDayFormated);


            //    alert(firstDayFormated+"----"+lastDayFormated);
        }

        function fun2() {

            var headerMonthYear = $('.fc-center h2').html();
            var myHeadermonthYearArray = headerMonthYear.split(" ");

            var intMonthNumb = 0;
            switch (myHeadermonthYearArray[0]) {
                case "January":
                    intMonthNumb = 1;
                    break;
                case "February":
                    intMonthNumb = 2;
                    break;
                case "March":
                    intMonthNumb = 3;
                    break;
                case "April":
                    intMonthNumb = 4;
                    break;
                case "May":
                    intMonthNumb = 5;
                    break;
                case "June":
                    intMonthNumb = 6;
                    break;
                case "July":
                    intMonthNumb = 7;
                    break;
                case "August":
                    intMonthNumb = 8;
                    break;
                case "September":
                    intMonthNumb = 9;
                    break;
                case "October":
                    intMonthNumb = 10;
                    break;
                case "November":
                    intMonthNumb = 11;
                    break;
                case "December":
                    intMonthNumb = 12;
                    break;
                default: {
                    break;
                }
            }
            intMonthNumb = intMonthNumb + 1;
            if (intMonthNumb == 13) {
                intMonthNumb = 1;
                var intYear = 0;
                intYear = myHeadermonthYearArray[1];
                intYear = ++intYear;
                myHeadermonthYearArray[1] = intYear;

            }
            if (intMonthNumb < 10) {
                var temp = "";
                temp = temp.concat("0");
                temp = temp.concat(intMonthNumb);
                intMonthNumb = temp;
            }
            var tempDate = "";
            tempDate = tempDate.concat(intMonthNumb);
            tempDate = tempDate.concat("/");
            tempDate = tempDate.concat("01");
            tempDate = tempDate.concat("/");
            tempDate = tempDate.concat(myHeadermonthYearArray[1]);
            // alert(tempDate);
            var date = new Date(tempDate);
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            var firstDayFormated = "";
            var lastDayFormated = "";
            firstDayFormated = convert(firstDay);
            lastDayFormated = convert(lastDay);

            function convert(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [mnth, day, date.getFullYear()].join("-");
            }
            document.getElementById("fromdateinput").value = btoa(firstDayFormated);
            document.getElementById("todateinput").value = btoa(lastDayFormated);
        }
    </script>
    <script>
        $(function() {
            $('#demodateF').on('change', function() {
                console.log("Inside  demoF");
                var fromdate = document.getElementById("demodateF").value;
                var toDate = calculateToDate(fromdate, 1); // Calculate todate by adding 1 year
                document.getElementById("demodateT").value = toDate;
                var todate = document.getElementById("demodateT").value;
                var year = document.getElementById("dynamic_select").value;
                window.location = "/dateFilterStaffBookingRevised/" + btoa(fromdate) + "/" + btoa(todate) + "/" + btoa(year);
            });

            $('#demodateT').on('change', function() {
                console.log("Inside  demoT");
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;
                var year = document.getElementById("dynamic_select");
                window.location = "/dateFilterStaffBookingRevised/" + btoa(fromdate) + "/" + btoa(todate) + "/" + btoa(year);
            });

            $('#download').on('click', function() {
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;

                window.location = "/downloadexcel/" + btoa(fromdate) + "/" + btoa(todate);
            });
        });

        function calculateToDate(fromdate, yearsToAdd) {
            var fromDateObj = new Date(fromdate);
            var toDateObj = new Date(fromDateObj);
            toDateObj.setFullYear(fromDateObj.getFullYear() + yearsToAdd);
            toDateObj.setDate(toDateObj.getDate() - 1);
            // Extract mm, dd, yyyy parts
            var mm = String(toDateObj.getMonth() + 1).padStart(2, '0'); // January is 0!
            var dd = String(toDateObj.getDate()).padStart(2, '0');
            var yyyy = toDateObj.getFullYear();

            // Format as mm-dd-yyyy
            var formattedDate = mm + '-' + dd + '-' + yyyy;
            return formattedDate;
        }

        // $(document).ready(function() {
        // var dataCount = <?php echo count($data_ar); ?>;
        // $('.dt-buttons').hide();
        // if (dataCount < 5000) {
        //     $('.dt-buttons').show();
        //     $('#download').hide();
        // } else {
        //     $('.dt-buttons').show(); // Hide DataTables buttons
        //     $('.buttons-pdf').hide();
        //     $('.buttons-copy').hide();
        //     $('.buttons-csv').hide();
        //     $('.buttons-excel').hide();
        //     $('.buttons-print').hide();
        //     $('#download').show();
        //     }
        // });
    </script>

</body>

</html>
