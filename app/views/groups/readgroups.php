<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT . '/css/profile.css'; ?>">
<?php require APPROOT . '/views/inc/navbar.php'; ?> 
	<div class="container">
		<div class="row" style="margin-top: 60px">
		<div class="col-md-3 mt-3" style="position:fixed;">
		<?php require APPROOT . '/views/inc/sidebar.php'; ?>
		<div class="modal fade" id="add-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		</div></div>
			<div class="col-md-8 offset-md-4 mt-3">
				<center><h1 style="color:#ffb380;">Gatherings I can join</h1></center><br>
				<table class="table">
  <thead style="background-color: rgb(255, 179, 128);">
    <tr>
      <th scope="col"></th>
      <th scope="col">Gatherings' names</th>
      <th scope="col">Gatherings' creators</th>
      <th scope="col">Gathering's themes</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  	<?php $i=1; ?>
  	<?php foreach ($data['readgroups'] as $groups) { ?>
    <tr>
      <th scope="row"><?php echo $i; ?></th>
      <td><?php echo $groups->group_name ?></td>
      <td>
      <?php 
      $uer = new Users();
      $creator = $user->findUserById($groups->creator_id);
      echo $creator->user_name;
      ?>
  	</td>
      <td><?php echo $groups->group_theme ?></td>
      <td><a class="btn btn-sm" style="color: black;" href="<?php echo URLROOT; ?>/groups/joingroup/<?php echo $groups->group_id; ?>">join</a></td>
    </tr>
<?php
$i++;
}
?>
  </tbody>
</table>
			</div>
		</div>
	</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>