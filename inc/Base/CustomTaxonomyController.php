<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\TaxonomyCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class CustomTaxonomyController extends BaseController
{
    public $settings;

    public $callbacks;

    public $tax_callbacks;

    public $subpages = array();

    public $taxonomies = array();

    public function register()
    {
        if (!$this->activated('taxonomy_manager')) {
            return;
        }

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->tax_callbacks = new TaxonomyCallbacks();

        $this->setSubPages();

        $this->setSettings();

        $this->setSections();

        $this->setFields();

        $this->settings->addSubPages($this->subpages)->register();

        $this->storeCustomTaxonomies();

        if (!empty($this->taxonomies)) {
            add_action('init', array($this, 'registerCustomTaxonomies'));
        }

    }
    public function setSubpages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'crivas_plugin',
                'page_title' => 'Custom Taxonomies',
                'menu_title' => 'Taxonomy Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'crivas_taxonomy',
                'callback' => array($this->callbacks, 'adminTaxonomyManager'),
            ),
        );
    }

    public function setSettings()
    {
        $args = [
            [
                'option_group' => 'crivas_plugin_tax_settings',
                'option_name' => 'crivas_taxonomy',
                'callback' => [$this->tax_callbacks, 'taxSanitize'],
            ],
        ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => 'crivas_tax_index',
                'title' => 'Custom Taxnomy Manager',
                'callback' => [$this->tax_callbacks, 'taxSectionManager'],
                'page' => 'crivas_taxonomy',
            ],
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [
            [
                'id' => 'taxonomy',
                'title' => 'Custom Taxnomy ID',
                'callback' => [$this->tax_callbacks, 'textField'],
                'page' => 'crivas_taxonomy',
                'section' => 'crivas_tax_index',
                'args' => [
                    'option_name' => 'crivas_taxonomy',
                    'label_for' => 'taxonomy',
                    'placeholder' => 'eg. genre',
                ],
            ],
            [
                'id' => 'singular_name',
                'title' => 'Singular Name',
                'callback' => [$this->tax_callbacks, 'textField'],
                'page' => 'crivas_taxonomy',
                'section' => 'crivas_tax_index',
                'args' => [
                    'option_name' => 'crivas_taxonomy',
                    'label_for' => 'singular_name',
                    'placeholder' => 'eg. Genre',
                ],
            ],
            [
                'id' => 'hierarchical',
                'title' => 'Hierarchical',
                'callback' => [$this->tax_callbacks, 'checkboxField'],
                'page' => 'crivas_taxonomy',
                'section' => 'crivas_tax_index',
                'args' => [
                    'option_name' => 'crivas_taxonomy',
                    'label_for' => 'hierarchical',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'id' => 'objects',
                'title' => 'Post Types',
                'callback' => [$this->tax_callbacks, 'checkboxPostTypesField'],
                'page' => 'crivas_taxonomy',
                'section' => 'crivas_tax_index',
                'args' => [
                    'option_name' => 'crivas_taxonomy',
                    'label_for' => 'objects',
                    'class' => 'ui-toggle',
                ],
            ],
        ];

        $this->settings->setFields($args);
    }

    public function storeCustomTaxonomies()
    {
        // get the taxonomies array
        $options = get_option('crivas_taxonomy') ?: array();

        // store this info into an array
        foreach ($options as $option) {
            $labels = array(
                'name' => $option['singular_name'],
                'singular_name' => $option['singular_name'],
                'search_items' => 'Search ' . $option['singular_name'],
                'all_items' => 'All ' . $option['singular_name'],
                'parent_item' => 'Parent ' . $option['singular_name'],
                'parent_item_colon' => 'Parent ' . $option['singular_name'],
                'edit_item' => 'Edit ' . $option['singular_name'],
                'update_item' => 'Update ' . $option['singular_name'],
                'add_new_item' => 'Add New ' . $option['singular_name'],
                'new_item_name' => 'New ' . $option['singular_name'] . ' Name',
                'menu_name' => $option['singular_name'],
            );
            $this->taxonomies[] = [
                'hierarchical' => isset($option['hierarchical']) ?: false,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => $option['taxonomy']),
                'objects' => isset($option['objects']) ? $option['objects']: null,
            ];
        }

        // register the taxonomy

    }

    public function registerCustomTaxonomies()
    {
        foreach ($this->taxonomies as $taxonomy) {
            
            $objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null;
            
            register_taxonomy($taxonomy['rewrite']['slug'], $objects, $taxonomy);
        }
    }

}
