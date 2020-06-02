<?php
class Pages extends Controller{
	public function __construct(){
		$this->userController = $this->controller('Users');
		$this->postController = $this->controller('Posts');
		$this->categoryController = $this->controller('Categories');
		$this->likesController = $this->controller('Likes');
		$this->relatesController = $this->controller('Relates');
		$this->dislikesController = $this->controller('Dislikes');
		$this->groupsController = $this->controller('Groups');
		$this->postModel = $this->model('Post');
	}
	public function showmydiaries(){
		$user = new Users();
		$data = [
			'show_diary' => $this->postModel->showMyDiaries(),
			'logged_in_user' => $user->getUserInfo()
		];
		$this->view('posts/showmydiaries', $data);
	}
	public function showmyparticipations(){
		$user = new Users();
		$data = [
			'show_my_participations' => $this->postModel->showMyParticipations(),
			'logged_in_user' => $user->getUserInfo()
		];
		$this->view('posts/showmyparticipations', $data);
	}
	public function index($myposts_page = 1,$myfriends_posts_page = 1,$display = ''){
		$per_myposts_page = 5;
		$per_myfriends_posts_page = 12345678;
		if($display === 'search'){
			$myfriends_posts = $this->postModel->displayMyFriendsPosts($per_myfriends_posts_page,$myfriends_posts_page);
			$myposts = $this->postModel->displayMyPostsSearch($per_myposts_page,$myposts_page);
		}elseif($display === 'mysearch'){
			$myfriends_posts = $this->postModel->displayMyFriendsPostsSearch($per_myfriends_posts_page,$myfriends_posts_page);
			$myposts = $this->postModel->displayMyPosts($per_myposts_page,$myposts_page);
		}else{
			$myfriends_posts = $this->postModel->displayMyFriendsPosts($per_myfriends_posts_page,$myfriends_posts_page);
			$myposts = $this->postModel->displayMyPosts($per_myposts_page,$myposts_page);
		}
		if($display === 'search'){
			$count_myfriends_posts = $this->postModel->countMyFriendsposts();
			$count_myposts = $this->postModel->countMypostsSearch();
		}elseif($display === 'mysearch'){
			$count_myfriends_posts = $this->postModel->countMyFriendspostsSearch();
			$count_myposts = $this->postModel->countMyposts();
		}else{
			$count_myposts = $this->postModel->countMyposts();
			$count_myfriends_posts = $this->postModel->countMyFriendsposts();
		}
		$user = new Users();
		$category = new Categories();
		$data = [
			'title' => 'Home page',
			'logged_in_user' => $user->getUserInfo(),
			'myposts' => $myposts,
			'count_myposts' => $count_myposts,
			'myposts_page' => $myposts_page,
			'myfriends_posts' => $myfriends_posts,
			'count_myfriends_posts' => $count_myfriends_posts,
			'myfriends_posts_page' => $myfriends_posts_page,
			'display' => $display,
			'per_myposts_page' => $per_myposts_page,
			'per_myfriends_posts_page' => $per_myfriends_posts_page,
			'myfriends_posts_page' => $myfriends_posts_page,
			'cat_info' => $category->selectCategories(),
		];
		$this->view('pages/index', $data);
	}
	public function about(){
		$data = ['title' => 'About page'];
		$this->view('pages/about', $data);
	}
	public function mainpage(){
		$data = ['title' => 'About page'];
		$this->view('pages/mainpage', $data);
	}
	public function diaries(){
		$data = ['title' => 'About page'];
		$this->view('pages/diaries', $data);
	}
}
?>