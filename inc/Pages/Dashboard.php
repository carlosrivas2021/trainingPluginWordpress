<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Pages;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class Dashboard extends BaseController
{
    public $settings;
    public $callbacks;
    public $callbacks_mngr;
    public $pages = array();
    // public $subpages = array();

    public function register()
    {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->callbacks_mngr = new ManagerCallbacks();

        $this->setPages();

        // $this->setSubPages();

        $this->setSettings();

        $this->setSections();

        $this->setFields();

        // $this->settings->addPages($this->pages)->withSubPages('Dashboard')->addSubPages($this->subpages)->register();
        $this->settings->addPages($this->pages)->withSubPages('Dashboard')->register();
    }

    public function setPages()
    {
        $this->pages = [
            [
                'page_title' => 'CRivas Plugin',
                'menu_title' => 'CRivas',
                'capability' => 'manage_options',
                'menu_slug' => 'crivas_plugin',
                'callback' => array($this->callbacks, 'adminDashboard'),
                'icon_url' => 'dashicons-store',
                'position' => 110,

            ],
        ];
    }

    // public function setSubPages()
    // {
    //     $this->subpages = [
    //         [
    //             'parent_slug' => 'crivas_plugin',
    //             'page_title' => 'Custom post types',
    //             'menu_title' => 'CPT',
    //             'capability' => 'manage_options',
    //             'menu_slug' => 'crivas_plugin_cpt',
    //             'callback' => function () {echo '<h1>CRivas Plugin CPT Manager</h1>';},

    //         ],
    //     ];
    // }

    public function setSettings()
    {

        $args = [
            [
                'option_group' => 'crivas_plugins_settings',
                'option_name' => 'crivas_plugin',
                'callback' => [$this->callbacks_mngr, 'checkboxSanitize'],
            ],
        ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => 'crivas_admin_index',
                'title' => 'Settings Manager',
                'callback' => [$this->callbacks_mngr, 'adminSectionManager'],
                'page' => 'crivas_plugin',
            ],
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {

        $args = array();

        foreach ($this->managers as $key => $value) {
            $args[] = [
                'id' => $key,
                'title' => $value,
                'callback' => [$this->callbacks_mngr, 'checkboxField'],
                'page' => 'crivas_plugin',
                'section' => 'crivas_admin_index',
                'args' => [
                    'option_name' => 'crivas_plugin',
                    'label_for' => $key,
                    'class' => 'ui-toggle',
                ],
            ];
        }

        $this->settings->setFields($args);
    }

}
