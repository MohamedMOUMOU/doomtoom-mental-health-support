<?php require APPROOT . '/views/inc/header.php'; ?>
  <style>
    body{
      background-image: url("<?php echo URLROOT; ?>/public/images/website_images/bg-masthead.jpg");
      background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover;
    }
  </style>
<div class="container">
	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card card-body bg-light mt-5">
				<h2>Create an account</h2>
				<p>Please fill out this form to register</p>
				<form action="<?php echo URLROOT; ?>/users/register" method="post">
					<div class="form-group"><label for="user_name">User name: <sup>*</sup></label>
						<input type="text" name="user_name" value="<?php echo $data['user_name']; ?>" class="form-control form-control-md <?php echo (!empty($data['user_name_err'])) ? 'is-invalid' : ''; ?>">
						<span class="invalid-feedback"><?php echo $data['user_name_err']; ?></span>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group"><label for="user_first_name">First name: <sup>*</sup></label>
								<input type="text" name="user_first_name" value="<?php echo $data['user_first_name']; ?>" class="form-control form-control-md <?php echo (!empty($data['user_first_name_err'])) ? 'is-invalid' : ''; ?>">
								<span class="invalid-feedback"><?php echo $data['user_first_name_err']; ?></span>
							</div>
						</div>
						<div class="col">
							<div class="form-group"><label for="user_last_name">Last name: <sup>*</sup></label>
								<input type="text" name="user_last_name" value="<?php echo $data['user_last_name']; ?>" class="form-control form-control-md <?php echo (!empty($data['user_last_name_err'])) ? 'is-invalid' : ''; ?>">
								<span class="invalid-feedback"><?php echo $data['user_last_name_err']; ?></span>
							</div>
						</div>
					</div>
					<div class="form-group"><label for="user_sex">Sex: <sup>*</sup></label>
						<select name ="user_sex" class="form-control form-control-md <?php echo (!empty($data['user_sex_err'])) ? 'is-invalid' : ''; ?>">
							<option value="<?php echo (empty($data['user_sex'])) ? '' : $data['user_sex']; ?>"><?php echo (empty($data['user_sex'])) ? 'Select options' : ucwords($data['user_sex']); ?></option>
							<?php if($data['user_sex'] === "male"): ?>
								<option value="female">Female</option>
							<?php elseif($data['user_sex'] === "female"): ?>
								<option value="male">Male</option>
							<?php else: ?>
								<option value="male">Male</option>
								<option value="female">Female</option>
							<?php endif; ?>
						</select>
						<span class="invalid-feedback"><?php echo $data['user_sex_err']; ?></span>
					</div>
					<div class="form-group"><label for="user_email">Email: <sup>*</sup></label>
						<input type="email" name="user_email" value="<?php echo $data['user_email']; ?>" class="form-control form-control-md <?php echo (!empty($data['user_email_err'])) ? 'is-invalid' : ''; ?>">
						<span class="invalid-feedback"><?php echo $data['user_email_err']; ?></span>
					</div>
					<div class="form-group"><label for="user_password">Password: <sup>*</sup></label>
						<input type="password" name="user_password" value="<?php echo $data['user_password']; ?>" class="form-control form-control-md <?php echo (!empty($data['user_password_err'])) ? 'is-invalid' : ''; ?>">
						<span class="invalid-feedback"><?php echo $data['user_password_err']; ?></span>
					</div>
					<div class="form-group"><label for="user_password_confirmation">Password confirmation: <sup>*</sup></label>
						<input type="password" name="user_password_confirmation" value="<?php echo $data['user_password_confirmation']; ?>" class="form-control form-control-md <?php echo (!empty($data['user_password_confirmation_err'])) ? 'is-invalid' : ''; ?>">
						<span class="invalid-feedback"><?php echo $data['user_password_confirmation_err']; ?></span>
					</div>
					<div class="row">
						<div class="col">
							<input type="submit" value="Register" name="register" style="background-color: #ffb380;" class="btn btn-block">
						</div>
						<div class="col">
							<a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>