<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;

class Enqueue extends BaseController
{
    public function register()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    public function enqueue()
    {
        // enqueue all our script
        wp_enqueue_script('media-upload');
        wp_enqueue_media();
        wp_enqueue_style('mypluginstyle', $this->plugin_url . 'assets/mystyle.css', __FILE__);
        wp_enqueue_script('mypluginscript', $this->plugin_url . 'assets/myscript.js', __FILE__);
    }
}
