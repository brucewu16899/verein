<?php namespace Verein;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Cartalyst\Sentinel\Users\EloquentUser;

use Activation;
use Ban;

/**
 * A user is person who can login into the system.
 *
 * Only the most important data is saved alongside the User like email, password and the name.
 * Most datasets store the User ID to remember which logged in User created the data.
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $permissions
 * @property string $last_login
 * @property string $first_name
 * @property string $last_name
 * @property string $timezone
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property string $name
 * @property string $avatarPath
 * @property string $avatarUrl
 * @property bool $isBanned
 * @property bool $isActivated
 *
 * @property Member $member
 * @property Message[] $recentMessages
 * @property Message[] $unreadMessages
 * @property Notification[] $recentNotifications
 * @property Notification[] $unreadNotifications
 * @property Task[] $notCompletedTasks
 * @property Session[] $sessions
 * @property Ban $banRelation
 */
class User extends EloquentUser implements AuthenticatableContract
{
	use Authenticatable;
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token'
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'last_login',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	/**
	 * The Eloquent bans model name.
	 *
	 * @var string
	 */
	protected static $bansModel = \Verein\Extensions\EloquentBan::class;

	/**
	 * Get the complete name of the user.
	 *
	 * @return string
	 */
	public function getNameAttribute()
	{
		if (empty($this->first_name) || empty($this->last_name))
			return $this->email;
		else
			return $this->first_name . ' ' . $this->last_name;
	}

	/**
	 * Get the absolute path to the avatar.
	 *
	 * @return string
	 */
	protected function getAvatarPathAttribute()
	{
		return public_path() . '/images/avatar/' . $this->id . '.png';
	}

	/**
	 * Get the absolute url to the avatar.
	 *
	 * @return string
	 */
	public function getAvatarUrlAttribute()
	{
		if (!file_exists($this->avatarPath))
			$this->createAvatar();

		return \Config::get('app.url') . '/images/avatar/' . $this->id . '.png';
	}

	/**
	 * Check if the user is banned.
	 *
	 * @return bool
	 */
	public function getIsBannedAttribute()
	{
		return Ban::banned($this);
	}

	/**
	 * Check if the user is activated.
	 *
	 * @return bool
	 */
	public function getIsActivatedAttribute()
	{
		return (Activation::completed($this) !== false);
	}

	/**
	 * Get the activation date of the user or NULL if the user is not yet activated.
	 *
	 * @return mixed
	 */
	public function getActivatedAtAttribute()
	{
		$activation = Activation::where('user_id', $this->id)
			->first();

		if ($activation === null)
			return null;
		else
			return new \Carbon\Carbon($activation->completed_at);
	}

	/**
	 * Get the Member for this User.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function member()
	{
		return $this->belongsTo('\Verein\Member');
	}

	/**
	 * Get the last 10 messages for this user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function recentMessages()
	{
		return $this->hasMany('Verein\Message', 'to_user_id')
			->user()
			->conversations()
			->limit(10);
	}

	/**
	 * Get all unread messages for this user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function unreadMessages()
	{
		return $this->hasMany('Verein\Message', 'to_user_id')
			->unread();
	}

	/**
	 * Get the last 10 notifications for this user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function recentNotifications()
	{
		return $this->hasMany('Verein\Notification', 'to_user_id')
			->recent();
	}

	/**
	 * Get all unread notifications for this user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function unreadNotifications()
	{
		return $this->hasMany('Verein\Notification', 'to_user_id')
			->unread();
	}

	/**
	 * Returns the ban relationship.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function banRelation()
	{
		return $this->hasOne(static::$bansModel, 'user_id');
	}

	/**
	 * Get all sessions for this user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sessions()
	{
		return $this->hasMany('Verein\Session');
	}

	/**
	 * Get all unread messages for this user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function notCompletedTasks()
	{
		return $this->belongsToMany('Verein\Task', 'tasks_users', 'assigned_user_id')
			->notCompleted();
	}

	/**
	 * Scope for all activated users.
	 *
	 * @param Illuminate\Database\Query\Builder $query
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public function scopeActivated($query)
	{
		return $query
			->join('activations', 'users.id', '=', 'activations.user_id')
			->where('activations.completed', '=', 1);
	}

	/**
	 * Scope for all not activated users.
	 *
	 * @param Illuminate\Database\Query\Builder $query
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public function scopeNotActivated($query)
	{
		return $query
			->join('activations', 'users.id', '=', 'activations.user_id')
			->where('activations.completed', '=', 0);
	}

	/**
	 * Create a new avatar fir this user. Overwrites the old one if it exists.
	 *
	 * @return bool
	 */
	public function createAvatar()
	{
		$identicon = new \Identicon\Identicon();

		\File::put($this->avatarPath, $identicon->getImageData($this->id, 164, null, "#ffffff"));
		return (file_exists($this->avatarPath));
	}

	/**
	 * Activates the user.
	 *
	 * @return bool
	 */
	public function activate()
	{
		$activation = Activation::exists($this);
		if ($activation === false)
			return false;

		return Activation::complete($this, $activation->code);
	}

	/**
	 * Ban the user.
	 *
	 * @return void
	 */
	public function ban()
	{
		Ban::ban($this);
	}

	/**
	 * Unban the user.
	 *
	 * @return void
	 */
	public function unban()
	{
		Ban::unban($this);
	}
}
