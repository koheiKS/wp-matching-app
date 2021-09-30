<?php

require_once(dirname(__FILE__). '/../service/CategoryService.php');
require_once(dirname(__FILE__). '/../service/ModelService.php');

class AdminController {

	private $cat_service;
	private $model;

	static function init() {
		return new self();
	}

	public function __construct() {
		$this->cat_service = new CategoryService();
		$this->model       = new ModelService();
	}

	public function set_plugin_menu() {
		add_menu_page(
			'カスタムバナー',
			'カスタムバナー',
			'manage_options',
			'custom-banner',
			[$this, 'show_about_plugin'],
			'dashicons-excerpt-view'
		);
	}
	public function set_plugin_sub_menu() {
		add_submenu_page(
			'custom-banner',
			'設定',
			'設定',
			'manage_options',
			'custom-banner-config',
			[$this, 'show_config_form'],
			'dashicons-admin-tools'
		);
	}

	function show_about_plugin() {
		global $wpdb;
		$atts = array();
		if (isset($_GET['action']) && $_GET['action']=='edit') {
			$file        = dirname(__FILE__). '/../templates/admin-banner.php';
			$id          = $_GET['id'];
			$nonce_field = wp_nonce_field(CustomBanner::CREDENTIAL_BAN_ACTION, CustomBanner::CREDENTIAL_BAN_NAME);
			$banners     = $this->cat_service->get_banners_by_cat_id($id);
			$atts += array(
				'id'          => $id,
				'nonce_field' => $nonce_field,
				'banners'     => $banners
			);
		} else {
			$file        = dirname(__FILE__). '/../templates/admin-category.php';
			$nonce_field = wp_nonce_field(CustomBanner::CREDENTIAL_CAT_ACTION, CustomBanner::CREDENTIAL_CAT_NAME);
			$categories  = $this->cat_service->get_all_categories();
			$atts += array(
				'nonce_field' => $nonce_field,
				'categories'  => $categories
			);
		}
		$this->model->display_template($file, $atts);
	}

	function ok_notices() {
		if ($messages = get_transient( 'ok-notices' ) ) {
			$file = dirname(__FILE__). '/../templates/ok-notice.php';
			$this->model->display_template($file, $messages);
		}
	}
}

?>
