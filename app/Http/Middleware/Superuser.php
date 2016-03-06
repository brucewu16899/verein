<?php namespace Verein\Http\Middleware;

use Illuminate\Http\Request;

use Closure;

class Superuser
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		if (\Sentinel::guest()) {
			if ($request->ajax())
				return response('Unauthorized.', 401);
			else
				return redirect()->route('account.login');
		}

		if (!\Sentinel::hasAccess('superuser')) {
			if ($request->ajax())
				return response('Unauthorized.', 401);
			else
				return redirect()->route('dashboard');
		}

		return $next($request);
	}

}
