<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The MemberProfile stores addition information about the member.
 *
 * @property int $id
 * @property int $member_id
 * @property int $user_id
 * @property string $type
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property Member $member
 * @property User $creator
 */
class MemberDate extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'member_id',
		'type',
		'value',
	];

	/**
	 * Table of the model.
	 *
	 * @var string
	 */
	protected $table = 'member_dates';

	/**
	 * Get the Member for this comment.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function member()
	{
		return $this->belongsTo('\Verein\Member', 'member_id');
	}

	/**
	 * Get the User who created the comment.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo('\Verein\User', 'user_id');
	}

	/**
	 * Returns the escaped value with html line breaks.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function getValueAttribute($value)
	{
		return nl2br(strip_tags($value));
	}
}
