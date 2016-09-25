<?php

Route::group(['middleware' => ['web', 'guest']], function() {
	/**
	 * Account
	 */
	Route::get('/login', [
		'as' => 'account.login',
		'uses' => 'Account\AuthController@login',
	]);
	Route::post('/login', [
		'as' => 'account.doLogin',
		'uses' => 'Account\AuthController@doLogin',
	]);

	Route::get('/register', [
		'as' => 'account.register',
		'uses' => 'Account\AuthController@register',
	]);

	Route::post('/register', [
		'as' => 'account.doRegister',
		'uses' => 'Account\AuthController@doRegister',
	]);
});

Route::group(['middleware' => ['web', 'auth']], function() {
	/**
	 * Account
	 */
	Route::get('/logout', [
		'as' => 'account.logout',
		'uses' => 'Account\AuthController@logout',
	]);

	Route::get('/profile', [
		'as' => 'user.profile',
		'uses' => 'User\ProfileController@profile',
	]);

	Route::get('/profile/logout/{session}', [
		'as' => 'user.profile.logout',
		'uses' => 'User\ProfileController@logout',
	]);

	/**
	 * Dashboard
	 */
	Route::get('/', [
		'as' => 'dashboard',
		'uses' => 'DashboardController@index'
	]);

	/**
	 * Notifications
	 */
	Route::group(['namespace' => 'Notification'], function() {
		Route::get('/notification/{notification}/read', [
			'as' => 'notification.read',
			'uses' => 'NotificationController@labelRead',
		]);
		Route::get('/notification/{notification}/unread', [
			'as' => 'notification.unread',
			'uses' => 'NotificationController@labelUnread',
		]);
	});

	/**
	 * Conversations/Messages
	 */
	Route::group(['namespace' => 'Conversation'], function() {
		Route::resource('conversation', 'ConversationController', [
			'except' => ['create', 'edit', 'update', 'destroy'],
		]);

		Route::resource('conversation.message', 'ConversationMessageController', [
			'except' => ['index', 'show', 'edit', 'update', 'destroy'],
		]);
	});
});

Route::group(['middleware' => ['web', 'superuser']], function() {
	Route::group(['namespace' => 'User'], function() {
		/**
		 * Users
		 */
		Route::post('/user/{user}/ban', [
			'as' => 'user.ban',
			'uses' => 'UserController@ban',
		]);
		Route::post('/user/{user}/unban', [
			'as' => 'user.unban',
			'uses' => 'UserController@unban',
		]);
		Route::post('/user/{user}/activate', [
			'as' => 'user.activate',
			'uses' => 'UserController@activate',
		]);
		Route::resource('user', 'UserController', [
			'except' => ['create', 'destroy', 'edit'],
		]);

		/**
		 * Members
		 */
		Route::resource('member', 'MemberController');

		Route::resource('member.profile', 'MemberProfileController', [
			'except' => ['index', 'show'],
		]);

		Route::resource('member.comment', 'MemberCommentController', [
			'except' => ['index', 'show'],
		]);

		Route::resource('member.date', 'MemberDateController', [
			'except' => ['index', 'show'],
		]);
	});
});
