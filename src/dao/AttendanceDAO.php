<?php
namespace WRO\DAO;
require_once(plugin_dir_path(__FILE__)."../entities/AttendanceEntity.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/Add.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/Get.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetAll.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/Update.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetChart.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/DeleteRow.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetAllById.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetBreakdown.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetBreakdownCount.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/UpdatePoints.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/DeletePlayer.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetAveragesInRange.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetAbsoluteAveragesInRange.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetCountsInRange.php");
require_once(plugin_dir_path(__FILE__)."../database/procedures/Attendance/GetAbsoluteCountsInRange.php");
use WRO\Entities                       as Entities;
use WRO\Database\Procedures\Attendance as Procedures;

class AttendanceDAO {
	public function Add(Entities\AttendanceEntity $entity) {
		return Procedures\Add::Run($entity);
	}

	public function Get($id) {
		return Procedures\Get::Run($id);
	}

	public function GetAbsoluteAveragesInRange($startRange, $endRange) {
		return Procedures\GetAbsoluteAveragesInRange::Run($startRange, $endRange);
	}

    public function GetAbsoluteCountsInRange($startRange, $endRange) {
		return Procedures\GetAbsoluteCountsInRange::Run($startRange, $endRange);
	}

	public function GetAll() {
		return Procedures\GetAll::Run();
	}

	public function GetAllById($id) {
		return Procedures\GetAllById::Run($id);
	}

	public function GetAveragesInRange($startRange, $endRange) {
		return Procedures\GetAveragesInRange::Run($startRange, $endRange);
	}
	
	public function GetBreakdown($id) {
		return Procedures\GetBreakdown::Run($id);
	}

    public function GetBreakdownCount($id) {
		return Procedures\GetBreakdownCount::Run($id);
	}

	public function GetChart($id) {
		return Procedures\GetChart::Run($id);
	}

    public function GetCountsInRange($startRange, $endRange) {
		return Procedures\GetCountsInRange::Run($startRange, $endRange);
	}

	public function Update(Entities\AttendanceEntity $entity) {
		return Procedures\Update::Run($entity);
	}

	public function UpdatePoints(Entities\AttendanceEntity $entity) {
		return Procedures\UpdatePoints::Run($entity);
	}

	public function DeleteRow($id) {
		return Procedures\DeleteRow::Run($id);
	}

	public function DeletePlayer($id) {
		return Procedures\DeletePlayer::Run($id);
	}
};