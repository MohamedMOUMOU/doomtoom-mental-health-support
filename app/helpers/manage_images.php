<?php
function profile_image($profile_image){
	if($profile_image->user_image === "unknown-profile.jpg"){
		return URLROOT . "/images/website_images/unknown-profile.jpg";
	}elseif($profile_image->user_image === "unknown-profile-woman.jpg"){
		return URLROOT . "/images/website_images/unknown-profile-woman.jpg";
	}else{
		return URLROOT . "/images/users_images/" . $profile_image->user_name . "_images/profile_images/" . $profile_image->user_image;
	}
}
function pbi_image($pbi_image){
	if($pbi_image->user_pbi === "default-pbi.png"){
		return URLROOT . "/images/website_images/default-pbi.png";
	}else{
		return URLROOT . "/images/users_images/" . $pbi_image->user_name . "_images/pbi_images/" . $pbi_image->user_pbi;
	}
}
function group_images($group,$group_creator){
	if($group->group_image === "default-g-image.png"){
		return URLROOT . "/images/website_images/default-g-image.png";
	}else{
		return URLROOT . "/images/groups_images/" . $group_creator . "_" . $group->group_name  . "_images/group_images/" . $group->group_image;
	}
}
function group_b_images($group,$group_creator){
	if($group->group_b_image == "default-g-b-image.png"){
		return URLROOT . "/images/website_images/default-g-image.png";
	}else{
		return URLROOT . "/images/groups_images/" . $group_creator . "_" . $group->group_name  . "_images/group_b_images/" . $group->group_b_image;
	}
}
function chat_images($user){
	if($user->chat_image === "default-chat-image.jpg"){
		return URLROOT . "/images/website_images/default-chat-image.jpg";
	}else{
		return URLROOT . "/images/users_images/" . $user->user_name . "_images/chat_images/" . $user->chat_image;
	}
}
?>