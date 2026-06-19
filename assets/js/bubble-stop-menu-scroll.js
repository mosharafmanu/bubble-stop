( function ( $ ) {
	'use strict';

	var isHomepage = $( 'body' ).hasClass( 'home' );
	var homeUrl = window.location.origin + '/';

	var sectionMap = {
		coffee:    { id: 'taste-our-coffee', cls: 'smart-media-content' },
		about:     { id: 'our-journey', cls: 'smart-media-content' },
		community: { id: 'testimonials', cls: 'testimonials-section' },
		rewards:   { id: 'rewards', cls: 'loyalty-rewards' },
	};

	function findSection( mapping, menuText ) {
		var slug = mapping.id;

		// Try exact ID match
		var $byId = $( '#' + slug );
		if ( $byId.length ) {
			return $byId;
		}

		// Try section with matching class
		var $byClass = $( 'section.' + mapping.cls + '[id]' ).first();
		if ( $byClass.length ) {
			return $byClass;
		}
		$byClass = $( 'section.' + mapping.cls ).first();
		if ( $byClass.length ) {
			return $byClass;
		}

		// Try heading text match
		if ( menuText ) {
			var found;
			$( 'section[id]' ).each( function () {
				var $h2 = $( this ).find( 'h2' ).first();
				if ( $h2.length && $h2.text().toLowerCase().indexOf( menuText ) !== -1 ) {
					found = $( this );
					return false;
				}
			} );
			if ( found ) {
				return found;
			}
		}

		return null;
	}

	function scrollTo( $el ) {
		var headerHeight = $( '.site-header' ).outerHeight() || 0;
		var offset = headerHeight + 20;
		$( 'html, body' ).animate(
			{ scrollTop: $el.offset().top - offset },
			600,
			'swing'
		);
	}

	function getMapping( text ) {
		var clean = text.toLowerCase().replace( /\s+/g, '' );
		for ( var key in sectionMap ) {
			if ( clean.indexOf( key ) !== -1 ) {
				return sectionMap[ key ];
			}
		}
		return null;
	}

	$( '.main-menu a' ).on( 'click', function ( e ) {
		var text = $( this ).text().trim();
		var mapping = getMapping( text );

		if ( ! mapping ) {
			return;
		}

		e.preventDefault();

		if ( isHomepage ) {
			var $section = findSection( mapping, text.toLowerCase() );
			if ( $section && $section.length ) {
				scrollTo( $section );
				if ( history.pushState ) {
					history.pushState( null, null, '#' + ( $section.attr( 'id' ) || mapping.id ) );
				}
			}
		} else {
			window.location.href = homeUrl + '#' + mapping.id;
		}
	} );

	$( window ).on( 'load', function () {
		if ( ! isHomepage || ! window.location.hash ) {
			return;
		}
		var $target = $( window.location.hash );
		if ( $target.length ) {
			setTimeout( function () {
				scrollTo( $target );
			}, 150 );
		}
	} );
} )( jQuery );
