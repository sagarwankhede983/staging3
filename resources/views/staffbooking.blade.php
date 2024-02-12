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
    <script src="../js/scripts.js"></script>
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

        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            width: 120px;
            height: 120px;
            margin: -76px 0 0 -76px;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        /* Animation Keyframes */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Page Content Animation */
        .animate-bottom {
            position: relative;
            -webkit-animation-name: animatebottom;
            -webkit-animation-duration: 1s;
            animation-name: animatebottom;
            animation-duration: 1s;
        }

        @-webkit-keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0;
            }

            to {
                bottom: 0px;
                opacity: 1;
            }
        }

        @keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0;
            }

            to {
                bottom: 0;
                opacity: 1;
            }
        }

        /* Hide the loader initially */
        #loader {
            display: block;
        }

        /* Hide the page content initially */
        #hello {
            display: none;
        }
    </style>
</head>

<body class="sb-nav-fixed" onload="showPage()" style="margin:0;">
    <div id="loader"></div>
    <!-- import sidebar navigation header -->
    @include('partials.navbarheader')
    <div id="layoutSidenav">
        <!-- import left sidebar here -->
        @include('partials.leftmenubar')
        <div id="layoutSidenav_content">
            <main>

                {{-- @if (count($data_ar) >= 5000)
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong></strong> This data is too larger to show on grid so you can view only 5000 rows but
                        when you click it will download all data in given date range will be downloaded.
                    </div>
                @endif --}}
                <div id="hello">
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
                            {{-- <div> --}}
                            <label>Year :&nbsp;<br>
                                <select class="chosen" id="dynamic_select" style="width:200px">
                                    {{-- <option value="2023" selected>2023</option> --}}
                                </select>&nbsp;&nbsp;
                            </label>
                            {{-- </div> --}}
                        </div>

                        <div class="card" style="height: auto !important; margin-top: 1%">
                            <div class="card-header">
                                {{ trans('Staff Booking Data') }}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-bordered table-striped table-hover datatable"
                                        style="table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <th class="text-left" id="srno">SR.NO.</th>
                                                <th>event_id</th>
                                                <th>group_folio_id</th>
                                                <th>event_time_start</th>
                                                <th>event_time_end</th>
                                                <th>qty_est</th>
                                                <th>qty_gtd</th>
                                                <th>qty_show</th>
                                                <th>qty_bill</th>
                                                <th>company_party_name</th>
                                                <th>room</th>
                                                <th>cat_event_type</th>
                                                <th>cat_room_setup</th>
                                                <th>start_datetime</th>
                                                <th>end_datetime</th>
                                                <th>name</th>
                                                <th>folio_id</th>
                                                <th>folio_subtotal</th>
                                                <th>folio_surcharges</th>
                                                <th>folio_total</th>
                                                <th>folio_payments</th>
                                                <th>folio_balance</th>
                                                {{-- <th>folio_settled</th>
                                                <th>folio_open_date</th>
                                                <th>folio_close_date</th>
                                                <th>folio_operating_day</th>
                                                <th>folio_staff_id</th>
                                                <th>folio_customer_id</th>
                                                <th>folio_location</th>
                                                <th>folio_item_id</th> --}}
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
                                                <td class="text-left">{{ $data_ar[$i]['event_time_start'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['event_time_end'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['qty_est'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['qty_gtd'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['qty_show'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['qty_bill'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['company_party_name'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['room'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['cat_event_type'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['cat_room_setup'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['start_datetime'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['end_datetime'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['name'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_id'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_subtotal'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_surcharges'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_total'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_payments'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_balance'] }}</td>
                                                {{-- <td class="text-left">{{ $data_ar[$i]['folio_settled'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_open_date'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_close_date'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_operating_day'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_staff_id'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_customer_id'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_location'] }}</td>
                                                <td class="text-left">{{ $data_ar[$i]['folio_item_id'] }}</td> --}}
                                            </tr>
                                            <?php
                                                  $i++;
                                                  }
                                                 ?>
                                            {{-- {{ dd($data_ar) }} --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

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
                // {
                //     text: 'Download Excel',
                //     className: 'custom-excel-button',
                //     action: function(e, dt, node, config) {
                //         $('#hiddenDownloadButton').click();
                //     }
                // }
            ],
            pageLength: 10
        });
        // $(document).ready(function() {
        //     // Assign an ID to the custom Excel button
        //     $('.custom-excel-button').attr('id', 'download');
        // });
    </script>
    <script>
        $(document).ready(function() {
            $(function() {
                $("#demodateF").datepicker({
                    dateFormat: 'mm-dd-yy',
                    onSelect: function(selectedDate) {
                        var fromDate = new Date(selectedDate);
                        var toDate = new Date(fromDate);
                        toDate.setFullYear(fromDate.getFullYear() + 1);
                        $("#demodateT").datepicker("option", "minDate", selectedDate);
                        $("#demodateT").datepicker("option", "maxDate", toDate);
                        // Refresh the "to" date Datepicker
                        $("#demodateT").datepicker("refresh");
                        $('#demodateF').trigger('change');
                    }
                });
            });

            $(function() {
                $("#demodateT").datepicker({
                    dateFormat: 'mm-dd-yy',
                    beforeShow: function(input, inst) {
                        var minDate = $("#demodateF").datepicker("getDate");
                        if (minDate) {
                            var maxDate = new Date(minDate);
                            maxDate.setFullYear(minDate.getFullYear() + 1);
                            $(this).datepicker("option", "minDate", minDate);
                            $(this).datepicker("option", "maxDate", maxDate);
                        }
                    }
                });
            });
        });

        var year = <?php echo $year; ?>;

        var select = document.getElementById("dynamic_select");
        var currentYear = new Date().getFullYear();
        if (year != currentYear) {
            currentYear = year;
        }
        var startYear = currentYear - 10; // Adjust as needed
        var endYear = currentYear + 10;

        for (var year = startYear; year <= endYear; year++) {
            var option = document.createElement("option");
            option.value = year;
            option.text = year;
            if (year === currentYear) { // Select the current year by default
                option.selected = true;
            }
            select.appendChild(option);
        }

        function updateDates() {
            var selectedYear = select.value;
            var formattedFromDate = `01-01-${selectedYear}`;
            var formattedToDate = `31-12-${selectedYear}`;
            document.getElementById("demodateF").value = formattedFromDate;
            document.getElementById("demodateT").value = formattedToDate;
            $('#demodateF').trigger('change');
        }

        // Attach event listener to the select element
        select.addEventListener("change", updateDates);

        // Initial update of the dates based on the default selected year
        fromdate = document.getElementById("demodateF").value;
        todate = document.getElementById("demodateT").value;
        if (fromdate.getFullYear() === year && todate.getFullYear() === year) {
            updateDates();
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
                console.log("Inside  demoF");
                var fromdate = document.getElementById("demodateF").value;
                var toDate = calculateToDate(fromdate, 1); // Calculate todate by adding 1 year
                document.getElementById("demodateT").value = toDate;
                var todate = document.getElementById("demodateT").value;
                var year = document.getElementById("dynamic_select").value;
                window.location = "/dateFilterStaffBooking/" + btoa(fromdate) + "/" + btoa(todate) + "/" +
                    btoa(year);
            });

            $('#demodateT').on('change', function() {
                console.log("Inside  demoT");
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;
                var year = document.getElementById("dynamic_select");
                window.location = "/dateFilterStaffBooking/" + btoa(fromdate) + "/" + btoa(todate) + "/" +
                    btoa(year);
            });

            $('#download').on('click', function() {
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;

                window.location = "/downloadexcel/" + btoa(fromdate) + "/" + btoa(todate);
            });
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

        // $(document).ready(function() {
        // var dataCount = <?php echo count($data_ar); ?>;
        // $('.dt-buttons').hide();
        // if (dataCount < 5000) {
        //     $('.dt-buttons').show();
        //     $('#download').hide();
        // } else {
        //     $('.dt-buttons').show(); // Hide DataTables buttons
        //     $('.buttons-pdf').hide();
        //     $('.buttons-copy').hide();
        //     $('.buttons-csv').hide();
        //     $('.buttons-excel').hide();
        //     $('.buttons-print').hide();
        //     $('#download').show();
        //     }
        // });

        // window.onload = function() {
        //     document.getElementById("loader").style.display = "none";
        //     document.getElementById("hello").style.display = "block";
        // };

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("hello").style.display = "block";
            document.getElementById("srno").click();
            document.getElementById("srno").click();
        }
    </script>

</body>

</html>
