<?php

namespace CalderaLearn\RestSearch\Tests\Unit;

use Brain\Monkey;
//Import PHP unit test case.
//Must be aliased to avoid having two classes of same name in scope.
use PHPUnit\Framework\TestCase as FrameworkTestCase;

/**
 * Class TestCase
 *
 * Default test case for all unit tests
 * @package CalderaLearn\RestSearch\Tests\Unit
 */
abstract class TestCase extends FrameworkTestCase
{
    /**
     * Prepares the test environment before each test.
     */
    protected function setUp() {
        parent::setUp();
        Monkey\setUp();
    }

    /**
     * Cleans up the test environment after each test.
     */
    protected function tearDown()
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
