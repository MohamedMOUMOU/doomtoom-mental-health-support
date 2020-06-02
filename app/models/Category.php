<?php
class Category{
	public function __construct(){
		$this->db = new Database;
	}
	public function selectCategoriesInfo(){
		$this->db->query("SELECT * FROM categories");
		$categories = $this->db->resultSet();
		return $categories;
	}
	public function findCategoryByPost($post_id){
		$this->db->query("SELECT categories.cat_title FROM categories LEFT JOIN posts ON categories.cat_id = posts.post_category_id WHERE posts.post_id = :post_id");
		$this->db->bind(':post_id', $post_id);
		return $this->db->single();
	}
	public function findCategoryById($cat_id){
		$this->db->query("SELECT cat_title FROM categories WHERE cat_id = :cat_id");
		$this->db->bind(':cat_id', $cat_id);
		return $this->db->single();
	}
}