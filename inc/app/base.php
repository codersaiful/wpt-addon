<?php 
namespace WPT_ADDON\Inc\App;

class Base{
    public $version;

    public function __construct()
    {
        $this->version = WPT_ADDON_VERSION;
    }
}