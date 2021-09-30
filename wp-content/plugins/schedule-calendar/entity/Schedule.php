<?php

class Schedule {
	
	private $id;
	private $user;
	private $booking;
	private $start_date;
	private $start_time;
	private $end_date;
	private $end_time;
	private $status;

	public function __construct() {
		$args     = func_get_args();
		$args_num = func_num_args();
		switch ($args_num) {
			case 6:
				call_user_func_array(array($this, "construct_without_id_and_booking"), $args);
				break;
			case 7:
				call_user_func_array(array($this, "construct_without_id"), $args);
				break;
			case 8:
				call_user_func_array(array($this, "construct_with_all"), $args);
				break;
		}
	}

	public function construct_without_id_and_booking($user, $start_date, $start_time, $end_date, $end_time, $status) {
		$this->user       = $user;
		$this->start_date = $start_date;
		$this->start_time = $start_time;
		$this->end_date   = $end_date;
		$this->end_time   = $end_time;
		$this->status     = $status;
	}

	public function construct_without_id($user, $booking, $start_date, $start_time, $end_date, $end_time, $status) {
		$this->user       = $user;
		$this->booking    = $booking;
		$this->start_date = $start_date;
		$this->start_time = $start_time;
		$this->end_date   = $end_date;
		$this->end_time   = $end_time;
		$this->status     = $status;	
	}

	public function construct_with_all($id, $user, $booking, $start_date, $start_time, $end_date, $end_time, $status) {
		$this->id         = $id;
		$this->user       = $user;
		$this->booking    = $booking;
		$this->start_date = $start_date;
		$this->start_time = $start_time;
		$this->end_date   = $end_date;
		$this->end_time   = $end_time;
		$this->status     = $status;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_user() {
		return $this->user;
	}

	public function get_booking() {
		return $this->booking;
	}

	public function get_start_date() {
		return $this->start_date;
	}

	public function get_start_time() {
		return $this->start_time;
	}

	public function get_end_date() {
		return $this->end_date;
	}

	public function get_end_time() {
		return $this->end_time;
	}

	public function get_status() {
		return $this->status;
	}

}

?>
