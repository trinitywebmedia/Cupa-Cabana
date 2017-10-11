jQuery.noConflict();

function parallax() {
	var scrollPosition = jQuery(window).scrollTop();
	var jQuerybgobj =  jQuery('section[data-type="background"]');
	var yPos = -( scrollPosition / jQuerybgobj.data('speed')); 
	jQuery('section[data-type="background"]').css('background-position', '0 '+yPos+'px' );
}

jQuery(document).ready(function() {

	/* ========== FITVIDS PLUGIN ========== */
	
	jQuery('.fitvids').fitVids();

	/* ========== PARALLAX BACKGROUND ========== */

	jQuery(window).on('scroll', function(e) {
		parallax();
		
	});
	
	
	/* ========== BOOTSTRAP CAROUSEL ========== */

	jQuery('.carousel').carousel({
	  interval: 4000
	});

	/* ========== SMOOTH SCROLLING BETWEEN SECTIONS ========== */
	
	jQuery('.home a').not('#myCarousel a, #testimonials a, .modal-trigger a, .panel a, .tab_container ul li a').click(function(o) {
	    //gets <a> link
		var str = jQuery(this).attr('href');
		if( str.indexOf("http")  <= 0){	
			
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')  || location.hostname == this.hostname) {
				var target = jQuery(this.hash);
				jQuery('.nav-primary ul li.menu-item').removeClass('active');
				target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
				   if (target.length) {
					   jQuery(this).parent('li.menu-item').addClass('active');
					if (jQuery(".navbar").css("position") == "fixed" ) {
					 jQuery('html,body').animate({
						 scrollTop: target.offset().top-72
					}, 700, 'swing');
				 } else {
					 jQuery('html,body').animate({
						 scrollTop: target.offset().top
					}, 700, 'swing');
				 }
					return false;
				}
			}
	    }
	});


	/* =========== CUSTOM STYLE FOR SELECT DROPDOWN ========== */

	jQuery("select").selectpicker({style: 'btn-hg btn-primary', menuStyle: 'dropdown'});

	// style: select toggle class name (which is .btn)
	// menuStyle: dropdown class name

	// You can always select by any other attribute, not just tag name.
	// Also you can leave selectpicker arguments blank to apply defaults.



	/* ========== TOOLTIPS & POPOVERS =========== */

	jQuery("[data-toggle=tooltip]").tooltip();

	jQuery('.popover-trigger').popover('hide');
	
	jQuery('a[data-toggle="tab"]:first').tab('show');
	jQuery('a[data-toggle="tab"]:first').parent().addClass('active');
	jQuery('.tab_container .tab-pane:first').addClass('in active');
	

	/* ========== Nav Spy =========== */
	jQuery('.nav-primary').onePageNav({
		currentClass: 'active',
		changeHash: false,
		scrollSpeed: 750,
		scrollOffset: 72,
	});
	
		

    /* ========== MAGNIFIC POPUP ========== */
	
	/* pop-up for portfolio images */
    jQuery('.gallery-image, .gallery-popup').magnificPopup({
	  	delegate: 'a',
	  	type: 'image',
	  	closeOnContentClick: 'true',
		mainClass: 'mfp-with-zoom',
	  	zoom: {
		    enabled: true, 
		    duration: 300, 
		    easing: 'ease-in-out',
		    opener: function(openerElement) {
		      return openerElement.is('img') ? openerElement : openerElement.find('img');
		    }
		}
	});
	
	/* Pop-up for portfolio videos */
	jQuery('.gallery-video').magnificPopup({
		delegate: 'a',
	  	type: 'iframe',
	  	closeOnContentClick: 'true',
	  	zoom: {
		    enabled: true, 
		    duration: 300, 
		    easing: 'ease-in-out'
		},
		disableOn: 700,
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	});

	/* ========== END OF SCRIPTS ========== */
	
	
	/* ========== MOBILE MENU ========== */
	
	jQuery('.nav-secondary .menu li, .nav-primary .menu li').each(function(){
		if( jQuery(this).children('ul.sub-menu').length > 0 ){
			jQuery(this).children('a').after('<span class="indicator"><i class="fa fa-angle-down"></i></span>');	
		}
	});
	jQuery('.nav-secondary .menu li span.indicator, .nav-primary .menu li span.indicator').toggle(function(){
		jQuery(this).next('ul.sub-menu').show();
		jQuery(this).children('.fa').removeClass('fa-angle-down');
		jQuery(this).children('.fa').addClass('fa-angle-up');
	},function(){
		jQuery(this).next('ul.sub-menu').hide();
		jQuery(this).children('.fa').removeClass('fa-angle-up');
		jQuery(this).children('.fa').addClass('fa-angle-down');
	});

});


/* ========== ISOTOPE FILTERING ========== */

jQuery(window).load(function(){

	var jQuerycontainer = jQuery('#gallery-items'),
        jQueryselect = jQuery('#filters select');

    jQuerycontainer.isotope({
        itemSelector: '.gallery-item',
		filter: jQuery('#filters select option:selected').val()
    });

    jQueryselect.change(function() {
        var filters = jQuery(this).val();
        jQuerycontainer.isotope({
            filter: filters
        });
    });
    
});