$(document).ready(function(){
/*$(".flash-message").fadeIn(2000,function(){
	$('.flash-message').fadeOut(4000,0,function(){
	$(".con").slideDown(1000);
})});*/
function online_friend_chat(){
$.get("http://64.227.113.78/get_instant_data.php?online_friend_chat=result", function(data){
	$(".online_friends_in_chat_room").html(data);
});
}
setInterval(function(){
online_friend_chat();
},1000)
function get_members(){
$.get("http://64.227.113.78/get_instant_data.php?get_members=result", function(data){
	$(".get_members").html(data);
});
}
setInterval(function(){
get_members();
},1000)
$('.message-blue').click('on',function(){
	var message_id = $(this).attr('message-id');
	$('.blue-message-modal').attr('id','my_message_' + message_id);
	var uncomplete_action = $('#delete_for_me').attr('uncomplete-action');
	$('#delete_for_me').attr('action',uncomplete_action + message_id);
	var uncomplete_action2 = $('#delete_for_everyone').attr('uncomplete-action2');
	$('#delete_for_everyone').attr('action',uncomplete_action2 + message_id);
});
$('.message-green').click('on',function(){
	var message_id = $(this).attr('message-id');
	$('.green-message-modal').attr('id','message_' + message_id);
	var uncomplete_action = $('#delete_o_for_me').attr('uncomplete-action');
	$('#delete_o_for_me').attr('action',uncomplete_action + message_id);
});
$('.custom-file-input').on('click',function(){
	console.log($(this).val());
});
$(".chat-section").animate({ scrollTop: '100000000px' });
  return false;
});