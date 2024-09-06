<?php
// includes/db-functions.php to create database table on activation
function rcs_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_team_colors';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        color varchar(7) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'rcs_create_table');