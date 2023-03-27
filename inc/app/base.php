<?php 
namespace WPT_ADDON_LUD\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'wpt_addon';
    public $data_name = 'WPT_ADDON_LUD_DATA';

    public function __construct()
    {
        $this->version = WPT_ADDON_LUD_VERSION;
        $this->base_url = WPT_ADDON_LUD_BASE_URL;
    }
}