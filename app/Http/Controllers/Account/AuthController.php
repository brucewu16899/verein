<?php namespace Verein\Http\Controllers\Account;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;

class AuthController extends Controller
{
	/**
	 * Rules for users who tries to log in.
	 *
	 * @var array
	 */
	protected $loginUserRules = [
		'email' => 'required|email',
		'password' => 'required',
	];

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function login()
	{
		return view('auth.login');
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function doLogin(Request $request)
	{
		$this->validate($request, $this->loginUserRules);

		$credentials = $request->only('email', 'password');
		$error = trans('auth.login.wrong-credentials');

		try {
			$user = \Sentinel::authenticate($credentials, $request->has('remember'));
		} catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exception) {
			$user = false;
			$error = trans('auth.login.not-activated');
		} catch (\Verein\Extensions\BannedException $exception) {
			$user = false;
			$error = trans('auth.login.banned');
		} catch (Cartalyst\Sentinel\Checkpoints\ThrottlingException $exception) {
			$user = false;
			$error = trans('auth.login.throttled');
		}

		if ($user !== false)
			return redirect()->intended(route('dashboard'));
		else
			return redirect()
				->route('account.login')
				->withInput($request->only('email', 'remember'))
				->withErrors([
					'email' => $error,
				]);
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout()
	{
		\Sentinel::logout();

		return redirect()->route('account.login');
	}
}
