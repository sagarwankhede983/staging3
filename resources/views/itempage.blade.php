@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2%">
    <button class="btn btn-primary" onclick="history.go(-1);">Back </button>
</div>
<div style="margin-bottom:2%">
    <select class="chosen" id="dynamic_select">
        <option value="Select All">Select All</option>
        <?php
  $i=0;
    foreach($item_list_ar as $id => $eventcount)
    {
        $item_name=$item_list_ar[$i]['item_name'];
        $item_id=$item_list_ar[$i]['item_id'];

  ?>
        <option value="{{$item_id}}" <?php if($item_id==$selected_id){ ?>selected<?php } ?>>{{$item_name}}</option>
        <?php
    $i++;
    }
    ?>
    </select>
</div>
<script type="text/javascript">
$(".chosen").chosen();
</script>
<div class="card">
    <div class="card-header">
        {{ trans('global.lunch') }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th class="text-left">SR.NO.</th>
                        <th class="text-left">ITEM NAME</th>
                        <th class="text-left">CATEGORY</th>
                        <th class="text-left">COUNT</th>
                        <th class="text-left">EVENT START TIME</th>
                        <th class="text-left">EVENT END TIME</th>
                        <th class="text-left">MORE DETAIL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
              if ($item_data_ar=="") {
                  $i=0;
                  foreach ($item_list_ar as $id => $eventcount) {
                      $item_id=$item_list_ar[$i]['item_id'];
                      $item_category=$item_list_ar[$i]['item_category'];
                      $item_name=$item_list_ar[$i]['item_name'];
                      $item_count=$item_list_ar[$i]['count'];
                      $startdatetime=$item_list_ar[$i]['eventstartat'];
                      $enddatetime=$item_list_ar[$i]['eventendat'];?>
                    <tr style="align-content: center">
                        <td class="text-left">{{$i+1}}</td>
                        <td class="text-left">{{$item_name}}</td>
                        <td class="text-left">{{$item_category}}</td>
                        <td class="text-left">{{$item_count}}</td>
                        <td class="text-left">{{$startdatetime}}</td>
                        <td class="text-left">{{$enddatetime}}</td>
                        <td class="text-left"><a href="viewDetailFromDashboard">View Detail</a></td>
                    </tr>
                    <?php
                $i++;
                  }
              }
              else {
                $i=0;
                foreach ($item_data_ar as $id => $eventcount) {
                  $item_id=$item_data_ar[$i]['item_id'];
                  $item_category=$item_data_ar[$i]['item_category'];
                  $item_name=$item_data_ar[$i]['item_name'];
                  $item_count=$item_data_ar[$i]['count'];
                  $startdatetime=$item_data_ar[$i]['eventstartat'];
                  $enddatetime=$item_data_ar[$i]['eventendat'];
                 ?>
                    <tr style="align-content: center">
                        <td class="text-left">{{$i+1}}</td>
                        <td class="text-left">{{$item_name}}</td>
                        <td class="text-left">{{$item_category}}</td>
                        <td class="text-left">{{$item_count}}</td>
                        <td class="text-left">{{$startdatetime}}</td>
                        <td class="text-left">{{$enddatetime}}</td>
                        <td class="text-left"><a href="viewDetailFromDashboard">View Detail</a></td>
                    </tr>
                    <?php
              $i++;
                }
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
$(function() {
    let deleteButtonTrans = '{{ trans('
    global.datatables.delete ') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.users.massDestroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
            var ids = $.map(dt.rows({
                selected: true
            }).nodes(), function(entry) {
                return $(entry).data('entry-id')
            });

            if (ids.length === 0) {
                alert('{{ trans('
                    global.datatables.zero_selected ') }}')

                return
            }

            if (confirm('{{ trans('
                    global.areYouSure ') }}')) {
                $.ajax({
                        headers: {
                            'x-csrf-token': _token
                        },
                        method: 'POST',
                        url: config.url,
                        data: {
                            ids: ids,
                            _method: 'DELETE'
                        }
                    })
                    .done(function() {
                        location.reload()
                    })
            }
        }
    }
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('user_delete')
    dtButtons.push(deleteButton)
    @endcan

    $('.datatable:not(.ajaxTable)').DataTable({
        buttons: dtButtons
    })
})
$(function() {
    $('#dynamic_select').on('change', function() {
        var selected_id = $(this).val(); // get selected value

        if (selected_id == "Select All") {
            window.location = "/fromDashboarditem";

        } else {
            window.location = "/fromDashboarditem2/" + btoa(selected_id);
        }

    });
});
$(function() {
    $("#demodate").datepicker();
    dateFormat: "yy-dd-mm"
});
</script>


@endsection
@endsection
