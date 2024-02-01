<style>
validateForm {
    margin-left: 70px;
    font-weight: bold;
    float: left;
    clear: left;
    width: 100px;
    text-align: left;
    margin-right: 10px;
    font-family: sans-serif, bold, Arial, Helvetica;
    font-size: 14px;
}
</style>
<style>
.switch {
    position: relative;
    display: inline-block;
    width: 52px;
    height: 16px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #262a2e;
    -webkit-transition: .4s;
    transition: .4s;
    height: 26px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 23px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

.help-tip {
    top: 18px;
    right: 18px;
    text-align: center;
    background-color:
        #D9534F;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 14px;
    line-height: 26px;
    cursor: default;
    margin-top: -27px;
    margin-left: 290px;
}

.help-tip:before {
    content: '?';
    font-weight: bold;
    color: #fff;
}

.help-tip:hover p {
    display: block;
    transform-origin: 100% 0%;
}

.help-tip p {
    /* The tooltip */
    display: none;
    text-align: left;
    background-color: #1E2021;
    padding: 10px;
    width: 450px;
    border-radius: 3px;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
    color: #FFF;
    font-size: 13px;
    height: 70px;

}

.help-tip p:before {
    /* The pointer of the tooltip */
    position: absolute;
    content: '';
    width: 0;
    height: 0;
    border: 6px solid transparent;
    border-bottom-color: #1E2021;
    right: 10px;
    top: -12px;
}

.help-tip p:after {
    /* Prevents the tooltip from being hidden */
    width: 100%;
    height: 40px;
    content: '';
    position: absolute;
    top: -40px;
    left: 0;
}
</style>




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
                            Email Set Up
                        </div>
                        <div class="card-body">
                            <form action="/addEmailSetUp" method="POST" enctype="multipart/form-data">
                                @csrf
                                <table style="width:100%">
                                    <tr>
                                        <td>
                                            <label for="name">Email*</label>
                                            <input name="emailtoadd" id="email_id" style="width:80%" />
                                            <?php if($email_error!=""){
                                                ?>
                                            <label style="color: red"><?php echo $email_error;?></label>
                                            <?php
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="card" style="height: auto !important; margin-top: 1%">
                        <div class="card-header">
                            Remove Email
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>SR./NO.</th>
                                            <th>
                                                User Email
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        if($users){
                                        $i=0;
                                        foreach($users as $key){
                                        $user_email=$users[$i]['UserEmail'];
                                        $email_id=$users[$i]['uniqueId'];
                                        ?>
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td>{{$user_email}}</td>
                                            <td>
                                                <a onclick="return confirm('{{ trans('global.areYouSure') }}');"
                                                    style="display: inline-block;" class="btn btn-xs btn-danger"
                                                    href="/deleteUserEmailFromSetUp/{{base64_encode($email_id)}}">
                                                    {{ trans('global.delete') }}
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i=$i+1;
                                        }
                                    }
                                    else{
                                        ?>
                                        <tr>
                                            <td colspan='3'>
                                                No Data Found
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <script>
                    $(function() {
                        $('#dynamic_select').on('change', function() {
                            var selected_id = $(this).val();
                            if (selected_id == 'User') {
                                document.getElementById("mySelect").disabled = false;
                            } else {
                                document.getElementById("mySelect").disabled = true;
                            }


                        });
                    });
                    </script>
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
</body>

</html>
