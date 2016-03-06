<?php

use Verein\Extensions\DiffRenderer;

class DiffRendererTest extends TestCase
{
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

	public function testEquals()
	{
		$old = ['equal', 'first'];
		$new = ['equal', 'second'];

		$diff = new \Diff($old, $new);
		$renderer = new \Verein\Extensions\DiffRenderer;
		$render = @$diff->render($renderer);

		$this->assertContains('diff-change-equal', $render);
	}

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
