<?php


namespace calderawp\CalderaForms\Admin;
use calderawp\CalderaForms\Admin\Menu\MainPage;
use calderawp\CalderaForms\Admin\Menu\Page;
use calderawp\CalderaForms\Admin\ReactWPScripts as ReactWPScripts;

class AdminUi
{

    /**
     * @var string
     */
    protected $pluginDirPath;
    public function __construct($pluginDirPath)
    {
        $this->pluginDirPath = $pluginDirPath;
    }

    /**
     * Enqueue the assets for the menu pages
     */
    public function enqueueAdmin()
    {
        ReactWPScripts\enqueue_assets( $this->pluginDirPath );
    }

    /**
     * Add the hooks to load the menu pages
     */
    public function setUpMenus(){
        $mainPage = new MainPage('caldera-forms', 'form', 'Caldera Forms', 'caldera-forms-admin' );
        add_action('admin_menu', [$mainPage, 'display']);
        $calderaFormsEntries = new Page('caldera-forms-entries', 'form', 'Caldera Forms', 'caldera-forms-admin-entries' );
        add_action('admin_menu', [$calderaFormsEntries, 'display']);
    }
}