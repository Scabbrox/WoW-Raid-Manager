<?php
namespace ImportHistory;

class GetAll {
	private function __construct() {}

	public static function Run() {
		global $wpdb;
		$result = NULL;

		try {
			$result = $wpdb->get_results("
				SELECT *
				FROM ImportHistory;
			");
		} catch (Exception $e) {

		}

		return $result;
	}
}