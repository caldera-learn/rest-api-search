<?php


namespace CalderaLearn\RestSearch\Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
	/**
	 * Super basic test for educational purposes
	 *
	 * @covers TestCase
	 */
	public function testTheTruth()
	{
		//What should the value be?
		$excepted = true;
		//What is the value actually
		$actual = false;
		//Are they not the same?
		$this->assertNotEquals($excepted, $actual);
	}
}
