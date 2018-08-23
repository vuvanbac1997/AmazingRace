@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'challenges'] )

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
    Challenges
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\ChallengeController@index') !!}"><i class="fa fa-files-o"></i> Challenges</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $challenge->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\ChallengeController@store') !!} @else {!! action('Admin\ChallengeController@update', [$challenge->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\ChallengeController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('title')) has-error @endif">
                                <label for="title">@lang('admin.pages.challenges.columns.title')</label>
                                <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') ? old('title') : $challenge->title }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('content')) has-error @endif">
                                <label for="content">@lang('admin.pages.challenges.columns.content')</label>
                                <textarea name="content" class="form-control" rows="5" required placeholder="@lang('admin.pages.challenges.columns.content')">{{ old('content') ? old('content') : $challenge->content }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('score')) has-error @endif">
                                <label for="score">@lang('admin.pages.challenges.columns.score')</label>
                                <input type="text" class="form-control" id="score" name="score" required value="{{ old('score') ? old('score') : $challenge->score }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('answer')) has-error @endif">
                                <label for="answer">@lang('admin.pages.challenges.columns.answer')</label>
                                <textarea name="answer" class="form-control" rows="5" required placeholder="@lang('admin.pages.challenges.columns.answer')">{{ old('answer') ? old('answer') : $challenge->answer }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                @if( !empty($challenge->coverImage) )
                                    <img id="cover-image-preview"  style="max-width: 500px; width: 100%;" src="{!! $challenge->present()->coverImage->present()->url !!}" alt="" class="margin" />
                                @else
                                    <img id="cover-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin" />
                                @endif
                                <input type="file" style="display: none;"  id="cover-image" name="cover_image">
                                <p class="help-block" style="font-weight: bolder;">
                                    @lang('admin.pages.challenges.columns.cover_image_id')
                                    <label for="cover-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                                </p>
                            </div>
                        </div>
                    </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="is_enabled">@lang('admin.pages.common.label.is_enabled')</label>
                            <div class="switch">
                                <input id="is_enabled" name="is_enabled" value="1" @if( $challenge->is_enabled) checked @endif class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                                <label for="is_enabled"></label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop
