<?php


namespace calderawp\CalderaForms\Admin\Tests\Unit;


use function calderawp\CalderaForms\Admin\CalderaFormsUi;
use calderawp\CalderaForms\Admin\Container;

class ContainerTest extends TestCase
{

    /**
     *
     * @covers \calderawp\CalderaForms\Admin\CalderaFormsUi()
     */
    public function testGetViaAccessor(){
        $this->assertEquals(Container::class, get_class(CalderaFormsUi()));

    }

    /**
     * @covers \calderawp\CalderaForms\Admin\setPluginDirPath()
     * @covers \calderawp\CalderaForms\Admin\getPluginDirPath()
     */
    public function testSetPluginDirPath()
    {
        $container = new Container();
        $container->setPluginDirPath( '/var/roy' );
        $this->assertEquals( '/var/roy', $container->getPluginDirPath() );
    }

    /**
     * @covers \calderawp\CalderaForms\Admin\__constructor()
     * @covers \calderawp\CalderaForms\Admin\setPluginDirPath()
     * @covers \calderawp\CalderaForms\Admin\getPluginDirPath()
     */
    public function testSetPluginDirPathWithConstructor()
    {
        $container = new Container('/var/roy');
        $this->assertEquals( '/var/roy', $container->getPluginDirPath() );
    }

}