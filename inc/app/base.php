<?php 
namespace WPT_ADDON\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'wpt_addon';
    public $data_name = 'WPT_ADDON_DATA';

    public function __construct()
    {
        $this->version = WPT_ADDON_VERSION;
        $this->base_url = WPT_ADDON_BASE_URL;
    }
}