<?php namespace Verein\Extensions;

use Cartalyst\Sentinel\Checkpoints\CheckpointInterface;
use Cartalyst\Sentinel\Checkpoints\AuthenticatedCheckpoint;
use Cartalyst\Sentinel\Users\UserInterface;

use Verein\Extensions\BanRepository;
use Verein\Extensions\BannedException;

class BanCheckpoint implements CheckpointInterface
{
	use AuthenticatedCheckpoint;

	/**
	 * The bans repository.
	 *
	 * @var \Verein\Extensions\BanRepository
	 */
	protected $bans;

	/**
	 * Create a new activation checkpoint.
	 *
	 * @param \Cartalyst\Sentinel\bans\BanRepository $bans
	 */
	public function __construct(BanRepository $bans)
	{
		$this->bans = $bans;
	}

	/**
	 * {@inheritDoc}
	 */
	public function login(UserInterface $user)
	{
		return $this->checkBan($user);
	}

	/**
	 * {@inheritDoc}
	 */
	public function check(UserInterface $user)
	{
		return $this->checkBan($user);
	}

	/**
	 * Checks the ban status of the given user.
	 *
	 * @param \Cartalyst\Sentinel\Users\UserInterface $user
	 * @return bool
	 * @throws \Verein\Extensions\BannedException
	 */
	protected function checkBan(UserInterface $user)
	{
		$banned = $this->bans->banned($user);

		if ($banned) {
			$exception = new BannedException('Your account has been banned.');

			$exception->setUser($user);

			throw $exception;
		}
	}
}
