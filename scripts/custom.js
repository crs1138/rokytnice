// Tooltip from CSS Globe written by Alen Grakalic (http://cssglobe.com)
this.tooltip = function(){xOffset = -10;yOffset = 10;jQuery.noConflict();jQuery(".tooltip").hover(function(e){this.t = this.title;this.title = "";jQuery("body").append("<p class='itooltip'>"+ this.t +"</p>");jQuery(".itooltip").css("top",(e.pageY - xOffset) + "px").css("left",(e.pageX + yOffset) + "px").fadeIn(500);},function(){this.title = this.t; jQuery(".itooltip").remove();});jQuery("a.tooltip").mousemove(function(e){jQuery(".itooltip").css("top",(e.pageY - xOffset) + "px").css("left",(e.pageX + yOffset) + "px");});};
//END TOOLTIP

jQuery.noConflict(); jQuery(document).ready(function(){

	////////////////////
	//VAR SETUP
	////////////////////
	var loading = jQuery('#loading'),
		mainBox = jQuery('#main'),
		header = jQuery('#header'),
		pageBox = jQuery(".pageContent"),
		toggleButton = jQuery('.toggleButton'),
		sidebar = jQuery('#sidebar'),
		widgetsToggle = jQuery('.widgetsToggle'),
		//iPad,iPhone,iPod...
		deviceAgent = navigator.userAgent.toLowerCase(),
		iPadiPhone = deviceAgent.match(/(iphone|ipod|ipad)/),
		//MAP VARS
		gMap = jQuery('#gMap'),
		containerHeight = jQuery(window).height(),
		marker = jQuery('.marker'),
		mapType = jQuery("#mapType"),
		target = jQuery("#target");

	var opts = {
  		lines: 12, // The number of lines to draw
  		length: 8, // The length of each line
  		width: 3, // The line thickness
  		radius: 16, // The radius of the inner circle
  		corners: 1, // Corner roundness (0..1)
  		rotate: 0, // The rotation offset
  		direction: 1, // 1: clockwise, -1: counterclockwise
  		color: '#fff', // #rgb or #rrggbb or array of colors
  		speed: 1, // Rounds per second
  		trail: 100, // Afterglow percentage
  		shadow: false, // Whether to render a shadow
  		hwaccel: false, // Whether to use hardware acceleration
  		className: 'spinner', // The CSS class to assign to the spinner
  		zIndex: 2e9, // The z-index (defaults to 2000000000)
  		top: 'auto', // Top position relative to parent in px
  		left: 'auto' // Left position relative to parent in px
	};
	var loadTarget = document.getElementById('loading');
	var spinner = new Spinner(opts).spin(loadTarget);

	////////////////////
	//RUN FUNCTIONS
	////////////////////
	tooltip();

	////////////////////
	//WINDOW LOAD
	////////////////////
	jQuery(window).load(function(){

		loading.stop(true,true).fadeOut(500,function(){
			spinner.stop();
			loading.remove();
		});

		//TOP AREA SPACING STUFF
		var headerHeight = header.height(),
			headerSpacing = headerHeight + 35;
		jQuery("#dropmenu > li > a, #searchIcon").css({lineHeight:headerHeight+"px"});
		jQuery("#dropmenu > li > ul, #sidebar").css({top:headerHeight+"px"});
		jQuery("#content").css({paddingTop:headerSpacing+"px"});

		header.stop(true,true).fadeIn(500,function(){
			header.css({display:'block'});
		});
	});

	////////////////////
	//SEARCH TOGGLE
	////////////////////
	jQuery('#searchToggle').click(function(){
		jQuery('#header #searchform').stop(true,true).fadeToggle(200);
		jQuery(this).find('i').toggleClass('fa-times');
	});


    ////////////////////
    //WIDGETS TOGGLE
    ////////////////////
	widgetsToggle.live('click', function(){
		sidebar.stop(true,true).fadeToggle(200);
		widgetsToggle.stop(true,true).toggle();
		jQuery('#searchToggle.active').click();
		return false;
	});


		////////////////////
        //NEXT MARKER
        ////////////////////
        jQuery('#nextMarker').live('click', function(){
        	var activeMarker = jQuery('.activeMarker');
        	if(activeMarker.is(':not(:last-child)')){
        		activeMarker.removeClass('activeMarker').next('.marker').addClass('activeMarker').mouseover();
        	} else {
        		activeMarker.removeClass('activeMarker');
        		jQuery('.marker:first-child').addClass('activeMarker').mouseover();
        	}
        });
        ////////////////////
        //PREV MARKER
        ////////////////////
        jQuery('#prevMarker').live('click', function(){
        	var activeMarker = jQuery('.activeMarker');
        	if(activeMarker.is(':not(:first-child) ')){
        		activeMarker.removeClass('activeMarker').prev('.marker').addClass('activeMarker').mouseover();
        	} else {
        		activeMarker.removeClass('activeMarker');
        		jQuery('.marker:last-child').addClass('activeMarker').mouseover();
        	}
        });
        ////////////////////
       	//HOVER
       	////////////////////
        marker.live('mouseover', function(){
        	jQuery('.activeInfo').removeClass('activeInfo').stop(true,true).hide();
        	jQuery(this).siblings('.marker').removeClass('activeMarker');
        	jQuery(this).addClass('activeMarker').children('.markerInfo').addClass('activeInfo').stop(true, true).show();
        	target.stop(true,true).show();
        });
        ////////////////////
        //TARGET HOVER
        ////////////////////
        target.live('mouseover',function(){
        	jQuery(this).stop(true,true).hide();
        });

    ////////////////////
    //MAP TYPE
    ////////////////////
    jQuery(".roadmap").live('click', function(){
    	gMap.gmap3({
    		map: {
    			options: {
    				mapTypeId: 'roadmap' //hybrid, satellite, roadmap, terrain
    				// mapTypeId: new google.maps.mapTypeId.ROADMAP
    			}
    		}
    	});
    	jQuery(this).removeClass('roadmap').addClass('hybrid');
    	jQuery("#mapStyle").toggleClass('hybrid');
    });

    // $(".roadmap").live('click', function(){
    // 	gMap.gmap3({
    // 		action: 'setOptions',
    // 		args: [{mapTypeId: 'roadmap'}]
    // 	});
    // 	$(this).removeClass('roadmap').addClass('hybrid');
    // 	$("#mapStyle").toggleClass('hybrid');
    // });

    // jQuery(".roadmap").live('click',function(){
    // 	gMap.gmap3({action: 'setOptions', args:[{mapTypeId:'roadmap'}]}); //hybrid, satellite, roadmap, terrain
    // 	jQuery(this).removeClass('roadmap').addClass('hybrid');
    // 	jQuery("#mapStyle").toggleClass('hybrid');
    // });

	jQuery(".hybrid").live('click', function() {
    	// console.log('crsMap', crsMap);
		gMap.gmap3({
			map: {
				options: {
					mapTypeId: 'hybrid'
				}
			}
		});
		jQuery(this).removeClass('hybrid').addClass('roadmap');
		jQuery("#mapStyle").toggleClass('roadmap');
	});

    // jQuery(".hybrid").live('click',function(){
    // 	gMap.gmap3({action: 'setOptions', args:[{mapTypeId:'hybrid'}]}); //hybrid, satellite, roadmap, terrain
    // 	jQuery(this).removeClass('hybrid').addClass('roadmap');
    // 	jQuery("#mapStyle").toggleClass('roadmap');
    // });
    mapType.live('mouseover', function(){
       jQuery("#mapStyleContainer").stop(true,true).fadeIn(200);
    });
    mapType.live('mouseout', function(){
		jQuery("#mapStyleContainer").stop(true,true).fadeOut(100);
    });

	////////////////////
	//REMOVE TITLE ATTRIBUTE
	////////////////////
	jQuery("#dropmenu a, .attachment-small").removeAttr("title");

	////////////////////
	//MENU
	////////////////////
	jQuery("#dropmenu ul").parent().children("a").append("<span>&nbsp;&nbsp;+</span>");

	jQuery("#dropmenu ul li a").hover(function(){
		jQuery(this).stop(true,true).animate({paddingLeft:"20px"},300);
	},function(){
		jQuery(this).stop(true,true).animate({paddingLeft:"15px"},300);
	});

	////////////////////
	//IF iPad
	////////////////////
	if (iPadiPhone) {
		function windowSizes(){
			var headerHeight = header.height(),
				headerSpacing = headerHeight + 35,
				windowHeight = jQuery(window).height(),
				footerSpacing = 75,
				mainHeight = windowHeight - headerSpacing - footerSpacing - 40;
			if(mainBox.outerHeight() > mainHeight) {
				jQuery(mainBox).css({height:mainHeight,overflow:"auto"});
			}
		}

		windowSizes();

		jQuery(window).resize(function() {
			windowSizes();
		});

		toggleButton.click(function(){
			windowSizes();
		});

		jQuery('body').addClass('iPad');

	////////////////////
	//IF NOT iPad
	////////////////////
	} else {
		//ADD HANDLE AND MAKE DRAGGABLE
		mainBox.draggable({ handle:"#handle",opacity: 0.8}).resizable();

		mainBox.prepend("<div id='moveNotice'></div>");

		var moveNotice = jQuery("#moveNotice");

		jQuery("#handle").hover(function(){
			moveNotice.stop(true,true).fadeIn(200);
		},function(){
			moveNotice.stop(true,true).fadeOut(200);
		});
	}

	////////////////////
	//PRETTY PHOTO
	////////////////////
	jQuery("a[href$='jpg'],a[href$='jpeg'],a[href$='png'],a[href$='gif']").attr({rel: "prettyPhoto[pp_gal]"});
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
		animation_speed: 'normal', // fast/slow/normal
		opacity: 0.35, // Value betwee 0 and 1
		show_title: false, // true/false
		allow_resize: true, // true/false
		overlay_gallery: false,
		counter_separator_label: ' of ', // The separator for the gallery counter 1 "of" 2
		//theme: 'light_rounded', // light_rounded / dark_rounded / light_square / dark_square
		hideflash: true, // Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto
		modal: false // If set to true, only the close button will close the window
	});

	////////////////////
	//FORM VALIDATION
	////////////////////
	jQuery("#primaryPostForm").submit(function(event) {

	    var postTest = jQuery('#postTest'),
	    	requiredField = jQuery("#primaryPostForm .required").not('#primaryPostForm #postTest');

	    //CHECK REQUIRED FIELDS
		requiredField.each(function(){
			var imRequired = jQuery(this);
			if (imRequired.val() === "" || imRequired.val() === "-1") {
				imRequired.css({background:"#deb6ae"});
				event.preventDefault();
			} else {
				imRequired.css({background:"#333"});
			}
		});

		//CHECK FORM TEST
		if(postTest.val() != "102"){
			postTest.css({background:"#deb6ae"});
			event.preventDefault();
			alert('Test answer incorrect. Please try again.');
		} else {
			postTest.css({background:"#333"});
		}
	});

	////////////////
	//RESPONSIVE MENU
	////////////////
	// Create the dropdown base
	jQuery("<select id='selectMenu'><select />").appendTo("#navigation");

	// Create default option "Go to..."
	jQuery("<option />", {
	   "selected": "selected",
	   "value"   : "",
	   "text"    : "Menu"
	}).appendTo("#navigation select");

	// Populate dropdown with menu items
	jQuery("#dropmenu a").each(function() {
	 	var el = jQuery(this);

	 	el.parents('.sub-menu').each(function(){
	 		el.prepend('<span class="navDash">-</span>');
	 	});

	 	jQuery("<option />", {
	  	   "value"   : el.attr("href"),
	     	"text"    : el.text()
	 	}).appendTo("#navigation select");
	});

	// Load url when selected
	jQuery("#selectMenu").change(function() {
  		window.location = jQuery(this).find("option:selected").val();
	});

});