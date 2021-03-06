<?php get_header();?>

<div id="contentContainer">
<div id="content">

<div id="main">
	<div id="handle"></div>
	<div id="closeBox"></div>
	<?php
	if(is_search()){
	  $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
	  $s = get_query_var('s');
	  query_posts('s='.$s.'&paged='.$page);
	}
	if (have_posts()) : ?>

	<h2 class="entrytitle"><?php _e('Search Results','themolitor');?></h2>
	<div class="clear"></div>

	<div class="listing">
		<p id="results">
		</p>

			<?php
			$crs_index = 0;
			$sitePin = get_theme_mod('themolitor_customizer_pin');

			while (have_posts()) : the_post();
			$post_pin = get_post_meta( $post->ID, 'themolitor_pin', TRUE );
			// OLD LEGACY SUPPORT
			$data = get_post_meta( $post->ID, 'key', true );
			$oldPin = $data['pin'];

			if($post_pin){} elseif($oldPin){$post_pin = $oldPin;} else {$post_pin = $sitePin;}
			 ?>
				<div id="post-<?php the_ID(); ?>" class="post">
					<a class="blogThumb" href="<?php the_permalink();?>"><?php echo '<img src="' . $post_pin . '" alt="" />';
    					?></a>
					<h2 id="title<?php echo $crs_index; ?> "class="blogTitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h2>

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