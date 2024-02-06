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
            /* justify-content: space-between; */
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

        label {
            padding-left: 8%;
        }

        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
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

                @if (count($data_ar) >= 5000)
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong></strong> This data is too larger to show on grid so you can view only 5000 rows but when you click it will download all data in given date range will be downloaded.
                    </div>
                @endif
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

                        {{-- <button id="download" type="submit">Download Excel</button> --}}




                    </div>

                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            {{ trans('Staff Booking Data') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-hover datatable"
                                    style="table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">Group Folio id</th>
                                            <th class="text-left">Company Party Name </th>
                                            <th class="text-left">Event Start Time</th>
                                            <th class="text-left">Event End Time</th>
                                            <th class="text-left">Room</th>
                                            <th class="text-left">Event Type</th>
                                            <th class="text-left">Sales Rep</th>
                                            <th class="text-left">Sales Stage</th>
                                            <th class="text-left">Quantity est </th>
                                            <th class="text-left">Quantity gtd </th>
                                            <th class="text-left">VIP Level</th>
                                            <th class="text-left">Folio Location </th>
                                            <th class="text-left">Folio Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                              $i=0;
                                              foreach($data_ar as $id => $eventcount)  {
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{ $i + 1 }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['group_folio_id'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['company_party_name'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_time_start'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_time_end'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['room'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['event_type'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['sales_rep'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['sales_stage'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_est'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['qty_gtd'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['vip_level'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_location'] }}</td>
                                            <td class="text-left">{{ $data_ar[$i]['folio_total'] }}</td>
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
                    title: 'staffbookingdata'
                },
                {
                    extend: 'excel',
                    title: 'staffbookingdata'
                },
                {
                    extend: 'pdf',
                    title: 'staffbookingdata',
                    orientation: 'landscape'
                },
                'print',
                {
                    text: 'Download Excel',
                    className: 'custom-excel-button',
                    action: function(e, dt, node, config) {
                        $('#hiddenDownloadButton').click();
                    }
                }
            ],
            pageLength: 10
        });
        $(document).ready(function() {
            // Assign an ID to the custom Excel button
            $('.custom-excel-button').attr('id', 'download');
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
            $('#demodateF').on('change', function() {
                var fromdate = document.getElementById("demodateF").value;
                var toDate = calculateToDate(fromdate, 1); // Calculate todate by adding 1 year
                document.getElementById("demodateT").value = toDate;
                var todate = document.getElementById("demodateT").value;

                window.location = "/dateFilterStaffBooking/" + btoa(fromdate) + "/" + btoa(todate);
                // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

            });

            function calculateToDate(fromdate, yearsToAdd) {
                var fromDateObj = new Date(fromdate);
                var toDateObj = new Date(fromDateObj);
                toDateObj.setFullYear(fromDateObj.getFullYear() + yearsToAdd);
                toDateObj.setDate(toDateObj.getDate() - 1);
                // Extract mm, dd, yyyy parts
                var mm = String(toDateObj.getMonth() + 1).padStart(2, '0'); // January is 0!
                var dd = String(toDateObj.getDate()).padStart(2, '0');
                var yyyy = toDateObj.getFullYear();

                // Format as mm-dd-yyyy
                var formattedDate = mm + '-' + dd + '-' + yyyy;
                return formattedDate;
            }
        });

        $(function() {
            $('#demodateT').on('change', function() {
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;

                window.location = "/dateFilterStaffBooking/" + btoa(fromdate) + "/" + btoa(todate);
                // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

            });
        });


        $(function() {
            $('#download').on('click', function() {
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;

                window.location = "/downloadexcel/" + btoa(fromdate) + "/" + btoa(todate);
                // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

            });
        });

        $(document).ready(function() {
            // Assuming `data_ar` is the array containing your data
            var dataCount = <?php echo count($data_ar); ?>;

            // Hide the DataTables buttons by default
            $('.dt-buttons').hide();

            // Show the DataTables buttons if data count is less than 5000
            if (dataCount < 5000) {
                $('.dt-buttons').show();
                $('#download').hide();

            } else {

                $('.dt-buttons').show(); // Hide DataTables buttons
                $('.buttons-pdf').hide();
                $('.buttons-copy').hide();
                $('.buttons-csv').hide();
                $('.buttons-excel').hide();
                $('.buttons-print').hide();
                $('#download').show();
            }

            // Add custom functionality to your button (assuming it has an ID of "download")
            $('#download').click(function() {
                // Add your custom functionality here
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
