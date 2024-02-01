@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
           
                <div class="card-body">
                    <form name="myForm" method="POST" action="{{url('/firsttimeuserchangepassword')}}" onsubmit="return validateForm()" autocomplete="off"  >
                        {{ csrf_field() }}
                        <h1>
                            <div class="login-logo">
                                <a href="#">
                                <img src="{{url('/images/kingranch_logo.png')}}" height="50" width="300" style="margin-left:25%">
                                </a>
                            </div>
                        </h1>
                        <p class="text-muted"></p>
                        <div>
                          
                            <div class="form-group">
                                <input type="password" name="passwordchange" class="form-control" placeholder="{{ trans('global.password') }}">
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirm_password" class="form-control" placeholder="{{ trans('global.cpassword') }}">
                               </div>
                            <div class="form-group">
                                <input type="hidden" value="{{$id}}" name="id"></label>
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
                var password = document.forms["myForm"]["passwordchange"].value;
                var confirm_password = document.forms["myForm"]["confirm_password"].value;
                if(password!=="" && confirm_password!=="")
                {
                   
                            if(password!=confirm_password)
                                {
                                    alert("Password missmatch");
                                    return false;  
                                }
                    
                }
                else{
                    if(password==="")
                        {
                            alert("Password can not be blank");
                            return false;
                        }
                        else{
                            if(confirm_password==="")
                            {
                                alert("You must confirm your password");
                                return false;
                            }
                        }
                    
                }
                } 
             
                </script>

        </div>
    </div>
</div>
@endsection