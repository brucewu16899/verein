<?php namespace Verein\Http\Controllers\User;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\Session;

class ProfileController extends Controller
{
	/**
	 * Display the profile page of the user.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function profile()
	{
		return view('user/profile');
	}

	/**
	 * Logout from a session.
	 *
	 * @param string $sessionId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout($sessionId)
	{
		$session = Session::findOrFail($sessionId);

		$session->delete();

		return redirect()->route('user.profile');
	}
}
