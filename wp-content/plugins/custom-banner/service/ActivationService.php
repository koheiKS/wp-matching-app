<?php

require_once(dirname(__FILE__). '/../repository/CbCategoryRep.php');
require_once(dirname(__FILE__). '/../repository/CbBannerRep.php');

class ActivationService {

	private $cat_rep;
	private $ban_rep;

	public function __construct() {
		$this->cat_rep = new CbCategoryRep();
		$this->ban_rep = new CbBannerRep();
	}

	public function activate() {
		global $wpdb;
		$table_cat = $wpdb->prefix . CbCategoryRep::TABLE;
		$table_ban = $wpdb->prefix . CbBannerRep::TABLE;
		if($wpdb->get_var("SHOW TABLES LIKE '".$table_cat."'") != $table_cat) {
			$this->cat_rep->create_table();
		}
		if($wpdb->get_var("SHOW TABLES LIKE '".$table_ban."'") != $table_ban) {
			$this->ban_rep->create_table();
		}
	}
}

?>
