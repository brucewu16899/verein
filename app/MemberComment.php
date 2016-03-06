<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * The MemberProfile stores addition information about the member.
 *
 * @property int $id
 * @property int $member_id
 * @property int $user_id
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property string $htmlContent
 *
 * @property Member $member
 * @property User $creator
 */
class MemberComment extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'members_comments';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'member_id',
		'comment',
	];

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
	 * Get the html content of the comment.
	 *
	 * @return string
	 */
	public function getHtmlContentAttribute()
	{
		return \Markdown::parse($this->comment);
	}
}
