<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css')}}" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script type="text/javascript" src="{{ asset('/css/chartjs.js') }}"></script>
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
                        <h1 class="mt-4"></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">King-Ranch</li>
                        </ol>
                    <div style="margin-bottom:2%;margin-left:65%">
                        <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css -->
                        <link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css')}}" />
                        <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
                        <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
                        <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js -->
                        <script type="text/javascript" src="{{ asset('/js/googlecalender.min.js') }}"></script>
                            <form method="post" action="/ondateHuntingDashboardChange">
                            {{ csrf_field() }}
                            <?php if ($todayDate == "")
                            {
                            ?>
                            <label>Date:</label><input style="margin-left: 1%" name="filterdate" id="demodate"><button
                            style="margin-left: 1%" type="submit" class="btn btn-primary" id="btn_submit">Submit</button>
                            <?php
                            }
                            else
                            {
                            ?>
                            <label>Date:</label><input style="margin-left: 1%" name="filterdate" id="demodate"
                            value="<?php echo $todayDate; ?> "><button style="margin-left: 1%" type="submit"
                            class="btn btn-primary" id="btn_submit">Submit</button>
                            <?php
                            }
                            ?>
                            </form>
                    </div>
                    <?php
                        if($todayDate==date('m-d-Y'))
                        {
                    ?>
                        <div class="row">
                            <!-- hunting event count -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #ce9500 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Today's Hunting Event</td>
                                            <td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todayHuntingEventNum_ar[0]['count']}}</span></td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardTodaysHuntingevents\{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Guid Assigned Event Count -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #379457 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Today's Guide Assigned Event</td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardTodaysGuideAssignedHuntingevents\{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Guide Unassigned Event Count -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #f5302e !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Today's Guide Unassigned Event</td>

                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardTodaysUnuideAssignedHuntingevents\{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Guide -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #187da0 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Total Guide</td>
                                            <td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$totalNumGuide_ar[0]['count']}}</span></td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardstotalGuide">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Assigned Guide -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #3333ff !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Assigned Guide</td>
                                            <td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$totalAsignedGuide_ar[0]['count']}}</span></td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardAssignedGuide/{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Unassigned Guide -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #187da0 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Unssigned Guide</td>
                                            <td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$totalNumGuide_ar[0]['count']-$totalAsignedGuide_ar[0]['count']}}</span></td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardUnassignedGuide/{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Todays Reservation Detail -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #f5302e !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Today's Reservation Detail</td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardTodayGuideReservation">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- On Date Reservation Detail -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #379457 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">On Date Reservation Detail</td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardOnDateGuideReservation">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Guide Schedule -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="background-color: #ce9500 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Guide Schedule</td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardGuideShedule">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        else
                        {
                        ?>
                        <div class="row">
                            <!-- hunting event count -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #ce9500 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Hunting Event</td>
                                            <td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todayHuntingEventNum_ar[0]['count']}}</span></td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardTodaysHuntingevents\{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Guid Assigned Event Count -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #379457 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Guide Assigned Event</td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardTodaysGuideAssignedHuntingevents\{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Guide Unassigned Event Count -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #f5302e !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Guide Unassigned Event</td>

                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardTodaysUnuideAssignedHuntingevents\{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Guide -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #187da0 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Total Guide</td>
                                            <td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$totalNumGuide_ar[0]['count']}}</span></td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardstotalGuide">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                             <!-- Assigned Guide -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #3333ff !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Assigned Guide</td>
                                            <td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$totalAsignedGuide_ar[0]['count']}}</span></td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardAssignedGuide/{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Unassigned Guide -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #187da0 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Unssigned Guide</td>
                                            <td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$totalNumGuide_ar[0]['count']-$totalAsignedGuide_ar[0]['count']}}</span></td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardUnassignedGuide/{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                             <!-- Reservation Detail -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #f5302e !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Reservation Detail</td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromdashbordtodayscheduleDashChange/{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- On Date Reservation Detail -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #379457 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">On Date Reservation Detail</td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromdashboardOndateDashboradChange/{{base64_encode($todayDate)}}">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Guide Schedule -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4"   style="background-color: #ce9500 !important">
                                        <div class="card-body">
                                            <table>
                                        <tr>
                                            <td style="text-align: left;width: 10%">Guide Schedule</td>
                                        </tr>
                                             </table>
                                        </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/fromDashboardGuideShedule">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                         <!-- graph -->
                <canvas id="myChart" width="400" height="100"></canvas>
                        <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['Events', 'Guide Assigned Events', 'Guide Unassigned Events', 'Total Guide', 'Assigned Guide', 'Unassigned Guide'],
                                datasets: [{
                                    data: [{{$todayHuntingEventNum_ar[0]['count']}},{{$todayGuidedEventNum_ar[0]['count']}},{{$todayHuntingEventNum_ar[0]['count']-$todayGuidedEventNum_ar[0]['count']}},{{$totalNumGuide_ar[0]['count']}},{{$totalAsignedGuide_ar[0]['count']}},{{$totalNumGuide_ar[0]['count']-$totalAsignedGuide_ar[0]['count']}}],
                                    backgroundColor: [
                                        'rgba(255,20,20,1)',
                                        'rgba(0,255,20,1)',
                                        'rgba(0,20,255,1)',
                                        'rgba(192,192,192,1)',
                                        'rgba(255,255,20,1)',
                                        'rgba(255,20,255,1)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                        </script>
                <script type="text/javascript">
                    window.dataf =
                </script>
                    </div>
                </main>

            </div>
        </div>

    <script>
        $(document).ready(function() {

            $(function() {
                $( "#demodate" ).datepicker({
                    dateFormat: 'mm-dd-yy',
                });
            });
        })
    </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-demo.js"></script>
    </body>
</html>
