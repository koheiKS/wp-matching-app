<?php

require_once(dirname(__FILE__). '/../service/ScheduleService.php');
require_once(dirname(__FILE__). '/../service/ScModelService.php');

class ScheduleController {

	private $schedule_service;
	private $model;

	public function __construct() {
		$this->schedule_service = new ScheduleService();
		$this->model = new ModelService();
	}

	public function sc_new_schedule() {
		$file        = dirname(__FILE__). "/../templates/new-schedule.php";
		$user_id     = get_current_user_id();
		$nonce_field = wp_nonce_field(ScheduleCalendar::NEW_ACTION, ScheduleCalendar::NEW_NAME);
		$atts        = array("user_id" => $user_id, "nonce_field" => $nonce_field);
		$this->model->display_template($file, $atts);
	}

	public function create_schedule() {
		global $wpdb;
		if(isset($_POST[ScheduleCalendar::NEW_NAME]) && $_POST[ScheduleCalendar::NEW_NAME]) {
			if(check_admin_referer(ScheduleCalendar::NEW_ACTION, ScheduleCalendar::NEW_NAME)) {
				$user_id    = $_POST['user_id'];
				$start_date = $_POST['start_date'];
				$start_time = $_POST['start_time'];
				$end_date   = $_POST['end_date'];
				$end_time   = $_POST['end_time'];
				$status     = $_POST['status'];
				$this->schedule_service->create($user_id, $start_date, $start_time, $end_date, $end_time, $status);
			}
		}
	}

	function sc_show_schedule($atts) {
		extract(shortcode_atts(array(
			'user_id' => 0,
		), $atts));
		$events_data = $this->get_user_schedule($user_id);
		$events = array();
		$event_keys = ["title", "url", "start", "end", "start_time", "end_time"];
		for($i = 0; $i < count($events_data); $i++) {
			$title = $this->calc_status($events_data[$i]['status']);
			$url = $this->get_url($user_id, $events_data[$i]['status']);
			$event_values = array(
				$title,
				$url,
				$events_data[$i]['start_date'],
				$events_data[$i]['end_date'],
				$events_data[$i]['start_time'],
				$events_data[$i]['end_time']
			);
			$event = array_combine($event_keys, $event_values);
			array_push($events, $event);
		}
		$events = json_encode($events, JSON_UNESCAPED_UNICODE);
		$core_time = json_encode($this->get_user_coretime($user_id), JSON_UNESCAPED_UNICODE);
		$core_week = json_encode($this->get_coreweek_values($user_id), JSON_UNESCAPED_UNICODE);

		$customer_id = get_current_user_id();
		$service_id = get_the_ID();
		$need_time = get_field('time');
		$new_booking = $this->sc_new_booking($customer_id, $service_id);
		$is_loggedin = is_user_logged_in();
		return <<< HTML
$new_booking
<div id="calendar" data-events=$events data-needtime=$need_time data-coretime=$core_time data-coreweek=$core_week data-is_loggedin=$is_loggedin></div>
HTML;
	}
}

?>
