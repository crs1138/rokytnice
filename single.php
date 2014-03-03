<?php
get_header();


class Marker {
  public $data;
  public $tag;
  public $latLng = array();
  public $options;

  public function __construct($latitude, $longitude, $title, $permalink, $pin, $excerpt, $kml=null) {
    $this->latLng  = array( $latitude, $longitude );
    $this->data = $title;
    $this->tag = $permalink;
    $this->options = (object) array(
      "icon" => $pin
      );
    $this->excerpt = $excerpt;
    $this->kml = $kml;
  }

  public function get_marker_coords (){
    return "{latLng: [" . $this->latLng['latitude'] . ", " . $this->latLng['longitude'] . "], data: " . $this->title . "}";
  }

}

//VAR SETUP
$crumbs = get_theme_mod('themolitor_customizer_bread_onoff');
$siteBg = get_theme_mod('themolitor_customizer_background_url');
$toggle = get_theme_mod('themolitor_customizer_mapstyle_onoff');
$zoomOn = get_theme_mod('themolitor_customizer_mapzoom_onoff');
$postZoom = get_theme_mod('themolitor_customizer_post_zoom');
$blogCat = get_option('themolitor_blog_category');
$twitter = get_theme_mod('themolitor_customizer_twitter');
$sitePin = get_theme_mod('themolitor_customizer_pin');
?>

<div id="contentContainer">
<div id="content">

