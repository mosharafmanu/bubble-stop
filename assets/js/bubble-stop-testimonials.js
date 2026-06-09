( function ( $ ) {
	'use strict';

	$( function () {
		$( '.testimonials-section' ).each( function () {
			const $section = $( this );
			const $carousel = $section.find( '.testimonials-section__carousel' );

			if ( $carousel.children( '.testimonial-card' ).length < 1 ) {
				return;
			}

			$carousel.slick( {
				dots: false,
				arrows: false,
				infinite: true,
				adaptiveHeight: true,
				speed: 350,
				slidesToShow: 1,
				slidesToScroll: 1,
			} );
		} );
	} );

	$( document ).on( 'click', '.testimonials-section__arrow--prev', function () {
		const $carousel = $( this ).closest( '.testimonials-section' ).find( '.testimonials-section__carousel' );
		if ( $carousel.hasClass( 'slick-initialized' ) ) {
			$carousel.slick( 'slickPrev' );
		}
	} );

	$( document ).on( 'click', '.testimonials-section__arrow--next', function () {
		const $carousel = $( this ).closest( '.testimonials-section' ).find( '.testimonials-section__carousel' );
		if ( $carousel.hasClass( 'slick-initialized' ) ) {
			$carousel.slick( 'slickNext' );
		}
	} );
} )( jQuery );
