<?php
class Personalgalleries extends Controller {
	public function __construct(){
		$this->personalgalleryModel = $this->model('Personalgallery');
	}
	public function add($photos_gallery_id){
		if($_SESSION['photos_gallery_id'] == $photos_gallery_id){
			if(isset($_POST['change_personal_gallery_image'])){
				$add = $this->personalgalleryModel->add();
				header('Location: ' . $_SERVER['HTTP_REFERER']);
				return $add;
			}
		}else{
			flash("photo_not_added","You can not add photos to other people galleries","error");
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	public function delete($personal_gallery_id){
		$delete = $this->personalgalleryModel->delete($personal_gallery_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete;
	}
	public function read($photos_gallery_id){
		if($photos_gallery_id == $_SESSION['photos_gallery_id']){
			$read = $this->personalgalleryModel->read($photos_gallery_id);
		}else{
			$read = $this->personalgalleryModel->read_published($photos_gallery_id);
		}
		return $read;
	}
	public function readjust_number($num,$photos_gallery_id){
		if($photos_gallery_id == $_SESSION['photos_gallery_id']){
			$readjust_number = $this->personalgalleryModel->readjust_number($num,$photos_gallery_id);
		}else{
			$readjust_number = $this->personalgalleryModel->readjust_number_published($num,$photos_gallery_id);
		}
		return $readjust_number;
	}
	public function count($photos_gallery_id){
		if($photos_gallery_id == $_SESSION['photos_gallery_id']){
			$count = $this->personalgalleryModel->count($photos_gallery_id);
		}else{
			$count = $this->personalgalleryModel->count_published($photos_gallery_id);
		}
		return $count;
	}
}
?>