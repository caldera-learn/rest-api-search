<?php


namespace CalderaLearn\RestSearch\Tests\Unit;

use CalderaLearn\RestSearch\Tests\Mock\FilterWPQuery;
use CalderaLearn\RestSearch\Tests\Mock\WP_Post;

class FilterWPQueryTest extends TestCase
{

    /**
     * Test that the getPosts method return an array
     *
     * @covers FilterWPQuery::getPosts()
     */
    public function testGetPosts()
    {
        //Get the mock posts
        $results = FilterWPQuery::getPosts();
        //Make sure results are an array
        $this->assertTrue(is_array($results));
    }
    /**
     * Test the result data is consistent
     *
     * @covers FilterWPQuery::callback()
     */
    public function testWithNull()
    {
        //Use the mock data we have in our mock class as the expected values
        $expected = FilterWPQuery::getPosts();

        //Get the results from the callback
        $results  = FilterWPQuery::callback(null, null);

        //Make sure results are an array
        $this->assertTrue(is_array($results));

        //Make sure the two arrays are the same size
        $this->assertCount(count($expected), $results);

        /** These arrays are not the same, compare the meaning of the contents */

        //Used to make sure this loop of tests ran
        $looped = false;
        /**
         * Loop through expected, comparing to eactual results
         * @var int $i
         * @var  WP_Post $post
         */
        foreach ($expected as $i => $post) {
            $looped = true;
            //Test that the mock and resulting post titles are the same
            $this->assertSame($post->post_title, $results[$i]->post_title);
        }
        //Make sure loop ran
        $this->assertTrue($looped);
    }
}
