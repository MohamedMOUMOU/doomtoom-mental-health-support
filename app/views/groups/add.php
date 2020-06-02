<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<!-- Add post Modal -->
<div class="container-fluid" style="margin-top: 90px;">
	<div class="row">
		<div class="col-md-6 offset-md-3 scroll-sidebar" style="max-height:89vh; overflow: auto;">
			<div class="modal-body">
        <h1 style="color: rgb(255, 179, 128);">Add a gathering</h1>
        <form action="<?php echo URLROOT; ?>/groups/add" method="post" enctype="multipart/form-data">
          <div class="form-group"><label for="group_name">Group name: <sup>*</sup></label>
            <input type="text" name="group_name" value="<?php echo $data['group_name']; ?>" class="form-control form-control-md <?php echo (!empty($data['group_name_err'])) ? 'is-invalid' : ''; ?>" class="group_name" required>
            <span class="invalid-feedback"><?php echo $data['group_name_err']; ?></span>
          </div>
          <div class="form-group"><label for="group_theme">Group theme: <sup>*</sup></label>
            <input type="text" name="group_theme" value="<?php echo $data['group_theme']; ?>" class="form-control form-control-md <?php echo (!empty($data['group_theme_err'])) ? 'is-invalid' : ''; ?>" class="group_theme" required>
            <span class="invalid-feedback"><?php echo $data['group_theme_err']; ?></span>
          </div>
          <div class="form-group"><label for="group_image">Post image: <sup>*</sup></label>
            <input type="file" name="group_image" value="<?php echo $data['group_image']['name']; ?>" class="form-control form-control-md">
          </div>
          <div class="form-group"><label for="group_b_image">Group background image: <sup>*</sup></label>
            <input type="file" name="group_b_image" value="<?php echo $data['group_b_image']['name']; ?>" class="form-control form-control-md">
          </div>
          <input type="submit" style="background-color:rgb(255, 179, 128);" value="Create a gathering" name="add_group" class="btn btn-success btn-block">
        </form>
      </div>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>