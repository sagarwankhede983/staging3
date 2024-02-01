
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
                                <table width="50%" style="margin-left: 50%">
                                  <tr>
                                        <td><label>Please select customer:</label></td>
                                        <td><label> Rate Type:</label></td>
                                        <td></td>
                                  </tr>
                                  <tr>
                                        <td><select class="chosen" id="dynamic_select_cust" style="width: 300px" name="selected_customer_id_from_select">
                                            <option <?php if($customerIdFilter=="0") {?> selected <?php }?> value="0">Select</option>
                                              <?php
                                              $i=0;

                                              foreach ($listOutCustomers_ar as $id => $eventcount) {
                                              $customer_name=$listOutCustomers_ar[$i]['name'];
                                              $customer_id=$listOutCustomers_ar[$i]['customer_id'];
                                              if(trim($customer_name)==""){
                                              $customer_name="Customer Name is not Available";
                                              }else{


                                              }

                                              ?>
                                              <option  <?php if($customer_id==$customerIdFilter) {?> selected <?php }?> value="{{$customer_id}}">{{$customer_name}}-{{$customer_id}}</option>
                                              <?php
                                              $i++;
                                              }
                                              ?>
                                              </select>
                                        </td>
                                        <td>
                                            <select class="chosen" id="dynamic_select_ratetype" name="selected_rate_type_from_select">>
                                                    <option value="All" <?php if($rateTypeFilter=="All"){?>selected <?php }?>
                                                    >All*</option>
                                              <?php
                                              $i=0;

                                              foreach ($rate_type_list_ar as $id => $eventcount) {
                                              $rate_type_item=$rate_type_list_ar[$i]['rate_type'];
                                              ?>
                                              <option  <?php if($rate_type_item===$rateTypeFilter) {?> selected <?php }?> value="{{$rate_type_item}}">{{$rate_type_item}}</option>
                                              <?php
                                              $i++;
                                              }
                                              ?>
                                              </select>
                                        </td>
                                  </tr>
                              </table>
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
                                           // var defaultDateTemp=document.getElementById("fromdateinput").value;
                                            //var defaultDateTempArray=defaultDateTemp.split("-");
                                            var calender_date="";
                                                var d = new Date(),
                                                month = '' + (d.getMonth() + 1),
                                                day = '' + d.getDate(),
                                                year = d.getFullYear();

                                                if (month.length < 2)
                                                month = '0' + month;
                                                if (day.length < 2)
                                                day = '0' + day;

                                                calender_date=[year, month, day].join('-');
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
<script>
        $(function(){
      $('#dynamic_select_cust').on('change', function () {
          var selected_id = $(this).val();
          var e=document.getElementById("dynamic_select_cust");
          var selected_cust_id = e.options[e.selectedIndex].value;
          var f=document.getElementById("dynamic_select_ratetype");
          var selected_ratetype = f.options[f.selectedIndex].value;
            window.location = "/pmsRoomReservationOnCaledarSelectedId/"+btoa(selected_cust_id)+"/"+btoa(selected_ratetype);
              // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

      });
       $('#dynamic_select_ratetype').on('change', function () {
          var selected_id = $(this).val();
          var e=document.getElementById("dynamic_select_cust");
          var selected_cust_id = e.options[e.selectedIndex].value;
          var f=document.getElementById("dynamic_select_ratetype");
          var selected_ratetype = f.options[f.selectedIndex].value;
            window.location = "/pmsRoomReservationOnCaledarSelectedId/"+btoa(selected_cust_id)+"/"+btoa(selected_ratetype);
              // /viewCustomerDetailFromItemDetail/{customer_id}/{date}

      });
    });
        </script>
    </body>
</html>






