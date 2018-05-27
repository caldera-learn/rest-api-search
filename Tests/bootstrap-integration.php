<?php
// phpcs:disable
/**
 * This is the bootstrap file for Integration Tests -- run with composer wp-tests
 */

$_tests_dir = getenv('WP_TESTS_DIR');
if (! $_tests_dir) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Load Patchwork before everything else in order to allow us to redefine WordPress and Beans functions.
require_once dirname(dirname(__FILE__)) . '/vendor/brain/monkey/inc/patchwork-loader.php';

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin()
{
	require dirname(dirname(__FILE__)) . '/rest-api-search.php';
}
tests_add_filter('muplugins_loaded', '_manually_load_plugin');

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
// phpcs:enable
