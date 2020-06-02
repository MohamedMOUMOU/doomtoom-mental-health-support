<?php
class Groups extends Controller {
	public function __construct(){
		$this->groupModel = $this->model('Group');
		$this->usersController = $this->controller('Users');
		$this->gmController = $this->controller('Groupsmessages');
	}
	public function add(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			// Process form
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($_POST['add_group'])){
			$user = new Users();
			$data = [
				'group_name' => $_POST['group_name'],
				'group_name_err' => '',
				'group_theme' => $_POST['group_theme'],
				'group_theme_err' => '',
				'group_image' => $_FILES['group_image'],
				'group_image_err' => '',
				'group_b_image' => $_FILES['group_b_image'],
				'group_b_image_err' => ''
			];
			// validate data
			$found_group = false;
			$my_groups = $this->groupModel->find_group_by_creator_id($_SESSION['user_id']);
			foreach ($my_groups as $group) {
				if($group->group_name == $data['group_name']){
					$found_group = true;
				}
			}
			if(empty($data['group_name'])){
				$data['group_name_err'] = 'The group name can not be empty';
			}elseif(strlen($data['group_name']) < 4){
				$data['group_name_err'] = 'The group name can not be less than 4 charachters';
			}
			if($found_group){
				$data['group_name_err'] = 'This has already existed';
			}
			if(empty($data['group_name_err']) && empty($data['members_ids_err'])){
				if(!$found_group){
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\groups_images\\" . $_SESSION['user_name'] . "_" . $data['group_name'] . "_images", 0755);
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\groups_images\\" . $_SESSION['user_name'] . "_" . $data['group_name'] . "_images\\group_images", 0755);
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\groups_images\\" . $_SESSION['user_name'] . "_" . $data['group_name'] . "_images\\group_b_images", 0755);
					mkdir(dirname(dirname(dirname(__file__))) . "\public\images\groups_images\\" . $_SESSION['user_name'] . "_" . $data['group_name'] . "_images\\group_files", 0755);
					if($this->groupModel->add($data)){
						flash("group_created","Your group is created successfuly","success");
						$group = $this->groupModel->find_group_by_name_and_creator($data['group_name'],$_SESSION['user_id']);
						$group_id = $group->group_id;
						redirect('groups/readgroups');
					}else{
						die("something goes wrong");
					}
				}
			}else{
				$this->view('groups/add', $data);
			}
		}}else{
			// Init data
			$user = new Users();
			$data = [
				'group_name' => '',
				'group_name_err' => '',
				'group_theme' => '',
				'group_theme_err' => '',
				'group_image' => '',
				'group_image_err' => '',
				'group_b_image' => '',
				'group_b_image_err' => '',
				'friends' => $user->get_friends_list(),
				'count_friends' => $user->get_friends_count(),
			];
			$this->view('groups/add',$data);
		}
	}
	public function read($group_id){
		$user = new Users();
		if($this->verify_member_ship($group_id)[0]){
			$_SESSION['group_id'] = $group_id;
			$groups_messages = new Groupsmessages();
			$data = [
				'messages' => $groups_messages->read_group_messages($group_id),
				'group' => $this->groupModel->find_group_by_id($group_id),
				'logged_in_user' => $user->getUserInfo(),
				'members_ids' => $this->members_of_group($group_id)[0],
				'members_count' => $this->members_of_group($group_id)[1],
				'not_members_ids' => $this->not_members_of_group($group_id)[0],
				'not_members_count' => $this->not_members_of_group($group_id)[1],
				'friends_count' => count($user->get_friends_list()),
			];
			$data['creator'] = $user->findUserById($data['group']->creator_id);
			$_SESSION['group_creator_id'] = $data['group']->creator_id;
			$this->view('groups/read', $data);
		}
	}
	public function get_members(){
		$data = $this->members_of_group($_SESSION['group_id']);
		if($data[1] > 1){
		$user = new Users();
		for ($i=0; $i < $data[1]; $i++) {
			$member = $user->findUserById($data[0][$i]);
			if($member->user_image === "unknown-profile.jpg"){
				$member_image = URLROOT . "/images/website_images/unknown-profile.jpg";
			}elseif($member->user_image === "unknown-profile-woman.jpg"){
				$member_image = URLROOT . "/images/website_images/unknown-profile-woman.jpg";
			}else{
				$member_image = URLROOT . "/images/users_images/" . $member->user_name . "_images/profile_images/" . $member->user_image;
			}
			if($member->user_online === 'o'){
				$o_or_f = '<p style="display: block;margin-top: -10px;color:#7aff7a">online</p>';
			}else{
				$o_or_f = '<p style="display: block;margin-top: -10px;color:#ff7a7a">offline</p>';
			}
			?>
			<div class='row pt-2 ml-1 mr-1 member-<?php echo $member->user_id; ?>' style="border-radius: 10px;margin-bottom: 13px;">
				<div class='col-3'>
					<?php if(!$user->is_friend($member->user_id)): ?>
						<img style='height: 60px;width: 60px;border-radius:50px;' src='<?php echo $member_image; ?>'>
					<?php else: ?>
						<a href="<?php echo URLROOT . "/chats/read/" . $_SESSION['user_id'] . "/" . $member->user_id; ?>"><img style='height: 60px;width: 60px;border-radius:50px;' src='<?php echo $member_image; ?>'></a>
					<?php endif; ?>
				</div>
				<div class="col-9">
					<?php
					if(!$user->is_friend($member->user_id)){
						echo "<p><span class='text-muted'>" . $member->user_name . "<span></p>";
					}else{
						echo "<p><a style='color:black;text-decoration:none;' href='" . URLROOT . "/chats/read/" . $_SESSION['user_id'] . "/" . $member->user_id . "'><span>" . $member->user_name . "<span></a></p>";
					}
					echo $o_or_f;?>
				</div>
			</div>
			<?php if($i != ($data[1]-1)): ?>
				<hr>
			<?php endif; ?>
			<?php
		}
		}else{
			echo "<center class='text-muted mt-5'>-- no members --</center>";
		}
	}
	public function verify_member_ship($group_id){
		$group = $this->groupModel->find_group_by_id($group_id);
		$members_ids = explode(",", $group->members_ids);
		if($_SESSION['user_id'] == $group->creator_id){
			$data= ['is_admin' => true, true];
			return $data;
		}
		foreach ($members_ids as $member_id) {
			if($_SESSION['user_id'] == $member_id){
				$data = ['is_admin' => false, true];
				return $data;
			}
		}
	}
	public function members_of_group($group_id){
		$group = $this->groupModel->find_group_by_id($group_id);
		$members_ids = explode(",", $group->members_ids);
		if($_SESSION['user_id'] == $group->creator_id){
			$members = explode(",", $group->members_ids);
			$count_members = count($members);
		}else{
			$members[0] = $group->creator_id;
			$i = 1;
			foreach ($members_ids as $member_id){
				if($member_id != $_SESSION['user_id']){
					$members[$i] = $member_id;
					$i++;
				}
			}
			$count_members = count($members);
		}
		return $data = [$members, $count_members];
	}
	public function not_members_of_group($group_id){
		$user = new Users();
		$user_friends = $user->get_friends_list();
		$c = 0;
		foreach ($user_friends as $friend) {
			$friends_ids_array[$c] = $friend->user_id;
			$c++;
		}
		$friends_ids = $friends_ids_array;
		$members_ids = $this->members_of_group($group_id)[0];
		$not_members_ids = array_diff($friends_ids, $members_ids);
		die();
		return $data = [array_values($not_members_ids),count($not_members_ids)];
	}
	public function update_g_image($group_id){
		if($_SESSION['user_id'] === $_SESSION['group_creator_id']){
			if(isset($_POST['change_group_image'])){
				if($_FILES['group_image']['size'] != 0){
					$change = $this->groupModel->update_g_image($group_id);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					return $change;
				}
				else{
					header('Location: ' . $_SERVER['HTTP_REFERER']);	
				}
			}
		}
	}
	public function update_g_b_image($group_id){
		if($_SESSION['user_id'] === $_SESSION['group_creator_id']){
				if($_FILES['group_b_image']['size'] != 0){
					$change = $this->groupModel->update_g_b_image($group_id);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					return $change;
				}
				else{
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}
		}
	}
	public function update_group_name($group_id){
		if($_SESSION['user_id'] === $_SESSION['group_creator_id']){
			if(isset($_POST['change_group_name'])){
				$found_group = false;
				$my_groups = $this->groupModel->find_group_by_creator_id($_SESSION['user_id']);
				foreach ($my_groups as $group) {
					if($group->group_name == $_POST['group_name']){
						$found_group = true;
					}
				}
				$my_group = $this->groupModel->find_group_by_id($group_id);
				if(!empty($_POST['group_name']) && !$found_group){
					rename($_SERVER['DOCUMENT_ROOT'] . "/mymvc/public/images/groups_images/" . $_SESSION['user_name'] . "_" . $my_group->group_name . "_images",$_SERVER['DOCUMENT_ROOT'] . "/mymvc/public/images/groups_images/" . $_SESSION['user_name'] . "_" . $_POST['group_name'] . "_images");
					$change = $this->groupModel->update_group_name($group_id);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					return $change;
				}
				else{
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}
			}
		}
	}
	public function delete_members($group_id){
		if(isset($_POST['delete_members'])){
			if($this->verify_member_ship($group_id)['is_admin']){
				$old_group = $this->groupModel->find_group_by_id($group_id);
				$old_group_members = $old_group->members_ids;
				$old_group_members_array = explode(",", $old_group_members);
				$f = 1;
				if(count($old_group_members_array) > 2 && count($_POST['members_ids']) < (count($old_group_members_array) - 1)){
					foreach ($_POST['members_ids'] as $member_id){
						if($f == 1){
							for ($i=0; $i < count($old_group_members_array); $i++) { 
								if($old_group_members_array[$i] !== $member_id){
									${"new_" . $f . "_group_members_array"}[$i] = $old_group_members_array[$i];
								}
							}
						}elseif($f > 1){
							for ($c= 0; $c < count(${"new_" . ($f -1) . "_group_members_array"}); $c++) { 
								if(${"new_" . ($f -1) . "_group_members_array"}[$c] !== $member_id){
									${"new_" . $f . "_group_members_array"}[$c] = ${"new_" . ($f -1) . "_group_members_array"}[$c];
								}
							}
						}
						${"new_" . $f . "_group_members_array"} = array_values(${"new_" . $f . "_group_members_array"});
						$f++;
					}
					$new_member_ids = join("," , ${"new_" . ($f-1) . "_group_members_array"});
					$delete = $this->groupModel->update_members($new_member_ids,$group_id);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					return $delete;
				}else{
					echo "bola";
				}
			}
		}
	}
	public function add_members($group_id){
		if(isset($_POST['add_members'])){
			if($this->verify_member_ship($group_id)['is_admin']){
				$old_group = $this->groupModel->find_group_by_id($group_id);
				$old_group_members = $old_group->members_ids;
				$old_group_members_array = explode(",", $old_group_members);
				$f = 1;
				foreach ($_POST['not_members_ids'] as $not_member_id) {
					$old_group_members_array[(count($old_group_members_array) + $f)] = $not_member_id;
					$f++;
				}
				$new_group_members = join(",", $old_group_members_array);
				$add = $this->groupModel->update_members($new_group_members, $group_id);
				header('Location: ' . $_SERVER['HTTP_REFERER']);
				return $add;
			}
		}
	}
	public function my_groups(){
		$groups = $this->groupModel->get_all_groups();
		$i = 0;
		foreach ($groups as $group) {
			if($this->verify_member_ship($group->group_id)[0]){
				$groups_ids[$i] = $group->group_id;
			}
			$i++;
		}
		if(isset($groups_ids) && count($groups_ids) >= 1){
			$groups_ids = array_values($groups_ids);
		}elseif(!isset($groups_ids)){
			$groups_ids = [];
		}
		return $groups_ids;
	}
	public function find_group_by_id($group_id){
		$group = $this->groupModel->find_group_by_id($group_id);
		return $group;
	}
	public function readgroups(){
		$user = new Users();
		$data = [
			'logged_in_user' => $user->getUserInfo(),
			'readgroups' => $this->groupModel->readgroups()
		];
		$this->view('groups/readgroups', $data);
	}
	public function joingroup($group_id){
		$_SESSION['group_id'] = $group_id;
		$gm = new Groupsmessages();
		$joingroup = $this->groupModel->joingroup($group_id);
		$data = [
			'group' => $this->groupModel->find_group_by_id($group_id),
			'messages' => $gm->read_group_messages($group_id)
		];
		$this->view('/groups/read', $data);
	}
}
?>