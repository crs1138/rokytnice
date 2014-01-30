<?php get_header(); ?>

<div id="contentContainer">
<div id="content">

<div id="main">
	<div id="handle"></div>
	<div id="closeBox"></div>
	<h2><?php _e('Not Found','themolitor');?></h2>
	<p><?php _e('The page you were looking for does not exist.','themolitor');?><br />
</div><!--end main-->

<div class="clear"></div>
</div><!--end content-->
</div><!--end contentContainer-->

<script>
jQuery.noConflict(); jQuery(document).ready(function(){
	//LOADS FULLSCREEN IMAGE
	jQuery.backstretch("<?php echo get_template_directory_uri();?>/images/Yield_Sign.jpg", {speed: 150});
});
</script>

<?php get_footer(); ?>