<div id="main" <?php if($blogCat && in_category($blogCat)){ ?>class="blog"<?php } ?>>

	<div id="handle"></div>
	<div id="closeBox"></div>

	<?php if (have_posts()) : while (have_posts()) : the_post();
	//VAR SETUP
	$zoom = get_post_meta( $post->ID, 'themolitor_zoom', TRUE );
	$latitude = get_post_meta( $post->ID, 'themolitor_latitude', TRUE );
	$longitude = get_post_meta( $post->ID, 'themolitor_longitude', TRUE );
	$addrOne = get_post_meta( $post->ID, 'themolitor_address_one', TRUE );
	$addrTwo = get_post_meta( $post->ID, 'themolitor_address_two', TRUE );
	$pin = get_post_meta( $post->ID, 'themolitor_pin', TRUE );
	$bg = get_post_meta( $post->ID, 'themolitor_bg_img', TRUE );

	$kml = get_post_meta( $post->ID, 'themolitor_kml_layer', TRUE );
	// $kml = 'http://planxdesign.eu/gmap/testing-circuit.kml';

	//LEGACY SUPPORT
	$data = get_post_meta( $post->ID, 'key', true );
	$oldZoom = $data['zoom'];
	$oldLatitude = $data['latitude'];
	$oldLongitude = $data['longitude'];
	$oldAddrOne = $data['address_one'];
	$oldAddrTwo = $data['address_two'];
	$oldPin = $data['pin'];
	$oldBg = $data['bg_img'];

	//CHECK FOR LEGACY IF VARS EMPTY
	if($zoom){} elseif($oldZoom){$zoom = $oldZoom;} else {$zoom = $postZoom;}
	if($latitude){} elseif($oldLatitude){$latitude = $oldLatitude;}
	if($longitude){} elseif($oldLongitude){$longitude = $oldLongitude;}
	if($addrOne){} elseif($oldAddrOne){$addrOne = $oldAddrOne;}
	if($addrTwo){} elseif($oldAddrTwo){$addrTwo = $oldAddrTwo;}
	if($pin){} elseif($oldPin){$pin = $oldPin;} else {$pin = $sitePin;}
	if($bg){} elseif($oldBg){$bg = $oldBg;} else {$bg = $siteBg;}

	//GET LAT/LONG FROM ADDRESS
	if (!$latitude && !$longitude && $addrOne && $addrTwo) {
		$addrOneFix = str_replace(" ", "+", $addrOne);
		$addrTwoFix = str_replace(" ", "+", $addrTwo);
		$address = $addrOneFix.'+'.$addrTwoFix;
		$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
		$json = json_decode($geocode);
		$latitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$longitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	}
	?>


	<div  <?php post_class(); ?>>

		<h2 class="posttitle"><?php the_title(); ?><?php edit_post_link(' <small>&#9997;</small>','',' '); ?></h2>

		<?php if ($crumbs && function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>




		<div class="entry">
			<?php
			if ($addrOne && $addrTwo) {
				echo '<p id="postAddr">'.$addrOne.'<br />';
				echo $addrTwo.'<br /><em><a id="myDirections" title="'. __('Get Directions','themolitor').'" href="#">'. __('Get Directions','themolitor').' &rarr;</a></em></p>';
			} elseif ($latitude && $longitude) {
				echo '<br /><em><a id="myDirections" title="'. __('Get Directions','themolitor').'" href="#">'. __('Get Directions','themolitor').' &rarr;</a></em></p>';

			}

			the_content();
			?>
       	</div><!--end entry-->

		<?php
		$args = array('post_type' => 'attachment','post_mime_type' => 'image' ,'post_status' => null, 'post_parent' => $post->ID);
		$attachments = get_posts($args);
		if ($attachments) {
		?>
			<div id="galleryToggle" class="toggleButton closed"><span>+</span><?php _e('Gallery','themolitor');?></div>
			<ul class="galleryBox">
	       		<?php attachment_toolbox('small'); ?>
	        </ul>
		<?php }

		//RELATED STUFF
		$original_post = $post;
		$tags = wp_get_post_tags($post->ID);
		$showtags = 10;
		if (!empty($tags)) {
			$first_tag = $tags[0]->term_id;
			$tagname = $tags[0]->name;
			$args=array(
				'tag__in' => array($first_tag),
				'post__not_in' => array($post->ID),
				'caller_get_posts'=>1
			);
			$my_query = new WP_Query($args);
			if( $my_query->have_posts() ) { ?>

				<div id="relatedToggle" class="toggleButton"><span>+</span><?php _e('Related','themolitor');?></div>
		       	<div id="related">
					<ul>
						<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
						<li><a class="tooltip" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'small' ); ?></a></li>
						<?php endwhile; ?>

					</ul>
				<?php
				//DISPLAYS VIEW ALL LINK IF RELATED POSTS EXCEEDS $shotags+1
				$count = get_tags('include='.$first_tag.'');
				if (!empty($count) && !empty($tags)) {
					foreach ($count as $tag) {
					?>
					<p id="relatedItemsLink"><a class="tooltip" title="<?php _e('Items Tagged','themolitor');?> '<?php echo $tagname; ?>' (<?php echo $tag->count; ?>)" href="<?php echo get_tag_link($first_tag); ?>"><em><?php _e('View Map of Related Items','themolitor');?> &rarr;</em></a></p>
				<?php }}?>

				</div><!--end related-->
			<?php  }}
			$post = $original_post;
			wp_reset_query();
			?>



		<?php if ('open' == $post->comment_status) : ?>
			<div id="commentToggle" class="toggleButton closed"><span>+</span><?php comments_number( __('Comments','themolitor'), __('1 Comment','themolitor'), __('% Comments','themolitor') ); ?></div>
	        <div class="clear" id="commentsection">
				<?php comments_template(); ?>
	        </div>
        <?php endif;?>

	</div><!--end post-->

