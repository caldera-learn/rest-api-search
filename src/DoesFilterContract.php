<?php


namespace CalderaLearn\RestSearch;

/**
 * Interface DoesFilterContract
 *
 * Interfaces for classes that add filters.
 */
interface DoesFilterContract
{

	/**
	 * Add the filter
	 */
	public function addHook();

	/**
	 * Remove the filter
	 */
	public function removeHook();
}
