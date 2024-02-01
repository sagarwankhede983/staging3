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
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            Unassigned Guide
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">SR.NO.</th>
                                            <th class="text-left">GUIDE ID</th>
                                            <th class="text-left">GUIDE NAME</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                                                      $i=0;
                                                                                      foreach ($guideInitemtable_ar as $id => $eventcount) {
                                                                                          $item_id=$guideInitemtable_ar[$i]['item_id'];
                                                                                          $item_name=$guideInitemtable_ar[$i]['item_name'];
                                                                                       ?>
                                        <tr style="align-content: center">
                                            <td class="text-left">{{$i+1}}</td>
                                            <td class="text-left">{{$item_id}}</td>
                                            <td class="text-left">{{$item_name}}</td>
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
    // $(function() {
    //     let deleteButtonTrans = '{{ trans('
    //     global.datatables.delete ') }}'
    //     let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
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
