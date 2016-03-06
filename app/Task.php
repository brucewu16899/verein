<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;

/**
 * The Task is a generic task. It can be further specialized by data stored in other objects.
 *
 * @property int $id
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
 * @property User $completedBy
 * @property TaskJob[] $jobs
 * @property User[] $users
 */
class Task extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks';

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'completed' => 'boolean',
	];

	/**
	 * Scope of all not completed tasks.
	 *
	 * @param Illuminate\Database\Query\Builder $query
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public function scopeNotCompleted($query)
	{
		return $query->where('completed', '=', '0');
	}

	/**
	 * Get the creator of this Task.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo('Verein\User', 'user_id');
	}

	/**
	 * Get the User who completed the Task.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function completedBy()
	{
		return $this->belongsTo('Verein\User', 'completed_by_user_id');
	}

	/**
	 * Return underlying jobs of this task.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function jobs()
	{
		return $this->hasMany('Verein\TaskJob');
	}

	/**
	 * Return users assigned to this task.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('Verein\User', 'tasks_users', 'task_id', 'assigned_user_id');
	}

	/**
	 * Get the progress in percent for this task and underlying jobs.
	 *
	 * @return int
	 */
	public function getProgressAttribute()
	{
		// If no underlying jobs, return if task is completed
		if (count($this->jobs) === 0)
			return ($this->completed) ? 100 : 0;

		$completed = 0;
		$sum = 0;
		foreach ($this->jobs as $job) {
			$sum++;
			if ($job->completed)
				$completed++;
		}

		return round(($completed / $sum) * 100);
	}

	/**
	 * User completed this task.
	 *
	 * @param \Verein\User $user
	 *
	 * @return \Verein\Task
	 */
	public function complete(User $user)
	{
		$this->completed = true;
		$this->completed_at = \Carbon\Carbon::now();
		$this->completed_by_user_id = $user->id;

		return $this;
	}
}
