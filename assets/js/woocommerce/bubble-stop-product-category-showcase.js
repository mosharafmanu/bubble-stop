( function ( $ ) {
	'use strict';

	function initCarousel( $section ) {
		const $carousel = $section.find( '.product-category-showcase__carousel' );

		if ( $carousel.hasClass( 'slick-initialized' ) ) {
			$carousel.slick( 'unslick' );
		}

		if ( $carousel.children( '.menu-product-card' ).length < 1 ) {
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
				{ breakpoint: 576, settings: { slidesToShow: 1, variableWidth: false } },
			],
		} );
	}

	function setLoading( $section, isLoading ) {
		$section.toggleClass( 'is-loading', isLoading );
		$section.find( '.product-category-showcase__tab' ).prop( 'disabled', isLoading );
	}

	function replaceCarouselContent( $section, html ) {
		const $carousel = $section.find( '.product-category-showcase__carousel' );

		if ( $carousel.hasClass( 'slick-initialized' ) ) {
			$carousel.slick( 'unslick' );
		}

		$carousel.html( html );
	}

	$( function () {
		$( '.product-category-showcase' ).each( function () {
			initCarousel( $( this ) );
		} );
	} );

	$( document ).on( 'click', '.product-category-showcase__arrow--prev', function () {
		const $carousel = $( this ).closest( '.product-category-showcase' ).find( '.product-category-showcase__carousel' );
		if ( $carousel.hasClass( 'slick-initialized' ) ) {
			$carousel.slick( 'slickPrev' );
		}
	} );

	$( document ).on( 'click', '.product-category-showcase__arrow--next', function () {
		const $carousel = $( this ).closest( '.product-category-showcase' ).find( '.product-category-showcase__carousel' );
		if ( $carousel.hasClass( 'slick-initialized' ) ) {
			$carousel.slick( 'slickNext' );
		}
	} );

	$( document ).on( 'keydown', '.product-category-showcase__tab', function ( event ) {
		if ( event.key !== 'ArrowLeft' && event.key !== 'ArrowRight' ) {
			return;
		}

		const $tabs = $( this ).closest( '.product-category-showcase__tabs' ).find( '.product-category-showcase__tab' );
		const index = $tabs.index( this );
		const nextIndex = event.key === 'ArrowRight'
			? ( index + 1 ) % $tabs.length
			: ( index - 1 + $tabs.length ) % $tabs.length;

		event.preventDefault();
		$tabs.eq( nextIndex ).trigger( 'focus' ).trigger( 'click' );
	} );

	$( document ).on( 'click', '.product-category-showcase__tab', function () {
		const $tab = $( this );
		const $section = $tab.closest( '.product-category-showcase' );

		if ( $tab.hasClass( 'is-active' ) || $section.hasClass( 'is-loading' ) ) {
			return;
		}

		setLoading( $section, true );
		$section.find( '.product-category-showcase__tab' ).removeClass( 'is-active' ).attr( 'aria-selected', 'false' );
		$tab.addClass( 'is-active' ).attr( 'aria-selected', 'true' );

		$.ajax( {
			url: bubbleStopCategoryShowcase.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'bubble_stop_load_category_products',
				nonce: bubbleStopCategoryShowcase.nonce,
				category_id: $tab.data( 'category-id' ),
				limit: $section.data( 'product-limit' ),
			},
		} ).done( function ( response ) {
			if ( ! response.success || ! response.data.html ) {
				replaceCarouselContent( $section, '<p class="product-category-showcase__empty">' + bubbleStopCategoryShowcase.error + '</p>' );
				return;
			}

			replaceCarouselContent( $section, response.data.html );
			initCarousel( $section );
		} ).fail( function () {
			replaceCarouselContent( $section, '<p class="product-category-showcase__empty">' + bubbleStopCategoryShowcase.error + '</p>' );
		} ).always( function () {
			setLoading( $section, false );
		} );
	} );
} )( jQuery );
