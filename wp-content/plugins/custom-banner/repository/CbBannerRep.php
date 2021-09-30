<?php

require_once(dirname(__FILE__). '/../entity/CbCategory.php');
require_once(dirname(__FILE__). '/../entity/CbBanner.php');

class CbBannerRep {

	private $table;

	public function __construct() {
		global $wpdb;
		$this->table = $wpdb->prefix . 'cb_banner';
	}

	public function find_by_category($category) {
		global $wpdb;
		$result = $wpdb->get_results("SELECT id, text, url FROM ".$this->table." WHERE cb_category_id = ".$category->get_id().";");
		$banners = array();
		foreach ($result as $row) {
			$banner = new CbBanner($row->id, $category->get_id(), $row->text, $row->url);
			array_push($banners, $banner);
		}
		return $banners;
	}

	public function find_by_id($id) {
		global $wpdb;
		$row = $wpdb->get_row("SELECT id, text, url, cb_category_id FROM " .$this->table. " WHERE id = " .$id. ";");
		$banner = new CbBanner($row->id, $row->cb_category_id, $row->text, $row->url);
		return $banner;
	}

	public function save($banner) {
		global $wpdb;
		$wpdb->insert(
			$this->table,
			array(
				'cb_category_id' => $banner->get_cat_id(),
				'width'          => 200,
				'height'         => 30,
				'text'           => $banner->get_text(),
				'url'            => $banner->get_url()
			)
		);
	}

	public function delete($banner) {
		global $wpdb;
		$wpdb->delete($this->table, array('ID' => $banner->get_id()), array('%d'));
	}

	function create_table() {
		global $wpdb;
		$data_db_version = '1.0';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE ".$this->table." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`cb_category_id` int(11),
			`width` int UNSIGNED,
			`height` int UNSIGNED,
			`text` varchar(30) NOT NULL,
			`url` varchar(100) NOT NULL,
			PRIMARY KEY  (id),
			FOREIGN KEY  (cb_category_id) REFERENCES wp_cb_category(id) ON DELETE CASCADE
		) ".$charset_collate.";";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);
		add_option( 'data_db_version', $data_db_version );
	}

	function drop_table() {
		global $wpdb;
		$wpdb->query("DROP TABLE IF EXISTS ".$this->table."");
		delete_option( 'data_db_version' );
	}
}

?>
