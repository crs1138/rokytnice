<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<input type="image" src="<?php echo get_template_directory_uri(); ?>" id="searchsubmit" alt="GO!" />
	<input type="text" value="<?php _e('Search Site','themolitor');?>" onfocus="this.value=''; this.onfocus=null;" name="s" id="s" />
</form>