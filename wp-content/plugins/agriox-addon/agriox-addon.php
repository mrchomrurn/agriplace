<?php

/**
 * Plugin Name: Agriox Theme Addon
 * Description: Required plugin for Agriox Theme.
 * Plugin URI:  https://layerdrops.com/
 * Version:     1.0
 * Author:      Layerdrops
 * Author URI:  https://layerdrops.com/
 * Text Domain: agriox-addon
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once __DIR__ . '/vendor/autoload.php';


/**
 * Main Agriox Theme Addon Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Agriox_Addon_Extension
{

    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var Agriox_Addon_Extension The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return Agriox_Addon_Extension An instance of the class.
     */
    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct()
    {
        $this->define_constants();
        $this->theme_fallback();

        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('AGRIOX_ADDON_VERSION', self::VERSION);
        define('AGRIOX_ADDON_FILE', __FILE__);
        define('AGRIOX_ADDON_PATH', __DIR__);
        define('AGRIOX_ADDON_URL', plugins_url('', AGRIOX_ADDON_FILE));
        define('AGRIOX_ADDON_ASSETS', AGRIOX_ADDON_URL . '/assets');
    }

    /**
     * register fallback theme functions
     *
     * @return void
     */
    public function theme_fallback()
    {
        /**
         * making array of custom icon classes
         * which is saved in transient
         * @return array
         */
        if (!function_exists('agriox_get_fa_icons')) :

            function agriox_get_fa_icons()
            {
                $data = get_transient('agriox_fa_icons');

                if (empty($data)) {
                    global $wp_filesystem;
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();

                    $fontAwesome_file =   AGRIOX_ADDON_PATH . '/assets/vendors/fontawesome/css/all.min.css';
                    $template_icon_file = AGRIOX_ADDON_PATH . '/assets/vendors/agriox-icons/style.css';
                    $content = '';

                    if ($wp_filesystem->exists($fontAwesome_file)) {
                        $content = $wp_filesystem->get_contents($fontAwesome_file);
                    } // End If Statement

                    if ($wp_filesystem->exists($template_icon_file)) {
                        $content .= $wp_filesystem->get_contents($template_icon_file);
                    } // End If Statement

                    $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';
                    $pattern_two = '/\.(icon-(?:\w+(?:-)?)+):before\s*{\s*content/';

                    $subject = $content;

                    preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
                    preg_match_all($pattern_two, $subject, $matches_two, PREG_SET_ORDER);

                    $all_matches = array_merge($matches, $matches_two);

                    $icons = array();

                    foreach ($all_matches as $match) {
                        // $icons[] = array('value' => $match[1], 'label' => $match[1]);
                        $icons[] = $match[1];
                    }


                    $data = $icons;
                    set_transient('agriox_fa_icons', $data, 10080); // saved for one week

                }

                return array_combine($data, $data); // combined for key = value
            }


        endif;

        // custom kses allowed html
        if (!function_exists('agriox_kses_allowed_html')) :
            function agriox_kses_allowed_html($tags, $context)
            {
                switch ($context) {
                    case 'agriox_allowed_tags':
                        $tags = array(
                            'a' => array('href' => array(), 'class' => array()),
                            'b' => array(),
                            'br' => array(),
                            'span' => array('class' => array(), 'data-count' => array()),
                            'img' => array('class' => array()),
                            'i' => array('class' => array()),
                            'p' => array('class' => array()),
                            'ul' => array('class' => array()),
                            'li' => array('class' => array()),
                            'div' => array('class' => array()),
                            'strong' => array()
                        );
                        return $tags;
                    default:
                        return $tags;
                }
            }

            add_filter('wp_kses_allowed_html', 'agriox_kses_allowed_html', 10, 2);

        endif;

        if (!function_exists('agriox_excerpt')) :

            // Post's excerpt text
            function agriox_excerpt($get_limit_value, $echo = true)
            {
                $opt = $get_limit_value;
                $excerpt_limit = !empty($opt) ? $opt : 40;
                $excerpt = wp_trim_words(get_the_content(), $excerpt_limit, '');
                if ($echo == true) {
                    echo esc_html($excerpt);
                } else {
                    return esc_html($excerpt);
                }
            }

        endif;


        if (!function_exists('agriox_posted_on')) :
            /**
             * Prints HTML with meta information for the current post-date/time.
             */
            function agriox_posted_on()
            {
                $time_agrioxtring = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
                if (get_the_time('U') !== get_the_modified_time('U')) {
                    $time_agrioxtring = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
                }

                $time_agrioxtring = sprintf(
                    $time_agrioxtring,
                    esc_attr(get_the_date(DATE_W3C)),
                    esc_html(get_the_date()),
                    esc_attr(get_the_modified_date(DATE_W3C)),
                    esc_html(get_the_modified_date())
                );

                $posted_on = sprintf(
                    /* translators: %s: post date. */
                    esc_html_x(' %s', 'post date', 'agriox'),
                    '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_agrioxtring . '</a>'
                );

                echo '<span class="posted-on"><i class="far fa-clock"></i>' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

            }
        endif;

        if (!function_exists('agriox_posted_by')) :
            /**
             * Prints HTML with meta information for the current author.
             */
            function agriox_posted_by()
            {
                $byline = sprintf(
                    /* translators: %s: post author. */
                    esc_html_x('%s', 'post author', 'agriox'),
                    '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
                );

                echo '<span class="byline"><i class="far fa-user-circle"></i> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

            }
        endif;

        if (!function_exists('agriox_comment_count')) {
            function agriox_comment_count()
            {
                if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                    echo '<span class="comments-link"><i class="far fa-comments"></i>';
                    comments_popup_link(
                        sprintf(
                            wp_kses(
                                /* translators: %s: post title */
                                __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'agriox'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        )
                    );
                    echo '</span>';
                }
            }
        }

        if (!function_exists('agriox_entry_footer')) :
            /**
             * Prints HTML with meta information for the categories, tags and comments.
             */
            function agriox_entry_footer()
            {
                // Hide category and tag text for pages.
                if ('post' === get_post_type()) {

                    /* translators: used between list items, there is a space after the comma */
                    $tags_list = get_the_tag_list('', esc_html_x(' ', 'list item separator', 'agriox'));
                    if ($tags_list) {
                        /* translators: 1: list of tags. */
                        printf('<span class="tags-links news-details__tags tags-info"><span>' . esc_html__('Tags %1$s', 'agriox') . '</span>', '</span>' . $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }

                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list(esc_html__(' ', 'agriox'));
                    if ($categories_list) {
                        /* translators: 1: list of categories. */
                        printf('<span class="cat-info news-details__tags cat-links"><span>' . esc_html__('Posted in %1$s', 'agriox') . '</span>', '</span>' . $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                }
            }
        endif;

        if (!function_exists('agriox_post_query')) {
            function agriox_post_query($post_type)
            {
                $post_list = get_posts(array(
                    'post_type' => $post_type,
                    'showposts' => -1,
                ));
                $posts = array();

                if (!empty($post_list) && !is_wp_error($post_list)) {
                    foreach ($post_list as $post) {
                        $options[$post->ID] = $post->post_title;
                    }
                    return $options;
                }
            }
        }

        if (!function_exists('agriox_custom_query_pagination')) :
            /**
             * Prints HTML with post pagination links.
             */
            function agriox_custom_query_pagination($paged = '', $max_page = '')
            {
                global $wp_query;
                $big = 999999999; // need an unlikely integer
                if (!$paged)
                    $paged = get_query_var('paged');
                if (!$max_page)
                    $max_page = $wp_query->max_num_pages;

                $links = paginate_links(array(
                    'base'       => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'     => '?paged=%#%',
                    'current'    => max(1, $paged),
                    'total'      => $max_page,
                    'mid_size'   => 1,
                    'prev_text' => '<i class="fa fa-angle-left"></i>',
                    'next_text' => '<i class="fa fa-angle-right"></i>',
                ));

                echo wp_kses($links, 'agriox_allowed_tags');
            }
        endif;

        if (!function_exists('agriox_get_nav_menu')) :
            function agriox_get_nav_menu()
            {
                $menu_list = get_terms(array(
                    'taxonomy' => 'nav_menu',
                    'hide_empty' => true,
                ));
                $options = [];
                if (!empty($menu_list) && !is_wp_error($menu_list)) {
                    foreach ($menu_list as $menu) {
                        $options[$menu->slug] = $menu->name;
                    }
                    return $options;
                }
            }
        endif;

        if (!function_exists('agriox_get_taxonoy')) :
            function agriox_get_taxonoy($taxonoy)
            {
                $taxonomy_list = get_terms(array(
                    'taxonomy' => $taxonoy,
                    'hide_empty' => true,
                ));
                $options = [];
                if (!empty($taxonomy_list) && !is_wp_error($taxonomy_list)) {
                    foreach ($taxonomy_list as $taxonomy) {
                        $options[$taxonomy->slug] = $taxonomy->name;
                    }
                    return $options;
                }
            }
        endif;

        if (!function_exists('agriox_get_template')) :
            function agriox_get_template($template_name = null)
            {
                $template_path = apply_filters('agriox-elementor/template-path', 'elementor-templates/');
                $template = locate_template($template_path . $template_name);
                if (!$template) {
                    $template = AGRIOX_ADDON_PATH  . '/elementor-templates/' . $template_name;
                }
                if (file_exists($template)) {
                    return $template;
                } else {
                    return false;
                }
            }
        endif;

        if (!function_exists('agriox_get_thumbnail_alt')) :
            function agriox_get_thumbnail_alt($thumbnail_id)
            {
                return get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            }
        endif;
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     *
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function i18n()
    {

        load_plugin_textdomain('agriox-addon', false, AGRIOX_ADDON_PATH . '/languages');
    }

    /**
     * On Plugins Loaded
     *
     * Checks if Elementor has loaded, and performs some compatibility checks.
     * If All checks pass, inits the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function on_plugins_loaded()
    {
        new Layerdrops\Agriox\Assets();
        new Layerdrops\Agriox\PostTypes();
        new Layerdrops\Agriox\Utility();
        new Layerdrops\Agriox\Frontend\Shortcodes();


        if (is_admin()) {
            new Layerdrops\Agriox\Admin();
        }

        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);


        if ($this->is_compatible()) {
            add_action('elementor/init', [$this, 'init']);
        }
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('animate');
        wp_enqueue_style('bootstrap-select');
        wp_enqueue_style('bxslider');
        wp_enqueue_style('jarallax');
        wp_enqueue_style('jquery-magnific-popup');
        wp_enqueue_style('odometer');
        wp_enqueue_style('owl-carousel');
        wp_enqueue_style('owl-theme');
        wp_enqueue_style('reey-font');
        wp_enqueue_style('swiper');
        wp_enqueue_style('agriox-icon-2');
        wp_enqueue_style('agriox-addon-style');

        wp_enqueue_script('bootstrap-select');
        wp_enqueue_script('jquery-bxslider');
        wp_enqueue_script('countdown');
        wp_enqueue_script('isotope');
        wp_enqueue_script('jarallax');
        wp_enqueue_script('jquery-ajaxchimp');
        wp_enqueue_script('jquery-appear');
        wp_enqueue_script('jquery-magnific-popup');
        wp_enqueue_script('odometer');
        wp_enqueue_script('owl-carousel');
        wp_enqueue_script('swiper');
        wp_enqueue_script('wow');
        wp_enqueue_script('sharer');
        wp_enqueue_script('agriox-addon-script');
    }

    /**
     * Compatibility Checks
     *
     * Checks if the installed version of Elementor meets the plugin's minimum requirement.
     * Checks if the installed PHP version meets the plugin's minimum requirement.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function is_compatible()
    {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return false;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return false;
        }

        return true;
    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init()
    {

        $this->i18n();



        // register category
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
        // load icons
        add_filter('elementor/icons_manager/additional_tabs', array($this, 'add_elementor_custom_icons'));

        // Add Plugin actions
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init_widgets()
    {

        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Header());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\MainSlider());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\About());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Features());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\IconBox());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Faq());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Service());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Portfolio());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Testimonials());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Video());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Blog());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Sponsors());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\CallToAction());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Team());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\ContactInfo());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Offer());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Gallery());

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\Shop());

        if (function_exists('wpcf7')) {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\ContactForm());
        }

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\FooterAbout());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\FooterNews());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\FooterNavMenu());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\FooterSubscribe());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Layerdrops\Agriox\Widgets\FooterCopyright());
    }

    public function add_elementor_widget_categories($elements_manager)
    {

        $elements_manager->add_category(
            'agriox-category',
            [
                'title' => __('Agriox Addon', 'agriox-addon'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    public function add_elementor_custom_icons($array)
    {

        return array(
            'agriox' => array(
                'name'          => 'agriox',
                'label'         => 'Agriox Icons',
                'url'           => '',
                'enqueue'       => array(
                    AGRIOX_ADDON_URL . '/assets/vendors/agriox-icons/style.css',
                ),
                'prefix'        => '',
                'displayPrefix' => '',
                'labelIcon'     => 'icon-dairy-products',
                'ver'           => '1.1',
                'fetchJson'     => AGRIOX_ADDON_URL . '/assets/vendors/agriox-icons/agriox-icons-new.js',
                'native'        => 1,
            ),
            'agriox-two' => array(
                'name'          => 'agriox-two',
                'label'         => 'Agriox Icons 02',
                'url'           => '',
                'enqueue'       => array(
                    AGRIOX_ADDON_URL . '/assets/vendors/agriox-icons-2/style.css',
                ),
                'prefix'        => '',
                'displayPrefix' => '',
                'labelIcon'     => 'icon-dairy-products',
                'ver'           => '1.1',
                'fetchJson'     => AGRIOX_ADDON_URL . '/assets/vendors/agriox-icons-2/agriox-icons-2.js',
                'native'        => 1,
            ),
        );
    }


    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'agriox-addon'),
            '<strong>' . esc_html__('Agriox Theme Addon', 'agriox-addon') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'agriox-addon') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'agriox-addon'),
            '<strong>' . esc_html__('Agriox Theme Addon', 'agriox-addon') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'agriox-addon') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'agriox-addon'),
            '<strong>' . esc_html__('Agriox Theme Addon', 'agriox-addon') . '</strong>',
            '<strong>' . esc_html__('PHP', 'agriox-addon') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
}

Agriox_Addon_Extension::instance();
