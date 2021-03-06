<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

class BaseController
{
    public $plugin_path;
    public $plugin_url;
    public $plugin;
    public $managers = array();

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin = plugin_basename(dirname(__FILE__, 3)) . '/crivas-plugin.php';

        $this->managers = [
            'cpt_manager' => 'Activate CPT Manager',
            'taxonomy_manager' => 'Activate Taxonomy Manager',
            'media_widgets' => 'Activate Media Widgets',
            'gallery_manager' => 'Activate Gallery Manager',
            'testimonial_manager' => 'Activate Testimonial Manager',
            'templates_manager' => 'Activate Templates Manager',
            'login_manager' => 'Activate Login Manager',
            'memberships_manager' => 'Activate Memberships Manager',
            'chats_manager' => 'Activate Chats Manager',
        ];
    }

    public function activated( string $key )
	{
		$option = get_option( 'crivas_plugin' );
		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}
