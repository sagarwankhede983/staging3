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
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css')}}" />
    <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.js') }}"></script>
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js -->
    <script type="text/javascript" src="{{ asset('/js/googlecalender.min.js') }}"></script>
    @include('layouts.dataTablesRequiredJS')

</head>
<style>
html,
body {
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
}

#hideMe {
    -moz-animation: cssAnimation 0s ease-in 5s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 5s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 5s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 5s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

@keyframes cssAnimation {
    to {
        width: 0;
        height: 0;
        overflow: hidden;
    }
}

@-webkit-keyframes cssAnimation {
    to {
        width: 0;
        height: 0;
        visibility: hidden;
    }
}
</style>

<body class="sb-nav-fixed">
    <!-- import sidebar navigation header -->
    @include('partials.navbarheader')
    <div id="layoutSidenav">
        <!-- import left sidebar here -->
        @include('partials.leftmenubar')
        <div id="layoutSidenav_content">
            <main>
               <div class="container-fluid">
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                           Customers
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">CUSTOMER ID</th>
                                           <!--  <th class="text-left">FIRST NAME</th>
                                            <th class="text-left">LAST NAME</th> -->
                                            <th class="text-left">NAME</th>
                                            <!-- <th class="text-left">CUSTOMER ID(RS)</th> -->
                                            <th class="text-left">CUSTOMER CODE</th>
                                            <!-- <th class="text-left">CUSTOMER NAME (ALPH) JDE</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                              $i=0;
                                              foreach($resort_suit_customers_ar as $id => $resort_suit_customers_ar_list)  {
                                              $cust_id=$resort_suit_customers_ar[$i]['customer_id'];
                                              $cust_first_name=$resort_suit_customers_ar[$i]['first_name'];
                                              $cust_last_name=$resort_suit_customers_ar[$i]['last_name'];
                                              $cust_name=$resort_suit_customers_ar[$i]['name'];
                                              $cust_id_rs=$resort_suit_customers_ar[$i]['customer_code'];
                                              $full_name=$cust_first_name." ". $cust_last_name;
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{$i+1}}</td>
                                            <td class="text-left">{{$cust_id}}</td>
                                            <td class="text-left">{{$full_name}}</td>
                                            <td class="text-left">{{$cust_id_rs}}</td>
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

            <script>
            $(document).ready(function() {
                $(function() {
                    $("#demodate").datepicker({
                        dateFormat: 'mm-dd-yy',
                    });
                });
            })
            </script>

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
    // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excelHtml5', 'pdf', 'print'
        ]
    });
    </script>
</body>

</html>
