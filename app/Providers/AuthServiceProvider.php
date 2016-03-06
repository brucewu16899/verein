<?php namespace Verein\Providers;

use Illuminate\Support\ServiceProvider;

use Verein\Extensions\SentinelGuard;

use Auth;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Auth::extend('sentinel', function($app, $name, array $config) {
			return new SentinelGuard(Auth::createUserProvider($config['provider']));
		});
	}

	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
