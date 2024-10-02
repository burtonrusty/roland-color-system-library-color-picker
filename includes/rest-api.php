<?php
// Hook into the REST API initialization action
add_action('rest_api_init', function () {
    register_rest_route('my-plugin/v1', '/colors', array(
        'methods' => 'GET',
        'callback' => 'get_user_colors',
        'permission_callback' => 'is_user_logged_in', // Ensure the user is logged in
    ));
});

// Callback function to fetch user colors
function get_user_colors($request) {
    $user_id = get_current_user_id();
    if (!$user_id) {
        return new WP_Error('no_user', 'User not logged in', array('status' => 401));
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'user_team_colors'; // Use your actual table name
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id));

    if (empty($results)) {
        return new WP_Error('no_colors', 'No colors found for this user', array('status' => 404));
    }

    return rest_ensure_response($results);
}
