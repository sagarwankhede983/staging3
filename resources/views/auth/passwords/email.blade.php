@extends('layouts.app')
@section('content')
    <div class="row justify-content-center" style="margin-top: 10% !important">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <?php
                            if($alertmeassage!="")
                            {
                                // dd($alertmeassage);
                                if($alertmeassage=="Email sent"){
                                    $alertmeassage="The One time password has been sent on email";
                                ?>
                                {{-- change on 19-05-2027 --}}
                    {{-- <h6 style="font-size: 10;color: green">*{{$alertmeassage}}</h6> --}}
                    <div style="background-color: white;margin-bottom: 3%;padding-bottom: 1%;padding-top: 1%;padding-left: 1%;border-style: solid;border-color: #04AA6D;border-radius: 15px;border-width:thin;"
                        id="mydiv" onload="myFunction()">
                        <div> <strong style="color:#04AA6D;">Success!</strong> <?php echo $alertmeassage; ?>
                        </div>
                    </div>
                    <?php
                                }
                                else{
                                    $alertmeassage="Seems like entered Email is no longer with us";
                                    ?>
                    {{-- <h6 style="font-size: 10;color: red">*{{ $alertmeassage }}</h6> --}}
                    <div style="background-color: white;margin-bottom: 3%;padding-bottom: 1%;padding-top: 1%;padding-left: 1%;border-style:solid;border-color: #ff1a1a;border-radius: 15px;border-width:thin"
                        id="mydiv">
                        <strong style="color:#ff1a1a;">Failed!</strong>
                        <?php echo $alertmeassage; ?>
                    </div>
                    <?php
                                }
                            }
                            ?>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <h1>
                                <div class="login-logo">
                                    <a href="#">
                                        <img src="{{ url('/images/kingranch_logo.png') }}" height="50" width="300"
                                            style="margin-left:25%">
                                    </a>
                                </div>
                            </h1>
                            <p class="text-muted"></p>
                            <div>
                                {{ csrf_field() }}
                                <div class="form-group has-feedback">
                                    <input type="email" name="email" class="form-control"
                                        required="required"="autofocus" placeholder="{{ trans('global.login_email') }}">
                                    @if ($errors->has('email'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </em>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                                        {{ trans('global.reset_password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    function myFunction() {
                        $('#mydiv').delay(1000).fadeOut(3000);
                    }
                    myFunction();
                </script>
            </div>
        </div>
    </div>
@endsection
