<?php

require_once(dirname(__FILE__). '/../service/CoretimeService.php');
require_once(dirname(__FILE__). '/../service/CoreweekService.php');

class CoretimeAndWeekController {

	private $coretime_service;
	private $coreweek_service;

	public function __construct() {
		$this->coretime_service = new CoretimeService();
		$this->coreweek_service = new CoreweekService();
	}
}

?>
