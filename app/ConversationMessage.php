<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The Message is a message between one User and another.
 *
 * @property int $id
 * @property int $conversation_id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property string $message
 * @property bool $read
 * @property string $read_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property string $humanDiff
 *
 * @property User $sender
 * @property User $receiver
 */
class ConversationMessage extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'conversation_id',
		'from_user_id',
		'to_user_id',
		'message',
	];

	/**
	 * Get the difference between the date where the message was created and now
	 * in a human readable format e.g. "10 minutes ago".
	 *
	 * @return string
	 */
	public function getHumanDiffAttribute()
	{
		return $this->created_at->diffForHumans(null, true);
	}

	/**
	 * Return the formatted message.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function getMessageAttribute($value)
	{
		return \Markdown::parse($value);
	}

	/**
	 * Get the MessageConversation of the message.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function conversation()
	{
		return $this->belongsTo('Verein\ConversationMessage', 'conversation_id');
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
	 * Scope for unread messages.
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
	 * Scope for the last conversations orderd by last message.
	 *
	 * ToDo: Optimize with join
	 *
	 * @param Illuminate\Database\Query\Builder $query
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public function scopeConversations($query)
	{
		return $query
			->from(\DB::raw('(select * from `conversation_messages` order by `created_at` desc) as `conversation_messages`'))
			->groupBy('conversation_id');
	}

	/**
	 * Returns all Messages where a User is part of the conversation.
	 *
	 * @param Illuminate\Database\Query\Builder $query
	 * @param int $userId (Default: null)
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public function scopeUser($query, $userId = null)
	{
		if (empty($userId))
			$userId = \Sentinel::getUser()->id;

		return $query
			->where('from_user_id', $userId)
			->orWhere('to_user_id', $userId);
	}

	/**
	 * Get the unread notifications for a user.
	 *
	 * @param Illuminate\Database\Query\Builder $query
	 * @param int $userId (Default: null)
	 *
	 * @return Illuminate\Database\Query\Builder
	 */
	public function scopeUnreadReceiver($query, $userId = null)
	{
		if (empty($userId))
			$userId = \Sentinel::getUser()->id;

		return $query
			->where(function(\Illuminate\Database\Query\Builder $query) use ($userId) {
				$query
					->where('read', '=', 0)
					->where('to_user_id', $userId);
			});
	}
}
