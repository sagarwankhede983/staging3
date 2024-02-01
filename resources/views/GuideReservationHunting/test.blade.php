
@extends('layouts.admin')
@section('content')

<!-- css start -->
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.column-new {
  float: left;
  width: 16.6%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row-new {margin: 0 -5px;}

/* Clear floats after the columns */
.row-new:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column-new {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}

/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 10%;
  
}

/* Style the buttons inside the tab */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  border: none;
  outline: none;
  text-align: cnter;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
  height:250px;
  width:100%;
  
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 10px 12px;
  border: 1px solid #ccc;
  width: 90%;
  height:750px;
  border-left: none;
}
</style>
<!-- css end -->
<div style="margin-bottom:2%">
<button class="btn btn-primary" onclick="history.go(-1);">Back </button>
</div>
<!-- dynamic header div start -->
<div class="row row-new">
    <div class="column column-new">
      <div class="card" style="background-color:#2B2727">
        <label style="color:aliceblue !important;">Number Of Hunting</label>
        <span  style="color:aliceblue !important;">{{$todayHuntingEventNum_ar[0]['count']}}</span>
      </div>
    </div>
    <div class="column column-new">
      <div class="card" style="background-color:#2B2727">
      <label style="color:aliceblue !important;">Guide Assigned Event</label>
      <span  style="color:aliceblue !important;">{{$todayGuidedEventNum_ar[0]['count']}}</span>
      </div>
    </div>
    <div class="column column-new">
      <div class="card" style="background-color:#2B2727">
      <label style="color:aliceblue !important;">Guide UnAssigned Event</label>
      <span  style="color:aliceblue !important;">{{$todayHuntingEventNum_ar[0]['count']-$todayGuidedEventNum_ar[0]['count']}}</span>
      </div>
    </div>
    <div class="column column-new">
      <div class="card" style="background-color:#2B2727">
      <label style="color:aliceblue !important;">Number Of Total Guide</label>
      <span  style="color:aliceblue !important;">{{$totalNumGuide_ar[0]['count']}}</span>
      </div>
    </div>
    <div class="column column-new">
      <div class="card" style="background-color:#2B2727">
      <label style="color:aliceblue !important;">Number Of Assigned Guide</label>
      <span  style="color:aliceblue !important;">{{$totalAsignedGuide_ar[0]['count']}}</span>
      </div>
    </div>  
    <div class="column column-new">
      <div class="card" style="background-color:#2B2727">
      <label style="color:aliceblue !important;">Number Of UnAssigned Guide</label>
      <span  style="color:aliceblue !important;">{{$totalNumGuide_ar[0]['count']-$totalAsignedGuide_ar[0]['count']}}</span>
      </div>
    </div>
