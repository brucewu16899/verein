<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Verein\MemberComment;

class MemberCommentTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Test that a employee could be created with the minimum input.
	 */
	public function testCreate()
	{
		$comment = $this->createMemberComment();

		$comment = MemberComment::find(1);
		$this->assertNotNull($comment, 'MemberComment could not be saved');
	}

	/**
	 * Test that a employee can be created via form and the translation of the title column.
	 */
	public function testCreateForm()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$member = $this->createMember();

		$this->call('GET', route('member.show', ['member' => $member->id]));
		$this->assertResponseOk();

		$this->call('POST', route('member.comment.store', ['member' => $member->id]), [
			'member_id' => $member->id,
			'comment' => 'Test MemberComment',
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('member.show', [
			'member' => $member->id,
		]);

		$comment = MemberComment::find(1);
		$this->assertNotNull($comment);
		$this->assertEquals('Test MemberComment', $comment->comment);
	}

	/**
	 * Test that a employee can be edited via form.
	 */
	public function testEditForm()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$member = $this->createMember();
		$comment = $this->createMemberComment($member);

		$this->call('GET', route('member.comment.edit', [
			'member' => $member->id,
			'comment' => $comment->id,
		]));
		$this->assertResponseOk();

		$response = $this->call('PUT', route('member.comment.update', [
			'member' => $member->id,
			'comment' => $comment->id,
		]), [
			'comment' => 'Test Update',
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('member.show', [
			'member' => $member->id,
		]);

		$comment = MemberComment::find($comment->id);
		$this->assertNotNull($comment);
		$this->assertEquals('Test Update', $comment->comment);
	}
}
