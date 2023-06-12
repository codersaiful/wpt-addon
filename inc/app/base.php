<?php 
namespace WCMMQ_ADDON\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'wpt_addon';
    public $notify_table_name = 'wcmmq_low_stock_emails';
    public $data_name = 'WPT_ADDON_DATA';

    public function __construct()
    {
        $this->version = WCMMQ_ADDON_VERSION;
        $this->base_url = WCMMQ_ADDON_BASE_URL;
    }
}