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
    {{-- @include('layouts.dataTablesRequiredJS') --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.css') }}" />
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">



    <link href="" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="//fonts.googleapis.com/css?family=Merriweather:300,700,700italic,300italic|Open+Sans:700,400&display=swap" />
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
                <div id="hello">
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
                                <div class="table-wrapper">


                                    <table id="datatable" class="display nowrap" style="width:100%">
                                        <thead>
                                            <tr align="left">
                                                <th>event_id</th>
                                                <th>group_folio_id</th>
                                                <th>event_time_start</th>
                                                <th>event_time_end</th>
                                                <th>qty_est</th>
                                                <th>qty_gtd</th>
                                                <th>qty_show</th>
                                                <th>qty_bill</th>
                                                <th>company_party_name</th>
                                                <th>room</th>
                                                <th>cat_event_type</th>
                                                <th>cat_room_setup</th>
                                                <th>start_datetime</th>
                                                <th>end_datetime</th>
                                                <th>name</th>
                                                <th>folio_id</th>
                                                <th>folio_subtotal</th>
                                                <th>folio_surcharges</th>
                                                <th>folio_total</th>
                                                <th>folio_payments</th>
                                                <th>folio_balance</th>
                                                <th>folio_settled</th>
                                                <th>folio_open_date</th>
                                                <th>folio_close_date</th>
                                                <th>folio_operating_day</th>
                                                <th>folio_staff_id</th>
                                                <th>folio_customer_id</th>
                                                <th>folio_location</th>
                                                <th>folio_item_id</th>
                                                <th>item_id</th>
                                                <th>item_name</th>
                                                <th>price</th>
                                                <th>qty</th>
                                                <th>discount</th>
                                                <th>disc_type</th>
                                                <th>ext_price</th>
                                                <th>price_with_surcharges</th>
                                                <th>item_charge_code</th>
                                                <th>item_staff_id</th>
                                                <th>item_txn_date</th>
                                                <th>item_customer_id</th>
                                                <th>cost_at_purchase</th>
                                                <th>deferred</th>
                                                <th>folio_item_detail_id</th>
                                                <th>detail_charge_code</th>
                                                <th>has_value</th>
                                                <th>charge_code_amount</th>
                                                <th>est_arrival_date</th>
                                                {{--  <th>cat_sales_stage</th>
                                            <th>folio_lock_datetime</th>
                                            <th>tax_exempt_type</th>
                                            <th>last_modified_date</th>
                                            <th>item_type</th>
                                            <th>package_item</th>
                                            <th>package_order</th>
                                            <th>market_code</th>
                                            <th>item_desc</th>
                                            <th>customer_id</th>
                                            <th>first_name</th>
                                            <th>last_name</th>
                                            <th>company_name</th>
                                            <th>salutation</th>
                                            <th>address</th>
                                            <th>address_line_2</th>
                                            <th>city</th>
                                            <th>state_prov</th>
                                            <th>postal_code</th>
                                            <th>country</th>
                                            <th>home_phone</th>
                                            <th>work_phone</th>
                                            <th>work_ext</th>
                                            <th>other_phone</th>
                                            <th>fax_number</th>
                                            <th>main_phone</th>
                                            <th>phone_main</th>
                                            <th>email_address</th>
                                            <th>customer_since</th>
                                            <th>birth_date</th>
                                            <th>gender</th>
                                            <th>created_in_app</th>
                                            <th>total_purchased</th>
                                            <th>cat_purchased</th>
                                            <th>glf_purchased</th>
                                            <th>fit_purchased</th>
                                            <th>pos_purchased</th>
                                            <th>pms_purchased</th>
                                            <th>ret_purchased</th>
                                            <th>ski_purchased</th>
                                            <th>spa_purchased</th>
                                            <th>spa_products</th>
                                            <th>spa_services</th>
                                            <th>occupation</th>
                                            <th>is_group</th>
                                            <th>group_id</th>
                                            <th>relationship</th>
                                            <th>source</th>
                                            <th>referred_by_id</th>
                                            <th>approved_by</th>
                                            <th>direct_bill</th>
                                            <th>market_source</th>
                                            <th>customer_type</th>
                                            <th>created_in_loc</th>
                                            <th>no_call</th>
                                            <th>no_mail</th>
                                            <th>no_email</th>
                                            <th>source_cust_id</th>
                                            <th>old_cat_purchased</th>
                                            <th>old_glf_purchased</th>
                                            <th>old_fit_purchased</th>
                                            <th>old_pos_purchased</th>
                                            <th>old_pms_purchased</th>
                                            <th>old_ski_purchased</th>
                                            <th>old_spa_purchased</th>
                                            <th>old_spa_products</th>
                                            <th>old_spa_services</th>
                                            <th>created_date</th>
                                            <th>create_staff_id</th>
                                            <th>change_staff_id</th>
                                            <th>customer_code</th>
                                            <th>vip_level</th>
                                            <th>default_discount</th>
                                            <th>default_discount_exp</th>
                                            <th>default_discount_eff</th>
                                            <th>exclude_loyalty</th>
                                            <th>cc_type</th>
                                            <th>cc_expiry</th>
                                            <th>other_address</th>
                                            <th>other_address_line_2</th>
                                            <th>other_city</th>
                                            <th>other_state_prov</th>
                                            <th>other_postal_code</th>
                                            <th>other_country</th>
                                            <th>source_iface</th>
                                            <th>source_sys_id</th>
                                            <th>source_sys_name</th>
                                            <th>language</th>
                                            <th>last_visit_date</th>
                                            <th>demographic</th>
                                            <th>default_player_type</th>
                                            <th>all_customer_guid</th>
                                            <th>cc_change_date</th>
                                            <th>send_method</th>
                                            <th>club_prospect</th>
                                            <th>club_reference</th>
                                            <th>home_country_code</th>
                                            <th>work_country_code</th>
                                            <th>mobile_country_code</th>
                                            <th>other_country_code</th>
                                            <th>main_country_code</th>
                                            <th>mobile_phone</th>
                                            <th>club_activation_date</th>
                                            <th>pms_num_visits</th>
                                            <th>pms_old_num_visit</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="../js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                scrollX: true, // Enable horizontal scrolling
                scrollY: 'calc(100vh - 200px)', // Set the height for vertical scrolling
                scrollCollapse: true,
                fixedHeader: true,
                order: [
                    [0, "desc"]
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        filename: 'StaffBookingData'
                    },
                    {
                        extend: 'csv',
                        filename: 'StaffBookingData'
                    },
                    {
                        extend: 'excel',
                        filename: 'StaffBookingData'
                    },
                    // {
                    //     extend: 'pdf',
                    //     filename: 'StaffBookingData',
                    //     exportOptions: {
                    //         columns: ':all' // Include only visible columns in the PDF export
                    //     }
                    // },
                    {
                        extend: 'print',
                        filename: 'StaffBookingData'
                    }
                ],
                ajax: {
                    url: "{{ url('users-data') }}",
                    type: "GET",
                    data: function(d) {
                        d.param1 = document.getElementById("demodateF").value;
                        d.param2 = document.getElementById("demodateT").value;
                    }
                },
                columns: [{
                        data: 'event_id'
                    },
                    {
                        data: 'group_folio_id'
                    },
                    {
                        data: 'event_time_start'
                    },
                    {
                        data: 'event_time_end'
                    },
                    {
                        data: 'qty_est'
                    },
                    {
                        data: 'qty_gtd'
                    },
                    {
                        data: 'qty_show'
                    },
                    {
                        data: 'qty_bill'
                    },
                    {
                        data: 'company_party_name'
                    },
                    {
                        data: 'room'
                    },
                    {
                        data: 'cat_event_type'
                    },
                    {
                        data: 'cat_room_setup'
                    },
                    {
                        data: 'start_datetime'
                    },
                    {
                        data: 'end_datetime'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'folio_id'
                    },
                    {
                        data: 'folio_subtotal'
                    },
                    {
                        data: 'folio_surcharges'
                    },
                    {
                        data: 'folio_total'
                    },
                    {
                        data: 'folio_payments'
                    },
                    {
                        data: 'folio_balance'
                    },
                    {
                        data: 'folio_settled'
                    },
                    {
                        data: 'folio_open_date'
                    },
                    {
                        data: 'folio_close_date'
                    },
                    {
                        data: 'folio_operating_day'
                    },
                    {
                        data: 'folio_staff_id'
                    },
                    {
                        data: 'folio_customer_id'
                    },
                    {
                        data: 'folio_location'
                    },
                    {
                        data: 'folio_item_id'
                    },
                    {
                        data: 'item_id'
                    },
                    {
                        data: 'item_name'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'qty'
                    },
                    {
                        data: 'discount'
                    },
                    {
                        data: 'disc_type'
                    },
                    {
                        data: 'ext_price'
                    },
                    {
                        data: 'price_with_surcharges'
                    },
                    {
                        data: 'item_charge_code'
                    },
                    {
                        data: 'item_staff_id'
                    },
                    {
                        data: 'item_txn_date'
                    },
                    {
                        data: 'item_customer_id'
                    },
                    {
                        data: 'cost_at_purchase'
                    },
                    {
                        data: 'deferred'
                    },
                    {
                        data: 'folio_item_detail_id'
                    },
                    {
                        data: 'detail_charge_code'
                    },
                    {
                        data: 'has_value'
                    },
                    {
                        data: 'charge_code_amount'
                    },
                    {
                        data: 'est_arrival_date'
                    }
                    // {
                    //     data: 'cat_sales_stage'
                    // },
                    // {
                    //     data: 'folio_lock_datetime'
                    // },
                    // {
                    //     data: 'tax_exempt_type'
                    // },
                    // {
                    //     data: 'last_modified_date'
                    // },
                    // {
                    //     data: 'item_type'
                    // },
                    // {
                    //     data: 'package_item'
                    // },
                    // {
                    //     data: 'package_order'
                    // },
                    // {
                    //     data: 'market_code'
                    // },
                    // {
                    //     data: 'item_desc'
                    // },
                    // {
                    //     data: 'customer_id'
                    // },
                    // {
                    //     data: 'first_name'
                    // },
                    // {
                    //     data: 'last_name'
                    // },
                    // {
                    //     data: 'company_name'
                    // },
                    // {
                    //     data: 'salutation'
                    // },
                    // {
                    //     data: 'address'
                    // },
                    // {
                    //     data: 'address_line_2'
                    // },
                    // {
                    //     data: 'city'
                    // },
                    // {
                    //     data: 'state_prov'
                    // },
                    // {
                    //     data: 'postal_code'
                    // },
                    // {
                    //     data: 'country'
                    // },
                    // {
                    //     data: 'home_phone'
                    // },
                    // {
                    //     data: 'work_phone'
                    // },
                    // {
                    //     data: 'work_ext'
                    // },
                    // {
                    //     data: 'other_phone'
                    // },
                    // {
                    //     data: 'fax_number'
                    // },
                    // {
                    //     data: 'main_phone'
                    // },
                    // {
                    //     data: 'phone_main'
                    // },
                    // {
                    //     data: 'email_address'
                    // },
                    // {
                    //     data: 'customer_since'
                    // },
                    // {
                    //     data: 'birth_date'
                    // },
                    // {
                    //     data: 'gender'
                    // },
                    // {
                    //     data: 'created_in_app'
                    // },
                    // {
                    //     data: 'total_purchased'
                    // },
                    // {
                    //     data: 'cat_purchased'
                    // },
                    // {
                    //     data: 'glf_purchased'
                    // },
                    // {
                    //     data: 'fit_purchased'
                    // },
                    // {
                    //     data: 'pos_purchased'
                    // },
                    // {
                    //     data: 'pms_purchased'
                    // },
                    // {
                    //     data: 'ret_purchased'
                    // },
                    // {
                    //     data: 'ski_purchased'
                    // },
                    // {
                    //     data: 'spa_purchased'
                    // },
                    // {
                    //     data: 'spa_products'
                    // },
                    // {
                    //     data: 'spa_services'
                    // },
                    // {
                    //     data: 'occupation'
                    // },
                    // {
                    //     data: 'is_group'
                    // },
                    // {
                    //     data: 'group_id'
                    // },
                    // {
                    //     data: 'relationship'
                    // },
                    // {
                    //     data: 'source'
                    // },
                    // {
                    //     data: 'referred_by_id'
                    // },
                    // {
                    //     data: 'approved_by'
                    // },
                    // {
                    //     data: 'direct_bill'
                    // },
                    // {
                    //     data: 'market_source'
                    // },
                    // {
                    //     data: 'customer_type'
                    // },
                    // {
                    //     data: 'created_in_loc'
                    // },
                    // {
                    //     data: 'no_call'
                    // },
                    // {
                    //     data: 'no_mail'
                    // },
                    // {
                    //     data: 'no_email'
                    // },
                    // {
                    //     data: 'source_cust_id'
                    // },
                    // {
                    //     data: 'old_cat_purchased'
                    // },
                    // {
                    //     data: 'old_glf_purchased'
                    // },
                    // {
                    //     data: 'old_fit_purchased'
                    // },
                    // {
                    //     data: 'old_pos_purchased'
                    // },
                    // {
                    //     data: 'old_pms_purchased'
                    // },
                    // {
                    //     data: 'old_ski_purchased'
                    // },
                    // {
                    //     data: 'old_spa_purchased'
                    // },
                    // {
                    //     data: 'old_spa_products'
                    // },
                    // {
                    //     data: 'old_spa_services'
                    // },
                    // {
                    //     data: 'created_date'
                    // },
                    // {
                    //     data: 'create_staff_id'
                    // },
                    // {
                    //     data: 'change_staff_id'
                    // },
                    // {
                    //     data: 'customer_code'
                    // },
                    // {
                    //     data: 'vip_level'
                    // },
                    // {
                    //     data: 'default_discount'
                    // },
                    // {
                    //     data: 'default_discount_exp'
                    // },
                    // {
                    //     data: 'default_discount_eff'
                    // },
                    // {
                    //     data: 'exclude_loyalty'
                    // },
                    // {
                    //     data: 'cc_type'
                    // },
                    // {
                    //     data: 'cc_expiry'
                    // },
                    // {
                    //     data: 'other_address'
                    // },
                    // {
                    //     data: 'other_address_line_2'
                    // },
                    // {
                    //     data: 'other_city'
                    // },
                    // {
                    //     data: 'other_state_prov'
                    // },
                    // {
                    //     data: 'other_postal_code'
                    // },
                    // {
                    //     data: 'other_country'
                    // },
                    // {
                    //     data: 'source_iface'
                    // },
                    // {
                    //     data: 'source_sys_id'
                    // },
                    // {
                    //     data: 'source_sys_name'
                    // },
                    // {
                    //     data: 'language'
                    // },
                    // {
                    //     data: 'last_visit_date'
                    // },
                    // {
                    //     data: 'demographic'
                    // },
                    // {
                    //     data: 'default_player_type'
                    // },
                    // {
                    //     data: 'all_customer_guid'
                    // },
                    // {
                    //     data: 'cc_change_date'
                    // },
                    // {
                    //     data: 'send_method'
                    // },
                    // {
                    //     data: 'club_prospect'
                    // },
                    // {
                    //     data: 'club_reference'
                    // },
                    // {
                    //     data: 'home_country_code'
                    // },
                    // {
                    //     data: 'work_country_code'
                    // },
                    // {
                    //     data: 'mobile_country_code'
                    // },
                    // {
                    //     data: 'other_country_code'
                    // },
                    // {
                    //     data: 'main_country_code'
                    // },
                    // {
                    //     data: 'mobile_phone'
                    // },
                    // {
                    //     data: 'club_activation_date'
                    // },
                    // {
                    //     data: 'pms_num_visits'
                    // },
                    // {
                    //     data: 'pms_old_num_visits'
                    // }
                ]
            });
        });
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
        if (year != currentYear) {
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
        if (fromdate.getFullYear() === year && todate.getFullYear() === year) {
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
                dataTable = $('#datatable').DataTable();
                $('#datatable').addClass('processing');
                dataTable.clear().draw();
                // window.location = "/dateFilterStaffBookingRevised/" + btoa(fromdate) + "/" + btoa(todate) +
                //     "/" + btoa(year);
            });

            $('#demodateT').on('change', function() {
                console.log("Inside  demoT");
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;
                var year = document.getElementById("dynamic_select");
                dataTable = $('#datatable').DataTable();
                dataTable.clear().draw();

                // window.location = "/dateFilterStaffBookingRevised/" + btoa(fromdate) + "/" + btoa(todate) +
                //     "/" + btoa(year);
            });

            // $('#download').on('click', function() {
            //     var fromdate = document.getElementById("demodateF").value;
            //     var todate = document.getElementById("demodateT").value;
            //     dataTable = $('#datatable').DataTable();
            //     dataTable.draw();
            //     // window.location = "/downloadexcel/" + btoa(fromdate) + "/" + btoa(todate);
            // });
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
    </script>

</body>

</html>
