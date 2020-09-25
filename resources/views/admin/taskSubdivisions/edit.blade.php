@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.taskSubdivision.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.task-subdivisions.update", [$taskSubdivision->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="subdivision_name">{{ trans('cruds.taskSubdivision.fields.subdivision_name') }}</label>
                <input class="form-control {{ $errors->has('subdivision_name') ? 'is-invalid' : '' }}" type="text" name="subdivision_name" id="subdivision_name" value="{{ old('subdivision_name', $taskSubdivision->subdivision_name) }}" required>
                @if($errors->has('subdivision_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subdivision_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taskSubdivision.fields.subdivision_name_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection