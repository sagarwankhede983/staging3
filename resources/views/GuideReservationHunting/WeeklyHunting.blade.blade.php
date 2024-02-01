@extends('layouts.admincopy')
@section('content')
<!doctype html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="{{ url('/css/bootstrapcssforcalender.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/bootstrapcssforcalender2.css')}}" />

</head>
<body>
<div style="margin-bottom:2%">
<button class="btn btn-primary" onclick="history.go(-1);">Back </button>
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

</style>
</body>
</html>
@endsection



