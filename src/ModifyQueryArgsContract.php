<?php


namespace CalderaLearn\RestSearch;

interface ModifyQueryArgsContract
{


	/**
	 * Filter query args if needed
	 *
	 * @param array $args Key value array of query var to query value.
	 * @param \WP_REST_Request $request The request used.
	 *
	 * @return array
	 */
	public function filterQueryArgs($args, $request);

	/**
	 * Check if we should filter request args
	 *
	 * @param \WP_REST_Request $request
	 * @return bool
	 */
	public function shouldFilter(\WP_REST_Request $request): bool;


	/**
	 * Return the additional query arguments that should be added
	 *
	 * @return array
	 */
	public function getAdditionalQueryArguments(): array;
}
