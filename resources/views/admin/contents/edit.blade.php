@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.content.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.contents.update", [$content->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                <label for="image">{{ trans('cruds.content.fields.image') }}*</label>
                <div class="needsclick dropzone" id="image-dropzone">

                </div>
                @if($errors->has('image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.content.fields.image_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                <label for="body">{{ trans('cruds.content.fields.body') }}</label>
                <textarea id="body" name="body" class="form-control ckeditor">{{ old('body', isset($content) ? $content->body : '') }}</textarea>
                @if($errors->has('body'))
                    <em class="invalid-feedback">
                        {{ $errors->first('body') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.content.fields.body_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('lid') ? 'has-error' : '' }}">
                <label for="lid">{{ trans('cruds.content.fields.lid') }}</label>
                <textarea id="lid" name="lid" class="form-control ">{{ old('lid', isset($content) ? $content->lid : '') }}</textarea>
                @if($errors->has('lid'))
                    <em class="invalid-feedback">
                        {{ $errors->first('lid') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.content.fields.lid_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('rutitr') ? 'has-error' : '' }}">
                <label for="rutitr">{{ trans('cruds.content.fields.rutitr') }}</label>
                <input type="text" id="rutitr" name="rutitr" class="form-control" value="{{ old('rutitr', isset($content) ? $content->rutitr : '') }}">
                @if($errors->has('rutitr'))
                    <em class="invalid-feedback">
                        {{ $errors->first('rutitr') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.content.fields.rutitr_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">{{ trans('cruds.content.fields.status') }}</label>
                <select id="status" name="status" class="form-control">
                    <option value="" disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Content::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $content->status) === (string)$key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <em class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </em>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var uploadedImageMap = {}
Dropzone.options.imageDropzone = {
    url: '{{ route('admin.contents.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">')
      uploadedImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedImageMap[file.name]
      }
      $('form').find('input[name="image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($content) && $content->image)
      var files =
        {!! json_encode($content->image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="image[]" value="' + file.file_name + '">')
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
@stop