<?php namespace Verein\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function boot()
	{
		View::composer('*', function(\Illuminate\View\View $view) {
			$view->with('session', \Session::all());

			if (\Sentinel::check()) {
				$view->with('user', \Sentinel::getUser());
			}
		});
	}

	/**
	 * Register
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
