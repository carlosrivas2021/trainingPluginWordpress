<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class MembershipsController extends BaseController
{
    public $callbacks;
    public $subpages = array();
    public function register()
    {
        
        if (!$this->activated('memberships_manager')) {
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
                'page_title' => 'Memberships Manager', 
				'menu_title' => 'Memberships Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'crivas_memberships',
                'callback' => array($this->callbacks, 'adminMembershipsManager'),
            ),
        );
    }
}
