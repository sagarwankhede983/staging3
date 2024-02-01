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
        * {
            box-sizing: border-box;
        }

        h3 {
            font-size: 20px;
            text-align: center;
            color: black;
        }

        body {
            background: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ccc;
            padding: 10px;
        }

        input[type=text],
        select,
        textarea {
            width: 100%;
            height: fit-content;
            padding: 12px;
            border: 1px solid #f2f2f2;
            border-radius: 4px;
            resize: vertical;
            height: auto;
            min-height: 20px;
            max-height: 200px;
        }


        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        textarea {
            resize: none;
            overflow: hidden;
            font-weight: normal;
            font-size: 15px;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .col-25 {
            float: left;
            width: 50%;
            margin-top: 6px;
            font-weight: 600;
        }

        .col-40 {
            flex: 1;
            float: right;
            width: 40%;
            margin-top: 10px;
            word-wrap: break-word;
            background: white;
            padding-left: 2%;
            height: 30px;
        }

        .col-50 {
            float: right;
            width: 40%;
            margin-top: 6px;
            height: auto;
            background: white;
        }


        .col-75 {
            float: right;
            width: 75%;
            margin-top: 6px;
        }


        .row::after {
            content: "";
            display: table;
            clear: both;
        }

        @media screen and (max-width: 600px) {

            .col-25,
            .col-75,
            .col-40,
            input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
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
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            <div class="card-header">
                                Hunting Events
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="container">
                                    <h3>Color Title :
                                        {{ $data_ar[0]['type_of_hunt'] . '-' . $data_ar[0]['customer_name'] . '-' . $data_ar[0]['cat_sales_stage'] . '-' . $data_ar[0]['guide_name'] }}
                                    </h3><br>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="cname">Customer Name :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['customer_name'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="cnumber">Customer Contact No. :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['customer_phone_no'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="cstage">Cat Sales Stage :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['cat_sales_stage'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="ctitle">VIP Level :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['vip_level'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="nhunters">Number of Hunters :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ count($data_ar) }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="thunts">Type of Hunts :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['type_of_hunt'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="sdate">Start Date :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['start_datetime'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="edate">End Date :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['end_datetime'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="gid">Guide ID :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['item_id'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="gname">Guide Name :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['guide_name'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="gnumber">Guide Contact No. :</label>
                                        </div>
                                        <div class="col-40">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="hstart">Hunt Start :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['huntstart'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="hend">Hunt End :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>{{ $data_ar[0]['huntend'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="ryear">Reservation Year :</label>
                                        </div>
                                        <div class="col-40">
                                            <?php
                                            $tempTdayDate = explode('-', $data_ar[0]['huntend']);
                                            ?>
                                            <p>{{ $tempTdayDate[2] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-25">
                                            <label for="description">Description :</label>
                                        </div>
                                        <div class="col-40">
                                            <p>
                                                <?php
                                                if ($data_ar[0]['amount'] > 0) {
                                                    echo "$" . $data_ar[0]['amount'] . ' on File ' . $data_ar[0]['txn_date'];
                                                }
                                                ?></p>
                                        </div>
                                    </div>
                                    <br>

                                </div>
                            </div>
                        </div>
                    </div>

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
