<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The TaskJobMember stores which TaskJob was assigned to which User.
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_job_id
 * @property int $assigned_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property User $creator
 * @property TaskJob $job
 * @property User $member
 */
class TaskJobUser extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks_jobs_users';

	/**
	 * Get the creator of this TaskJobMember.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo('Verein\User', 'user_id');
	}

	/**
	 * Get the job belonging to this relationship.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function job()
	{
		return $this->belongsTo('Verein\TaskJob', 'task_job_id');
	}

	/**
	 * Get the user assigned to this job.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('Verein\User', 'assigned_user_id');
	}
}
