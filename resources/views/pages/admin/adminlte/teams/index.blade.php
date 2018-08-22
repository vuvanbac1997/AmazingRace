@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'teams'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin/adminlte') !!}"></script>
@stop

@section('title')
@stop

@section('header')
Teams
@stop

@section('breadcrumb')
<li class="active">Teams</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\TeamController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
                    </p>
                </h3>
                <br>
                <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => $count])</p>
            </div>
            <div class="col-sm-6 wrap-top-pagination">
                <div class="heading-page-pagination">
                    {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], [], $count, 'shared.topPagination') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-body" style=" overflow-x: scroll; ">
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                <th>{!! \PaginationHelper::sort('username', trans('admin.pages.teams.columns.username')) !!}</th>
                <th>{!! \PaginationHelper::sort('display_name', trans('admin.pages.teams.columns.display_name')) !!}</th>
                <th>{!! \PaginationHelper::sort('password', trans('admin.pages.teams.columns.password')) !!}</th>

                <th style="width: 40px">{!! \PaginationHelper::sort('is_enabled', trans('admin.pages.common.label.is_enabled')) !!}</th>
                <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
            </tr>
            @foreach( $teams as $team )
                <tr>
                    <td>{{ $team->id }}</td>
               <td>{{ $team->username }}</td>
               <td>{{ $team->display_name }}</td>
               <td>{{ $team->password }}</td>

                    <td>
                        @if( $team->is_enabled )
                            <span class="badge bg-green">@lang('admin.pages.common.label.is_enabled_true')</span>
                        @else
                            <span class="badge bg-red">@lang('admin.pages.common.label.is_enabled_false')</span>
                        @endif
                    </td>
                    <td>
                        <a href="{!! action('Admin\TeamController@show', $team->id) !!}" class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-xs delete-button" data-delete-url="{!! action('Admin\TeamController@destroy', $team->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="box-footer">
        {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], []) !!}
    </div>
</div>
@stop