<?php
class Categories extends Controller {
	public function __construct(){
		$this->categoryModel = $this->model('Category');
	}
	public function selectCategories(){
		$categories = $this->categoryModel->selectCategoriesInfo();
		return $categories;
	}
	public function findCategoryByPost($post_id){
		$category = $this->categoryModel->findCategoryByPost($post_id);
		return $category;
	}
	public function findCategoryById($cat_id){
		$cat_title = $this->categoryModel->findCategoryById($cat_id);
		return $cat_title;
	}
}
?>