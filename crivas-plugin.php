<?php

/**
 * @package CRivasPlugin
 */

/*
Plugin Name: CRivas Plugin
Plugin URI: http://crivas.com/plugin
Description: This is my first attempt on writing a custom Plugin for this amazing tutorial series.
Version: 1.0.0
Author: Carlos Rivas
Author URI: http://crivas.com
License: GPL v2 or later
Text Domain: CRivas
 */

// if (!defined('ABSPATH')) {
//   die;
// }

defined('ABSPATH') or die('Hey you can\t access this file, you silly human!');

// if (!function_exists('add_action')){
//   echo 'Hey you can\t access this file, you silly human!';
//   die;
// }

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

define('PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN', plugin_basename(__FILE__));

use Inc\Base\Activate;
use Inc\Base\Deactivate;

function activate_crivas_plugin()
{
    Activate::activate();
}

function deactivate_crivas_plugin()
{
    Deactivate::deactivate();
}

//activation
register_activation_hook(__FILE__, 'activate_crivas_plugin');

//deactivation
register_deactivation_hook(__FILE__, 'deactivate_crivas_plugin');

if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}