</div>
<!-- dynamic header div end -->
<div>
      <div class="tab">
          <button class="tablinks" onclick="openCity(event, 'Event Detail')" id="defaultOpen">Event Detail</button>
          <button class="tablinks" onclick="openCity(event, 'Assigned Guide')">Assigned Guide</button>
          <button class="tablinks" onclick="openCity(event, 'Unassigned Guide')">Unassigned Guide</button>
      </div>

      <div id="Event Detail" class="tabcontent">
        <div class="card">
          <div class="card-header">
              Hunting
          </div>
          <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover datatable">
                  <thead>
                      <tr>
                          <th class="text-left">SR.NO.</th>
                          <th class="text-left">EVENT ID</th>
                          <th class="text-left">EVENT NAME</th>
                          <th class="text-left">ITEM ID</th>
                          <th class="text-left">ITEM NAME</th>
                          <th class="text-left">DATE</th>
                      </tr>
                  </thead>
                  <tbody>
                                  <?php 
                                            $i=0;
                                            foreach ($todayHuntingEventInfo_ar as $id => $eventcount) {
                                                $event_id=$todayHuntingEventInfo_ar[$i]['event_id'];
                                                $cat_event_type=$todayHuntingEventInfo_ar[$i]['cat_event_type'];
                                                $item_id=$todayHuntingEventInfo_ar[$i]['item_id']; 
                                                $item_name=$todayHuntingEventInfo_ar[$i]['item_name'];
                                                $start_datetime=$todayHuntingEventInfo_ar[$i]['start_datetime'];?>               
                                                <tr style="align-content: center">
                                                    <td class="text-left">{{$i+1}}</td>
                                                    <td class="text-left">{{$event_id}}</td>
                                                    <td class="text-left">{{$cat_event_type}}</td>
                                                    <td class="text-left">{{$item_id}}</td>
                                                    <td class="text-left">{{$item_name}}</td>
                                                    <td class="text-left">{{$start_datetime}}</td>
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

      <div id="Assigned Guide" class="tabcontent">
        <div class="card">
            <div class="card-header">
                Hunting
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th class="text-left">SR.NO.</th>
                            <th class="text-left">ITEM ID</th>
                            <th class="text-left">ITEM NAME</th>
                            <th class="text-left">DATE</th>
                            <th class="text-left">CONTACT PERSON</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                                              $i=0;
                                              foreach ($totalAsignedGuideInfo_ar as $id => $eventcount) {
                                                  $item_id=$totalAsignedGuideInfo_ar[$i]['item_id'];
                                                  $item_name=$totalAsignedGuideInfo_ar[$i]['item_name'];
                                                  $name=$totalAsignedGuideInfo_ar[$i]['name']; 
                                                  $start_datetime=$totalAsignedGuideInfo_ar[$i]['start_datetime'];?>               
                                                  <tr style="align-content: center">
                                                      <td class="text-left">{{$i+1}}</td>
                                                      <td class="text-left">{{$item_id}}</td>
                                                      <td class="text-left">{{$item_name}}</td>
                                                      <td class="text-left">{{$name}}</td>
                                                      <td class="text-left">{{$start_datetime}}</td>
                                                  </tr>
                                                <?php
                                                  $i++;
                                              }
                                ?>
                                  <?php 
                                              $i=0;
                                              foreach ($totalAsignedGuideInfo_ar as $id => $eventcount) {
                                                  $item_id=$totalAsignedGuideInfo_ar[$i]['item_id'];
                                                  $item_name=$totalAsignedGuideInfo_ar[$i]['item_name'];
                                                  $name=$totalAsignedGuideInfo_ar[$i]['name']; 
                                                  $start_datetime=$totalAsignedGuideInfo_ar[$i]['start_datetime'];?>               
                                                  <tr style="align-content: center">
                                                      <td class="text-left">{{$i+1}}</td>
                                                      <td class="text-left">{{$item_id}}</td>
                                                      <td class="text-left">{{$item_name}}</td>
                                                      <td class="text-left">{{$name}}</td>
                                                      <td class="text-left">{{$start_datetime}}</td>
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

      <div id="Unassigned Guide" class="tabcontent">
          <div class="card">
                <div class="card-header">
                    Hunting
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-bordered table-striped table-hover datatable">
                          <thead>
                              <tr>
                                  <th class="text-left">SR.NO.</th>
                                  <th class="text-left">ITEM ID</th>
                                  <th class="text-left">ITEM NAME</th>
                                  <th class="text-left">DATE</th>
                                  <th class="text-left">CONTACT PERSON</th>
                              </tr>
                          </thead>
                          <tbody>
                                          <?php 
                                                    $i=0;
                                                    foreach ($totalAsignedGuideInfo_ar as $id => $eventcount) {
                                                        $item_id=$totalAsignedGuideInfo_ar[$i]['item_id'];
                                                        $item_name=$totalAsignedGuideInfo_ar[$i]['item_name'];
                                                        $name=$totalAsignedGuideInfo_ar[$i]['name']; 
                                                        $start_datetime=$totalAsignedGuideInfo_ar[$i]['start_datetime'];?>               
                                                        <tr style="align-content: center">
                                                            <td class="text-left">{{$i+1}}</td>
                                                            <td class="text-left">{{$item_id}}</td>
                                                            <td class="text-left">{{$item_name}}</td>
                                                            <td class="text-left">{{$name}}</td>
                                                            <td class="text-left">{{$start_datetime}}</td>
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
      <div>
      <!-- Tabulatr  -->
      <script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})


function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
@section('scripts')
@parent
@endsection
@endsection