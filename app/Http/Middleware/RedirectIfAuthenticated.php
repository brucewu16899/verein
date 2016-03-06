<?php namespace Verein\Http\Middleware;

use Closure;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!\Sentinel::guest())
			return redirect()->route('dashboard');

		return $next($request);
	}
}
