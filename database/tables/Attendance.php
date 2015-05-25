<?php
namespace Tables;
include_once(ABSPATH.'wp-admin/includes/upgrade.php');

class AttendanceTable {
	private function __construct() {}

	public static function CreateTable() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
        
        \dbDelta("
            CREATE TABLE IF NOT EXISTS Attendance (
                ID  int(10) NOT NULL AUTO_INCREMENT,
			    PlayerID  smallint(5),
			    Date date NOT NULL,
			    Points  float(3, 2),
			    PRIMARY KEY  ID (ID),
			    FOREIGN KEY (PlayerID) REFERENCES Player(ID)
            ) $charset_collate;");
	}

	public static function DropTable() {
		global $wpdb;

		$wpdb->get_results("DROP TABLE IF EXISTS Attendance;");
	}
}