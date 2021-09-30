<?php
/*
Plugin Name: Custom Banner
Plugin URI: http://www.example.com/plugin/
Description: 内部、外部リンクを貼ったバナーを作成する
Author: Shima
Author URI: http://www.example.com
Version: 1.0
*/
?>
<?php

require(dirname(__FILE__). '/controller/AdminController.php');
require(dirname(__FILE__). '/controller/CategoryController.php');
require(dirname(__FILE__). '/controller/BannerController.php');

add_action('init', 'CustomBanner::init');

class CustomBanner {

	static function init() {
		return new self();
	}

	const VERSION               = '1.0';
	const PLUGIN_ID             = 'custom-banner';
	const BANNER                = '-banner';
	const CATEGORY              = '-category';
	const CREDENTIAL_CAT_ACTION = self::PLUGIN_ID . self::CATEGORY . '-nonce-action';
	const CREDENTIAL_BAN_ACTION = self::PLUGIN_ID . self::BANNER . '-nonce-action';
	const CREDENTIAL_CAT_NAME   = self::PLUGIN_ID . self::CATEGORY . '-nonce-key';
	const CREDENTIAL_BAN_NAME   = self::PLUGIN_ID . self::BANNER . '-nonce-key';

	private $admin_controller;
	private $cat_controller;
	private $ban_controller;

	function __construct() {

		add_action('wp_enqueue_scripts', [$this, 'load_scripts']);

		$this->admin_controller = new AdminController();
		$this->cat_controller   = new CategoryController();
		$this->ban_controller   = new BannerController();

		register_activation_hook(dirname(__FILE__).'/service/ActivationService.php', ['ActivationService', 'activate']);
		register_uninstall_hook(dirname(__FILE__).'/service/UninstallService.php', ['UninstallService', 'uninstall']);
		if (is_admin() && is_user_logged_in()) {
			add_action('admin_menu', [$this->admin_controller, 'set_plugin_menu']);
			add_action('admin_menu', [$this->admin_controller, 'set_plugin_sub_menu']);
			add_action('admin_notices', [$this->admin_controller, 'ok_notices']);
			add_action('admin_init', [$this->cat_controller, 'save_category']);
			add_action('admin_init', [$this->cat_controller, 'delete_category']);
			add_action('admin_init', [$this->ban_controller, 'save_banner']);
			add_action('admin_init', [$this->ban_controller, 'delete_banner']);
		}
		add_shortcode('custom-banner', [$this->cat_controller, 'custom_banner']);
	}

	function load_scripts() {
		wp_enqueue_style('custom_banner_style_css', dirname(__FILE__). '/css/style.css');
	}
}

?>
