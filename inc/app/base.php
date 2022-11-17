<?php 
namespace WPT_ADDON\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'wpt_addon_vf';
    public $data_name = 'WPT_ADDON_VF_DATA';

    public function __construct()
    {
        $this->version = WPT_ADDON_VF_VERSION;
        $this->base_url = WPT_ADDON_VF_BASE_URL;
    }
}