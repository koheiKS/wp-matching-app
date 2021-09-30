<?php

require_once(dirname(__FILE__). '/../entity/CbBanner.php');
require_once(dirname(__FILE__). '/../repository/CbBannerRep.php');

class BannerService {

	private $banner_rep;

	public function __construct() {
		$this->banner_rep = new CbBannerRep();
	}

	public function get_banner_by_id($id) {
		return $this->banner_rep->find_by_id($id);
	}

	public function create_banner($cat_id, $text, $url) {
		$banner     = new CbBanner($cat_id, $text, $url);
		$this->banner_rep->save($banner);
	}

	public function delete_banner_by_id($banner) {
		$this->banner_rep->delete($banner);
	}

}

?>
