var flatfile = {

	/* slashes
	---------------------------------------------- */
	nav_apply_slashes: function() {

		var slash_wrapper = '<span class="slash_wrapper"></span>';
		var slash = '<span>/</span>';
		var elements_with_slash;

		elements_with_slash = jQuery( '.home #header .menu li' );	
		elements_with_slash.wrapInner( slash_wrapper );
		elements_with_slash.children( 'span' ).append( slash );

		elements_with_slash = jQuery( '#rollover-nav div' ).last().find( 'li' );
		elements_with_slash.wrapInner( slash_wrapper );
		elements_with_slash.children( 'span' ).append( slash );

		elements_with_slash = jQuery('#breadcrumbs h2 + h2').prev();
		elements_with_slash.wrapInner( slash_wrapper );
		elements_with_slash.children( 'span' ).append( slash );
	}, 
	
	/* overlay navigation
	---------------------------------------------- */
	init_nav: function() {
		
		/* the site title and the rollover nav */
		var site_title = jQuery( '#header h1' ).first();
		var rollover_nav = jQuery( '#rollover-nav, #dim' );
		
		/* when the site title is clicked
		   the navigation appears and page content is dimmed */
		site_title.click(
			function() {
				site_title.css( 'visibility', 'hidden' );
				rollover_nav.show();
				return false;
			}
		);
		
		/* when the dimmed page is clicked
		   the navigation disappears */
		jQuery( '#dim' ).click(
			function() {
				rollover_nav.hide();
				site_title.css( 'visibility', 'visible' );
			}
		);
		
		/* navigation is disabled on the homepage */
		jQuery( '.home #header h1' ).unbind( 'click' );		
	}, 
	
	/* category descriptions
	---------------------------------------------- */
	init_desc: function() {
	
		/* hide the description text */
		jQuery( '.description p' ).hide();
		
		/* clicking the more link
		   causes the description to appear */
		jQuery( '.description a' ).click(
			function() {
				jQuery(this).toggleClass( 'highlight' );
				jQuery( '#' + jQuery(this).attr( 'id' ) + '-description p' ).toggle();
			}
		);	
	},
	
	/* tooltips
	---------------------------------------------- */
	init_tooltips: function() {
		
		/* add a label to each thumbnail image
		   on category pages */
		jQuery( '.thumbnail a img' ).each(
			function() {
				var tooltip_label = 
					'<span class="tooltip-label">' + 
					jQuery(this).attr('title') + 
					'</div>';
				jQuery(this).parent().after( tooltip_label );
			}
		);
		
		/* hide/show tooltips on extended hover */
		jQuery( '.thumbnail' ).hoverIntent(
			function() {
				jQuery( '.tooltip-label' ).hide();
				jQuery(this).children( '.tooltip-label' ).show();
			},
			function() {
				jQuery(this).children('.tooltip-label').hide();
			}
		);
		
		/* clickify the tooltips to prevent them 
		   from interfering with thumbnail clicks */
		jQuery( '.tooltip-label' ).click(
			function() {
				window.location = jQuery(this).prev().attr( 'href' );
			}
		);
		
		/* apply tooltips to:
		   — top left page controls
		   — article controls */
		jQuery(
			'#controls a[title], ' +
			'.article .article-controls a[title]'
		).tooltip(
			{
				tipClass: 'tooltip-system',
				predelay: 100,
				position: 'bottom left',
				offset: [-4, 4]
			}
		);
	}, 
	
	/* cleanup titles
	---------------------------------------------- */
	cleanup_titles: function() {
		jQuery(
			'#header a, ' +
			'#footer a, ' + 
			'#featured img, ' +
			'.thumbnail img, ' +
			'#caption img, ' +
			'.article-controls a, ' +
			'.excerpt img'
		).removeAttr('title');
	}, 
	
	/* cleanup borders
	---------------------------------------------- */
	cleanup_borders: function() {
		
		/* remove borders from linked images */
		jQuery( 'a img' ).parent().css( 'border', 'none' );
		
		/* remove borders from pictograms */
		jQuery( '.article a .flatfile-normal' ).parent().css( 'border', 'none' );	
	},
	
	/* move videos from caption to content
	---------------------------------------------- */
	cleanup_videos: function() {
	
		var cleared_default = false;
		
		var iframes = jQuery( '#caption iframe' );
		if( iframes.length ) {
			iframes.each(
				function() {
					if( !jQuery(this).parent().hasClass( 'keep-in-caption' ) ) {
						if( !cleared_default ) {
							jQuery( '.default' ).html('');
							cleared_default = true;
						}
						jQuery( '.default' ).append( jQuery(this).detach() );
					}
				}
			);
		}
		
		var objects = jQuery( '#caption object' );
		if( objects.length ) {
			objects.each(
				function() {
					if( !jQuery(this).parent().hasClass( 'keep-in-caption' ) ) {
						if( !cleared_default ) {
							jQuery( '.default' ).html('');
							cleared_default = true;
						}
						jQuery( '.default' ).append( jQuery(this).detach() );
					}
				}
			);
		}
		
		jQuery( '#caption' ).removeClass( 'hide-videos' );
	}
};

