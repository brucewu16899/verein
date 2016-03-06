<?php namespace Verein\Http\Controllers;

class DashboardController extends Controller
{
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('dashboard');
	}
}
