<?php
//VAR SETUP
$rss = get_theme_mod('themolitor_customizer_rss_onoff');
$skype = get_theme_mod('themolitor_customizer_skype');
$flickr = get_theme_mod('themolitor_customizer_flickr');
$instagram = get_theme_mod('themolitor_customizer_instagram');
$linkedin = get_theme_mod('themolitor_customizer_linkedin');
$youtube = get_theme_mod('themolitor_customizer_youtube');
$vimeo = get_theme_mod('themolitor_customizer_vimeo');
$googlePlus = get_theme_mod('themolitor_customizer_google');
$pinterest = get_theme_mod('themolitor_customizer_pinterest');
$facebook = get_theme_mod('themolitor_customizer_facebook');
$twitter = get_theme_mod('themolitor_customizer_twitter');
$widgets = get_theme_mod('themolitor_customizer_widgets_onoff');
$id = get_option('themolitor_welcome_page');
?>

<div id="footer">
		
	<?php if(!empty($widgets)){ ?>
	<a href="#" id="widgetsOpen" title="<?php _e('More','themolitor');?>" class="widgetsToggle">+</a>
	<a href="#" id="widgetsClose" title="<?php _e('Close','themolitor');?>" class="widgetsToggle">&times;</a>	
	<?php }
	
	if(is_single()){
		next_post_link('%link', '<i class="fa fa-chevron-left"></i>', TRUE); 
		previous_post_link('%link', '<i class="fa fa-chevron-right"></i>', TRUE);
	}?>

	<div class="pageContent">
		<?php if(is_front_page() && !$id == ''){?>
		<h2><?php echo get_the_title($id); ?></h2>
		<?php } elseif(is_single() || is_page()) { ?>
		<h2><?php the_title(); ?></h2>
		<?php } elseif(is_404()) { ?>
		<h2><?php _e('404 Error','themolitor');?></h2>
		<?php } elseif(is_search()) { ?>
		<h2><?php _e('Search Results','themolitor');?></h2>
		<?php } elseif(is_category()) { ?>
		<h2><?php single_cat_title(); ?></h2>
		<?php } elseif( is_tag() ) { ?>
		<h2><?php single_tag_title(); ?></h2>
		<?php } elseif (is_day()) { ?>
		<h2><?php _e('Archive for','themolitor');?> <?php the_time('F jS, Y'); ?></h2>
		<?php } elseif (is_month()) { ?>
		<h2><?php _e('Archive for','themolitor');?> <?php the_time('F, Y'); ?></h2>
		<?php } elseif (is_year()) { ?>
		<h2><?php _e('Archive for','themolitor');?> <?php the_time('Y'); ?></h2>
		<?php } elseif (is_author()) { ?>
		<h2><?php _e('Author Archive','themolitor');?></h2>
		<?php } ?>
	</div>
	
	<?php if (!empty($rss) || !empty($skype) || !empty($googlePlus) || !empty($pinterest) || !empty($instagram) || !empty($flickr) || !empty($linkedin) || !empty($youtube) || !empty($vimeo) || !empty($facebook) || !empty($twitter)) { ?>
	<div id="socialStuff">
		<?php if (!empty($rss)) { ?>
			<a class="socialicon" id="rssIcon" href="<?php bloginfo('rss2_url'); ?>"  title="<?php _e('RSS Feed','themolitor');?>" rel="nofollow"><i class="fa fa-rss-square"></i></a>
		<?php } if (!empty($skype)) { ?>
			<a class="socialicon" id="skypeIcon" href="<?php echo $skype; ?>"  title="Skype" rel="nofollow"><i class="fa fa-skype"></i></a>
		<?php } if (!empty($flickr)) { ?>
			<a class="socialicon" id="flickrIcon" href="<?php echo $flickr; ?>"  title="Flickr" rel="nofollow"><i class="fa fa-flickr"></i></a>
		<?php } if (!empty($instagram)) { ?>
			<a class="socialicon" id="instagramIcon" href="<?php echo $instagram; ?>"  title="Instagram" rel="nofollow"><i class="fa fa-instagram"></i></a>
		<?php } if (!empty($linkedin)) { ?>
			<a class="socialicon" id="linkedinIcon" href="<?php echo $linkedin; ?>"  title="LinkedIn" rel="nofollow"><i class="fa fa-linkedin-square"></i></a>
		<?php } if (!empty($youtube)) { ?> 
			<a class="socialicon" id="youtubeIcon" href="<?php echo $youtube; ?>" title="YouTube"  rel="nofollow"><i class="fa fa-youtube-square"></i></a>
		<?php } if (!empty($vimeo)) { ?> 
			<a class="socialicon" id="vimeoIcon" href="<?php echo $vimeo; ?>"  title="Vimeo" rel="nofollow"><i class="fa fa-vimeo-square"></i></a>
		<?php } if (!empty($pinterest)) { ?> 
			<a class="socialicon" id="pinterestIcon" href="<?php echo $pinterest; ?>"  title="Pinterest" rel="nofollow"><i class="fa fa-pinterest-square"></i></a>
		<?php } if (!empty($googlePlus)) { ?> 
			<a class="socialicon" id="gplusIcon" href="<?php echo $googlePlus; ?>"  title="Google Plus" rel="nofollow"><i class="fa fa-google-plus-square"></i></a>
		<?php } if (!empty($facebook)) { ?> 
			<a class="socialicon" id="facebookIcon" href="<?php echo $facebook; ?>"  title="Facebook" rel="nofollow"><i class="fa fa-facebook-square"></i></a>
		<?php } if (!empty($twitter)) { ?> 
			<a class="socialicon" id="twitterIcon" href="<?php echo $twitter; ?>" title="Twitter"  rel="nofollow"><i class="fa fa-twitter-square"></i></a>
		<?php } ?>
	</div>
	<?php } ?>
	
	<div id="copyright">
	<!--IMPORTANT! DO NOT REMOVE GOOGLE NOTICE-->
	&copy; <?php echo date('Y '); bloginfo('name'); ?>. <?php _e('Map by Google.');?> 
	<!--IMPORTANT! DO NOT REMOVE GOOGLE NOTICE-->
	</div>	

</div><!--end footer-->

<?php 
get_sidebar();
wp_footer(); 
?>

</body>
</html>