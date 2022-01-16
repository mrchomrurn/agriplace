<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;


/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function agriox_child_theme_setup()
{
    load_child_theme_textdomain('agriox-child', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'agriox_child_theme_setup');

if (!function_exists('agriox_child_thm_parent_css')) :
    function agriox_child_thm_parent_css()
    {
        // loading parent styles
        wp_enqueue_style('agriox-parent-style', get_template_directory_uri() . '/style.css', array('agriox-fonts', 'agriox-icons', 'bootstrap', 'fontawesome'));

        // loading child style based on parent style
        wp_enqueue_style('agriox-style', get_stylesheet_directory_uri() . '/style.css', array('agriox-parent-style'));
    }

endif;
add_action('wp_enqueue_scripts', 'agriox_child_thm_parent_css');

// END ENQUEUE PARENT ACTION