( function( window, document ) {
	let app = {};
	app.state = false; // toggled

	app.init = function() {
		let search = document.getElementById('mist-search');
		search.addEventListener('focus', function(){
			search.placeholder = "Was möchtest Du Wissen?";
		});
		
		search.addEventListener('blur', function(){
			search.placeholder = "42?";
		});
	};

	document.addEventListener("DOMContentLoaded", function(event) { 
		app.init();
	});

	return app;
} ( window, document ) );
