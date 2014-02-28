<script type="text/javascript">

<?php
  class Marker {
    public $data;
    public $tag;
    public $latLng = array();
    public $options;

    public function __construct($latitude, $longitude, $title, $permalink, $pin, $excerpt) {
      $this->latLng  = array( $latitude, $longitude );
      $this->data = $title;
      $this->tag = $permalink;
      $this->options = (object) array(
        "icon" => $pin
        );
      $this->excerpt = $excerpt;
    }

    public function get_marker_coords (){
      return "{latLng: [" . $this->latLng['latitude'] . ", " . $this->latLng['longitude'] . "], data: " . $this->title . "}";
    }

  }

  $customList = new WP_Query();
  $customList->query('showposts=5000');
  ?>
  <?php
  if ($customList->have_posts()) :
    while ($customList->have_posts()) : $customList->the_post();

    //VAR SETUP
    $latitude = get_post_meta( $post->ID, 'themolitor_latitude', TRUE );
    $longitude = get_post_meta( $post->ID, 'themolitor_longitude', TRUE );
    $addrOne = get_post_meta( $post->ID, 'themolitor_address_one', TRUE );
    $addrTwo = get_post_meta( $post->ID, 'themolitor_address_two', TRUE );
    $pin = get_post_meta( $post->ID, 'themolitor_pin', TRUE );

    //VAR SETUP
    $mainZoom = get_theme_mod('themolitor_customizer_home_zoom');
    $toggle = get_theme_mod('themolitor_customizer_mapstyle_onoff');
    $sitePin = get_theme_mod('themolitor_customizer_pin');

    //LEGACY SUPPORT
    $data = get_post_meta( $post->ID, 'key', true );
    $oldLatitude = $data['latitude'];
    $oldLongitude = $data['longitude'];
    $oldAddrOne = $data['address_one'];
    $oldAddrTwo = $data['address_two'];
    $oldPin = $data['pin'];

    //CHECK FOR LEGACY IF VARS EMPTY
    if($latitude){} elseif($oldLatitude){$latitude = $oldLatitude;}
    if($longitude){} elseif($oldLongitude){$longitude = $oldLongitude;}
    if($addrOne){} elseif($oldAddrOne){$addrOne = $oldAddrOne;}
    if($addrTwo){} elseif($oldAddrTwo){$addrTwo = $oldAddrTwo;}
    if($pin){} elseif($oldPin){$pin = $oldPin;} else {$pin = $sitePin;}

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

      if($latitude && $longitude){
        $title = get_the_title();
        $permalink = get_permalink();
        $excerpt = get_the_excerpt();

        $single_marker = new Marker ($latitude, $longitude, $title, $permalink, $pin, $excerpt);
        $markers[] = $single_marker;

      }
    endwhile;
   else:?>
    alert('<?php _e('You need to add posts to display on the map.','themolitor');?>');
  <?php endif;  ?>
  /* Pass the array of markers from PHP to JS to be processed in gmap3() later on.
    IN: PHP array of object of Marker class
    OUT: JS array of objects suitable for markers values in GMAP3.
  */
  var markersJSON = '<?php echo json_encode($markers); ?>';
  var crs_markersJS = jQuery.parseJSON(markersJSON);

//<![CDATA[
jQuery.noConflict(); jQuery(document).ready(function(){

  // FOOTER MAP controls
  jQuery('#footer').prepend('<div class="markerNav" title="<?php _e('Prev','themolitor');?>" id="prevMarker"><i class="fa fa-chevron-left"></i></div><div id="markers"></div><div class="markerNav" title="<?php _e('Next','themolitor');?>" id="nextMarker"><i class="fa fa-chevron-right"></i></div><?php if($toggle){ ?><div id="mapTypeContainer"><div id="mapStyleContainer"><div id="mapStyle" class="roadmap"></div></div><div id="mapType" title="<?php _e('Map Type','themolitor');?>" class="roadmap"></div></div><?php } ?>');

    jQuery('body').prepend("<div id='target'></div>");

    //Markers Description Init
    jQuery.each( crs_markersJS, function(index, value) {

      var jQuerybutton = jQuery('<div id="marker'+index+'" class="marker"><div id="markerInfo'+index+'" class="markerInfo"><a class="imgLink" href="'+crs_markersJS[index].tag+'"><img src="'+crs_markersJS[index].options.icon+'" /></a><h2><a href="'+crs_markersJS[index].tag+'">'+crs_markersJS[index].data+'</a></h2><p>'+crs_markersJS[index].excerpt+'</p><a class="markerLink" href="'+crs_markersJS[index].tag+'"><?php _e('View Details','themolitor');?> &rarr;</a><div class="markerTotal">'+(index+1)+' / <span></span></div><div class="clear"></div></div></div>');

      jQuery('#markers').append(jQuerybutton);
      jQuery('#marker0').addClass('activeMarker');
      jQuery('.activeMarker #markerInfo0').addClass('activeInfo').css('display','block');

      var numbers = jQuery(".markerInfo").length;
      jQuery(".markerTotal span").html(numbers);

    });

    // Initialize GMAP3
    jQuery('#gMap').addClass('activeMap').gmap3({
      // MAP properties
      map: {
        options: {
          center: crs_markersJS[0].latLng, // center on the position of the last post (first field in array) latLng;
          zoom:<?php echo $mainZoom;?>,
          scrollwheel:true,
          disableDefaultUI:false,
          disableDoubleClickZoom:false,
          draggable:true,
          mapTypeControl:true,
          mapTypeId:'hybrid',
          mapTypeControlOptions: {
                position: google.maps.ControlPosition.RIGHT_BOTTOM,
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
        },
        callback: function(map){
          console.log('Map init:', map);
          console.log('MarkersJS:', crs_markersJS);


        },   // callback end

        // Listen Once
        onces: {
          bounds_changed: function(map){
            var number = 0;
            bounds = map.getBounds();
          }
        }
      },
      marker: {
        values: crs_markersJS,
        options: {
          draggable: false
        },
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
                  
          }, //mouseout end
          click: function(marker, event, context){
            console.log('marker: ', marker);
            console.log('event: ', context);
            console.log('context: ', context);
            window.location = context.tag;
          } //click end
        }, // events end
        callback: function(marker){
          var $this = jQuery(this);
          jQuery.each( crs_markersJS, function(index, value) {

          //   var jQuerybutton = jQuery('<div id="marker'+index+'" class="marker"><div id="markerInfo'+index+'" class="markerInfo"><a class="imgLink" href="'+crs_markersJS[index].tag+'"><img src="'+crs_markersJS[index].options.icon+'" /></a><h2><a href="'+crs_markersJS[index].tag+'">'+crs_markersJS[index].data+'</a></h2><p>'+crs_markersJS[index].excerpt+'</p><a class="markerLink" href="'+crs_markersJS[index].tag+'"><?php _e('View Details','themolitor');?> &rarr;</a><div class="markerTotal">'+(index+1)+' / <span></span></div><div class="clear"></div></div></div>');
            var jQuerybutton = jQuery('#marker'+index);
            console.log('#marker:', jQuerybutton);

            jQuerybutton.mouseover(function(){
              $this.gmap3("get").panTo(marker[index].position);
              jQuery("#target").stop(true,true).fadeIn(500).delay(500).fadeOut(500);
            });




            // jQuery('#markers').append(jQuerybutton);

            // var numbers = jQuery(".markerInfo").length;
            // jQuery(".markerTotal span").html(numbers);
          });

        }   // callback end

      } // marker end
    });

});
//]]>


</script>