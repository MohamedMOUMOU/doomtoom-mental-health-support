<?php
if(isset($_GET['check'])) {
	require_once '../app/libraries/Controller.php';
	require_once '../app/config/config.php';
	require_once '../app/libraries/Database.php';
	require_once '../app/controllers/Users.php';
	session_start();
     $logged = new Users();
     $result = $logged->instantLoggedInUserData();
     echo $result;
}
if(isset($_GET['offlineuser'])) {
	require_once '../app/libraries/Controller.php';
	require_once '../app/config/config.php';
	require_once '../app/libraries/Database.php';
	require_once '../app/controllers/Users.php';
	session_start();
	$fuser = new Users();
	$result = $fuser->offlineUser();
	return $result;
}
if(isset($_GET['onlineuserscount'])) {
	require_once '../app/libraries/Controller.php';
	require_once '../app/config/config.php';
	require_once '../app/libraries/Database.php';
	require_once '../app/controllers/Users.php';
	session_start();
	$onlineusers = new Users();
	$result = $onlineusers->getUsersOnlineCount();
	echo $result;
}
if(isset($_GET['offlineuserscount'])) {
	require_once '../app/libraries/Controller.php';
	require_once '../app/config/config.php';
	require_once '../app/libraries/Database.php';
	require_once '../app/controllers/Users.php';
	session_start();
	$offlineusers = new Users();
	$result = $offlineusers->getUsersOfflineCount();
	echo $result;
}
if(isset($_GET['onlinefriends'])) {
	require_once '../app/libraries/Controller.php';
	require_once '../app/config/config.php';
	require_once '../app/libraries/Database.php';
	require_once '../app/controllers/Users.php';
	session_start();
	$online_friends = new Users();
	$result = $online_friends->getOnlineFriends();
	echo $result;
}
if(isset($_GET['offlinefriends'])) {
	require_once '../app/libraries/Controller.php';
	require_once '../app/config/config.php';
	require_once '../app/libraries/Database.php';
	require_once '../app/controllers/Users.php';
	session_start();
	$offline_friends = new Users();
	$result = $offline_friends->getOfflineFriends();
	echo $result;
}
if(isset($_GET['online_friend_chat'])) {
	require_once '../app/libraries/Controller.php';
	require_once '../app/config/config.php';
	require_once '../app/helpers/manage_dates.php';
	require_once '../app/helpers/manage_urls.php';
	require_once '../app/libraries/Database.php';
	// require_once '../app/views/inc/header.php';
	require_once '../app/libraries/Core.php';
	require_once '../app/controllers/Users.php';
	session_start();
	$user = new Users();
	$online_friend_chat = $user->get_friends();
	echo $online_friend_chat;
}
if(isset($_GET['get_members'])) {
	require_once '../app/libraries/Controller.php';
	require_once '../app/config/config.php';
	require_once '../app/libraries/Database.php';
	require_once '../app/controllers/Groups.php';
	session_start();
	$group = new Groups();
	$get_members = $group->get_members();
	echo $get_members;
}
?>