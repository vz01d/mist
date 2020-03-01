( function( window, document ) {
	let app = {};

	// -> Server ?
	const placeHolders= [
		"Was möchtest Du Wissen?",
		"Suchst Du was?",
		"Hast Du heute schon gelächelt?",
		"Hast Du eine Frage?",
		"Was bedeutet 42?",
		"Gibt es einen Vierten Aggregatzustand?",
		"Pi * X² * V / (Pi * 3 / 9) * ((42³ / 3600) + ((42/100) + 3))?",
		"V?",
		"X?",
		"???",
		"220 550",
		"OCT"
	];
	app.state = false; // toggled

	app.init = function() {
		let search = document.getElementById('mist-search');
		search.addEventListener('focus', function(){
			search.placeholder = placeHolders[Math.floor(Math.random() * placeHolders.length)];
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
