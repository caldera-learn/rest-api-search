<?php

namespace CalderaLearn\RestSearch\Tests\Integration;

use CalderaLearn\RestSearch\ContentGetter\PostsGenerator;
use CalderaLearn\RestSearch\FilterWPQuery;
use CalderaLearn\RestSearch\Tests\Mock\AlwaysFilterWPQuery;

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
        $query = new \WP_Query(['post_type' => 'post']);
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
        $results = FilterWPQuery::getPosts();

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
        $results = FilterWPQuery::getPosts();

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
        //Get the mock posts
        $results = AlwaysFilterWPQuery::filterPreQuery(null);
        $this->assertTrue(is_array($results));
        $this->assertFalse(empty($results));
        $expected = AlwaysFilterWPQuery::getPosts();
        $this->assertEquals(count($expected), count($results));
    }
}
