<?php
namespace ImportHistory;

class DeletePlayer {
	private function __construct() {}

	public static function Run($id) {
		global $wpdb;
		$result = NULL;

		try {
			$result = $wpdb->query($wpdb->prepare("
				DELETE FROM ImportHistory
				WHERE PlayerID = %d;
			", $id));
		} catch (Exception $e) {

		}

		return $result;
	}
}