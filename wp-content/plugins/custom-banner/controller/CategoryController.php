<?php

require_once(dirname(__FILE__). '/../service/CategoryService.php');
require_once(dirname(__FILE__). '/../service/ModelService.php');

class CategoryController {

	private $cat_service;
	private $model;

	public function __construct() {
		$this->cat_service = new CategoryService();
		$this->model       = new ModelService();
	}

	function save_category() {
		if(isset($_POST[CustomBanner::CREDENTIAL_CAT_NAME]) && $_POST[CustomBanner::CREDENTIAL_CAT_NAME]) {
			if(check_admin_referer(CustomBanner::CREDENTIAL_CAT_ACTION, CustomBanner::CREDENTIAL_CAT_NAME)) {
				$this->cat_service->create_category($_POST['category']);
				set_transient("ok-notices", ["カテゴリーを登録しました。"], 10);
				wp_redirect(menu_page_url(CustomBanner::PLUGIN_ID));
			}
		}
	}

	function delete_category() {
		if(isset($_GET['page']) && $_GET['page'] == CustomBanner::PLUGIN_ID && isset($_GET['action']) && $_GET['action'] == 'delete') {
			$id = (int) $_GET['id'];
			$category = $this->cat_service->get_category_by_id($id);
			$this->cat_service->delete_category($category);
			set_transient("ok-notices", ["カテゴリーを削除しました。"], 10);
		}
	}

	function update_category() {
		if(isset($_POST[CustomBanner::CREDENTIAL_CAT_NAME]) && $_POST[CustomBanner::CREDENTIAL_CAT_NAME]) {
			if(check_admin_referer(CustomBanner::CREDENTIAL_CAT_ACTION, CustomBanner::CREDENTIAL_CAT_NAME)) {
				$this->cat_service->update_category($_POST['category'], $_POST['name']);
				set_transient("ok-notice", ["カテゴリー名を変更しました。"], 10);
				wp_redirect(menu_page_url(CustomBanner::PLUGIN_ID));
			}
		}
	}

	function show_edit_category($id) {
                global $wpdb;
                $table_name = $wpdb->prefix . 'cb_banner';
                $banners = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE cb_category_id = ".$id.";");
        ?>
                <h3>新規バナー登録</h3>

                        <form action="" method="post" id="my-submenu-form">
                        <?php wp_nonce_field(self::CREDENTIAL_BAN_ACTION, self::CREDENTIAL_BAN_NAME) ?>
                                <p>
                                        <label for="text">テキスト:</label>
                                        <input type="text" name="text" />
                                </p>
                                <p>
                                        <label for="url">URL:</label>
                                        <input type="text" name="url" />
                                </p>
                                <p><input type='submit' value='保存' class='button button-primary button-large'></p>
                        </form>
        <?php
        }

	function custom_banner($atts) {
		extract(shortcode_atts(array(
			'id' => 0,
		), $atts));
		$file             = dirname(__FILE__). '/../templates/banner-list.php';
		$banners          = $this->cat_service->get_banners_by_cat_id($id);
		$this->model->display_template($file, $banners);
        }
}

?>
