<?php namespace Verein\Extensions;

use Cartalyst\Support\Traits\RepositoryTrait;
use Cartalyst\Sentinel\Users\UserInterface;

/**
 * Repository for user bans.
 *
 * @method \Illuminate\Database\Query\Builder newQuery()
 */
class BanRepository
{
	use RepositoryTrait;

	/**
	 * The Eloquent ban model name.
	 *
	 * @var string
	 */
	protected $model = \Verein\Extensions\EloquentBan::class;

	/**
	 * Create a new Illuminate ban repository.
	 *
	 * @param string $model
	 */
	public function __construct($model = null)
	{
		if (isset($model))
			$this->model = $model;
	}

	/**
	 * {@inheritDoc}
	 */
	public function ban(UserInterface $user)
	{
		$ban = $this->createModel();
		$ban->user_id = $user->getUserId();
		$ban->save();

		return $ban;
	}

	/**
	 * {@inheritDoc}
	 */
	public function unban(UserInterface $user)
	{
		if (!$this->banned($user))
			return true;

		return ($this->newQuery()
			->where('user_id', $user->getUserId())
			->delete() > 0);
	}

	/**
	 * {@inheritDoc}
	 */
	public function banned(UserInterface $user)
	{
		return $this->newQuery()
			->where('user_id', $user->getUserId())
			->exists();
	}
}