<?php if($latitude && $longitude){
	$title = get_the_title();
	$permalink = get_permalink();
	$excerpt = get_the_excerpt();

	$single_marker = new Marker ($latitude, $longitude, $title, $permalink, $pin, $excerpt, $kml);
	$markers[] = $single_marker;
?>
<script>
/* Pass the array of markers from PHP to JS to be processed in gmap3() later on.
  IN: PHP array of object of Marker class
  OUT: JS array of objects suitable for markers values in GMAP3.
*/
var markersJSON = '<?php echo json_encode($markers); ?>';
var crs_markersJS = jQuery.parseJSON(markersJSON);
console.log('crs_markersJS: ', crs_markersJS);
//START MAP
jQuery.noConflict(); jQuery(document).ready(function(){

	<?php if($toggle){ ?>jQuery("#footer").append('<div id="mapTypeContainer"><div id="mapStyleContainer" class="gradientBorder"><div id="mapStyle"></div></div><div id="mapType" class="roadmap"></div></div>');<?php } ?>

	var crs_gMap = jQuery("#gMap"); // create jQ object for the map

	crs_gMap.addClass('activeMap').gmap3({
    	map:{
	     	center: true,
			options: {
				// center: [<?php echo $latitude; ?>,<?php echo $longitude; ?>],
				center: crs_markersJS[0].latLng,
				zoom: <?php echo $zoom;?>,
				scrollwheel:true,
				disableDefaultUI:false,
				disableDoubleClickZoom:false,
				draggable:true,
				mapTypeControl:true,
				mapTypeId:'satellite',
				mapTypeControlOptions: {
					position: google.maps.ControlPosition.LEFT_TOP,
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
				},
				panControl:false,
				scaleControl:false,
				streetViewControl:true,
				streetViewControlOptions: {
					position: google.maps.ControlPosition.RIGHT_CENTER
				},
				zoomControl:true,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.DEFAULT,
					position: google.maps.ControlPosition.RIGHT_CENTER
				}
			}
   		},
		marker:{
			values: crs_markersJS,
		    events: {
		      mouseover: function(marker,event,context){
		        var $this = jQuery(this);
		        var map = $this.gmap3("get"),
		        infowindow = $this.gmap3({get:{name:"infowindow"}});
		        if (infowindow){
		            infowindow.open(map, marker);
		            infowindow.setContent(context.data);
		        } else {
		            $this.gmap3({
		            infowindow:{
		                    anchor:marker,
		                    options:{content: context.data}
		                }
		            });
		        }
		      }, // mouseover end
		      mouseout: function() {
		        var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
		        if (infowindow){
		          infowindow.close();
		        }
		              
		      } //mouseout end
		    }, // events end
			options:{
		   		icon: new google.maps.MarkerImage('<?php echo $pin;?>')
		 	}
		},
   		kmllayer:{
   			options:{
   				url: crs_markersJS[0].kml,
   				// url: "http://planxdesign.eu/gmap/testing-circuit.kml",
   				opts:{
   					preserveViewport: true
   				}
   			}
   		}
	}); // end gMap.init
	console.log('crs_markersJS[0].kml: ', crs_markersJS[0].kml );
	// Get Directions on click #myDirections
	jQuery(document).on('click', '#myDirections', function(event){
		event.preventDefault ? event.preventDefault() : event.returnValue = false;

		crs_gMap.gmap3({
			getgeoloc: { // get visitor's latLng
				callback: function(getLatLng){ // pass visitor's latLng to getroute
					if (getLatLng) {
						// use my geolocation (latLng) in getroute
						jQuery(this).gmap3({
							getroute: { //get route data
								options: {
									origin: getLatLng,
									destination: crs_markersJS[0].latLng,
									travelMode: google.maps.DirectionsTravelMode.DRIVING
								},
								callback: function(results){ // pass result of route data to renderer
									if( !results ) return;
									jQuery(this).gmap3({ //render route
										map: {
											options: {
												center: getLatLng
											}
										},
										directionsrenderer: {
											container: jQuery('<div id="directionContainer"></div>').addClass('googlemap').insertAfter('#postAddr'),
											options: {
												directions: results
											}
										}
									});
								}
							}
						});
					}
				}
			}
		});
	});


}); // end document.ready
</script>
<?php } else { ?>
<script>
jQuery.noConflict(); jQuery(document).ready(function(){
	jQuery.backstretch("<?php echo $bg; ?>", {speed: 150});
});
</script>
<?php }

endwhile; endif; ?>

</div><!--end main-->

<div class="clear"></div>
</div><!--end content-->
</div><!--end contentContainer-->

<?php get_footer(); ?>