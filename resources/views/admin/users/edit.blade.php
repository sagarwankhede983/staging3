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

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
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


    .help-tip{
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

    .help-tip:before{
        content:'?';
        font-weight: bold;
        color:#fff;
    }

    .help-tip:hover p{
        display:block;
        transform-origin: 100% 0%;
    }

    .help-tip p{    /* The tooltip */
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

    .help-tip p:before{ /* The pointer of the tooltip */
        position: absolute;
        content: '';
        width:0;
        height: 0;
        border:6px solid transparent;
        border-bottom-color:#1E2021;
        right:10px;
        top:-12px;
    }

    .help-tip p:after{ /* Prevents the tooltip from being hidden */
        width:100%;
        height:40px;
        content:'';
        position: absolute;
        top:-40px;
        left:0;
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
            {{ trans('global.edit') }} {{ trans('global.user.title_singular') }}
        </div>

        <div class="card-body">
            <form action="/updateuserinfo" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('global.user.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{$usersarray[0]['NAME']}}">
                    <p class="helper-block">
                        <input type="hidden" name="uid" value="{{$uid}}">
                        {{ trans('global.user.fields.name_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">{{ trans('global.user.fields.email') }}*</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{$usersarray[0]['EMAIL']}}">
                    <p class="helper-block">
                        {{ trans('global.user.fields.email_helper') }}
                    </p>
                </div>
                <?php
                if(session()->get('userrole')=='Super Admin'){


                ?>

                <div class="form-group">
                    <label for="password">{{ trans('global.user.fields.password') }}</label>
                    <input type="password" id="passwordchange" name="passwordchange" class="form-control" value="{{$usersarray[0]['PASSWORD']}}">
                    <p class="helper-block">
                        {{ trans('global.user.fields.password_helper') }}
                    </p>
                </div>
                <?php
            }
                ?>
                <input type="hidden" name="roletochange" id="roletochange" value="{{session()->get('userrole')}}">

    <div class="form-group">
        <div class="form-group">
                    <label style="font: bold">Role</label>
        <Select class="form-control" name="role" id="dynamic_select" >
        <?php
            $i=0;
                foreach($roles as $key){
                    $user_role=$roles[$i]['TITLE'];
            ?>
            <option <?php if($usersarray[0]['ROLE']==$user_role){?> Selected <?php }?>>{{$user_role}}</option>
            <?php
            $i=$i+1;
            }
            ?>
        </Select>
    </div>
    </div>




    <div class="form-group">
        <div class="form-group">
                    <label style="font: bold">Sub-Role</label>
                    <?php if($usersarray[0]['ROLE']=="User"){?>
                    <Select class="form-control" name="subrole" id="mySelect">
                        <?php
                            $i=0;
                                foreach($subroles as $key){
                                    $user_subrole=$subroles[$i];
                            ?>
                            <option <?php if($usersarray[0]['SUBROLE']==$user_subrole){?> Selected <?php }?>>{{$user_subrole}}</option>
                            <?php
                            $i=$i+1;
                            }
                            ?>
                        </Select>

    <?php }
    else {?>
<Select disabled class="form-control" name="subrole" id="mySelect">
    <?php
        $i=0;
            foreach($subroles as $key){
                $user_subrole=$subroles[$i];
        ?>
        <option <?php if($usersarray[0]['SUBROLE']==$user_subrole){?> Selected <?php }?>>{{$user_subrole}}</option>
        <?php
        $i=$i+1;
        }
        ?>
    </Select>
    <?php } ?>
        {{-- <Select disabled class="form-control" name="subrole" id="mySelect"> --}}
            {{-- <Select class="form-control" name="subrole" id="mySelect">
          <option>Catering</option>
          <option>Hunting-Reservation</option> --}}
        {{-- </Select> --}}
    </div>
    </div>

    <div class="form-group">
    <label style="font: bold">Change Password </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label class="switch">
      <input type="checkbox" name="toggle" checked>
      <span class="slider round"></span>
    </label>
    <div class="help-tip">
        <p>Yes: User need to change this password on sign on.<br>No: User can directly enter into the dashboard with this password. </p>
    </div>
    </div>
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>
        </div>
                            </div>
                        </div>
                    </main>

                </div>
            </div>

    <script>
        $(function(){
          $('#dynamic_select').on('change', function () {
              var selected_id = $(this).val();
              if(selected_id=='User'){
                document.getElementById("mySelect").disabled = false;
              }
              else{
                document.getElementById("mySelect").disabled = true;
              }


          });
        });
    </script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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
