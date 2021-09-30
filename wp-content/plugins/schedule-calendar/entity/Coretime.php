<?php

class Coretime {

	private $user;
	private $start_time;
	private $end_time;
	private $start_break_time;
	private $end_break_time;

	public function __construct() {
		$args     = func_get_args();
		$args_num = func_num_args();
		switch ($args_num) {
			case 5:
				call_user_func_array(array($this, "construct_with_all"), $args);
				break;
                }
        }

	public function construct_with_all($user, $start_time, $end_time, $start_break_time, $end_break_time) {
		$this->user             = $user;
		$this->start_time       = $start_time;
		$this->end_time         = $end_time;
		$this->start_break_time = $start_break_time;
		$this->end_break_time   = $end_break_time;
	}

	public function get_user() {
		return $this->user;
	}

	public function get_start_time() {
		return $this->start_time;
	}

	public function get_end_time() {
		return $this->end_time;
	}

	public function get_start_break_time() {
		return $this->start_break_time;
	}

	public function get_end_break_time() {
		return $this->end_break_time;
	}

}

?>
