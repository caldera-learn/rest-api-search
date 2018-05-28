<?php


namespace CalderaLearn\RestSearch\Tests\Unit;

use CalderaLearn\RestSearch\Features\Factory;

class FeatureFactoryTest extends TestCase
{

	/**
	 * Test setting up system using factory
	 *
	 * @covers \CalderaLearn\RestSearch\Features\Factory::search()
	 */
	public function testArgs()
	{
		$schema = [
			'default' => 'post',
			'description' => __('Post type(s) for search query'),
			'type' => 'array',
			//Limit to public post types and allow query by rest base
			'items' =>
				[
					'enum' => [
						'posts',
						'pages'
					],
					'type' => 'string',
				],
		];

		$args =  [
			'post_type' => [
				'schema' => $schema,
				'default' => 'post',
			]
		];
		$search = Factory::search($args, [ 'post' ]);
		$this->assertSame(
			[
				'post_type' => $schema
			],
			$search->getSchemaModifier()->getAdditionalSchemaArguments()
		);

		$this->assertSame(
			[ 'post_type' => 'post' ],
			$search->getArgsModifier()->getAdditionalQueryArguments()
		);
	}
}
