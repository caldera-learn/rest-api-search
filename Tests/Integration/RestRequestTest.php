<?php


namespace CalderaLearn\RestSearch\Tests\Integration;

use CalderaLearn\RestSearch\FilterWPQuery;
use CalderaLearn\RestSearch\Tests\Mock\AlwaysFilterWPQuery;

class RestRequestTest extends RestAPITestCase
{

	/**
	 * Ensures that REST API requests will be filtered
	 *
	 * @covers FilterWPQuery::callback()
	 */
	public function testShouldFilter()
	{
		//Create a request
		$request = new \WP_REST_Request('GET', '/wp/v2/posts');
		rest_api_loaded();
		//Make sure the method returns true
		$this->assertTrue(FilterWPQuery::shouldFilter());
	}


	/**
	 * Ensure that REST API response data was correctly altered
	 *
	 * @covers FilterWPQuery::shouldFilter();
	 * @covers FilterWPQuery::callback()
	 */
	public function testFilteringRESTRequest()
	{
		//setup filter
		AlwaysFilterWPQuery::addFilter();
		$this->assertTrue(AlwaysFilterWPQuery::shouldFilter());

		//Create a request
		$request = new \WP_REST_Request('GET', '/wp/v2/posts');
		//Dispatch request
		$response = rest_get_server()->dispatch($request);


		//Test response status
		$this->assertSame(200, $response->get_status());

		//Test the repsonse data
		//Use the mock data we have in our mock class as the expected values
		$expected = FilterWPQuery::getPosts();

		//Test that the expected results and the actual results are the same

		$responseData = $response->get_data();
		$this->assertTrue(is_array($responseData));
		$this->assertSame(count($expected), count($responseData));
		foreach ($responseData as $i => $responsePost) {
			$this->assertTrue(isset($expected[$i]));
			$this->assertSame($expected[$i]->post_title, $responsePost[ 'title' ][ 'rendered' ]);
		}
	}
}
