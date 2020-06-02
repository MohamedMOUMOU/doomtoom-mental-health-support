<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<!-- Add post Modal -->
<div class="container-fluid" style="margin-top: 90px;">
	<div class="row">
		<div class="col-md-6 offset-md-3 scroll-sidebar" style="max-height:89vh; overflow: auto;">
			<div class="modal-body">
        <h1 style="color: rgb(255, 179, 128);">Participate</h1>
        <form action="<?php echo URLROOT; ?>/posts/add" method="post" enctype="multipart/form-data">
          <div class="form-group"><label for="post_title">Participation title: <sup>*</sup></label>
            <input type="text" name="post_title" value="<?php echo $data['post_title']; ?>" class="form-control form-control-md <?php echo (!empty($data['post_title_err'])) ? 'is-invalid' : ''; ?>" class="post_title" required>
            <span class="invalid-feedback"><?php echo $data['post_title_err']; ?></span>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group"><label for="post_category">Participation type: <sup>*</sup></label>
            <select name ="post_category_id" class="form-control form-control-md <?php echo (!empty($data['post_category_id_err'])) ? 'is-invalid' : ''; ?>">
                <option value="16">Share your remote</option>
                <option value="16">Free participation</option>
            </select>
            <span class="invalid-feedback"><?php echo $data['post_category_id_err']; ?></span>
          </div>
            </div>
            <div class="col">
              <div class="form-group"><label for="post_status">post_status: <sup>*</sup></label>
              <select name ="post_status" class="form-control form-control-md <?php echo (!empty($data['post_status_err'])) ? 'is-invalid' : ''; ?>" required>
              <option value="<?php echo (empty($data['post_status'])) ? '' : $data['post_status']; ?>"><?php echo (empty($data['post_status'])) ? 'Select options' : ucwords($data['post_status']); ?></option>
              <?php if($data['post_status'] === "publish"): ?>
                <option value="draft">Draft</option>
              <?php elseif($data['post_status'] === "draft"): ?>
                <option value="publish">Publish</option>
              <?php else: ?>
                <option value="published">Publish</option>
                <option value="draft">Private</option>
              <?php endif; ?>
            </select>
            <span class="invalid-feedback"><?php echo $data['post_status_err']; ?></span>
          </div>
          </div>
          <div class="col">
            <div class="form-group"><label for="post_request_help">Request help ?: <sup>*</sup></label>
              <select name ="post_request_help" class="form-control form-control-md <?php echo (!empty($data['post_request_help_error'])) ? 'is-invalid' : ''; ?>" required>
              <option value="<?php echo (empty($data['post_request_help'])) ? '' : $data['post_request_help']; ?>"><?php echo (empty($data['post_request_help'])) ? 'Select options' : ucwords($data['post_request_help']); ?></option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            <span class="invalid-feedback"><?php echo $data['post_request_help']; ?></span>
          </div>
          </div>
          </div>
          <div class="form-group"><label for="post_image">Participation image: <sup>*</sup></label>
            <input type="file" name="post_image" value="<?php echo $data['post_image']['name']; ?>" class="form-control form-control-md <?php echo (!empty($data['post_image_err'])) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['post_image_err']; ?></span>
          </div>
          <div class="form-group"><label for="post_content">Participation content: <sup>*</sup></label>
            <textarea class="form-control <?php echo (!empty($data['post_image_err'])) ? 'is-invalid' : ''; ?>"name="post_content" id="editor" cols="30" rows="10">
            	<?php echo $data['post_content']; ?>
         </textarea>
         <span class="invalid-feedback"><?php echo $data['post_content_err']; ?></span>
          </div>
          <input type="submit" value="Participate" name="add_post" style="background-color:rgb(255, 179, 128);" class="btn btn-block">
        </form>
      </div>
		</div>
		<div class="col-md-6 scroll-sidebar" style="max-height:89vh; overflow: auto;">
			<h2 class="post_title_example"><h2>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>