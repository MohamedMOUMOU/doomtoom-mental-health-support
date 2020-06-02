<?php
class Likes extends Controller {
	public function __construct(){
		$this->likesModel = $this->model('Like');
	}
	public function likePost($post_id){
		$like = $this->likesModel->likePost($post_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		die();
		return $like;
	}
	public function liked($post_id){
		$liked = $this->likesModel->liked($post_id);
		return $liked;
	}
	public function likes_vs_friends(){
		$likes_vs_friends = $this->likesModel->likes_vs_friends();
		return $likes_vs_friends;
	}
	public function update_post_likes_count(){
		$update_post_likes_count = $this->likesModel->update_post_likes_count();
		return $update_post_likes_count;
	}
}
?>