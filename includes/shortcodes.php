<?php
// includes/shortcodes.php
function rcs_display_section_shortcode()
{
    if (!is_user_logged_in()) {
        return '<p>You need to be logged in to save colors.</p>';
    }

    $output = '<div id="rcs-display-container">';
    $output .= '<div id="rcs-color-display" style="width: 400px; height: 400px; border: 1px solid #000;"></div>';
    $output .= '<input type="text" id="rcs-hex-display" readonly style="margin-top: 10px; width: 400px; text-align: center;" />';
    $output .= '<form id="rcs-save-color-form" method="post" action="">';
    $output .= '<input type="hidden" name="rcs_color" id="rcs_color" value="" />';
    $output .= '<input type="submit" name="rcs_save_color" value="Save Team Color" style="width: 100%; margin-top: 10px; background-color: black; color: white;" />';
    $output .= '</form>';
    $output .= '</div>';

    return $output;
}
add_shortcode('rcs_display_section', 'rcs_display_section_shortcode');

// Shortcode to display user colors with delete buttons
function rcs_display_user_colors()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_team_colors';
    $user_id = get_current_user_id();
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT color FROM $table_name WHERE user_id = %d",
        $user_id
    ));

    $output = '<div id="rcs-user-colors">';
    foreach ($results as $row) {
        $color = esc_attr($row->color);
        $image_url = plugins_url('assets/images/delete-icon.png', dirname(__FILE__));
        $output .= '<div class="rcs-color-box" style="background-color: ' . $color . '; width: 200px; height: 200px; margin: 10px; display: inline-block; position: relative;">';
        $output .= '<img src="' . $image_url . '" class="rcs-delete-color" data-color="' . $color . '" style="position: absolute; top: 5px; right: 5px; width: 20px; height: 20px; cursor: pointer;" />';
        $output .= '<span class="rcs-color-code" style="position: absolute; bottom: 5px; left: 5px; color: #fff; background-color: rgba(0, 0, 0, 0.5); padding: 2px 5px; border-radius: 3px;">' . $color . '</span>';
        $output .= '</div>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode('rcs_user_colors', 'rcs_display_user_colors');
// palette shortcodes

function rcs_color_palettes_section_shortcode()
{
    $palette1 = include plugin_dir_path(__FILE__) . '../assets/palettes/palette1.php';
    $palette2 = include plugin_dir_path(__FILE__) . '../assets/palettes/palette2.php';
    $palette3 = include plugin_dir_path(__FILE__) . '../assets/palettes/palette3.php';
    $palette4 = include plugin_dir_path(__FILE__) . '../assets/palettes/palette4.php';
    $palette5 = include plugin_dir_path(__FILE__) . '../assets/palettes/palette5.php';
    $palette6 = include plugin_dir_path(__FILE__) . '../assets/palettes/palette6.php';

    $palettes = array(
        'Palette 1' => $palette1,
        'Palette 2' => $palette2,
        'Palette 3' => $palette3,
        'Palette 4' => $palette4,
        'Palette 5' => $palette5,
        'Palette 6' => $palette6,
    );

    $output = '<div id="rcs-color-palettes">';
    foreach ($palettes as $paletteName => $palette) {
        $output .= '<div class="rcs-palette-container">';
        $output .= '<h3>' . $paletteName . '</h3>';
        $output .= '<div class="rcs-color-grid">';

        foreach ($palette as $name => $color) {
            $output .= '<div class="rcs-color-block" data-color="' . $color . '" style="background-color: ' . $color . ';" title="' . $name . '"></div>';
        }

        $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode('rcs_color_palettes_section', 'rcs_color_palettes_section_shortcode');

function rcs_palette1_shortcode()
{
    $palette = include plugin_dir_path(__FILE__) . '../assets/palettes/palette1.php';
    return rcs_generate_palette_html('Palette 1', $palette);
}
add_shortcode('rcs_palette1', 'rcs_palette1_shortcode');

function rcs_palette2_shortcode()
{
    $palette = include plugin_dir_path(__FILE__) . '../assets/palettes/palette2.php';
    return rcs_generate_palette_html('Palette 2', $palette);
}
add_shortcode('rcs_palette2', 'rcs_palette2_shortcode');

function rcs_palette3_shortcode()
{
    $palette = include plugin_dir_path(__FILE__) . '../assets/palettes/palette3.php';
    return rcs_generate_palette_html('Palette 3', $palette);
}
add_shortcode('rcs_palette3', 'rcs_palette3_shortcode');

function rcs_palette4_shortcode()
{
    $palette = include plugin_dir_path(__FILE__) . '../assets/palettes/palette4.php';
    return rcs_generate_palette_html('Palette 4', $palette);
}
add_shortcode('rcs_palette4', 'rcs_palette4_shortcode');

function rcs_palette5_shortcode()
{
    $palette = include plugin_dir_path(__FILE__) . '../assets/palettes/palette5.php';
    return rcs_generate_palette_html('Palette 5', $palette);
}
add_shortcode('rcs_palette5', 'rcs_palette5_shortcode');

function rcs_palette6_shortcode()
{
    $palette = include plugin_dir_path(__FILE__) . '../assets/palettes/palette6.php';
    return rcs_generate_palette_html('Palette 6', $palette);
}
add_shortcode ('rcs_palette6', 'rcs_palette6_shortcode');