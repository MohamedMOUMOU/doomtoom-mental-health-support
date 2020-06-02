$(document).ready(function(){
/*$(".flash-message").fadeIn(2000,function(){
	$('.flash-message').fadeOut(4000,0,function(){
	$(".con").slideDown(1000);
})});*/
// $("#image-posts").hover(function(){
// 	$(this).css("zIndex","20");
// 	$(this).animate({height:"+=20px"},1000);
// },function(){
// 	$(this).animate({height:"-=20px"},1000);
// });
function loggedin(){
$.get("http://64.227.113.78/get_instant_data.php?check=result", function(data){
	$(".loggedin").html(data);
});
}
setInterval(function(){
loggedin();
},1000)
function onlineusers(){
$.get("http://64.227.113.78/get_instant_data.php?onlineuserscount=result", function(data){
	$(".onlinefriendscount").html(data);
});
}
setInterval(function(){
onlineusers();
},1000)
function offlineusers(){
$.get("http://64.227.113.78/get_instant_data.php?offlineuserscount=result", function(data){
	$(".offlinefriendscount").html(data);
});
}
setInterval(function(){
offlineusers();
},1000)
function offlineuser(){
$.get("http://64.227.113.78/get_instant_data.php?offlineuser=result", function(data){
});
}
setInterval(function(){
offlineuser();
},1000)
function onlineFriends(){
$.get("http://64.227.113.78/get_instant_data.php?onlinefriends=result", function(data){
	$(".onlinefriends").html(data);
});
}
setInterval(function(){
onlineFriends();
},1000)
function offlineFriends(){
$.get("http://64.227.113.78/get_instant_data.php?offlinefriends=result", function(data){
	$(".offlinefriends").html(data);
});
}
setInterval(function(){
offlineFriends();
},1000)
ClassicEditor
  .create( document.querySelector( '#editor' ) )
  .catch( error => {
  console.error( error );
});
});