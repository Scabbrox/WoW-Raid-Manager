<?php
namespace WRO\Database\Procedures\Player;
require_once(plugin_dir_path(__FILE__)."../StoredProcedure.php");
require_once(plugin_dir_path(__FILE__)."../../tables/PlayerTable.php");
use WRO\Database\Tables     as Tables;
use WRO\Database\Procedures as Procedures;

class Get extends Procedures\StoredProcedure {
	public static function Run($id) {
		global $wpdb;
		$classTable  = new Tables\ClassTable();
		$playerTable = new Tables\PlayerTable();
		$realmTable  = new Tables\RealmTable();

		return $wpdb->get_row($wpdb->prepare("
			SELECT pl.ID, pl.UserID, wp.user_login as Username, pl.ClassID, cl.Name as ClassName, pl.Name, pl.Active, pl.Realm, rt.Name as RealmName
			FROM " .    $playerTable->GetName() .  " as pl
				JOIN " . $classTable->GetName() .  " as cl ON pl.ClassID = cl.ID
				LEFT JOIN " . $wpdb->prefix . "users as wp ON pl.UserID = wp.ID
				JOIN " . $realmTable->GetName() . " as rt on pl.Region = rt.Region AND pl.Realm = rt.Slug
			WHERE pl.ID = %d;
		", $id));
	}
};