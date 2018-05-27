<?php

namespace CalderaLearn\RestSearch\Tests\Integration;

use Mockery;

/**
 * Class IntegrationTestCase
 *
 * All integration tests MUST extend this class
 *
 * @package CalderaLearn\RestSearch\Tests\Integration
 */
abstract class IntegrationTestCase extends \WP_UnitTestCase
{
	/**
	 * Cleans up the test environment after each test.
	 */
	public function tearDown()
	{
		Mockery::close();
		parent::tearDown();
	}
}
