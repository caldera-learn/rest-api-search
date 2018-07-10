<?php


namespace calderawp\CalderaForms\Admin\Tests\Unit;

use calderawp\CalderaForms\Admin\Something;

class SomethingTest extends TestCase
{

	public function testDoSomething()
	{
		$this->assertTrue((new Something())->doAThing());
	}
}
