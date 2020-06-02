<?php
class Profilelikes extends Controller {
	public function __construct(){
		$this->profilelikesModel = $this->model('Profilelike');
	}
	public function likeProfile($profile_id){
		$like_profile = $this->profilelikesModel->likeProfile($profile_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $like_profile;
	}
	public function likedprofile($profile_id){
		$likedprofile = $this->profilelikesModel->likedprofile($profile_id);
		return $likedprofile;
	}
}
?>