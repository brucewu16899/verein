<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Verein\MemberDate;

class MemberDateTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Test that a MemberDate could be created with the minimum input.
	 */
	public function testCreate()
	{
		$this->createMemberDate();

		$memberDate = MemberDate::find(1);
		$this->assertNotNull($memberDate, 'MemberDate could not be saved');
	}

	/**
	 * Test that a MemberDate can be created via form.
	 */
	public function testCreateForm()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$member = $this->createMember();

		$this->call('GET', route('member.date.create', ['member' => $member->id]));
		$this->assertResponseOk();

		$this->call('POST', route('member.date.store', ['member' => $member->id]), [
			'type' => 'private_phone',
			'value' => '123456789',
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('member.show', [
			'member' => $member->id,
		]);

		$memberDate = MemberDate::find(1);
		$this->assertNotNull($memberDate);
		$this->assertEquals('123456789', $memberDate->value);
	}

	/**
	 * Test that a MemberDate can be edited via form.
	 */
	public function testEditForm()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$member = $this->createMember();
		$memberDate = $this->createMemberDate($member);

		$this->call('GET', route('member.date.edit', [
			'member' => $member->id,
			'date' => $memberDate->id,
		]));
		$this->assertResponseOk();

		$response = $this->call('PUT', route('member.date.update', [
			'member' => $member->id,
			'date' => $memberDate->id,
		]), [
			'type' => 'private_phone',
			'value' => '1234567890',
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('member.show', [
			'member' => $member->id,
		]);

		$memberDate = MemberDate::find(1);
		$this->assertNotNull($memberDate);
		$this->assertEquals('1234567890', $memberDate->value);
	}

	/**
	 * Test that a member can be deleted via interface.
	 */
	public function testDeleteForm()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$member = $this->createMember();
		$memberDate = $this->createMemberDate();

		$this->call('GET', route('member.show', ['member' => $member->id]));
		$this->assertResponseOk();

		$response = $this->call('DELETE', route('member.date.destroy', [
			'member' => $member->id,
			'date' => $memberDate->id,
		]), [
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('member.show', [
			'member' => $member->id,
		]);

		$memberDate = MemberDate::find($memberDate->id);
		$this->assertNull($memberDate);
	}
}
