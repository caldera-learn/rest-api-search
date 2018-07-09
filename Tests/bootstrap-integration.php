<?php
// phpcs:disable
/**
 * This is the bootstrap file for Integration Tests -- run with composer wp-tests
 */

$_tests_dir = getenv('WP_TESTS_DIR');
if (!$_tests_dir) {
    $_tests_dir = '/tmp/wordpress-tests-lib';
}

// Load Patchwork before everything else in order to allow us to redefine WordPress and plugin functions.
require_once dirname(__FILE__, 2) . '/vendor/brain/monkey/inc/patchwork-loader.php';

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

tests_add_filter('muplugins_loaded', '_manually_load_plugin');
/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin()
{
    require dirname(__FILE__, 2) . '/caldera-forms-admin.php';
}

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

// Clean up.
unset($_tests_dir);
// phpcs:enable
