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
                        </div>
                                  <div class="card" style="height: auto !important; margin-top: 1%">
                                      <div class="card-header">
                                          {{ trans('global.dinner') }}
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
                                              foreach ($dinner_ar as $id => $eventcount) {
                                                  $itemcount=$dinner_ar[$i]['itemcount'];
                                                  $item_id=$dinner_ar[$i]['item_id'];
                                                  $item_name=$dinner_ar[$i]['item_name'];
                                                  $item_desc_db=$dinner_ar[$i]['item_desc'];
                                                  if(empty($item_desc_db)){
                                        $item_desc_db="NA";
                                      }
                                                  $start_datetime=$dinner_ar[$i]['start_datetime'];?>
                                                  <tr style="align-content: center">
                                                      <td>{{$i+1}}</td>
                                                      <td>{{$item_id}}</td>
                                                      <td>{{$item_name}}</td>
                                                      <td>{{$item_desc_db}}</td>
                                                      <td>{{$itemcount}}</td>
                                                      <td>{{$start_datetime}}</td>
                                                      <td><a href="/viewDetailFromDashboard\{{base64_encode($item_id)}}\{{base64_encode($item_name)}}\{{base64_encode($item_desc_db)}}\{{base64_encode($start_datetime)}}">View Detail</a></td>
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
