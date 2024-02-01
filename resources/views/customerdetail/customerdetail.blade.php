@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2%">
<button class="btn btn-primary" onclick="history.go(-1);">Back </button>
</div>
<div class="card">
    <div class="card-header">
        Detail
    </div>
    <div class="card-body">
    <div class="table-responsive">
    <a href="{{ URL::to('/customers/pdf') }}">Export PDF</a>
    <table style="width: 100%">
      <thead>
      </thead>
      <tbody>
           <tr style="column-span: 3">
            <td style="text-align: left"><span class="navbar-brand-full"><img src="{{url('/images/kingranch_logo.png')}}" height="50" width="160" style="margin-bottom:3%"></td>
            <td style="text-align: center">Hunting Recreation & Meals<br>PO Box 733221,Dallas,Tx,75373-3221<br>Tel:832-681-5700 <Fax:832-681-5759><br></Fax:832-681-5759></td>
            <td style="text-align:right">Function #:323<br>Page 1 of 2<br>Co-ordinator:Sheila Martinez<br>Sales Rep: Sheila Martinez</td>
          </tr>
          <tr>
              <td style="text-align: left"></td>
              <td style="text-align: center">BANQUET EVENT ORDER</td>
              <td style="text-align: left"></td>
          </tr>
          <tr>
            <td style="width:33.33%">____________________________________________</td>
            <td style="width:33.33%">____________________________________________</td>
            <td style="width:33.33%">____________________________________________</td>
          <tr>
          <tr>
              <td style="text-align: left">Hunting</td>
              <td style="text-align: center"></td>
              <td style="text-align: right">Tuesday, July 16,2019</td>
          </tr>
          <tr>
              <td style="text-align: left">Account Information<br>
                        Account: {{$customer_data_ar[0]['name']}}<br>
                        Address:  {{$customer_data_ar[0]['address']}}<br>
                        {{$customer_data_ar[0]['city']}},{{$customer_data_ar[0]['state_prov']}},{{$customer_data_ar[0]['postal_code']}}<br>
                        Site Contact: JOHNSON MCMURRY, CECILIA(CECI)  
              </td>
              <td style="text-align: center"></td>
              <td style="text-align: left">Contact Information<br>
                        Name:JOHNSON MCMURRY,CECILIA (CECI)<br>
                        Work #:0<br>
                        Fax #:<br>
                        E-mail:<br>
            </td>
          </tr>
          <tr>
          <td colspan="3">
              <table style="width:100%">
            <thead> 
                    <tr>
                        <th colspan="9" style="text-align:center;background-color: greenyellow">Function Events</th>
                    </tr>
                    <tr>
                        <th>Event Id</th>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Room</th>
                        <th>Event Type</th>
                        <th>Exp. Guests</th>
                        <th>Gtd. Guests</th>
                    </tr>
            </thead>
            <tbody>
                <tr>
                <td>
                </td> 
                <td>
                </td> 
                <td>
                </td> 
                <td>
                </td> 
                <td>
                </td> 
                <td>
                </td> 
                <td>
                </td> 
                <td>
                </td> 
                <td>
                </td>    
            </tr>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
          </td> 
          <tr>
      </tbody>
    </table>
        </div>
    </div>
</div>
@section('scripts')
@parent

@endsection
@endsection