<?php
class Profiledislikes extends Controller {
	public function __construct(){
		$this->ProfiledislikesModel = $this->model('Profiledislike');
	}
	public function disLikeProfile($profile_id){
		$dislike_profile = $this->ProfiledislikesModel->disLikeProfile($profile_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $dislike_profile;
	}
	public function dislikedprofile($profile_id){
		$dislikedprofile = $this->ProfiledislikesModel->dislikedprofile($profile_id);
		return $dislikedprofile;
	}
}
?>