<?php
class Users extends Controller {
	public function __construct(){
		$this->categoryController = $this->controller('categories');
		$this->postController = $this->controller('posts');
		$this->profilelikesController = $this->controller('Profilelikes');
		$this->profiledislikesController = $this->controller('Profiledislikes');
		$this->usersgalleriesController = $this->controller('Usersgalleries');
		$this->groupsController = $this->controller('Groups');
		$this->chatModel = $this->model('Chat');
		$this->likesController = $this->controller('Likes');
		$this->userModel = $this->model('User');
		$this->searchModel = $this->model('Search');
		$this->db = new Database();
	}
	public function register(){
		// check for POST
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			// Process form
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Init data
			$data = [
				'user_name' => trim($_POST['user_name']),
				'user_name_err' => '',
				'user_first_name' => trim($_POST['user_first_name']),
				'user_first_name_err' => '',
				'user_last_name' => trim($_POST['user_last_name']),
				'user_last_name_err' => '',
				'user_sex' => trim($_POST['user_sex']),
				'user_sex_err' => '',
				'user_email' => trim($_POST['user_email']),
				'user_email_err' => '',
				'user_password' => trim($_POST['user_password']),
				'user_password_err' => '',
				'user_password_confirmation' => trim($_POST['user_password_confirmation']),
				'user_password_confirmation_err' => ''
			];
			// validate data
			if(strlen($data['user_name']) < 4){
				$data['user_name_err'] = 'The username should be greater than 4 characters';
			}elseif(strlen($data['user_name']) > 15){
				$data['user_name_err'] = 'The username should be smaller than 15 characters';
			}elseif(empty($data['user_name'])){
				$data['user_name_err'] = 'Username field can not be empty';
			}elseif($this->userModel->findUserByUserName($data['user_name'])){
				$data['user_name_err'] = 'This user name is already taken';
			}
			if(empty($data['user_email'])){
				$data['user_email_err'] = 'Email field can not be empty';
			}elseif($this->userModel->findUserByEmail($data['user_email'])){
				$data['user_email_err'] = 'This email is already taken';
			}
			if(empty($data['user_password'])){
				$data['user_password_err'] = 'Password field can not be empty';
			}elseif(strlen($data['user_password']) < 5){
				$data['user_password_err'] = 'Password can not be less than 4 characters';
			}
			if(empty($data['user_first_name'])){
				$data['user_first_name_err'] = 'First name field can not be empty';
			}
			if(empty($data['user_last_name'])){
				$data['user_last_name_err'] = 'Last name field can not be empty';
			}
			if(empty($data['user_sex'])){
				$data['user_sex_err'] = 'user sex field can not be empty';
			}
			if($data['user_password_confirmation'] !== $data['user_password']){
				$data['user_password_confirmation_err'] = 'Your password confirmation is wrong';
			}elseif (empty($data['user_password_confirmation'])) {
				$data['user_password_confirmation_err'] = 'Password confirmation field can not be empty';
			}
			if(empty($data['user_name_err']) && empty($data['user_first_name_err']) && empty($data['user_last_name_err']) && empty($data['user_sex_err']) && empty($data['user_email_err']) && empty($data['user_password_err']) && empty($data['user_password_confirmation_err'])){
				// Hash password
				$data['user_password'] = password_hash($data['user_password'], PASSWORD_BCRYPT, array('cost' => 10));
				// Register user
				if($this->userModel->insertUserData($data)){
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\users_images\\" . $data['user_name'] . "_images", 0755);
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\users_images\\" . $data['user_name'] . "_images\pbi_images\\", 0755);
					mkdir (dirname(dirname(dirname(__file__))) . "\public\images\users_images\\" . $data['user_name'] . "_images\profile_images\\", 0755);
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\users_images\\" . $data['user_name'] . "_images\chat_images\\", 0755);
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\posts_images\\" . $data['user_name'] . "_images", 0755);
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\gallery_images\\" . $data['user_name'] . "_images", 0755);
					$this->login();
					redirect('pages/index');
				}else{
					die("something goes wrong");
				}
			}else{
				$this->view('users/register', $data);
			}
		}else{
			// Init data
			$data = [
				'user_name' => '',
				'user_name_err' => '',
				'user_first_name' => '',
				'user_first_name_err' => '',
				'user_last_name' => '',
				'user_last_name_err' => '',
				'user_sex' => '',
				'user_sex_err' => '',
				'user_email' => '',
				'user_email_err' => '',
				'user_password' => '',
				'user_password_err' => '',
				'user_password_confirmation' => '',
				'user_password_confirmation_err' => ''
			];
			$this->view('users/register',$data);
		}
	}
	public function login(){
		// check for POST
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			// Process form
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Init data
			$data = [
				'user_name' => trim($_POST['user_name']),
				'user_name_err' => '',
				'user_password' => trim($_POST['user_password']),
				'user_password_err' => ''
			];
			// validate data
			if(empty($data['user_name'])){
				$data['user_name_err'] = "User name field can not be empty";
			}
			if(empty($data['user_password'])){
				$data['user_password_err'] = "User password field can not be empty";
			}
			if(empty($data['user_name_err']) && empty($data['user_password_err'])){
				// check user name
				if($this->userModel->findUserByUserName($data['user_name'])){
				}else{
					$data['user_name_err'] = "No user found";
				}
				// Check and set logged in users
				$loggedInUser = $this->userModel->login($data['user_password'],$data['user_name']);
				if($loggedInUser){
					// create sessions
					$this->createUserSession($loggedInUser);
				}else{
					$data['user_password_err'] = "Incorrect password";
					$this->view('users/login', $data);
				}
			}else{
				$this->view('users/login', $data);
			}
		}else{
			// Init data
			$data = [
				'user_name' => '',
				'user_name_err' => '',
				'user_password' => '',
				'user_password_err' => ''
			];
			$this->view('users/login',$data);
		}
	}
	public function createUserSession($user){
		$_SESSION['user_id'] = $user->user_id;
		$_SESSION['user_name'] = $user->user_name;
		$_SESSION['user_first_name'] = $user->user_first_name;
		$_SESSION['user_last_name'] = $user->user_last_name;
		$_SESSION['user_email'] = $user->user_email;
		$_SESSION['user_sex'] = $user->user_sex;
		$_SESSION['user_role'] = $user->user_role;
		$_SESSION['photos_gallery_id'] = $user->photos_gallery_id;
		$this->userModel->updateUserLoggedinTime($_SESSION['user_id']);
		redirect('pages/index');
	}
	public function instantLoggedInUserData(){
		    $logged_in_user = $this->userModel->getLoggedInUser();
		    $d = (time() - $logged_in_user->user_logged_in);
		    $dday = floor($d/(24*60*60));
		    $unitday = ' d ';
		    if($dday == 0){
		        $dday = '';
		        $unitday = '';
		    }
		    $dhour = floor(($d-(floor($d/(24*60*60))*24*60*60))/(60*60));
		    $unithour = ' h ';
		    if($dhour == 0){
		        $dhour = '';
		        $unithour = '';
		    }
		    $dmin = floor((($d-(floor($d/(24*60*60))*24*60*60))-(floor(($d-(floor($d/(24*60*60))*24*60*60))/(60*60))*60*60))/60);
		    $unitmin = ' min ';
		    if($dmin == 0){
		        $dmin = '';
		        $unitmin = '';
		    }
		    $dsec = (($d-(floor($d/(24*60*60))*24*60*60))-(floor(($d-(floor($d/(24*60*60))*24*60*60))/(60*60))*60*60))-(60*floor((($d-(floor($d/(24*60*60))*24*60*60))-(floor(($d-(floor($d/(24*60*60))*24*60*60))/(60*60))*60*60))/60));
		    return '<i class="fa fa-sign-in"></i> Logged in for ' . $dday . $unitday . $dhour . $unithour . $dmin . $unitmin . $dsec . ' sec';
	}
	public function getUserInfo(){
		$logged_in_user = $this->userModel->getLoggedInUser();
		return $logged_in_user;
	}
	public function logout(){
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);
		unset($_SESSION['user_first_name']);
		unset($_SESSION['user_last_name']);
		unset($_SESSION['user_email']);
		unset($_SESSION['user_sex']);
		unset($_SESSION['photos_gallery_id']);
		redirect('users/login');
	}
	public $user_id;
	public function search_for_friends($users_page = 1,$myfriends_page = 1,$search = ''){
		$user_id = $this->user_id;
		$this->db->query("SELECT user_id,friend_id FROM friends WHERE (user_id = :current_user_id AND friend_id = :user_id) OR (user_id = :user_id) AND friend_id = :current_user_id");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$already_friends = $this->db->resultSet();
		$count_already_friends = $this->db->rowCount();
        if($count_already_friends == 2){
            $message = "block";
        }else{
            $message = "not friend";
        }
        $this->db->query("SELECT user_id,request_friend_id,friend_id FROM friends WHERE user_id = :current_user_id AND request_friend_id = :user_id AND friend_id = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$request_friendship = $this->db->resultSet();
		$count_request_friendship = $this->db->rowCount();
		if($count_request_friendship == 1){
		$message = "wait for the user to accept your request";
		}
		$this->db->query("SELECT user_id,request_friend_id,friend_id FROM friends WHERE user_id = :user_id AND request_friend_id = :current_user_id AND friend_id = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$request_friendship_reverse = $this->db->resultSet();
		$count_request_friendship_reverse = $this->db->rowCount();
		if($count_request_friendship_reverse == 1){
		$message = "accept";
		}
		$per_users_page = 4;
		$per_myfriends_page = 4;
		if($search === 'search'){
			$myfriends = $this->userModel->getMyFriendsInfo($per_myfriends_page,$myfriends_page);
			$users = $this->userModel->getUsersSearchInfo($per_users_page,$users_page);
		}elseif($search === 'mysearch'){
			$myfriends = $this->userModel->getMyFriendsSearchInfo($per_myfriends_page,$myfriends_page);
			$users = $this->userModel->getUsersInfo($per_users_page,$users_page);
		}else{
			$myfriends = $this->userModel->getMyFriendsInfo($per_myfriends_page,$myfriends_page);
			$users = $this->userModel->getUsersInfo($per_users_page,$users_page);
		}
		if($search === 'search'){
			$count_myfriends = $this->userModel->count_myfriends();
			$count_users = $this->userModel->count_users_search();
		}elseif($search === 'mysearch'){
			$count_myfriends = $this->userModel->count_myfriends_search();
			$count_users = $this->userModel->count_users();
		}else{
			$count_users = $this->userModel->count_users();
			$count_myfriends = $this->userModel->count_myfriends();
		}
		$group = new Groups();
		$data = [
			'logged_in_user' => $this->getUserInfo(),
			'users' => $users,
			'myfriends' => $myfriends,
			'users_page' => $users_page,
			'count_myfriends' => $count_myfriends,
			'myfriends_page' => $myfriends_page,
			'per_users_page' => $per_users_page,
			'per_myfriends_page' => $per_myfriends_page,
			'user_id' => '',
			'count_users' => $count_users,
			'last_searchs' => $this->searchModel->lastUserSearchs(),
			'search' => $search,
		];
		$this->view('users/searchforusers', $data, $message);
		return $message;
	}
	public function userInProfile($user_id){
		$this->db->query("SELECT user_id,friend_id FROM friends WHERE (user_id = :current_user_id AND friend_id = :user_id) OR (user_id = :user_id) AND friend_id = :current_user_id");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$already_friends = $this->db->resultSet();
		$count_already_friends = $this->db->rowCount();
        if($count_already_friends == 2){
            $message = "block";
        }else{
            $message = "not friend";
        }
        $this->db->query("SELECT user_id,request_friend_id,friend_id FROM friends WHERE user_id = :current_user_id AND request_friend_id = :user_id AND friend_id = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$request_friendship = $this->db->resultSet();
		$count_request_friendship = $this->db->rowCount();
		if($count_request_friendship == 1){
		$message = "wait for the user to accept your request";
		}
		$this->db->query("SELECT user_id,request_friend_id,friend_id FROM friends WHERE user_id = :user_id AND request_friend_id = :current_user_id AND friend_id = 0");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':user_id', $user_id);
		$request_friendship_reverse = $this->db->resultSet();
		$count_request_friendship_reverse = $this->db->rowCount();
		if($count_request_friendship_reverse == 1){
		$message = "accept";
		}
		return $message;
	}
	public function accept($user_id){
		$this->userModel->confirm_request($user_id);
	}
	public function deny($user_id){
		$this->userModel->deny_request($user_id);
	}
	public function add($user_id){
		return $this->userModel->add_as_friend($user_id);
	}
	public function block($user_id){
		$this->userModel->block_friend($user_id);
	}
	private $time_out_in_seconds = 40;
	public function online(){
		$timee = time();
		$time_out_in_seconds = $this->time_out_in_seconds;
		$time_out = $timee - $time_out_in_seconds;
		$this->db->query("UPDATE users SET user_access_time = :timee WHERE user_id = :current_user_id");
		$this->db->bind(':timee', $timee);
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->execute();
		$online = 'o';
		$this->db->query("UPDATE users SET user_online = :online WHERE user_access_time > :time_out");
		$this->db->bind(':online', $online);
		$this->db->bind('time_out', $time_out);
		$this->db->execute();
	}
	public function userTime(){
		return $this->userModel->userTime();
	}
	public function offlineUser(){
		$offline = 'f';
		$timee = time();
		$time_out_in_seconds = $this->time_out_in_seconds;
		$time_out = $timee - $time_out_in_seconds;
		$this->db->query("UPDATE users SET user_online = :offline WHERE user_access_time < :time_out");
		$this->db->bind(':offline', $offline);
		$this->db->bind(':time_out', $time_out);
		return $this->db->execute();
	}
	public function getUsersOnlineCount(){
		$count_online_users = $this->userModel->onlineUsers();
		return $count_online_users;
	}
	public function getUsersOfflineCount(){
		$count_offline_users = $this->userModel->offlineUsers();
		return $count_offline_users;
	}
	public function getOnlineFriends(){
		$online_friends = $this->userModel->onlineFriends();
?>
		<div class="row">
		<?php foreach($online_friends as $o_friends): ?>
			<div class="col-2">
		<?php if($o_friends->user_image == "unknown-profile.jpg" || $o_friends->user_image == 'unknown-profile-woman.jpg'):
			$online_user_profile_image = URLROOT . "/images/website_images/" . $o_friends->user_image;
		else:
			$online_user_profile_image = URLROOT . "/images/users_images/" . $o_friends->user_name . "_images/profile_images/" . $o_friends->user_image;
		endif;
		?>
		<?php echo "<a href='" . URLROOT . "/chats/read/{$_SESSION['user_id']}/{$o_friends->friend_id}'><img style='height:40px;width:40px;border-radius:250px;border-style:solid;border-width:2px;border-color:#7aff7a;' src='" . $online_user_profile_image . "'></a>"; ?>
		<?php echo "<img class='pull-right' style='position:relative;bottom:10px;left:10px;height:10px;width:10px;' src='" . URLROOT ."/images/website_images/online-user.png' >"; ?>
		</div>
		<?php endforeach; ?>
		</div>
		<?php if($this->getUsersOnlineCount() == 0){
			echo "<p class='text-muted text-center'>--no available discussions--</p>";
		}
		if($this->getUsersOnlineCount() > 6){ ?>
		<br>
<?php
		}
	}
	public function getOfflineFriends(){
		$offline_friends = $this->userModel->offlineFriends();
?>
		<div class="row">
		<?php foreach($offline_friends as $f_friends): ?>
		<?php if($f_friends->user_image == "unknown-profile.jpg" || $f_friends->user_image == 'unknown-profile-woman.jpg'):
			$offline_user_profile_image = URLROOT . "/images/website_images/" . $f_friends->user_image;
		else:
			$offline_user_profile_image = URLROOT . "/images/users_images/" . $f_friends->user_name . "_images/profile_images/" . $f_friends->user_image;
		endif;
		?>
			<div class="col-2">
			<?php echo "<a href='" . URLROOT . "/chats/read/{$_SESSION['user_id']}/{$f_friends->friend_id}'><img style='height:40px;width:40px;border-radius:250px;border-style:solid;border-width:2px;border-color:#ff7a7a;' src='" . $offline_user_profile_image . "'></a>"; ?>
			<?php echo "<img class='pull-right' style='position:relative;bottom:10px;left:10px;height:10px;width:10px;' src='" . URLROOT ."/images/website_images/offline-user.png' >"; ?>
			</div>
		<?php endforeach; ?>
		</div>
		<?php
		if($this->getUsersOfflineCount() == 0){
			echo "<p class='text-muted text-center'>--All discussions are available--</p>";
		}if($this->getUsersOfflineCount() > 6){ ?>
		<br>
<?php
		}
	}
	public function selectFriendshipRequests(){
		$result = $this->userModel->selectFriendshipRequests();
		return $result;
	}
	public function selectFriendshipRequestsCount(){
		$result = $this->userModel->selectFriendshipRequestsCount();
		return $result;
	}
	public function profile($user_id){
		$post = new Posts();
		$like = new Profilelikes();
		$dislike = new Profiledislikes();
		$data = [
			'liked' => $like->likedprofile($user_id),
			'disliked' => $dislike->dislikedprofile($user_id),
			'count_posts' => $post->count_posts($user_id),
			'count_friends' => $this->userModel->count_friends($user_id),
			'user_info' => $this->userModel->findUserById($user_id),
			'posts_info' => $post->show_posts_by_user_id($user_id)
		];
		$this->view('users/profile', $data);
	}
	public function change_profile_image($profile_id){
		if($profile_id === $_SESSION['user_id']){
			if(isset($_POST['change_profile_image'])){
				if($_FILES['profile_image']['size'] != 0){
					$change = $this->userModel->change_profile_image($profile_id);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					return $change;
				}
				else{
					header('Location: ' . $_SERVER['HTTP_REFERER']);	
				}
			}
		}else{
			flash("not change profile image","you can not edit the profile image of other people","error");
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	public function change_pbi_image($profile_id){
		if($profile_id === $_SESSION['user_id']){
			if(isset($_POST['change_pbi_image'])){
				if($_FILES['pbi_image']['size'] != 0){
					$change = $this->userModel->change_pbi_image($profile_id);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					return $change;
				}
				else{
					header('Location: ' . $_SERVER['HTTP_REFERER']);	
				}
			}
		}else{
			flash("not change pbi image","you can not edit the profile background image of other people","error");
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	public function edit_self_description($profile_id){
		if($profile_id === $_SESSION['user_id']){
			if(isset($_POST['submit_self_description'])){
				if(!empty($_POST['self_description'])){
					$change = $this->userModel->edit_self_description($profile_id);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					return $change;
				}
				else{
					header('Location: ' . $_SERVER['HTTP_REFERER']);	
				}
			}
		}else{
			flash("not change self description","you can not edit the self description field of other people","error");
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	public function findUserById($user_id){
		$user = $this->userModel->findUserById($user_id);
		return $user;
	}
	public function find_user_by_photo_gallery_id($photos_gallery_id){
		$user = $this->userModel->find_user_by_photo_gallery_id($photos_gallery_id);
		return $user;
	}
	public function is_friend($user_id){
		$is_friend = $this->userModel->is_friend($user_id);
		if($is_friend == 1){
			return true;
		}else{
			return false;
		}	
	}
	public function get_friends(){
		$data = $this->userModel->get_friends();
		foreach ($data['friends'] as $friend) {
			$last = $this->chatModel->read_last($_SESSION['user_id'],$friend->user_id);
			?>
			<?php
			if($friend->user_image === "unknown-profile.jpg"){
				$friend_image = URLROOT . "/images/website_images/unknown-profile.jpg";
			}elseif($friend->user_image === "unknown-profile-woman.jpg"){
				$friend_image = URLROOT . "/images/website_images/unknown-profile-woman.jpg";
			}else{
				$friend_image = URLROOT . "/images/users_images/" . $friend->user_name . "_images/profile_images/" . $friend->user_image;
			}
			?>
			<a href="<?php echo URLROOT . "/chats/read/" . $_SESSION['user_id'] . "/" . $friend->user_id; ?>" class="list-group-item list-group-item-action list-group-item-light rounded-0">
              <div class="media">
				<?php if($friend->user_online === 'o'){ ?>
              	<img src="<?php echo $friend_image; ?>" alt="user" width="50" height="50" style="border: 2px solid;border-color:black;border-radius:250px;border-color:#7aff7a;">
              <?php }else{ ?>
				<img src="<?php echo $friend_image; ?>" alt="user" width="50" height="50" style="border: 2px solid;border-color:black;border-radius:250px;border-color:#ff7a7a;">
              <?php } ?>
                <div class="media-body ml-4">
                  <div class="mb-1">
                  	<span>
                    	<h5 class="mb-0 mt-1"><?php echo $friend->user_name; ?></h5>
                	</span>
                	<span class="">
                    <small class="" style="font-weight: 100;">
                    	<?php
        					foreach ($last as $last_message) {
								if($last_message->sender_id == $_SESSION['user_id']){
									if(strlen($last_message->message)>35){
										echo "you : " . substr($last_message->message,0,35) . "...";
									}else{
										echo "you : " . substr($last_message->message,0,35);
										echo manage_urls();
									}
								}else{
									echo $friend->user_name . " : " . $last_message->message;
								}
							}
                    	?>
                    </small>
                    <small class="" style="float: right;">
                    	<?php
        					foreach ($last as $last_message) {
								echo chat_dates2($last_message->creation_time);
							}
                    	?>
                    </small>
                    </span>
                  </div>
                </div>
              </div>
            </a>
			<?php
		}
	}
	public function get_friends_list(){
		$friends = $this->userModel->get_friends();
		return $friends['friends'];
	}
	public function get_friends_count(){
		$count = $this->userModel->get_friends();
		return $count['count'];
	}
	public function change_chat_image($user_id){
		if($user_id = $_SESSION['user_id']){
			$change = $this->userModel->change_chat_image($user_id);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			return $change;
		}
		else{
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
}
?>