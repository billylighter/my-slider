<?php
$meta = get_post_meta($post->ID);
$my_slider_link_text = (array_key_exists('my_slider_link_text', $meta)) ? $meta['my_slider_link_text'][0] : '';
$my_slider_link_url = (array_key_exists('my_slider_link_url', $meta)) ? $meta['my_slider_link_url'][0] : '';
//var_dump($meta);
?>
<table class="form-table mv-slider-metabox">
    <input type="hidden" name="my_slider_nonce" value="<?php echo wp_create_nonce('my_slider_nonce');?>">
    <tr>
        <th>
            <label for="mv_slider_link_text">Link Text</label>
        </th>
        <td>
            <input
                type="text"
                name="my_slider_link_text"
                id="my_slider_link_text"
                class="regular-text link-text"
                value="<?php echo esc_html($my_slider_link_text);?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="mv_slider_link_url">Link URL</label>
        </th>
        <td>
            <input
                type="url"
                name="my_slider_link_url"
                id="my_slider_link_url"
                class="regular-text link-url"
                value="<?php echo esc_url($my_slider_link_url);?>"
                required
            >
        </td>
    </tr>
</table>