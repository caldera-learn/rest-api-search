<?php

namespace CalderaLearn\RestSearch;

/**
 * Class PreparedPostTypes
 *
 * Prepares post types in the format we need for the UsesPreparedPostTypes trait
 * @package ExamplePlugin
 */
class PreparedPostTypes
{

    /**
     * Prepared post types
     *
     * @var array
     */
    protected $postTypes;

    /**
     * PreparedPostTypes constructor.
     * @param array $postTypes Array of post type objects `get_post_types([], 'objects')`
     */
    public function __construct(array $postTypes)
    {
        $this->setPostTypes($postTypes);
    }


    /**
     * Get an array of "rest_base" values for all public post types
     *
     * @return array
     */
    public function getPostTypeRestBases(): array
    {
        return !empty($this->postTypes) ? array_keys($this->postTypes) : [];
    }

    /**
     * Prepare the post types
     *
     * @param array $postTypes
     */
    protected function setPostTypes(array $postTypes)
    {
        $this->postTypes = [];
        /** @var \WP_Post_Type $postType */
        foreach ($postTypes as $postType) {
            if ($postType->show_in_rest) {
                $this->postTypes[$postType->rest_base] = $postType->name;
            }
        }
    }

    /**
     * Convert REST API base to post type slug
     *
     * @param string $restBase
     * @return string|null
     */
    public function restBaseToSlug(string $restBase)
    {
        if (in_array($restBase, $this->getPostTypeRestBases())) {
            return $this->postTypes[$restBase];
        }

        return null;
    }
}
