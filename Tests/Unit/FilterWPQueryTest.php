<?php

namespace CalderaLearn\RestSearch\Tests\Unit;

use Brain\Monkey;
use CalderaLearn\RestSearch\FilterWPQuery;
use CalderaLearn\RestSearch\ContentGetter\ContentGetterContract;
use Mockery;

/**
 * Class FilterWPQueryTest
 *
 * Unit tests for class that modifies WP_Query
 *
 * @package CalderaLearn\RestSearch\Tests\Unit
 */
class FilterWPQueryTest extends TestCase
{
	/**
	 * Array of mocked posts.
	 *
	 * @var array
	 */
	protected $mockedPosts;

	/**
	 * Prepares the test environment before each test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->mockedPosts = [];
	}

	/**
	 * Test that the filter priority is 10
	 *
	 * @covers \CalderaLearn\RestSearch\FilterWPQuery::getFilterPriority()
	 * @covers \CalderaLearn\RestSearch\FilterWPQuery::$filterPriority
	 */
	public function testGetPriority()
	{
		$this->assertEquals(10, FilterWPQuery::getFilterPriority());
	}

	/**
	 * Test that the getPosts method return an array
	 *
	 * @covers \CalderaLearn\RestSearch\FilterWPQuery::getPosts()
	 */
	public function testGetPosts()
	{
		// Set up the mocks.
		$postsGeneratorMock = Mockery::mock(ContentGetterContract::class);
		$postsGeneratorMock->shouldReceive('getContent')->andReturn([]);
		FilterWPQuery::setContentGetter($postsGeneratorMock);
		$wpQueryMock = Mockery::mock('WP_Query');

		//Add a mock WP_Rest_Request to prevent errors
		$wpRestRequestMock = Mockery::mock('WP_REST_Request');
		FilterWPQuery::captureRequest(null, null, $wpRestRequestMock);

		//Get the mock posts
		$results = FilterWPQuery::getPosts($wpQueryMock);
		//Make sure results are an array
		$this->assertTrue(is_array($results));
	}

	/**
	 * Test that the getPosts method return of WP_Posts
	 *
	 * @covers \CalderaLearn\RestSearch\FilterWPQuery::getPosts()
	 */
	public function testGetPostsArePosts()
	{
		// Set up the mocks.
		$postsGeneratorMock = Mockery::mock(ContentGetterContract::class);
		FilterWPQuery::setContentGetter($postsGeneratorMock);
		$postsGeneratorMock->shouldReceive('getContent')
			->once()
			->andReturnUsing([$this, 'mockImplementationCallback']);
		$wpQueryMock        = Mockery::mock('WP_Query');
		$wpQueryMock->query = ['posts_per_page' => 4];

		//Add a mock WP_Rest_Request to prevent errors
		$wpRestRequestMock = Mockery::mock('WP_REST_Request');
		FilterWPQuery::captureRequest(null, null, $wpRestRequestMock);

		//Get the mock posts
		$results = FilterWPQuery::getPosts($wpQueryMock);
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
	 * Test that our mock returns true for should filter
	 *
	 * @covers FilterWPQuery::shouldFilter()
	 * @covers FilterWPQueryTest::testWithNull()
	 */
	public function testShouldFilter()
	{
		Monkey\Functions\expect('did_action')
			->once()
			->with('rest_api_init')
			->andReturn(1);
		$this->assertTrue(FilterWPQuery::shouldFilter(null));
	}

	/**
	 * Test the result data is consistent
	 *
	 * @covers \CalderaLearn\RestSearch\FilterWPQuery::filterPreQuery()
	 */
	public function testCallbackWithNull()
	{
		// Set up the mocks.
		Monkey\Functions\expect('did_action')
			->once()
			->with('rest_api_init')
			->andReturn(1);
		$postsGeneratorMock = Mockery::mock(ContentGetterContract::class);
		FilterWPQuery::setContentGetter($postsGeneratorMock);
		$postsGeneratorMock->shouldReceive('getContent')
			->once()
			->andReturnUsing([$this, 'mockImplementationCallback']);
		$wpQueryMock        = Mockery::mock('WP_Query');
		$wpQueryMock->query = ['posts_per_page' => 4];

		$wpRestRequestMock = Mockery::mock('WP_REST_Request');
		FilterWPQuery::captureRequest(null, null, $wpRestRequestMock);
		//Get the results from the callback
		$results = FilterWPQuery::filterPreQuery(null, $wpQueryMock);

		//Make sure results are an array
		$this->assertTrue(is_array($results));

		//Make sure the two arrays are the same size
		$this->assertCount(count($this->mockedPosts), $results);

		/** These arrays are not the same, compare the meaning of the contents */

		//Used to make sure this loop of tests ran
		$looped = false;
		/**
		 * Loop through expected, comparing to actual results
		 * @var int $i
		 * @var  \WP_Post $post
		 */
		foreach ($this->mockedPosts as $index => $post) {
			$looped = true;
			//Test that the mock and resulting post titles are the same
			$this->assertSame($post->post_title, $results[$index]->post_title);
		}
		//Make sure loop ran
		$this->assertTrue($looped);
	}

	/**
	 * Test the result data is not changed, when passed an array
	 *
	 * * @covers \CalderaLearn\RestSearch\FilterWPQuery::filterPreQuery()
	 */
	public function testCallbackWithArray()
	{
		// Set up the mocks.
		Monkey\Functions\expect('did_action')->with('rest_api_init')->never();
		$postsGeneratorMock = Mockery::mock(ContentGetterContract::class);
		FilterWPQuery::setContentGetter($postsGeneratorMock);
		$postsGeneratorMock->shouldNotReceive('getContent');
		$wpQueryMock        = Mockery::mock('WP_Query');
		$wpQueryMock->query = ['posts_per_page' => 4];

		//Create 1 mock posts
		$expected = $this->generateMockedPosts(1);

		//Get the results from the callback
		$results = FilterWPQuery::filterPreQuery($expected, $wpQueryMock);

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
		 * @var  \WP_Post $post
		 */
		foreach ($expected as $index => $post) {
			$looped = true;
			//Test that the mock and resulting post titles are the same
			$this->assertSame($post->post_title, $results[$index]->post_title);
		}
		//Make sure loop ran
		$this->assertTrue($looped);
	}

	/**
	 * Generates mocked posts for our tests.
	 *
	 * @param WP_Query $query Instance of the query mock.
	 *
	 * @return array
	 */
	public function mockImplementationCallback($query): array
	{
		// Need to grab a quantity.
		return $this->generateMockedPosts(4);
	}

	/**
	 * Generates mocked posts for our tests.
	 *
	 * @param int $quantity Number of posts to generate.
	 *
	 * @return array
	 */
	protected function generateMockedPosts($quantity): array
	{
		$this->mockedPosts = [];
		for ($postNumber = 0; $postNumber < $quantity; $postNumber++) {
			$post                = Mockery::mock('WP_Post');
			$post->post_title    = "Mock Post {$postNumber}";
			$post->filter        = 'raw';
			$this->mockedPosts[] = $post;
		}
		return $this->mockedPosts;
	}
}
