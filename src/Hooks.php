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
	 * Add all hooks used by this plugin
	 */
	public function addHooks()
	{
		FilterWPQuery::addFilter();
	}

	/**
	 * Remove all hooks used by this plugin
	 */
	public function removeHooks()
	{
		FilterWPQuery::removeFilter();
	}
}
