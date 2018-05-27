<?php

namespace CalderaLearn\RestSearch\Tests\Integration;

use CalderaLearn\RestSearch\FilterWPQuery;
use CalderaLearn\RestSearch\ContentGetter\PostsGenerator;

class RestRequestTest extends RestAPITestCase
{
    /**
     * Ensures that REST API requests will be filtered
     *
     * @covers FilterWPQuery::filterPreQuery()
     */
    public function testShouldFilter()
    {
        //Create a request
        $request = new \WP_REST_Request('GET', '/wp/v2/posts');
        rest_api_loaded();
        //Make sure the method returns true
        $this->assertTrue(FilterWPQuery::shouldFilter(null));
    }

    /**
     * Ensure that REST API response data was correctly altered
     *
     * @covers FilterWPQuery::shouldFilter();
     * @covers FilterWPQuery::filterPreQuery()
     */
    public function testFilteringRESTRequest()
    {
        $numberOfPosts = 5;

        // Setup filter
        FilterWPQuery::addFilter();
        FilterWPQuery::init(new PostsGenerator());

        //Create a request
        $request = new \WP_REST_Request('GET', '/wp/v2/posts');
        $request->set_param('per_page', $numberOfPosts);
        //Dispatch request
        $response = rest_get_server()->dispatch($request);

        //Test response status
        $this->assertSame(200, $response->get_status());

        //Test the response data
        $responseData = $response->get_data();
        $this->assertTrue(is_array($responseData));
        $this->assertSame($numberOfPosts, count($responseData));
        foreach ($responseData as $index => $responsePost) {
            $this->assertSame("Mock Post {$index}", $responsePost['title']['rendered']);
        }
    }
}
