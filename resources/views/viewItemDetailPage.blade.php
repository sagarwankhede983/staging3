

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
                                    Detail
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover datatable">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">SR.NO</th>
                                                    <th class="text-left">EVENT ID</th>
                                                    <th class="text-left">EVENT</th>
                                                    <th class="text-left">CUSTOMER NAME</th>
                                                    <th class="text-left">ROOM</th>
                                                    <th class="text-left">ITEM</th>
                                                    <th class="text-left">COUNT</th>
                                                    <th class="text-left">DATE</th>
                                                    <th class="text-left">START TIME</th>
                                                    <th class="text-left">END TIME</th>
                                                    <th class="text-left">CUSTOMER DETAIL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                        $i=0;
                                        foreach ($data_ar as $id => $eventcount) {
                                            $itemcount=$data_ar[$i]['itemcount'];
                                            $date=$data_ar[$i]['dateofevent'];
                                            $start_time=$data_ar[$i]['eventstarttime'];
                                            $end_time=$data_ar[$i]['eventendtime'];
                                            $event_id=$data_ar[$i]['event_id'];
                                            $cat_event_type=$data_ar[$i]['cat_event_type'];
                                            $name=$data_ar[$i]['name'];
                                            $room=$data_ar[$i]['room'];
                                            $item_id=$data_ar[$i]['item_id'];
                                            $customer_id=$data_ar[$i]['customer_id'];
                                            $item_name=$data_ar[$i]['item_name'];?>
                                                <tr style="align-content: center">
                                                    <td>{{$i+1}}</td>
                                                    <td>{{$event_id}}</td>
                                                    <td>{{$cat_event_type}}</td>
                                                    <td>{{$name}}</td>
                                                    <td>{{$room}}</td>
                                                    <td>{{$item_name}}</td>
                                                    <td>{{$itemcount}}</td>
                                                    <td>{{$date}}</td>
                                                    {{-- Miltary date format change start 25/09/2023 --}}
                                                    <td nowrap>{{$start_time}}</td>
                                                    <td nowrap>{{$end_time}}</td>
                                                    {{-- Miltary date format change end 25/09/2023 --}}
                                                    <td><a href="/viewCustomerDetailFromItemDetail\{{base64_encode($customer_id)}}\{{base64_encode($date)}}">View Detail</a></td>
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
