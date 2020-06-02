<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<?php
$users_page = $data['users_page'];
$myfriends_page = $data['myfriends_page'];
$per_users_page = $data['per_users_page'];
$per_myfriends_page = $data['per_myfriends_page'];
$count_users = $data['count_users'];
$count_myfriends = $data['count_myfriends'];
$count_users_for_pagination = ceil($count_users/$per_users_page);
$count_myfriends_for_pagination = ceil($count_myfriends/$per_myfriends_page);
$back_users = $users_page - 1;
$back_myfriends = $myfriends_page -1;
$for_users = $users_page + 1;
$for_myfriends = $myfriends_page + 1;
?>
<div role="main" class="container-fluid" style="margin-top: 70px;">
	<div class="row">
		<div class="col-md-3 scroll-sidebar1" style="overflow: auto;height: 87vh;">
		<?php require APPROOT . '/views/inc/sidebar1.php'; ?>
	</div>
		<div class="col-md-6 offset-md-3">
<nav class="navbar navbar-expand-xl navbar-light bg-light">
			<?php if($data['search'] == 'mysearch'): ?>
			<a href="<?php echo URLROOT; ?>/users/search_for_friends/1/<?php echo $myfriends_page; ?>/mysearch" style="text-decoration: none;" class="nav-link" data-toggle="tooltip" data-placement="left" title="Back to the list of all users"><i class="fa fa-backward"></i></a>
			<?php else: ?>
				<a href="<?php echo URLROOT; ?>/users/search_for_friends/1/<?php echo $myfriends_page; ?>" style="text-decoration: none;" class="nav-link" data-toggle="tooltip" data-placement="left" title="Back to the list of all users"><i class="fa fa-backward"></i></a>
			<?php endif; ?>
			<span class="nav-link" style="color:black;"><i class="fa fa-search"></i> Search for friends</span>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault1" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault1">
        <ul class="navbar-nav mr-auto">
			<?php if($data['search'] === "search"): ?>
				<li class="nav-item">
					<span class="nav-link">Search results: <?php echo $count_users ; ?></span>
				</li>
			<?php endif; ?>
		</ul>
        <ul class="navbar-nav ml-auto">
        <form action="<?php echo URLROOT . '/searchs/searchFriends'; ?>" method="post" class="form-inline my-2 my-lg-0">
        <div class="input-group input-group-sm">
        <input type="text" class="form-control" name="search_content" placeholder="Search for friends" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
        <div class="input-group-append">
        <button type="submit" name="search_friends" class="input-group-text"><i class="fa fa-search"></i></button>
        </div>
        </div>
        </form>
		</div>
		</nav>
			<div class="row mb-3">
				<?php if($count_users === 0): ?>
					<div class="col-3"></div>
					<div class="col-6 mt-3">
						<h3 class="text-center text-muted">-- no found users --</h3>
					</div>
					<div class="col-3"></div>
				</div>
				<?php else: ?>
				<?php foreach($data['users'] as $users): ?>
					<?php
					$user = new Users();
					$user->user_id = $users->user_id;
					$message = $user->search_for_friends();
					?>
					<div class="col-lg-3 col-6 mt-3">
						<div class="card bg-light">
							<div class="text-center">
								<?php if($users->user_image == "unknown-profile.jpg" || $users->user_image == 'unknown-profile-woman.jpg'):
									$profile_image = URLROOT . "/images/website_images/" . $users->user_image;
								else:
									$profile_image = URLROOT . "/images/users_images/" . $users->user_name . "_images/profile_images/" . $users->user_image;
								endif;
								?>
								<img class="img-fluid mt-3" style="height:70px;width:70px;border-radius:250px;" src="<?php echo $profile_image; ?>" alt="">
								<p><?php echo $users->user_name; ?></p>
								<?php
                if($message == "block"):
                ?>
                	<a href="<?php echo URLROOT . "/chats/read/{$_SESSION['user_id']}/{$users->user_id}" ?>" style="border-radius: 0px;" class="btn btn-primary btn-block"> Send message</a>
                <?php
                else:
                    ?>
					<form action="<?php echo URLROOT; ?>/users/accept/<?php echo $users->user_id; ?>" method="post" class="">
                        <input type="submit" style="border-radius: 0;" class="btn btn-primary btn-block" name="accept_request<?php echo $users->user_id ; ?>" value="send message">
                    </form>                    <?php
                endif;
                ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
			<?php if($count_users_for_pagination > 1): ?>
						<?php if($users_page <= 1): ?>
							<a class="btn btn-light" href="#" aria-label="Previous">previous</a>
						<?php else: ?>
							<?php if($data['search'] === "search"): ?>
								<a class="btn btn-light" href="<?php echo  URLROOT . "/users/search_for_friends/" . $back_users . "/" . $myfriends_page . "/" . "/search" ; ?>" aria-label="Previous">previous</a>
							<?php elseif($data['search'] === "mysearch"): ?>
								<a class="btn btn-light" href="<?php echo  URLROOT . "/users/search_for_friends/" . $back_users . "/" . $myfriends_page . "/" . "/mysearch" ; ?>" aria-label="Previous">previous</a>
							<?php else: ?>
								<a class="btn btn-light" href="<?php echo  URLROOT . "/users/search_for_friends/" . $back_users . "/" . $myfriends_page . "/" ; ?>" aria-label="Previous">previous</a>
							<?php endif; ?>
						<?php endif; ?>
					</a>
						<?php if($users_page >= $count_users_for_pagination): ?>
							<a class="btn btn-light pull-right" href="#" aria-label="Previous">next</a>
						<?php else: ?>
							<?php if($data['search'] === "search"): ?>
								<a class="btn btn-light pull-right" href="<?php echo  URLROOT . "/users/search_for_friends/" . $for_users . "/" . $myfriends_page . "/search"; ?>" aria-label="Previous">next</a>
							<?php elseif($data['search'] === "mysearch"): ?>
								<a class="btn btn-light pull-right" href="<?php echo  URLROOT . "/users/search_for_friends/" . $for_users . "/" . $myfriends_page . "/mysearch"; ?>" aria-label="Previous">next</a>
							<?php else: ?>
								<a class="btn btn-light pull-right" href="<?php echo  URLROOT . "/users/search_for_friends/" . $for_users . "/" . $myfriends_page ; ?>" aria-label="Previous">next</a>
							<?php endif; ?>
						<?php endif; ?>
		<?php endif; ?>
