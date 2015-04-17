var app = angular.module('butler', [
	'ngSanitize',
	'ui.select'
], function ($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

app.controller('MessagesController', ['$http', '$scope', function ($http, $scope) {
	$scope.conversations = {};
	$scope.conversationsLoading = true;
	$scope.currentConversation = {};
	$scope.unreadCount = 0;

	$scope.messages = {};
	$scope.messageFormHasErrors = false;
	$scope.messageFormErrors = {};

	$scope.pageHasError = false;
	$scope.pageError = '';

	$scope.searchUsers = [];

	function composeForm() {
		this.to = [];
		this.conversation_id = '';
		this.message = '';

		this.errors = [];
		this.disabled = false;
	}

	$scope.composeForm = new composeForm();
	$scope.composing = false;

	$http.get('messages/all')
		.success(function (data) {
			$scope.conversationsLoading = false;

			if (data.length) {
				$scope.conversations = $scope.prepareConversations(data);
				$scope.currentConversation = _.first($scope.conversations);
				$scope.composeForm.to = $scope.currentConversation.users;
				$scope.composeForm.to = _.reject($scope.composeForm.to, function (to) {
					return to.id === Butler.AUTH_USER_ID;
				});
			}

			$scope.pageHasError = false;
		})
		.error(function () {
			$scope.conversationsLoading = false;
			$scope.pageHasError = true;
			$scope.pageError = 'Couldn\'t load the conversations. Please refresh the page and try again';
		});

	$scope.getMessages = function (conversation_id) {
		$scope.currentConversation = _.find($scope.conversations, function (conversation) {
			return conversation.id === conversation_id;
		});

		$scope.composing = false;
		$scope.composeForm.to = $scope.currentConversation.users;
		$scope.composeForm.to = _.reject($scope.composeForm.to, function (to) {
			return to.id === Butler.AUTH_USER_ID;
		});
		$scope.composeForm.disabled = false;
		$scope.composeForm.errors = [];
	};

	$scope.composeMessage = function () {
		$scope.currentConversation = {};
		$scope.composing = true;
		$scope.composeForm.to = [];
	};

	$scope.getUsers = function (search_term) {
		$http.get('messages/search/users/' + search_term)
			.success(function (users) {
				_.each($scope.composeForm.to, function (to) {
					users = _.reject(users, function (user) {
						return user.id === to.id;
					});
				});

				$scope.searchUsers = users;
			})
	};

	$scope.send = function (conversation_id) {
		$scope.composeForm.conversation_id = conversation_id;
		$scope.composeForm.disabled = true;
		$scope.composeForm.errors = [];

		$http.post('messages', $scope.composeForm)
			.success(function (conversation) {
				$scope.composeForm.disabled = false;
				$scope.composeForm.errors = [];
				$scope.composeForm.message = '';

				var currentConversation = _.find($scope.conversations, function (conv) {
					return conv.id === conversation.id;
				});

				if (_.isEmpty(currentConversation)) {
					var convs = [conversation];
					convs = $scope.prepareConversations(convs);

					$scope.conversations = _.union(convs, $scope.conversations);
					$scope.currentConversation = convs[0];
				} else {
					_.map($scope.conversations, function (conv) {
						if (conversation.id === conv.id) {
							conv.messages = conversation.messages;
							conv.latest_message = getLatestMessage(conv);

							return conv;
						}
					});
				}

				$scope.composing = false;
			})
			.error(function (errors) {
				$scope.composeForm.disabled = false;
				$scope.composeForm.errors = errors;
			});
	};

	$scope.prepareConversations = function (conversations) {
		_.each(conversations, function (conversation) {
			var subject = "";

			if (!_.isEmpty(conversation.title)) {
				subject = conversation.title;
			} else {
				subject = _.reduce(conversation.users, function (final, current) {
					var users = final + current.name;
					if (_.last(conversation.users).id !== current.id) {
						users += ', ';
					}
					return users;
				}, '');
			}

			conversation.short_subject = formatString(subject, 25);
			conversation.long_subject = formatString(subject, 30);

			conversation.latest_message = getLatestMessage(conversation);
		});

		return conversations;
	}
}]);

app.directive('repeatMessages', function () {
	return function (scope, element, attrs) {
		if (scope.$last) {
			scrollToBottom();
		}
	}
});

function getLatestMessage(conversation) {
	var latest_message = _.last(conversation.messages);
	if (!_.isEmpty(latest_message)) {
		latest_message = formatString(latest_message.message, 50);
	}

	return latest_message;
}

function formatString(_string, chars) {
	if (_string.length > chars) {
		return _string.substring(0, chars) + '...';
	}

	return _string;
}

function scrollToBottom() {
	var message_details = $('.message-details');
	message_details.scrollTop(message_details[0].scrollHeight);

}