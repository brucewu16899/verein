<?php namespace Verein\Providers;

use Illuminate\Support\ServiceProvider;

class MarkdownServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		\App::bind('markdown', function() {
			$parser = new \cebe\markdown\GithubMarkdown();
			$parser->html5 = true;
			$parser->keepListStartNumber = true;

			return $parser;
		});
	}

}
