<?php
if (!function_exists('my_slider_get_placeholder_image')) {
    function my_slider_get_placeholder_image()
    {
        return "<img src='" . MY_SLIDER_URL . "assets/images/default.jpg' class='img-fluid wp-post-image' />";
    }
}

if (!function_exists('my_slider_options')) {
    function my_slider_options()
    {
        $show_bullets = isset(MY_Slider_Settings::$options['my_slider_bullets']) && MY_Slider_Settings::$options['my_slider_bullets'] == 1 ? true : false;

        wp_enqueue_script('my_slider_options', MY_SLIDER_URL . 'vendor/flexslider/flexslider.js', array('jquery'), MY_SLIDER_VERSION, true);
        wp_localize_script('my_slider_options', 'SLIDER_OPTIONS', array(
            'controlNav' => $show_bullets
        ));
    }
}