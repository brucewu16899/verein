<?php namespace Verein\Http\Controllers\Notification;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\Notification;

class NotificationController extends Controller
{
	/**
	 * Label notification as read
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function labelRead(Request $request, $id)
	{
		$notification = Notification::findOrFail($id);
		$notification
			->labelRead()
			->save();

		if ($request->ajax())
			return [
				'notification' => $notification,
				'success' => true,
			];
		else
			return redirect()->back();
	}

	/**
	 * Label notification as unread
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function labelUnread(Request $request, $id)
	{
		$notification = Notification::findOrFail($id);
		$notification
			->labelUnread()
			->save();

		if ($request->ajax())
			return [
				'notification' => $notification,
				'success' => true,
			];
		else
			return redirect()->back();
	}
}
