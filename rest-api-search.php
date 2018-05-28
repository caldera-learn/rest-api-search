<?php
/**
 * Plugin Name:     Rest Api Search
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     rest-api-search
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Rest_Api_Search
 */

namespace CalderaLearn\RestSearch;

use CalderaLearn\RestSearch\ContentGetter\PostsGenerator;
use CalderaLearn\RestSearch\Features\Factory;

include_once __DIR__ .'/vendor/autoload.php';

/**
 * Launch the plugin.
 */
add_action( 'init', function(){

	FilterWPQuery::setContentGetter( new PostsGenerator() );
	$postTypes = new PreparedPostTypes( get_post_types([], 'objects') );
    Factory::search( new ModifyQueryArgs($postTypes), new ModifySchema($postTypes ));
	( new Hooks() )->addHooks();
});
