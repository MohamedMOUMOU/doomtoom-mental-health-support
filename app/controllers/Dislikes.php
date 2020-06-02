<?php
class Dislikes extends Controller {
	public function __construct(){
		$this->dislikesModel = $this->model('Dislike');
	}
	public function disLikePost($post_id){
		$dislike = $this->dislikesModel->disLikePost($post_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $dislike;
	}
	public function disliked($post_id){
		$disliked = $this->dislikesModel->disliked($post_id);
		return $disliked;
	}
	public function update_post_dislikes_count(){
		$update_post_dislikes_count = $this->dislikesModel->update_post_dislikes_count();
		return $update_post_dislikes_count;
	}
}
?>