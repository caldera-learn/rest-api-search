<?php


namespace calderawp\CalderaForms\Admin\Tests\Unit;

use calderawp\CalderaForms\Admin\Menu\MainPage;

class PageTest extends TestCase
{

	/**
	 *
	 * @covers \calderawp\CalderaForms\Admin\Menu\Page::getSlug()
	 */
	public function testGetSlug()
	{
		$slug = 'sluggoo';
		$menuIcon = 'smile';
		$menuLabel = 'Hi roy';
		$elementId = 'hi-roy';
		$page = new MainPage($slug, $menuIcon, $menuLabel, $elementId);
		$this->assertEquals('caldera-forms', $page->getSlug());
	}

	/**
 *
 * @covers \calderawp\CalderaForms\Admin\Menu\Page::getIcon()
 */
	public function testGetIcon()
	{
		$slug = 'slug';
		$menuIcon = 'smile';
		$menuLabel = 'Hi roy';
		$elementId = 'hi-roy';
		$page = new MainPage($slug, $menuIcon, $menuLabel, $elementId);
		$this->assertEquals($menuIcon, $page->getIcon());
	}

	/**
 *
 * @covers \calderawp\CalderaForms\Admin\Menu\Page::getMenuLabel()
 */
	public function testMenuLabel()
	{
		$slug = 'slug';
		$menuIcon = 'smile';
		$menuLabel = 'Hi roy';
		$elementId = 'hi-roy';
		$page = new MainPage($slug, $menuIcon, $menuLabel, $elementId);
		$this->assertEquals($menuLabel, $page->getMenuLabel());
	}

	/**
	 *
	 * @covers \calderawp\CalderaForms\Admin\Menu\Page::getElementId()
	 */
	public function testGetElementId()
	{
		$slug = 'slug';
		$menuIcon = 'smile';
		$menuLabel = 'Hi roy';
		$elementId = 'hi-roy';
		$page = new MainPage($slug, $menuIcon, $menuLabel, $elementId);
		$this->assertEquals($elementId, $page->getElementId());
	}

	/**
	 *
	 * @covers \calderawp\CalderaForms\Admin\Menu\Page::render()
	 */
	public function testRender()
	{
		$slug = 'slug';
		$menuIcon = 'smile';
		$menuLabel = 'Hi roy';
		$elementId = 'hi-roy';
		$page = new MainPage($slug, $menuIcon, $menuLabel, $elementId);
		$this->assertNotFalse(strpos($page->render(), $page->getElementId()));
	}
}
