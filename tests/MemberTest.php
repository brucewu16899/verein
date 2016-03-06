<?php

use Verein\Member;

class MemberTest extends TestCase
{
	/**
	 * Test that a member could be created with the minimum input.
	 */
	public function testCreate()
	{
		$member = $this->createMember();

		$member = Member::find(1);
		$this->assertNotNull($member, 'Member could not be saved');
	}

	/**
	 * Test that the index view loads and contains companies.
	 */
	public function testIndex()
	{
		$member = $this->createMember();

		$admin = $this->createSuperuser();
		$this->be($admin);

		$response = $this->call('GET', route('member.index'));
		$this->assertResponseOk();
		$this->assertContains($member->name, $response->getContent());
	}

	/**
	 * Test that the show view loads and contains the member.
	 */
	public function testShow()
	{
		$member = $this->createMember();

		$admin = $this->createSuperuser();
		$this->be($admin);

		$response = $this->call('GET', route('member.show', ['member' => $member->id]));
		$this->assertResponseOk();
		$this->assertContains($member->name, $response->getContent());
	}

	/**
	 * Test that a member can be created via form.
	 */
	public function testCreateForm()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$this->call('GET', route('member.create'));
		$this->assertResponseOk();

		$this->call('POST', route('member.store'), [
			'first_name' => 'Thomas',
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('member.show', [
			'member' => 2,
		]);

		$member = Member::find(2);
		$this->assertNotNull($member);
		$this->assertEquals('Thomas', $member->first_name);
	}

	/**
	 * Test that a member can be edited via form.
	 */
	public function testEditForm()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$member = $this->createMember();

		$this->call('GET', route('member.edit', ['member' => $member->id]));
		$this->assertResponseOk();

		$this->call('PUT', route('member.update', ['member' => $member->id]), [
			'first_name' => 'Thomas',
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('member.show', [
			'member' => $member->id,
		]);

		$member = Member::find($member->id);
		$this->assertNotNull($member);
		$this->assertEquals('Thomas', $member->first_name);
	}

	/**
	 * Test that a member can be deleted via interface.
	 */
	public function testDeleteForm()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$member = $this->createMember();

		$this->call('GET', route('member.show', ['member' => $member->id]));
		$this->assertResponseOk();

		$response = $this->call('DELETE', route('member.destroy', ['member' => $member->id]), [
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('member.index');

		$member = \Verein\Member::find($member->id);
		$this->assertNull($member);
	}
}
