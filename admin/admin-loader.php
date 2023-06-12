<?php
namespace WCMMQ_ADDON\Admin;

use WCMMQ_ADDON\Inc\App\Enqueue;
use WCMMQ_ADDON\Inc\App\Base;
use WCMMQ_ADDON\Inc\App\Hook_Base;

class Admin_Loader extends Hook_Base
{
    public function run()
    {

        new Menu_Page_Table();
    }

}