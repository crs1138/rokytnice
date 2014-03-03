<?php get_header();?>

<div id="contentContainer">
<div id="content">

<div id="main">
	<div id="handle"></div>
	<div id="closeBox"></div>

	<?php if (have_posts()) : ?>

	<h2 class="entrytitle"><?php _e('Search Results','themolitor');?></h2>
	<div class="clear"></div>

	<div class="listing">
		<p id="results">
			<?php _e('Search returned','themolitor');?><span></span> <?php _e('listing(s)','themolitor');?>...
		</p>

			<?php
			$crs_index = 0;
			while (have_posts()) : the_post();
			$post_pin = get_post_meta( $post->ID, 'themolitor_pin', TRUE );
			 ?>
				<div id="post-<?php the_ID(); ?>" class="post">
					<a class="blogThumb" href="<?php the_permalink();?>"><?php echo '<img src="' . $post_pin . '" alt="" />';
    					?></a>
					<h2 id="title<?php echo $crs_index; ?> "class="blogTitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h2>

					<p class="blogMeta"><?php _e('Posted','themolitor');?> <?php the_date();?>&nbsp; / &nbsp; <?php _e('By','themolitor');?> <?php the_author();?>&nbsp; / &nbsp;<?php comments_number(__('0 Comments','themolitor'), __('1 Comment','themolitor'), __('% Comments','themolitor')); ?></p>
	    			<p><?php the_excerpt(); ?></p>
	    			<div class="clear"></div>
	    		</div>

				<?php $crs_index++;
		endwhile;
		else: ?>
		<p><?php _e("Sorry, your search didn't return any listings. Try again?",'themolitor');?></p>

		<script>
		jQuery.noConflict(); jQuery(document).ready(function(){
			jQuery.backstretch("<?php echo get_template_directory_uri();?>/images/Yield_Sign.jpg", {speed: 150});
		});
		</script>
	<?php endif; ?>


	</div><!--end listing-->

</div><!--end main-->

<div class="clear"></div>
</div><!--end content-->
</div><!--end contentContainer-->

<?php
get_template_part('script_list');
get_footer();
?>