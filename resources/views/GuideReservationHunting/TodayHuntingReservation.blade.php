
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
                                <!-- css start -->
<style>
* {
  box-sizing: border-box;
}
body {
  font-family: Arial, Helvetica, sans-serif;
}
/* Float four columns side by side */
.column-new {
  float: left;
  width: 16.6%;
  padding: 0 10px;
}
/* Remove extra left and right margins, due to padding */
.row-new {margin: 0 -5px;}
/* Clear floats after the columns */
.row-new:after {
  content: "";
  display: table;
  clear: both;
}
/* Responsive columns */
@media screen and (max-width: 600px) {
  .column-new {
    width: 100%;
    height: 150px;
    display: block;
    margin-bottom: 20px;
  }
}
/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial;
}

/* Style tab links */
.tablink {
  background-color: #555;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 33.33%;
}

.tablink:hover {
  background-color: #777;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: white;
  display: none;
  padding: 100px 20px;
  height: auto;
}

#EVENT {background-color: #819b81;}
#AssignedGuide {background-color: #48bfbf;}
#UnassignedGuide {background-color: #4a4c68;}
#About {background-color: orange;}
</style>
     @include('layouts.dataTablesRequiredJS')
     <style>
      .dataTables_scrollHeadInner{
        width: 100% !important;
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

<!-- css end -->
<div style="margin-bottom:2%; margin-top:2%">
<button class="btn btn-primary" onclick="history.go(-1);">Back </button>
</div>
<button class="tablink" onclick="openPage('EVENT', this, '#819b81')">EVENT</button>
<button class="tablink" onclick="openPage('AssignedGuide', this, '#48bfbf')" id="defaultOpen">ASSIGNED GUIDE</button>
<button class="tablink" onclick="openPage('UnassignedGuide', this, '#4a4c68')">AVAILABLE GUIDE</button>

<div id="EVENT" class="tabcontent">
      <div class="card" style="height: auto !important; margin-top: 1%">
          <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover datatable">
                  <thead>
                      <tr>
                          <th class="text-left">SR.NO.</th>
                          <th class="text-left">EVENT ID</th>
                          <th class="text-left">EVENT NAME</th>
                          <th class="text-left">CUSTOMER NAME</th>
                          <th class="text-left">GUIDE ID</th>
                          <th class="text-left">GUIDE NAME</th>
                          <th class="text-left">ROOM</th>
                          <th class="text-left">DATE</th>
                      </tr>
                  </thead>
                  <tbody>
                                  <?php
                                            $i=0;
                                            foreach ($todayHuntingEventInfo_ar as $id => $eventcount) {
                                                $event_id=$todayHuntingEventInfo_ar[$i]['event_id'];
                                                $cat_event_type=$todayHuntingEventInfo_ar[$i]['cat_event_type'];
                                                $item_id=$todayHuntingEventInfo_ar[$i]['item_id'];
                                                $item_name=$todayHuntingEventInfo_ar[$i]['item_name'];
                                                $start_datetime=$todayHuntingEventInfo_ar[$i]['start_datetime'];
                                                $cust_name=$todayHuntingEventInfo_ar[$i]['name'];
                                                $room=$todayHuntingEventInfo_ar[$i]['room'];
                                                  if($item_name=="")
                                                {
                                                  $item_name="NA";
                                                }
                                                if($item_id=="")
                                                {
                                                  $item_id="NA";
                                                }
                                                ?>
                                                <tr style="align-content: center">
                                                    <td class="text-left">{{$i+1}}</td>
                                                    <td class="text-left">{{$event_id}}</td>
                                                    <td class="text-left">{{$cat_event_type}}</td>
                                                    <td class="text-left">{{$cust_name}}</td>
                                                    <td class="text-left">{{$item_id}}</td>
                                                    <td class="text-left">{{$item_name}}</td>
                                                    <td class="text-left">{{$room}}</td>
                                                    <td class="text-left">{{$start_datetime}}</td>
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

<div id="AssignedGuide" class="tabcontent">
      <div class="card" style="height: auto !important; margin-top: 1%">
                <div class="card-body">
                    <div class="table-responsive">
                          <table class="table table-bordered table-striped table-hover datatable">
                              <thead>
                                  <tr>
                                      <th class="text-left">SR.NO.</th>
                                          <th class="text-left">GUIDE ID</th>
                                          <th class="text-left">GUIDE NAME</th>
                                          <th class="text-left">ROOM</th>
                                          <th class="text-left">CUSTOMER NAME</th>
                                          <th class="text-left">DATE</th>
                                  </tr>
                              </thead>
                              <tbody>
                              <?php
                                                        $i=0;
                                                        foreach ($totalAsignedGuideInfo_ar as $id => $eventcount) {
                                                            $item_id=$totalAsignedGuideInfo_ar[$i]['item_id'];
                                                            $item_name=$totalAsignedGuideInfo_ar[$i]['item_name'];
                                                            $start_datetime=$totalAsignedGuideInfo_ar[$i]['start_datetime'];
                                                            $room=$totalAsignedGuideInfo_ar[$i]['room'];
                                                            $name=$totalAsignedGuideInfo_ar[$i]['name'];?>
                                                            <tr style="align-content: center">
                                                                <td class="text-left">{{$i+1}}</td>
                                                                <td class="text-left">{{$item_id}}</td>
                                                                <td class="text-left">{{$item_name}}</td>
                                                                <td class="text-left">{{$room}}</td>
                                                                <td class="text-left">{{$name}}</td>
                                                                <td class="text-left">{{$start_datetime}}</td>
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

<div id="UnassignedGuide" class="tabcontent">

        <div class="card" style="height: auto !important; margin-top: 1%">
                      <div class="card-body">
                          <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                           <th class="text-left">SR.NO.</th>
                                            <th class="text-left">GUIDE ID</th>
                                            <th class="text-left">GUIDE NAME</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                                              $i=0;
                                                              foreach ($totalUnasignedGuideInfo_ar as $id => $eventcount) {
                                                                  $item_id=$totalUnasignedGuideInfo_ar[$i]['item_id'];
                                                                  $item_name=$totalUnasignedGuideInfo_ar[$i]['item_name']; ?>
                                                                  <tr style="align-content: center">
                                                                      <td class="text-left">{{$i+1}}</td>
                                                                      <td class="text-left">{{$item_id}}</td>
                                                                      <td class="text-left">{{$item_name}}</td>
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
      <!-- Tabulatr  -->
<script>

function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

</script>
                    </div>
                </main>

            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
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

