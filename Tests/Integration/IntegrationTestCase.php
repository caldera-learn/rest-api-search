<?php

namespace calderawp\CalderaForms\Admin\Tests\Integration;

use Brain\Monkey;
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
	 * Prepares the test environment before each test.
	 */
	public function setUp()
	{
		parent::setUp();
		Monkey\setUp();
	}

	/**
	 * Cleans up the test environment after each test.
	 */
	public function tearDown()
	{
		Monkey\tearDown();
		parent::tearDown();
	}
}
