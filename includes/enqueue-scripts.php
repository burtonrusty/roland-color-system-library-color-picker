<?php
// includes/enqueue-scripts.php

function rcs_enqueue_scripts() {
    $css_version = '1.0.21'; // Define the CSS version
    $js_version = '1.0.0'; // Define the JS version

    // Correct path to the CSS and JS files
    $css_file = plugin_dir_url(dirname(__FILE__)) . 'assets/css/rcs-style.css';
    $js_file = plugin_dir_url(dirname(__FILE__)) . 'assets/js/rcs-script.js';

    // Log the URLs for debugging
    error_log('CSS File URL: ' . $css_file);
    error_log('JS File URL: ' . $js_file);

    // Enqueue the styles and scripts
    wp_enqueue_style('rcs-styles', $css_file, array(), $css_version);
    wp_enqueue_script('rcs-scripts', $js_file, array('jquery'), $js_version, true);

    // Localize the script with new data
    wp_localize_script('rcs-scripts', 'rcs_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('rcs_save_color_nonce')
    ));
}

add_action('wp_enqueue_scripts', 'rcs_enqueue_scripts');

// Add defer attribute to the script
function add_defer_attribute($tag, $handle) {
    if ('rcs-scripts' !== $handle) {
        return $tag;
    }
    return str_replace(' src', ' defer="defer" src', $tag);
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);