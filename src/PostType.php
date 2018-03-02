<?php


namespace CalderaLearn\RestSearch;

/**
 * Class PostType
 *
 * Post type whose POST wp/v2/<post-type-rest_base> we are hijacking
 *
 */
class PostType
{
    /**
     * Post type slug
     *
     * @TODO Change this to your post type's slug
     */
    const SLUG = 'post';

    /**
     * Post type rest_base
     *
     * @TODO Change this to your post type's rest_base
     */
    const RESTBASE = 'posts';
}
