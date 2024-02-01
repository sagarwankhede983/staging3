<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        window.addEventListener('beforeunload',function(){
            window.location.reload();
        })
    </script>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}" />
    <script type="text/javascript" src="{{ asset('/css/chartjs.js') }}"></script>
    <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
    @include('layouts.dataTablesRequiredJS')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #F5F5F5;
        }

        table {
            width: fit-content;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 3px;
            text-align: left;
            border-bottom: 1px solid #ddd;
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
                    <div style="margin-bottom:2%;">
                        <button class="btn btn-primary" onclick="history.go(-1);Location.reload(true);">Back </button>
                    </div>
                    <div class="card" style="height: auto !important;">

                            <div class="card-header" style="background-color:#20a8d8; color:#ffffff;padding: 2%">
                                {{-- <h4>Hunt Details</h4> --}}
                                <thead>
                                    <td>Hunt Details</td>
                                </thead>
                            </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Event Id</td>
                                            <td>{{ $data_ar[0]['event_id']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Folio Id</td>
                                            <td>{{ $data_ar[0]['group_folio_id']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Customer Name</td>
                                            <td>{{ $data_ar[0]['customer_name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sales Stage</td>
                                            <td>{{ $data_ar[0]['cat_sales_stage'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Market Code</td>
                                            <td> <?php
                                                if($data_ar[0]['market_code'] != null){
                                                    ?>
                                                    {{ $data_ar[0]['market_code'] }}<br>
                                                    <?php

                                                }else{
                                                    echo "NA";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td># Hunter</td>
                                            <td>{{ count($data_ar) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Event Start DateTime</td>
                                            {{-- Miltary date format change start 26/09/2023 --}}
                                            <td><?php
                                            if($data_ar[0]['start_datetime'] == ""){
                                                echo 'NA';
                                            }else{
                                                // $tempTdayDate = explode(":", $data_ar[0]['start_datetime']);
                                                echo $data_ar[0]['start_datetime'];
                                            }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Event End DateTime</td>
                                            <td>
                                                <?php
                                            if($data_ar[0]['end_datetime'] == ""){
                                                echo 'NA';
                                            }else{
                                                // $tempTdayDate = explode(":", $data_ar[0]['end_datetime']);
                                                echo $data_ar[0]['end_datetime'];
                                            }
                                                ?>
                                                {{-- Miltary date format change end 26/09/2023 --}}
                                        </tr>
                                        <tr>
                                            <td>Hunt Start</td>
                                            <td>{{ $data_ar[0]['huntstart'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hunt End</td>
                                            <td>
                                                <?php
                                                if($data_ar[0]['huntend'] != null){
                                                    ?>
                                                    {{ $data_ar[0]['huntend'] }}<br>
                                                    <?php

                                                }else{
                                                    echo "NA";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Type of Hunt</td>
                                            <td>{{ $data_ar[0]['type_of_hunt'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hunt Guide</td>
                                            <td>
                                                <?php
                                                if($data_ar[0]['guide_name'] != null){
                                                    ?>
                                                    {{ $data_ar[0]['guide_name'] }}<br>
                                                    <?php

                                                }else{
                                                    echo "NA";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>
                                                <?php
                                                if($data_ar[0]['amount'] != "NA"){
                                                    ?>
                                                    {{ $data_ar[0]['customer_phone_no'] }}<br>
                                                    <?php
                                                    echo "$".$data_ar[0]['amount']." on File ".$data_ar[0]['txn_date'];
                                                }else{
                                                    echo "NA";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Color Title</td>
                                            <td>
                                                <?php
                                                $tempTdayDate = explode("-", $data_ar[0]['huntstart']);
                                                if($data_ar[0]['guide_name'] != NULL){
                                                    $color = $data_ar[0]['type_of_hunt'] . '-' . $data_ar[0]['customer_name'] . '-' . $data_ar[0]['cat_sales_stage'] . '-' . $data_ar[0]['guide_name'];
                                                }else{
                                                    $color = $data_ar[0]['type_of_hunt'] . '-' . $data_ar[0]['customer_name'] . '-' . $data_ar[0]['cat_sales_stage'] . '-' . 'NA';
                                                }
                                                ?>
                                                {{ $color }}</td>
                                        </tr>
                                        <tr>
                                            <td>Room</td>
                                            <td>{{ $data_ar[0]['room']}}</td>
                                        </tr>
                                        <tr>
                                            <?php
                                            $tempTdayDate = explode("-", $data_ar[0]['huntstart']);
                                            if($tempTdayDate[0] == ""){
                                                $year = 'NA';
                                            }else{
                                                $year = $tempTdayDate[2];
                                            }
                                            ?>
                                            <td>Reservation Year</td>
                                            <td>{{ $year}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <form action="{{ url('/oncalenderhuntingeventsinforevised1/01-05-2023') }}" method="get">
                            <button onclick="">Detail Page 1</button>
                        </form> --}}
                    </div>
                    <br>
                </div>
            </main>

        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
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
