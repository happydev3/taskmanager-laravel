@extends('layouts.admin')
@section('content')
@can('task_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.tasks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.task.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Task', 'route' => 'admin.tasks.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.task.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Task">
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('task_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tasks.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.tasks.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'job_type', name: 'job_type' },
{ data: 'status_name', name: 'status.name' },
{ data: 'applicant_first_name', name: 'applicant.first_name' },
{ data: 'contact_person', name: 'contact_person' },
{ data: 'name', name: 'name' },
{ data: 'lot', name: 'lot' },
{ data: 'block', name: 'block' },
{ data: 'plan', name: 'plan' },
{ data: 'houseno_unit', name: 'houseno_unit' },
{ data: 'street', name: 'street' },
{ data: 'city_city_name', name: 'city.city_name' },
{ data: 'subdivision_subdivision_name', name: 'subdivision.subdivision_name' },
{ data: 'ascm', name: 'ascm' },
{ data: 'tag', name: 'tags.name' },
{ data: 'survey_by_name', name: 'survey_by.name' },
{ data: 'assigned_to_name', name: 'assigned_to.name' },
{ data: 'dwg_by_name', name: 'dwg_by.name' },
{ data: 'passed', name: 'passed' },
{ data: 'failed', name: 'failed' },
{ data: 'resurveyed', name: 'resurveyed' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Task').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection