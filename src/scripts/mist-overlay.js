( function( window, document ) {
	let app = {};
	app.init = function() {
		let targets = document.querySelectorAll( '.mist-copyright-info' );
		targets.forEach( function( t ) {
			t.addEventListener( 'click', function( e ) {
				// el
				let el = e.target;
				let rect = el.getBoundingClientRect();
				const target = this.getAttribute( 'href' ).substr( 1 );
				const modalWindow = document.getElementById( target );
				if ( modalWindow.classList ) {
					modalWindow.classList.add( 'open' );
				}

				// pos
				let xPos = ( el.offsetLeft - el.scrollLeft + el.clientLeft );
				let yPos = ( el.offsetTop - el.scrollTop + el.clientTop );

				modalWindow.style.top = yPos + 'px';
				modalWindow.style.left = xPos + 'px';

				// data
				let dataText = el.parentNode.dataset.cptext;
				let dataUrl = el.parentNode.dataset.cpurl;
				
				// apply modal html
				modalWindow.querySelector( '.modal-body' ).innerHTML =
					'<p>' +
					dataText +
					'</p>' +
					'<a href="' + dataUrl + '" target="_blank">' +
					'Bildquelle</a>'
				;

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
