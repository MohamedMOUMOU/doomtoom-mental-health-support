<div class="logged-in-user row pb-2">
	<div class="col-md-3" style="position: relative;">
		<?php if($url[3] != 'start'): ?>
		<img src="<?php echo profile_image($data['logged_in_user']); ?>" class="my-image" alt="">
		<img src="<?php echo profile_image($data['receiver']); ?>" class="his-image" alt="">
		<?php elseif($url[3] == 'start'): ?>
			<img src="<?php echo profile_image($data['logged_in_user']); ?>" class="my-image-start" alt="">
		<?php endif; ?>
	</div>
	<div class="col-md-9 text-center" style="margin: auto;">
		<h4 class="pt-3">Chat room</h4>
	</div>
</div>
<div class="text-center" style="margin-top: 115px;">
	<button data-toggle='modal' data-target='#change_chat_image' type="submit" style="margin-bottom: 15px;" class="btn btn-primary">Change chat background image</button>
</div>
<h5 class="mb-4">My Friends : <span style="border-radius: 250px;background-color: #ff7f7a;" class="badge badge-success pull-right offlinefriendscount"></span><span style="border-radius: 250px;background-color: #7aff7a;margin-right: 5px;" class="badge badge-success pull-right onlinefriendscount"></span></h5>
<div class="online_friends_in_chat_room"></div>
