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
                            Catering Room Reservation
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">CUSTOMER ID</th>
                                            <th class="text-left">CUSTOMER NAME</th>
                                            <th class="text-left">MARKET CODE</th>
                                            <th class="text-left">EVENT ID</th>
                                            <th class="text-left">EVENT TYPE</th>
                                            <th class="text-left">ROOM</th>
                                            <th class="text-left">NIGHT</th>
                                            <th class="text-left">START DATE</th>
                                            <th class="text-left">END DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                              $i=0;
                                              foreach($resort_suit_customers_cat_no_nights_ar as $id => $resort_suit_customers_cat_no_nights_ar_list)  {
                                              $custId=$resort_suit_customers_cat_no_nights_ar[$i]['customer_id'];
                                              $name=$resort_suit_customers_cat_no_nights_ar[$i]['name'];
                                              $vipLevel=$resort_suit_customers_cat_no_nights_ar[$i]['vip_level'];
                                              $eventId=$resort_suit_customers_cat_no_nights_ar[$i]['event_id'];
                                              $eventType=$resort_suit_customers_cat_no_nights_ar[$i]['cat_event_type'];
                                              $room=$resort_suit_customers_cat_no_nights_ar[$i]['room'];
                                              $dateDiff=$resort_suit_customers_cat_no_nights_ar[$i]['datediff'];
                                              $startDate=$resort_suit_customers_cat_no_nights_ar[$i]['start_datetime'];
                                              $endDate=$resort_suit_customers_cat_no_nights_ar[$i]['end_datetime'];
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{$i+1}}</td>
                                            <td class="text-left">{{$custId}}</td>
                                            <td class="text-left">{{$name}}</td>
                                            <td class="text-left">{{$vipLevel}}</td>
                                            <td class="text-left">{{$eventId}}</td>
                                            <td class="text-left">{{$eventType}}</td>
                                            <td class="text-left">{{$room}}</td>
                                            <td class="text-left">{{$dateDiff}}</td>
                                            <td class="text-left">{{$startDate}}</td>
                                            <td class="text-left">{{$endDate}}</td>
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

                </div>
            </main>

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

