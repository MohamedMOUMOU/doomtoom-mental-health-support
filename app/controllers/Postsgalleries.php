<?php
class Postsgalleries extends Controller {
	public function __construct(){
		$this->postsgalleryModel = $this->model('Postsgallery');
	}
	public function add($posts_gallery_media,$post_id,$status){
		$add = $this->postsgalleryModel->add($posts_gallery_media,$post_id,$status);
		return $add;
	}
	public function delete($posts_gallery_id){
		$delete = $this->postsgalleryModel->delete($posts_gallery_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete;
	}
	public function update_by_image($post_image,$status){
		$update_by_image = $this->postsgalleryModel->update_by_image($post_image,$status);
		return $update_by_image;
	}
	public function read($photos_gallery_id){
		if($photos_gallery_id == $_SESSION['photos_gallery_id']){
			$read = $this->postsgalleryModel->read($photos_gallery_id);
		}else{
			$read = $this->postsgalleryModel->read_published($photos_gallery_id);
		}
		return $read;
	}
	public function readjust_number($num,$photos_gallery_id){
		if($photos_gallery_id == $_SESSION['photos_gallery_id']){
			$readjust_number = $this->postsgalleryModel->readjust_number($num,$photos_gallery_id);
		}else{
			$readjust_number = $this->postsgalleryModel->readjust_number_published($num,$photos_gallery_id);
		}
		return $readjust_number;
	}
	public function count($photos_gallery_id){
		if($photos_gallery_id == $_SESSION['photos_gallery_id']){
			$count = $this->postsgalleryModel->count($photos_gallery_id);
		}else{
			$count = $this->postsgalleryModel->count_published($photos_gallery_id);
		}
		return $count;
	}
}
?>