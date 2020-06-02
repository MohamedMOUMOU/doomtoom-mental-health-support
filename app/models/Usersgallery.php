<?php
class Usersgallery{
	public function __construct(){
		$this->db = new Database;
	}
	public function add($users_gallery_media,$user_id,$cat){
		$this->db->query("INSERT INTO users_gallery(photos_gallery_id,user_id,users_gallery_media,category) VALUES(:photos_gallery_id,:user_id,:users_gallery_media,:category)");
		$this->db->bind(':photos_gallery_id', $_SESSION['photos_gallery_id']);
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':users_gallery_media', $users_gallery_media);
		$this->db->bind(':category', $cat);
		return $this->db->execute();
	}
	public function delete($users_gallery_id){
		$this->db->query("DELETE FROM users_gallery WHERE users_gallery_id = :users_gallery_id AND user_id = :user_id AND photos_gallery_id = :photos_gallery_id");
		$this->db->bind(':photos_gallery_id', $_SESSION['photos_gallery_id']);
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->bind(':users_gallery_id', $users_gallery_id);
		$this->db->execute();

	}
	public function read($cat,$photos_gallery_id){
		$this->db->query("SELECT users_gallery_media,users_gallery_id FROM users_gallery WHERE photos_gallery_id = :photos_gallery_id AND category = :category ORDER BY users_gallery_id DESC");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->bind(':category', $cat);
		$this->db->execute();
		$users_gallery_media = $this->db->resultSet();
		return $users_gallery_media;
	}
	public function readjust_number($num,$photos_gallery_id){
		$this->db->query("SELECT users_gallery_media,users_gallery_id,category FROM users_gallery WHERE photos_gallery_id = :photos_gallery_id ORDER BY users_gallery_id DESC LIMIT :num");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->bind(':num', $num);
		$this->db->execute();
		$users_gallery_media = $this->db->resultSet();
		return $users_gallery_media;
	}
	public function count_p_images($photos_gallery_id){
		$this->db->query("SELECT users_gallery_media FROM users_gallery WHERE photos_gallery_id = :photos_gallery_id AND category = 'profile_images'");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$users_gallery_media_count = $this->db->rowCount();
		return $users_gallery_media_count;
	}
	public function count_pbi_images($photos_gallery_id){
		$this->db->query("SELECT users_gallery_media FROM users_gallery WHERE photos_gallery_id = :photos_gallery_id AND category = 'pbi_images'");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$users_gallery_media_count = $this->db->rowCount();
		return $users_gallery_media_count;
	}
	public function count_u_images($photos_gallery_id){
		$this->db->query("SELECT users_gallery_media FROM users_gallery WHERE photos_gallery_id = :photos_gallery_id");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$users_gallery_media_count = $this->db->rowCount();
		return $users_gallery_media_count;
	}
}