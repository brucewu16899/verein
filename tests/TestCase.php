<?php

use Illuminate\Database\Eloquent\Model;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
	/**
	 * Create fake data.
	 *
	 * @var \Faker\Generator
	 */
	protected $faker;

	/**
	 * Base URL
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://localhost';

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->baseUrl = env('APP_URL');
	}

	/**
	 * Default preparation for each test
	 */
	public function setUp()
	{
		parent::setUp();

		// Migrate database
		Artisan::call('migrate');

		// To create test models
		Model::unguard();

		// Logout - just to be sure
		\Sentinel::logout();
	}

	/**
	 * Reset database.
	 */
	public function tearDown()
	{
		parent::tearDown();
	}

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		$this->faker = \Faker\Factory::create();
		$this->faker->seed(1);

		return $app;
	}

	/**
	 * @inheritdoc
	 */
	public function be(Illuminate\Contracts\Auth\Authenticatable $user, $driver = null)
	{
		\Sentinel::login($user);
	}

	/**
	 * Create new random User.
	 *
	 * @param string $password
	 * @param bool $activate
	 *
	 * @return \Verein\User
	 */
	protected function createUser($password = '123456', $activate = true)
	{
		$lastLogin = $this->faker->dateTime();

		$user = \Sentinel::register([
			'email' => $this->faker->email,
			'password' => $password,
			'last_login' => $lastLogin,
			'first_name' => $this->faker->firstName,
			'last_name' => $this->faker->lastName,
		]);

		$activation = Activation::create($user);
		if ($activate)
			Activation::complete($user, $activation->code);

		return $user;
	}

	/**
	 * Create new random superuser.
	 *
	 * @param string $password
	 *
	 * @return \Verein\User
	 */
	protected function createSuperuser($password = '123456')
	{
		$lastLogin = $this->faker->dateTime();

		$admin = \Sentinel::registerAndActivate([
			'email' => $this->faker->email,
			'password' => $password,
			'last_login' => $lastLogin,
			'first_name' => $this->faker->firstName,
			'last_name' => $this->faker->lastName,
		]);

		$adminRole = Sentinel::findRoleBySlug('superuser');

		if ($adminRole === null) {
			$adminRole = Sentinel::getRoleRepository()->createModel()->create([
				'name' => 'Superuser',
				'slug' => 'superuser',
			]);

			$adminRole->addPermission('superuser')->save();
		}

		$adminRole->users()->attach($admin);

		return $admin;
	}

	/**
	 * Create new random Member.
	 *
	 * @return \Verein\Member
	 */
	protected function createMember()
	{
		return \Verein\Member::create([
			'first_name' => $this->faker->firstName,
			'last_name' => $this->faker->lastName,
			'email' => $this->faker->email,
			'website' => $this->faker->url,
			'sex' => $this->faker->boolean(50) ? 'male' : 'female',
			'birthday' => $this->faker->date,
		]);
	}

	/**
	 * Create a random MemberComment.
	 *
	 * @param VisualAppeal\Connect\Member $member (Default: null, newly created)
	 *
	 * @return VisualAppeal\Connect\MemberComment
	 */
	protected function createMemberComment($member = null)
	{
		$member = $member ?: $this->createMember();

		return \Verein\MemberComment::create([
			'member_id' => $member->id,
			'comment' => $this->faker->paragraph,
		]);
	}

	/**
	 * Create a Notification from user1 to user2.
	 *
	 * @param VisualAppeal\Connect\User $user1 (Default: null, newly created)
	 * @param VisualAppeal\Connect\User $user2 (Default: null, newly created)
	 *
	 * @return VisualAppeal\Connect\Notification
	 */
	protected function createNotification($user1 = null, $user2 = null)
	{
		$user1 = $user1 ?: $this->createUser();
		$user2 = $user2 ?: $this->createuser();

		$notification = \Verein\Notification::create([
			'from_user_id' => $user1->id,
			'to_user_id' => $user2->id,
			'icon' => 'test',
			'message' => 'notification.test',
			'message_parameters' => [
				'user' => $user1->name,
			],
			'url' => '',
			'url_parameters' => [],
		]);

		return \Verein\Notification::find($notification->id);
	}

	/**
	 * Create a random Task.
	 *
	 * @param VisualAppeal\Connect\User $user (Default: null, newly created)
	 *
	 * @return VisualAppeal\Connect\Task
	 */
	protected function createTask($user = null)
	{
		$user = $user ?: $this->createUser();

		return \Verein\Task::create([
			'user_id' => $user->id,
			'title' => $this->faker->sentence,
		]);
	}

	/**
	 * Create a random TaskJob for Task $task.
	 *
	 * @param VisualAppeal\Connect\Task $task
	 * @param VisualAppeal\Connect\User $user (Default: null, newly created)
	 *
	 * @return VisualAppeal\Connect\TaskJob
	 */
	protected function createTaskJob(\Verein\Task $task, $user = null)
	{
		$user = $user ?: $this->createUser();

		return \Verein\TaskJob::create([
			'user_id' => $user->id,
			'task_id' => $task->id,
			'title' => $this->faker->sentence,
		]);
	}

	/**
	 * Create a conversation between two users.
	 *
	 * @param VisualAppeal\Connect\User $user1 (Default: null, newly created)
	 * @param VisualAppeal\Connect\User $user2 (Default: null, newly created)
	 *
	 * @return VisualAppeal\Connect\Conversation
	 */
	public function createConversation($user1 = null, $user2 = null)
	{
		$user1 = $user1 ?: $this->createUser();
		$user2 = $user2 ?: $this->createUser();

		return \Verein\Conversation::create([
			'from_user_id' => $user1->id,
			'to_user_id' => $user2->id,
		]);
	}

	/**
	 * Create a random ConversationMessage in a conversation.
	 *
	 * @param VisualAppeal\Connect\Conversation $conversation (Default: null, newly created)
	 *
	 * @return VisualAppeal\Connect\ConversationMessage
	 */
	public function createMessage($conversation)
	{
		$conversation = $conversation ?: $this->createConversation();

		return \Verein\ConversationMessage::create([
			'conversation_id' => $conversation->id,
			'from_user_id' => $conversation->from_user_id,
			'to_user_id' => $conversation->to_user_id,
			'message' => $this->faker->sentence,
		]);
	}
}
