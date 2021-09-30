<?php

require_once(dirname(__FILE__). '/../entity/CbCategory.php');
require_once(dirname(__FILE__). '/CbBannerRep.php');

class CbCategoryRep {

	private $table;
	private $ban_rep;

	public function __construct() {
		global $wpdb;
		$this->table   = $wpdb->prefix . 'cb_category';
		$this->ban_rep = new CbBannerRep();
	}

	public function find_all() {
		global $wpdb;
		$result = $wpdb->get_results("SELECT id, name FROM ".$this->table.";");
		$categories = array();
		foreach ($result as $row) {
			$category = new CbCategory($row->id, $row->name);
			$banners  = $this->ban_rep->find_by_category($category);
			$category->set_banners($banners);
			array_push($categories, $category);
		}
		return $categories;
	}

	public function find_by_id($id) {
		global $wpdb;
		$result     = $wpdb->get_results("SELECT id, name FROM ".$this->table. " WHERE id=" .$id. ";");
		$category   = new CbCategory($result[0]->id, $result[0]->name);
		$banners    = $this->ban_rep->find_by_category($category);
		$category->set_banners($banners);
		return $category;
	}

	public function save($category) {
		global $wpdb;
		$wpdb->insert(
			$this->table,
			array(
				'name' => $category->get_name()
			)
		);
	}

	function delete($category) {
		global $wpdb;
		$wpdb->delete($this->table, array('id' => $category->get_id()), array('%d'));
	}

	function delete_by_id($id) {
		global $wpdb;
		$wpdb->delete($this->table, array('id' => $id), array('%d'));
	}

	function create_cat_table() {
		global $wpdb;
		$data_db_version= '1.0';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE ".$this->table." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(30) NOT NULL ,
			PRIMARY KEY  (id),
			UNIQUE KEY  (name)
		) ".$charset_collate.";";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'data_db_version', $data_db_version );
	}
	
	function drop_table() {
		global $wpdb;
		$wpdb->query("DROP TABLE IF EXISTS ".$this->table."");
		delete_option( 'data_db_version' );
	}
}

?>

