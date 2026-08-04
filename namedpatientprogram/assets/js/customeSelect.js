$(function(){

	var $customSelect = $( '.custom-select' );
	var $resetButton = $( '#resetButton' );
	$customSelect.each(function() {
		var classes = $( this ).attr( 'class' );
		var id = $( this ).attr( 'id' );
		var name = $( this ).attr( 'name' );

		var template =  '<div class="' + classes + '">';
		template += '<span class="custom-select-trigger">';
		template += '<span class="custom-select-trigger-text">' + $( this ).data( 'placeholder' ) + '</span>';
		template += '</span>';
		template += '<div class="custom-options">';

		$(this).find( 'option' ).each( function() {
			template += '<span class="custom-option" onclick="CountrySelect('+$( this ).attr( 'value' )+')" data-value="' + $( this ).attr( 'value' ) + '">' + $( this ).html() + '</span>';
		});

		template += '</div></div>';
		
		var customSelectWrapper = $( '<div class="custom-select-wrapper"></div>' );
		customSelectWrapper.css({
			'-webkit-user-select': 'none',
			'-moz-user-select': 'none',
			'-ms-user-select': 'none',
			'user-select': 'none'
		});

		$( this ).wrap( customSelectWrapper );
		$( this ).after( template );
	});
	$( document ).on( 'click', function( e ){
		var eTarget = e.target;

		if( !$( eTarget ).closest( '.custom-select-wrapper' ).hasClass( 'custom-select-wrapper' ) ) {
			$( '.custom-select' ).removeClass( 'opened' );
			customOptionsClosed();
		}
	});
	$( '.custom-select-trigger' ).on( 'click', function() {
		$( this ).parents( '.custom-select' ).toggleClass( 'opened' );

		var timer;
		if( $( this ).parents( '.custom-select' ).hasClass( 'opened' ) ){
			clearTimeout( timer );

			$( this )
				.parents( '.custom-select' )
				.find( '.custom-options' )
				.stop()
				.css('display', 'block')
				.animate({
					'opacity': '1',
					'margin-top': '0px'
				},100 );
		}

		else{
			customOptionsClosed();
		}

	});


	$( '.custom-option' ).on( 'click', function() {
		$( this ).parents( '.custom-select-wrapper' ).find( 'select' ).val( $( this ).data( 'value' ) );
		$( this ).parents( '.custom-options' ).find( '.custom-option' ).removeClass( 'selection' );
		$( this ).addClass( 'selection' );
		$( this ).parents( '.custom-select' ).removeClass( 'opened' );		
		$( this ).parents( '.custom-select' ).find( '.custom-select-trigger-text' ).text( $( this ).text() );
		customOptionsClosed();
	});


	$resetButton.on('click', function() {
		$( '.custom-select-trigger-text' ).text( $customSelect.data( 'placeholder' ) );
	});


	function customOptionsClosed() {
		$('.custom-options')
			.stop()
			.animate({
				opacity: 0,
				'margin-top': '0'
			},100 );

		t = setTimeout(function(){
			$('.custom-options').css('display', 'none');
		}, 500 );
	}

});