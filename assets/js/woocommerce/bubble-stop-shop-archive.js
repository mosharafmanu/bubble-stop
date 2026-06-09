( function ( $ ) {
	'use strict';

	function initCategoryCarousel( $block ) {
		const $carousel = $block.find( '.shop-category-block__carousel' );

		if ( $carousel.hasClass( 'slick-initialized' ) || $carousel.children( '.shop-menu-card' ).length < 1 ) {
			return;
		}

		$carousel.slick( {
			dots: false,
			arrows: false,
			infinite: false,
			speed: 350,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
				{ breakpoint: 1100, settings: { slidesToShow: 3 } },
				{ breakpoint: 768, settings: { slidesToShow: 2 } },
				{ breakpoint: 576, settings: { slidesToShow: 1 } },
			],
		} );
	}

	$( function () {
		$( '.shop-category-block' ).each( function () {
			initCategoryCarousel( $( this ) );
		} );
	} );

	$( document ).on( 'click', '.shop-category-block__arrow--prev', function () {
		$( this ).closest( '.shop-category-block' ).find( '.shop-category-block__carousel' ).slick( 'slickPrev' );
	} );

	$( document ).on( 'click', '.shop-category-block__arrow--next', function () {
		$( this ).closest( '.shop-category-block' ).find( '.shop-category-block__carousel' ).slick( 'slickNext' );
	} );
} )( jQuery );
