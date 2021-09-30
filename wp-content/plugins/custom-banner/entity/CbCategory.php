<?php

require_once("CbBanner.php");

class CbCategory {

	protected $id;
	protected $name;
	protected $banners;

	public function __construct() {
		$args     = func_get_args();
		$args_num = func_num_args();
		switch ($args_num) {
			case 1:
				call_user_func_array(array($this, "construct_only_name"), $args);
				break;
			case 2:
				call_user_func_array(array($this, "construct_without_banners"), $args);
				break;
			case 3:
				call_user_func_array(array($this, "construct_with_banners"), $args);
				break;
		}
	}

	public function construct_only_name($name) {
		$this->name = $name;
	}

	public function construct_without_banners($id, $name) {
		$this->id   = $id;
		$this->name = $name;
	}

	public function construct_with_banners($id, $name, $banners){
		$this->id      = $id;
		$this->name    = $name;
		$this->banners = $banners;
	}

	public function set_banners($banners) {
		$this->banners = $banners;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_name() {
		return $this->name;
	}

	public function get_banners() {
		return $this->banners;
	}
}
?>
