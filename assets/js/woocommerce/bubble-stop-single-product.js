( function ( $ ) {
	'use strict';

	function syncDefaultVariations( $form ) {
		$form.find( '[data-variation-select]:checked' ).each( function () {
			const $radio = $( this );
			$form.find( '#' + $radio.data( 'variation-select' ) ).val( $radio.val() ).trigger( 'change' );
		} );
	}

	$( function () {
		const $productImage = $( '.drink-order-card__image' ).first();
		$productImage.data( 'original-src', $productImage.attr( 'src' ) || '' );
		$productImage.data( 'original-srcset', $productImage.attr( 'srcset' ) || '' );
		$productImage.data( 'original-alt', $productImage.attr( 'alt' ) || '' );

		$( '.drink-order-form.variations_form' ).each( function () {
			const $form = $( this );
			syncDefaultVariations( $form );
		} );

		$( '.drink-topping-picker__options' ).scrollTop( 0 );
	} );

	$( document ).on( 'change', '[data-variation-select]', function () {
		const $radio = $( this );
		const $form = $radio.closest( '.variations_form' );
		$form.find( '#' + $radio.data( 'variation-select' ) ).val( $radio.val() ).trigger( 'change' );
	} );

	$( document ).on( 'click', '.drink-topping-picker__toggle', function () {
		const $toggle = $( this );
		const $picker = $toggle.closest( '.drink-topping-picker' );
		const $options = $picker.find( '.drink-topping-picker__options' );
		const isOpen = $picker.hasClass( 'is-open' );

		if ( isOpen ) {
			$options.stop( true, true ).slideUp( 250 );
		} else {
			$options.scrollTop( 0 ).stop( true, true ).slideDown( 250 );
		}

		$picker.toggleClass( 'is-open', ! isOpen );
		$toggle.attr( 'aria-expanded', String( ! isOpen ) );
	} );

	$( document ).on( 'found_variation', '.drink-order-form.variations_form', function ( event, variation ) {
		if ( ! variation.image || ! variation.image.src ) {
			return;
		}

		const $image = $( '.drink-order-card__image' ).first();
		$image.closest( 'picture' ).find( 'source' ).remove();
		$image.attr( 'src', variation.image.src );
		if ( variation.image.srcset ) {
			$image.attr( 'srcset', variation.image.srcset );
		}
		if ( variation.image.alt ) {
			$image.attr( 'alt', variation.image.alt );
		}
	} );

	$( document ).on( 'reset_data', '.drink-order-form.variations_form', function () {
		$( this ).find( '[data-variation-select]' ).prop( 'checked', false );

		const $image = $( '.drink-order-card__image' ).first();
		$image.attr( 'src', $image.data( 'original-src' ) || '' );
		$image.attr( 'alt', $image.data( 'original-alt' ) || '' );
		if ( $image.data( 'original-srcset' ) ) {
			$image.attr( 'srcset', $image.data( 'original-srcset' ) );
		} else {
			$image.removeAttr( 'srcset' );
		}
	} );

	$( document ).on( 'submit', '.drink-order-form', function ( event ) {
		const form = this;
		if ( form.checkValidity() ) {
			return;
		}

		event.preventDefault();
		form.reportValidity();
	} );
} )( jQuery );