<nav class="navbar navbar-expand-xl navbar-light bg-light mt-3">
			<?php if($data['search'] == 'search'): ?>
			<a href="<?php echo URLROOT; ?>/users/search_for_friends/<?php echo $users_page; ?>/1/search" style="text-decoration: none;" class="nav-link" data-toggle="tooltip" data-placement="left" title="Back to the list of all friends"><i class="fa fa-backward"></i></a>
			<?php else: ?>
				<a href="<?php echo URLROOT; ?>/users/search_for_friends/<?php echo $users_page; ?>" style="text-decoration: none;" class="nav-link" data-toggle="tooltip" data-placement="left" title="Back to the list of all friends"><i class="fa fa-backward"></i></a>
			<?php endif; ?>
			<span class="nav-link" style="color:black;"><i class="fa fa-users"></i> My friends</span>
		      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault1" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExampleDefault1">
        <ul class="navbar-nav mr-auto">
			<?php if($data['search'] === "mysearch"): ?>
				<li class="nav-item">
					<span class="nav-link">Search results: <?php echo $count_myfriends ; ?></span>
				</li>
			<?php endif; ?>
		</ul>
		<ul class="navbar-nav ml-auto">
			<form action="<?php echo URLROOT ; ?>/searchs/searchMyFriends" method="post" class="form-inline my-2 my-lg-0">
				<div class="input-group input-group-sm">
				<input type="text" class="form-control" name="search_content_myfriends" placeholder="Search for my friends">
				<div class="input-group-append">
				<button type="submit" name="search_myfriends" class="input-group-text"><i class="fa fa-search"></i></button>
				</div>
			</form>
		</div>
		</nav>
		<div class="row mb-3">
			<?php if($count_myfriends === 0): ?>
					<div class="col-3"></div>
					<div class="col-6 mt-3">
						<h3 class="text-center text-muted">-- no found users --</h3>
					</div>
					<div class="col-3"></div>
				</div>
				<?php else: ?>
				<?php foreach($data['myfriends'] as $myfriends): ?>
					<div class="col-lg-3 col-6 mt-3">
						<div class="card bg-light">
							<div class="text-center">
								<?php if($myfriends->user_image == "unknown-profile.jpg" || $myfriends->user_image == 'unknown-profile-woman.jpg'):
									$profile_image_myfriends = URLROOT . "/images/website_images/" . $myfriends->user_image;
								else:
									$profile_image_myfriends = URLROOT . "/images/users_images/" . $myfriends->user_name . "_images/profile_images/" . $myfriends->user_image;
								endif;
								?>
								<img class="img-fluid mt-3" style="height:70px;width:70px;border-radius:250px;" src="<?php echo $profile_image_myfriends; ?>" alt="">
								<p><?php echo $myfriends->user_name; ?></p>

                    <form action="<?php echo URLROOT; ?>/users/block/<?php echo $myfriends->friend_id; ?>" method="post">
                        <input type="submit" class="btn btn-danger btn-block" name="block<?php echo $myfriends->friend_id ; ?>" value="block">
                    </form>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
			<?php if($count_myfriends_for_pagination > 1): ?>
			<?php if($myfriends_page <= 1): ?>
				<a class="btn btn-light" href="#" aria-label="Previous" style="color: gray;">previous</a>
			<?php else: ?>
				<?php if($data['search'] === "search"): ?>
					<a class="btn btn-light" href="<?php echo  URLROOT . "/users/search_for_friends/" . $users_page . "/" . $back_myfriends . "/search" ; ?>" aria-label="Previous">previous</a>
				<?php elseif($data['search'] === "mysearch"): ?>
					<a class="btn btn-light" href="<?php echo  URLROOT . "/users/search_for_friends/" . $users_page . "/" . $back_myfriends . "/mysearch" ; ?>" aria-label="Previous">previous</a>
				<?php else: ?>
					<a class="btn btn-light" href="<?php echo  URLROOT . "/users/search_for_friends/" . $users_page . "/" . $back_myfriends ; ?>" aria-label="Previous">previous</a>
				<?php endif; ?>
			<?php endif; ?>
			<?php if($myfriends_page >= $count_myfriends_for_pagination): ?>
				<a class="btn btn-light pull-right" href="#" aria-label="Previous" style="color: gray;">next</a>
			<?php else: ?>
				<?php if($data['search'] === "search"): ?>
					<a class="btn btn-light pull-right" href="<?php echo  URLROOT . "/users/search_for_friends/" . $users_page . "/" . $for_myfriends . "/search"; ?>" aria-label="Previous">next</a>
				<?php elseif($data['search'] === "mysearch"): ?>
					<a class="btn btn-light pull-right" href="<?php echo  URLROOT . "/users/search_for_friends/" . $users_page . "/" . $for_myfriends . "/mysearch" ; ?>" aria-label="Previous">next</a>
				<?php else: ?>
					<a class="btn btn-light pull-right" href="<?php echo  URLROOT . "/users/search_for_friends/" . $users_page . "/" . $for_myfriends ; ?>" aria-label="Previous">next</a>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
		</div>
		<div class="col-md-3 offset-md-9 scroll-sidebar" style="overflow: auto;height: 87vh;">
		<?php require APPROOT . '/views/inc/sidebar.php'; ?>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>