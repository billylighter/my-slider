<?php

if (!class_exists('MY_Slider_Post_Type')) {
    class MY_Slider_Post_Type
    {
        function __construct()
        {
            add_action('init', array($this, 'create_post_type'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_post'));

            add_filter('manage_my-slider_posts_columns', array($this, 'my_slider_cpt_columns'));
            add_action('manage_my-slider_posts_custom_column', array($this, 'my_slider_custom_columns'), 10, 2);
            add_filter('manage_edit-my-slider_sortable_columns', array($this, 'my_slider_sortable_columns'));
        }

        public function create_post_type(): void
        {
            register_post_type('my-slider',
                array(
                    'label' => 'Slider',
                    'description' => 'Sliders',
                    'labels' => array(
                        'name' => 'Sliders',
                        'singular_name' => 'Slider'
                    ),
                    'public' => true,
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => false,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => false,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true,
                    'menu_icon' => 'dashicons-format-gallery',
//                    'register_meta_box_cb' => array($this, 'add_meta_boxes')
                ));
        }

        public function my_slider_sortable_columns($columns)
        {
            $columns['my_slider_link_text'] = 'my_slider_link_text';
            return $columns;
        }

        public function add_meta_boxes(): void
        {
            add_meta_box(
                'my_slider_meta_box',
                'Link Option',
                array($this, 'add_inner_meta_boxes'),
                'my-slider',
                'normal',
                'high'
            );
        }

        public function my_slider_cpt_columns($columns)
        {
            $columns['my_slider_link_text'] = esc_html__('Link Text', 'my-slider');
            $columns['my_slider_link_url'] = esc_html__('Link URL', 'my-slider');
            return $columns;
        }

        public function my_slider_custom_columns($column, $post_id): void
        {
            switch ($column) {
                case 'my_slider_link_text':
                    echo esc_html(get_post_meta($post_id, 'my_slider_link_text', true));
                    break;
                case 'my_slider_link_url':
                    echo esc_html(get_post_meta($post_id, 'my_slider_link_url', true));
                    break;
            }
        }

        public function add_inner_meta_boxes($post): void
        {
            require_once(MY_SLIDER_PATH . 'views/my-slider_metabox.php');
        }

        public function save_post($post_id)
        {
            if (isset($_POST['my_slider_nonce'])) {
                if (!wp_verify_nonce($_POST['my_slider_nonce'], 'my_slider_nonce')) {
                    return;
                }
            }

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (isset($_POST['post_type']) && $_POST['post_type'] === 'my_slider') {
                if (!current_user_can('edit_page', $post_id)) {
                    return;
                } elseif (!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }

            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {
                $old_link_text = get_post_meta($post_id, 'my_slider_link_text', true);
                $new_link_text = sanitize_text_field($_POST['my_slider_link_text']);
                $old_link_url = get_post_meta($post_id, 'my_slider_link_url', true);
                $new_link_url = sanitize_text_field($_POST['my_slider_link_url']);

                update_post_meta($post_id, 'my_slider_link_text', $new_link_text, $old_link_text);
                update_post_meta($post_id, 'my_slider_link_url', $new_link_url, $old_link_url);
//                delete_post_meta($post_id,'my_slider_link_text' );
//                delete_post_meta($post_id,'my_slider_link_url' );
            }
        }


    }
}