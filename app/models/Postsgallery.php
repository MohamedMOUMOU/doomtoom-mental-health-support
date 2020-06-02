<?php
class Postsgallery{
	public function __construct(){
		$this->db = new Database;
	}
	public function add($posts_gallery_media,$post_id,$status){
		$this->db->query("INSERT INTO posts_gallery(photos_gallery_id,post_user_id,post_id,posts_gallery_media,status) VALUES(:photos_gallery_id,:post_user_id,:post_id,:posts_gallery_media,:status)");
		$this->db->bind(':photos_gallery_id', $_SESSION['photos_gallery_id']);
		$this->db->bind(':post_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->bind(':posts_gallery_media', $posts_gallery_media);
		$this->db->bind(':status', $status);
		return $this->db->execute();
	}
	public function delete($posts_gallery_id){
		$this->db->query("DELETE FROM posts_gallery WHERE posts_gallery_id = :posts_gallery_id AND post_user_id = :post_user_id AND photos_gallery_id = :photos_gallery_id");
		$this->db->bind(':photos_gallery_id', $_SESSION['photos_gallery_id']);
		$this->db->bind(':post_user_id', $_SESSION['user_id']);
		$this->db->bind(':posts_gallery_id', $posts_gallery_id);
		$this->db->execute();

	}
	public function update_by_image($post_image,$status){
		$this->db->query("UPDATE posts_gallery SET status = :status WHERE posts_gallery_media = :post_image");
		$this->db->bind(':status', $status);
		$this->db->bind(':post_image', $post_image);
		return $this->db->execute();
	}
	public function read($photos_gallery_id){
		$this->db->query("SELECT posts_gallery_media,posts_gallery_id FROM posts_gallery WHERE photos_gallery_id = :photos_gallery_id ORDER BY posts_gallery_id DESC");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$posts_gallery_media = $this->db->resultSet();
		return $posts_gallery_media;
	}
	public function readjust_number($num,$photos_gallery_id){
		$this->db->query("SELECT posts_gallery_media FROM posts_gallery WHERE photos_gallery_id = :photos_gallery_id ORDER BY posts_gallery_id DESC LIMIT :num");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->bind(':num', $num);
		$this->db->execute();
		$posts_gallery_media = $this->db->resultSet();
		return $posts_gallery_media;
	}
	public function count($photos_gallery_id){
		$this->db->query("SELECT posts_gallery_media FROM posts_gallery WHERE photos_gallery_id = :photos_gallery_id ORDER BY posts_gallery_id");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$posts_gallery_media_count = $this->db->rowCount();
		return $posts_gallery_media_count;
	}
	public function read_published($photos_gallery_id){
		$this->db->query("SELECT posts_gallery_media,posts_gallery_id FROM posts_gallery WHERE photos_gallery_id = :photos_gallery_id AND status = 'published' ORDER BY posts_gallery_id DESC");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$posts_gallery_media = $this->db->resultSet();
		return $posts_gallery_media;
	}
	public function readjust_number_published($num,$photos_gallery_id){
		$this->db->query("SELECT posts_gallery_media FROM posts_gallery WHERE photos_gallery_id = :photos_gallery_id AND status = 'published' ORDER BY posts_gallery_id DESC LIMIT :num");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->bind(':num', $num);
		$this->db->execute();
		$posts_gallery_media = $this->db->resultSet();
		return $posts_gallery_media;
	}
	public function count_published($photos_gallery_id){
		$this->db->query("SELECT posts_gallery_media FROM posts_gallery WHERE photos_gallery_id = :photos_gallery_id AND status = 'published' ORDER BY posts_gallery_id");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$this->db->execute();
		$posts_gallery_media_count = $this->db->rowCount();
		return $posts_gallery_media_count;
	}
}