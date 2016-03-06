<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The TaskJob is a subtask of a Task.
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $title
 * @property bool $completed
 * @property string $completed_at
 * @property int $completed_by_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property User $creator
 * @property Task $task
 * @property Member $completedBy
 */
class TaskJob extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks_jobs';

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'completed' => 'boolean',
	];

	/**
	 * Get the creator of this TaskJob.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo('Verein\User', 'user_id');
	}

	/**
	 * Get the task belonging to this job.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function task()
	{
		return $this->belongsTo('Verein\Task', 'task_id');
	}

	/**
	 * Get the User who completed the TaskJob.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function completedBy()
	{
		return $this->belongsTo('Verein\User', 'completed_by_user_id');
	}

	/**
	 * User completed this job.
	 *
	 * @param \Verein\User $user
	 *
	 * @return \Verein\TaskJob
	 */
	public function complete(User $user)
	{
		$this->completed = true;
		$this->completed_at = \Carbon\Carbon::now();
		$this->completed_by_user_id = $user->id;

		return $this;
	}
}
