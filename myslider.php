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
 * Text Domain: myslider-myrs
 * Domain Path: /languages
 *
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

            add_action('admin_menu', array($this, 'add_menu'));

            require_once(MY_SLIDER_PATH . 'post-types/class.my-slider-cpt.php');
            $MY_Slider_Post_Type = new MY_Slider_Post_Type();

            require_once(MY_SLIDER_PATH . 'class.my-slider-settings.php');
            $MY_Slider_Settings = new MY_Slider_Settings();
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
        public function my_slider_settings_page(){
            if(!current_user_can('manage_options')){
                return;
            }
            if(isset($_GET['settings-updated'])){
                add_settings_error('my_slider_options', 'my_slider_message', ' Settings saved', 'success');
            }
            settings_errors('my_slider_options');
           require(MY_SLIDER_PATH . 'views/settings-page.php');
        }
    }
}

if (class_exists('MY_SLIDER')) {
    register_activation_hook(__FILE__, array('MY_SLIDER', 'activate'));
    register_uninstall_hook(__FILE__, array('MY_SLIDER', 'uninstall'));
    $my_slider = new MY_SLIDER();
}

/*
 * Checking if class is available end
 */