jQuery(document).ready(function() {

	/* do this, to keep the load visually smooth
	---------------------------------------------- */
	flatfile.init_desc();
	flatfile.nav_apply_slashes();

	/* image handling
	---------------------------------------------- */

	/* resize the current featured image
	   to fit within the container div, #featured */
	var fit_featured_image = function() {

		/* define a selector */
		var current_obj = jQuery( '.current' );
		if( jQuery( '.current img' ).length ) {
			current_obj = jQuery( '.current img' );
		}
				
		var currentImg = new Image();
		currentImg.onload = function() {

			/* get scale factor for each direction */			
			var scale_width  = jQuery('#featured').width() / currentImg.width;
			var scale_height = jQuery('#featured').height() / currentImg.height;
			
			/* compare to decide which direction to scale */
			var scale_factor = scale_width;
			if ( scale_width > scale_height ) {
				scale_factor = scale_height;
			}
			
			/* if the image doesn't need to be scaled */
			if( scale_factor >= 1 ) {
				scale_factor = 1;
				
				/* check if it has been scaled up */
				if( current_obj.hasClass( 'zoomed-out' ) ) {
					
					/* toggle classes */
					current_obj
						.removeClass('zoomed-out')
						.addClass('zoomed-in');	
				}
				
			/* if the image does need to be scaled */
			} else {
				if( scale_factor < 1.0 ) {
					
					/* add class */
					current_obj
						.addClass( 'zoomed-out' );
				}
			}
			
			/* remove zoom from featured image on homepage */
			jQuery( '.home #featured img')
				.removeClass('zoomed-in')
				.removeClass('zoomed-out')
				.unbind('click');

			/* scale the current image */
			current_obj
				.attr('width', currentImg.width * scale_factor)
				.attr('height', currentImg.height * scale_factor);
						
			/* reset the #featured div height to auto */
			jQuery('#featured').css('height', 'auto');
		};
		currentImg.src = current_obj.attr('src');
	};
	
	/* utility function to resize the container div #featured */
	var resize_featured = function(width, height) {
		
		jQuery('#featured')
			.css('width', width)
			.css('height', height);
		
		/* if there are any videos, turn the height to auto */
		if( jQuery('#featured .current iframe').length || 
		    jQuery('#featured .current object').length    ) {
			jQuery('#featured').css('height', 'auto');
		} else {
			/* otherwise, fit the current featured image to fit inside */
			fit_featured_image();
		}
	};
	
	/* resize the container div #featured
	   to fit inside the window */
	var fit_featured = function() {
		resize_featured(
			jQuery(window).width() - jQuery('#header').width() - 100,
			jQuery(window).height() - 120
		);
	};
	
	/* resize the #wrapper div
	   to fit around the container div #featured */
	var resize_wrapper = function() {
		jQuery( '.home #wrapper' ).css( 'min-width',
			function() {
				var width = jQuery( '#header' ).width() + jQuery( '#featured' ).width() + 18;
				return width;
			}
		);
		jQuery( '.single #wrapper' ).css( 'min-width',
			function() {
				var width = jQuery( '#header' ).width() + jQuery( '#featured' ).width() + 18;
				return width;
			}
		);
	};
	
	/* add zoom in/out for all featured images */
	var clickify_featured = function() {
		
		jQuery('#featured img').each(
			function() {
			
				/* unbind click to prevent multiple click bindings */
				jQuery(this).unbind( 'click' );
			
				// add the zoom on click
				jQuery(this).click(
					function() {
						if( jQuery(this).hasClass( 'zoomed-in' )) {

							/* if already zoomed out
							   zoom out by fitting #featured to the window */
							fit_featured();
							resize_wrapper();
					
							/* toggle classes */
							jQuery(this)
								.removeClass('zoomed-in')
								.addClass('zoomed-out');
					
						} else if( jQuery(this).hasClass( 'zoomed-out' )) {
					
							/* if not, calculate the max zoom, and resize */
							var zoomImg = new Image();
							zoomImg.onload = function() {
								resize_featured(
									zoomImg.width,
									zoomImg.height
								);
								resize_wrapper();
							};
							if( jQuery('.current img').length ) {
								zoomImg.src = jQuery('.current img').attr('src');
							} else {
								zoomImg.src = jQuery('.current').attr('src');
							}
							
							/* toggle classes */
							jQuery(this)
								.addClass('zoomed-in')
								.removeClass('zoomed-out');
						}
					}
				);
			}
		);
	}
	
	jQuery(window).load(function() {
		
		/* move videos to right */
		flatfile.cleanup_videos();
		
		/* resize featured image */
		if( jQuery('#featured').length ) {
			jQuery('#featured .default').addClass('current');
			jQuery('#featured').hide();
			fit_featured();
			jQuery('#featured').fadeIn(100);
			resize_wrapper();
		}
		clickify_featured();	
		
		/* setup nav */
		flatfile.init_nav();

		/* misc. */
		flatfile.init_tooltips();
		flatfile.cleanup_titles();
		flatfile.cleanup_borders();

		/* activate details
		---------------------------------------------- */
		var details = jQuery( '#caption a img' );
		if( details.length ) {
			details.each(
				function() {
					/* if this is not a link to an attachment page */
					if( jQuery(this).parent().attr('href').indexOf('attachment') == -1 ) {

						/* grey out any images that link to the already visible featured image */
						if( jQuery(this).parent().attr('href') === jQuery( '#featured .default img' ).attr( 'src' ) ) {
							if( !( jQuery( '#caption iframe' ).length || 
							       jQuery( '#caption object' ).length    )) {
								jQuery(this).parent().addClass( 'selected' );			
							}
						}

						/* preload linked images, and append to #featured */
						var detailImg = new Image();
						detailImg.onload = function()
						{
							jQuery( '#featured' ).append( '<img src="' + this.src + '">' );
							clickify_featured();
						};
						detailImg.src = jQuery(this).parent().attr( 'href' );

						/* bind click functionality to detail images */
						jQuery(this).click(function() {

							var detailSrc = jQuery(this).parent().attr('href');

							if( jQuery(this).parent().hasClass('selected') ) {
								jQuery('#caption a').removeClass('selected');
							} else {
								jQuery('#caption a').removeClass('selected');
								jQuery(this).parent().addClass('selected');						
							}

							jQuery('#featured img').each(function() {

								if( jQuery(this).attr('src') == detailSrc ) {

									/* if this detail is already selected, revert to default, otherwise show this detail */
									if( jQuery(this).hasClass('current') ) {
										jQuery('.current').removeClass('current');
										jQuery('.default').addClass('current');
									} else {
										jQuery('.current').removeClass('current');
										jQuery(this).addClass('current');
									}
									jQuery('#featured').hide();
									fit_featured();
									jQuery('#featured').fadeIn(100);
								}
							});

							return false;
						}
						);	
					}
				}
			);
		}
	});
});


