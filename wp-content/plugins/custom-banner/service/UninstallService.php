<?php

require_once(dirname(__FILE__). '/../repository/CbCategoryRep.php');
require_once(dirname(__FILE__). '/../repository/CbBannerRep.php');

class UninstallService {

	private $cat_rep;
	private $ban_rep;

	public function __construct() {
		$this->cat_rep = new CbCategoryRep();
		$this->ban_rep = new CbBannerRep();
	}

	function uninstall() {
        	$this->cat_rep->drop_table();
        	$this->ban_rep->drop_table();
	}

}

?>
