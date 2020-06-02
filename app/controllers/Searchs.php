<?php
class Searchs extends Controller {
	public function __construct(){
		$this->searchModel = $this->model('Search');
	}
	public function searchFriends(){
		if($_POST['search_content'] === ''){
			redirect('users/searchForFriends');
		}else{
			$this->searchModel->insertSearchData();
			redirect('users/searchForFriends/1/1/search');
		}
	}
	public function searchMyFriends(){
		if($_POST['search_content_myfriends'] === ''){
			redirect('users/searchForFriends');
		}else{
			$this->searchModel->insertSearchDataMyFriends();
			redirect('users/searchForFriends/1/1/mysearch');
		}
	}
	public function searchMyPosts(){
		if($_POST['search_content_myposts'] === ''){
			redirect('pages/index');
		}else{
			$this->searchModel->insertSearchDataMyPosts();
			redirect('pages/index/1/1/search');
		}
	}
	public function searchMyFriendsPosts(){
		if($_POST['search_content_myfriends_posts'] === ''){
			redirect('pages/index');
		}else{
			$this->searchModel->insertSearchDataMyFriendsPosts();
			redirect('pages/index/1/1/mysearch');
		}
	}
}
?>