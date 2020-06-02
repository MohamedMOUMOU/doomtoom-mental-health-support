<?php
class Relates extends Controller {
	public function __construct(){
		$this->relatesModel = $this->model('Relate');
	}
	public function relatePost($post_id){
		$relate = $this->relatesModel->relatePost($post_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		die();
		return $relate;
	}
	public function related($post_id){
		$related = $this->relatesModel->related($post_id);
		return $related;
	}
	public function update_post_relates_count(){
		$update_post_relates_count = $this->relatesModel->update_post_relates_count();
		return $update_post_relates_count;
	}
}
?>