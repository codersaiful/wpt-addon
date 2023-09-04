<?php 
namespace mmq_users\Inc\App;

class Base{
    public $version;
    public $base_url;
    public $prefix = 'mmq_users';
    public $data_name = 'mmq_users_DATA';

    public function __construct()
    {
        $this->version = MMQ_USERS_VERSION;
        $this->base_url = MMQ_USERS_BASE_URL;
    }
}