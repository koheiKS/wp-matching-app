<?php

require_once(dirname(__FILE__). '/../entity/Coretime.php');
require_once(dirname(__FILE__). '/../repository/CoretimeRep.php');

class CoretimeService {
	
	private $coretime_rep;

	public function __construct() {
		$this->coretime_rep = new CoretimeRep();
	}
}

?>
