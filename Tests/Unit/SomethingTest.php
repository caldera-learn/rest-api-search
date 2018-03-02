<?php


namespace CalderaLearn\RestSearch\Tests\Unit;

use CalderaLearn\RestSearch\Something;

class SomethingTest extends TestCase
{

    /**
     * Test the something class works
     *
     * @covers Something::getArg()
     * @covers Something::$arg
     */
    public function testGetArg()
    {
        //Expected value
        $expected = 42;
        //Create object to test
        $something = new Something($expected);
        //Compare expected output to actual output
        $this->assertEquals($expected, $something->getArg());
    }
}
