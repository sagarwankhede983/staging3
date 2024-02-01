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
                        <div style="margin-bottom:2%; margin-top: 2%" class="row">
                            <table width="100%">
                              <tr>
                                <td>
                                  <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
                                </td>
                                <td style="text-align:right">
                                      <form method="post" action="/ondateitempageajaxcall">
                                      {{ csrf_field() }}
                                      <div class="container" style="margin-bottom: 2%">
                                      <?php if($date==""){
                                      ?>
                                      <label>Date:</label><input style="margin-left: 1%" name="filterdate" id="demodate" ><button style="margin-left: 1%" type="submit" class="btn btn-primary" id="btn_submit">Submit</button>
                                      <?php
                                      }
                                      else{
                                      ?>
                                      <label>Date:</label><input style="margin-left: 1%" name="filterdate" id="demodate"  value="<?php echo $date;?>"><button style="margin-left: 1%" type="submit" class="btn btn-primary" id="btn_submit" >Submit</button>
                                      <?php
                                      }
                                      ?>
                                      </div>
                                      </form>
                                </td>
                            </tr>
                          </table>
                        </div>
                      <div class="card" style="height: auto !important; margin-top: 1%">
                                  <div class="card-header">
                                      {{ $type }}
                                  </div>
                                  <div class="card-body">
                                      <div class="table-responsive">
                                          <table class="table table-bordered table-striped table-hover datatable">
                                              <thead>
                                                  <tr>
                                                      <th class="text-left">SR.NO.</th>
                                                      <th class="text-left">ITEM ID</th>
                                                      <th class="text-left">ITEM NAME</th>
                                                      <th class="text-left">ITEM DESCRIPTION</th>
                                                      <th class="text-left">ITEM COUNT</th>
                                                      <th class="text-left">DATE</th>
                                                      <th class="text-left">MORE DETAIL</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              <?php
                                              $i=0;
                                              foreach ($data_ar as $id => $eventcount) {
                                                  $itemcount=$data_ar[$i]['eventcount'];
                                                  $item_id=$data_ar[$i]['item_id'];
                                                  $item_name=$data_ar[$i]['item_name'];
                                                  $item_desc_db=$data_ar[$i]['item_desc'];
                                                  if(empty($item_desc_db)){
                                                    $item_desc_db="NA";
                                                  }
                                                  $start_datetime=$data_ar[$i]['start_datetime'];?>
                                                  <tr style="align-content: center">
                                                      <td class="text-left">{{$i+1}}</td>
                                                      <td class="text-left">{{$item_id}}</td>
                                                      <td class="text-left">{{$item_name}}</td>
                                                      <td class="text-left">{{$item_desc_db}}</td>
                                                      <td class="text-left">{{$itemcount}}</td>
                                                      <td class="text-left">{{$start_datetime}}</td>
                                                      <td class="text-left"><a href="/viewDetailFromDashboard\{{base64_encode($item_id)}}\{{base64_encode($item_name)}}\{{base64_encode($item_desc_db)}}\{{base64_encode($start_datetime)}}">View Detail</a></td>
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

    <script>
        $(document).ready(function() {
            $(function() {
                $( "#demodate" ).datepicker({
                    dateFormat: 'mm-dd-yy',
                });
            });
        })
    </script>

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
