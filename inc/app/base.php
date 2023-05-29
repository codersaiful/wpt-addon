<?php 
namespace WCMMQ_GROUP_ADDON\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'wcmmq_group_addon';
    public $data_name = 'WCMMQ_GROUP_ADDON_DATA';

    public function __construct()
    {
        $this->version = WCMMQ_GROUP_ADDON_VERSION;
        $this->base_url = WCMMQ_GROUP_ADDON_BASE_URL;
    }
}