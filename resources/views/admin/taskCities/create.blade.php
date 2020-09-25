@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.taskCity.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.task-cities.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="city_name">{{ trans('cruds.taskCity.fields.city_name') }}</label>
                <input class="form-control {{ $errors->has('city_name') ? 'is-invalid' : '' }}" type="text" name="city_name" id="city_name" value="{{ old('city_name', '') }}">
                @if($errors->has('city_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taskCity.fields.city_name_helper') }}</span>
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