<?php

class User {

	private $id;
	private $display_name;
	private $nicename;
	private $email;

	public function __construct($user) {
		$this->id           = $user->ID;
		$this->display_name = $user->display_name;
		$this->nicename     = $user->user_nicename;
		$this->email        = $user->user_email;
	}

	public function get_display_name($user_id) {
		return get_userdata($user_id)->display_name;
	}

	public function get_email($user_id) {
		return get_userdata($user_id)->user_email;
	}

	public function get_nicename($user_id) {
		return get_userdata($user_id)->user_nicename;
	}
}

?>
