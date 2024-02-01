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
<style>
html,
body {
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
}

#hideMe {
    -moz-animation: cssAnimation 0s ease-in 5s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 5s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 5s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 5s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

@keyframes cssAnimation {
    to {
        width: 0;
        height: 0;
        overflow: hidden;
    }
}

@-webkit-keyframes cssAnimation {
    to {
        width: 0;
        height: 0;
        visibility: hidden;
    }
}
</style>

<body class="sb-nav-fixed">
    <!-- import sidebar navigation header -->
    @include('partials.navbarheader')
    <div id="layoutSidenav">
        <!-- import left sidebar here -->
        @include('partials.leftmenubar')
        <div id="layoutSidenav_content">
            <main>
               <div class="container-fluid">
                <div class="container-fluid">
                    <div style="margin-bottom:2%;margin-top: 2%">
                        <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
                    </div>
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            PMS Charge By Code Filter
                        </div>
                        <div class="card-body">
                              <form method="post" action="/getpmschargebycodefoliodetailsonsubmitclick">
                                    {{ csrf_field() }}
                                <table width="100%">
                                    <tr>
                                        <td><label> From Date:</label></td>
                                        <td><label> To Date:</label></td>
                                        <td><label>Charge Code</label></td>
                                        <td></td>
                                    </tr>
                                    <tr>

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
                                            <select class="chosen" id="pms_charge_code_filter" style="width: 300px" name="pms_charge_code_filter">
                                            <option value="All" <?php if($pmsChargeCodeFilter=="All"){?> selected <?php } ?>>All*</option>
                                              <?php
                                              $i=0;

                                              foreach ($pms_charge_code_list_ar as $id => $eventcount) {
                                              $charge_code=$pms_charge_code_list_ar[$i]['charge_code'];
                                                                                            ?>
                                              <option  <?php if($pmsChargeCodeFilter==$charge_code) { ?> selected <?php }?> value="{{$charge_code}}" >{{$charge_code}}</option>
                                              <?php
                                              $i++;
                                              }
                                              ?>
                                              </select>
                                        </td>
                                        <td>
                                            <button style="margin-left: 2%" type="submit" class="btn btn-primary" id="btn_submit"  >Submit</button>
                                        </td>
                                    </tr>

                        </table>
                    </form>
                </div>
            </div>
                <?php if($pms_charge_by_code_detail_info_ar!=""){ ?>
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                           PMS Charge By Code
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">FOLIO</th>
                                            <th class="text-left">RESERVE UNDER</th>
                                            <th class="text-left">RESERVE UNDER ID</th>
                                            <th class="text-left">PAID BY FOLIO</th>
                                            <th class="text-left">PAID BY </th>
                                            <th class="text-left">PAID BY ID</th>
                                            <th class="text-left">MEMBER</th>
                                            <th class="text-left">DATE</th>
                                            <!-- <th class="text-left">ITEM NAME</th> -->
                                            <th class="text-left">STAFF</th>
                                            <th class="text-left">AMMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          <?php

                                              $i=0;
                                              foreach($pms_charge_by_code_detail_info_ar as $id => $pms_charge_by_code_detail_info_ar_list)  {
                                              $folio_id=$pms_charge_by_code_detail_info_ar[$i]['folio_id'];
                                              $cust_name_res=$pms_charge_by_code_detail_info_ar[$i]['name'];
                                              $cust_id_res=$pms_charge_by_code_detail_info_ar[$i]['folio_customer_id'];
                                              $folio_id_paid=$pms_charge_by_code_detail_info_ar[$i]['app_folio_id'];
                                              $cust_name_paid=$pms_charge_by_code_detail_info_ar[$i]['customer_name_paid'];
                                              $cust_id_paid=$pms_charge_by_code_detail_info_ar[$i]['customer_id_paid'];
                                              $member=$pms_charge_by_code_detail_info_ar[$i]['customer_code'];
                                              $date=$pms_charge_by_code_detail_info_ar[$i]['folio_operating_day'];

                                              $staff_name=$pms_charge_by_code_detail_info_ar[$i]['staff_name'];
                                              $ammount=$pms_charge_by_code_detail_info_ar[$i]['ammount'];

                                                if($cust_name_res!=""){}
                                                else{
                                              $cust_name_res="NA";
                                                }
                                                if($cust_id_res!=""){}
                                                else{
                                              $cust_id_res="NA";
                                                }
                                                if($folio_id_paid!=""){}
                                                else{
                                                $folio_id_paid="NA";
                                                }
                                                if($cust_name_paid!=""){}
                                                else{
                                                $cust_name_paid="NA";
                                                }
                                                if($cust_id_paid!=""){}
                                                else{
                                                $cust_id_paid="NA";
                                                }
                                                if($member!=""){}
                                                else{
                                                $member="NA";
                                                }
                                                if($date!=""){}
                                                else{
                                                $date="NA";
                                                }
                                                if($staff_name!=""){}
                                                else{
                                                $staff_name="NA";
                                                }
                                                if($ammount!=""){}
                                                else{
                                                $ammount="0";
                                                }
                                              ?>

                                        <tr style="align-content: center">
                                            <td class="text-left">{{$i+1}}</td>
                                            <td class="text-left">{{$folio_id}}</td>
                                            <td class="text-left">{{$cust_name_res}}</td>
                                            <td class="text-left">{{$cust_id_res}}</td>
                                            <td class="text-left">{{$folio_id_paid}}</td>
                                            <td class="text-left">{{$cust_name_paid}}</td>
                                            <td class="text-left">{{$cust_id_paid}}</td>
                                            <td class="text-left">{{$member}}</td>
                                            <td class="text-left">{{$date}}</td>
                                            <td class="text-left">{{$staff_name}}</td>
                                            <td class="text-left">{{$ammount}}</td>
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
                    <?php } ?>
                </div>
            </main>

            <script>
            $(document).ready(function() {
                $(function() {
                    $("#demodate").datepicker({
                        dateFormat: 'mm-dd-yy',
                    });
                });
            })
            </script>

        </div>
    </div>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../js/scripts.js"></script>
    <script>
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excelHtml5', 'pdf', 'print'
        ]
    });

    </script>
</body>

</html>
