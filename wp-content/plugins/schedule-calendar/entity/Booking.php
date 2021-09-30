<?php

class Booking {

	private $id;
	private $user;
	private $service;
	private $start_date;
	private $start_time;
	private $end_date;
	private $end_time;
	private $is_canceled;

	public function __construct() {
		$args     = func_get_args();
		$args_num = func_num_args();
		switch ($args_num) {
			case 5:
				call_user_func_array(array($this, "construct_with_all"), $args);
				break;
		}
	}

	public function construct_with_all($id, $user, $service, $start_date, $start_time, $end_date, $end_time, $is_canceled) {
		$this->id          = $id;
		$this->user        = $user;
		$this->service     = $service;
		$this->start_date  = $start_date;
		$this->start_time  = $start_time;
		$this->end_date    = $end_date;
		$this->end_time    = $end_time;
		$this->is_canceled = $is_canceled;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_user() {
		return $this->user;
	}

	public function get_service() {
		return $this->service;
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

	public function get_is_canceled() {
		return $this->is_canceled;
	}

}

?>
