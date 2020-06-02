<?php
class Usersgalleries extends Controller {
	public function __construct(){
		$this->usersgalleryModel = $this->model('Usersgallery');
	}
	public function add($users_gallery_media,$user_id,$cat){
		$add = $this->usersgalleryModel->add($users_gallery_media,$user_id,$cat);
		return $add;
	}
	public function delete($users_gallery_id){
		$delete = $this->usersgalleryModel->delete($users_gallery_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete;
	}
	public function read($cat,$photos_gallery_id){
		$read_profile_images = $this->usersgalleryModel->read($cat,$photos_gallery_id);
		return $read_profile_images;
	}
	public function readjust_number($num,$photos_gallery_id){
		$readjust_number = $this->usersgalleryModel->readjust_number($num,$photos_gallery_id);
		return $readjust_number;
	}
	public function count_p_images($photos_gallery_id){
		$count_p_images = $this->usersgalleryModel->count_p_images($photos_gallery_id);
		return $count_p_images;
	}
	public function count_pbi_images($photos_gallery_id){
		$count_pbi_images = $this->usersgalleryModel->count_pbi_images($photos_gallery_id);
		return $count_pbi_images;
	}
	public function count_u_images($photos_gallery_id){
		$count_u_images = $this->usersgalleryModel->count_u_images($photos_gallery_id);
		return $count_u_images;
	}

}
?>