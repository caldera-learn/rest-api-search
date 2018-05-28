<?php


namespace CalderaLearn\RestSearch\Tests\Mock;

use CalderaLearn\RestSearch\ModifySchemaContract;

class SchemaModifierImplementation implements ModifySchemaContract
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
		return (bool)$this->should;
	}

	/** @inheritdoc */
	public function getAdditionalSchemaArguments(): array
	{
		return [
			'post_type ' => [
				'default' => 'post',
				'description' => __('Post type(s) for search query'),
				'type' => 'array',
				'items' =>
					[
						'enum' => [
							'posts',
							'pages'
						],
						'type' => 'string',
					],
			]
		];
	}
}
