<?php
namespace WRO\Database\Procedures\Player;
require_once(plugin_dir_path(__FILE__)."../StoredProcedure.php");
require_once(plugin_dir_path(__FILE__)."../../tables/PlayerTable.php");
use WRO\Database\Tables     as Tables;
use WRO\Database\Procedures as Procedures;

class GetAll extends Procedures\StoredProcedure {
	public static function Run() {
		global $wpdb;
		$result = NULL;
		$classTable  = new Tables\ClassTable();
		$playerTable = new Tables\PlayerTable();

		$result = $wpdb->get_results("
			SELECT pl.ID, pl.UserID, wp.user_login as Username, pl.ClassID, cl.Name as ClassName, pl.Name, pl.Active
			FROM " .    $playerTable->GetName() .  " as pl
				JOIN " . $classTable->GetName() .  " as cl ON pl.ClassID = cl.ID
				LEFT JOIN " . $wpdb->prefix . "users as wp ON pl.UserID = wp.ID
			ORDER BY pl.ID ASC;
		");

		// set types
		foreach($result as $player) {
			$player->Active = (bool)$player->Active;
		}

		return $result;
	}
};