<?php
class User{
	public function __construct(){
		$this->db = new Database;
	}
	// Find user by user name
	public function findUserByUserName($user_name){
		$this->db->query("SELECT * FROM users WHERE user_name = :user_name");
		$this->db->bind(':user_name', $user_name);
		$row = $this->db->single();
		if($this->db->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
		// Find user by user email
	public function findUserByEmail($user_email){
		$this->db->query("SELECT * FROM users WHERE user_email = :user_email");
		$this->db->bind(':user_email', $user_email);
		$row = $this->db->single();
		if($this->db->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function findUserById($user_id){
		$this->db->query("SELECT * FROM users WHERE user_id = :user_id");
		$this->db->bind(':user_id', $user_id);
		$row = $this->db->single();
		return $row;
	}
	public function insertUserData($data){
		$this->db->query('INSERT INTO users(user_name,user_first_name,user_last_name,user_email,user_password,user_sex,user_role,user_image,user_pbi) VALUES(:user_name,:user_first_name,:user_last_name,:user_email,:user_password,:user_sex,:subscriber,:user_image,:user_pbi)');
		if($data['user_sex'] == "male"){
			$user_image = "unknown-profile.jpg";
		}elseif($data['user_sex'] == "female"){
			$user_image = "unknown-profile-woman.jpg";
		}
		$user_pbi = "default-pbi.png";
		$subscriber = "subscriber";
		$this->db->bind(':user_name', $data['user_name']);
		$this->db->bind(':user_first_name', $data['user_first_name']);
		$this->db->bind(':user_last_name', $data['user_last_name']);
		$this->db->bind(':user_email', $data['user_email']);
		$this->db->bind(':user_password', $data['user_password']);
		$this->db->bind(':subscriber', $subscriber);
		$this->db->bind(':user_sex', $data['user_sex']);
		$this->db->bind(':user_image', $user_image);
		$this->db->bind(':user_pbi', $user_pbi);
/*		$users = $this->db->execute();*/
		if($this->db->execute()){
			$this->db->query("SELECT user_id FROM users WHERE user_name = :user_name");
			$this->db->bind(':user_name', $data['user_name']);
			$this->db->execute();
			$user = $this->db->single();
			$gallery_user_id = $user->user_id;
			$this->db->query("INSERT INTO photos_galleries(gallery_user_id) VALUES(:gallery_user_id)");
			$this->db->bind(':gallery_user_id', $gallery_user_id);
			$this->db->execute();
			$this->db->query("SELECT gallery_id FROM photos_galleries WHERE gallery_user_id = :gallery_user_id");
			$this->db->bind(':gallery_user_id', $gallery_user_id);
			$this->db->execute();
			$gallery = $this->db->single();
			$photos_gallery_id = $gallery->gallery_id;
			$this->db->query("UPDATE users SET photos_gallery_id = :photos_gallery_id WHERE user_id = :user_id");
			$this->db->bind(':photos_gallery_id', $photos_gallery_id);
			$this->db->bind(':user_id', $gallery_user_id);
			$this->db->execute();
			return true;
		}else{
			return false;
		}
	}
	public function login($user_password,$user_name){
		$this->db->query("SELECT * FROM users WHERE user_name = :user_name");
		$this->db->bind(':user_name', $user_name);
		$user = $this->db->single();
		if(password_verify($user_password, $user->user_password)){
			return $user;
		}else{
			return false;
		}
	}
	public function updateUserLoggedinTime($user_id){
		$this->db->query("UPDATE users SET user_logged_in = :now WHERE user_id = :user_id");
		$now = time();
		$this->db->bind(':now', $now);
		$this->db->bind(':user_id', $user_id);
		$this->db->execute();
	}
	public function getLoggedInUser(){
		$this->db->query("SELECT * FROM users WHERE user_id = :user_id");
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$user = $this->db->single();
		return $user;
	}
	public function getUsersInfo($per_users_page,$users_page){
		if(isset($users_page)){
			$users_page = $users_page;
		}else{
			$users_page = 1;
		}
		if($users_page == "" || $users_page == 1){
			$users_page_1 = 0;
		}else{
			$users_page_1 = ($users_page * $per_users_page)-$per_users_page;
		}
		$this->db->query("SELECT user_id,user_image,user_name FROM users WHERE user_id != :user_id ORDER BY user_id DESC LIMIT :users_page_1,:per_users_page");
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->bind(':users_page_1', $users_page_1);
		$this->db->bind(':per_users_page', $per_users_page);
		$users = $this->db->resultSet();
		return $users;
	}
	public function count_users(){
		$this->db->query("SELECT user_id FROM users WHERE user_id != :current_user_id");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->execute();
		$count_users = $this->db->rowCount();
		return $count_users;
	}
	public function getMyFriendsInfo($per_myfriends_page,$myfriends_page){
		if(isset($myfriends_page)){
			$myfriends_page = $myfriends_page;
		}else{
			$myfriends_page = 1;
		}
		if($myfriends_page == "" || $myfriends_page == 1){
			$myfriends_page_1 = 0;
		}else{
			$myfriends_page_1 = ($myfriends_page * $per_myfriends_page)-$per_myfriends_page;
		}
		$this->db->query("SELECT users.user_id,users.user_image,users.user_name,friends.user_id,friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :current_user_id ORDER BY friends.friend_id DESC LIMIT :myfriends_page_1,:per_myfriends_page");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':myfriends_page_1', $myfriends_page_1);
		$this->db->bind(':per_myfriends_page', $per_myfriends_page);
		$myfriends = $this->db->resultSet();
		return $myfriends;
	}
	public function count_myfriends(){
		$this->db->query("SELECT users.user_id,users.user_image,users.user_name,friends.user_id,friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :current_user_id");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->execute();
		$count_myfriends = $this->db->rowCount();
		return $count_myfriends;
	}
	private function lastSearchFriends(){
		$this->db->query("SELECT search_content FROM searchs WHERE search_user_id = :current_user_id AND search_category = :search_friends ORDER BY search_id DESC LIMIT 1");
		$search_friends = 'search_friends';
		$this->db->bind(':search_friends', $search_friends);
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$search = $this->db->single();
		return '%' . $search->search_content . '%';
	}
	public function getUsersSearchInfo($per_users_page,$users_page){
		if(isset($users_page)){
			$users_page = $users_page;
		}else{
			$users_page = 1;
		}
		if($users_page == "" || $users_page == 1){
			$users_page_1 = 0;
		}else{
			$users_page_1 = ($users_page * $per_users_page)-$per_users_page;
		}
		$search_content = $this->lastSearchFriends();
		$this->db->query("SELECT user_id,user_image,user_name FROM users WHERE user_id != :current_user_id AND user_name LIKE :search_content ORDER BY user_id DESC LIMIT :users_page_1,:per_users_page");
		$this->db->bind(':search_content', $search_content);
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':per_users_page',$per_users_page);
		$this->db->bind(':users_page_1', $users_page_1);
		$users = $this->db->resultSet();
		return $users;
	}
	public function count_users_search(){
		$search_content = $this->lastSearchFriends();
		$this->db->query("SELECT user_id,user_image,user_name FROM users WHERE user_id != :current_user_id AND user_name LIKE :search_content");
		$this->db->bind(':search_content', $search_content);
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->execute();
		$count_users = $this->db->rowCount();
		return $count_users;
	}
	private function lastSearchMyFriends(){
		$this->db->query("SELECT search_content FROM searchs WHERE search_user_id = :current_user_id AND search_category = :search_myfriends ORDER BY search_id DESC LIMIT 1");
		$search_myfriends = 'search_myfriends';
		$this->db->bind(':search_myfriends', $search_myfriends);
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$search = $this->db->single();
		return '%' . $search->search_content . '%';
	}
	public function getMyFriendsSearchInfo($per_myfriends_page,$myfriends_page){
		if(isset($myfriends_page)){
			$myfriends_page = $myfriends_page;
		}else{
			$myfriends_page = 1;
		}
		if($myfriends_page == "" || $myfriends_page == 1){
			$myfriends_page_1 = 0;
		}else{
			$myfriends_page_1 = ($myfriends_page * $per_myfriends_page)-$per_myfriends_page;
		}
		$search_content = $this->lastSearchMyFriends();
		$this->db->query("SELECT users.user_id,users.user_name,users.user_image,users.user_name,friends.user_id,friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND users.user_name LIKE :search_content ORDER BY friends.friend_id DESC LIMIT :myfriends_page_1,:per_myfriends_page");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':search_content', $search_content);
		$this->db->bind(':myfriends_page_1', $myfriends_page_1);
		$this->db->bind(':per_myfriends_page',$per_myfriends_page);
		$myfriends = $this->db->resultSet();
		return $myfriends;
	}
	public function count_myfriends_search(){
		$search_content = $this->lastSearchMyFriends();
		$current_user_id = $_SESSION['user_id'];
		$this->db->query("SELECT users.user_id,users.user_name,users.user_image,users.user_name,friends.user_id,friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND users.user_name LIKE :search_content");
		$this->db->bind(':current_user_id', $current_user_id);
		$this->db->bind(':search_content', $search_content);
		$this->db->execute();
		$count_myfriends = $this->db->rowCount();
		return $count_myfriends;
	}
	public function onlineUsers(){
		$online = 'o';
		$this->db->query("SELECT users.user_id, users.user_name, users.user_online,friends.user_id, friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND users.user_online = :online ORDER BY users.user_id");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':online', $online);
		$this->db->execute();
		$count_online_users = $this->db->rowCount();
		return $count_online_users;
	}
	public function offlineUsers(){
		$offline = 'f';
		$this->db->query("SELECT users.user_id, users.user_name, users.user_online,friends.user_id, friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND users.user_online = :offline ORDER BY users.user_id");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':offline', $offline);
		$this->db->execute();
		$count_offline_users = $this->db->rowCount();
		return $count_offline_users;
	}
	public function onlineFriends(){
		$online = 'o';
		$this->db->query("SELECT users.user_id, users.user_name, users.user_image, users.user_online,friends.user_id, friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND users.user_online = :online ORDER BY user_time DESC LIMIT 6");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':online', $online);
		return $this->db->resultSet();
	}
	public function offlineFriends(){
		$offline = 'f';
		$this->db->query("SELECT users.user_id, users.user_name, users.user_image, users.user_online,friends.user_id, friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND users.user_online = :offline ORDER BY user_time DESC LIMIT 6");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':offline', $offline);
		return $this->db->resultSet();
	}
	public function userTime(){
		$user_time = time();
		$this->db->query("UPDATE users SET user_time = :user_time WHERE user_id = :current_user_id");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_time', $user_time);
		return $this->db->execute();
	}
	public function selectFriendshipRequests(){
		$this->db->query("SELECT users.user_id,users.user_name,users.user_image,friends.user_id,friends.request_friend_id,friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.request_friend_id = :current_user_id AND friends.user_id = 0 ORDER BY friends.time_of_request DESC LIMIT 3");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$friendship_requests = $this->db->resultSet();
		return $friendship_requests;
	}
	public function selectFriendshipRequestsCount(){
		$this->db->query("SELECT users.user_id,users.user_name,users.user_image,friends.user_id,friends.request_friend_id,friends.friend_id FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.request_friend_id = :current_user_id AND friends.user_id = 0 ORDER BY friends.time_of_request DESC LIMIT 3");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->execute();
		$friendship_requests_count = $this->db->rowCount();
		return $friendship_requests_count;
	}
	public function deny_request($user_id){
		$true = "true";
		$this->db->query("DELETE FROM friends WHERE (user_id = :user_id AND request_friend_id = :current_user_id) OR (friend_id = :user_id AND request_friend_id = :current_user_id)");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':true', $true);
		$this->db->execute();
		redirect('users/search_for_friends');
	}
	public function confirm_request($user_id){
		$true = "true";
		$this->db->query("INSERT INTO friends(friend_id,request_friend_id,time_of_request,validated,user_id) VALUES(:current_user_id,:user_id,:time_of_request,:true,:user_id)");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':true', $true);
		$this->db->bind(':time_of_request', time());
		$this->db->execute();
		$this->db->query("INSERT INTO friends(friend_id,request_friend_id,time_of_request,validated,user_id) VALUES(:user_id,:user_id,:time_of_request,:true,:current_user_id)");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':true', $true);
		$this->db->bind(':time_of_request', time());
		$this->db->execute();
		redirect('chats/read/' . $_SESSION['user_id'] . "/" . $user_id);
		die();
	}
	public function block_friend($user_id){
		$this->db->query("DELETE FROM friends WHERE (user_id = :user_id AND friend_id = :current_user_id) OR (user_id = :current_user_id AND friend_id = :user_id)");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$this->db->execute();
		redirect('users/search_for_friends');
	}
	public function change_profile_image($profile_id){
		$num = rand(0,999999999999);
		$profile_image = $_SESSION['user_name'] . $_SESSION['user_role'] . $num . $_FILES['profile_image']['name'];
		$profile_image_temp = $_FILES['profile_image']['tmp_name'];
		move_uploaded_file($profile_image_temp,$_SERVER['DOCUMENT_ROOT'] . "/mymvc/public/images/users_images/" . $_SESSION['user_name'] . "_images/profile_images/" . $profile_image);
		$user_gallery = new Usersgalleries();
		$user_gallery->add($profile_image,$_SESSION['user_id'],'profile_images');
		$this->db->query("UPDATE users SET user_image = :new_profile_image WHERE user_id = :profile_id");
		$this->db->bind(':new_profile_image', $profile_image);
		$this->db->bind('profile_id', $profile_id);
		return $this->db->execute();
	}
	public function change_pbi_image($profile_id){
		$num = rand(0,999999999999);
		$pbi_image = $_SESSION['user_name'] . $_SESSION['user_role'] . $num . $_FILES['pbi_image']['name'];
		$pbi_image_temp = $_FILES['pbi_image']['tmp_name'];
		move_uploaded_file($pbi_image_temp,$_SERVER['DOCUMENT_ROOT'] . "/mymvc/public/images/users_images/" . $_SESSION['user_name'] . "_images/pbi_images/" . $pbi_image);
		$user_gallery = new Usersgalleries();
		$user_gallery->add($pbi_image,$_SESSION['user_id'],'pbi_images');
		$this->db->query("UPDATE users SET user_pbi = :new_pbi_image WHERE user_id = :profile_id");
		$this->db->bind(':new_pbi_image', $pbi_image);
		$this->db->bind('profile_id', $profile_id);
		return $this->db->execute();
	}
	public function edit_self_description($profile_id){
		$this->db->query("UPDATE users SET user_self_description = :new_self_description WHERE user_id = :profile_id");
		$this->db->bind(':new_self_description', $_POST['self_description']);
		$this->db->bind('profile_id', $profile_id);
		return $this->db->execute();
	}
	public function count_friends($user_id){
		$this->db->query("SELECT user_id FROM friends WHERE user_id = :user_id AND validated = 'true'");
		$this->db->bind(':user_id', $user_id);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function find_user_by_photo_gallery_id($photos_gallery_id){
		$this->db->query("SELECT user_name,user_id,user_image FROM users WHERE photos_gallery_id = :photos_gallery_id");
		$this->db->bind(':photos_gallery_id',$photos_gallery_id);
		$user = $this->db->single();
		return $user;
	}
	public function is_friend($user_id){
		$this->db->query("SELECT user_id FROM friends WHERE user_id = :user_id AND friend_id = :friend_id AND validated = 'true'");
		$this->db->bind(':user_id', $user_id);
		$this->db->bind('friend_id', $_SESSION['user_id']);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function get_friends(){
		$this->db->query("SELECT users.user_name,users.user_image,users.user_id,users.user_online FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :user_id");
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$friends = $this->db->resultSet();
		$this->db->query("SELECT users.user_name,users.user_image,users.user_id,users.user_online FROM users LEFT JOIN friends ON users.user_id = friends.friend_id WHERE friends.user_id = :user_id");
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->execute();
		$count = $this->db->rowCount();
		$data = ['friends' => $friends, 'count' => $count];
		return $data;
	}
	public function change_chat_image($user_id){
		$num = rand(0,999999999999);
		$chat_image = $_SESSION['user_name'] . $num . $_FILES['chat_image']['name'];
		$chat_image_temp = $_FILES['chat_image']['tmp_name'];
		move_uploaded_file($chat_image_temp,$_SERVER['DOCUMENT_ROOT'] . "/mymvc/public/images/users_images/" . $_SESSION['user_name'] . "_images/chat_images/" . $chat_image);
		$this->db->query("UPDATE users SET chat_image = :chat_image WHERE user_id = :user_id");
		$this->db->bind(':chat_image', $chat_image);
		$this->db->bind('user_id', $user_id);
		return $this->db->execute();
	}
}
?>