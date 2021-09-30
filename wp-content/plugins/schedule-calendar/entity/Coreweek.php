<?php

class Coreweek {

	private $user;
	private $can_on_monday;
	private $can_on_tuesday;
	private $can_on_wednesday;
	private $can_on_tursday;
	private $can_on_friday;
	private $can_on_saturday;
	private $can_on_sunday;
	private $can_on_public_holiday;

	public function __construct() {
		$args     = func_get_args();
		$args_num = func_num_args();
		switch ($args_num) {
			case 9:
				call_user_func_array(array($this, "construct_with_all"), $args);
				break;
                }
	}

	public function construct_with_all($user, $on_monday, $on_tuesday, $on_wednesday, $on_tursday, $on_friday, $on_saturday, $on_sunday, $on_public_holiday) {
		$this->user                  = $user;
		$this->can_on_monday         = $on_monday;
		$this->can_on_tuesday        = $on_tuesday;
		$this->can_on_wednesday      = $on_wednesday;
		$this->can_on_tursday        = $on_tursday;
		$this->can_on_friday         = $on_friday;
		$this->can_on_saturday       = $on_saturday;
		$this->can_on_sunday         = $on_sunday;
		$this->can_on_public_holiday = $on_public_holiday;
	}

	public function get_user() {
		return $this->user;
	}

	public function get_can_on_monday() {
		return $this->can_on_monday;
	}

	public function get_can_on_tuesday() {
		return $this->can_on_tuesday;
	}

	public function get_can_on_wednesday() {
		return $this->can_on_wednesday;
	}

	public function get_can_on_tursday() {
		return $this->can_on_tursday;
	}

	public function get_can_on_friday() {
		return $this->can_on_saturday;
	}

	public function get_can_on_sunday() {
		return $this->can_on_sunday;
	}

	public function get_can_on_public_holiday() {
		return $this->can_on_public_holiday;
	}
}

?>
