<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The TaskUser stores which Task was assigned to which User.
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property int $assigned_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property User $creator
 * @property Task $task
 * @property User $user
 */
class TaskUser extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks_users';

	/**
	 * Get the creator of this assignment.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo('Verein\User', 'user_id');
	}

	/**
	 * Get the task belonging to this assignment.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function task()
	{
		return $this->belongsTo('Verein\Task');
	}

	/**
	 * Get the user belonging to this assignment.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('Verein\User', 'assigned_user_id');
	}
}
