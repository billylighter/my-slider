<?php

/**
 * Plugin Name: My Slider
 * Plugin URI: https://github.com
 * Description: Test version of slider for wordpress
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Myr S
 * Author URI: https://github.com
 * License: GPL v2 or later
 * Licence URI: https://github.com
 * Text Domain: my_slider
 * Domain Path: /languages
 *
 */

/*
 * TODO: NEED TO ADD LANGUAGES STRING SUPPORT i18
 */

if (!defined('ABSPATH')) {
    echo 'Fuck you.';
    exit;
}

/*
 * Checking if class is available start
 */

if (!class_exists('MY_SLIDER')) {
    class MY_SLIDER
    {
        function __construct()
        {
            $this->define_constants();

            $this->load_text_domain();

            require_once(MY_SLIDER_PATH . 'functions/functions.php');

            add_action('admin_menu', array($this, 'add_menu'));

            require_once(MY_SLIDER_PATH . 'post-types/class.my-slider-cpt.php');
            $MY_Slider_Post_Type = new MY_Slider_Post_Type();

            require_once(MY_SLIDER_PATH . 'class.my-slider-settings.php');
            $MY_Slider_Settings = new MY_Slider_Settings();

            require_once(MY_SLIDER_PATH . 'shortcodes/class.my-slider-shortcode.php');
            $MY_Slider_Shortcode = new MY_Slider_Shortcode();

            add_action('wp_enqueue_scripts', array($this, 'register_scripts'), 999);
            add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'), 999);
        }

        public function define_constants()
        {
            define('MY_SLIDER_PATH', plugin_dir_path(__FILE__));
            define('MY_SLIDER_URL', plugin_dir_url(__FILE__));
            define('MY_SLIDER_VERSION', '1.0,0');
        }

        public static function activate()
        {
            /*
             * Recommended step for flushing permalinks if plugin need to create new Post type.
             */
            update_option('rewrite_rules', '');
        }

        public static function deactivate()
        {
            /*
             * Flushing rewrite rules when plugin is deactivating.
             */
            flush_rewrite_rules();
            unregister_post_type('my-slider');
        }

        public static function uninstall()
        {
            delete_option( 'my_slider_options' );

            $posts = get_posts(
                array(
                    'post_type' => 'my-slider',
                    'number_posts'  => -1,
                    'post_status'   => 'any'
                )
            );

            foreach( $posts as $post ){
                wp_delete_post( $post->ID, true );
            }
        }

        public function load_text_domain(){
            load_plugin_textdomain(
                'my_slider',
                false,
                dirname(plugin_basename(__FILE__)) . '/languages/'
            );
        }

        public function add_menu(): void
        {
            /*
             * Default position for settings page in WordPress dashboard
             */
            add_menu_page(
                'My Slider Options',
                'My Slider',
                'manage_options',
                'my_slider_admin',
                array($this, 'my_slider_settings_page'),
                'dashicons-images-alt2'
            );

            add_submenu_page(
                'my_slider_admin',
                'Manage Slides',
                'Manage Slides',
                'manage_options',
                'edit.php?post_type=my-slider',
                null,
                null
            );

            add_submenu_page(
                'my_slider_admin',
                'Add new Slide',
                'Add new Slide',
                'manage_options',
                'post-new.php?post_type=my-slider',
                null,
                null
            );

            /*
             * Also can use add_plugins_page() to adding option page in Plugins section
             */

            /*
             * Also can use add_theme_page() to adding option page in Appearance section
             */

            /*
             * Also can use add_options_page() to adding option page in Settings section
             */

        }

        public function my_slider_settings_page()
        {
            if (!current_user_can('manage_options')) {
                return;
            }
            if (isset($_GET['settings-updated'])) {
                add_settings_error('my_slider_options', 'my_slider_message', ' Settings saved', 'success');
            }
            settings_errors('my_slider_options');
            require(MY_SLIDER_PATH . 'views/settings-page.php');
        }

        public function register_scripts()
        {
            wp_register_style('my_slider_main_css', MY_SLIDER_URL . 'vendor/flexslider/flexslider.css', array(), MY_SLIDER_VERSION, 'all');
            wp_register_style('my_slider_custom_css', MY_SLIDER_URL . 'assets/css/frontend.css', array(), MY_SLIDER_VERSION, 'all');
            wp_register_script('my_slider_main_jq', MY_SLIDER_URL . 'vendor/flexslider/jquery.flexslider-min.js', array('jquery'), MY_SLIDER_VERSION, true);
            wp_register_script('my_slider_options', MY_SLIDER_URL . 'vendor/flexslider/flexslider.js', array('jquery'), MY_SLIDER_VERSION, true);
        }

        public function register_admin_scripts()
        {
            global $typenow;
            if ($typenow == 'my_slider') {
                wp_enqueue_style('my_slider_admin_css', MY_SLIDER_URL . 'assets/css/admin.css', array(), MY_SLIDER_VERSION, 'all');
            }
        }
    }
}

if (class_exists('MY_SLIDER')) {
    register_activation_hook(__FILE__, array('MY_SLIDER', 'activate'));
    register_deactivation_hook(__FILE__, array('MY_SLIDER', 'deactivate'));
    register_uninstall_hook(__FILE__, array('MY_SLIDER', 'uninstall'));
    $my_slider = new MY_SLIDER();
}

/*
 * Checking if class is available end
 */

