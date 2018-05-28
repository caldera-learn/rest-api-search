<?php


namespace CalderaLearn\RestSearch\Tests\Unit;

use CalderaLearn\RestSearch\Features\Search;
use CalderaLearn\RestSearch\ModifySchema;
use CalderaLearn\RestSearch\ModifySchemaContract;
use CalderaLearn\RestSearch\Tests\Mock\SchemaModifierImplementation;

class SearchFeatureGeneratorTest extends TestCase
{
	/**
	 *
	 * @covers \CalderaLearn\RestSearch\Features\Search::__construct()
	 * @covers \CalderaLearn\RestSearch\Features\Search::getSchemaModifier()
	 * @covers \CalderaLearn\RestSearch\Features\Search::getArgsModifier()
	 */
	public function testSetModifiers()
	{

		$schemaModifer = new SchemaModifierImplementation();
		$queryArgModifier = new QueryArgModifierImplementation();
		$search = new Search($queryArgModifier, $schemaModifer);
		$this->assertSame($schemaModifer, $search->getSchemaModifier());
		$this->assertSame($queryArgModifier, $search->getArgsModifier());
	}

	/**
	 * Test that schema is filtered properly
	 *
	 * @covers \CalderaLearn\RestSearch\Features\Search::filterSchema()
	 * @covers \CalderaLearn\RestSearch\Features\Search::getSchemaModifier()
	 */
	public function testFilterSchema()
	{
		$schemaModifer = new SchemaModifierImplementation();
		$queryArgModifier = new QueryArgModifierImplementation();
		$search = new Search($queryArgModifier, $schemaModifer);
		$schemaModifer->setShouldFilter(true);
		$wpPostTypeMock        = \Mockery::mock('WP_Post_Type');
		$wpPostTypeMock->name = 'post';

		$this->assertTrue($schemaModifer->shouldFilter($wpPostTypeMock));
		$this->assertTrue($search->getSchemaModifier()->shouldFilter($wpPostTypeMock));
		$otherArgs = [
			'page' => [
				'default' => 1,
				'type' => 'integer'
			]
		];
		$expectArgs = array_merge($otherArgs, $schemaModifer->getAdditionalSchemaArguments());
		$args = $search->filterSchema($otherArgs, $wpPostTypeMock);
		$this->assertEquals($expectArgs, $args);
	}

	/**
	 * Test that filter args are filtered correctly
	 *
	 * @since 1.7.0
	 */
	public function testFilterQueryArgs()
	{
		$schemaModifer = new SchemaModifierImplementation();
		$queryArgModifier = new QueryArgModifierImplementation();
		$search = new Search($queryArgModifier, $schemaModifer);
		$queryArgModifier->setShouldFilter(true);
		$wpPostTypeMock        = \Mockery::mock('WP_Post_Type');
		$wpPostTypeMock->name = 'post';
		$this->assertTrue($queryArgModifier->shouldFilter($wpPostTypeMock));
		$this->assertTrue($search->getArgsModifier()->shouldFilter($wpPostTypeMock));

		$otherArgs = [
			'page' => [
				'default' => 1,
				'type' => 'integer'
			]
		];
		$expectArgs = array_merge($otherArgs, $queryArgModifier->getAdditionalQueryArguments());
		$wpRestRequest = \Mockery::mock('WP_REST_Request');
		$args = $search->filterQueryArgs($otherArgs, $wpRestRequest);
		$this->assertEquals($expectArgs, $args);
	}
}
