<?php

// includes/admin-settings.php
// Create the settings page
function rcs_color_library_settings_page() {
    if (isset($_POST['rcs_enabled_palettes'])) {
        check_admin_referer('rcs_save_palettes', 'rcs_nonce');
        $enabled_palettes = array_map('sanitize_text_field', $_POST['rcs_enabled_palettes']);
        update_option('rcs_enabled_palettes', $enabled_palettes);
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    $enabled_palettes = get_option('rcs_enabled_palettes', array());
    ?>
    <div class="wrap">
        <h1>Color Library Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('rcs_save_palettes', 'rcs_nonce'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Enabled Palettes</th>
                    <td>
                        <?php rcs_enabled_palettes_callback(); ?>
                        <p class="description">Select the palettes you want to enable.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action('admin_init', 'rcs_register_settings');

function rcs_register_settings() {
    register_setting('rcs_color_library_settings_group', 'rcs_enabled_palettes');

    add_settings_section(
        'rcs_color_library_settings_section',
        'Manage Palettes',
        'rcs_color_library_settings_section_callback',
        'rcs-color-library'
    );

    add_settings_field(
        'rcs_enabled_palettes',
        '<span class="dashicons dashicons-color-picker"></span> Enabled Palettes',
        'Enabled Palettes',
        'rcs_enabled_palettes_callback',
        'rcs-color-library',
        'rcs_color_library_settings_section'
    );
}

function rcs_color_library_settings_section_callback() {
    echo 'Select the palettes you want to enable:';
}

function rcs_enabled_palettes_callback() {
    $palettes = array('Palette 1', 'Palette 2', 'Palette 3', 'Palette 4', 'Palette 5', 'Palette 6'); // List of palettes
    $enabled_palettes = get_option('rcs_enabled_palettes', array());

    foreach ($palettes as $palette) {
        $checked = in_array($palette, $enabled_palettes) ? 'checked' : '';
        echo '<label><input type="checkbox" name="rcs_enabled_palettes[]" value="' . $palette . '" ' . $checked . '> ' . $palette . '</label><br>';
    }
}

// Add the settings page to the admin menu
if (is_admin()) {
    add_action('admin_menu', 'rcs_add_admin_menu');
    add_action('admin_init', 'rcs_register_settings');
}

function rcs_add_admin_menu() {
    add_menu_page(
        'Color Library Settings', // Page title
        'Color Library', // Menu title
        'manage_options', // Capability
        'rcs-color-library', // Menu slug
        'rcs_color_library_settings_page', // Callback function
        'dashicons-admin-customizer', // Icon (Dashicon class for color picker)
        80 // Position
    );
}