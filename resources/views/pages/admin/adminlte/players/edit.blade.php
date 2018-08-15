@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'players'] )

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
    Players
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\PlayerController@index') !!}"><i class="fa fa-files-o"></i> Players</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $player->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\PlayerController@store') !!} @else {!! action('Admin\PlayerController@update', [$player->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\PlayerController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group text-center">
                                @if( !empty($player->coverImage) )
                                    <img id="cover-image-preview"  style="max-width: 500px; width: 100%;" src="{!! $player->present()->coverImage->present()->url !!}" alt="" class="margin" />
                                @else
                                    <img id="cover-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin" />
                                @endif
                                <input type="file" style="display: none;"  id="cover-image" name="cover_image">
                                <p class="help-block" style="font-weight: bolder;">
                                    @lang('admin.pages.players.columns.cover_image_id')
                                    <label for="cover-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                <label for="name">@lang('admin.pages.players.columns.name')</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $player->name }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group @if ($errors->has('id_coach')) has-error @endif">
                                <label for="id_coach">@lang('admin.pages.players.columns.id_coach')</label>
                                <input type="text" class="form-control" id="id_coach" name="id_coach" required value="{{ old('id_coach') ? old('id_coach') : $player->id_coach }}">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group @if ($errors->has('id_team')) has-error @endif">
                                <label for="id_team">@lang('admin.pages.players.columns.id_team')</label>
                                <select class="form-control" id="id_team" name="id_team" required>

                                    @foreach($teams as $team)
                                        <option value="{!! $team->id !!}"
                                                @if (old('id_team') && old('id_team') == $team->id
                                                || ($team->id == $team->id_team)) selected @endif>
                                            {{$team->display_name}}</option>
                                    @endforeach

                                </select>
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
