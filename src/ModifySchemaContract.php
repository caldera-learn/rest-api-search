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
	 * Add post_type to schema
	 *
	 * @uses ""rest_{$postType}_collection_params" action
	 *
	 * @param array $query_params JSON Schema-formatted collection parameters.
	 * @param \WP_Post_Type $post_type Post type object.
	 *
	 * @return array
	 */
	public function filterSchema($query_params, $post_type);

	/**
	 * Check if this post type's schema should be filtered
	 *
	 * @param \WP_Post_Type $WP_Post_Type
	 * @return bool
	 */
	public function shouldFilter(\WP_Post_Type $WP_Post_Type): bool;


	/**
	 * Return the additional schema arguments that should be added
	 *
	 * @return array
	 */
	public function getAdditionalSchemaArguments(): array;
}
