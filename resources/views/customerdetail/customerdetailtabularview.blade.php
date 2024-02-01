
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
        <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
        <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
     @include('layouts.dataTablesRequiredJS')
     <style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #2f353a;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: blue;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: yellowgreen;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
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
                    <div class="container-fluid">
                        <div style="margin-bottom:2%;margin-top: 2%">
                            <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
                        </div>
                        <div style="margin-bottom:2%">
                            <select class="chosen" id="dynamic_select">
                            <?php
                            $i=0;

                            foreach ($customer_on_date_ar as $id => $eventcount) {
                            $alldates=$customer_on_date_ar[$i]['alldates'];
                            ?>

                            <option <?php if($alldates===$date) {?> selected <?php }?>> {{$alldates}}</option>

                            <?php
                            $i++;
                            }
                            ?>
                            </select>
                            <input type="hidden" value="<?php echo $customer_id; ?>" name="customer_id" id="customer_id"/>
                        </div>
                        <div class="card" style="height: auto !important; margin-top: 1%">
                            <div class="card-header">
                                Event Detail
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-left">SR.NO.</th>
                                                <th class="text-left">EVENT ID</th>
                                                <th class="text-left">CUSTOMER NAME</th>
                                                <th class="text-left">ROOM</th>
                                                <th class="text-left">DATE</th>
                                                <th class="text-left">EVENT TYPE</th>
                                                <th class="text-left">START TIME</th>
                                                <th class="text-left">END TIME</th>
                                                <th class="text-left">EXP. GUESTS</th>
                                                <th class="text-left">GTD. GUESTS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                           $i=0;
                                           foreach ($customer_data_ar as $id => $eventcount) {
                                               $event_id=$customer_data_ar[$i]['event_id'];
                                               $event=$customer_data_ar[$i]['name'];
                                               $room=$customer_data_ar[$i]['room'];
                                               $date=$customer_data_ar[$i]['start_datetime'];
                                               $event_type=$customer_data_ar[$i]['cat_event_type'];
                                               if(empty($event_type))
                                               {
                                                 $event_type="Other";
                                               }
                                               $start_time=$customer_data_ar[$i]['start_time'];
                                               $end_time=$customer_data_ar[$i]['end_time'];
                                               $expguests=$customer_data_ar[$i]['qty_est'];
                                               $gtdguests=$customer_data_ar[$i]['qty_gtd'];
                                            ?>
                                            <tr style="align-content: center">
                                                <td class="text-left">{{$i+1}}</td>
                                                <td class="text-left">{{$event_id}}</td>
                                                <td class="text-left">{{$event}}</td>
                                                <td class="text-left">{{$room}}</td>
                                                <td class="text-left">{{$date}}</td>
                                                <td class="text-left">{{$event_type}}</td>
                                                {{-- Miltary time format change start 25/09/2023--}}
                                                <td nowrap class="text-left">{{$start_time}}</td>
                                                <td nowrap class="text-left">{{$end_time}}</td>
                                                {{-- Miltary time format change end 25/09/2023--}}
                                                <td class="text-left">{{$expguests}}</td>
                                                <td class="text-left">{{$gtdguests}}</td>
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
                        <div class="card" style="height: auto !important; margin-top: 1%">
                            <div class="card-header">
                                <h4>More Detail</h4>
                            </div>
                            <div class="tab">
                                <?php
                                $i=0;
                                $event_type="";
                                foreach($customer_event_data_ar as $data){
                                  $db_event_type=$customer_event_data_ar[$i]['cat_event_type'];
                                  if(empty($db_event_type)){
                                          $db_event_type="Other";
                                        }
                                  if($event_type!=$db_event_type)
                                  {
                                  ?>
                                  <button class="tablinks" onclick="openCity(event, '{{$db_event_type}}')"><font style="color: white">{{$db_event_type}}</font></button>
                                <?php
                                $event_type=$db_event_type;
                                  }
                                $i++;
                                }
                                ?>

                            </div>
                              <?php
                              $k=0;
                              $event_type_previous="";
                                foreach ($customer_event_data_ar as $id => $eventcount) {
                                      $event_type=$customer_event_data_ar[$k]['cat_event_type'];
                                      if(empty($event_type)){
                                        $event_type="Other";
                                      }
                                      if($event_type_previous!=$event_type)
                                      {


                              ?>
                          <div id="{{$event_type}}" class="tabcontent">


                            <?php
                              $i=0;
                              $previous_event_id="";
                              foreach ($customer_event_data_ar as $id => $eventcount) {
                                  $event_id=$customer_event_data_ar[$i]['event_id'];
                                  $event=$customer_event_data_ar[$i]['name'];
                                  $room=$customer_event_data_ar[$i]['room'];
                                  $date=$customer_event_data_ar[$i]['start_datetime'];
                                  $event_type_compare=$customer_event_data_ar[$i]['cat_event_type'];
                                  $start_time=$customer_event_data_ar[$i]['start_time'];
                                  $end_time=$customer_event_data_ar[$i]['end_time'];
                                  $expguests=$customer_event_data_ar[$i]['qty_est'];
                                  $gtdguests=$customer_event_data_ar[$i]['qty_gtd'];
                                  $item_name=$customer_event_data_ar[$i]['item_name'];
                                  $item_desc=$customer_event_data_ar[$i]['item_desc'];
                                  $count=$customer_event_data_ar[$i]['qty'];

                                  if(empty($event_type_compare))
                                  {
                                      $event_type_compare="Other";
                                  }
                                  ?>

                                  <div>
                                    <table style="width:100%">
                                    <?php
                                        if($event_type_compare==$event_type)
                                        {
                                          ?>

                                    <?php
                                      if($event_id!=$previous_event_id)
                                      {
                                    ?>
                                      <tr>
                                      <td style="width: 50%"><p>ROOM : {{$room}}</p></td>
                                      <td style="text-align: right">Time : {{$start_time}}-{{$end_time}}</td>
                                      </tr>
                                    <?php
                                      }
                                      else{
                                        ?>
                                        <tr>
                                      <td style="width: 50%"></td>
                                      <td style="text-align: right"><br></td>
                                      </tr>
                                        <?php
                                      }
                                    ?>
                                      <tr><td></td><td></td></tr>
                                      <tr><td></td><td></td></tr>
                                      <tr><td></td><td></td></tr>
                                      <tr><td></td><td></td></tr>
                                      <tr><td></td><td>{{$item_name}}({{$count}})
                                      <br><font style="size:10px">{{$item_desc}}</font>
                                      <br>*****</td></tr>

                                          <?php
                                        }
                                    ?>
                                    </table>
                                  </div>
                            <?php
                            $i++;
                            $previous_event_id=$event_id;
                              }
                            ?>
                          </div>
                          <?php
                          $event_type_previous=$event_type;
                                  }
                                  $k++;
                            }
                          ?>
                          </div>

                    </div>
                </main>

            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../js/scripts.js"></script>
        <script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
        <script>
  $(function(){
      $('#dynamic_select').on('change', function () {
          var selected_id = $(this).val(); // get selected value
          var customer_id=$('#customer_id').val();
          //alert(customer_id);
            window.location = "/viewCustomerDetailFromItemDetail/"+btoa(customer_id)+"/"+btoa(selected_id);
              // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

      });
    });
</script>
<script>
   // $(function() {

    //     let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    //     alert(dtButtons);
    //     $('.datatable:not(.ajaxTable)').DataTable({
    //         buttons: dtButtons
    //     })
    // })
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>

    </body>
</html>
