<?php

require_once(dirname(__FILE__). '/../entity/CbCategory.php');
require_once(dirname(__FILE__). '/../repository/CbCategoryRep.php');

class CategoryService {

	private $category_rep;

	public function __construct() {
		$this->category_rep = new CbCategoryRep();
	}

	public function create_category($name) {
		$category = new CbCategory($name);
		$this->category_rep->save($category);
	}

	public function get_category_by_id($id) {
		$category = $this->category_rep->find_by_id($id);
		return $category;
	}

	public function get_all_categories() {
		return $this->category_rep->find_all();
	}

	public function get_banners_by_cat_id($cat_id) {
		$category = $this->category_rep->find_by_id($cat_id);
		return $category->get_banners();
	}

	public function delete_category($category) {
		$this->category_rep->delete($category);
	}
}

?>
