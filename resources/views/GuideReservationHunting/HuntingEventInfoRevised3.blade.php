<!DOCTYPE html>
<html lang="en">

<head>
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
        .container1 {
        display: flex;
        justify-content: space-between;
        align-items: center;
    },

    .left {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
    },

    .right {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
    },
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
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css') }}" />
    <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.min.js') }}"></script>
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
                    <div class="container1"
                        style="margin-bottom:2%;margin-top: 2%;padding-left:1.5rem;padding-right:1.5rem">
                        <div class="left">
                            <div class="child">
                        <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
                    </div>
                </div>
                <div class="right">
                            <form method="post" action="/ondateHuntingFromPageRevised">
                                {{ csrf_field() }}
                                {{-- <div class="container"> --}}
                                    <?php $dateP = $data_ar[0]['start_datetime'];
                                    $date = strtok($dateP, ' '); ?>
                                    <?php if($date==""){
                                    ?>
                                    <label>Date:</label><input name="date"
                                        id="demodate"><button type="submit"
                                        class="btn btn-primary" id="btn_submit">Submit</button>
                                    <?php
                                    }
                                    else{
                                    ?>
                                    <label>Date:</label><input name="date" id="demodate"
                                        value="<?php echo $date; ?>"><button type="submit"
                                        class="btn btn-primary" id="btn_submit">Submit</button>
                                    <?php
                                    }
                                    ?>
                                {{-- </div> --}}
                            </form>
                        </div>
                    </div>
                    <?php
                    $i=0;
                    if($data_ar[0]['customer_name'] != NULL){
                        foreach($data_ar as $id => $eventcount){
                            // for($i=0;$i<count($data_ar);$i++){
                        ?>
                    <div class="card" style="height: auto !important;">

                        <div>
                            <div style="background-color:#20a8d8; color:#ffffff;padding: 2%">
                                <thead>
                                    <td>Color Title</td>
                                    <td>{{ $data_ar[0]['type_of_hunt'] . '-' . $data_ar[0]['customer_name'] . '-' . $data_ar[0]['cat_sales_stage'] . '-' . $data_ar[0]['guide_name'] }}
                                    </td>
                                </thead>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="detailTable">
                                    <tbody>
                                        <tr>
                                            <td>Title</td>
                                            <td>{{ $data_ar[0]['customer_name'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sales Stages</td>
                                            <td>{{ $data_ar[0]['cat_sales_stage'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Number of Hunters</td>
                                            <td>{{ count($data_ar) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Start Time</td>
                                            <td>{{ $data_ar[0]['start_datetime'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>End Time</td>
                                            <td>{{ $data_ar[0]['end_datetime'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Type of Hunt</td>
                                            <td>{{ $data_ar[0]['type_of_hunt'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hunt Guide</td>
                                            <td>{{ $data_ar[0]['guide_name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>{{ $data_ar[0]['customer_phone_no'] }}<br>
                                                <?php
                                                if ($data_ar[0]['amount'] != 'NA') {
                                                    echo "$" . $data_ar[0]['amount'] . ' on File ' . $data_ar[0]['txn_date'];
                                                } else {
                                                    echo 'NA';
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Hunt Start</td>
                                            <td>{{ $data_ar[0]['huntstart'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hunt End</td>
                                            <td>{{ $data_ar[0]['huntend'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Folio Id</td>
                                            <td>{{ $data_ar[0]['folio_id'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Room</td>
                                            <td>{{ $data_ar[0]['room'] }}</td>
                                        </tr>
                                        <tr>
                                            <?php
                                            $tempTdayDate = explode("-", $data_ar[0]['huntend']);
                                            if($tempTdayDate[0] == ""){
                                                $year = 'NA';
                                            }else{
                                                $year = $tempTdayDate[2];
                                            }
                                            ?>
                                            <td>Reservation Year</td>
                                            <td>{{ $year }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><br>
                    <?php  }}else{ ?>
                    <div>
                        <div style="background-color:#20a8d8; color:#ffffff;padding: 2%">
                            <table>
                                <thead>
                                    <td>No Data Found.</td>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </main>
        </div>
        {{-- @include('partials.rightmenubarrevised') --}}
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../js/scripts.js"></script>
    <script>
        $(document).ready(function() {

            $(function() {
                $("#demodate").datepicker({
                    dateFormat: 'mm-dd-yy',
                });
            });
        })
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
