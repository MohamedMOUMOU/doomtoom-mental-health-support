<?php
class Posts extends Controller {
	public function __construct(){
		$this->postModel = $this->model('Post');
		$this->userController = $this->controller('Users');
		$this->categoryController = $this->controller('Categories');
		$this->groupController = $this->controller('Groups');
		$this->postsgalleriesController = $this->controller('Postsgalleries');
	}
	public function add(){
		// check for POST
		$category = new Categories;
		$cat_info = $category->selectCategories();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			// Process form
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($_POST['add_post'])){
			// Init data
			$data = [
				'post_title' => $_POST['post_title'],
				'post_title_err' => '',
				'post_content' => $_POST['post_content'],
				'post_content_err' => '',
				'post_category_id' => $_POST['post_category_id'],
				'post_category_id_err' => '',
				'post_status' => $_POST['post_status'],
				'post_status_err' => '',
				'post_request_help' => $_POST['post_request_help'],
				'post_request_help_err' => '',
				'cat_info' => $cat_info,
			];
			// validate data
			if(empty($data['post_title'])){
				$data['post_title_err'] = 'The post title can not be empty';
			}
			if(empty($data['post_status'])){
				$data['post_status_err'] = 'The post status can not be empty';
			}
			if(empty($data['post_category_id'])){
				$data['post_category_id_err'] = 'The post category_id can not be empty';
			}
			if(!empty($_POST['post_title']) && empty($_POST['post_content'])){
				$data['post_content_err'] = 'You need to have some content';
			}
			if(empty($data['post_title_err']) && empty($data['post_content_err'])){
				if($this->postModel->insertPostData($data)){
					flash("post_created","Your post is created successfuly","success");
					redirect('pages/showmyparticipations');
				}else{
					die("something goes wrong");
				}
			}else{
				$this->view('posts/add', $data);
			}
		}}else{
			// Init data
			$data = [
				'post_title' => '',
				'post_title_err' => '',
				'post_content' => '',
				'post_content_err' => '',
				'post_category_id' => '',
				'post_category_id_err' => '',
				'cat_info' => $cat_info,
			];
			$this->view('posts/add',$data);
		}
	}
	public function adiary(){
		// check for POST
		$category = new Categories;
		$cat_info = $category->selectCategories();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			// Process form
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($_POST['add_post'])){
			// Init data
			$data = [
				'post_title' => $_POST['post_title'],
				'post_title_err' => '',
				'post_content' => $_POST['post_content'],
				'post_content_err' => '',
				'diary_lesson_learnt' => $_POST['diary_lesson_learnt'],
				'diary_lesson_learnt_err' => '',
				'post_status' => $_POST['post_status'],
				'post_status_err' => '',
				'post_request_help' => $_POST['post_request_help'],
				'post_request_help_err' => '',
				'cat_info' => $cat_info,
			];
			// validate data
			if(empty($data['post_title'])){
				$data['post_title_err'] = 'The post title can not be empty';
			}
			if(empty($data['post_status'])){
				$data['post_status_err'] = 'The post status can not be empty';
			}
			if(empty($data['post_title_err']) && empty($data['post_content_err'])){
				$this->postModel->insertDiaryData($data);
					redirect('pages/showmydiaries');
			}else{
				$this->view('posts/addiary', $data);
			}
		}}else{
			// Init data
			$data = [
				'post_title' => '',
				'post_title_err' => '',
				'post_content' => '',
				'post_content_err' => '',
				'diary_lesson_learnt' => '',
				'diary_lesson_learnt_err' => '',
				'cat_info' => $cat_info,
			];
			$this->view('posts/adiary',$data);
		}
	}
	public function edit($post_id){
		// check for POST
		$category = new Categories;
		$post = $this->postModel->findPostById($post_id);
		if($post->post_user_id == $_SESSION['user_id']){
			$cat_title = $category->findCategoryById($post->post_category_id);
			$post_cat_title = $cat_title->cat_title;
			$cat_info = $category->selectCategories();
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Process form
				// Sanitize POST data
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			if(isset($_POST['edit_post'])){
				// Init data
				$data = [
					'post_id' => $post_id,
					'post_title' => $_POST['post_title'],
					'post_title_err' => '',
					'post_content' => $_POST['post_content'],
					'post_content_err' => '',
					'post_category_title' => $post_cat_title,
					'post_category_id' => $_POST['post_category_id'],
					'post_category_id_err' => '',
					'post_image' => $_FILES['post_image'],
					'post_image_err' => '',
					'post_status' => $_POST['post_status'],
					'post_status_err' => '',
					'cat_info' => $cat_info,
				];
				// validate data
				if(empty($data['post_title'])){
					$data['post_title_err'] = 'The post title can not be empty';
				}
				if(empty($data['post_status'])){
					$data['post_status_err'] = 'The post status can not be empty';
				}
				if(empty($data['post_category_id'])){
					$data['post_category_id_err'] = 'The post category_id can not be empty';
				}
				if(!empty($_POST['post_title']) && empty($post->post_image) && empty($_POST['post_content'])){
					$data['post_image_err'] = 'You need to have some content';
					$data['post_content_err'] = 'You need to have some content';
				}
				if(empty($data['post_title_err']) && empty($data['post_image_err']) && empty($data['post_content_err'])){
					if($this->postModel->updatePostData($data,$post_id)){
						flash("post_updated","Your post has been updated successfuly","success");
						redirect('pages/index');
					}else{
						die("something goes wrong");
					}
				}else{
					$this->view('posts/edit', $data);
				}
			}}else{
				// Init data
				$data = [
					'post_id' => $post->post_id,
					'post_title' => $post->post_title,
					'post_title_err' => '',
					'post_content' => $post->post_content,
					'post_content_err' => '',
					'post_category_title' => $post_cat_title,
					'post_category_id' => $post->post_category_id,
					'post_category_id_err' => '',
					'post_image' => $post->post_image,
					'post_image_err' => '',
					'cat_info' => $cat_info,
					'post_status' => $post->post_status,
					'post_status_err' => '',
				];
				$this->view('posts/edit',$data);
			}
		}else{
			flash("post_not_updated","editing other people posts is forbidden","error");
			redirect('pages/showmyparticipations');
		}
	}
	public function show($post_id){
		$user = new Users();
		$data = [
			'logged_in_user' => $user->getUserInfo(),
			'show_post' => $this->postModel->selectPostById($post_id),
		];
		$this->view('posts/show', $data);
	}
	public function last_seen_posts(){
		$last_seen_posts = $this->postModel->last_seen_posts();
		return $last_seen_posts;
	}
	public function recently_liked_posts(){
		$recently_liked_posts = $this->postModel->recently_liked_posts();
		return $recently_liked_posts;
	}
	public function post_is_viewed($post_id){
		$post_is_viewed = $this->postModel->post_is_viewed($post_id);
		return $post_is_viewed;
	}
	public function count_posts($post_user_id){
		$count_posts = $this->postModel->count_posts($post_user_id);
		return $count_posts;
	}
	public function show_posts_by_user_id($user_id){
		$show_posts_by_user_id = $this->postModel->show_posts_by_user_id($user_id);
		return $show_posts_by_user_id;
	}
}