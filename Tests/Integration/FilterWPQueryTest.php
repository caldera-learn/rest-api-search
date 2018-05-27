<?php

namespace CalderaLearn\RestSearch\Tests\Integration;

use Brain\Monkey;
use CalderaLearn\RestSearch\ContentGetter\PostsGenerator;
use CalderaLearn\RestSearch\FilterWPQuery;
use WP_Query;

/**
 * Class FilterWPQueryTest
 *
 * Test interaction of FilterWPQuery with WordPress plugins API
 *
 * @package CalderaLearn\RestSearch\Tests\Integration
 */
class FilterWPQueryTest extends IntegrationTestCase
{
    /**
     * Test adding the filter
     *
     * @covers FilterWPQuery::addFilter()
     */
    public function testAddFilter()
    {
        //Add filter
        $this->assertTrue(FilterWPQuery::addFilter());
        //Make sure addFilter() had the right effect --  it was added with priority 10
        $this->assertEquals(
            FilterWPQuery::getFilterPriority(),
            has_filter('posts_pre_query', [FilterWPQuery::class, 'filterPreQuery'])
        );
    }

    /**
     * Test removing the filter
     *
     * @covers FilterWPQuery::shouldFilter()
     */
    public function testFilterRemoved()
    {
        //Add filter
        FilterWPQuery::addFilter();
        //Remove and test return type
        $this->assertTrue(FilterWPQuery::removeFilter());
        //Make sure removeFilter() had the right effect -- the filter was removed
        $this->assertFalse(has_filter('posts_pre_query', [FilterWPQuery::class, 'filterPreQuery']));
    }

    /**
     * Test that by default this class does not do anything by default
     *
     * @covers FilterWPQuery::shouldFilter()
     * @covers FilterWPQuery::filterPreQuery()
     */
    public function testNotFilteringByDefault()
    {
        //Add one post and save its title and ID in variables for comparing to
        $postTitle = 'The expected post title';
        $postId    = $this->factory->post->create(['post_title' => $postTitle]);

        //Add filter
        FilterWPQuery::addFilter();

        //Test that the filter SHOULD not do anything
        $this->assertFalse(FilterWPQuery::shouldFilter([]));

        //Query for all posts -- should only be one post, the one we just created.
        $query = new WP_Query(['post_type' => 'post']);
        $this->assertFalse(empty($query->posts));
        $this->assertEquals(1, count($query->posts[0]));
        $this->assertEquals($postId, $query->posts[0]->ID);
        $this->assertEquals($postTitle, $query->posts[0]->post_title);
    }

    /**
     * Test that the getPosts method return an array
     *
     * @covers \CalderaLearn\RestSearch\FilterWPQuery::getPosts()
     */
    public function testGetPosts()
    {
        // Initialize by loading the implementation.
        FilterWPQuery::init(new PostsGenerator());

        //Get the mock posts
        $query   = new WP_Query();
        $results = FilterWPQuery::getPosts($query);

        //Make sure results are an array
        $this->assertTrue(is_array($results));
    }

    /**
     * Test that the getPosts method returns an array of WP_Posts.
     *
     * @covers \CalderaLearn\RestSearch\FilterWPQuery::getPosts()
     */
    public function testGetPostsArePosts()
    {
        // Initialize by loading the implementation.
        FilterWPQuery::init(new PostsGenerator());

        //Get the mock posts
        $query   = new WP_Query();
        $results = FilterWPQuery::getPosts($query);

        $this->assertFalse(empty($results));

        //Make sure results are an array of WP_Posts
        $looped = false;
        foreach ($results as $result) {
            $looped = true;
            //Make sure all results are WP_Posts
            $this->assertTrue(is_a($result, '\WP_Post'), get_class($result));
        }
        //Make sure loop ran
        $this->assertTrue($looped);
    }

    /**
     * Test that the getPosts method does filter when it is explicitly set to so.
     *
     * @covers \CalderaLearn\RestSearch\FilterWPQuery::getPosts()
     */
    public function testGetPostsArePostsShouldFilter()
    {
        // Set up the test.
        $numberOfPosts = 5;
        $query         = new WP_Query(['posts_per_page' => $numberOfPosts]);
        FilterWPQuery::init(new PostsGenerator());

        // Mock that it's a RESTful request.
        Monkey\Functions\expect('did_action')->with('rest_api_init')->andReturn(1);
        $this->assertTrue(FilterWPQuery::shouldFilter(null));

        // Run it.
        $actual = FilterWPQuery::filterPreQuery(null, $query);

        // Let's test.
        $this->assertTrue(is_array($actual));
        $this->assertFalse(empty($actual));
        $this->assertEquals($numberOfPosts, count($actual));

        foreach ($actual as $index => $post) {
            $this->assertSame("Mock Post {$index}", $post->post_title);
        }
    }

    /**
     * Test end-to-end by running a REST request.
     *
     * @covers FilterWPQuery::shouldFilter();
     * @covers FilterWPQuery::filterPreQuery()
     */
    public function testEnd2End()
    {
        $numberOfPosts = 5;

        //Setup filter
        FilterWPQuery::addFilter();
        FilterWPQuery::init(new PostsGenerator());

        // Process the REST request.
        $request = new \WP_REST_Request('GET', '/wp/v2/posts');
        $request->set_param('per_page', $numberOfPosts);
        $response = rest_get_server()->dispatch($request);

        // Let's test.
        $this->assertSame(200, $response->get_status());

        $responseData = $response->get_data();
        $this->assertTrue(is_array($responseData));
        $this->assertSame($numberOfPosts, count($responseData));
        foreach ($responseData as $index => $responsePost) {
            $this->assertSame("Mock Post {$index}", $responsePost['title']['rendered']);
        }
    }
}
