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
                       <?php
                        if (empty($dataoftodaysitemstocook_ar)) {?>
                        <div class="card" style="height: auto !important; margin-top: 1%">
                            <div class="card-header">
                            {{ "Item Details" }}
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
                    <th class="text-left">Date</th>
                    <th class="text-left">MORE DETAIL</th>
                    </tr>
                    </thead>
                      <?php  }
 ?>
                                <?php
                                    $i=0;
                                    $event_type="";

                                    foreach($dataoftodaysitemstocook_ar as $data)
                                    {
                                    $itemcount=$dataoftodaysitemstocook_ar[$i]['itemcount'];
                                    $item_id=$dataoftodaysitemstocook_ar[$i]['item_id'];
                                    $item_name=$dataoftodaysitemstocook_ar[$i]['item_name'];
                                    $start_datetime=$dataoftodaysitemstocook_ar[$i]['start_datetime'];
                                    $db_event_type=$dataoftodaysitemstocook_ar[$i]['cat_event_type'];
                                    if(empty($db_event_type))
                                    {
                                    $db_event_type="Other";
                                    }
                                    $item_desc_db=$dataoftodaysitemstocook_ar[$i]['item_desc'];
                                    if(empty($item_desc_db)){
                                    $item_desc_db="NA";
                                    }
                                    if($event_type!=$db_event_type)
                                    {
                                    if($event_type!="")
                                    {
                                ?>

                                </tbody>
                                </table>
                                </div>
                                </div>
                                </div>
                                <?php
                                }
                                $event_type=$db_event_type;
                                $j=0;
                                ?>
                                <div class="card" style="height: auto !important; margin-top: 1%">
                                <div class="card-header">
                                {{$db_event_type}}
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
                                <th class="text-left">Date</th>
                                <th class="text-left">MORE DETAIL</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                }
                                ?>
                                <tr style="align-content: center">
                                <td class="text-left">{{++$j}}</td>
                                <td class="text-left">{{$item_id}}</td>
                                <td class="text-left">{{$item_name}}</td>
                                <td class="text-left">{{$item_desc_db}}</td>
                                <td class="text-left">{{$itemcount}}</td>
                                <td>{{$start_datetime}}</td>
                                <td class="text-left"><a href="/viewDetailFromDashboard\{{base64_encode($item_id)}}\{{base64_encode($item_name)}}\{{base64_encode($item_desc_db)}}\{{base64_encode($start_datetime)}}">View Detail</a></td>
                                </tr>
                                <?php
                                $i=$i+1;
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
