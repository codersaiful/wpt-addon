<?php 
namespace WPT_ADDON\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'related_products_category_table';
    public $data_name = 'WPT_ADDON_DATA';

    public function __construct()
    {
        $this->version = WPT_RLC_VERSION;
        $this->base_url = WPT_RLC_BASE_URL;
    }
}