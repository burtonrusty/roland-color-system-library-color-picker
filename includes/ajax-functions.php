<?php
// includes/ajax-functions.php

// Hook for logged-in users to delete a user color
add_action('wp_ajax_rcs_delete_user_color', 'rcs_delete_user_color');

// Function to delete a user color
function rcs_delete_user_color() {
    // Check the nonce for security
    if (!check_ajax_referer('rcs_save_color_nonce', 'security', false)) {
        wp_send_json_error(array('message' => 'Nonce check failed.'));
        return;
    }

    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'You need to be logged in to delete colors.'));
        return;
    }

    // Check if the color is set in the POST request
    if (!isset($_POST['color'])) {
        wp_send_json_error(array('message' => 'No color specified for deletion.'));
        return;
    }

    $color = sanitize_text_field($_POST['color']);
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_team_colors';
    $user_id = get_current_user_id();

    // Delete the color
    $result = $wpdb->delete(
        $table_name,
        array(
            'user_id' => $user_id,
            'color' => $color
        ),
        array(
            '%d',
            '%s'
        )
    );

    if ($result !== false) {
        wp_send_json_success(array('message' => 'Color deleted successfully.'));
    } else {
        wp_send_json_error(array('message' => 'Failed to delete color.'));
    }
}

// Hook for logged-in users to save a user color
add_action('wp_ajax_rcs_save_user_color', 'rcs_save_user_color');

// Function to save a user color
function rcs_save_user_color() {
    // Check the nonce for security
    if (!check_ajax_referer('rcs_save_color_nonce', 'security', false)) {
        wp_send_json_error(array('message' => 'Nonce check failed.'));
        return;
    }

    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'You need to be logged in to save colors.'));
        return;
    }

    // Check if the color is set in the POST request
    if (!isset($_POST['color'])) {
        wp_send_json_error(array('message' => 'Color not set in POST request.'));
        return;
    }

    $color = sanitize_text_field($_POST['color']);
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_team_colors';
    $user_id = get_current_user_id();

    // Insert the color
    $result = $wpdb->insert(
        $table_name,
        array(
            'user_id' => $user_id,
            'color' => $color
        ),
        array(
            '%d',
            '%s'
        )
    );

    if ($result !== false) {
        wp_send_json_success(array('message' => 'Your team color has been saved successfully.'));
    } else {
        wp_send_json_error(array('message' => 'Failed to save your team color.'));
    }
}