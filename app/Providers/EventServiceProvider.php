<?php namespace Verein\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Verein\User;
use Verein\Member;
use Verein\MemberDate;

use Verein\Notification;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
	];

	/**
	 * Register user and member events.
	 *
	 * @return void
	 */
	protected function bootUsers()
	{
		// Create member with user
		User::created(function(User $user) {
			// Save ID of user who created the member
			$member = new Member;
			if (\Sentinel::check())
				$member->user_id = \Sentinel::getUser()->id;
			$member->save();

			// Save ID of the member in the user model
			$user->member_id = $member->id;
			$user->save();
		});

		// Member about to be created
		Member::creating(function(Member $member) {
			if (\Sentinel::check())
				$member->user_id = \Sentinel::getUser()->id;
		});

		// MemberDate about to be created
		MemberDate::creating(function(MemberDate $memberComment) {
			if (\Sentinel::check())
				$memberComment->user_id = \Sentinel::getUser()->id;
		});
	}

	/**
	 * Register events.
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();

		$this->bootUsers();
	}
}
