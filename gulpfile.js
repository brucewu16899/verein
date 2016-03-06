var elixir = require("laravel-elixir");

elixir(function(mix) {
	// Build stylesheets
	mix
		.less(["main.less"])
		.styles([
			"../components/bootstrap/dist/css/bootstrap.min.css",
			"../components/admin-lte/dist/css/AdminLTE.min.css",
			"../components/admin-lte/dist/css/skins/skin-black.min.css",
			"../../../public/css/app.css"
		]);

	// Build scripts
	mix
		.scripts(
			[
				"app.js"
			],
			"public/js/app.js",
			"resources/assets/js"
		)
		.scripts(
			[
				"jquery/dist/jquery.js",
				"bootstrap/dist/js/bootstrap.js",
				"admin-lte/dist/js/app.js"
			],
			"public/js/vendor.js",
			"resources/assets/components"
		);

	// Versioning files
	mix.version([
		"css/all.css",
		"js/vendor.js",
		"js/app.js"
	]);

	// Copy fonts
	mix.copy("resources/assets/components/fontawesome/fonts", "public/fonts");

	// Copy flags
	mix.copy("resources/assets/components/flag-icon-css/flags", "public/images/flags");
});
