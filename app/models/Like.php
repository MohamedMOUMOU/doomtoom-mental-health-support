<?php
class Like extends Controller {
	public function __construct(){
		$this->db = new Database;
	}
	public function likePost($post_id){
		$this->db->query("SELECT dislike_id FROM dislikes WHERE user_id = :current_user_id AND post_id = :post_id AND disliked = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count3 = $this->db->rowCount();
		$this->db->query("SELECT post_user_id FROM posts WHERE post_id = :post_id");
		$this->db->bind(':post_id', $post_id);
		$res = $this->db->single();
		$this->db->query("SELECT feel_better_count FROM users WHERE user_id = :post_user_id");
		$this->db->bind(':post_user_id', $res->post_user_id);
		$resu = $this->db->single();
		if($count3 === 1){
			$this->db->query("UPDATE dislikes SET disliked = 0 WHERE user_id = :current_user_id AND post_id = :post_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$remove_dislike = $this->db->execute();
			$action = $remove_dislike;
		}
		$this->db->query("SELECT like_id FROM likes WHERE user_id = :current_user_id AND post_id = :post_id AND likes = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		$this->db->query("SELECT like_id FROM likes WHERE user_id = :current_user_id AND post_id = :post_id AND likes = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count2 = $this->db->rowCount();
		if($count === 1){
			$this->db->query("UPDATE likes SET likes = 0 WHERE user_id = :current_user_id AND post_id = :post_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_likes_count($post_id);
			$this->update_post_dislikes_count($post_id);
			$f_count = $resu->feel_better_count - 1;
			$this->db->query("UPDATE users SET feel_better_count = :feel_better_count WHERE user_id = :post_user_id");
			$this->db->bind(':feel_better_count', $f_count);
			$this->db->bind(':post_user_id', $res->post_user_id);
			$this->db->execute();
		}elseif($count2 === 1){
			$this->db->query("UPDATE likes SET likes = 1 WHERE user_id = :current_user_id AND post_id = :post_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_likes_count($post_id);
			$this->update_post_dislikes_count($post_id);
			$f_count = $resu->feel_better_count + 1;
			$this->db->query("UPDATE users SET feel_better_count = :feel_better_count WHERE user_id = :post_user_id");
			$this->db->bind(':feel_better_count', $f_count);
			$this->db->bind(':post_user_id', $res->post_user_id);
			$this->db->execute();
		}else{
			$this->db->query("INSERT INTO likes(user_id,post_id,likes) VALUES(:current_user_id,:post_id,1)");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_likes_count($post_id);
			$this->update_post_dislikes_count($post_id);
			$this->db->query("SELECT post_user_id FROM posts WHERE post_id = :post_id");
			$this->db->bind(':post_id', $post_id);
			$f_count = $resu->feel_better_count + 1;
			$this->db->query("UPDATE users SET feel_better_count = :feel_better_count WHERE user_id = :post_user_id");
			$this->db->bind(':feel_better_count', $f_count);
			$this->db->bind(':post_user_id', $res->post_user_id);
			$this->db->execute();
		}
	}
	public function liked($post_id){
		$this->db->query("SELECT like_id FROM likes WHERE post_id = :post_id AND user_id = :current_user_id AND likes = 1");
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
	public function likes_vs_friends(){
		$this->db->query("SELECT post_user_id,post_id,post_rating,post_likes_count FROM posts");
		$result = $this->db->resultSet();
		foreach($result as $post){
			$this->db->query("SELECT friendship_id FROM friends WHERE user_id = :user_id");
			$this->db->bind(":user_id", $post->post_user_id);
			$this->db->execute();
			$count_friends = $this->db->rowCount();
			$count_post_likes = $post->post_likes_count;
			if($count_post_likes > $count_friends){
				$this->db->query("UPDATE posts SET post_rating = 1 WHERE post_id = :post_id");
				$this->db->bind(':post_id', $post->post_id);
				$this->db->execute();
			}elseif($count_post_likes <= $count_friends){
				$this->db->query("UPDATE posts SET post_rating = 0 WHERE post_id = :post_id");
				$this->db->bind(':post_id', $post->post_id);
				$this->db->execute();
			}
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