<?php

namespace CalderaLearn\RestSearch\Tests\Mock;

use stdClass;
use WP_Post;

/**
 * Class FilterWPQuery
 *
 * Mock class that is totally decoupled from WordPress
 *
 * @package CalderaLearn\RestSearch\Tests\Mock
 */
class FilterWPQuery extends \CalderaLearn\RestSearch\FilterWPQuery
{
	/** @inheritdoc */
	public static function shouldFilter($postsOrNull) : bool
	{
		return is_null($postsOrNull);
	}

	/** @inheritdoc */
	public static function removeFilter() : bool
	{
		return true;
	}

	/** @inheritdoc */
	public static function getPosts() : array
	{
		$mockPosts = [];
		for ($postNumber = 0; $postNumber <= 4; $postNumber++) {
			$post             = new WP_Post( new stdClass() );
			$post->post_title = "Mock Post {$postNumber}";
			$post->filter     = 'raw';
			$mockPosts[]      = $post;
		}

		return $mockPosts;
	}
}
