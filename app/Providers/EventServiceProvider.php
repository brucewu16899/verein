<?php namespace Verein\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Verein\User;
use Verein\Member;
use Verein\MemberComment;

use Verein\Notification;

use Verein\Task;
use Verein\TaskJob;
use Verein\TaskUser;
use Verein\TaskJobUser;

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

		// MemberComment about to be created
		MemberComment::creating(function(MemberComment $memberComment) {
			if (\Sentinel::check())
				$memberComment->user_id = \Sentinel::getUser()->id;
		});
	}

	/**
	 * Register task events.
	 *
	 * @return void
	 */
	protected function bootTasks()
	{
		// User assigned user to task
		TaskUser::created(function(TaskUser $taskMember) {
			Notification::notify([
				'from_user_id' => $taskMember->user_id, // User who assigned the task
				'to_user_id' => $taskMember->user->id, // User who was assigned
				'icon' => 'tasks',
				'message' => 'notification.task.assigned',
				'message_parameters' => [
					'task' => $taskMember->task->title,
				],
				'url' => 'task.view',
				'url_parameters' => [
					'id' => $taskMember->task->id,
				],
			]);
		});

		// User assigned user to job
		TaskJobUser::created(function(TaskJobUser $taskJobUser) {
			Notification::notify([
				'from_user_id' => $taskJobUser->user_id, // User who assigned the job
				'to_user_id' => $taskJobUser->user->id, // User who was assigned
				'icon' => 'tasks',
				'message' => 'notification.task.job.assigned',
				'message_parameters' => [
					'job' => $taskJobUser->job->title,
					'task' => $taskJobUser->job->task->title,
				],
				'url' => 'task.job.view',
				'url_parameters' => [
					'id' => $taskJobUser->job->id,
				],
			]);
		});

		// User created new job for task
		TaskJob::created(function(TaskJob $taskJob) {
			foreach ($taskJob->task->users as $user) {
				Notification::notify([
					'from_user_id' => $taskJob->user_id, // User who created the job
					'to_user_id' => $user->id, // One of the users who is assigned to the parent task or one of the jobs
					'icon' => 'tasks',
					'message' => 'notification.task.job.created',
					'message_parameters' => [
						'job' => $taskJob->title,
						'task' => $taskJob->task->title,
					],
					'url' => 'task.job.view',
					'url_parameters' => [
						'id' => $taskJob->id,
					],
				]);
			}
		});

		// Task about to be created
		Task::creating(function(Task $task) {
			if (\Sentinel::check())
				$task->user_id = \Sentinel::getUser()->id;
		});

		// Task user assignment about to be created
		TaskUser::creating(function(TaskUser $taskMember) {
			if (\Sentinel::check())
				$taskMember->user_id = \Sentinel::getUser()->id;
		});

		// Job about to be created
		TaskJob::creating(function(TaskJob $taskJob) {
			if (\Sentinel::check())
				$taskJob->user_id = \Sentinel::getUser()->id;
		});

		// Job user assignment about to be created
		TaskJobUser::creating(function(TaskJobUser $taskJobUser) {
			if (\Sentinel::check())
				$taskJobUser->user_id = \Sentinel::getUser()->id;
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
		$this->bootTasks();
	}
}
