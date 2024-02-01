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
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css') }}" />
    <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.min.js') }}"></script>
    @include('layouts.dataTablesRequiredJS')
    <style>
        .container1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }

        .right {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
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
                    <div class="container1"
                        style="margin-bottom:2%;margin-top: 2%;padding-left:1.5rem;padding-right:1.5rem">
                        <div class="left">
                            <div class="child">
                                <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
                            </div>
                        </div>
                        <?php $dateP = $fromdate;
                        $date = strtok($dateP, ' '); ?>
                        <?php if($date==""){
                                            ?>
                        <label>From Date:<br>
                            <input name="dateF" id="demodateF" style="width: 100px;">&nbsp;&nbsp;</label>
                        <label>To Date:<br>
                            <input name="dateT" id="demodateT" style="width: 100px;">&nbsp;&nbsp;</label>
                        <?php
                                        }
                                        else{
                                            ?>
                        <label>From Date:<br>
                            <input name="dateF" id="demodateF" value="<?php echo $date; ?>"
                                style="width: 130px;">&nbsp;&nbsp;</label>
                        <label>To Date:<br>
                            <input name="dateT" id="demodateT" value="<?php echo $todate; ?>"
                                style="width: 130px;">&nbsp;&nbsp;</label>
                        <?php
                                        }
                                        ?>
                        <div>
                            <label>Guide :&nbsp;<br><select class="chosen" id="dynamic_select" style="width:200px">
                                    <?php
                                    $i=0;

                                    {
                                    foreach ($listOfAllTheGuides_ar as $id => $eventcount) {
                                    $item_name=$listOfAllTheGuides_ar[$i]['item_name'];
                                    $item_id=$listOfAllTheGuides_ar[$i]['item_id'];

                                    ?>
                                    <option <?php if($guide_id===$item_name) {?> selected <?php $guide_name=$item_name;}?>
                                        value="{{ $item_name }}">
                                        {{ $item_name }}</option>
                                    <?php
                                    $i++;
                                    }
                                    };
                                    ?>
                                </select>&nbsp;&nbsp;</label>
                        </div>

                        <div> <label>Market Code :&nbsp;<br><select class="chosen" id="dynamic_select_marketcode"
                                    style="width:200px">
                                    <?php
                                $i=0;

                            {
                                foreach ($market_code_list_ar as $id => $eventcount) {
                                $item_name=$market_code_list_ar[$i]['market_code'];


                                ?>
                                    <option <?php if($market_code===$item_name) {?> selected <?php }?>
                                        value="{{ $item_name }}">
                                        {{ $item_name }}</option>
                                    <?php
                                $i++;
                                }
                                };
                                    ?>
                                </select>&nbsp;&nbsp;</label>
                        </div>
                    </div>

                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            {{ trans('Hunt Data') }}
                        </div>
                        <div>
                            <form action="/fromDashboardWeeklyHuntingBtnPressRevised/fromdate/todate/guide_id/market_code"
                                method="get" style="margin: 1%">
                                <table width="100%">
                                    <tr>
                                        {{-- <td style="text-align: left">
                                            <button onclick="fun1()"
                                                style="width: 50px; box-sizing: border-box;margin: 0;height: 2.1em;padding: 0 .6em;font-size: 1em;white-space:nowrap;cursor: pointer;"><span
                                                    class="fc-icon fc-icon-left-single-arrow"></span></button>

                                        </td> --}}
                                        <td>
                                            <input type="hidden" name="fromdate" id="fromdateinput"
                                                value="<?php echo $fromdate; ?>">
                                        </td>
                                        <td>
                                            <input type="hidden" name="todate" id="todateinput"
                                                value="<?php echo $todate; ?>">
                                        </td>
                                        <td>
                                            <input type="hidden" name="guide_id" id="guide_id"
                                                value="<?php echo base64_encode('All'); ?>">
                                        </td>
                                        <td>
                                            <input type="hidden" name="market_code" id="market_code"
                                                value="<?php echo base64_encode('All'); ?>">
                                        </td>
                                        {{-- <td style="text-align: right">
                                            <button onclick="fun2()"
                                                style="width: 50px; box-sizing: border-box;margin: 0;height: 2.1em;padding: 0 .6em;font-size: 1em;white-space:nowrap;cursor: pointer;"><span
                                                    class="fc-icon fc-icon-right-single-arrow"></span></button>
                                        </td> --}}
                                    </tr>
                                </table>


                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">EVENT ID </th>
                                            <th class="text-left">FOLIO ID </th>
                                            <th class="text-left">CUSTOMER NAME</th>
                                            <th class="text-left">SALES STAGE</th>
                                            <th class="text-left">Market Code</th>
                                            <th class="text-left"># HUNTER</th>
                                            <th class="text-left">EVENT START DATETIME</th>
                                            <th class="text-left">EVENT END DATETIME</th>
                                            <th class="text-left">HUNT START </th>
                                            <th class="text-left">HUND END </th>
                                            <th class="text-left">TYPE OF HUNT</th>
                                            <th class="text-left">HUNT GUIDE </th>
                                            <th class="text-left">DESCRIPTION</th>
                                            <th class="text-left">ROOM </th>
                                            <th class="text-left">RESERVATION YEAR </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                              $i=0;
                                              foreach($data_ar as $id => $eventcount)  {
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{ $i + 1 }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['group_folio_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['customer_name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['cat_sales_stage'] }}</td>
                                            <td class="text-left"> <?php
                                                if($data_ar[0]['market_code'] != null){
                                                    ?>
                                                {{ $data_ar[0]['market_code'] }}<br>
                                                <?php

                                                }else{
                                                    echo "NA";
                                                }
                                                ?></td>
                                            <td class="text-left">{{ count($data_ar) }}</td>
                                            <td class="text-left">
                                                {{-- Miltary date format change start 26/09/2023 --}}
                                                <?php
                                                if ($data_ar[0]['start_datetime'] == '') {
                                                    echo 'NA';
                                                } else {
                                                    // $tempTdayDate = explode(':', $data_ar[0]['start_datetime']);
                                                    echo $data_ar[0]['start_datetime'];
                                                }
                                                ?>
                                            </td>
                                            <td class="text-left">
                                                <?php
                                                if ($data_ar[0]['end_datetime'] == '') {
                                                    echo 'NA';
                                                } else {
                                                    // $tempTdayDate = explode(':', $data_ar[0]['end_datetime']);
                                                    echo $data_ar[0]['end_datetime'];
                                                }
                                                ?>
                                                {{-- Miltary date format change end 26/09/2023 --}}
                                            </td>
                                            <td class="text-left">{{ $data_ar[$i]['huntstart'] }}</td>
                                            <td class="text-left">
                                                <?php
                                                if ($data_ar[$i]['huntend'] == null) {
                                                    echo 'NA';
                                                } else {
                                                    echo $data_ar[$i]['huntend'];
                                                }
                                                ?>
                                            </td>
                                            <td class="text-left">{{ $data_ar[$i]['type_of_hunt'] }}</td>
                                            <td class="text-left">
                                                <?php
                                                if ($data_ar[$i]['guide_name'] == null) {
                                                    echo 'NA';
                                                } else {
                                                    echo $data_ar[$i]['guide_name'];
                                                }
                                                ?>
                                            </td>
                                            <td class="text-left">
                                                <?php
                                                if ($data_ar[$i]['amount'] != 'NA') {
                                                    ?>
                                                {{ $data_ar[$i]['customer_phone_no'] }}<br>
                                                <?php
                                                    echo "$" . $data_ar[$i]['amount'] . ' on File ' . $data_ar[$i]['txn_date'];
                                                } else {
                                                    echo 'NA';
                                                }
                                                ?></td>
                                            <td class="text-left">{{ $data_ar[$i]['room'] }}</td>
                                            <td class="text-left"><?php
                                            $tempTdayDate = explode('-', $data_ar[$i]['huntstart']);
                                            if ($tempTdayDate[0] == '') {
                                                echo 'NA';
                                            } else {
                                                echo $tempTdayDate[2];
                                            }
                                            ?></td>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../js/scripts.js"></script>
    <script>
        $('.datatable').DataTable({
            scrollX: true,
            scrollY: "600px",
            scrollCollapse: true,

            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'csv',
                    title: 'huntingdata'
                },
                {
                    extend: 'excel',
                    title: 'huntingdata'
                },
                {
                    extend: 'pdf',
                    title: 'huntingdata',
                    orientation: 'landscape'
                },
                'print'
            ],
            pageLength: 5
        });
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../js/scripts.js"></script>
    <script type="text/javascript">
        window.addEventListener("load", function() {
            setTimeout(otherOperation, 5);
        }, false);

        function otherOperation() {
            var hidePreButtonFromCalendar = document.getElementsByClassName("fc-prev-button");
            hidePreButtonFromCalendar[0].style.display = "none";
            var hideNextButtonFromCalendar = document.getElementsByClassName("fc-next-button");
            hideNextButtonFromCalendar[0].style.display = "none";
            var hideTodayButtonFromCalendar = document.getElementsByClassName("fc-today-button");
            hideTodayButtonFromCalendar[0].style.display = "none";
            var hideMonthButtonFromCalendar = document.getElementsByClassName("fc-month-button");
            //hideWeekButtonFromCalendar[0].style.visibility = "hidden"; // or
            hideMonthButtonFromCalendar[0].style.display = "none";
            var hideWeekButtonFromCalendar = document.getElementsByClassName("fc-agendaWeek-button");
            hideWeekButtonFromCalendar[0].style.display = "none";
            var hideDayButtonFromCalendar = document.getElementsByClassName("fc-agendaDay-button");
            hideDayButtonFromCalendar[0].style.display = "none";

        }
    </script>
    <script>
        function fun1() {

            var headerMonthYear = $('.fc-center h2').html();
            var myHeadermonthYearArray = headerMonthYear.split(" ");

            var intMonthNumb = 0;
            switch (myHeadermonthYearArray[0]) {
                case "January":
                    intMonthNumb = 1;
                    break;
                case "February":
                    intMonthNumb = 2;
                    break;
                case "March":
                    intMonthNumb = 3;
                    break;
                case "April":
                    intMonthNumb = 4;
                    break;
                case "May":
                    intMonthNumb = 5;
                    break;
                case "June":
                    intMonthNumb = 6;
                    break;
                case "July":
                    intMonthNumb = 7;
                    break;
                case "August":
                    intMonthNumb = 8;
                    break;
                case "September":
                    intMonthNumb = 9;
                    break;
                case "October":
                    intMonthNumb = 10;
                    break;
                case "November":
                    intMonthNumb = 11;
                    break;
                case "December":
                    intMonthNumb = 12;
                    break;
                default: {
                    break;
                }
            }
            intMonthNumb = intMonthNumb - 1;
            if (intMonthNumb == 0) {
                intMonthNumb = 12;
                myHeadermonthYearArray[1] = myHeadermonthYearArray[1] - 1;
            }
            if (intMonthNumb < 10) {
                var temp = "";
                temp = temp.concat("0");
                temp = temp.concat(intMonthNumb);
                intMonthNumb = temp;
            }

            var tempDate = "";
            tempDate = tempDate.concat(intMonthNumb);
            tempDate = tempDate.concat("/");
            tempDate = tempDate.concat("01");
            tempDate = tempDate.concat("/");
            tempDate = tempDate.concat(myHeadermonthYearArray[1]);
            // alert(tempDate);
            var date = new Date(tempDate);
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            var firstDayFormated = "";
            var lastDayFormated = "";
            firstDayFormated = convert(firstDay);
            lastDayFormated = convert(lastDay);

            function convert(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [mnth, day, date.getFullYear()].join("-");
            }

            document.getElementById("fromdateinput").value = btoa(firstDayFormated);
            document.getElementById("todateinput").value = btoa(lastDayFormated);


            //    alert(firstDayFormated+"----"+lastDayFormated);
        }

        function fun2() {

            var headerMonthYear = $('.fc-center h2').html();
            var myHeadermonthYearArray = headerMonthYear.split(" ");

            var intMonthNumb = 0;
            switch (myHeadermonthYearArray[0]) {
                case "January":
                    intMonthNumb = 1;
                    break;
                case "February":
                    intMonthNumb = 2;
                    break;
                case "March":
                    intMonthNumb = 3;
                    break;
                case "April":
                    intMonthNumb = 4;
                    break;
                case "May":
                    intMonthNumb = 5;
                    break;
                case "June":
                    intMonthNumb = 6;
                    break;
                case "July":
                    intMonthNumb = 7;
                    break;
                case "August":
                    intMonthNumb = 8;
                    break;
                case "September":
                    intMonthNumb = 9;
                    break;
                case "October":
                    intMonthNumb = 10;
                    break;
                case "November":
                    intMonthNumb = 11;
                    break;
                case "December":
                    intMonthNumb = 12;
                    break;
                default: {
                    break;
                }
            }
            intMonthNumb = intMonthNumb + 1;
            if (intMonthNumb == 13) {
                intMonthNumb = 1;
                var intYear = 0;
                intYear = myHeadermonthYearArray[1];
                intYear = ++intYear;
                myHeadermonthYearArray[1] = intYear;

            }
            if (intMonthNumb < 10) {
                var temp = "";
                temp = temp.concat("0");
                temp = temp.concat(intMonthNumb);
                intMonthNumb = temp;
            }
            var tempDate = "";
            tempDate = tempDate.concat(intMonthNumb);
            tempDate = tempDate.concat("/");
            tempDate = tempDate.concat("01");
            tempDate = tempDate.concat("/");
            tempDate = tempDate.concat(myHeadermonthYearArray[1]);
            // alert(tempDate);
            var date = new Date(tempDate);
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            var firstDayFormated = "";
            var lastDayFormated = "";
            firstDayFormated = convert(firstDay);
            lastDayFormated = convert(lastDay);

            function convert(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [mnth, day, date.getFullYear()].join("-");
            }
            document.getElementById("fromdateinput").value = btoa(firstDayFormated);
            document.getElementById("todateinput").value = btoa(lastDayFormated);
        }
    </script>
    <script>
        $(function() {
            $('#dynamic_select').on('change', function() {
                var selected_id = $(this).val();
                var selected_marketcode = document.getElementById("dynamic_select_marketcode").value;
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;
                window.location = "/getSheduleFilterR/" + btoa(fromdate) + "/" + btoa(todate) + "/" + btoa(
                        selected_id) +
                    "/" + btoa(selected_marketcode) + "/" + btoa('Hunt');
                // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

            });
        });

        $(function() {
            $('#dynamic_select_marketcode').on('change', function() {
                var selected_marketcode = $(this).val();
                var selected_id = document.getElementById("dynamic_select").value;
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;

                window.location = "/getSheduleFilterR/" + btoa(fromdate) + "/" + btoa(todate) + "/" + btoa(
                        selected_id) +
                    "/" + btoa(selected_marketcode) + "/" + btoa('Hunt');
                // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

            });
        });

        $(function() {
            $('#demodateF').on('change', function() {
                var selected_marketcode = document.getElementById("dynamic_select_marketcode").value;
                var selected_id = document.getElementById("dynamic_select").value;
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;

                window.location = "/getSheduleFilterR/" + btoa(fromdate) + "/" + btoa(todate) + "/" + btoa(
                        selected_id) +
                    "/" + btoa(selected_marketcode) + "/" + btoa('Hunt');
                // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

            });
        });

        $(function() {
            $('#demodateT').on('change', function() {
                var selected_marketcode = document.getElementById("dynamic_select_marketcode").value;
                var selected_id = document.getElementById("dynamic_select").value;
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;

                window.location = "/getSheduleFilterR/" + btoa(fromdate) + "/" + btoa(todate) + "/" + btoa(
                        selected_id) +
                    "/" + btoa(selected_marketcode) + "/" + btoa('Hunt');
                // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(function() {
                $("#demodateF").datepicker({
                    dateFormat: 'mm-dd-yy',
                });
            });

            $(function() {
                $("#demodateT").datepicker({
                    dateFormat: 'mm-dd-yy',
                });
            });
        })
    </script>
</body>

</html>
