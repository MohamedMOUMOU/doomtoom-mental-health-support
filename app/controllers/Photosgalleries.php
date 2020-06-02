<?php
class Photosgalleries extends Controller {
	public function __construct(){
		// $this->postsgalleryModel = $this->model('Postsgallery');
		$this->userController = $this->controller('Users');
		$this->postsgalleriesController = $this->controller('Postsgalleries');
		$this->usersgalleriesController = $this->controller('Usersgalleries');
		$this->personalgalleriesController = $this->controller('Personalgalleries');
		$this->gallerieslikesController = $this->controller('Gallerieslikes');
		$this->galleriesdislikesController = $this->controller('Galleriesdislikes');
		$this->photosgalleryModel = $this->model('Photosgallery');
	}
	public function show($photos_gallery_id){
		$user = new Users();
		$galleries_likes = new Gallerieslikes();
		$galleries_dislikes = new Galleriesdislikes();
		$user_i = $user->find_user_by_photo_gallery_id($photos_gallery_id);
		$user_id = $user_i->user_id;
		$is_friend = $user->is_friend($user_id);
		if($photos_gallery_id == $_SESSION['photos_gallery_id'] || $is_friend){
			$posts_gallery = new Postsgalleries();
			$users_gallery = new Usersgalleries();
			$personal_gallery = new Personalgalleries();
			$user = new Users();
			$user_n = $user->find_user_by_photo_gallery_id($photos_gallery_id);
			$data = [
				'logged_in_user' => $user->getUserInfo(),
				'user_name' => $user_n->user_name,
				'user_image' => $user_n->user_image,
				'photos_gallery' => $this->photosgalleryModel->read($photos_gallery_id),
				'liked' => $galleries_likes->liked_gallery($photos_gallery_id),
				'disliked' => $galleries_dislikes->disliked_gallery($photos_gallery_id),
				'posts_galleries_media' => $posts_gallery->read($photos_gallery_id),
				'posts_galleries_media_1' => $posts_gallery->readjust_number(1,$photos_gallery_id),
				'posts_galleries_media_2' => $posts_gallery->readjust_number(2,$photos_gallery_id),
				'posts_galleries_media_3' => $posts_gallery->readjust_number(3,$photos_gallery_id),
				'posts_galleries_media_4' => $posts_gallery->readjust_number(4,$photos_gallery_id),
				'posts_galleries_media_count' => $posts_gallery->count($photos_gallery_id),
				'personal_galleries_media' => $personal_gallery->read($photos_gallery_id),
				'personal_galleries_media_1' => $personal_gallery->readjust_number(1,$photos_gallery_id),
				'personal_galleries_media_2' => $personal_gallery->readjust_number(2,$photos_gallery_id),
				'personal_galleries_media_3' => $personal_gallery->readjust_number(3,$photos_gallery_id),
				'personal_galleries_media_4' => $personal_gallery->readjust_number(4,$photos_gallery_id),
				'personal_galleries_media_count' => $personal_gallery->count($photos_gallery_id),
				'users_galleries_media_p_images' => $users_gallery->read('profile_images',$photos_gallery_id),
				'users_galleries_media_pbi_images' => $users_gallery->read('pbi_images',$photos_gallery_id),
				'users_galleries_media_1' => $users_gallery->readjust_number(1,$photos_gallery_id),
				'users_galleries_media_2' => $users_gallery->readjust_number(2,$photos_gallery_id),
				'users_galleries_media_3' => $users_gallery->readjust_number(3,$photos_gallery_id),
				'users_galleries_media_4' => $users_gallery->readjust_number(4,$photos_gallery_id),
				'users_galleries_media_count_p_images' => $users_gallery->count_p_images($photos_gallery_id),
				'users_galleries_media_count_pbi_images' => $users_gallery->count_pbi_images($photos_gallery_id),
				'users_galleries_media_count' => $users_gallery->count_u_images($photos_gallery_id),
			];
			$this->view('Photosgalleries/show', $data);
		}
	}
}
?>