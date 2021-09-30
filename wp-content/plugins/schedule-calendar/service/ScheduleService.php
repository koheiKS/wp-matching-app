<?php

require_once(dirname(__FILE__). '/../entity/Schedule.php');
require_once(dirname(__FILE__). '/../repository/ScheduleRep.php');

class ScheduleService {

	private $schedule_rep;

	public function __construct() {
		$this->schedule_rep = new ScheduleRep();
	}

	public function create($user_id, $start_date, $start_time, $end_date, $end_time, $status) {
		$user     = new User(get_userdata($user_id));
		$schedule = new Schedule($user, $start_date, $start_time, $end_date, $end_time, $status);
		$this->schedule_rep->save($schedule);
	}
}

?>
