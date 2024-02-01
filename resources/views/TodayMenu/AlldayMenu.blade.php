@extends('layouts.admin')
@section('content')

<div style="margin-bottom:2%">
<button class="btn btn-primary" onclick="history.go(-1);">Back </button>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
<form method="post" action="/testpdfonclick">
{{ csrf_field() }}
<div class="container" style="margin-bottom: 2%">

<label>From Date:</label><input style="margin-left: 1%" name="filterdate" id="demodate" >
<label>To Date:</label><input style="margin-left: 1%" name="filterdate2" id="demodate2" >
<button style="margin-left: 1%" type="submit" class="btn btn-primary" id="btn_submit">Submit</button>

</div>

</form>

<div class="card">
    <div class="card-header">
        Menus
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover datatable">
            <thead>
                <tr>
                    <th class="text-left">SR.NO.</th>
                    <th class="text-left">ITEM ID</th>
                    <th class="text-left">ITEM NAME</th>
                    <th class="text-left">ITEM DESCRIPTION</th>
                    <th class="text-left">ITEM COUNT</th>
                    <th class="text-left">DATE</th>
                    <th class="text-left">MORE DETAIL</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            foreach ($appetizer_ar as $id => $eventcount) {
                $itemcount=$appetizer_ar[$i]['itemcount'];
                $item_id=$appetizer_ar[$i]['item_id'];
                $item_name=$appetizer_ar[$i]['item_name'];
                $item_desc_db=$appetizer_ar[$i]['item_desc'];
                if(empty($item_desc_db)){
      $item_desc_db="NA";
    }
                $start_datetime=$appetizer_ar[$i]['start_datetime'];?>
                <tr style="align-content: center">
                    <td class="text-left">{{$i+1}}</td>
                    <td class="text-left">{{$item_id}}</td>
                    <td class="text-left">{{$item_name}}</td>
                    <td class="text-left">{{$item_desc_db}}</td>
                    <td class="text-left">{{$itemcount}}</td>
                    <td class="text-left">{{$start_datetime}}</td>
                    <td class="text-left"><a href="/viewDetailFromDashboard\{{base64_encode($item_id)}}\{{base64_encode($item_name)}}\{{base64_encode($item_desc_db)}}\{{base64_encode($start_datetime)}}">View Detail</a></td>
                </tr>
                <tr style="align-content: center">
                    <td class="text-left">{{$i+1}}</td>
                    <td class="text-left">{{$item_id}}</td>
                    <td class="text-left">{{$item_name}}</td>
                    <td class="text-left">{{$item_desc_db}}</td>
                    <td class="text-left">{{$itemcount}}</td>
                    <td class="text-left">{{$start_datetime}}</td>
                    <td class="text-left"><a href="/viewDetailFromDashboard\{{base64_encode($item_id)}}\{{base64_encode($item_name)}}\{{base64_encode($item_desc_db)}}\{{base64_encode($start_datetime)}}">View Detail</a></td>
                </tr>
                <tr style="align-content: center">
                    <td class="text-left">{{$i+1}}</td>
                    <td class="text-left">{{$item_id}}</td>
                    <td class="text-left">{{$item_name}}</td>
                    <td class="text-left">{{$item_desc_db}}</td>
                    <td class="text-left">{{$itemcount}}</td>
                    <td class="text-left">{{$start_datetime}}</td>
                    <td class="text-left"><a href="/viewDetailFromDashboard\{{base64_encode($item_id)}}\{{base64_encode($item_name)}}\{{base64_encode($item_desc_db)}}\{{base64_encode($start_datetime)}}">View Detail</a></td>
                </tr>
                <tr style="align-content: center">
                    <td class="text-left">{{$i+1}}</td>
                    <td class="text-left">{{$item_id}}</td>
                    <td class="text-left">{{$item_name}}</td>
                    <td class="text-left">{{$item_desc_db}}</td>
                    <td class="text-left">{{$itemcount}}</td>
                    <td class="text-left">{{$start_datetime}}</td>
                    <td class="text-left"><a href="/viewDetailFromDashboard\{{base64_encode($item_id)}}\{{base64_encode($item_name)}}\{{base64_encode($item_desc_db)}}\{{base64_encode($start_datetime)}}">View Detail</a></td>
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
@section('scripts')
@parent
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

</script>
 <script>
  $(function() {
    $( "#demodate" ).datepicker();
    dateFormat: "yy-dd-mm"
  });

  </script>
  <script>
  $(function() {
    $( "#demodate2" ).datepicker();
    dateFormat: "yy-dd-mm"
  });

  </script>
<!-- <script src="http://code.jquery.com/jquery-2.1.3.js"></script> -- -->
<!-- <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script> -->
<script type="text/javascript" src="{{ url('/js/calenderdate.js') }}"></script>
@endsection
@endsection
