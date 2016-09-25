<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Member of the club.
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $form_of_address
 * @property string $email
 * @property string $sex
 * @property string $birthday
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property string $name
 *
 * @property User $creator
 * @property User $user
 * @property MemberComment[] $comments
 * @property MemberDate[] $dates
 */
class Member extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'members';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'form_of_address',
		'email',
		'sex',
		'birthday',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'birthday',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	/**
	 * Get the user who created the member.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo('\Verein\User');
	}

	/**
	 * Get the user who is assigned to this member.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user()
	{
		return $this->hasOne('\Verein\User');
	}

	/**
	 * Return comments.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function comments()
	{
		return $this->hasMany('Verein\MemberComment');
	}

	/**
	 * Return dates.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function dates()
	{
		return $this->hasMany('Verein\MemberDate');
	}

	/**
	 * Get the email address of the user if the member email is empty and a user exists.
	 * Otherwise return the member email.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function getEmailAttribute($value)
	{
		if (empty($value) && isset($this->user->id) && !empty($this->user->email))
			return $this->user->email;
		else
			return $value;
	}

	/**
	 * Return the translated sex of the member.
	 *
	 * @param string $default
	 *
	 * @return string
	 */
	public function getSexAttribute($default)
	{
		if (!empty($default))
			return trans('member.sex.' . $default);
		else
			return '';
	}

	/**
	 * Get the name of the Member.
	 *
	 * If the member name is empty and a user is set, return the name of the user.
	 *
	 * @return string
	 */
	public function getNameAttribute()
	{
		if (!empty($this->first_name) || !empty($this->last_name)) {
			$parts = [];

			if (!empty($this->form_of_address))
				$parts[] = $this->form_of_address;

			if (!empty($this->first_name))
				$parts[] = $this->first_name;

			if (!empty($this->last_name))
				$parts[] = $this->last_name;

			return implode(' ', $parts);
		} else if (isset($this->user->id) && !empty($this->user->name)) {
			return $this->user->name;
		} else {
			return '';
		}
	}
}
