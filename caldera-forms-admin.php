<?php
/**
 * Plugin name: Caldera Forms Admin
 */
include_once __DIR__ .'/vendor/autoload.php';

add_action( 'init', function(){

    $adminUi = new \calderawp\CalderaForms\Admin\AdminUi( plugin_dir_path( __FILE__ ) );
    $adminUi->setUpMenus();
    $adminUi->enqueueAdmin();
});




