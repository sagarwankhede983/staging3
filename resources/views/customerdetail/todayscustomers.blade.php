
@extends('layouts.admin')
@section('content')

<div style="margin-bottom:2%">
<button class="btn btn-primary" onclick="history.go(-1);">Back </button>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.customerdetail') }}
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover datatable">
            <thead>
                <tr>
                    <th class="text-left">SR.NO.</th>
                    <th class="text-left">CUSTOMER ID</th>
                    <th class="text-left">CUSTOMER NAME</th>
                    <th class="text-left">CUSTOMER PHONE</th>
                    <th class="text-left">EMAIL ADDRESS</th>
                    <th class="text-left">DATE</th>
                    <th class="text-left">EVENT</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i=0;
            foreach ($customer_detail_ar as $id => $eventcount) {
                $customer_id=$customer_detail_ar[$i]['customer_id'];
                $name=$customer_detail_ar[$i]['name'];
                $home_phone=$customer_detail_ar[$i]['home_phone']; 
                $email_address=$customer_detail_ar[$i]['email_address'];
                $start_datetime=$customer_detail_ar[$i]['start_datetime'];
                $cat_event_type=$customer_detail_ar[$i]['event_type'];?>               
                <tr style="align-content: center">
                    <td class="text-left">{{$i+1}}</td>
                    <td class="text-left">{{$customer_id}}</td>
                    <td class="text-left">{{$name}}</td>
                    <td class="text-left">{{$home_phone}}</td>
                    <td class="text-left">{{$email_address}}</td>
                    <td class="text-left">{{$start_datetime}}</td>
                    <td class="text-left">{{$cat_event_type}}</td>
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

@endsection
@endsection