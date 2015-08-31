app.controller("UserUICtrl", function($scope, $modal, AttendanceSvc, RaidLootSvc) {
	$scope.model = {
		BreakdownEntities: [],
		RaidLoot: [],
		AjaxContent: {
			Breakdown: { status: 'loading', message: '' },
			RaidLoot:  { status: 'loading', message: '' }
		}
	};
	var vm = $scope.model;

    function RefreshLootLinks() {
        setTimeout(function () {
            $WowheadPower.refreshLinks();
        }, 25);
    }
    $scope.RefreshLootLinks = RefreshLootLinks;

	$scope.populate = function() {
		AttendanceSvc.GetBreakdown()
			.success(function(data) {
				vm.BreakdownEntities = data;

				// transform ClassID to CSS class name
				angular.forEach(vm.BreakdownEntities, function(value, key) {
					value.ClassID = ClassIdToCss(parseInt(value.ClassID));
				});

				vm.AjaxContent.Breakdown.status = 'success';
			})
			.error(function(errmsg) {
				vm.AjaxContent.Breakdown.status = 'error';
				vm.AjaxContent.Breakdown.message = errmsg;
			});

		RaidLootSvc.GetAll()
			.success(function(data) {
				vm.RaidLoot = data;

				// transform data into proper stuff for view
				angular.forEach(vm.RaidLoot, function(value, key) {
					value.ClassID = ClassIdToCss(parseInt(value.ClassID));
					value.Item = BuildLootURL(value.Item);
				});

				vm.AjaxContent.RaidLoot.status = 'success';
			    RefreshLootLinks();
			})
			.error(function(errmsg) {
				vm.AjaxContent.RaidLoot.status = 'error';
				vm.AjaxContent.RaidLoot.message = errmsg;
			});
	};
	$scope.populate();

	$scope.ShowDetails = function(item) {
		var modalInstance = $modal.open({
			templateUrl: plugin_url.app + '/user-ui/templates/playerBreakdownModal.html',
			controller: 'PlayerBreakdownModalCtrl',
			size: 'lg',
			resolve: {
				entity: function() {
					return item;
				}
			}
		});
	};
});

app.controller("PlayerBreakdownModalCtrl", function($scope, $modalInstance, toastr, entity, AttendanceSvc, DisputeSvc) {
	$scope.model = {
		BreakdownEntity: entity,
		AttendanceEntities: null,
		ChartData: null,
		AjaxContent: {
			Attendance: { status: 'loading', message: '' },
			Chart:      { status: 'loading', message: '' }
		},
		AjaxForm: {
			Dispute: 'ready'
		}
	};
	var vm = $scope.model;

	$scope.populate = function() {
		var chart, chartOptions; 

		AttendanceSvc.GetAllById(entity.ID)
			.success(function(data) {
				vm.AttendanceEntities = data;

				for(var i = 0; i < vm.AttendanceEntities.length; ++i) {
					vm.AttendanceEntities[i].Dispute = {
						Points: null,
						Comment: null
					}
				}

				vm.AjaxContent.Attendance.status = 'success';
			})
			.error(function(errmsg) {
				vm.AjaxContent.Attendance.status = 'error';
				vm.AjaxContent.Attendance.message = errmsg;
			});

		AttendanceSvc.GetChart(entity.ID)
			.success(function(data) {
				var sqlDate;
				var temp = data;

				// setup chart data
				vm.ChartData = new google.visualization.DataTable();
		      	vm.ChartData.addColumn('date', 'Date');
				vm.ChartData.addColumn('number', 'Your Attendance');
				vm.ChartData.addColumn('number', 'Your Average Attendance');
				vm.ChartData.addColumn('number', 'Raid Attendance');

				// add chart data
				angular.forEach(temp, function(value, key) {
					sqlDate = value.Date.split(/[- :]/);
					vm.ChartData.addRow([new Date(sqlDate[0], sqlDate[1] - 1, sqlDate[2]), parseInt(value.Points), parseInt(value.PlayerAverage), parseInt(value.RaidAverage)]);
				});

				// draw chart
			    setTimeout(function () {
					chart = new google.charts.Line(document.getElementById('calendar_basic'));
					chartOptions = {
						width: '100%',
						height: 255,
						legend: {
							position: 'none'
						},
						vAxis: { 
							viewWindowMode: 'explicit',
							viewWindow: {
								max: 100,
								min: 0
							}
						},
						axisTitlesPosition: 'none'
					};
					chart.draw(vm.ChartData, chartOptions);
    			}, 100);

				vm.AjaxContent.Chart.status = 'success';
			})
			.error(function(errmsg) {
				vm.AjaxContent.Chart.status = 'error';
				vm.AjaxContent.Chart.message = errmsg;
			});
	};
	$scope.populate();

	$scope.SubmitDispute = function(form, entity) {
		var disputeEntity = {
			AttendanceID: entity.ID,
			Points: entity.Dispute.Points,
			Comment: entity.Dispute.Comment
		};

		if(!form.$invalid && entity.Dispute.Points != null) {
			vm.AjaxForm.Dispute = 'processing';

			DisputeSvc.AddRecord(disputeEntity)
				.success(function(data) {
					entity.Dispute = {
						Points: null,
						Comment: null
					};

					form.$setPristine();
					toastr.success("Dispute submitted!");
				})
				.error(function(errmsg, errstatus) {
					toastr.error(errmsg, errstatus, { 
						closeButton: true,
						progressBar: true,
						timeOut: 30000,
				 	});
				})
				.finally(function() {
					vm.AjaxForm.Dispute = 'ready';
				})
		}
	};

	$scope.cancel = function() {
		$modalInstance.dismiss('cancel');
	};
});