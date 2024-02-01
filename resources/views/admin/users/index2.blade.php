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
</head>

<body class="sb-nav-fixed" onload='myFunction()'>
    <!-- import sidebar navigation header -->
    @include('partials.navbarheader')
    <div id="layoutSidenav">
        <!-- import left sidebar here -->
        @include('partials.leftmenubar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <?php
                    // if($alertmeassage!=""){
                    ?>
                    {{-- <div style="background-color: #63ee5e;margin-bottom: 3%;padding-bottom: 1%;padding-top: 1%;padding-left: 1%"
                        id="mydiv">
                        <strong>Success!</strong>
                        code deleted as it was not able to comment out it was for echo $alertmeassage variable
                        <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
                    </div> --}}

                    <div style="margin-bottom:2%;margin-top: 2%;display:inline">
                        <button class="btn btn-primary" style="margin-bottom:1%;margin-top: 1%" onclick="history.go(-1);">Back </button>
                    </div>

                    <?php
// }
// change on 16-05-2023
if($alertmeassage != "")
                                        {
if(strlen($alertmeassage)==33){
 ?>
                    <div style="background-color: white;margin-bottom: 1%;margin-top:1px;padding-bottom: 1%;padding-top: 1%;padding-left: 2%;padding-right: 2%;border-style: solid;border-color: #04AA6D;border-radius: 15px;border-width:thin;margin:1px;display:inline-block;"
                        id="mydiv">

                        <div> <strong style="color:#04AA6D;">Success!</strong> <?php echo $alertmeassage; ?>
                        </div>
                    </div>
                    <?php
}else{
    ?>
                    <div style="background-color: white;margin-bottom:1%;margin-top:1px;padding-bottom: 1%;padding-top: 1%;padding-left: 2%;padding-right: 2%;border-style:solid;border-color: #ff1a1a;border-radius: 15px;border-width:thin;display:inline-block;"
                        id="mydiv">
                        <strong style="color:#04AA6D;">Failed!</strong>
                        <?php echo $alertmeassage; ?>
                    </div>
                    <?php
}
}




?>

                    <div class="card" style="height: auto !important; margin-top: 1%">


                        <div class="card-header">
                            {{ trans('global.user.title_singular') }} {{ trans('global.list') }}
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>SR./NO.</th>
                                            <th>
                                                {{ trans('global.user.fields.name') }}
                                            </th>
                                            <th>
                                                {{ trans('global.user.fields.email') }}
                                            </th>
                                            <th>
                                                Role
                                            </th>
                                            <th>
                                                Sub-Role
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                   $i=0;
                        foreach($users as $key){
                            $user_name=$users[$i]['NAME'];
                            $user_email=$users[$i]['EMAIL'];
                            $user_role=$users[$i]['ROLE'];
                            $sub_role=$users[$i]['SUBROLE'];
                            $user_id=$users[$i]['ID'];
                            if($sub_role=="")
                            {
                              $sub_role="NA";
                            }
                    ?>
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $user_name }}</td>
                                            <td>{{ $user_email }}</td>
                                            <td>{{ $user_role }}</td>
                                            <td>{{ $sub_role }}</td>
                                        </tr>
                                        <?php
                        $i=$i+1;
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
    <script>
        function myFunction() {
            $('#mydiv').delay(1000).fadeOut(3000);
        }
        myFunction();
    </script>
</body>

</html>
