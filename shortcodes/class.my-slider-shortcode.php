<?php

if (!class_exists('MY_Slider_Shortcode')) {
    class MY_Slider_Shortcode
    {
        public function __construct(){
            add_shortcode( 'my_slider', array( $this, 'add_shortcode' ) );
        }

        public function add_shortcode( $atts = array(), $content = null, $tag = '' ){

            $atts = array_change_key_case( (array) $atts, CASE_LOWER );

            extract( shortcode_atts(
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }

            ob_start();
            require(MY_SLIDER_PATH . 'views/my_slider_shortcode.php');
            wp_enqueue_style('my_slider_main_css');
            wp_enqueue_style('my_slider_custom_css');
            wp_enqueue_script('my_slider_main_jq');
            wp_enqueue_script('my_slider_options');
            my_slider_options();
            return ob_get_clean();
        }
    }
}