<?php


namespace CalderaLearn\RestSearch\Tests\Unit;

use CalderaLearn\RestSearch\ContentGetter\PostsGenerator;
use CalderaLearn\RestSearch\Modes;

class ModeControlTests extends TestCase
{

	/**
	 * Test that the right type of ContentGetters come out of factory
	 *
	 * @covers \CalderaLearn\RestSearch\Modes::factory()
	 */
	public function testFactory()
	{
		$modes = new Modes();
		$this->assertTrue(is_a($modes->factory(''), PostsGenerator::class));
		$this->assertTrue(is_a($modes->factory(PostsGenerator::class), PostsGenerator::class));
	}

	/**
	 * Test that the right type of ContentGetters come out of factory
	 *
	 * @covers \CalderaLearn\RestSearch\Modes::factory()
	 */
	public function testGetMode()
	{
		$modes = new Modes();
		$mockRestRequest = \Mockery::mock('\WP_Rest_Request');
		$mockRestRequest->shouldReceive('get_param')
			->once()
			->andReturn('default');

		$this->assertTrue(is_a($modes->controlMode(nulll, $mockRestRequest), PostsGenerator::class));
	}
}
