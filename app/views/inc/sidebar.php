<?php
$user = new Users();
$friendship_requests = $user->selectFriendshipRequests();
$friendship_requests_count = $user->selectFriendshipRequestsCount();
$like = new Profilelikes();
$dislike = new Profiledislikes();
?>
<style>
.pro-img {
    margin-top: -80px;
    margin-bottom: 20px
}

.little-profile .pro-img img {
    width: 108px;
    height: 108px;
    -webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    border-radius: 100%
}
.btn-rounded.btn-md {
    padding: 12px 35px;
    font-size: 16px
}
.btn-primary,
.btn-primary.disabled {
    background: #7460ee;
    border: 1px solid #7460ee;
    -webkit-box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
    box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
    -webkit-transition: 0.2s ease-in;
    -o-transition: 0.2s ease-in;
    transition: 0.2s ease-in
}

.btn-rounded {
    border-radius: 60px;
    padding: 7px 18px
}

.m-t-20 {
    margin-top: 20px
}

.text-center {
    text-align: center !important
}
</style>
        <!-- Column -->
<div class="card"> <img height="110" class="card-img-top" src="<?php echo pbi_image($data['logged_in_user']);?>" alt="Card image cap">
    <div class="card-body little-profile text-center">
        <div class="pro-img"><img src="<?php echo profile_image($data['logged_in_user']);?>" alt="user"></div>
        <h4 class=""><?php echo $data['logged_in_user']->user_first_name . " " . $data['logged_in_user']->user_last_name; ?></h4>
        <small class="text-muted" style="color:rgb(204, 170, 255);">Web Designer &amp; Developer</small>
        <div class="row text-center mt-2 mb-0">
            <div class="col">
            <?php if($data['logged_in_user']->feel_better_count >= 1): ?>
            <p class="" style="color:rgb(255, 179, 128);">
                <i class="fas fa-hand-holding-heart"></i><br>
                You made <?php echo $data['logged_in_user']->feel_better_count; ?> people feel better.</p>
            <?php endif ?>
            </div>
            <div class="col">
                <?php if($data['logged_in_user']->feel_better_count >= 1): ?>
                <p style="color: rgb(204, 170, 255);">
                <i class="far fa-hand-paper"></i><br>
                <?php echo $data['logged_in_user']->relates_count; ?> people related to your participations.</p>
                <?php endif ?>
            </div>
        </div>
    </div>
</div><br>
    <div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Challenge !</h4></p>
  <p class="mb-0">Want to support people. create a gathering</p>
  <p class="mb-0">Want to get help. join a gathering</p>
  <p class="mb-0">Want to share your thoughts. publish a new participation</p>
</div>