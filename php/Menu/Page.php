<?php


namespace calderawp\CalderaForms\Admin\Menu;

use calderawp\CalderaForms\Admin\Contracts\MenuPage;

class Page implements MenuPage
{

	/** @var string */
	protected $slug;
	/** @var string */
	protected $menuIcon;
	/** @var string */
	protected $menuLabel;
	/** @var string */
	protected $elementId;

	/**
	 * Page constructor.
	 * @param string $slug
	 * @param string $menuIcon
	 * @param string $menuLabel
	 * @param string $elementId
	 */
	public function __construct($slug, $menuIcon, $menuLabel, $elementId)
	{
		$this->slug = $slug;
		$this->menuIcon = $menuIcon;
		$this->menuLabel = $menuLabel;
		$this->elementId = $elementId;
	}

	/** @inheritdoc */
	public function getSlug()
	{
		return $this->slug;
	}

	/** @inheritdoc */
	public function getIcon()
	{
		return $this->menuIcon;
	}

	/** @inheritdoc */
	public function getMenuLabel()
	{
		return $this->menuLabel;
	}

	/** @inheritdoc */
	public function render()
	{
        printf('<div id="%s"></div>', esc_attr($this->getElementId()));
	}

	/** @inheritdoc */
	public function getElementId()
	{
		return $this->elementId;
	}

	/** @inheritdoc */
	public function display()
	{
		add_submenu_page(
			MainPage::SLUG,
			$this->getLabel(),
			$this->getLabel(),
			'manage_options',
			$this->getSlug(),
			[$this, 'render']
		);
	}

	/**
	 * @return string
	 */
	protected function getLabel()
	{
		return sprintf(
			'<span class="caldera-forms-menu-dashicon"><span class="dashicons dashicons-%s"></span>%s</span>',
			esc_attr($this->getIcon()),
			$this->getMenuLabel()
		);
	}
}
