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
			        <div style="margin-bottom:2%;margin-left:75%">
			           	<!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css -->
			           	<link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css')}}" />
			           	<!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
	    				<script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
	    				<!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js -->
	    				<script type="text/javascript" src="{{ asset('/js/googlecalender.min.js') }}"></script>
			                <form method="post" action="/ondatedashboardchange">
			                    {{ csrf_field() }}
			                    <?php if($todayDate==""){
			                    ?>
						<div><label>Date:</label><input style="margin-left: 1%;width: 120px" name="filterdate" id="demodate"><button style="margin-left: 1%" type="submit" class="btn btn-primary" id="btn_submit">Submit</button></div>
			                    <?php
				        	}
				        	else{
				            	?>
			                    	<div><label>Date:</label><input style="margin-left: 1%;width: 120px" name="filterdate" id="demodate" value="<?php echo $todayDate; ?> "><button style="margin-left: 1%" type="submit" class="btn btn-primary" id="btn_submit">Submit</button></div>
			                    <?php
			                        }
			        		?>
			                </form>
			        </div>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                     	<div class="card-body">
                                    		<table>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Today's Menu</td>
			                    			<td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todaymenu}}</span></td>
			                    		</tr>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Item Count</td>
			                    			<td style="text-align: right;width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todayChargebalItemCount_ar}}</span></td>
			                    		</tr>
			                	</table>
			                </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="fromDashboardTodayMenu">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                   	<div class="card-body">
                                    		<table>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Today's Breakfast</td>
			                    			<td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todaybreakfast}}</span></td>
			                    		</tr>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Item Count</td>
			                    			<td style="text-align: right;width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todayChargebalItemCountBre_ar}}</span></td>
			                    		</tr>
			                	</table>
			                </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="fromDashboardTodayBreakfast">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                    		<table>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Today's Lunch</td>
			                    			<td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todaylunch}}</span></td>
			                    		</tr>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Item Count</td>
			                    			<td style="text-align: right;width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todayChargebalItemCountLunch_ar}}</span></td>
			                    		</tr>
			                	</table>
			                </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="fromDashboardTodayLunch">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                	<div class="card-body">
                                    		<table>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Today's Dinner</td>
			                    			<td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todaydinner}}</span></td>
			                    		</tr>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Item Count</td>
			                    			<td style="text-align: right;width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$todayChargebalItemCountDinner_ar}}</span></td>
			                    		</tr>
			                	</table>
			                </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="fromDashboardTodayDinner">View Details</a>
                                        <div class="small text-white"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
			<?php
			$rowcount=0;
			$nextrowcount=0;
			$i=0;
			$j=1;
			foreach($datatodayevent_ar as $event)
			{
			    $item_count=$datatodayevent_ar[$i]['event_count'];
			    $start_datetime=$datatodayevent_ar[$i]['start_datetime'];
			    $event_type=$datatodayevent_ar[$i]['cat_event_type'];
			        if (in_array($event_type, array("Breakfast", "Lunch", "Dinner")))
			        {
			        }
			        else
			        {
			            if(empty($event_type))
			            {
			                $event_type="Other";
			            }
			            ?>
			            <?php
			            if($rowcount==0 || $rowcount%4==0)
			            {

			            ?>
			            <div class="row">
			            <?php
			            }
			            ?>
			            <div class="col-xl-3 col-md-6">
			                <div class="card bg-custom{{$j}} text-white mb-4">
			                    <div class="card-body">
			                    	<table>
			                    		<tr>
			                    			<td style="text-align: left;width: 10%">Today's {{$event_type}}</td>
			                    			<td style="text-align: right; width: 10%"><span style="font-size:15px;font-color:black;font-weight: 1000">{{$item_count}}</span></td>
			                    		</tr>
			                    	</table>
			                    </div>
			                    <div class="card-footer d-flex align-items-center justify-content-between">
			                        <a class="small text-white stretched-link" href="fromDashboardTodayOtherEvent/{{base64_encode($event_type)}}">View Details</a>
			                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
			                    </div>
			                </div>
			            </div>
			             <?php
			              $rowcount=$rowcount+1;
			              $nextrowcount=$nextrowcount+1;
			            if($rowcount==0  || $rowcount%4==0)
			            {
			            ?>
			            </div>
			            <?php

			            }
			            ?>
			            <?php

			            $j=$j+1;
			        }
			    $i=$i+1;
			}
			if($nextrowcount%4==0 || $nextrowcount==0)
			{
			?>
			<div class="row">
				 <div class="col-xl-3 col-md-6">
			                <div class="card bg-custom18 text-white mb-4">
			                    <div class="card-body">On Date Menu</div>
			                    <div class="card-footer d-flex align-items-center justify-content-between">
			                        <a class="small text-white stretched-link" href="fromDashboardOnDateMenu">View Details</a>
			                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
			                    </div>
			                </div>
			            </div>
			             <div class="col-xl-3 col-md-6">
			                <div class="card bg-custom7 text-white mb-4">
			                    <div class="card-body">Weekly Menu
			                    </div>
			                    <div class="card-footer d-flex align-items-center justify-content-between">
			                        <a class="small text-white stretched-link" href="fromDashboardWeeklyMenu">View Details</a>
			                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
			                    </div>
			                </div>
			            </div>
			             <div class="col-xl-3 col-md-6">
			                <div class="card bg-custom40 text-white mb-4">
			                    <div class="card-body">Today's Event</div>
			                    <div class="card-footer d-flex align-items-center justify-content-between">
			                        <a class="small text-white stretched-link" href="fromDashboardEvents">View Details</a>
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
			<div class="col-xl-3 col-md-6">
			                <div class="card bg-custom18 text-white mb-4">
			                    <div class="card-body">On Date Menu</div>
			                    <div class="card-footer d-flex align-items-center justify-content-between">
			                        <a class="small text-white stretched-link" href="fromDashboardOnDateMenu">View Details</a>
			                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
			                    </div>
			                </div>
			            </div>
			            <?php
			            $nextrowcount=$nextrowcount+1;
			            if($nextrowcount%4==0 || $nextrowcount==0){
			            ?>
			</div>
			<div class="row">
						<?php

						}
						?>
						<div class="col-xl-3 col-md-6">
						<div class="card bg-custom7 text-white mb-4">
						<div class="card-body">Weekly Menu
						</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
						<a class="small text-white stretched-link" href="fromDashboardWeeklyMenu">View Details</a>
						<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
						</div>
						</div>
						<?php
						$nextrowcount=$nextrowcount+1;
						if($nextrowcount%4==0 || $nextrowcount==0){
						?>
			</div>
			<div class="row">
			      <?php
				}
				?>
				<div class="col-xl-3 col-md-6">
			                <div class="card bg-custom40 text-white mb-4">
			                    <div class="card-body">Today's Event</div>
			                    <div class="card-footer d-flex align-items-center justify-content-between">
			                        <a class="small text-white stretched-link" href="fromDashboardEvents">View Details</a>
			                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
			                    </div>
			                </div>
			            </div>
			    </div>
				<?php
			}
			?>
                       <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4" style="height: auto !important">
                                    <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Today's Item Count</div>
                                    <div class="card-body"><canvas id="myChartMenus" width="500" height="400"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4" style="height: auto !important">
                                    <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Today's Event Count</div>
                                    <div class="card-body"><canvas id="myChartevents" width="450" height="350"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>

