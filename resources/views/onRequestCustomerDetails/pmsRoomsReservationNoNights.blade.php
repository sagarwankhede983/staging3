<!--  -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css')}}" />
        <script type="text/javascript" src="{{ asset('/css/chartjs.js') }}"></script>
           <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css -->
                    <link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css')}}" />
                    <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
                    <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
                    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js -->
                    <script type="text/javascript" src="{{ asset('/js/googlecalender.min.js') }}"></script>
     @include('layouts.dataTablesRequiredJS')
    </head>
    <body class="sb-nav-fixed">
       <!-- import sidebar navigation header -->
       @include('partials.navbarheader')
        <div id="layoutSidenav">
           <!-- import left sidebar here -->
                   @include('partials.leftmenubar')
            <div id="layoutSidenav_content">
                 <main>
                <div class="container-fluid">
                    <div style="margin-bottom:2%;margin-top: 2%">
                        <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
                    </div>
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            PMS Room Reservation Filter
                        </div>
                        <div class="card-body">
                              <form method="post" action="/getPMSCustomerNoNightsData">
                                    {{ csrf_field() }}
                                <table width="100%">
                                    <tr>
                                        <td><label>Please select customer:</label></td>
                                        <td><label> Rate Type:</label></td>
                                        <td><label> From Date:</label></td>
                                        <td><label> To Date:</label></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                          <select class="chosen" id="dynamic_select_cust" style="width: 300px" name="selected_customer_id_from_select">
                                            <option <?php if($customerIdFilter=="0") {?> selected <?php }?> value="0">All*</option>
                                              <?php
                                              $i=0;

                                              foreach ($listOutCustomers_ar as $id => $eventcount) {
                                              $customer_name=$listOutCustomers_ar[$i]['name'];
                                              $customer_id=$listOutCustomers_ar[$i]['customer_id'];
                                              if(trim($customer_name)==""){
                                              $customer_name="Customer Name is not Available";
                                              }else{


                                              }

                                              ?>
                                              <option  <?php if($customer_id==$customerIdFilter) {?> selected <?php }?> value="{{$customer_id}}">{{$customer_name}}-{{$customer_id}}</option>
                                              <?php
                                              $i++;
                                              }
                                              ?>
                                              </select>
                                        </td>
                                        <td>
                                            <select class="chosen" id="dynamic_select_ratetype" name="selected_rate_type_from_select">
                                                    <option value="All" <?php if($rateTypeFilter=="All"){?>selected <?php }?>
                                                    >All*</option>
                                              <?php
                                              $i=0;

                                              foreach ($rate_type_list_ar as $id => $eventcount) {
                                              $rate_type_item=$rate_type_list_ar[$i]['rate_type'];
                                              ?>
                                              <option  <?php if($rate_type_item===$rateTypeFilter) {?> selected <?php }?> value="{{$rate_type_item}}">{{$rate_type_item}}</option>
                                              <?php
                                              $i++;
                                              }
                                              ?>
                                              </select>
                                        </td>
                                        <td>
                                            <?php
                                            if($fromDatefromController=="")
                                            {
                                                ?>
                                                <input style="margin-left: 2%;width: 120px" name="fromdate" id="fromDatePMS" required>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <input style="margin-left: 2%;width: 120px" name="fromdate" id="fromDatePMS" value="<?php echo $fromDatefromController; ?>" required>
                                                <?php
                                            }?>
                                        </td>
                                        <td>
                                            <?php
                                            if($toDatefromController=="")
                                            {
                                                ?>
                                                <input style="margin-left: 2%;width: 120px" name="todate" id="toDatePMS" required>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <input style="margin-left: 2%;width: 120px" name="todate" id="toDatePMS" value="<?php echo $toDatefromController; ?>" required >
                                                <?php
                                            }?>
                                        </td>
                                        <td>
                                            <button style="margin-left: 2%" type="submit" class="btn btn-primary" id="btn_submit"  >Submit</button>
                                        </td>
                                    </tr>

                        </table>
                    </form>
                </div>
                    </div>
                    <?php
                    if($resort_suit_customers_pms_no_nights_ar==""){

                }
                else{
                ?>
<div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            PMS Room Reservation
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">CUSTOMER ID</th>
                                            <th class="text-left">CUSTOMER NAME</th>
                                            <th class="text-left">NIGHT</th>
                                            <th class="text-left">MORE DETAIL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                              $i=0;
                                              foreach($resort_suit_customers_pms_no_nights_ar as $id => $resort_suit_customers_pms_no_nights_ar_list)  {
                                              $cust_id=$resort_suit_customers_pms_no_nights_ar[$i]['customer_id'];
                                              $cust_name=$resort_suit_customers_pms_no_nights_ar[$i]['name'];
                                              $night_stayed=$resort_suit_customers_pms_no_nights_ar[$i]['no_night'];
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{$i+1}}</td>
                                            <td class="text-left">{{$cust_id}}</td>
                                            <td class="text-left">{{$cust_name}}</td>
                                            <td class="text-left">{{$night_stayed}}</td>
                                            <td class="text-left"><a href="pmsRoomReservationByCustomerDetail\{{base64_encode($cust_id)}}\{{base64_encode($toDatefromController)}}\{{base64_encode($fromDatefromController)}}\{{base64_encode($rateTypeFilter)}}">View Detail</a></td>
                                        </tr>
                                        <?php
                                                  $i++;
                                                  }
                                                  ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php
            }
            ?>

                </div>
            </main>
    <script>
        $(document).ready(function() {

            $(function() {
                $( "#fromDatePMS" ).datepicker({
                    dateFormat: 'mm-dd-yy',
                });

        })
             $(function() {
                $( "#toDatePMS" ).datepicker({
                    dateFormat: 'mm-dd-yy',
                });

        })
        });
    </script>

            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
<script>
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
    </body>
</html>

