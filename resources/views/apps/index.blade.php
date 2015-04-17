@extends('layouts.app')

@section('content')
<div class="container" ng-app="butler" ng-controller="AppsController">
    <h1 class="page-header"><i class="fa fa-cube"></i> My Apps</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="alert alert-danger" ng-if="status === 'failed'">
                    <span>Failed to load the resource</span>
                </div>
                <ul class="list-group">
                    <li class="list-group-item" ng-if="status === 'loading'">
                        <i class="fa fa-spinner fa-spin"></i> Loading
                    </li>
                    <li class="list-group-item" ng-if="apps.length <= 0">
                        You don't have any apps configured / created yet.
                        <a class="btn btn-default btn-xs pull-right" href="#" data-toggle="modal" data-target="#modal-add-app" data-backdrop="static">Create</a>
                    </li>
                    <li class="list-group-item" ng-repeat="app in apps">
                        <h3><strong><% app.name %></strong></h3>
                        <div class="alert alert-info">
                            <p>App ID: <strong><% app.app_id %></strong></p>
                            <p>Key: <strong><% app.app_key %></strong></p>
                        </div>
                        <div class="alert alert-warning">
                            <p>Secret: <strong><% app.app_secret %></strong></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Total Apps
                    <a class="btn btn-default btn-xs pull-right" href="#" data-toggle="modal" data-target="#modal-add-app" data-backdrop="static">New</a>
                </div>
                <div class="panel-body text-center">
                    <h3><i class="fa fa-cube"></i> <% apps.length %></h3>
                </div>
            </div>
        </div>
    </div>

    @include('apps.partials.create')
</div>
@endsection

@section('footer_js')
<script src="{{ asset('js/angular.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection