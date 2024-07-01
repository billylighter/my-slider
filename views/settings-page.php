<div class="wrap">
    <h1>
        <?php echo esc_html(get_admin_page_title());?>
    </h1>
    <form action="options.php" method="POST">
        <?php
        settings_fields('my_slider_group');
        do_settings_sections('my_slider_page1');
        do_settings_sections('my_slider_page2');
        submit_button('Save settings');
        ?>
    </form>
</div>