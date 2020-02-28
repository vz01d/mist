( function( window, document ) {
	let app = {};
	app.state = false; // toggled

	app.init = function() {
		let search = document.getElementById('mist-search');
		console.log(search);
	};

	document.ready( app.init );

	return app;
} ( window, document ) );
