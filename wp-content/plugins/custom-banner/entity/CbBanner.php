<?php

class CbBanner {

	private $id;
	private $cat_id;
	private $text;
	private $url;

	public function __construct() {
		$args     = func_get_args();
		$args_num = func_num_args();
		switch ($args_num) {
			case 3:
				call_user_func_array(array($this, "construct_without_id"), $args);
				break;
			case 4:
				call_user_func_array(array($this, "construct_with_id"), $args);
				break;
		}
	}

	public function construct_without_id($cat_id, $text, $url) {
		$this->cat_id = $cat_id;
		$this->text   = $text;
		$this->url    = $url;
	}

	public function construct_with_id($id, $cat_id, $text, $url) {
		$this->id     = $id;
		$this->cat_id = $cat_id;
		$this->text   = $text;
		$this->url    = $url;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_cat_id() {
		return $this->cat_id;
	}

	public function get_text() {
		return $this->text;
	}

	public function get_url() {
		return $this->url;
	}
}

?>
