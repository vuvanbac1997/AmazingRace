@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'teams'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            $("#cover-image").change(function (event) {
                $("#cover-image-preview").attr("src", URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Teams
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\TeamController@index') !!}"><i class="fa fa-files-o"></i> Teams</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $team->id }}</li>
    @endif
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="@if($isNew) {!! action('Admin\TeamController@store') !!} @else {!! action('Admin\TeamController@update', [$team->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\TeamController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="container">
                    
                </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group text-center">
                                @if( !empty($team->coverImage) )
                                    <img id="cover-image-preview"  style="max-width: 500px; width: 100%;" src="{!! $team->present()->coverImage->present()->url !!}" alt="" class="margin" />
                                @else
                                    <img id="cover-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin" />
                                @endif
                                <input type="file" style="display: none;"  id="cover-image" name="cover_image">
                                <p class="help-block" style="font-weight: bolder;">
                                    @lang('admin.pages.teams.columns.cover_image_id')
                                    <label for="cover-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if ($errors->has('username')) has-error @endif">
                                <label for="username">@lang('admin.pages.teams.columns.username')</label>
                                <input type="text" class="form-control" id="username" name="username" required value="{{ old('username') ? old('username') : $team->username }}">
                            </div>

                            <div class="form-group @if ($errors->has('display_name')) has-error @endif">
                                <label for="display_name">@lang('admin.pages.teams.columns.display_name')</label>
                                <input type="text" class="form-control" id="display_name" name="display_name" required value="{{ old('display_name') ? old('display_name') : $team->display_name }}">
                            </div>
                            <div class="form-group @if ($errors->has('password')) has-error @endif">
                                <label for="password">@lang('admin.pages.teams.columns.password')</label>
                                <input type="text" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="is_enabled">@lang('admin.pages.common.label.is_enabled')</label>
                                <div class="switch">
                                    <input id="is_enabled" name="is_enabled" value="1" @if( $team->is_enabled) checked @endif class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                                    <label for="is_enabled"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                    </div>


                <div class="row">
                    <div class="col-md-12">
                        
                    </div>
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop
