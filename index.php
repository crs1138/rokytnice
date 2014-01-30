<?php 
$id = get_option('themolitor_welcome_page');
get_header();
/////////////////
//WELCOME CONTENT
/////////////////
if(isset($id)){
$page_data = get_page($id);
$pageContent = apply_filters('the_content', $page_data->post_content);
$showPostsInCategory = null;    	
$showPostsInCategory = new WP_Query(); 
$showPostsInCategory->query('showposts=1&post_type=page&page_id='.$id);
if ($showPostsInCategory->have_posts()) : while ($showPostsInCategory->have_posts()) : $showPostsInCategory->the_post();	
?>
<div id="contentContainer">
	<div id="content">
		<div id="main">
			<div id="handle"></div>
			<div id="closeBox"></div>
			<h2 class="entrytitle"><?php the_title(); ?></h2>	
			<div class="entry"><?php the_content(); ?></div>
		</div><!--end main-->
		<div class="clear"></div>
	</div><!--end content-->
</div><!--end contentContainer-->
<?php
endwhile; endif;
$showPostsInCategory = null;
wp_reset_postdata();
}//END WELCOME CONTENT
get_template_part('script');	
get_footer(); 
?>