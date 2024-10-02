<?php
/*
Plugin Name: Roland Color System Library
Description: A plugin that adds a color picker to your site.
Version: 1.0.1
Author: Rusty Burton
*/

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/ajax-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/db-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/rest-api.php';

// Add settings link to plugin actions
function rcs_add_settings_link($links) {
    $settings_link = '<a href="admin.php?page=rcs-color-library">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'rcs_add_settings_link');




