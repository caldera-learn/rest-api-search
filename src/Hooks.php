<?php


namespace CalderaLearn\RestSearch;

/**
 * Class Hooks
 *
 * Manages adding and removing all hooks together
 *
 * @package CalderaLearn\RestSearch
 */
class Hooks
{
	/**
	 * @var Modes
	 */
	protected $modes;
	/**
	 * Add all hooks used by this plugin
	 */
	public function addHooks()
	{
		FilterWPQuery::addFilter();
		$this->modes = new Modes();
		add_filter('caldera_learn_rest_search_pre_get_posts', [ $this->modes, 'controlMode' ], 10, 2);
	}

	/**
	 * Remove all hooks used by this plugin
	 */
	public function removeHooks()
	{
		FilterWPQuery::removeFilter();
		remove_filter('caldera_learn_rest_search_pre_get_posts', [ $this->modes, 'controlMode' ], 10);
	}
}
