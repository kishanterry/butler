var app = angular.module('butler', [], function ($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

app.controller('AppsController', ['$http', '$scope', function ($http, $scope) {

	$scope.status = 'loading';
	$scope.apps = {};
	$scope.newApp = {};
	$scope.createFormHasErrors = false;
	$scope.createFormErrors = {};
	$scope.creating = false;


	$scope.createApp = function () {
		$scope.creating = true;
		$http.post('apps', $scope.newApp)
			.success(function (data) {
				$scope.createFormHasErrors = false;
				$scope.apps.push(data);

				$scope.creating = false;
				hideBSModal('#modal-add-app');
			})
			.error(function (data) {
				$scope.createFormHasErrors = true;
				$scope.createFormErrors = data;

				$scope.creating = false;
			});
	};

	$http.get('apps/all/' + Butler.AUTH_USER_ID)
		.success(function (data) {
			$scope.apps = data;
			$scope.status = 'success';
		})
		.error(function () {
			$scope.status = 'failed';
		});

	$scope.cancelCreateApp = function () {
		hideBSModal('#modal-add-app');
	};

	function hideBSModal(modal_id) {
		$(modal_id).modal('hide');
		$scope.newApp = {};
	}
}]);