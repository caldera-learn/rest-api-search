<?php


namespace CalderaLearn\RestSearch;

/**
 * Class ModifySchema
 *
 * Modifies the REST API route schema so it has an argument "post_type"
 *
 *
 * @package ExamplePlugin
 */
interface ModifySchemaContract
{

	/**
	 * Check if this post type's schema should be filtered
	 *
	 * @param string $postTypeRestBase
	 * @return bool
	 */
	public function shouldFilter(string $postTypeRestBase): bool;


	/**
	 * Return the additional schema arguments that should be added
	 *
	 * @return array
	 */
	public function getAdditionalSchemaArguments(): array;
}
