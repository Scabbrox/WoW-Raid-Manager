app.factory("AttendanceSvc", function($http) {
	return {
		AddRecord: function(entity) {
			return $http({
				method: 'POST',
				url: ajax_object.ajax_url,
				params: {
					'action': 'wro_attendance',
					'entity': JSON.stringify(entity)
				}
			});
		},
		DeleteRecord: function(id) {
			return $http({
				method: 'DELETE',
				url: ajax_object.ajax_url,
				params: {
					'action': 'wro_attendance',
					'id': id
				}
			});
		},
		GetAll: function() {
			return $http({
				method: 'GET',
				url: ajax_object.ajax_url,
				params: {
					'action': 'wro_attendance',
					'func': 'all'
				}
			});
		},
		GetAllById: function(id) {
			return $http({
				method: 'GET',
				url: ajax_object.ajax_url,
				params: {
					'action': 'wro_attendance',
					'func': 'all',
					'id': id
				}
			});
		},
		GetBreakdown: function() {
			return $http({
				method: 'GET',
				url: ajax_object.ajax_url,
				params: {
					'action': 'wro_attendance',
					'func': 'breakdown'
				}
			});
		},
		GetChart: function(id) {
			return $http({
				method: 'GET',
				url: ajax_object.ajax_url,
				params: {
					'action': 'wro_attendance',
					'func': 'chart',
					'id': id
				}
			});
		},
		SaveGroupAttnd: function(entities) {
			return $http({
				method: 'POST',
				url: ajax_object.ajax_url,
				params: {
					'action': 'wro_attendance',
					'dailyEntities': JSON.stringify(entities)
				}
			});
		},
		UpdateRecord: function(entity) {
			return $http({
				method: 'PUT',
				url: ajax_object.ajax_url,
				params: {
					'action': 'wro_attendance',
					'entity': JSON.stringify(entity)
				}
			});
		}
	};
});