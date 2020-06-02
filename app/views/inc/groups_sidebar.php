<div class="logged-in-user row pb-2">
	<div class="col-md-4">
		<img <?php echo ($data['creator']->user_id == $_SESSION['user_id']) ? "data-toggle='modal' data-target='#change_group_image'" : ""?> style="height: 100px;width: 100px;border-radius: 250px;<?php echo ($data['creator']->user_id == $_SESSION['user_id']) ? "cursor:pointer;" : "";?>" src="<?php echo group_images($data['group'],$data['creator']->user_name); ?>" alt="">
	</div>
	<div class="col-md-8 text-center" style="margin: auto;">
		<h4 class="pt-3"><?php echo $data['group']->group_name; ?> Chat room</h4>
	</div>
</div>
<div class="text-center" style="margin-top: 112px;">
	<?php
	if($data['creator']->user_id == $_SESSION['user_id']){
	?>
	<h4>Change : </h4>
	<div class="btn-group-vertical text-center" role="group" aria-label="Basic example">
	<div class="btn-group text-center" role="group" aria-label="Basic example">
		<button data-toggle='modal' data-target='#change_group_b_image' type="submit" class="btn btn-primary"> background image</button>
		<button data-toggle='modal' data-target='#change_group_name' type="submit" class="btn btn-primary"> group name</button>
	</div>
	<div class="btn-group text-center" role="group" aria-label="Basic example">
		<?php if($data['not_members_count'] < ($data['friends_count'] - 2)): ?>
			<button style="margin-bottom: 15px;" data-toggle='modal' data-target='#delete_member' class='btn btn-danger'><i class="fa fa-trash"></i> Delele members</button>
		<?php else: ?>
			<button style="margin-bottom: 15px;cursor: no-drop;" class='btn btn-secondary'><i class="fa fa-trash"></i> Delele members</button>
		<?php endif; ?>
		<?php if($data['not_members_count'] == 0): ?>
			<button style="margin-bottom: 15px;cursor: no-drop;" class='btn btn-secondary'><i class="fa fa-plus"></i> Add members</button>
		<?php else: ?>
			<button style="margin-bottom: 15px;" data-toggle='modal' data-target='#add_member' class='btn btn-primary'><i class="fa fa-plus"></i> Add members</button>
		<?php endif; ?>
	</div>
</div>
	<?php
	}
	?>
</div>
<h5 class="mb-4">Group members :</h5>
<div class="get_members"></div>