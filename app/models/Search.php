<?php
class Search{
	public function __construct(){
		$this->db = new Database;
	}
	public function insertSearchData(){
		if(isset($_POST['search_friends'])){
			$this->db->query("INSERT INTO searchs(search_user_id,search_category,search_content) VALUES (:current_user_id,:search_category,:search_content)");
			$search_friends = 'search_friends';
			$search_content = $_POST['search_content'];
			$current_user_id = $_SESSION['user_id'];
			$this->db->bind(':current_user_id', $current_user_id);
			$this->db->bind(':search_category', $search_friends);
			$this->db->bind(':search_content', $search_content);
			$this->db->execute();
		}
	}
	public function insertSearchDataMyFriends(){
		if(isset($_POST['search_myfriends'])){
			$search_myfriends = 'search_myfriends';
			$search_content = $_POST['search_content_myfriends'];
			$current_user_id = $_SESSION['user_id'];
			$this->db->query("INSERT INTO searchs(search_user_id,search_category,search_content) VALUES (:current_user_id,:search_category,:search_content)");
			$this->db->bind(':current_user_id', $current_user_id);
			$this->db->bind(':search_category', $search_myfriends);
			$this->db->bind(':search_content', $search_content);
			$this->db->execute();
		}
	}
	public function lastUserSearchs(){
		$this->db->query("SELECT search_content FROM searchs WHERE search_user_id = :current_user_id ORDER BY search_id DESC LIMIT 5");
		$current_user_id = $_SESSION['user_id'];
		$this->db->bind(':current_user_id', $current_user_id);
		return $this->db->resultSet();
	}
	public function insertSearchDataMyPosts(){
		if(isset($_POST['search_myposts'])){
			$search_myfriends = 'search_myposts';
			$search_content = $_POST['search_content_myposts'];
			$current_user_id = $_SESSION['user_id'];
			$this->db->query("INSERT INTO searchs(search_user_id,search_category,search_content) VALUES (:current_user_id,:search_category,:search_content)");
			$this->db->bind(':current_user_id', $current_user_id);
			$this->db->bind(':search_category', $search_myfriends);
			$this->db->bind(':search_content', $search_content);
			$this->db->execute();
		}
	}
	public function insertSearchDataMyFriendsPosts(){
		if(isset($_POST['search_myfriends_posts'])){
			$search_myfriends = 'search_myfriends_posts';
			$search_content = $_POST['search_content_myfriends_posts'];
			$current_user_id = $_SESSION['user_id'];
			$this->db->query("INSERT INTO searchs(search_user_id,search_category,search_content) VALUES (:current_user_id,:search_category,:search_content)");
			$this->db->bind(':current_user_id', $current_user_id);
			$this->db->bind(':search_category', $search_myfriends);
			$this->db->bind(':search_content', $search_content);
			$this->db->execute();
		}
	}
}