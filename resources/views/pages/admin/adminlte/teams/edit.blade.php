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
            $("#team_profile-image").change(function (event) {
                $("#profile-image-preview").attr("src", URL.createObjectURL(event.target.files[0]));
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
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group text-center">
                                @if( !empty($team->profileImage) )
                                    <img id="profile-image-preview"  style="max-width: 500px; width: 100%;" src="{!! $team->present()->profileImage->present()->url !!}" alt="" class="margin" />
                                @else
                                    <img id="profile-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin" />
                                @endif
                                <input type="file" style="display: none;"  id="tean_profile-image" name="team_profile_image">
                                <p class="help-block" style="font-weight: bolder;">
                                    @lang('admin.pages.teams.columns.profile_image_id')
                                    <label for="team_profile-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group @if ($errors->has('username')) has-error @endif">
                                <label for="username">@lang('admin.pages.teams.columns.username')</label>
                                <input type="text" class="form-control" id="username" name="username" required value="{{ old('username') ? old('username') : $team->username }}">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group @if ($errors->has('display_name')) has-error @endif">
                                <label for="display_name">@lang('admin.pages.teams.columns.display_name')</label>
                                <input type="text" class="form-control" id="display_name" name="display_name" required value="{{ old('display_name') ? old('display_name') : $team->display_name }}">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group @if ($errors->has('password')) has-error @endif">
                                <label for="password">@lang('admin.pages.teams.columns.password')</label>
                                <input type="password" class="form-control" id="password" name="password" required value="{{ old('password') ? old('password') : $team->password }}">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group @if ($errors->has('id_coach')) has-error @endif">
                                <label for="id_company">@lang('admin.pages.teams.columns.id_coach')</label>
                                <select class="form-control" id="id_coach" name="id_coach" required>
                                    @foreach($coachs as $coach)
                                        <option value="{!! $coach->id !!}"
                                                @if (old('id_coach') && old('id_coach') == $coach->id
                                                || ($coach->id == $team->id_coach)) selected @endif>
                                            {{$coach->name}}</option>
                                    @endforeach

                                </select>
                                {{--<input type="sele" class="form-control" id="id_company" name="id_company" required value="{{ old('id_company') ? old('id_company') : $team->id_company }}">--}}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group @if ($errors->has('id_company')) has-error @endif">
                                <label for="id_company">@lang('admin.pages.teams.columns.id_company')</label>
                                <select class="form-control" id="id_company" name="id_company" required>
                                    @foreach($companies as $company)
                                        <option value="{!! $company->id !!}"
                                                @if (old('id_company') && old('id_company') == $company->id
                                                || ($company->id == $team->id_company)) selected @endif>
                                            {{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7 pull-right">
                            <div class="form-group">
                                <label for="is_activated">@lang('admin.pages.teams.columns.is_activated')</label>
                                <div class="switch">
                                    <input id="is_activated" name="is_activated" value="1" @if( $team->is_activated) checked @endif class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                                    <label for="is_activated"></label>
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
