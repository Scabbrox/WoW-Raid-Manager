<?php
namespace WRO\Database\Procedures\Player;
require_once(plugin_dir_path(__FILE__)."../StoredProcedure.php");
require_once(plugin_dir_path(__FILE__)."../../tables/PlayerTable.php");
require_once(plugin_dir_path(__FILE__)."../../../entities/PlayerEntity.php");
use WRO\Entities            as Entities;
use WRO\Database\Tables     as Tables;
use WRO\Database\Procedures as Procedures;

class Update extends Procedures\StoredProcedure {
	public static function Run(Entities\PlayerEntity $entity) {
		global $wpdb;
		$result = NULL;
		$playerTable = new Tables\PlayerTable();

		if($entity->UserID === NULL) {
			$result = $wpdb->query($wpdb->prepare("
				UPDATE " . $playerTable->GetName() . "
				SET UserID = NULL,
					ClassID = %d, 
				    Name = %s,
				    Icon = %s,
				    Active = %d,
				    Region = %s,
				    Realm = %s
				WHERE ID = %d;
			", $entity->ClassID, $entity->Name, $entity->Icon, $entity->Active, $entity->Region, $entity->Realm, $entity->ID));
		} else {
			$result = $wpdb->query($wpdb->prepare("
				UPDATE " . $playerTable->GetName() . "
				SET UserID = %d,
					ClassID = %d, 
				    Name = %s,
				    Icon = %s,
				    Active = %d,
				    Region = %s,
				    Realm = %s
				WHERE ID = %d;
			", $entity->UserID, $entity->ClassID, $entity->Name, $entity->Icon, $entity->Active, $entity->Region, $entity->Realm, $entity->ID));
		}

		return $result;
	}
};