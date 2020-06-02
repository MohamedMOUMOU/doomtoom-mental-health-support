<?php
class Dislike{
	public function __construct(){
		$this->db = new Database;
	}
	public function disLikePost($post_id){
		$this->db->query("SELECT like_id FROM likes WHERE user_id = :current_user_id AND post_id = :post_id AND likes = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count3 = $this->db->rowCount();
		if($count3 === 1){
			$this->db->query("UPDATE likes SET likes = 0 WHERE user_id = :current_user_id AND post_id = :post_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$remove_dislike = $this->db->execute();
			$action = $remove_dislike;
		}
		$this->db->query("SELECT dislike_id FROM dislikes WHERE user_id = :current_user_id AND post_id = :post_id AND disliked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		$this->db->query("SELECT dislike_id FROM dislikes WHERE user_id = :current_user_id AND post_id = :post_id AND disliked = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count2 = $this->db->rowCount();
		if($count === 1){
			$this->db->query("UPDATE dislikes SET disliked = 0 WHERE user_id = :current_user_id AND post_id = :post_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_likes_count($post_id);
			$this->update_post_dislikes_count($post_id);
		}elseif($count2 === 1){
			$this->db->query("UPDATE dislikes SET disliked = 1 WHERE user_id = :current_user_id AND post_id = :post_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_likes_count($post_id);
			$this->update_post_dislikes_count($post_id);
		}else{
			$this->db->query("INSERT INTO dislikes(user_id,post_id,disliked) VALUES(:current_user_id,:post_id,1)");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_likes_count($post_id);
			$this->update_post_dislikes_count($post_id);
		}
	}
	public function disliked($post_id){
		$this->db->query("SELECT dislike_id FROM dislikes WHERE post_id = :post_id AND user_id = :current_user_id AND disliked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		if($count === 1){
			return true;
		}else{
			return false;
		}
	}
	public function new_post_likes_count($post_id){
		$this->db->query("SELECT likes FROM likes WHERE post_id = :post_id AND likes = 1");
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function update_post_likes_count($post_id){
		$new_post_likes_count = $this->new_post_likes_count($post_id);
		$this->db->query("UPDATE posts SET post_likes_count = :post_likes_count WHERE post_id = :post_id");
		$this->db->bind(':post_likes_count', $new_post_likes_count);
		$this->db->bind(':post_id', $post_id);
		return $this->db->execute();
	}
	public function new_post_dislikes_count($post_id){
		$this->db->query("SELECT disliked FROM dislikes WHERE post_id = :post_id AND disliked = 1");
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		return $this->db->rowcount();
	}
	public function update_post_dislikes_count($post_id){
		$new_post_dislikes_count = $this->new_post_dislikes_count($post_id);
		$this->db->query("UPDATE posts SET post_dislikes_count = :post_dislikes_count WHERE post_id = :post_id");
		$this->db->bind(':post_dislikes_count', $new_post_dislikes_count);
		$this->db->bind(':post_id', $post_id);
		return $this->db->execute();
	}
}
?>