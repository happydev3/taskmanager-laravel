@can('task_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.tasks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.task.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.task.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-statusTasks">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.task.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.job_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.applicant') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.contact_person') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.lot') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.block') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.plan') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.houseno_unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.street') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.city') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.subdivision') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.ascm') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.tag') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.survey_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.assigned_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.dwg_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.passed') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.failed') }}
                        </th>
                        <th>
                            {{ trans('cruds.task.fields.resurveyed') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $key => $task)
                        <tr data-entry-id="{{ $task->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $task->id ?? '' }}
                            </td>
                            <td>
                                {{ App\Task::JOB_TYPE_RADIO[$task->job_type] ?? '' }}
                            </td>
                            <td>
                                {{ $task->status->name ?? '' }}
                            </td>
                            <td>
                                {{ $task->applicant->first_name ?? '' }}
                            </td>
                            <td>
                                {{ $task->contact_person ?? '' }}
                            </td>
                            <td>
                                {{ $task->name ?? '' }}
                            </td>
                            <td>
                                {{ $task->lot ?? '' }}
                            </td>
                            <td>
                                {{ $task->block ?? '' }}
                            </td>
                            <td>
                                {{ $task->plan ?? '' }}
                            </td>
                            <td>
                                {{ $task->houseno_unit ?? '' }}
                            </td>
                            <td>
                                {{ $task->street ?? '' }}
                            </td>
                            <td>
                                {{ $task->city->city_name ?? '' }}
                            </td>
                            <td>
                                {{ $task->subdivision->subdivision_name ?? '' }}
                            </td>
                            <td>
                                {{ $task->ascm ?? '' }}
                            </td>
                            <td>
                                @foreach($task->tags as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $task->survey_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $task->assigned_to->name ?? '' }}
                            </td>
                            <td>
                                {{ $task->dwg_by->name ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $task->passed ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $task->passed ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $task->failed ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $task->failed ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $task->resurveyed ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $task->resurveyed ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('task_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.tasks.show', $task->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('task_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.tasks.edit', $task->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('task_delete')
                                    <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('task_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tasks.massDestroy') }}",
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
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-statusTasks:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection