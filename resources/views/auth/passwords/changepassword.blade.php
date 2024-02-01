@extends('layouts.app')
@section('content')
    <div class="row justify-content-center" style="margin-top: 10% !important">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <?php
                            if($alertmeassage!="")
                            {
                                if($alertmeassage=="Email sent"){
                                    $alertmeassage="The One time password has been sent on email";
                                ?>
                    {{-- change on 19-05-2023 --}}
                    {{-- <h6 style="font-size: 10;color: green">*{{$alertmeassage}}</h6> --}}
                    <div style="background-color: white;margin-bottom: 3%;padding-bottom: 1%;padding-top: 1%;padding-left: 1%;border-style: solid;border-color: #04AA6D;border-radius: 15px;border-width:thin;"
                        id="mydiv">
                        <div> <strong style="color:#04AA6D;">Success!</strong> <?php echo $alertmeassage; ?>
                        </div>
                    </div>
                    <?php
                                }
                                else{
                                    $alertmeassage="Seems like entered Email is no longer with us";
                                    ?>
                    {{-- <h6 style="font-size: 10;color: red">*{{$alertmeassage}}</h6> --}}
                    <div style="background-color: white;margin-bottom: 3%;padding-bottom: 1%;padding-top: 1%;padding-left: 1%;border-style:solid;border-color: #ff1a1a;border-radius: 15px;border-width:thin"
                        id="mydiv">
                        <strong style="color:#ff1a1a;">Failed!</strong><br>
                        <?php echo $alertmeassage; ?>
                    </div>
                    <?php
                                }
                            }
                            ?>
                    <div class="card-body">
                        <form name="myForm" method="POST" action="{{ url('/verifypasswordandconfirmpassword') }}"
                            onsubmit="return validateForm()" autocomplete="off">
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
                                <div class="form-group">
                                    <input type="text" name="otp" class="form-control"
                                        placeholder="{{ trans('global.otp') }}" maxlength="6">

                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control"
                                        placeholder="{{ trans('global.password') }}">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" class="form-control"
                                        placeholder="{{ trans('global.cpassword') }}">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" value="{{ $id }}" name="uid"></label>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" value="{{ $randomNumber }}" name="randomNumber"></label>
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
                    function validateForm() {
                        var password = document.forms["myForm"]["password"].value;
                        var confirm_password = document.forms["myForm"]["confirm_password"].value;
                        var otp = document.forms["myForm"]["otp"].value;
                        var random_number = document.forms["myForm"]["randomNumber"].value;
                        if (otp !== "" && password !== "" && confirm_password !== "") {
                            if (otp != random_number) {
                                alert("Invalid otp");
                                return false;
                            } else {
                                if (otp.length < 6) {
                                    alert("Password missmatch");
                                    return false;
                                } else {
                                    if (password != confirm_password) {
                                        alert("Password missmatch");
                                        return false;
                                    }
                                }
                            }
                        } else {
                            if (otp === "") {
                                alert("Otp can not be blank");
                                return false;
                            } else {
                                if (password === "") {
                                    alert("Password can not be blank");
                                    return false;
                                } else {
                                    if (confirm_password === "") {
                                        alert("You must confirm your password");
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                    function myFunction() {
                        $('#mydiv').delay(1000).fadeOut(3000);
                    }
                    myFunction();
                </script>
            </div>
        </div>
    </div>
@endsection
