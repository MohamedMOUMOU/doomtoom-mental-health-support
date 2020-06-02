<?php
class Post{
	public function __construct(){
		$this->db = new Database;
	}
	public function insertPostData($data){
		$posts_galleries = new Postsgalleries;
		$this->db->query('INSERT INTO posts(post_user_id,post_category_id,post_title,post_author,post_image,post_content,post_status,post_date,post_request_help) VALUES(:post_user_id,:post_category_id,:post_title,:post_author,:post_image,:post_content,:post_status,:post_date,:post_request_help)');
		$post_user_id = $_SESSION['user_id'];
		$post_category_id = $data['post_category_id'];
		$post_title = $data['post_title'];
		$post_author = $_SESSION['user_name'];
		$num = rand(0,999999999999);
		$post_image = $post_author . $_SESSION['user_role'] . $num . $data['post_image']['name'];
		$post_image_temp = $data['post_image']['tmp_name'];
		if($post_image === $post_author . $_SESSION['user_role'] . $num){
			$post_image = "";
		}
		$post_content = $data['post_content'];
		$post_status = $data['post_status'];
		$post_date = date('F j, Y \a\t h:i A');
		$post_request_help = $data['post_request_help'];
		move_uploaded_file($post_image_temp,$_SERVER['DOCUMENT_ROOT'] . "\mymvc\public\images\posts_images\\" . $_SESSION['user_name'] . "_images\\" . $post_image);
		$this->db->bind(':post_user_id', $post_user_id);
		$this->db->bind(':post_category_id', $post_category_id);
		$this->db->bind(':post_title', $post_title);
		$this->db->bind(':post_author', $post_author);
		$this->db->bind(':post_image', $post_image);
		$this->db->bind(':post_content', $post_content);
		$this->db->bind(':post_status', $post_status);
		$this->db->bind(':post_date', $post_date);
		$this->db->bind(':post_request_help', $post_request_help);
		$post = $this->db->execute();
		$this->db->query("SELECT post_id FROM posts WHERE post_image = :post_image");
		$this->db->bind(':post_image', $post_image);
		$this->db->execute();
		$last_post = $this->db->single();
		if(!empty($post_image)){
			if($post_status == "published"):
				$add = $posts_galleries->add($post_image,$last_post->post_id,'published');
			else:
				$add = $posts_galleries->add($post_image,$last_post->post_id,'draft');
			endif;
		}
		if($post){
			return $array = [$post,$post_image];
		}else{
			return false;
		}
	}
	public function insertDiaryData($data){
		$posts_galleries = new Postsgalleries;
		$this->db->query('INSERT INTO posts(post_user_id,post_category_id,post_title,post_author,post_content,post_status,post_date,post_request_help,diary_lesson_learnt) VALUES(:post_user_id,:post_category_id,:post_title,:post_author,:post_content,:post_status,:post_date,:post_request_help,:diary_lesson_learnt)');
		$post_user_id = $_SESSION['user_id'];
		$post_category_id = 15;
		$post_title = $data['post_title'];
		$post_author = $_SESSION['user_name'];
		$post_content = $data['post_content'];
		$post_status = $data['post_status'];
		$post_date = date('F j, Y \a\t h:i A');
		$post_request_help = $data['post_request_help'];
		$diary_lesson_learnt = $data['diary_lesson_learnt'];
		$this->db->bind(':post_user_id', $post_user_id);
		$this->db->bind(':post_category_id', $post_category_id);
		$this->db->bind(':post_title', $post_title);
		$this->db->bind(':post_author', $post_author);
		$this->db->bind(':post_content', $post_content);
		$this->db->bind(':post_status', $post_status);
		$this->db->bind(':post_date', $post_date);
		$this->db->bind(':post_request_help', $post_request_help);
		$this->db->bind(':diary_lesson_learnt', $diary_lesson_learnt);
		$post = $this->db->execute();
	}
	public function updatePostData($data,$post_id){
		$posts_galleries = new Postsgalleries;
		$post_category_id = $data['post_category_id'];
		$post_title = $data['post_title'];
		$post_author = $_SESSION['user_name'];
		if($data['post_image']['size'] == 0){
			$post = $this->findPostById($post_id);
			$post_image = $post->post_image;
		}else{
			$num = rand(0,999999999999);
			$post_image = $post_author . $_SESSION['user_role'] . $num . $data['post_image']['name'];
			$post_image_temp = $data['post_image']['tmp_name'];
			move_uploaded_file($post_image_temp,$_SERVER['DOCUMENT_ROOT'] . "\mymvc\public\images\posts_images\\" . $_SESSION['user_name'] . "_images\\" . $post_image);
			$p_i = $post_image;
			if($post_image === $post_author . $_SESSION['user_role'] . $num){
				$post_image = "";
			}
		}
		$post_content = $data['post_content'];
		$post_status = $data['post_status'];
		$post_date = date('F j, Y \a\t h:i A');
		$this->db->query('UPDATE posts SET post_category_id = :post_category_id,post_title = :post_title, post_author = :post_author,post_image = :post_image,post_content = :post_content,post_status = :post_status,post_date = :post_date WHERE post_id = :post_id');
		$this->db->bind(':post_category_id', $post_category_id);
		$this->db->bind(':post_title', $post_title);
		$this->db->bind(':post_author', $post_author);
		$this->db->bind(':post_image', $post_image);
		$this->db->bind(':post_content', $post_content);
		$this->db->bind(':post_status', $post_status);
		$this->db->bind(':post_date', $post_date);
		$this->db->bind(':post_id', $post_id);
		$post = $this->db->execute();
		if(empty($p_i)){
			if($post_status == 'published'){
				$update = $posts_galleries->update_by_image($post_image,'published');
			}elseif($post_status == 'draft'){
				$update = $posts_galleries->update_by_image($post_image,'draft');
			}
		}
		if(isset($p_i) && !empty($p_i)){
			if($post_status == "published"):
				$add = $posts_galleries->add($post_image,$post_id,'published');
			else:
				$add = $posts_galleries->add($post_image,$post_id,'draft');
			endif;
		}
		if($post){
			return $post;
		}else{
			return false;
		}
	}
	public function displayMyPosts($per_myposts_page,$myposts_page){
		if(isset($myposts_page)){
			$myposts_page = $myposts_page;
		}else{
			$myposts_page = 1;
		}
		if($myposts_page == "" || $myposts_page == 1){
			$myposts_page_1 = 0;
		}else{
			if(is_int($myposts_page) && is_int($per_myposts_page) && is_int($per_myposts_page)){
				$myposts_page_1 = ($myposts_page * $per_myposts_page)-$per_myposts_page;
			}else{
				$myposts_page_1 = 0;
			}
		}
		$this->db->query("SELECT * FROM posts WHERE post_user_id = :post_user_id ORDER BY post_id DESC LIMIT :myposts_page_1,:per_myposts_page");
		$this->db->bind(':post_user_id', $_SESSION['user_id']);
		$this->db->bind(':myposts_page_1', $myposts_page_1);
		$this->db->bind(':per_myposts_page', $per_myposts_page);
		$myposts = $this->db->resultSet();
		return $myposts;
	}
	public function countMyposts(){
		$this->db->query("SELECT * FROM posts WHERE post_user_id = :post_user_id");
		$this->db->bind(':post_user_id', $_SESSION['user_id']);
		$this->db->execute();
		$myposts_count = $this->db->rowCount();
		return $myposts_count;
	}
	public function displayMyFriendsPosts($per_myfriends_posts_page,$myfriends_posts_page){
		if(isset($myfriends_posts_page)){
			$myfriends_posts_page = $myfriends_posts_page;
		}else{
			$myfriends_posts_page = 1;
		}
		if($myfriends_posts_page == "" || $myfriends_posts_page == 1){
			$myfriends_posts_page_1 = 0;
		}else{
			if(is_int($myfriends_posts_page) && is_int($per_myfriends_posts_page) && is_int($per_myfriends_posts_page)){
				$myfriends_posts_page_1 = ($myfriends_posts_page * $per_myfriends_posts_page)-$per_myfriends_posts_page;
			}else{
				$myfriends_posts_page_1 = 0;
			}
		}
		$published = "published";
		$this->db->query("SELECT * FROM posts WHERE post_user_id != :user_id ORDER BY post_id DESC");
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$myfriends_posts = $this->db->resultSet();
		return $myfriends_posts;
	}
	public function countMyFriendsposts(){
		$published = "published";
		$this->db->query("SELECT posts.post_id, posts.post_user_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_comment_count, posts.post_status, posts.post_views_count, friends.user_id, friends.friend_id FROM posts LEFT JOIN friends ON posts.post_user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND posts.post_status = :published");
		$this->db->bind(':published', $published);
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->execute();
		$myfriends_posts_count = $this->db->rowCount();
		return $myfriends_posts_count;
	}
	public function selectPostById($post_id){
		$this->db->query("DELETE FROM last_seen_posts WHERE user_id = :current_user_id AND post_id = :post_id");
		$this->db->bind(':current_user_id',$_SESSION['user_id']);
		$this->db->bind(':post_id',$post_id);
		$this->db->execute();
		$this->db->query("INSERT INTO last_seen_posts (user_id,post_id) VALUES(:current_user_id,:post_id)");
		$this->db->bind(':current_user_id',$_SESSION['user_id']);
		$this->db->bind(':post_id',$post_id);
		$this->db->execute();
		$this->db->query("SELECT * FROM posts WHERE post_id = :post_id");
		$this->db->bind(':post_id', $post_id);
		return $this->db->single();
	}
	public function showMyDiaries(){
		$this->db->query("SELECT * FROM posts WHERE post_user_id = :user_id AND post_category_id = :post_category_id ORDER BY post_id DESC");
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->bind(':post_category_id', 15);
		return $this->db->resultSet();
	}
	public function showMyParticipations(){
		$this->db->query("SELECT * FROM posts WHERE post_user_id = :user_id ORDER BY post_id DESC");
		$this->db->bind(':user_id', $_SESSION['user_id']);
		return $this->db->resultSet();
	}
	public function lastSearchMyPosts(){
		$search_category = 'search_myposts';
		$this->db->query("SELECT search_content FROM searchs WHERE search_user_id = :current_user_id AND search_category = :search_category ORDER BY search_id DESC LIMIT 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':search_category', $search_category);
		$select_last_myposts_search = $this->db->single();
		return "%" . $select_last_myposts_search->search_content . "%";
	}
	public function displayMyPostsSearch($per_myposts_page,$myposts_page){
		if(isset($myposts_page)){
			$myposts_page = $myposts_page;
		}else{
			$myposts_page = 1;
		}
		if($myposts_page == "" || $myposts_page == 1){
			$myposts_page_1 = 0;
		}else{
			$myposts_page_1 = ($myposts_page * $per_myposts_page)-$per_myposts_page;
		}
		$published = "published";
		$last_search = $this->lastSearchMyPosts();
		$this->db->query("SELECT * FROM posts WHERE post_user_id = :current_user_id AND post_status = :published AND post_title LIKE :last_myposts_search ORDER BY post_id DESC LIMIT :myposts_page_1,:per_myposts_page");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':published', $published);
		$this->db->bind(':last_myposts_search', $last_search);
		$this->db->bind(':myposts_page_1', $myposts_page_1);
		$this->db->bind('per_myposts_page', $per_myposts_page);
		$myposts = $this->db->resultSet();
		return $myposts;
	}
	public function countMypostsSearch(){
		$published = "published";
		$last_search = $this->lastSearchMyPosts();
		$this->db->query("SELECT * FROM posts WHERE post_user_id = :current_user_id AND post_status = :published AND post_title LIKE :last_myposts_search");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':published', $published);
		$this->db->bind(':last_myposts_search', $last_search);
		$this->db->execute();
		$count_myposts = $this->db->rowCount();
		return $count_myposts;
	}
	public function lastSearchMyFriendsPosts(){
		$search_category = 'search_myfriends_posts';
		$this->db->query("SELECT search_content FROM searchs WHERE search_user_id = :current_user_id AND search_category = :search_category ORDER BY search_id DESC LIMIT 1");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':search_category', $search_category);
		$select_last_myposts_search = $this->db->single();
		return "%" . $select_last_myposts_search->search_content . "%";
	}
	public function displayMyFriendsPostsSearch($per_myfriends_posts_page,$myfriends_posts_page){
		if(isset($myfriends_posts_page)){
			$myfriends_posts_page = $myfriends_posts_page;
		}else{
			$myfriends_posts_page = 1;
		}
		if($myfriends_posts_page == "" || $myfriends_posts_page == 1){
			$myfriends_posts_page_1 = 0;
		}else{
			$myfriends_posts_page_1 = ($myfriends_posts_page * $per_myfriends_posts_page)-$per_myfriends_posts_page;
		}
		$published = "published";
		$last_search = $this->lastSearchMyFriendsPosts();
		$this->db->query("SELECT posts.post_id,posts.post_request_help,posts.post_relates_count, posts.post_user_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content,posts.post_comment_count, posts.post_status, posts.post_dislikes_count, posts.post_likes_count, posts.post_rating, posts.post_views_count, friends.user_id, friends.friend_id FROM posts LEFT JOIN friends ON posts.post_user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND post_status = :published AND post_title LIKE :last_myfriends_posts_search ORDER BY post_id DESC LIMIT :myfriends_posts_page_1,:per_myfriends_posts_page");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':published', $published);
		$this->db->bind(':last_myfriends_posts_search', $last_search);
		$this->db->bind(':myfriends_posts_page_1', $myfriends_posts_page_1);
		$this->db->bind('per_myfriends_posts_page', $per_myfriends_posts_page);
		$myfriends_posts = $this->db->resultSet();
		return $myfriends_posts;
	}
	public function countMyFriendspostsSearch(){
		$published = "published";
		$last_search = $this->lastSearchMyFriendsPosts();
		$this->db->query("SELECT posts.post_id, posts.post_user_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content,posts.post_comment_count, posts.post_status, posts.post_views_count, friends.user_id, friends.friend_id FROM posts LEFT JOIN friends ON posts.post_user_id = friends.friend_id WHERE friends.user_id = :current_user_id AND post_status = :published AND post_title LIKE :last_myfriends_posts_search");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		$this->db->bind(':published', $published);
		$this->db->bind(':last_myfriends_posts_search', $last_search);
		$this->db->execute();
		$count_myfriends_posts = $this->db->rowCount();
		return $count_myfriends_posts;
	}
	public function findPostById($post_id){
		$this->db->query("SELECT * FROM posts WHERE post_id = :post_id");
		$this->db->bind(':post_id', $post_id);
		return $this->db->single();
	}
	public function last_seen_posts(){
		$this->db->query("SELECT posts.post_id, posts.post_user_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_comment_count, posts.post_status, posts.post_views_count,last_seen_posts.user_id FROM posts LEFT JOIN last_seen_posts ON posts.post_id = last_seen_posts.post_id WHERE last_seen_posts.user_id = :current_user_id ORDER BY last_seen_posts.id DESC LIMIT 5");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		return $this->db->resultSet();
	}
	public function recently_liked_posts(){
		$this->db->query("SELECT posts.post_id, posts.post_user_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_comment_count, posts.post_status, posts.post_views_count,likes.like_id FROM posts LEFT JOIN likes ON posts.post_id = likes.post_id WHERE likes.user_id = :current_user_id AND likes.likes = 1 ORDER BY likes.like_id DESC LIMIT 5");
		$this->db->bind(':current_user_id', $_SESSION['user_id']);
		return $this->db->resultSet();
	}
	public function post_is_viewed($post_id){
		$this->db->query("SELECT posts.post_id, posts.post_user_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_comment_count, posts.post_status, posts.post_views_count,last_seen_posts.id FROM posts LEFT JOIN last_seen_posts ON posts.post_id = last_seen_posts.post_id WHERE last_seen_posts.post_id = :post_id");
		$this->db->bind(":post_id", $post_id);
		$this->db->execute();
		$count = $this->db->rowCount();
		if($count === 1){
			return true;
		}else{
			return false;
		}
	}
	public function count_posts($post_user_id){
		$this->db->query("SELECT post_id FROM posts WHERE post_user_id = :post_user_id");
		$this->db->bind(':post_user_id', $post_user_id);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function show_posts_by_user_id($user_id){
		$this->db->query("SELECT post_id,post_title,post_image,post_user_id,post_date,post_author,post_likes_count,post_content FROM posts WHERE post_user_id = :user_id");
		$this->db->bind(':user_id', $user_id);
		return $this->db->resultSet();
	}
}
?>