<?php

if (!class_exists('MY_Slider_Settings')) {
    class MY_Slider_Settings
    {
        public static $options;

        public function __construct()
        {
            self::$options = get_option('my_slider_options');
            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init()
        {
            register_setting(
                'my_slider_group',
                'my_slider_options',
                array($this, 'my_slider_validate')
            );
            add_settings_section(
                'my_slider_main_section',
                'How does it works',
                null,
                'my_slider_page1'
            );
            add_settings_section(
                'my_slider_second_section',
                'Other plugin options',
                null,
                'my_slider_page2'
            );
            add_settings_field(
                'my_slider_shortcode',
                'Shortcode',
                array($this, 'my_slider_shortcode_callback'),
                'my_slider_page1',
                'my_slider_main_section'
            );
            add_settings_field(
                'my_slider_title',
                'Slider title',
                array($this, 'my_slider_title_callback'),
                'my_slider_page2',
                'my_slider_second_section'
            );
            add_settings_field(
                'my_slider_bullets',
                'Display bullets',
                array($this, 'my_slider_bullets_callback'),
                'my_slider_page2',
                'my_slider_second_section'
            );
            add_settings_field(
                'my_slider_style',
                'Slider style',
                array($this, 'my_slider_style_callback'),
                'my_slider_page2',
                'my_slider_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    )
                )
            );
        }

        public function my_slider_shortcode_callback()
        {
            ?>
            <span>
               Use shortcode <strong>[my_slider]</strong> to display slider in any page\post\widget
            </span>
            <?php
        }

        public function my_slider_title_callback()
        {
            ?>

            <label for="my_slider_title">
                <input type="text"
                       name="my_slider_options[my_slider_title]"
                       id="my_slider_title"
                       value="<?php echo (isset(self::$options['my_slider_title'])) ? self::$options['my_slider_title'] : ''; ?>">
            </label>

            <?php
        }

        public function my_slider_bullets_callback()
        {
            ?>

            <label for="my_slider_bullets">
                <input type="checkbox"
                       name="my_slider_options[my_slider_bullets]"
                       id="my_slider_bullets"
                       value="1"
                    <?php if (isset(self::$options['my_slider_bullets'])) checked('1', self::$options['my_slider_bullets'], true); ?>
                >
                <i>Whether to display bullets or not</i>
            </label>

            <?php
        }

        public function my_slider_style_callback($args)
        {
            ?>

            <label for="my_slider_style">
                <select name="my_slider_options[my_slider_style]" id="my_slider_style">

                    <?php foreach ($args['items'] as $item) : ?>

                        <option value="<?php echo esc_attr($item); ?>"
                            <?php
                            isset(self::$options['my_slider_style']) ? selected($item, self::$options['my_slider_style'], true) : ''
                            ?>
                        >
                            <?php echo esc_html(ucfirst($item)); ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </label>

            <?php
        }

        public function my_slider_validate($input) : array
        {
            $new_input = array();
            foreach ($input as $key => $value) {
                $new_input[$key] = sanitize_text_field($value);
                switch ($key) {
                    case "my_slider_title":
                        $new_input[$key] = sanitize_text_field($value);
                        if(empty($new_input[$key])){
                            add_settings_error('my_slider_options', 'my_slider_message', ' The title field is must be field!', 'warning');
                        }
                        break;
                    case "my_slider_url":
                        $new_input[$key] = esc_url_raw($value);
                        break;
                    case "my_slider_int":
                        $new_input[$key] = absint($value);
                        break;
                    default:
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                }
            }
            return $new_input;
        }
    }
}