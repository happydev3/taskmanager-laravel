@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.task.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.tasks.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            {{--Client Name--}}
                            <div class="form-group">
                                <label class="required" for="applicant_id">{{ trans('cruds.task.fields.applicant') }}</label>
                                <select class="form-control select2 {{ $errors->has('applicant') ? 'is-invalid' : '' }}" name="applicant_id" id="applicant_id" required>
                                    @foreach($applicants as $id => $applicant)
                                        <option value="{{ $id }}" {{ old('applicant_id') == $id ? 'selected' : '' }}>{{ $applicant }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('applicant'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('applicant') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.applicant_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col">
                                    {{--Contact Person--}}
                                    <div class="form-group">
                                        <label for="contact_person">{{ trans('cruds.task.fields.contact_person') }}</label>
                                        <input class="form-control {{ $errors->has('contact_person') ? 'is-invalid' : '' }}" type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', '') }}">
                                        @if($errors->has('contact_person'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('contact_person') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.contact_person_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    {{--Optional E-mail--}}
                                    <div class="form-group">
                                        <label for="optional_email">{{ trans('cruds.task.fields.optional_email') }}</label>
                                        <input class="form-control {{ $errors->has('optional_email') ? 'is-invalid' : '' }}" type="email" name="optional_email" id="optional_email" value="{{ old('optional_email') }}">
                                        @if($errors->has('optional_email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('optional_email') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.optional_email_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            {{--Job Number--}}
                            <div class="form-group">
                                <label for="name">{{ trans('cruds.task.fields.name') }}</label>
                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.name_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            {{--Job Status--}}
                            <div class="form-group">
                                <label class="required" for="status_id">{{ trans('cruds.task.fields.status') }}</label>
                                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                                    @foreach($statuses as $id => $status)
                                        <option value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('status'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('status') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.status_helper') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="required">{{ trans('cruds.task.fields.job_type') }}</label>
                                @foreach(App\Task::JOB_TYPE_RADIO as $key => $label)
                                    <div class="form-check {{ $errors->has('job_type') ? 'is-invalid' : '' }}">
                                        <input class="form-check-input" type="radio" id="job_type_{{ $key }}" name="job_type" value="{{ $key }}" {{ old('job_type', 'grading') === (string) $key ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="job_type_{{ $key }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                                @if($errors->has('job_type'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('job_type') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.job_type_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <div class="form-check {{ $errors->has('passed') ? 'is-invalid' : '' }}">
                                    <input type="hidden" name="passed" value="0">
                                    <input class="form-check-input" type="checkbox" name="passed" id="passed" value="1" {{ old('passed', 0) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="passed">{{ trans('cruds.task.fields.passed') }}</label>
                                </div>
                                @if($errors->has('passed'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('passed') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.passed_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <div class="form-check {{ $errors->has('failed') ? 'is-invalid' : '' }}">
                                    <input type="hidden" name="failed" value="0">
                                    <input class="form-check-input" type="checkbox" name="failed" id="failed" value="1" {{ old('failed', 0) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="failed">{{ trans('cruds.task.fields.failed') }}</label>
                                </div>
                                @if($errors->has('failed'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('failed') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.failed_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <div class="form-check {{ $errors->has('resurveyed') ? 'is-invalid' : '' }}">
                                    <input type="hidden" name="resurveyed" value="0">
                                    <input class="form-check-input" type="checkbox" name="resurveyed" id="resurveyed" value="1" {{ old('resurveyed', 0) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="resurveyed">{{ trans('cruds.task.fields.resurveyed') }}</label>
                                </div>
                                @if($errors->has('resurveyed'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('resurveyed') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.resurveyed_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-10 bg-light">
                            <div class="row">
                                <div class="col">
                                    {{--Lot--}}
                                    <div class="form-group">
                                        <label for="lot">{{ trans('cruds.task.fields.lot') }}</label>
                                        <input class="form-control {{ $errors->has('lot') ? 'is-invalid' : '' }}" type="text" name="lot" id="lot" value="{{ old('lot', '') }}">
                                        @if($errors->has('lot'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('lot') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.lot_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    {{--Block--}}
                                    <div class="form-group">
                                        <label for="block">{{ trans('cruds.task.fields.block') }}</label>
                                        <input class="form-control {{ $errors->has('block') ? 'is-invalid' : '' }}" type="text" name="block" id="block" value="{{ old('block', '') }}">
                                        @if($errors->has('block'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('block') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.block_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    {{--Plan--}}
                                    <div class="form-group">
                                        <label for="plan">{{ trans('cruds.task.fields.plan') }}</label>
                                        <input class="form-control {{ $errors->has('plan') ? 'is-invalid' : '' }}" type="text" name="plan" id="plan" value="{{ old('plan', '') }}">
                                        @if($errors->has('plan'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('plan') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.plan_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    {{--House # / Unit--}}
                                    <div class="form-group">
                                        <label for="houseno_unit">{{ trans('cruds.task.fields.houseno_unit') }}</label>
                                        <input class="form-control {{ $errors->has('houseno_unit') ? 'is-invalid' : '' }}" type="text" name="houseno_unit" id="houseno_unit" value="{{ old('houseno_unit', '') }}">
                                        @if($errors->has('houseno_unit'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('houseno_unit') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.houseno_unit_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    {{--Street--}}
                                    <div class="form-group">
                                        <label for="street">{{ trans('cruds.task.fields.street') }}</label>
                                        <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', '') }}">
                                        @if($errors->has('street'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('street') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.street_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    {{--City--}}
                                    <div class="form-group">
                                        <label for="city_id">{{ trans('cruds.task.fields.city') }}</label>
                                        <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                                            @foreach($cities as $id => $city)
                                                <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $city }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('city'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('city') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.city_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    {{--Subdivision--}}
                                    <div class="form-group">
                                        <label for="subdivision_id">{{ trans('cruds.task.fields.subdivision') }}</label>
                                        <select class="form-control select2 {{ $errors->has('subdivision') ? 'is-invalid' : '' }}" name="subdivision_id" id="subdivision_id">
                                            @foreach($subdivisions as $id => $subdivision)
                                                <option value="{{ $id }}" {{ old('subdivision_id') == $id ? 'selected' : '' }}>{{ $subdivision }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('subdivision'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('subdivision') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.subdivision_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    {{--ASCM--}}
                                    <div class="form-group">
                                        <label for="ascm">{{ trans('cruds.task.fields.ascm') }}</label>
                                        <input class="form-control {{ $errors->has('ascm') ? 'is-invalid' : '' }}" type="text" name="ascm" id="ascm" value="{{ old('ascm', '') }}">
                                        @if($errors->has('ascm'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('ascm') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.task.fields.ascm_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><div class="form-group">
                                <label for="client_file">{{ trans('cruds.task.fields.client_file') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('client_file') ? 'is-invalid' : '' }}" id="client_file-dropzone">
                                </div>
                                @if($errors->has('client_file'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('client_file') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.client_file_helper') }}</span>
                            </div></div>
                        <div class="col"><div class="form-group">
                                <label for="field_file">{{ trans('cruds.task.fields.field_file') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('field_file') ? 'is-invalid' : '' }}" id="field_file-dropzone">
                                </div>
                                @if($errors->has('field_file'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('field_file') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.field_file_helper') }}</span>
                            </div></div>
                        <div class="col"><div class="form-group">
                                <label for="dwg_file">{{ trans('cruds.task.fields.dwg_file') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('dwg_file') ? 'is-invalid' : '' }}" id="dwg_file-dropzone">
                                </div>
                                @if($errors->has('dwg_file'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('dwg_file') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.dwg_file_helper') }}</span>
                            </div></div>
                        <div class="col"><div class="form-group">
                                <label for="final_file">{{ trans('cruds.task.fields.final_file') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('final_file') ? 'is-invalid' : '' }}" id="final_file-dropzone">
                                </div>
                                @if($errors->has('final_file'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('final_file') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.final_file_helper') }}</span>
                            </div></div>
                        <div class="col"><div class="form-group">
                                <label for="authority_file">{{ trans('cruds.task.fields.authority_file') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('authority_file') ? 'is-invalid' : '' }}" id="authority_file-dropzone">
                                </div>
                                @if($errors->has('authority_file'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('authority_file') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.authority_file_helper') }}</span>
                            </div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{--Description--}}
                            <div class="form-group">
                                <label for="description">{{ trans('cruds.task.fields.description') }}</label>
                                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.description_helper') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{--Tags--}}
                            <div class="form-group">
                                <label for="tags">{{ trans('cruds.task.fields.tag') }}</label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                </div>
                                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                                    @foreach($tags as $id => $tag)
                                        <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('tags'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tags') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.tag_helper') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><div class="form-group">
                                <label for="due_date">{{ trans('cruds.task.fields.due_date') }}</label>
                                <input class="form-control date {{ $errors->has('due_date') ? 'is-invalid' : '' }}" type="text" name="due_date" id="due_date" value="{{ old('due_date') }}">
                                @if($errors->has('due_date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('due_date') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.due_date_helper') }}</span>
                            </div></div>
                        <div class="col-md-3"><div class="form-group">
                                <label for="survey_by_id">{{ trans('cruds.task.fields.survey_by') }}</label>
                                <select class="form-control select2 {{ $errors->has('survey_by') ? 'is-invalid' : '' }}" name="survey_by_id" id="survey_by_id">
                                    @foreach($survey_bies as $id => $survey_by)
                                        <option value="{{ $id }}" {{ old('survey_by_id') == $id ? 'selected' : '' }}>{{ $survey_by }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('survey_by'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('survey_by') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.survey_by_helper') }}</span>
                            </div></div>
                        <div class="col-md-3"><div class="form-group">
                                <label for="dwg_by_id">{{ trans('cruds.task.fields.dwg_by') }}</label>
                                <select class="form-control select2 {{ $errors->has('dwg_by') ? 'is-invalid' : '' }}" name="dwg_by_id" id="dwg_by_id">
                                    @foreach($dwg_bies as $id => $dwg_by)
                                        <option value="{{ $id }}" {{ old('dwg_by_id') == $id ? 'selected' : '' }}>{{ $dwg_by }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('dwg_by'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('dwg_by') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.dwg_by_helper') }}</span>
                            </div></div>
                        <div class="col-md-3"><div class="form-group">
                                <label for="assigned_to_id">{{ trans('cruds.task.fields.assigned_to') }}</label>
                                <select class="form-control select2 {{ $errors->has('assigned_to') ? 'is-invalid' : '' }}" name="assigned_to_id" id="assigned_to_id">
                                    @foreach($assigned_tos as $id => $assigned_to)
                                        <option value="{{ $id }}" {{ old('assigned_to_id') == $id ? 'selected' : '' }}>{{ $assigned_to }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('assigned_to'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('assigned_to') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.task.fields.assigned_to_helper') }}</span>
                            </div></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <button class="btn-lg btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--           <div class="form-group">
                               <label class="required">{{ trans('cruds.task.fields.job_type') }}</label>
                               @foreach(App\Task::JOB_TYPE_RADIO as $key => $label)
                                   <div class="form-check {{ $errors->has('job_type') ? 'is-invalid' : '' }}">
                                       <input class="form-check-input" type="radio" id="job_type_{{ $key }}" name="job_type" value="{{ $key }}" {{ old('job_type', 'grading') === (string) $key ? 'checked' : '' }} required>
                                       <label class="form-check-label" for="job_type_{{ $key }}">{{ $label }}</label>
                                   </div>
                               @endforeach
                               @if($errors->has('job_type'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('job_type') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.job_type_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label class="required" for="status_id">{{ trans('cruds.task.fields.status') }}</label>
                               <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                                   @foreach($statuses as $id => $status)
                                       <option value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $status }}</option>
                                   @endforeach
                               </select>
                               @if($errors->has('status'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('status') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.status_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label class="required" for="applicant_id">{{ trans('cruds.task.fields.applicant') }}</label>
                               <select class="form-control select2 {{ $errors->has('applicant') ? 'is-invalid' : '' }}" name="applicant_id" id="applicant_id" required>
                                   @foreach($applicants as $id => $applicant)
                                       <option value="{{ $id }}" {{ old('applicant_id') == $id ? 'selected' : '' }}>{{ $applicant }}</option>
                                   @endforeach
                               </select>
                               @if($errors->has('applicant'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('applicant') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.applicant_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="optional_email">{{ trans('cruds.task.fields.optional_email') }}</label>
                               <input class="form-control {{ $errors->has('optional_email') ? 'is-invalid' : '' }}" type="email" name="optional_email" id="optional_email" value="{{ old('optional_email') }}">
                               @if($errors->has('optional_email'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('optional_email') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.optional_email_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="contact_person">{{ trans('cruds.task.fields.contact_person') }}</label>
                               <input class="form-control {{ $errors->has('contact_person') ? 'is-invalid' : '' }}" type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', '') }}">
                               @if($errors->has('contact_person'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('contact_person') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.contact_person_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="name">{{ trans('cruds.task.fields.name') }}</label>
                               <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                               @if($errors->has('name'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('name') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.name_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="lot">{{ trans('cruds.task.fields.lot') }}</label>
                               <input class="form-control {{ $errors->has('lot') ? 'is-invalid' : '' }}" type="text" name="lot" id="lot" value="{{ old('lot', '') }}">
                               @if($errors->has('lot'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('lot') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.lot_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="block">{{ trans('cruds.task.fields.block') }}</label>
                               <input class="form-control {{ $errors->has('block') ? 'is-invalid' : '' }}" type="text" name="block" id="block" value="{{ old('block', '') }}">
                               @if($errors->has('block'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('block') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.block_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="plan">{{ trans('cruds.task.fields.plan') }}</label>
                               <input class="form-control {{ $errors->has('plan') ? 'is-invalid' : '' }}" type="text" name="plan" id="plan" value="{{ old('plan', '') }}">
                               @if($errors->has('plan'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('plan') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.plan_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="houseno_unit">{{ trans('cruds.task.fields.houseno_unit') }}</label>
                               <input class="form-control {{ $errors->has('houseno_unit') ? 'is-invalid' : '' }}" type="text" name="houseno_unit" id="houseno_unit" value="{{ old('houseno_unit', '') }}">
                               @if($errors->has('houseno_unit'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('houseno_unit') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.houseno_unit_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="street">{{ trans('cruds.task.fields.street') }}</label>
                               <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', '') }}">
                               @if($errors->has('street'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('street') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.street_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="city_id">{{ trans('cruds.task.fields.city') }}</label>
                               <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                                   @foreach($cities as $id => $city)
                                       <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $city }}</option>
                                   @endforeach
                               </select>
                               @if($errors->has('city'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('city') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.city_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="subdivision_id">{{ trans('cruds.task.fields.subdivision') }}</label>
                               <select class="form-control select2 {{ $errors->has('subdivision') ? 'is-invalid' : '' }}" name="subdivision_id" id="subdivision_id">
                                   @foreach($subdivisions as $id => $subdivision)
                                       <option value="{{ $id }}" {{ old('subdivision_id') == $id ? 'selected' : '' }}>{{ $subdivision }}</option>
                                   @endforeach
                               </select>
                               @if($errors->has('subdivision'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('subdivision') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.subdivision_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="ascm">{{ trans('cruds.task.fields.ascm') }}</label>
                               <input class="form-control {{ $errors->has('ascm') ? 'is-invalid' : '' }}" type="text" name="ascm" id="ascm" value="{{ old('ascm', '') }}">
                               @if($errors->has('ascm'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('ascm') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.ascm_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="client_file">{{ trans('cruds.task.fields.client_file') }}</label>
                               <div class="needsclick dropzone {{ $errors->has('client_file') ? 'is-invalid' : '' }}" id="client_file-dropzone">
                               </div>
                               @if($errors->has('client_file'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('client_file') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.client_file_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="field_file">{{ trans('cruds.task.fields.field_file') }}</label>
                               <div class="needsclick dropzone {{ $errors->has('field_file') ? 'is-invalid' : '' }}" id="field_file-dropzone">
                               </div>
                               @if($errors->has('field_file'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('field_file') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.field_file_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="dwg_file">{{ trans('cruds.task.fields.dwg_file') }}</label>
                               <div class="needsclick dropzone {{ $errors->has('dwg_file') ? 'is-invalid' : '' }}" id="dwg_file-dropzone">
                               </div>
                               @if($errors->has('dwg_file'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('dwg_file') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.dwg_file_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="final_file">{{ trans('cruds.task.fields.final_file') }}</label>
                               <div class="needsclick dropzone {{ $errors->has('final_file') ? 'is-invalid' : '' }}" id="final_file-dropzone">
                               </div>
                               @if($errors->has('final_file'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('final_file') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.final_file_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="authority_file">{{ trans('cruds.task.fields.authority_file') }}</label>
                               <div class="needsclick dropzone {{ $errors->has('authority_file') ? 'is-invalid' : '' }}" id="authority_file-dropzone">
                               </div>
                               @if($errors->has('authority_file'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('authority_file') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.authority_file_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="description">{{ trans('cruds.task.fields.description') }}</label>
                               <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                               @if($errors->has('description'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('description') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.description_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="tags">{{ trans('cruds.task.fields.tag') }}</label>
                               <div style="padding-bottom: 4px">
                                   <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                   <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                               </div>
                               <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                                   @foreach($tags as $id => $tag)
                                       <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                                   @endforeach
                               </select>
                               @if($errors->has('tags'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('tags') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.tag_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="survey_by_id">{{ trans('cruds.task.fields.survey_by') }}</label>
                               <select class="form-control select2 {{ $errors->has('survey_by') ? 'is-invalid' : '' }}" name="survey_by_id" id="survey_by_id">
                                   @foreach($survey_bies as $id => $survey_by)
                                       <option value="{{ $id }}" {{ old('survey_by_id') == $id ? 'selected' : '' }}>{{ $survey_by }}</option>
                                   @endforeach
                               </select>
                               @if($errors->has('survey_by'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('survey_by') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.survey_by_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="assigned_to_id">{{ trans('cruds.task.fields.assigned_to') }}</label>
                               <select class="form-control select2 {{ $errors->has('assigned_to') ? 'is-invalid' : '' }}" name="assigned_to_id" id="assigned_to_id">
                                   @foreach($assigned_tos as $id => $assigned_to)
                                       <option value="{{ $id }}" {{ old('assigned_to_id') == $id ? 'selected' : '' }}>{{ $assigned_to }}</option>
                                   @endforeach
                               </select>
                               @if($errors->has('assigned_to'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('assigned_to') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.assigned_to_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="dwg_by_id">{{ trans('cruds.task.fields.dwg_by') }}</label>
                               <select class="form-control select2 {{ $errors->has('dwg_by') ? 'is-invalid' : '' }}" name="dwg_by_id" id="dwg_by_id">
                                   @foreach($dwg_bies as $id => $dwg_by)
                                       <option value="{{ $id }}" {{ old('dwg_by_id') == $id ? 'selected' : '' }}>{{ $dwg_by }}</option>
                                   @endforeach
                               </select>
                               @if($errors->has('dwg_by'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('dwg_by') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.dwg_by_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <label for="due_date">{{ trans('cruds.task.fields.due_date') }}</label>
                               <input class="form-control date {{ $errors->has('due_date') ? 'is-invalid' : '' }}" type="text" name="due_date" id="due_date" value="{{ old('due_date') }}">
                               @if($errors->has('due_date'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('due_date') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.due_date_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <div class="form-check {{ $errors->has('passed') ? 'is-invalid' : '' }}">
                                   <input type="hidden" name="passed" value="0">
                                   <input class="form-check-input" type="checkbox" name="passed" id="passed" value="1" {{ old('passed', 0) == 1 ? 'checked' : '' }}>
                                   <label class="form-check-label" for="passed">{{ trans('cruds.task.fields.passed') }}</label>
                               </div>
                               @if($errors->has('passed'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('passed') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.passed_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <div class="form-check {{ $errors->has('failed') ? 'is-invalid' : '' }}">
                                   <input type="hidden" name="failed" value="0">
                                   <input class="form-check-input" type="checkbox" name="failed" id="failed" value="1" {{ old('failed', 0) == 1 ? 'checked' : '' }}>
                                   <label class="form-check-label" for="failed">{{ trans('cruds.task.fields.failed') }}</label>
                               </div>
                               @if($errors->has('failed'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('failed') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.failed_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <div class="form-check {{ $errors->has('resurveyed') ? 'is-invalid' : '' }}">
                                   <input type="hidden" name="resurveyed" value="0">
                                   <input class="form-check-input" type="checkbox" name="resurveyed" id="resurveyed" value="1" {{ old('resurveyed', 0) == 1 ? 'checked' : '' }}>
                                   <label class="form-check-label" for="resurveyed">{{ trans('cruds.task.fields.resurveyed') }}</label>
                               </div>
                               @if($errors->has('resurveyed'))
                                   <div class="invalid-feedback">
                                       {{ $errors->first('resurveyed') }}
                                   </div>
                               @endif
                               <span class="help-block">{{ trans('cruds.task.fields.resurveyed_helper') }}</span>
                           </div>
                           <div class="form-group">
                               <button class="btn btn-danger" type="submit">
                                   {{ trans('global.save') }}
                               </button>
                           </div> --}}
            </form>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        var uploadedClientFileMap = {}
        Dropzone.options.clientFileDropzone = {
            url: '{{ route('admin.tasks.storeMedia') }}',
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 20
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="client_file[]" value="' + response.name + '">')
                uploadedClientFileMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedClientFileMap[file.name]
                }
                $('form').find('input[name="client_file[]"][value="' + name + '"]').remove()
            },
            init: function () {
                    @if(isset($task) && $task->client_file)
                var files =
                {!! json_encode($task->client_file) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="client_file[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        var uploadedFieldFileMap = {}
        Dropzone.options.fieldFileDropzone = {
            url: '{{ route('admin.tasks.storeMedia') }}',
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 20
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="field_file[]" value="' + response.name + '">')
                uploadedFieldFileMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedFieldFileMap[file.name]
                }
                $('form').find('input[name="field_file[]"][value="' + name + '"]').remove()
            },
            init: function () {
                    @if(isset($task) && $task->field_file)
                var files =
                {!! json_encode($task->field_file) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="field_file[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        var uploadedDwgFileMap = {}
        Dropzone.options.dwgFileDropzone = {
            url: '{{ route('admin.tasks.storeMedia') }}',
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 20
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="dwg_file[]" value="' + response.name + '">')
                uploadedDwgFileMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDwgFileMap[file.name]
                }
                $('form').find('input[name="dwg_file[]"][value="' + name + '"]').remove()
            },
            init: function () {
                    @if(isset($task) && $task->dwg_file)
                var files =
                {!! json_encode($task->dwg_file) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="dwg_file[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        var uploadedFinalFileMap = {}
        Dropzone.options.finalFileDropzone = {
            url: '{{ route('admin.tasks.storeMedia') }}',
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 20
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="final_file[]" value="' + response.name + '">')
                uploadedFinalFileMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedFinalFileMap[file.name]
                }
                $('form').find('input[name="final_file[]"][value="' + name + '"]').remove()
            },
            init: function () {
                    @if(isset($task) && $task->final_file)
                var files =
                {!! json_encode($task->final_file) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="final_file[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        var uploadedAuthorityFileMap = {}
        Dropzone.options.authorityFileDropzone = {
            url: '{{ route('admin.tasks.storeMedia') }}',
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 20
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="authority_file[]" value="' + response.name + '">')
                uploadedAuthorityFileMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedAuthorityFileMap[file.name]
                }
                $('form').find('input[name="authority_file[]"][value="' + name + '"]').remove()
            },
            init: function () {
                    @if(isset($task) && $task->authority_file)
                var files =
                {!! json_encode($task->authority_file) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="authority_file[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection
