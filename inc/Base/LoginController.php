<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class LoginController extends BaseController
{
    public $callbacks;
    public $subpages = array();
    public function register()
    {
        
        if (!$this->activated('login_manager')) {
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
                'page_title' => 'Login Manager', 
				'menu_title' => 'Login Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'crivas_login',
                'callback' => array($this->callbacks, 'adminLoginManager'),
            ),
        );
    }
}
