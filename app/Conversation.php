<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The Conversation stores conversation meta data.
 *
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property string $title
 * @property string $abstract
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property User $sender
 * @property User $receiver
 */
class Conversation extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'from_user_id',
		'to_user_id',
	];

	/**
	 * Generate a title based on sender and receiver name.
	 *
	 * @return string
	 */
	public function getTitleAttribute()
	{
		return trim($this->sender->name . ' - ' . $this->receiver->name);
	}

	/**
	 * Get the first 100 characters of the last message.
	 *
	 * @return string
	 */
	public function getAbstractAttribute()
	{
		if (isset($this->lastMessage))
			return \Markdown::parseParagraph(substr($this->lastMessage->getOriginal('message'), 0, 100));
		else
			return '';
	}

	/**
	 * Get the last message contents.
	 *
	 * @return string
	 */
	public function getLastMessageAttribute()
	{
		if (count($this->messages) > 0)
			return $this->messages->last();
		else
			return null;
	}

	/**
	 * Get the Messages of the MessageConversation.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function messages()
	{
		return $this->hasMany('Verein\ConversationMessage', 'conversation_id')
			->orderBy('created_at', 'asc');
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
	 * Returns all Conversations where a User is part of the conversation.
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
}
