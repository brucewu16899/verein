<?php namespace Verein\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use DispatchesJobs;
    use ValidatesRequests;

	/**
	 * Default number of items displayed on one page.
	 *
	 * @var int
	 */
	const DEFAULT_PAGE_SIZE = 30;
}
