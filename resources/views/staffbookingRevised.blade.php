<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}" />
    <script type="text/javascript" src="{{ asset('/css/chartjs.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css') }}" />
    @include('layouts.dataTablesRequiredJS')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="//fonts.googleapis.com/css?family=Merriweather:300,700,700italic,300italic|Open+Sans:700,400&display=swap" />
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
                {{-- <div id="hello"> --}}
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
                            {{ trans('Catering Staff Booking') }}
                        </div>
                        <div class="card-body">
                            <div class="table-wrapper">


                                <table id="datatable" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr align="left">
                                            <th>Event Id</th>
                                            <th>Group Folio Id</th>
                                            <th>Event Time Start</th>
                                            <th>Event Time End</th>
                                            <th>Qty Est</th>
                                            <th>Qty Gtd</th>
                                            <th>Qty Show</th>
                                            <th>Qty Bill</th>
                                            <th>Company Party Name</th>
                                            <th>Room</th>
                                            <th>Cat Event Type</th>
                                            <th>Cat Room Setup</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Name</th>
                                            <th>Folio Id</th>
                                            <th>Folio Subtotal</th>
                                            <th>Folio Surcharges</th>
                                            <th>Folio Total</th>
                                            <th>Folio Payments</th>
                                            <th>Folio Balance</th>
                                            <th>Folio Settled</th>
                                            <th>Folio Open Date</th>
                                            <th>Folio Close Date</th>
                                            <th>Folio Operating Day</th>
                                            <th>Folio Staff Id</th>
                                            <th>Folio Customer Id</th>
                                            <th>Folio Location</th>
                                            <th>Folio Item Id</th>
                                            <th>Item Id</th>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Discount</th>
                                            <th>Disc Type</th>
                                            <th>Ext Price</th>
                                            <th>Price With Surcharges</th>
                                            <th>Item Charge Code</th>
                                            <th>Item Staff Id</th>
                                            <th>Item Txn Date</th>
                                            <th>Item Customer Id</th>
                                            <th>Cost At Purchase</th>
                                            <th>Deferred</th>
                                            <th>Folio Item Detail Id</th>
                                            <th>Detail Charge Code</th>
                                            <th>Has Value</th>
                                            <th>Charge Code Amount</th>
                                            <th>Est Arrival Date</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </div> --}}
            </main>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../js/scripts.js"></script>

    </script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                scrollX: true, // Enable horizontal scrolling
                scrollY: 'calc(100vh - 200px)', // Set the height for vertical scrolling
                scrollCollapse: true,
                fixedHeader: true,
                order: [
                    [0, "desc"]
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        filename: function() {
                            var now = new Date();
                            var year = now.getFullYear();
                            var month = (now.getMonth() + 1).toString().padStart(2,
                                '0'); // Month is zero-based
                            var day = now.getDate().toString().padStart(2, '0');
                            var hours = now.getHours().toString().padStart(2, '0');
                            var minutes = now.getMinutes().toString().padStart(2, '0');
                            var seconds = now.getSeconds().toString().padStart(2, '0');

                            return 'StaffBookingData_' + year + month + day + hours + minutes +
                                seconds;
                        }
                    },
                    {
                        extend: 'csv',
                        filename: function() {
                            var now = new Date();
                            var year = now.getFullYear();
                            var month = (now.getMonth() + 1).toString().padStart(2,
                                '0'); // Month is zero-based
                            var day = now.getDate().toString().padStart(2, '0');
                            var hours = now.getHours().toString().padStart(2, '0');
                            var minutes = now.getMinutes().toString().padStart(2, '0');
                            var seconds = now.getSeconds().toString().padStart(2, '0');

                            return 'StaffBookingData_' + year + month + day + hours + minutes +
                                seconds;
                        }
                    },
                    {
                        extend: 'excel',
                        filename: function() {
                            var now = new Date();
                            var year = now.getFullYear();
                            var month = (now.getMonth() + 1).toString().padStart(2,
                                '0'); // Month is zero-based
                            var day = now.getDate().toString().padStart(2, '0');
                            var hours = now.getHours().toString().padStart(2, '0');
                            var minutes = now.getMinutes().toString().padStart(2, '0');
                            var seconds = now.getSeconds().toString().padStart(2, '0');

                            return 'StaffBookingData_' + year + month + day + hours + minutes +
                                seconds;
                        }
                    },
                    {
                        extend: 'print',
                        filename: function() {
                            var now = new Date();
                            var year = now.getFullYear();
                            var month = (now.getMonth() + 1).toString().padStart(2,
                                '0'); // Month is zero-based
                            var day = now.getDate().toString().padStart(2, '0');
                            var hours = now.getHours().toString().padStart(2, '0');
                            var minutes = now.getMinutes().toString().padStart(2, '0');
                            var seconds = now.getSeconds().toString().padStart(2, '0');

                            return 'StaffBookingData_' + year + month + day + hours + minutes +
                                seconds;
                        }
                    }
                ],
                ajax: {
                    url: "{{ url('users-data') }}",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.param1 = document.getElementById("demodateF").value;
                        d.param2 = document.getElementById("demodateT").value;
                    }
                },
                columns: [{
                        data: 'event_id'
                    },
                    {
                        data: 'group_folio_id'
                    },
                    {
                        data: 'event_time_start'
                    },
                    {
                        data: 'event_time_end'
                    },
                    {
                        data: 'qty_est'
                    },
                    {
                        data: 'qty_gtd'
                    },
                    {
                        data: 'qty_show'
                    },
                    {
                        data: 'qty_bill'
                    },
                    {
                        data: 'company_party_name'
                    },
                    {
                        data: 'room'
                    },
                    {
                        data: 'cat_event_type'
                    },
                    {
                        data: 'cat_room_setup'
                    },
                    {
                        data: 'start_datetime'
                    },
                    {
                        data: 'end_datetime'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'folio_id'
                    },
                    {
                        data: 'folio_subtotal'
                    },
                    {
                        data: 'folio_surcharges'
                    },
                    {
                        data: 'folio_total'
                    },
                    {
                        data: 'folio_payments'
                    },
                    {
                        data: 'folio_balance'
                    },
                    {
                        data: 'folio_settled'
                    },
                    {
                        data: 'folio_open_date'
                    },
                    {
                        data: 'folio_close_date'
                    },
                    {
                        data: 'folio_operating_day'
                    },
                    {
                        data: 'folio_staff_id'
                    },
                    {
                        data: 'folio_customer_id'
                    },
                    {
                        data: 'folio_location'
                    },
                    {
                        data: 'folio_item_id'
                    },
                    {
                        data: 'item_id'
                    },
                    {
                        data: 'item_name'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'qty'
                    },
                    {
                        data: 'discount'
                    },
                    {
                        data: 'disc_type'
                    },
                    {
                        data: 'ext_price'
                    },
                    {
                        data: 'price_with_surcharges'
                    },
                    {
                        data: 'item_charge_code'
                    },
                    {
                        data: 'item_staff_id'
                    },
                    {
                        data: 'item_txn_date'
                    },
                    {
                        data: 'item_customer_id'
                    },
                    {
                        data: 'cost_at_purchase'
                    },
                    {
                        data: 'deferred'
                    },
                    {
                        data: 'folio_item_detail_id'
                    },
                    {
                        data: 'detail_charge_code'
                    },
                    {
                        data: 'has_value'
                    },
                    {
                        data: 'charge_code_amount'
                    },
                    {
                        data: 'est_arrival_date'
                    }
                ]
            });
        });
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
                        minDate = new Date(document.getElementById("demodateF").value);
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
        fromdate = new Date(document.getElementById("demodateF").value);
        todate = new Date(document.getElementById("demodateT").value);
        if (fromdate.getFullYear() === year && todate.getFullYear() === year) {
            updateDates();
        }

        $(document).ready(function() {
            $('#demodateF').on('change', function() {
                updateYearFilterFromDates();
            });

            $('#demodateT').on('change', function() {
                updateYearFilterFromDates();
            });

            $('#dynamic_select').on('change', function() {
                updateDatesFromYearFilter();
            });
        });

        function updateYearFilterFromDates() {
            var fromDate = document.getElementById("demodateF").value;
            var toDate = document.getElementById("demodateT").value;

            // Extract years from dates
            var fromYear = new Date(fromDate).getFullYear();
            var toYear = new Date(toDate).getFullYear();

            // Update year filter if it's not already updated
            var yearSelect = document.getElementById("dynamic_select");
            if (yearSelect.value != fromYear) {
                yearSelect.value = fromYear;

                // Trigger change event to update other elements dependent on the year filter
                $(yearSelect).trigger('change');
            }
        }

        function updateDatesFromYearFilter() {
            var selectedYear = document.getElementById("dynamic_select").value;
            $('#demodateF, #demodateT').trigger('change');
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
                dataTable = $('#datatable').DataTable();
                $('#datatable').addClass('processing');
                dataTable.clear().draw();
            });

            $('#demodateT').on('change', function() {
                console.log("Inside  demoT");
                var fromdate = document.getElementById("demodateF").value;
                var todate = document.getElementById("demodateT").value;
                var year = document.getElementById("dynamic_select");
                dataTable = $('#datatable').DataTable();
                dataTable.clear().draw();
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
    </script>

</body>

</html>
