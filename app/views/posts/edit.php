<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<!-- Add post Modal -->
<div class="container-fluid mt-5">
	<div class="row">
		<div class="col-md-6 scroll-sidebar" style="max-height:89vh; overflow: auto;">
			<div class="modal-body">
        <h1>Add a post</h1>
        <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post_id'] ; ?>" method="post" enctype="multipart/form-data">
          <div class="form-group"><label for="post_title">post_title: <sup>*</sup></label>
            <input type="text" name="post_title" value="<?php echo $data['post_title']; ?>" class="form-control form-control-md <?php echo (!empty($data['post_title_err'])) ? 'is-invalid' : ''; ?>" class="post_title" required>
            <span class="invalid-feedback"><?php echo $data['post_title_err']; ?></span>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group"><label for="post_category">Post category: <sup>*</sup></label>
            <select name ="post_category_id" class="form-control form-control-md <?php echo (!empty($data['post_category_id_err'])) ? 'is-invalid' : ''; ?>">
              <option value="<?php echo $data['post_category_id']; ?>"><?php echo $data['post_category_title']; ?></option>
              <?php foreach($data['cat_info'] as $categories):
                if($categories->cat_title == $data['post_category_title']){
                }else{
                ?>
                <option value="<?php echo $categories->cat_id; ?>"><?php echo $categories->cat_title; ?></option>
                <?php
                  }
                endforeach; ?>
            </select>
            <span class="invalid-feedback"><?php echo $data['post_category_id_err']; ?></span>
          </div>
            </div>
            <div class="col">
              <div class="form-group"><label for="post_status">post_status: <sup>*</sup></label>
              <select name ="post_status" class="form-control form-control-md <?php echo (!empty($data['post_status_err'])) ? 'is-invalid' : ''; ?>">
                <?php if($data['post_status'] == 'published'): ?>
                    <option value="published">Publish</option>
                    <option value="draft">Draft</option>
                <?php elseif($data['post_status'] == 'draft'): ?>
                    <option value="draft">Draft</option>
                    <option value="published">Publish</option>
                <?php endif; ?>
            </select>
            <span class="invalid-feedback"><?php echo $data['post_status_err']; ?></span>
          </div>
          </div>
          </div>
          <div class="form-group"><label for="post_image">Post image: <sup>*</sup></label>
            <input style="" type="file" name="post_image" value="<?php echo $data['post_image']; ?>" class="form-control form-control-md <?php echo (!empty($data['post_image_err'])) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['post_image_err']; ?></span>
          </div>
          <div class="form-group"><label for="post_content">Post_content: <sup>*</sup></label>
              <textarea type="text" id="editor_1" name="post_content" class="form-control <?php echo (!empty($data['post_image_err'])) ? 'is-invalid' : ''; ?>">
            	<?php echo $data['post_content']; ?>
          </textarea>
         <span class="invalid-feedback"><?php echo $data['post_content_err']; ?></span>
          </div>
          <input type="submit" value="Edit post" name="edit_post" class="btn btn-success btn-block">
        </form>
      </div>
		</div>
		<div class="col-md-6 scroll-sidebar" style="max-height:89vh; overflow: auto;">
			<h2 class="post_title_example"><h2>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>