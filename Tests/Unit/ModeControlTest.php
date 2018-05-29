<?php


namespace CalderaLearn\RestSearch\Tests\Unit;

use CalderaLearn\RestSearch\ContentGetter\PostsGenerator;
use CalderaLearn\RestSearch\Modes;
use Brain\Monkey\Filters;
use CalderaLearn\RestSearch\Tests\Mock\CreatePostsImplementation;

class ModeControlTest extends TestCase
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
	 * @covers \CalderaLearn\RestSearch\Modes::controlMode()
	 */
	public function testGetMode()
	{
		$modes = new Modes();
		$mockRestRequest = \Mockery::mock('\WP_Rest_Request');
		$mockRestRequest->shouldReceive('get_param')
			->once()
			->andReturn('default');

		$this->assertTrue(is_a($modes->controlMode(null, $mockRestRequest), PostsGenerator::class));
	}

	/**
	 * Test that the filter for controlling mode is running
	 *
	 * @covers \CalderaLearn\RestSearch\Modes::controlMode()
	 */
	public function testGotModeFilterRuns()
	{
		$modes = new Modes();
		$mockRestRequest = \Mockery::mock('\WP_Rest_Request');
		$mockRestRequest->shouldReceive('get_param')
			->once()
			->andReturn('default');

		$modes->controlMode(null, $mockRestRequest);
		$this->assertTrue(Filters\applied(Modes::FILTER_NAME) > 0);
	}
}
