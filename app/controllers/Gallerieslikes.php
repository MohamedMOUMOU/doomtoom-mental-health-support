<?php
class Gallerieslikes extends Controller {
	public function __construct(){
		$this->gallerieslikesModel = $this->model('Gallerieslike');
	}
	public function like_gallery($gallery_id){
		$like_gallery = $this->gallerieslikesModel->like_gallery($gallery_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $like_gallery;
	}
	public function liked_gallery($gallery_id){
		$liked_gallery = $this->gallerieslikesModel->liked_gallery($gallery_id);
		return $liked_gallery;
	}
}
?>