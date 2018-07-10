<?php


namespace calderawp\CalderaForms\Admin;


class Container extends \calderawp\CalderaContainers\Service\Container
{

    /** @var string */
    protected $pluginDirPath;
    public function __construct($pluginDirPath = '' )
    {
        $this->pluginDirPath = $pluginDirPath;
        $this->singleton( 'AdminUi', function (){
            new AdminUi( $this->pluginDirPath );
        });
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPluginDirPath($path)
    {
        $this->pluginDirPath = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPluginDirPath(){
        return $this->pluginDirPath;
    }
}