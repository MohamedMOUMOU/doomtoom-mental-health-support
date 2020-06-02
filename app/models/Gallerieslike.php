<?php
class Gallerieslike extends Controller {
	public function __construct(){
		$this->db = new Database;
	}
	public function like_gallery($gallery_id){
		$this->db->query("SELECT dislike_id FROM galleries_dislikes WHERE user_id = :current_user_id AND gallery_id = :gallery_id AND disliked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':gallery_id', $gallery_id);
		$this->db->execute();
		$count3 = $this->db->rowCount();
		if($count3 === 1){
			$this->db->query("UPDATE galleries_dislikes SET disliked = 0 WHERE user_id = :current_user_id AND gallery_id = :gallery_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':gallery_id', $gallery_id);
			$remove_profile_dislike = $this->db->execute();
			$action = $remove_profile_dislike;
		}
		$this->db->query("SELECT like_id FROM galleries_likes WHERE user_id = :current_user_id AND gallery_id = :gallery_id AND liked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':gallery_id', $gallery_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		$this->db->query("SELECT like_id FROM galleries_likes WHERE user_id = :current_user_id AND gallery_id = :gallery_id AND liked = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':gallery_id', $gallery_id);
		$this->db->execute();
		$count2 = $this->db->rowCount();
		if($count === 1){
			$this->db->query("UPDATE galleries_likes SET liked = 0 WHERE user_id = :current_user_id AND gallery_id = :gallery_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':gallery_id', $gallery_id);
			$this->db->execute();
			$this->update_gallery_likes_count($gallery_id);
			$this->update_gallery_dislikes_count($gallery_id);
		}elseif($count2 === 1){
			$this->db->query("UPDATE galleries_likes SET liked = 1 WHERE user_id = :current_user_id AND gallery_id = :gallery_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':gallery_id', $gallery_id);
			$this->db->execute();
			$this->update_gallery_likes_count($gallery_id);
			$this->update_gallery_dislikes_count($gallery_id);
		}else{
			$this->db->query("INSERT INTO galleries_likes(user_id,gallery_id,liked) VALUES(:current_user_id,:gallery_id,1)");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':gallery_id', $gallery_id);
			$this->db->execute();
			$this->update_gallery_likes_count($gallery_id);
			$this->update_gallery_dislikes_count($gallery_id);
		}
		return $action;
	}
	public function liked_gallery($gallery_id){
		$this->db->query("SELECT like_id FROM galleries_likes WHERE gallery_id = :gallery_id AND user_id = :current_user_id AND liked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':gallery_id', $gallery_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		if($count === 1){
			return true;
		}else{
			return false;
		}
	}
	public function new_gallery_likes_count($gallery_id){
		$this->db->query("SELECT liked FROM galleries_likes WHERE gallery_id = :gallery_id AND liked = 1");
		$this->db->bind(':gallery_id', $gallery_id);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function update_gallery_likes_count($gallery_id){
		$new_gallery_likes_count = $this->new_gallery_likes_count($gallery_id);
		$this->db->query("UPDATE photos_galleries SET likes_count = :likes_count WHERE gallery_id = :gallery_id");
		$this->db->bind(':likes_count', $new_gallery_likes_count);
		$this->db->bind(':gallery_id', $gallery_id);
		return $this->db->execute();
	}
	public function new_gallery_dislikes_count($gallery_id){
		$this->db->query("SELECT disliked FROM galleries_dislikes WHERE gallery_id = :gallery_id AND disliked = 1");
		$this->db->bind(':gallery_id', $gallery_id);
		$this->db->execute();
		return $this->db->rowcount();
	}
	public function update_gallery_dislikes_count($gallery_id){
		$new_gallery_dislikes_count = $this->new_gallery_dislikes_count($gallery_id);
		$this->db->query("UPDATE photos_galleries SET dislikes_count = :dislikes_count WHERE gallery_id = :gallery_id");
		$this->db->bind(':dislikes_count', $new_gallery_dislikes_count);
		$this->db->bind(':gallery_id', $gallery_id);
		return $this->db->execute();
	}
}