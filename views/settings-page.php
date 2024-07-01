<div class="wrap">
    <h1>
        <?php echo esc_html(get_admin_page_title()); ?>
    </h1>

    <?php
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'main_options';
    ?>

    <h2 class="nav-tab-wrapper">
        <a href="?page=my_slider_admin&tab=main_options"
           class="nav-tab <?php echo $active_tab === 'main_options' ? 'nav-tab-active' : ''; ?>">Main options</a>
        <a href="?page=my_slider_admin&tab=additional_options"
           class="nav-tab <?php echo $active_tab === 'additional_options' ? 'nav-tab-active' : ''; ?>">Additional
            options</a>
    </h2>

    <form action="options.php" method="POST">
        <?php
        settings_fields('my_slider_group');
        if ($active_tab === 'main_options') {
            do_settings_sections('my_slider_page1');
        } elseif ($active_tab === 'additional_options') {
            do_settings_sections('my_slider_page2');
        }
        submit_button('Save settings');
        ?>
    </form>
</div>