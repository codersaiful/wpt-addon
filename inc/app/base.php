<?php 
namespace CCD_WPT_ADDON\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'ccd_wpt_addon';
    public $data_name = 'CCD_WPT_ADDON_DATA';

    public function __construct()
    {
        $this->version = CCD_WPT_ADDON_VERSION;
        $this->base_url = CCD_WPT_ADDON_BASE_URL;
    }
}