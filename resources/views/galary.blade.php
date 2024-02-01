
<!-- <script type="text/javascript" src="{{ url('/js/calenderdate.js') }}"></script> -->
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
			<style type="text/css">
			.container {
			/*position: relative;*/
			}

			/* Bottom right text */


			.img-wrap {
			display: flex;
			flex-direction: row;
			justify-content: space-around;
			}

			.img { display: block;
			width: 200px;
			height: 100px;
			}
			.alt-wrap {
			display: block;
			position: relative;
			margin: 10px;
			color: whitesmoke;
			border: 1px solid mediumorchid;
			}
			.alt-wrap p.alt {
			position: absolute;
			opacity: 0; /* hide initially */
			left: 0; right: 0; bottom: 0;
			margin: 0;
			padding: 15px;
			font-size: 14px;
			line-height: 22px;
			background-color: rgba(0,0,0,0.8);
			transition: all 300ms ease;
			transition-delay: 300ms;
			}

			.alt-wrap:hover > p.alt {
			opacity: 1;
			transition-delay: 0s;
			}
			.text-block {
			position: absolute;
			/*background-color: black;*/
			color: white;
			font-size: 20px;
			left-padding: 10px;
			margin-left: 30px;
			display:contents;
			background-color: white;

			}
			.para{
			margin-left: 4%;
			background: #169cf5;
			border-radius: 20px;
			width: 15%;
			text-align: center;
			}
			@media only screen and (max-width: 600px) {

			.img {
			width: 200px;
			height: 120px;
			}
			}
			</style>

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
                        	<table style="width:100% !important">
                        		<tr>
                        			<td style="width: 50%"><button class="btn btn-primary" onclick="history.go(-1);">Back </button></td>
                        			<td style="width: 50%;text-align: right;">
                        				<form method="post" action="/gallaryondate">
								{{ csrf_field() }}
								<?php if($date==""){
								?>
								<label>Date:</label><input style="margin-left: 1%" name="filterdate" id="demodate" ><button style="margin-left: 1%" type="submit" class="btn btn-primary" id="btn_submit">Submit</button>
								<?php
								}
								else{
								    ?>
								<label>Date:</label><input style="margin-left: 1%" name="filterdate" id="demodate"  value="<?php echo $date; ?> "><button style="margin-left: 1%" type="submit" class="btn btn-primary" id="btn_submit" >Submit</button>
								<?php
								}
								?>
							</form>
                        			</td>
                        		</tr>
                        	</table>
                        </div>

					      <?php
												$index=0;
												$current_event_type="";
													foreach ($dataoftodaysitemstocook_ar  as $data) {
														$event_type=$dataoftodaysitemstocook_ar[$index]['cat_event_type'];
															if($current_event_type!=$event_type)
															{
																if($current_event_type=="")
																{
																	?>

																	<?php
																}
																$current_event_type=$event_type;
																?>
																			<div class="card" style="height: auto !important; width: auto !important; margin-top:1%">
																				<div class="card-header">{{$event_type}}</div>
																					<div class="card-body">
																						<div class="container" style="align-items: center">
																			<?php
																			$i=0;
																			$k=1;
																	foreach($dataoftodaysitemstocook_ar as $data)
																	{
																		$event_type2=$dataoftodaysitemstocook_ar[$i]['cat_event_type'];
																		$itemcount=$dataoftodaysitemstocook_ar[$i]['itemcount'];
																	    $item_id=$dataoftodaysitemstocook_ar[$i]['item_id'];
																	    $item_name=$dataoftodaysitemstocook_ar[$i]['item_name'];
																	    $item_desc_db=$dataoftodaysitemstocook_ar[$i]['item_desc'];
																	    if($event_type==$event_type2)
																	    {
																			if($k==1 || $k==3)
																			{
																			echo "<div style='display: inline-flex; padding:3px;background-color:rgb(255, 255, 255)'>";
																			}

																			?>
																							<div>
																								<div class="text-block"><p class="para">{{$itemcount}}</p></div>
																								<div>
																									<img class="img" src="/images/{{$item_id}}.jpg" alt="{{$item_name}}({{$item_desc_db}})" value="{{$item_desc_db}}">
																								</div>
																							</div>
																						<?php
																							if($k==1 || $k==3)
																							{
																								echo "</div>";
																							$k=1;
																							}

																		}
																	$i=$i+1;
																	}
																						?>
																				</div>
																				</div>
																				</div>

																<?php
															}
														$index=$index+1;
													}
												?>

                    </div>
                </main>

            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
			<script type="text/javascript">
			$(".img").wrap('<div class="alt-wrap"/>');

			// Add alt text after each .img
			// 1. For all items with class .img...
			// 2. Run a function for each of them...
			// 3. To add a p element after it
			// 5. Containing that element's alt text
			$(".img").each(function() {
			$(this).after('<p class="alt">' + $(this).attr('alt') + '</p>');
			})
			</script>
			<script>
			$(function() {
			$( "#demodate" ).datepicker();
			dateFormat: "yy-dd-mm"
			});

  </script>
    </body>
</html>
