<?php


namespace CalderaLearn\RestSearch\Features;

use CalderaLearn\RestSearch\DoesFilterContract;
use CalderaLearn\RestSearch\ModifyQueryArgsContract;
use CalderaLearn\RestSearch\ModifySchemaContract;

/**
 * Class Search
 * @package CalderaLearn\RestSearch\Features
 */
class Search implements DoesFilterContract
{

	/**
	 * @var ModifyQueryArgsContract
	 */
	protected $argsModify;
	/**
	 * @var ModifySchemaContract
	 */
	protected $schemaModify;


	/**
	 * Search constructor.
	 * @param ModifyQueryArgsContract $argsModify
	 * @param ModifySchemaContract $schemaModify
	 */
	public function __construct(ModifyQueryArgsContract $argsModify, ModifySchemaContract $schemaModify)
	{
		$this->argsModify = $argsModify;
		$this->schemaModify = $schemaModify;
	}

	/** @inheritdoc */
	public function addHook()
	{
		add_filter('registered_post_type', [$this, 'postTypePrepare']);
	}

	/** @inheritdoc */
	public function removeHook()
	{
		remove_filter('registered_post_type', [$this, 'postTypePrepare']);
	}

	/**
	 * Get underlying ModifyQueryArgsContract
	 *
	 * @return ModifyQueryArgsContract
	 */
	public function getArgsModifier()
	{
		return $this->argsModify;
	}

	/**
	 * Get underlying ModifySchemaContract
	 *
	 * @return ModifySchemaContract
	 */
	public function getSchemaModifier()
	{
		return $this->schemaModify;
	}

	/**
	 * Manages interaction of plugins API and system for post type route schema changes
	 *
	 * @param array $query_params
	 * @param \WP_Post_Type $post_type
	 * @return array
	 */
	public function filterSchema(array $query_params, \WP_Post_Type $post_type)
	{

		if ($this->schemaModify->shouldFilter($post_type)) {
			$query_params = array_merge($query_params, $this->schemaModify->getAdditionalSchemaArguments());
		}

		return $query_params;
	}

	/**
	 * Manages interaction of plugins API and system for post type route WP_Query arg whitelist changes
	 *
	 * @param array $args
	 * @param \WP_REST_Request $request
	 * @return array
	 */
	public function filterQueryArgs(array $args, \WP_REST_Request $request)
	{
		if ($this->argsModify->shouldFilter($request)) {
			$args = array_merge($args, $this->argsModify->getAdditionalQueryArguments());
		}
		return $args;
	}

	/**
	 * Whenever a post type is registered, ensure we're hooked into it's WP REST API response.
	 *
	 * @param string $post_type The newly registered post type.
	 * @return string That same post type.
	 */
	public function postTypePrepare($post_type)
	{
		add_filter("rest_{$post_type}_collection_params", [ $this, 'filterSchema'], 10, 2);
		add_filter("rest_{$post_type}_query", 'filterQueryArgs', 10, 2);
		return $post_type;
	}
}
