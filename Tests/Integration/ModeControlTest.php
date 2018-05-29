<?php


namespace CalderaLearn\RestSearch\Tests\Integration;

use CalderaLearn\RestSearch\Modes;
use CalderaLearn\RestSearch\Tests\Mock\CreatePostsImplementation;

/**
 * Class ModeControlTest
 *
 * Demonstrates and tests how the "caldera_learn_rest_search_get_mode" filter can be used to implement search systems.
 */
class ModeControlTest extends IntegrationTestCase
{
	/**
	 * Make sure that filter can be used to make content getter extensible
	 *
	 * @covers \CalderaLearn\RestSearch\Modes::controlMode()
	 */
	public function testGetModeFilterReturns()
	{
		$modes = new Modes();
		add_filter(Modes::FILTER_NAME, function ($param, $mode) {
			$this->assertEquals('mockMode', $mode);
			if ('mockMode' === $mode) {
				return new CreatePostsImplementation();
			}
			return $param;
		}, 10, 2);
		$mockRestRequest = \Mockery::mock('\WP_Rest_Request');
		$mockRestRequest->shouldReceive('get_param')
			->once()
			->andReturn('mockMode');

		$contentGetter = $modes->controlMode(null, $mockRestRequest);
		$this->assertTrue(is_a($contentGetter, CreatePostsImplementation::class));
	}
}
