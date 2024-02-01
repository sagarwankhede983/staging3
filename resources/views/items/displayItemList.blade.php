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
    <!-- https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/googlecalender.css') }}" />
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

                    <div style="margin-bottom:2%; margin-top: 2%" class="row">
                        <table width="100%">
                            <tr>
                                <td>
                                    <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
                                </td>
                                <td>
                                    <?php
                                    if($emailSend != "")
                                                                            {
                                    if(strlen($emailSend)==33){
                                     ?>
                                    <div style="background-color: white;padding-bottom: 1%;padding-top: 1%;padding-left: 1%;border-style: solid;border-color: #04AA6D;border-radius: 15px;border-width:thin;"
                                        id="mydiv">
                                        <div> <strong style="color:#04AA6D;">Success!</strong><?php echo $emailSend; ?>
                                        </div>
                                    </div>
                                    <?php
                                    }else{
                                        ?>
                                    <div style="background-color: white;padding-bottom: 1%;padding-top: 1%;padding-left: 1%;border-style:solid;border-color: #ff1a1a;border-radius: 15px;border-width:thin;"
                                        id="mydiv">
                                        <strong style="color:#ff1a1a;">Failed!</strong>
                                        <?php echo $emailSend; ?>
                                    </div>
                                    <?php
                                    }
                                                                            }

                                    ?>
                                </td>
                                <td style="text-align:right">
                                    <form method="post" action="/sendItemListOnEmail">
                                        {{ csrf_field() }}
                                        <div class="container" style="margin-bottom: 2%">
                                            <button style="margin-left: 1%" type="submit" class="btn btn-primary"
                                                id="btn_getAnEmail">Email</button>
                                        </div>
                                        {{-- @if (strlen($emailSend) == 33)
                                        <div id="hideMe">
                                            <label style="color:#f72121;">{{$emailSend}}</label>
                                        </div>
                                        @endif --}}

                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            Catering Items
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">ITEM ID</th>
                                            <th class="text-left">ITEM NAME</th>
                                            <th class="text-left">CHARGE CODE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                              $i=0;
                                              foreach($cat_item_list_ar as $id => $itemList)  {
                                              $item_id=$cat_item_list_ar[$i]['item_id'];
                                              $item_name=$cat_item_list_ar[$i]['item_name'];
                                              $item_charge_code=$cat_item_list_ar[$i]['charge_code'];
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{ $i + 1 }}</td>
                                            <td class="text-left">{{ $item_id }}</td>
                                            <td class="text-left">{{ $item_name }}</td>
                                            <td class="text-left">{{ $item_charge_code }}</td>
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
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            PMS Items
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">ITEM ID</th>
                                            <th class="text-left">ITEM NAME</th>
                                            <th class="text-left">CHARGE CODE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                              $i=0;
                                              foreach($pms_item_list_ar as $id => $itemList)  {
                                              $item_id=$pms_item_list_ar[$i]['item_id'];
                                              $item_name=$pms_item_list_ar[$i]['item_name'];
                                              $item_charge_code=$pms_item_list_ar[$i]['charge_code'];
                                              ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{ $i + 1 }}</td>
                                            <td class="text-left">{{ $item_id }}</td>
                                            <td class="text-left">{{ $item_name }}</td>
                                            <td class="text-left">{{ $item_charge_code }}</td>
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
    {{-- change on 19-05-2023 --}}
    <script>
        function myFunction() {
            $('#mydiv').delay(1000).fadeOut(3000);
        }
        myFunction();
    </script>
</body>

</html>
