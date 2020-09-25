@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.comment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.comments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.comment.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comment.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="related_task_id">{{ trans('cruds.comment.fields.related_task') }}</label>
                <select class="form-control select2 {{ $errors->has('related_task') ? 'is-invalid' : '' }}" name="related_task_id" id="related_task_id" required>
                    @foreach($related_tasks as $id => $related_task)
                        <option value="{{ $id }}" {{ old('related_task_id') == $id ? 'selected' : '' }}>{{ $related_task }}</option>
                    @endforeach
                </select>
                @if($errors->has('related_task'))
                    <div class="invalid-feedback">
                        {{ $errors->first('related_task') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comment.fields.related_task_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comment">{{ trans('cruds.comment.fields.comment') }}</label>
                <input class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" type="text" name="comment" id="comment" value="{{ old('comment', '') }}">
                @if($errors->has('comment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comment.fields.comment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comment_file">{{ trans('cruds.comment.fields.comment_file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('comment_file') ? 'is-invalid' : '' }}" id="comment_file-dropzone">
                </div>
                @if($errors->has('comment_file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comment_file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comment.fields.comment_file_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedCommentFileMap = {}
Dropzone.options.commentFileDropzone = {
    url: '{{ route('admin.comments.storeMedia') }}',
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="comment_file[]" value="' + response.name + '">')
      uploadedCommentFileMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedCommentFileMap[file.name]
      }
      $('form').find('input[name="comment_file[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($comment) && $comment->comment_file)
          var files =
            {!! json_encode($comment->comment_file) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="comment_file[]" value="' + file.file_name + '">')
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