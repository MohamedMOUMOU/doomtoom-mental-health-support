<?php
function manage_urls(){
	if(isset($_GET['url'])){
		$url_array = explode('/',$_GET['url']);
		return $url_array;
	}else{
		return false;
	}
}
?>