<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Verein\Extensions\DiffRenderer;

class DiffRendererTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Test that diff contains inserted elements.
	 */
	public function testInsert()
	{
		$old = ['equal'];
		$new = ['equal', 'insert'];

		$diff = new \Diff($old, $new);
		$renderer = new \Verein\Extensions\DiffRenderer;
		$render = @$diff->render($renderer);

		$this->assertContains('diff-change-equal', $render);
		$this->assertContains('diff-change-insert', $render);
	}

	/**
	 * Test that diff contains delete elements.
	 */
	public function testDelete()
	{
		$old = ['equal', 'delete'];
		$new = ['equal'];

		$diff = new \Diff($old, $new);
		$renderer = new \Verein\Extensions\DiffRenderer;
		$render = @$diff->render($renderer);

		$this->assertContains('diff-change-equal', $render);
		$this->assertContains('diff-change-delete', $render);
	}

	/**
	 * Test that diff contains equal elements.
	 */
	public function testEquals()
	{
		$old = ['equal', 'first'];
		$new = ['equal', 'second'];

		$diff = new \Diff($old, $new);
		$renderer = new \Verein\Extensions\DiffRenderer;
		$render = @$diff->render($renderer);

		$this->assertContains('diff-change-equal', $render);
	}

	/**
	 * Test that diff contains replaced elements.
	 */
	public function testReplace()
	{
		$old = ['first', 'equal'];
		$new = ['second', 'equal'];

		$diff = new \Diff($old, $new);
		$renderer = new \Verein\Extensions\DiffRenderer;
		$render = @$diff->render($renderer);

		$this->assertContains('diff-change-replace', $render);
	}
}
