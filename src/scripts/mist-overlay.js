( function( window, document ) {
	let app = {};
	app.init = function() {
		let targets = document.querySelectorAll( '.mist-copyright-info' );
		targets.forEach( function( t ) {
			t.addEventListener( 'click', function( e ) {
				let rect = e.target.getBoundingClientRect();
				const target = this.getAttribute( 'href' ).substr( 1 );
				const modalWindow = document.getElementById( target );
				if ( modalWindow.classList ) {
					modalWindow.classList.add( 'open' );
				}

				// TODO: scroll height?!?

				modalWindow.style.top = rect.x + 'px';
				modalWindow.style.left = rect.y + 'px';

				/*
				modalWindow.querySelector( '.modal-body' ).innerHTML =
					'<p>' +
					MISTIMG.copyrightText +
					'</p>' +
					'<a href="' + MISTIMG.copyrightUrl + '" target="_blank">' +
					'Bildquelle</a>'
				;
				*/

				e.preventDefault();
			});
		});

		let closeBtns = document.querySelectorAll( '.modal-close' );
		closeBtns.forEach( function( btn ) {
			btn.addEventListener( 'click', function( e ) {
				const modal = document.querySelectorAll( '#mistmodal' );
				modal[0].classList.remove( 'open' );
				e.preventDefault();
			});
		});
	};

	document.addEventListener( 'DOMContentLoaded', function() {
		app.init();
	});

	return app;
} ( window, document ) );
