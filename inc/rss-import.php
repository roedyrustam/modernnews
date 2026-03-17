<?php
/**
 * Modern News RSS Import Feature
 */

// 1. Register Settings
function modernnews_rss_settings_init()
{
    register_setting('modernnews_rss', 'modernnews_rss_options');

    add_settings_section(
        'modernnews_rss_section_main',
        'RSS Feed Configuration',
        'modernnews_rss_section_main_cb',
        'modernnews_rss'
    );

    add_settings_field(
        'rss_feed_urls',
        'Feed URLs (One per line)',
        'modernnews_rss_field_urls_cb',
        'modernnews_rss',
        'modernnews_rss_section_main',
        ['label_for' => 'rss_feed_urls']
    );

    add_settings_field(
        'rss_import_category',
        'Import Category',
        'modernnews_rss_field_category_cb',
        'modernnews_rss',
        'modernnews_rss_section_main',
        ['label_for' => 'rss_import_category']
    );

    add_settings_field(
        'rss_post_status',
        'Default Post Status',
        'modernnews_rss_field_status_cb',
        'modernnews_rss',
        'modernnews_rss_section_main',
        ['label_for' => 'rss_post_status']
    );
}
add_action('admin_init', 'modernnews_rss_settings_init');

// 2. Section Callback
function modernnews_rss_section_main_cb($args)
{
    echo '<p>Configure your external RSS feeds here. The system will automatically fetch news from these sources.</p>';
}

// 3. Field Callbacks
function modernnews_rss_field_urls_cb($args)
{
    $options = get_option('modernnews_rss_options');
    $val = isset($options['rss_feed_urls']) ? $options['rss_feed_urls'] : '';
    echo '<textarea name="modernnews_rss_options[rss_feed_urls]" rows="10" cols="50" class="large-text code" placeholder="https://example.com/feed">' . esc_textarea($val) . '</textarea>';
    echo '<p class="description">Enter one RSS feed URL per line.</p>';
}

function modernnews_rss_field_category_cb($args)
{
    $options = get_option('modernnews_rss_options');
    $val = isset($options['rss_import_category']) ? $options['rss_import_category'] : 1;

    $args = array(
        'name' => 'modernnews_rss_options[rss_import_category]',
        'id' => 'rss_import_category',
        'selected' => $val,
        'class' => 'regular-text',
        'show_option_none' => 'Select Category',
        'hide_empty' => 0,
    );
    wp_dropdown_categories($args);
}

function modernnews_rss_field_status_cb($args)
{
    $options = get_option('modernnews_rss_options');
    $val = isset($options['rss_post_status']) ? $options['rss_post_status'] : 'draft';
    ?>
    <select name="modernnews_rss_options[rss_post_status]">
        <option value="draft" <?php selected($val, 'draft'); ?>>Draft</option>
        <option value="publish" <?php selected($val, 'publish'); ?>>Publish</option>
        <option value="pending" <?php selected($val, 'pending'); ?>>Pending Review</option>
    </select>
    <?php
}

// 4. Add Admin Menu
function modernnews_rss_options_page()
{
    add_submenu_page(
        'modernnews_theme_options',
        'RSS Import',
        'RSS Import',
        'manage_options',
        'modernnews_rss',
        'modernnews_rss_options_page_html'
    );
}
add_action('admin_menu', 'modernnews_rss_options_page');

// 5. Render Page
function modernnews_rss_options_page_html()
{
    if (!current_user_can('manage_options'))
        return;
    ?>
    <div class="wrap">
        <h1>
            <?php echo esc_html__('RSS Import', 'modernnews'); ?>
        </h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('modernnews_rss');
            do_settings_sections('modernnews_rss');
            submit_button('Save RSS Settings');
            ?>
        </form>

        <hr>

        <h2>Manual Import</h2>
        <p>Run the importer manually to fetch latest news immediately.</p>
        <form method="post" action="">
            <?php wp_nonce_field('modernnews_rss_manual_import', 'rss_import_nonce'); ?>
            <input type="hidden" name="run_rss_import" value="1">
            <?php submit_button('Run Import Now', 'secondary'); ?>
        </form>
    </div>
    <?php

    // Handle Manual Import
    if (isset($_POST['run_rss_import']) && check_admin_referer('modernnews_rss_manual_import', 'rss_import_nonce')) {
        modernnews_run_rss_import();
        echo '<div class="updated"><p>Import process completed.</p></div>';
    }
}

// 6. Import Logic
function modernnews_run_rss_import()
{
    $options = get_option('modernnews_rss_options');
    $urls_text = isset($options['rss_feed_urls']) ? $options['rss_feed_urls'] : '';
    $category = isset($options['rss_import_category']) ? $options['rss_import_category'] : 1;
    $status = isset($options['rss_post_status']) ? $options['rss_post_status'] : 'draft';

    if (empty($urls_text))
        return;

    $urls = array_filter(array_map('trim', explode("\n", $urls_text)));
    if (empty($urls))
        return;

    include_once(ABSPATH . WPINC . '/feed.php');

    foreach ($urls as $url) {
        if (empty($url))
            continue;

        $rss = fetch_feed($url);
        if (is_wp_error($rss))
            continue;

        $maxitems = $rss->get_item_quantity(5); // Fetch latest 5 items per feed
        $rss_items = $rss->get_items(0, $maxitems);

        if ($maxitems == 0)
            continue;

        foreach ($rss_items as $item) {
            $title = $item->get_title();
            $link = $item->get_permalink();
            $desc = $item->get_description();
            $date = $item->get_date('Y-m-d H:i:s');

            // Check duplicate by title or link meta
            $existing = new WP_Query(array(
                'meta_key' => '_modernnews_rss_source_url',
                'meta_value' => $link,
                'post_type' => 'post',
                'post_status' => 'any',
                'posts_per_page' => 1
            ));

            if ($existing->have_posts())
                continue;

            // Insert Post
            $post_data = array(
                'post_title' => wp_strip_all_tags($title),
                'post_content' => $desc . '<br><br><a href="' . esc_url($link) . '" target="_blank" rel="nofollow">Read full story at source</a>',
                'post_status' => $status,
                'post_type' => 'post',
                'post_author' => get_current_user_id() ? get_current_user_id() : 1,
                'post_category' => array($category),
                'post_date' => $date,
            );

            $post_id = wp_insert_post($post_data);

            if ($post_id) {
                update_post_meta($post_id, '_modernnews_rss_source_url', $link);
                update_post_meta($post_id, '_modernnews_rss_source_name', $rss->get_title());

                // Try to find image in enclosure
                if ($enclosure = $item->get_enclosure()) {
                    // Logic to upload image from URL to Media Library would go here
                    // For now, we rely on duplicate check and simple content import
                }
            }
        }
    }
}

// 7. Schedule Cron
function modernnews_rss_schedule_cron()
{
    if (!wp_next_scheduled('modernnews_rss_cron_event')) {
        wp_schedule_event(time(), 'hourly', 'modernnews_rss_cron_event');
    }
}
add_action('init', 'modernnews_rss_schedule_cron');
add_action('modernnews_rss_cron_event', 'modernnews_run_rss_import');
