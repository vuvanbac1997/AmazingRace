@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'companies'] )

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
            
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Companies
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\CompanyController@index') !!}"><i class="fa fa-files-o"></i> Companies</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $company->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\CompanyController@store') !!} @else {!! action('Admin\CompanyController@update', [$company->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\CompanyController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                <label for="name">@lang('admin.pages.companies.columns.name')</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $company->name }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('address')) has-error @endif">
                                <label for="address">@lang('admin.pages.companies.columns.address')</label>
                                <textarea name="address" class="form-control" rows="5" required placeholder="@lang('admin.pages.companies.columns.address')">{{ old('address') ? old('address') : $company->address }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('phone')) has-error @endif">
                                <label for="phone">@lang('admin.pages.companies.columns.phone')</label>
                                <input type="text" class="form-control" id="phone" name="phone" required value="{{ old('phone') ? old('phone') : $company->phone }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('description')) has-error @endif">
                                <label for="description">@lang('admin.pages.companies.columns.description')</label>
                                <textarea name="description" class="form-control" rows="5" required placeholder="@lang('admin.pages.companies.columns.description')">{{ old('description') ? old('description') : $company->description }}</textarea>
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
