<?php
class Personalgallery{
	public function __construct(){
		$this->db = new Database;
	}
	public function add(){
		$num = rand(0,999999999999);
		$personal_gallery_media = $_SESSION['photos_gallery_id'] . $_SESSION['user_id'] . $num . $_FILES['personal_gallery_media']['name'];
		$personal_gallery_media_temp = $_FILES['personal_gallery_media']['tmp_name'];
		move_uploaded_file($personal_gallery_media_temp,$_SERVER['DOCUMENT_ROOT'] . "\mymvc\public\images\gallery_images\\" . $_SESSION['user_name'] . "_images\\" . $personal_gallery_media);
		$this->db->query("INSERT INTO personal_gallery(photos_gallery_id,user_id,personal_gallery_media,status) VALUES(:photos_gallery_id,:user_id,:personal_gallery_media,:status)");
		$this->db->bind(':photos_gallery_id', $_SESSION['photos_gallery_id']);
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->bind(':personal_gallery_media', $personal_gallery_media);
		$this->db->bind(':status', $_POST['status']);
		$this->db->execute();
	}
	public function delete($personal_gallery_id){
		$this->db->query("DELETE FROM personal_gallery WHERE personal_gallery_id = :personal_gallery_id AND user_id = :user_id AND photos_gallery_id = :photos_gallery_id");
		$this->db->bind(':photos_gallery_id', $_SESSION['photos_gallery_id']);
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->bind(':personal_gallery_id', $personal_gallery_id);
		$this->db->execute();

	}
	public function read($photos_gallery_id){
		$this->db->query("SELECT personal_gallery_media,personal_gallery_id FROM personal_gallery WHERE photos_gallery_id = :photos_gallery_id ORDER BY personal_gallery_id DESC");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$personal_gallery_media = $this->db->resultSet();
		return $personal_gallery_media;
	}
	public function readjust_number($num,$photos_gallery_id){
		$this->db->query("SELECT personal_gallery_media,personal_gallery_id FROM personal_gallery WHERE photos_gallery_id = :photos_gallery_id ORDER BY personal_gallery_id DESC LIMIT :num");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->bind(':num', $num);
		$this->db->execute();
		$personal_gallery_media = $this->db->resultSet();
		return $personal_gallery_media;
	}
	public function count($photos_gallery_id){
		$this->db->query("SELECT personal_gallery_media FROM personal_gallery WHERE photos_gallery_id = :photos_gallery_id ORDER BY personal_gallery_id");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$posts_gallery_media_count = $this->db->rowCount();
		return $posts_gallery_media_count;
	}
	public function read_published($photos_gallery_id){
		$this->db->query("SELECT personal_gallery_media,personal_gallery_id FROM personal_gallery WHERE photos_gallery_id = :photos_gallery_id AND status = 'published' ORDER BY personal_gallery_id DESC");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$personal_gallery_media = $this->db->resultSet();
		return $personal_gallery_media;
	}
	public function readjust_number_published($num,$photos_gallery_id){
		$this->db->query("SELECT personal_gallery_media,personal_gallery_id FROM personal_gallery WHERE photos_gallery_id = :photos_gallery_id AND status = 'published' ORDER BY personal_gallery_id DESC LIMIT :num");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->bind(':num', $num);
		$this->db->execute();
		$personal_gallery_media = $this->db->resultSet();
		return $personal_gallery_media;
	}
	public function count_published($photos_gallery_id){
		$this->db->query("SELECT personal_gallery_media FROM personal_gallery WHERE photos_gallery_id = :photos_gallery_id AND status = 'published' ORDER BY personal_gallery_id");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$posts_gallery_media_count = $this->db->rowCount();
		return $posts_gallery_media_count;
	}
}