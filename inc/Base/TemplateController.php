<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class TemplateController extends BaseController
{
    public $callbacks;
    public $subpages = array();
    public function register()
    {
        
        if (!$this->activated('templates_manager')) {
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
                'page_title' => 'Templates Manager', 
				'menu_title' => 'Templates Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'crivas_templates',
                'callback' => array($this->callbacks, 'adminTemplatesManager'),
            ),
        );
    }
}
