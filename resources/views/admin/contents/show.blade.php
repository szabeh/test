@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.content.title') }}
    </div>

    <div class="card-body">
        <div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.content.fields.image') }}
                        </th>
                        <td>
                            @foreach($content->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.content.fields.body') }}
                        </th>
                        <td>
                            {!! $content->body !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.content.fields.lid') }}
                        </th>
                        <td>
                            {!! $content->lid !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.content.fields.rutitr') }}
                        </th>
                        <td>
                            {{ $content->rutitr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.content.fields.status') }}
                        </th>
                        <td>
                            {{ App\Content::STATUS_SELECT[$content->status] }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
@endsection