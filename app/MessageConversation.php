<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The MessageConversation stores which TaskJob was assigned to which Member.
 *
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property string $name
 *
 * @property User $sender
 * @property User $receiver
 */
class MessageConversation extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'messages_conversations';

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
	 * Get the Messages of the MessageConversation.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function messages()
	{
		return $this->hasMany('Verein\Message', 'message_conversation_id')
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
}
