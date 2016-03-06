<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;

/**
 * A Notification notifies a User about an event triggered by another User or the system.
 *
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property string $icon
 * @property string $message
 * @property string $message_parameters
 * @property string $url
 * @property string $url_parameters
 * @property bool read
 * @property string $read_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property User $sender
 * @property User $receiver
 */
class Notification extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'notifications';

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'read' => 'boolean',
		'message_parameters' => 'array',
		'url_parameters' => 'array',
	];

	/**
	 * Create a new notification.
	 *
	 * @param array $parameters
	 *        int from_user_id
	 *        int to_user_id
	 *        string icon
	 *        string message
	 *        array message_parameters (optional)
	 *        string url (optional)
	 *        array url_parameters (optional)
	 *
	 * @return bool
	 */
	public static function notify(array $parameters)
	{
		// Do not notify if user raises event by himself
		if ($parameters['from_user_id'] == $parameters['to_user_id'])
			return;

		$notification = self::create([
			'from_user_id' => $parameters['from_user_id'],
			'to_user_id' => $parameters['to_user_id'],
			'icon' => $parameters['icon'],
			'message' => $parameters['message'],
			'message_parameters' => isset($parameters['message_parameters'])
				? $parameters['message_parameters']
				: [],
			'url' => isset($parameters['url']) ? $parameters['url'] : '',
			'url_parameters' => isset($parameters['url_parameters'])
				? $parameters['url_parameters']
				: [],
		]);

		if ($notification === null)
			\Log::error('Notification could not be created: ' . serialize($parameters));

		return $notification;
	}

	/**
	 * Get the sender of the message.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sender()
	{
		return $this->belongsTo('Verein\User', 'from_user_id');
	}

	/**
	 * Get the receiver of the message.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function receiver()
	{
		return $this->belongsTo('Verein\User', 'to_user_id');
	}

	/**
	 * Scope for unread notifications.
	 *
	 * @param Illuminate\Database\Query\Builder $query
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public function scopeUnread($query)
	{
		return $query->where('read', '=', '0');
	}

	/**
	 * Scope for the last notifications.
	 *
	 * @param Illuminate\Database\Query\Builder $query
	 * @param int $limit (Default: 10)
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public function scopeRecent($query, $limit = 10)
	{
		return $query
			->orderBy('created_at', 'desc')
			->limit($limit);
	}

	/**
	 * Label notification as read.
	 *
	 * @return \Verein\Notification
	 */
	public function labelRead()
	{
		$this->read = true;
		$this->read_at = \Carbon\Carbon::now();

		return $this;
	}

	/**
	 * Label notification as uread.
	 *
	 * @return \Verein\Notification
	 */
	public function labelUnread()
	{
		$this->read = false;
		$this->read_at = null;

		return $this;
	}
}
