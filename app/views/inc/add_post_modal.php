<div class="modal fade" id="addPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo URLROOT; ?>/posts/add" method="post" enctype="multipart/form-data">
          <?php $datapost = $data['add_post']; ?>
          <div class="form-group"><label for="post_title">post_title: <sup>*</sup></label>
            <input type="text" name="post_title" value="<?php echo $datapost['post_title']; ?>" class="form-control form-control-md <?php echo (!empty($data['post_title_err'])) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['post_title_err']; ?></span>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group"><label for="post_category">Post category: <sup>*</sup></label>
            <select name ="post_category_id" class="form-control form-control-md <?php echo (!empty($data['post_category_id_err'])) ? 'is-invalid' : ''; ?>">
              <option value="<?php echo (empty($data['post_category_id'])) ? '' : $data['post_category_id']; ?>">1</option>
            </select>
            <span class="invalid-feedback"><?php echo $data['user_category_id_err']; ?></span>
          </div>
            </div>
            <div class="col">
              <div class="form-group"><label for="post_status">post_status: <sup>*</sup></label>
              <select name ="post_status" class="form-control form-control-md <?php echo (!empty($data['post_status_err'])) ? 'is-invalid' : ''; ?>">
              <option value="<?php echo (empty($data['post_status'])) ? '' : $data['post_status']; ?>"><?php echo (empty($data['post_status'])) ? 'Select options' : ucwords($data['post_status']); ?></option>
              <?php if($data['post_status'] === "publish"): ?>
                <option value="publish">Publish</option>
              <?php elseif($data['post_status'] === "draft"): ?>
                <option value="draft">Draft</option>
              <?php else: ?>
                <option value="publish">Publish</option>
                <option value="draft">Draft</option>
              <?php endif; ?>
            </select>
            <span class="invalid-feedback"><?php echo $data['post_status_err']; ?></span>
          </div>
          </div>
          </div>
          <div class="form-group"><label for="post_image">Post_image: <sup>*</sup></label>
            <input type="file" name="post_image" value="<?php echo $datapost['post_image']; ?>" class="form-control form-control-md <?php echo (!empty($data['post_image_err'])) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['post_image_err']; ?></span>
          </div>
          <div class="form-group"><label for="post_content">Post_content: <sup>*</sup></label>
            <textarea class="form-control "name="post_content" id="editor" cols="30" rows="10">
         </textarea>
            <span class="invalid-feedback"><?php echo $data['post_content_err']; ?></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>