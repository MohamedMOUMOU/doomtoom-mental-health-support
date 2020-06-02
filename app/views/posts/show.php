<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<?php $user = new Users(); ?>
<?php $showpost = $data['show_post']; ?>
<div role="main" class="container-fluid" style="margin-top: 70px;">
	<div class="row">
		<div class="col-md-3 scroll-sidebar1" style="overflow: auto;height: 87vh;">
		<?php require APPROOT . '/views/inc/sidebar1.php'; ?>
	</div>
		<div class="col-md-6 offset-md-3">
				<span class="pull-right mt-3">
					by <a href="#"><?php echo $showpost->post_author ?></a>
				</span>
				<h3 class="mt-2 mb-3"><a href="#" style="text-decoration: none;"><?php echo $showpost->post_title ?></a></h3>
				<hr>
				<p>Posted on <?php echo $showpost->post_date ?></p>
				<hr>
				<?php
                if ($showpost->post_image):
            	$post_user = $user->findUserById($showpost->post_user_id);
				$post_user_name = $post_user->user_name;
                ?>
                <a href="#"><img style="width:100%;" class='img-fluid rounded' src="<?php echo URLROOT . "/images/posts_images/" . $post_user_name . "_images/" . $showpost->post_image; ?>" alt=''></a>
				<?php endif; ?>
				<p class=""><?php echo $showpost->post_content; ?></p>
		</div>
		<div class="col-md-3 offset-md-9 scroll-sidebar" style="overflow: auto;height: 87vh;">
		<?php require APPROOT . '/views/inc/sidebar.php'; ?>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>