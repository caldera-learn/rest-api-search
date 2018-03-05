<?php

namespace CalderaLearn\RestSearch;

/**
 * Trait UsesPreparedPostTypes
 *
 * Forces a common pattern for dependency injection of PreparedPostTypes objects
 *
 * @package ExamplePlugin
 */
trait UsesPreparedPostTypes
{
	/**
	 * Prepared post types
	 *
	 * @var PreparedPostTypes
	 */
	protected $preparedPostTypes;

	/**
	 * UsesPreparedPostTypes constructor.
	 * @param PreparedPostTypes $preparedPostTypes
	 */
	public function __construct(PreparedPostTypes $preparedPostTypes)
	{
		$this->preparedPostTypes = $preparedPostTypes;
	}
}
