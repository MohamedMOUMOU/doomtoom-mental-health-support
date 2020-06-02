<?php
class Profilelike extends Controller {
	public function __construct(){
		$this->db = new Database;
	}
	public function likeProfile($profile_id){
		$this->db->query("SELECT dislike_id FROM profile_dislikes WHERE user_id = :current_user_id AND profile_id = :profile_id AND disliked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':profile_id', $profile_id);
		$this->db->execute();
		$count3 = $this->db->rowCount();
		if($count3 === 1){
			$this->db->query("UPDATE profile_dislikes SET disliked = 0 WHERE user_id = :current_user_id AND profile_id = :profile_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':profile_id', $profile_id);
			$remove_profile_dislike = $this->db->execute();
			$action = $remove_profile_dislike;
		}
		$this->db->query("SELECT like_id FROM profile_likes WHERE user_id = :current_user_id AND profile_id = :profile_id AND liked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':profile_id', $profile_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		$this->db->query("SELECT like_id FROM profile_likes WHERE user_id = :current_user_id AND profile_id = :profile_id AND liked = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':profile_id', $profile_id);
		$this->db->execute();
		$count2 = $this->db->rowCount();
		if($count === 1){
			$this->db->query("UPDATE profile_likes SET liked = 0 WHERE user_id = :current_user_id AND profile_id = :profile_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':profile_id', $profile_id);
			$this->db->execute();
			$this->update_profile_likes_count($profile_id);
			$this->update_profile_dislikes_count($profile_id);
		}elseif($count2 === 1){
			$this->db->query("UPDATE profile_likes SET liked = 1 WHERE user_id = :current_user_id AND profile_id = :profile_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':profile_id', $profile_id);
			$this->db->execute();
			$this->update_profile_likes_count($profile_id);
			$this->update_profile_dislikes_count($profile_id);
		}else{
			$this->db->query("INSERT INTO profile_likes(user_id,profile_id,liked) VALUES(:current_user_id,:profile_id,1)");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':profile_id', $profile_id);
			$this->db->execute();
			$this->update_profile_likes_count($profile_id);
			$this->update_profile_dislikes_count($profile_id);
		}
		return $action;
	}
	public function likedprofile($profile_id){
		$this->db->query("SELECT like_id FROM profile_likes WHERE profile_id = :profile_id AND user_id = :current_user_id AND liked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':profile_id', $profile_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		if($count === 1){
			return true;
		}else{
			return false;
		}
	}
	public function new_profile_likes_count($profile_id){
		$this->db->query("SELECT liked FROM profile_likes WHERE profile_id = :profile_id AND liked = 1");
		$this->db->bind(':profile_id', $profile_id);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function update_profile_likes_count($profile_id){
		$new_profile_likes_count = $this->new_profile_likes_count($profile_id);
		$this->db->query("UPDATE users SET profile_likes_count = :profile_likes_count WHERE user_id = :profile_id");
		$this->db->bind(':profile_likes_count', $new_profile_likes_count);
		$this->db->bind(':profile_id', $profile_id);
		return $this->db->execute();
	}
	public function new_profile_dislikes_count($profile_id){
		$this->db->query("SELECT disliked FROM profile_dislikes WHERE profile_id = :profile_id AND disliked = 1");
		$this->db->bind(':profile_id', $profile_id);
		$this->db->execute();
		return $this->db->rowcount();
	}
	public function update_profile_dislikes_count($profile_id){
		$new_profile_dislikes_count = $this->new_profile_dislikes_count($profile_id);
		$this->db->query("UPDATE users SET profile_dislikes_count = :profile_dislikes_count WHERE user_id = :profile_id");
		$this->db->bind(':profile_dislikes_count', $new_profile_dislikes_count);
		$this->db->bind(':profile_id', $profile_id);
		return $this->db->execute();
	}
}