<?php


namespace calderawp\CalderaForms\Admin\Contracts;

interface MenuPage
{

    /**
     * Render the intial view of the admin page
     *
     * @return string
     */
	public function render();

    /**
     * Add the menu page
     */
	public function display();

    /**
     * Get the menu page slug
     *
     * @return string
     */
	public function getSlug();

    /**
     * Get the menu page icon
     *
     * @return string
     */
	public function getIcon();

    /**
     * Get the Id of the element the client will mount on
     *
     * @return string
     */
	public function getElementId();
}
