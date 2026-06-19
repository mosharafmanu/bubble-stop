( function ( $ ) {
	'use strict';

	$( function () {
		$( '.shop-category-block' ).each( function () {
			const $section = $( this );
			const $carousel = $section.find( '.shop-category-block__carousel' );

			if ( ! $carousel.children().length ) {
				return;
			}

			$carousel.slick( {
				dots: false,
				arrows: false,
				infinite: true,
				speed: 350,
				slidesToShow: 4,
				slidesToScroll: 1,
				responsive: [
					{
						breakpoint: 992,
						settings: {
							slidesToShow: 3,
						},
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 2,
						},
					},
					{
						breakpoint: 576,
						settings: {
							slidesToShow: 1,
						},
					},
				],
			} );
		} );
	} );

	$( document ).on( 'click', '.shop-category-block__arrow--prev', function () {
		const $carousel = $( this ).closest( '.shop-category-block' ).find( '.shop-category-block__carousel' );
		if ( $carousel.hasClass( 'slick-initialized' ) ) {
			$carousel.slick( 'slickPrev' );
		}
	} );

	$( document ).on( 'click', '.shop-category-block__arrow--next', function () {
		const $carousel = $( this ).closest( '.shop-category-block' ).find( '.shop-category-block__carousel' );
		if ( $carousel.hasClass( 'slick-initialized' ) ) {
			$carousel.slick( 'slickNext' );
		}
	} );
} )( jQuery );
