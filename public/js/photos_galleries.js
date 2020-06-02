$(document).ready(function(){
$('.profile_gallery_section').hide();
$('.posts_gallery_section').hide();
$('.profile_gallery').click(function() {
	$('.profile_gallery_section').show();
	$('.posts_gallery_section').hide();
	$('.personal_gallery_section').hide();
});
$('.posts_gallery').click(function() {
	$('.posts_gallery_section').show();
	$('.profile_gallery_section').hide();
	$('.personal_gallery_section').hide();
});
$('.personal_gallery').click(function() {
	$('.personal_gallery_section').show();
	$('.profile_gallery_section').hide();
	$('.posts_gallery_section').hide();
});
var u_images_1 = $(".u_images_1").attr('src');
$('.big_u_image').attr('src', u_images_1);
$('.u_images').click(function() {
	var e = $(this).attr('src');      
	$('.big_u_image').attr('src', e);
});
var posts_images_1 = $(".posts_images_1").attr('src');
$('.big_posts_image').attr('src', posts_images_1);
$('.posts_images').click(function() {
	var f = $(this).attr('src');      
	$('.big_posts_image').attr('src', f);
});
var personal_images_1 = $(".personal_images_1").attr('src');
$('.big_personal_image').attr('src', personal_images_1);
$('.personal_images').click(function() {
	var f = $(this).attr('src');      
	$('.big_personal_image').attr('src', f);
});
$('.u_images').hover(function() {
	var image_id = $(this).attr('u-image-id');
	$('.delete-u-images-' + image_id).css({'display': 'block',
	'position': 'absolute',
	'top': '5px',
	'right': '20px'});
},function(){
	var image_id = $(this).attr('u-image-id');
	$('.delete-u-images-' + image_id).css('display' , 'none');
});
$('.delete-u-images').hover(function() {
	$(this).css({'display': 'block',
	'position': 'absolute',
	'top': '5px',
	'right': '20px'});
});
$('.posts_images').hover(function() {
	var image_id = $(this).attr('posts-image-id');
	$('.delete-posts-images-' + image_id).css({'display': 'block',
	'position': 'absolute',
	'top': '5px',
	'right': '20px'});
},function(){
	var image_id = $(this).attr('posts-image-id');
	$('.delete-posts-images-' + image_id).css('display' , 'none');
});
$('.delete-posts-images').hover(function() {
	$(this).css({'display': 'block',
	'position': 'absolute',
	'top': '5px',
	'right': '20px'});
});
$('.personal_images').hover(function() {
	var image_id = $(this).attr('personal-image-id');
	$('.delete-personal-images-' + image_id).css({'display': 'block',
	'position': 'absolute',
	'top': '5px',
	'right': '20px'});
},function(){
	var image_id = $(this).attr('personal-image-id');
	$('.delete-personal-images-' + image_id).css('display' , 'none');
});
$('.delete-personal-images').hover(function() {
	$(this).css({'display': 'block',
	'position': 'absolute',
	'top': '5px',
	'right': '20px'});
});
});