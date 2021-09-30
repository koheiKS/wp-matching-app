<?php

require_once(dirname(__FILE__). '/../repository/CoreweekRep.php');

class CoreweekService {

	private $coreweek_rep;

	public function __construct() {
		$this->coreweek_rep = new CoreweekRep();
	}
}

?>