<script type="text/javascript">
    var events = [];
    var eventscount = [];
    var toady_event = [];
    var today_event_count = [];
    <?php
    $i = 0;
    foreach($event_list_ar as $id => $eventcount) {
            $event_type = $event_list_ar[$i]['cat_event_type'];
            $event_count = $event_list_ar[$i]['count'];

            ?>
            eventscount.push('{{$event_count}}');
            events.push('{{$event_type}}');
            <?php
            $i++;
        } ?>
        <?php
    $i = 0;
    foreach($todays_event_data_ar as $id => $eventcount) {
            $today_event = $todays_event_data_ar[$i]['cat_event_type'];
            $today_event_count = $todays_event_data_ar[$i]['count'];
            if ($today_event != 'Side Item') {
                ?>
                toady_event.push('{{$today_event}}');
                today_event_count.push('{{$today_event_count}}');
                <?php
            }
            $i++;
        } ?>
        var ctx = document.getElementById("myChartMenus");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {

            labels: toady_event,

            datasets: [{
                label: 'Menus',
                data: today_event_count,
                backgroundColor: ['#ff8000',
                    '#40ff00',
                    '#ff0040',
                    '#0000ff',
                    '#808080',
                    '#33ccff'
                ],

                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
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
    var ctx = document.getElementById("myChartevents");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: events,
            datasets: [{
                label: 'Menus',
                data: eventscount,
                backgroundColor: ['#ff8000',
                    '#40ff00',
                    '#ff0040',
                    '#0000ff',
                    '#808080',
                    '#33ccff'
                ],

                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
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
