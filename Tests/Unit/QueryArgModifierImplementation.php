<?php


namespace CalderaLearn\RestSearch\Tests\Unit;

use CalderaLearn\RestSearch\ModifyQueryArgsContract;

class QueryArgModifierImplementation implements ModifyQueryArgsContract
{
	/**
	 * @var bool
	 */
	protected $should;

	/**
	 * @param bool $should
	 */
	public function setShouldFilter(bool $should)
	{
		$this->should = $should;
	}

	/** @inheritdoc */
	public function shouldFilter(string $postTypeSlug): bool
	{
		return (bool) $this->should;
	}

	/**
	 * @return array
	 */
	public function getAdditionalQueryArguments(): array
	{
		return [ 'post_type' => 'post' ];
	}
}
