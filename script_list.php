<?php
$mainZoom = get_theme_mod('themolitor_customizer_cat_zoom');
$toggle = get_theme_mod('themolitor_customizer_mapstyle_onoff');
$sitePin = get_theme_mod('themolitor_customizer_pin');

	if(is_search()){
		$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$s = get_query_var('s');
		query_posts('s='.$s.'&paged='.$page);
	}
	if (have_posts()) {
?>
<script type="text/javascript">
//<![CDATA[
jQuery.noConflict(); jQuery(document).ready(function(){

		jQuery('#footer').prepend('<div class="markerNav" title="<?php _e('Prev','themolitor');?>" id="prevMarker"><i class="fa fa-chevron-left"></i></div><div id="markers"></div><div class="markerNav" title="<?php _e('Next','themolitor');?>" id="nextMarker"><i class="fa fa-chevron-right"></i></div><?php if($toggle){ ?><div id="mapTypeContainer"><div id="mapStyleContainer"><div id="mapStyle" class="roadmap"></div></div><div id="mapType" title="<?php _e('Map Type','themolitor');?>" class="roadmap"></div></div><?php } ?>');

        jQuery('body').prepend("<div id='target'></div>");

  //       jQuery("#gMap").addClass('activeMap').gmap3({
  //       	action: 'init',
  //           onces: {
  //             bounds_changed: function(){
  //             	var number = 0;
  //               jQuery(this).gmap3({
  //                 action:'getBounds',
  //                 callback: function (){
  //                 	<?php
  //                 	while (have_posts()) : the_post();

  //                 	//VAR SETUP
  //   				$latitude = get_post_meta( $post->ID, 'themolitor_latitude', TRUE );
		// 			$longitude = get_post_meta( $post->ID, 'themolitor_longitude', TRUE );
		// 			$addrOne = get_post_meta( $post->ID, 'themolitor_address_one', TRUE );
		// 			$addrTwo = get_post_meta( $post->ID, 'themolitor_address_two', TRUE );
		// 			$pin = get_post_meta( $post->ID, 'themolitor_pin', TRUE );

		// 			//LEGACY SUPPORT
		// 			$data = get_post_meta( $post->ID, 'key', true );
		// 			$oldLatitude = $data['latitude'];
		// 			$oldLongitude = $data['longitude'];
		// 			$oldAddrOne = $data['address_one'];
		// 			$oldAddrTwo = $data['address_two'];
		// 			$oldPin = $data['pin'];

		// 			//CHECK FOR LEGACY IF VARS EMPTY
		// 			if($latitude){} elseif($oldLatitude){$latitude = $oldLatitude;}
		// 			if($longitude){} elseif($oldLongitude){$longitude = $oldLongitude;}
		// 			if($addrOne){} elseif($oldAddrOne){$addrOne = $oldAddrOne;}
		// 			if($addrTwo){} elseif($oldAddrTwo){$addrTwo = $oldAddrTwo;}
		// 			if($pin){} elseif($oldPin){$pin = $oldPin;} else {$pin = $sitePin;}

		// 			//GET LAT/LONG FROM ADDRESS
		// 			if (!$latitude && !$longitude && $addrOne && $addrTwo) {
		// 				$addrOneFix = str_replace(" ", "+", $addrOne);
		// 				$addrTwoFix = str_replace(" ", "+", $addrTwo);
		// 				$address = $addrOneFix.'+'.$addrTwoFix;
		// 				$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
		// 				$json = json_decode($geocode);
		// 				$latitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		// 				$longitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		// 			}

  //                 	if($latitude && $longitude){
  //                 	?>
  //                 	add(jQuery(this), number += 1, "<?php the_title(); ?>", "<?php the_permalink() ?>","<?php if($addrOne && $addrTwo){ echo $addrOne.'<br />'.$addrTwo; } ?>","<?php echo $latitude; ?>","<?php echo $longitude; ?>", '<?php the_post_thumbnail(); ?>','<?php echo $pin;?>');<?php } endwhile; ?>
  //                 }
  //               });
  //             }
  //           }
  //         },{
		// 	action: 'setOptions', args:[{
		// 		zoom:<?php echo $mainZoom;?>,
		// 		scrollwheel:true,
		// 		disableDefaultUI:false,
		// 		disableDoubleClickZoom:false,
		// 		draggable:true,
		// 		mapTypeControl:true,
		// 		mapTypeId:'hybrid',
		// 		mapTypeControlOptions: {
  //       			position: google.maps.ControlPosition.LEFT_TOP,
  //       			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
  //   			},
		// 		panControl:false,
		// 		scaleControl:false,
		// 		streetViewControl:true,
		// 		streetViewControlOptions: {
  //       			position: google.maps.ControlPosition.RIGHT_CENTER
  //   			},
		// 		zoomControl:true,
		// 		zoomControlOptions: {
  //       			style: google.maps.ZoomControlStyle.DEFAULT,
  //       			position: google.maps.ControlPosition.RIGHT_CENTER
  //   			}
		// 	}]
		// });
  //       function add(jQuerythis, i, title, link, excerpt, lati, longi, img, pin){
  //         jQuerythis.gmap3({
  //           action : 'addMarker',
  //           lat:lati,
  //           lng:longi,
  //           options: {icon: new google.maps.MarkerImage(pin)},
  //           events:{
  //      			mouseover: function(marker){
  //         			jQuerythis.css({cursor:'pointer'});
  //         			jQuery('#markerTitle'+i+'').stop(true,true).fadeIn({ duration: 200, queue: false }).animate({bottom:"32px"},{duration:200,queue:false});
  //         			jQuery('.markerInfo').removeClass('activeInfo').hide();
  //         			jQuery('#markerInfo'+i+'').addClass('activeInfo').show();
  //         			jQuery('.marker').removeClass('activeMarker');
  //         			jQuery('#marker'+i+'').addClass('activeMarker');
  //     			},
  //      			mouseout: function(){
  //         			jQuerythis.css({cursor:'default'});
  //         			jQuery('#markerTitle'+i+'').stop(true,true).fadeOut(200,function(){jQuery(this).css({bottom:"0"})});
  //     			},
  //     			click: function(marker){window.location = link}
  //  			},
  //           callback: function(marker){
  //             var jQuerybutton = jQuery('<div id="marker'+i+'" class="marker"><div id="markerInfo'+i+'" class="markerInfo"><a class="imgLink" href="'+link+'">'+img+'</a><h2><a href="'+link+'">'+title+'</a></h2><p>'+excerpt+'</p><a class="markerLink" href="'+link+'"><?php _e('View Details','themolitor');?> &rarr;</a><div class="markerTotal">'+i+' / <span></span></div><div class="clear"></div></div></div>');
  //             jQuerybutton.mouseover(function(){
  //                 jQuerythis.gmap3({
  //                   action:'panTo',
  //                   args:[marker.position]
  //                 });
  //                 jQuery("#target").stop(true,true).fadeIn(500).delay(500).fadeOut(500);
  //              });
  //             jQuery('#markers').append(jQuerybutton);
  //             var numbers = jQuery(".markerInfo").length;
  //             jQuery(".markerTotal span, #results span").html(numbers);
  //             if(i == 1){
  //             	jQuery('.marker:first-child').addClass('activeMarker').mouseover();
  //             }
  //             jQuerythis.gmap3({
  //             	action:'addOverlay',
  //             	content: '<div id="markerTitle'+i+'" class="markerTitle">'+title+'</div>',
  //             	latLng: marker.getPosition()
  //              });
  //           }
  //         });
  //       }
});
//]]>
</script>
<?php } else { ?>
<script>
jQuery.noConflict(); jQuery(document).ready(function(){
	jQuery.backstretch("<?php echo get_template_directory_uri();?>/images/Yield_Sign.jpg", {speed: 150});
	jQuery("#results span").html("0");
});
</script>
<?php } ?>