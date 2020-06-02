<?php
class Galleriesdislikes extends Controller {
	public function __construct(){
		$this->galleriesdislikesModel = $this->model('Galleriesdislike');
	}
	public function dislike_gallery($gallery_id){
		$dislike_gallery = $this->galleriesdislikesModel->dislike_gallery($gallery_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $dislike_gallery;
	}
	public function disliked_gallery($gallery_id){
		$disliked_gallery = $this->galleriesdislikesModel->disliked_gallery($gallery_id);
		return $disliked_gallery;
	}
}
?>