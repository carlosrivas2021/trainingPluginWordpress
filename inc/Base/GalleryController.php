<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class GalleryController extends BaseController
{
    public $callbacks;
    public $subpages = array();
    public function register()
    {
        
        if (!$this->activated('gallery_manager')) {
            return;
        }

        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->setSubpages();
        $this->settings->addSubPages($this->subpages)->register();
    }
    public function setSubpages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'crivas_plugin',
                'page_title' => 'Gallery Manager', 
				'menu_title' => 'Gallery Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'crivas_gallery',
                'callback' => array($this->callbacks, 'adminGalleryManager'),
            ),
        );
    }
}
