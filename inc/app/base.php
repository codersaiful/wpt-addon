<?php 
namespace MMQ_USERS\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'MMQ_USERS';
    public $data_name = 'MMQ_USERS_DATA';

    public function __construct()
    {
        $this->version = MMQ_USERS_VERSION;
        $this->base_url = MMQ_USERS_BASE_URL;
    }
}