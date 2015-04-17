@extends('layouts.app')

@section('custom_css')
<link href="{{ asset('/css/select.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container" ng-app="butler" ng-controller="MessagesController" ng-cloak>
    <div class="alert alert-danger" ng-if="pageHasError">
        <p><% pageError %></p>
    </div>

    <h1 class="page-header"><i class="fa fa-envelope"></i> Messages</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Conversations</strong>
                    <input type="button" value="Compose" class="btn btn-primary btn-xs pull-right" ng-click="composeMessage()">
                    <span class="badge"><% unreadCount %></span>
                </div>
                <div class="list-group message-inbox">
                    <div class="list-group-item loading" ng-if="conversationsLoading"><i class="fa fa-spinner fa-spin"></i></div>
                    <div class="list-group-item" ng-if="conversations.length" ng-repeat="conversation in conversations">
                        <div class="inbox-entry <% currentConversation.id === conversation.id ? 'current' : ''%>" ng-click="getMessages(conversation.id)">
                            <div>
                                <strong><% conversation.short_subject %></strong>
                                <small class="pull-right"><% conversation.latest_message.time_ago %></small>
                            </div>
                            <div>
                                <small ng-if="conversation.latest_message">
                                    <% conversation.latest_message %>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item" ng-if="!conversations.length && !conversationsLoading">
                        <p class="inbox-entry">You don't have any conversations/messages yet.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form class="compose-form">
                <div class="panel panel-default">
                    <div class="panel-heading" ng-if="!composing">
                        <strong><% currentConversation.long_subject %></strong>
                        <div class="dropdown pull-right">
                            <a href="#" data-toggle="dropdown"><i class="fa fa-group"></i><span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li ng-repeat="user in currentConversation.users"><a href="#"><% user.name %></a></li>
                            </ul>
                        </div>
                    </div>
                    <ui-select multiple ng-model="composeForm.to">
                        <ui-select-match placeholder="Recipients"><% $item.name %></ui-select-match>
                        <ui-select-choices refresh="getUsers($select.search)" refresh-delay="500" repeat="user in searchUsers">
                            <div>
                                <p><% user.name %></p>
                                <p><em><% user.email %></em></p>
                            </div>
                        </ui-select-choices>
                    </ui-select>
                    <div class="list-group message-details">
                        <div class="list-group-item" ng-repeat="message in currentConversation.messages" repeat-messages>
                            <div>
                                <a href="#"><strong><% message.creator.name %></strong></a>
                            </div>
                            <div><% message.message %></div>
                        </div>
                    </div>
                </div>

                <span class="label label-danger"><% composeForm.errors.message[0] %></span>
                <textarea name="message" ng-model="composeForm.message" class="form-control compose-area no-resize" placeholder="Message" type="text"></textarea>
                <input type="submit" value="Send" class="btn btn-success btn-xs compose-submit" ng-click="send(currentConversation.id)" ng-disabled="composeForm.disabled">
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
<script src="{{ asset('js/angular.js') }}"></script>
<script src="{{ asset('js/angular-sanitize.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/underscore.js') }}"></script>
<script src="{{ asset('js/select.js') }}"></script>
<script src="{{ asset('js/message.js') }}"></script>
@endsection