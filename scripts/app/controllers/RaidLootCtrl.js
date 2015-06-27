app.controller("RaidLootCtrl", function($scope, RaidLootSvc) {
	$scope.model = {
		RaidLoot: [],
		currentPage: 1
	};
	var vm = $scope.model;

    function RefreshLootLinks() {
        setTimeout(function () {
            $WowheadPower.refreshLinks();
        }, 25);
    }
    $scope.RefreshLootLinks = RefreshLootLinks;

	function Refresh() {
		RaidLootSvc.GetAll().then(
			function(response) {
				vm.RaidLoot = response.data;

				// transform data into proper stuff for view
				angular.forEach(vm.RaidLoot, function(value, key) {
					value.ClassStyle = ClassIdToCss(parseInt(value.ClassID));
					value.Item = BuildLootURL(value.Item);
				});


			   RefreshLootLinks();
			},
			function(errmsg) {

			}
		);
	}

	$scope.populate = function() {
		Refresh();
	};
	$scope.populate();

	$scope.Remove = function(row) {
		RaidLootSvc.Delete(row.ID).then(
			function(response) {
			},
			function(errormsg) {

			}
		);
	};

	$scope.RefreshTable = Refresh;
});