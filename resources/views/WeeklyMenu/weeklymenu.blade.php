<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/bootstrapforcalender336bootstrap.min.css')}}" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
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
        <link rel="stylesheet" type="text/css" href="{{ url('/css/bootstrapcssforcalender.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/bootstrapcssforcalender2.css')}}" />
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

                                    <div class="container">
                                    @if (\Session::has('success'))
                                          <div class="alert alert-success">
                                            <p>{{ \Session::get('success') }}</p>
                                          </div><br />
                                         @endif
                                       <div class="panel panel-default">
                                             <div class="panel-heading" style="background-color: #20a8d8">
                                                 <h2>Calendar</h2>
                                             </div>
                                            <div>
                                                     <form action="/fromDashboardWeeklyHuntingBtnPress/fromDate/todate" method="get" style="margin: 1%">
                                                        <table width="100%">
                                                            <tr>
                                                                <td style="text-align: left">
                                                                    <button onclick="fun1()" style="width: 50px; box-sizing: border-box;margin: 0;height: 2.1em;padding: 0 .6em;font-size: 1em;white-space:nowrap;cursor: pointer;"><span class="fc-icon fc-icon-left-single-arrow"></span></button>

                                                                </td>
                                                                <td>
                                                                     <input type="hidden" name="fromdate" id="fromdateinput" value="<?php echo $fromdate;?>">
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="todate" id="todateinput" value="<?php echo $todate;?>">
                                                                </td>
                                                                <td style="text-align: right">
                                                                    <button onclick="fun2()" style="width: 50px; box-sizing: border-box;margin: 0;height: 2.1em;padding: 0 .6em;font-size: 1em;white-space:nowrap;cursor: pointer;"><span class="fc-icon fc-icon-right-single-arrow"></span></button>
                                                                </td>
                                                            </tr>
                                                        </table>


                                                     </form>
                                            </div>

                                             <div class="panel-body" >
                                                {!! $calendar->calendar() !!}
                                            </div>
                                        </div>
                                    </div>

                                    {!! $calendar->script() !!}
                                    <style>
                                        .hiddenEvent{display: none;}
                                    .fc-other-month .fc-day-number { display:none;}

                                    td.fc-other-month .fc-day-number {
                                         /* visibility: hidden; */
                                         background:red;
                                    }
                                    .nav-link{
                                       *,
                                        *::before{
                                          box-sizing: border-box !important;
                                        }
                                    }
                                    </style>
                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
                                        <script>
                                              var defaultDateTemp=document.getElementById("fromdateinput").value;
                                            var defaultDateTempArray=defaultDateTemp.split("-");
                                            var calender_date="";
                                            calender_date=calender_date.concat(defaultDateTempArray[2]);
                                            calender_date=calender_date.concat("-");
                                            calender_date=calender_date.concat(defaultDateTempArray[0]);
                                            calender_date=calender_date.concat("-");
                                            calender_date=calender_date.concat(defaultDateTempArray[1]);
                                        </script>
                                        <script type="text/javascript" src="{{ asset('/css/bootsrapjsforcalender.js') }}"></script>
                                        <script>
                                            $('.fc-other-month').html('');
                                            $('.fc-other-month').html('');

                                            $('#calendar-rAMvW4gM').fullCalendar({
                                         // Other settings
                                         showNonCurrentDates: false
                                    });
                                     $(document).on('click', '.fc-button', function(event) {
                                         $('#calendar-rAMvW4gM').fullCalendar({
                                         // Other settings
                                         showNonCurrentDates: false
                                    });
                                        });

                                        $('.content2').click(function(){
                                    $('.account-dropdown').toggle();
                                    });
                                        </script>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script type="text/javascript">
            window.addEventListener("load", function ()
            {
                setTimeout(otherOperation, 5);
            }, false);
            function otherOperation()
            {
                var hidePreButtonFromCalendar = document.getElementsByClassName("fc-prev-button");
                hidePreButtonFromCalendar[0].style.display = "none";
                var hideNextButtonFromCalendar = document.getElementsByClassName("fc-next-button");
                hideNextButtonFromCalendar[0].style.display = "none";
                var hideTodayButtonFromCalendar = document.getElementsByClassName("fc-today-button");
                hideTodayButtonFromCalendar[0].style.display="none";
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

            function fun1(){

                    var headerMonthYear=$('.fc-center h2').html();
                    var myHeadermonthYearArray=headerMonthYear.split(" ");

                    var intMonthNumb=0;
                    switch(myHeadermonthYearArray[0])
                    {
                        case "January":
                        intMonthNumb=1;break;
                        case "February":
                        intMonthNumb=2;break;
                        case "March":
                        intMonthNumb=3;break;
                        case "April":
                        intMonthNumb=4;break;
                        case "May":
                        intMonthNumb=5;break;
                        case "June":
                        intMonthNumb=6;break;
                        case "July":
                        intMonthNumb=7;break;
                        case "August":
                        intMonthNumb=8;break;
                        case "September":
                        intMonthNumb=9;break;
                        case "October":
                        intMonthNumb=10;break;
                        case "November":
                        intMonthNumb=11;break;
                        case "December":
                        intMonthNumb=12;break;
                        default:{
                        break;
                        }
                    }
                    intMonthNumb=intMonthNumb-1;
                        if(intMonthNumb==0){
                            intMonthNumb=12;
                            myHeadermonthYearArray[1]=myHeadermonthYearArray[1]-1;
                        }
                        if(intMonthNumb<10){
                            var temp="";
                            temp=temp.concat("0");
                            temp=temp.concat(intMonthNumb);
                            intMonthNumb=temp;
                        }

                    var tempDate="";
                    tempDate=tempDate.concat(intMonthNumb);
                    tempDate=tempDate.concat("/");
                    tempDate=tempDate.concat("01");
                    tempDate=tempDate.concat("/");
                    tempDate=tempDate.concat(myHeadermonthYearArray[1]);
                    // alert(tempDate);
                    var date = new Date(tempDate);
                    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
                    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                    var firstDayFormated="";
                    var lastDayFormated="";
                    firstDayFormated=convert(firstDay);
                    lastDayFormated=convert(lastDay);
                    function convert(str) {
                    var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                    return [mnth,day,date.getFullYear()].join("-");
                    }

                    document.getElementById("fromdateinput").value =firstDayFormated;
                    document.getElementById("todateinput").value =lastDayFormated;


                    //    alert(firstDayFormated+"----"+lastDayFormated);
            }
            function fun2(){

                    var headerMonthYear=$('.fc-center h2').html();
                    var myHeadermonthYearArray=headerMonthYear.split(" ");

                    var intMonthNumb=0;
                    switch(myHeadermonthYearArray[0])
                    {
                        case "January":
                        intMonthNumb=1;break;
                        case "February":
                        intMonthNumb=2;break;
                        case "March":
                        intMonthNumb=3;break;
                        case "April":
                        intMonthNumb=4;break;
                        case "May":
                        intMonthNumb=5;break;
                        case "June":
                        intMonthNumb=6;break;
                        case "July":
                        intMonthNumb=7;break;
                        case "August":
                        intMonthNumb=8;break;
                        case "September":
                        intMonthNumb=9;break;
                        case "October":
                        intMonthNumb=10;break;
                        case "November":
                        intMonthNumb=11;break;
                        case "December":
                        intMonthNumb=12;break;
                        default:{
                        break;
                        }
                    }
                    intMonthNumb=intMonthNumb+1;
                        if(intMonthNumb==13){
                            intMonthNumb=1;
                            var intYear=0;
                            intYear=myHeadermonthYearArray[1];
                            intYear=++intYear;
                            myHeadermonthYearArray[1]=intYear;

                        }
                        if(intMonthNumb<10){
                            var temp="";
                            temp=temp.concat("0");
                            temp=temp.concat(intMonthNumb);
                            intMonthNumb=temp;
                        }
                    var tempDate="";
                    tempDate=tempDate.concat(intMonthNumb);
                    tempDate=tempDate.concat("/");
                    tempDate=tempDate.concat("01");
                    tempDate=tempDate.concat("/");
                    tempDate=tempDate.concat(myHeadermonthYearArray[1]);
                    // alert(tempDate);
                    var date = new Date(tempDate);
                    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
                    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                    var firstDayFormated="";
                    var lastDayFormated="";
                    firstDayFormated=convert(firstDay);
                    lastDayFormated=convert(lastDay);
                    function convert(str)
                    {
                        var date = new Date(str),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                        return [mnth,day,date.getFullYear()].join("-");
                    }
                    document.getElementById("fromdateinput").value =firstDayFormated;
                    document.getElementById("todateinput").value =lastDayFormated;
            }

        </script>
    </body>
</html>










