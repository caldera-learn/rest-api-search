<?php


namespace CalderaLearn\RestSearch;

interface ModifyQueryArgsContract
{

	/**
	 * Check if we should filter request args
	 *
	 * @param string $postTypeRestBase
	 * @return bool
	 */
	public function shouldFilter(string $postTypeRestBase): bool;

	/**
	 * Return the additional query arguments that should be added
	 *
	 * @return array
	 */
	public function getAdditionalQueryArguments(): array;
}
