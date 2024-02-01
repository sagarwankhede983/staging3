
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
                              <label style="margin-left:50%">Please select guide :</label><select class="chosen" id="dynamic_select" style="margin-left:2%">
                              <?php
                              $i=0;

                              foreach ($listOfAllTheGuides_ar as $id => $eventcount) {
                              $item_name=$listOfAllTheGuides_ar[$i]['item_name'];
                              $item_id=$listOfAllTheGuides_ar[$i]['item_id'];
                              ?>
                              <option  <?php if($guide_id===$item_id) {?> selected <?php }?> value="{{$item_id}}">{{$item_name}}</option>
                              <?php
                              $i++;
                              }
                              ?>
                              </select>
                        </div>
                                <div class="card" style="height: auto !important; margin-top: 1%">
                                   <div class="card-header">
                                        Cocktails
                                    </div>
                                    <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover datatable">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">SR.NO.</th>
                                                    <th class="text-left">ITEM ID</th>
                                                    <th class="text-left">ITEM NAME</th>
                                                    <th class="text-left">EVENT ID</th>
                                                    <th class="text-left">EVENT</th>
                                                    <th class="text-left">CUSTOMER NAME</th>
                                                    <th class="text-left">ROOM</th>
                                                    <th class="text-left">DATE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i=0;
                                            foreach ($guideshedule_ar as $id => $eventcount) {
                                                $item_id=$guideshedule_ar[$i]['item_id'];
                                                $item_name=$guideshedule_ar[$i]['item_name'];
                                                $event_id=$guideshedule_ar[$i]['event_id'];
                                                $event_type=$guideshedule_ar[$i]['cat_event_type'];
                                                $start_datetime=$guideshedule_ar[$i]['start_datetime'];
                                                $name=$guideshedule_ar[$i]['name'];
                                                $room=$guideshedule_ar[$i]['room'];
                                                ?>
                                                <tr style="align-content: center">
                                                    <td class="text-left">{{$i+1}}</td>
                                                    <td class="text-left">{{$item_id}}</td>
                                                    <td class="text-left">{{$item_name}}</td>
                                                    <td class="text-left">{{$event_id}}</td>
                                                    <td class="text-left">{{$event_type}}</td>
                                                    <td class="text-left">{{$name}}</td>
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
                </main>

            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
<script>
   $(function(){
      $('#dynamic_select').on('change', function () {
          var selected_id = $(this).val();
          //alert(customer_id);
            window.location = "/getGuideShedule/"+btoa(selected_id);
              // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

      });
    });
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
