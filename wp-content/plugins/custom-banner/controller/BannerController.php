<?php

require_once(dirname(__FILE__). '/../service/BannerService.php');

class BannerController {

	private $ban_service;

	public function __construct() {
		$this->ban_service = new BannerService();
	}

	public function save_banner() {
		if(isset($_POST[CustomBanner::CREDENTIAL_BAN_NAME]) && $_POST[CustomBanner::CREDENTIAL_BAN_NAME]) {
			if(check_admin_referer(CustomBanner::CREDENTIAL_BAN_ACTION, CustomBanner::CREDENTIAL_BAN_NAME)) {
				set_transient("ok-notices", ["バナーを登録しました。"], 10);
				$cat_id = $_POST['banner-cat-id'];
				$this->ban_service->create_banner($_POST['banner-cat-id'], $_POST['banner-text'], $_POST['banner-url']);
				wp_redirect(menu_page_url(CustomBanner::PLUGIN_ID) . "&action=edit&id=" . $cat_id);
			}
		}
	}

	function delete_banner() {
		if(isset($_GET['page']) && $_GET['page'] == CustomBanner::PLUGIN_ID && isset($_GET['ban-action']) && $_GET['ban-action'] == 'delete') {
			$id     = (int) $_GET['ban-id'];
			$banner = $this->ban_service->get_banner_by_id($id);
			$this->ban_service->delete_banner_by_id($banner);
			set_transient("ok-notices", ["バナーを削除しました。"], 10);
		}
	}
}

?>
