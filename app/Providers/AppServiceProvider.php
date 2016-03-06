<?php namespace Verein\Providers;

use Illuminate\Support\ServiceProvider;

use Verein\Extensions\BanRepository;
use Verein\Extensions\BanCheckpoint;

class AppServiceProvider extends ServiceProvider {

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
	 * @return void
	 */
	public function register()
	{
		$checkpoint = new BanCheckpoint(new BanRepository);
		\Sentinel::addCheckpoint('ban', $checkpoint);

		$this->app->singleton('sentinel.bans', function($app) {
			$config = $app['config']->get('cartalyst.sentinel');

			$model = array_get($config, 'bans.model');

			return new BanRepository($model);
		});
	}

}
