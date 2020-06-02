<?php
$core = new Core();
$url = $core->getUrl();
$user = new Users();
$online = $user->online();
$user = new Users();
$user_time = $user->userTime();
?>
<nav class="navbar navbar-expand-xl navbar-light fixed-top mb-5" style="background-color: white;-webkit-box-shadow: 0px 1px 24px -8px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 1px 24px -8px rgba(0,0,0,0.75);
box-shadow: 0px 1px 24px -8px rgba(0,0,0,0.75);">
      <a class="navbar-brand" href="<?php echo URLROOT; ?>">
        <img src="<?php echo URLROOT; ?>/images/website_images/website_logo45.png" width="30" height="30" class="d-inline-block align-top" alt="">
        <?php echo substr(SITENAME,0,8); ?>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?php echo ($url[0] == "" || ($url[0] == "pages" && $url[1] == "index")) ? "active" : ""; ?>">
            <a class="nav-link" href="<?php echo URLROOT; ?>"><i class="fa fa-home"></i> Home</a>
          </li>
            <li class="nav-item <?php echo ($url[0] == "posts" && $url[1] == "add") ? "active" : ""; ?>">
            <a class="nav-link" href="<?php echo URLROOT; ?>/posts/add" style="cursor: pointer;">
              <i class="fa fa-plus" style="font-size: 14px;"></i> Participate
            </a>
          </li>
          <li class="nav-item <?php echo ($url[0] == "posts" && $url[1] == "add") ? "active" : ""; ?>">
            <a class="nav-link" href="<?php echo URLROOT; ?>/posts/adiary" style="cursor: pointer;">
              <i class="fas fa-edit" style="font-size: 14px;"></i> New diary
            </a>
          </li>
          <li class="nav-item <?php echo ($url[0] == "posts" && $url[1] == "add") ? "active" : ""; ?>">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/showmydiaries" style="cursor: pointer;">
              <i class="fas fa-newspaper" style="font-size: 14px;"></i> My diaries
            </a>
          </li>
          <li class="nav-item <?php echo ($url[0] == "posts" && $url[1] == "add") ? "active" : ""; ?>">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/showmyparticipations" style="cursor: pointer;">
              <i class="fa fa-list" style="font-size: 14px;"></i> My participations
            </a>
          </li>
          <li class="nav-item <?php echo ($url[0] == "posts" && $url[1] == "add") ? "active" : ""; ?>">
            <a class="nav-link" href="<?php echo URLROOT; ?>/groups/add" style="cursor: pointer;">
              <i class="fa fa-plus" style="font-size: 14px;"></i> New gathering
            </a>
          </li>
          <li class="nav-item <?php echo ($url[0] == "posts" && $url[1] == "add") ? "active" : ""; ?>">
            <a class="nav-link" href="<?php echo URLROOT; ?>/groups/readgroups" style="cursor: pointer;">
              <i class="fa fa-users" style="font-size: 14px;"></i> Gatherings
            </a>
          </li>
          <li class="nav-item <?php echo ($url[0] == "users" && $url[1] == "logout") ? "active" : ""; ?>">
              <a href="<?php echo URLROOT . "/users/logout"; ?>" class="nav-link"><i class="fa fa-sign-out"></i> logout</a>
          </li>
        </ul>
      </ul>
      </div>
    </nav>