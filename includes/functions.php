<?php
// includes/functions.php

// Function to generate palette HTML
function rcs_generate_palette_html($paletteName, $palette)
{
    $enabled_palettes = get_option('rcs_enabled_palettes', array());
    error_log('Enabled palettes: ' . print_r($enabled_palettes, true));

    if (!in_array($paletteName, $enabled_palettes)) {
        error_log('Palette not enabled: ' . $paletteName);
        return ''; // Return empty if the palette is not enabled
    }

    $output = '<div class="rcs-palette-container">';
    $output .= '<h5 style="text-align: center;">' . $paletteName . '</h5>';

    foreach ($palette as $rowLabel => $row) {
        $output .= '<div class="rcs-color-row">';
        $output .= '<span class="rcs-row-label hidden-label">' . $rowLabel . '</span>'; // Add row label
        $output .= '<div class="rcs-color-grid">';

        foreach ($row as $name => $color) {
            $output .= '<div class="rcs-color-block" data-color="' . $color . '" style="background-color: ' . $color . ';" title="' . $name . '"></div>';
        }

        $output .= '</div>'; // Close rcs-color-grid
        $output .= '</div>'; // Close rcs-color-row
    }

    $output .= '</div>'; // Close rcs-palette-container

    error_log('Generated palette HTML: ' . $output);

    return $output;
}

// Function to manually check enabled palettes
function rcs_check_enabled_palettes() {
    $enabled_palettes = get_option('rcs_enabled_palettes', array());
    error_log('Enabled palettes (manual check): ' . print_r($enabled_palettes, true));
}

add_action('init', 'rcs_check_enabled_palettes');