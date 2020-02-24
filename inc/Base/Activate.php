<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

class Activate
{
    public static function activate()
    {
        // generated a CPT
        // flush rewrite rules
        flush_rewrite_rules();

        $default = array();

        if (!get_option('crivas_plugin')) {
            update_option('crivas_plugin', $default);
        }
        if (!get_option('crivas_cpt')) {
            update_option('crivas_cpt', $default);
        }
        if (!get_option('crivas_taxonomy')) {
            update_option('crivas_taxonomy', $default);
        }

    }
}
