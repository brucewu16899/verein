<?php namespace Verein\Extensions;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\Authenticatable;

use Sentinel;

class SentinelGuard implements StatefulGuard
{
	/**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
    	return !Sentinel::guest();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
    	return Sentinel::guest();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
    	\Log::info('get user !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
    	return Sentinel::getUser();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
    	if ($this->check())
    		return Sentinel::getUser()->id;

    	return null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
    	$user = Sentinel::findUserByCredentials($credentials);
    	if (!$user)
    		return false;

    	return Sentinel::validateCredentials($credentials);
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {

    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @param  bool   $remember
     * @param  bool   $login
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false, $login = true)
    {
    	return Sentinel::authenticate($credentials, $remember);
    }

    /**
     * Log a user into the application without sessions or cookies.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function once(array $credentials = [])
    {
    	return Sentinel::stateless($credentials);
    }

    /**
     * Log a user into the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  bool  $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false)
    {
    	Sentinel::login($user, $remember);
    }

    /**
     * Log the given user ID into the application.
     *
     * @param  mixed  $id
     * @param  bool   $remember
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function loginUsingId($id, $remember = false)
    {
    	$user = Sentinel::findUserById($id);
    	if (!$user)
    		return false;

    	return Sentinel::login($user, $remember);
    }

    /**
     * Log the given user ID into the application without sessions or cookies.
     *
     * @param  mixed  $id
     * @return bool
     */
    public function onceUsingId($id)
    {
    	$user = Sentinel::findUserById($id);
    	if (!$user)
    		return false;

    	// ToDo: Have to pass credentials
    	Sentinel::stateless($user);
    }

    /**
     * Determine if the user was authenticated via "remember me" cookie.
     *
     * @return bool
     */
    public function viaRemember()
    {
    	// TODO: Implement
    	return false;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
    	Sentinel::logout();
    }
}
