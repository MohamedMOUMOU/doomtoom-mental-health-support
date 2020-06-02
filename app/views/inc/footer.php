<script src="https://use.fontawesome.com/af66a1bb2a.js"></script>
<script type="text/javascript" src="<?php echo URLROOT; ?>\node_modules\@ckeditor\ckeditor5-build-classic\build\ckeditor.js"></script>
<script type="text/javascript" src="<?php echo URLROOT; ?>\node_modules\jquery\dist\jquery.js"></script>
<script src="<?php echo URLROOT; ?>\node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo URLROOT; ?>\node_modules\slick-carousel\slick\slick.min.js"></script>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/main.js"></script>
<?php
if($url[0] == "photosgalleries" && $url[1] == "show"){
	echo "<script type='text/javascript' src='" . URLROOT . "/js/photos_galleries.js'></script>";
}
?>
<?php
if($url[0] == "posts" && $url[1] == "edit"){
	echo "<script type='text/javascript' src='" . URLROOT . "/js/edit_post.js'></script>";
}
if(($url[0] == "groups" && $url[1] == "joingroup") || ($url[0] == "chats" && $url[1] == "read")){
	echo "<script type='text/javascript' src='" . URLROOT . "/js/chat.js'></script>";
}
?>
</body>
</html>