<?php
class Relate extends Controller {
	public function __construct(){
		$this->db = new Database;
	}
	public function relatePost($post_id){
		$this->db->query("SELECT post_user_id FROM posts WHERE post_id = :post_id");
		$this->db->bind(':post_id', $post_id);
		$res = $this->db->single();
		$this->db->query("SELECT relates_count FROM users WHERE user_id = :post_user_id");
		$this->db->bind(':post_user_id', $res->post_user_id);
		$resu = $this->db->single();
		$this->db->query("SELECT relate_id FROM relates WHERE user_id = :current_user_id AND post_id = :post_id AND relates = 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		$this->db->query("SELECT relate_id FROM relates WHERE user_id = :current_user_id AND post_id = :post_id AND relates = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		$count2 = $this->db->rowCount();
		if($count === 1){
			$this->db->query("UPDATE relates SET relates = 0 WHERE user_id = :current_user_id AND post_id = :post_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_relates_count($post_id);
			$f_count = $resu->relates_count - 1;
			$this->db->query("UPDATE users SET relates_count = :relates_count WHERE user_id = :post_user_id");
			$this->db->bind(':relates_count', $f_count);
			$this->db->bind(':post_user_id', $res->post_user_id);
			$this->db->execute();
		}elseif($count2 === 1){
			$this->db->query("UPDATE relates SET relates = 1 WHERE user_id = :current_user_id AND post_id = :post_id");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_relates_count($post_id);
			$f_count = $resu->relates_count + 1;
			$this->db->query("UPDATE users SET relates_count = :relates_count WHERE user_id = :post_user_id");
			$this->db->bind(':relates_count', $f_count);
			$this->db->bind(':post_user_id', $res->post_user_id);
			$this->db->execute();
		}else{
			$this->db->query("INSERT INTO relates(user_id,post_id,relates) VALUES(:current_user_id,:post_id,1)");
			$this->db->bind(':current_user_id', $_SESSION['user_id']);
			$this->db->bind(':post_id', $post_id);
			$this->db->execute();
			$this->update_post_relates_count($post_id);
			$this->db->query("SELECT post_user_id FROM posts WHERE post_id = :post_id");
			$this->db->bind(':post_id', $post_id);
			$f_count = $resu->relates_count + 1;
			$this->db->query("UPDATE users SET relates_count = :relates_count WHERE user_id = :post_user_id");
			$this->db->bind(':relates_count', $f_count);
			$this->db->bind(':post_user_id', $res->post_user_id);
			$this->db->execute();
		}
	}
	public function related($post_id){
		$this->db->query("SELECT relate_id FROM relates WHERE post_id = :post_id AND user_id = :current_user_id AND relates = 1");
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
	public function new_post_relates_count($post_id){
		$this->db->query("SELECT relate_id FROM relates WHERE post_id = :post_id AND relates = 1");
		$this->db->bind(':post_id', $post_id);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function update_post_relates_count($post_id){
		$new_post_relates_count = $this->new_post_relates_count($post_id);
		$this->db->query("UPDATE posts SET post_relates_count = :post_relates_count WHERE post_id = :post_id");
		$this->db->bind(':post_relates_count', $new_post_relates_count);
		$this->db->bind(':post_id', $post_id);
		return $this->db->execute();
	}
}
?>