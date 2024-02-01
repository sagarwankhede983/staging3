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
                            PMS Room Reservation
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">ARRIVAL DATE</th>
                                            <th class="text-left">DEPARTURE DATE</th>
                                            <th class="text-left">NIGHT</th>
                                            <th class="text-left">ROOM NUMBER</th>
                                            <th class="text-left">ROOM TYPE</th>
                                            <th class="text-left">CHECKIN DATE</th>
                                            <th class="text-left">CHECKOUT DATE</th>
                                            <th class="text-left">FOLIO ID</th>
                                            <th class="text-left">FOLIO STATUS</th>
                                            <th clss="text-left">RATE TYPE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                              $i=0;
                                              foreach($pms_room_reservation_against_customer_ar as $id => $pms_room_reservation_against_customer_ar_list)  {
                                              $checkinDate=$pms_room_reservation_against_customer_ar[$i]['checkin_date'];
                                              $checkoutDate=$pms_room_reservation_against_customer_ar[$i]['checkout_date'];
                                              $nights=$pms_room_reservation_against_customer_ar[$i]['num_nights'];
                                              $roomNumber=$pms_room_reservation_against_customer_ar[$i]['room_number'];
                                              $roomType=$pms_room_reservation_against_customer_ar[$i]['room_type'];
                                              $folioId=$pms_room_reservation_against_customer_ar[$i]['folio_id'];
                                              $folioStatus=$pms_room_reservation_against_customer_ar[$i]['folio_status'];
                                               $rateType=$pms_room_reservation_against_customer_ar[$i]['rate_type'];
                                              $arrivalDate=$pms_room_reservation_against_customer_ar[$i]['arrival_date'];
                                              $departureDate=$pms_room_reservation_against_customer_ar[$i]['departure_date'];
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{$i+1}}</td>
                                            <td class="text-left">{{$arrivalDate}}</td>
                                            <td class="text-left">{{$departureDate}}</td>
                                            <td class="text-left">{{$nights}}</td>
                                            <td class="text-left">{{$roomNumber}}</td>
                                            <td class="text-left">{{$roomType}}</td>
                                            <td class="text-left">{{$checkinDate}}</td>
                                            <td class="text-left">{{$checkoutDate}}</td>
                                            <td class="text-left">{{$folioId}}</td>
                                            <td class="text-left">{{$folioStatus}}</td>
                                            <td class="text-left">{{$rateType}}</td>
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

