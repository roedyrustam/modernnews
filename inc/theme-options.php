<?php
/**
 * Modern News Theme Options
 */

// 1. Register Settings
if (!defined('ABSPATH')) {
    exit;
}

function modernnews_theme_settings_init()
{
    // Check if Settings API is available
    if (!function_exists('is_admin') || !is_admin() || !function_exists('add_settings_section') || !function_exists('register_setting') || !function_exists('add_settings_field') || !function_exists('get_option')) {
        return;
    }

    register_setting('modernnews_theme_options', 'modernnews_theme_options');

    // --- Section: API Settings ---
    add_settings_section('modernnews_theme_section_api', 'API Settings', 'modernnews_theme_section_api_cb', 'modernnews_theme_options');
    add_settings_field('google_maps_api_key', 'Google Maps API Key', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_api', ['label_for' => 'google_maps_api_key']);
    add_settings_field('weather_api_key', 'OpenWeatherMap API Key', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_api', ['label_for' => 'weather_api_key']);
    add_settings_field('recaptcha_site_key', 'ReCaptcha Site Key', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_api', ['label_for' => 'recaptcha_site_key']);
    add_settings_field('recaptcha_secret_key', 'ReCaptcha Secret Key', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_api', ['label_for' => 'recaptcha_secret_key']);

    // --- Section: Analytics ---
    add_settings_section('modernnews_theme_section_analytics', 'Analytics & Scripts', 'modernnews_theme_section_analytics_cb', 'modernnews_theme_options');
    add_settings_field('header_scripts', 'Header Scripts', 'modernnews_theme_field_textarea_code_cb', 'modernnews_theme_options', 'modernnews_theme_section_analytics', ['label_for' => 'header_scripts']);
    add_settings_field('footer_scripts', 'Footer Scripts', 'modernnews_theme_field_textarea_code_cb', 'modernnews_theme_options', 'modernnews_theme_section_analytics', ['label_for' => 'footer_scripts']);

    // --- Section: Feature Management ---
    add_settings_section('modernnews_theme_section_features', 'Feature Management', 'modernnews_theme_section_features_cb', 'modernnews_theme_options');
    add_settings_field('enable_live_streaming', 'Enable Live Streaming Button', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_features', ['label_for' => 'enable_live_streaming']);
    add_settings_field('live_streaming_url', 'Live Streaming Page URL', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_features', ['label_for' => 'live_streaming_url']);
    add_settings_field('enable_citizen_news', 'Enable Citizen News Button', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_features', ['label_for' => 'enable_citizen_news']);
    add_settings_field('citizen_news_url', 'Citizen News Page URL', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_features', ['label_for' => 'citizen_news_url']);
    add_settings_field('subscribe_url', 'Subscribe Button URL', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_features', ['label_for' => 'subscribe_url']);

    // --- Section: Social Media ---
    add_settings_section('modernnews_theme_section_social', 'Social Media Links', 'modernnews_theme_section_social_cb', 'modernnews_theme_options');
    $socials = ['facebook', 'twitter', 'instagram', 'youtube', 'tiktok'];
    foreach ($socials as $social) {
        add_settings_field('social_' . $social, ucfirst($social) . ' URL', 'modernnews_theme_field_social_cb', 'modernnews_theme_options', 'modernnews_theme_section_social', ['label_for' => 'social_' . $social]);
    }

    // --- Section: Contact Info ---
    add_settings_section('modernnews_theme_section_contact', 'Contact Information', 'modernnews_theme_section_contact_cb', 'modernnews_theme_options');
    add_settings_field('contact_email', 'Email Address', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_contact', ['label_for' => 'contact_email']);
    add_settings_field('contact_phone', 'Phone Number', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_contact', ['label_for' => 'contact_phone']);
    add_settings_field('contact_address', 'Office Address', 'modernnews_theme_field_textarea_cb', 'modernnews_theme_options', 'modernnews_theme_section_contact', ['label_for' => 'contact_address']);

    // --- Section: Footer & Legal ---
    add_settings_section('modernnews_theme_section_footer', 'Footer & Legal Settings', 'modernnews_theme_section_footer_cb', 'modernnews_theme_options');
    add_settings_field('footer_logo_url', 'Footer Logo (URL)', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_footer', ['label_for' => 'footer_logo_url']);
    add_settings_field('footer_about', 'About Us Text', 'modernnews_theme_field_textarea_cb', 'modernnews_theme_options', 'modernnews_theme_section_footer', ['label_for' => 'footer_about']);
    add_settings_field('footer_copyright', 'Copyright Text', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_footer', ['label_for' => 'footer_copyright']);
    add_settings_field('privacy_policy_url', 'Privacy Policy URL', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_footer', ['label_for' => 'privacy_policy_url']);
    add_settings_field('terms_url', 'Terms of Service URL', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_footer', ['label_for' => 'terms_url']);

    // --- Section: General ---
    add_settings_section('modernnews_theme_section_general', 'General Settings', 'modernnews_theme_section_general_cb', 'modernnews_theme_options');
    add_settings_field('header_logo_url', 'Header Logo (URL)', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_general', ['label_for' => 'header_logo_url']);
    add_settings_field('sticky_header', 'Enable Sticky Header', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_general', ['label_for' => 'sticky_header']);

    // --- Section: Visual Style ---
    add_settings_section('modernnews_theme_section_style', 'Visual Style', 'modernnews_theme_section_style_cb', 'modernnews_theme_options');
    add_settings_field('primary_color', 'Primary Color', 'modernnews_theme_field_color_cb', 'modernnews_theme_options', 'modernnews_theme_section_style', ['label_for' => 'primary_color']);
    add_settings_field('heading_font', 'Heading Font', 'modernnews_theme_field_font_cb', 'modernnews_theme_options', 'modernnews_theme_section_style', ['label_for' => 'heading_font']);
    add_settings_field('body_font', 'Body Font', 'modernnews_theme_field_font_cb', 'modernnews_theme_options', 'modernnews_theme_section_style', ['label_for' => 'body_font']);

    // --- Section: News Ticker ---
    add_settings_section('modernnews_theme_section_ticker', 'Breaking News Ticker', 'modernnews_theme_section_ticker_cb', 'modernnews_theme_options');
    add_settings_field('ticker_enable', 'Enable Ticker', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_ticker', ['label_for' => 'ticker_enable']);
    add_settings_field('ticker_title', 'Ticker Title', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_ticker', ['label_for' => 'ticker_title']);
    add_settings_field('ticker_category', 'Filter by Category', 'modernnews_theme_field_category_cb', 'modernnews_theme_options', 'modernnews_theme_section_ticker', ['label_for' => 'ticker_category']);
    add_settings_field('ticker_count', 'Number of Posts', 'modernnews_theme_field_number_cb', 'modernnews_theme_options', 'modernnews_theme_section_ticker', ['label_for' => 'ticker_count']);

    // --- Section: SEO Settings ---
    add_settings_section('modernnews_theme_section_seo', 'SEO & OpenGraph', 'modernnews_theme_section_seo_cb', 'modernnews_theme_options');
    add_settings_field('default_og_image', 'Default OG Image (URL)', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_seo', ['label_for' => 'default_og_image']);

    // --- Section: Mobile Layout ---
    add_settings_section('modernnews_theme_section_mobile', 'Mobile Layout Settings', 'modernnews_theme_section_mobile_cb', 'modernnews_theme_options');
    add_settings_field('mobile_compact_mode', 'Enable Compact Header & Nav', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_mobile', ['label_for' => 'mobile_compact_mode']);

    // --- Section: Trending Settings ---
    add_settings_section('modernnews_theme_section_trending', 'Trending Settings', 'modernnews_theme_section_trending_cb', 'modernnews_theme_options');
    add_settings_field('trending_category_id', 'Trending Category', 'modernnews_theme_field_category_cb', 'modernnews_theme_options', 'modernnews_theme_section_trending', ['label_for' => 'trending_category_id']);

    // --- Section: Single Post Settings ---
    add_settings_section('modernnews_theme_section_single', 'Single Post Settings', 'modernnews_theme_section_single_cb', 'modernnews_theme_options');
    add_settings_field('single_show_progress_bar', 'Show Reading Progress Bar', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_single', ['label_for' => 'single_show_progress_bar']);
    add_settings_field('single_show_author_meta', 'Show Author Meta', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_single', ['label_for' => 'single_show_author_meta']);
    add_settings_field('single_show_reading_time', 'Show Estimated Reading Time', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_single', ['label_for' => 'single_show_reading_time']);
    add_settings_field('single_show_related_posts', 'Show Related Posts', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_single', ['label_for' => 'single_show_related_posts']);
    add_settings_field('single_related_posts_count', 'Related Posts Count', 'modernnews_theme_field_number_cb', 'modernnews_theme_options', 'modernnews_theme_section_single', ['label_for' => 'single_related_posts_count']);

    // --- Section: Archive Settings ---
    add_settings_section('modernnews_theme_section_archive', 'Archive Settings', 'modernnews_theme_section_archive_cb', 'modernnews_theme_options');
    add_settings_field('archive_layout', 'Archive Layout', 'modernnews_theme_field_select_layout_cb', 'modernnews_theme_options', 'modernnews_theme_section_archive', ['label_for' => 'archive_layout']);
    add_settings_field('archive_show_excerpt', 'Show Post Excerpt', 'modernnews_theme_field_checkbox_cb', 'modernnews_theme_options', 'modernnews_theme_section_archive', ['label_for' => 'archive_show_excerpt']);

    // --- Section: Update Settings ---
    add_settings_section('modernnews_theme_section_update', 'GitHub Update Settings', 'modernnews_theme_section_update_cb', 'modernnews_theme_options');
    add_settings_field('github_repo', 'GitHub Repository', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_update', ['label_for' => 'github_repo']);
    add_settings_field('github_token', 'GitHub Access Token', 'modernnews_theme_field_text_cb', 'modernnews_theme_options', 'modernnews_theme_section_update', ['label_for' => 'github_token']);


}
add_action('admin_init', 'modernnews_theme_settings_init');

/**
 * Enqueue Admin Scripts & Styles
 */
function modernnews_admin_scripts($hook)
{
    // Defensive check: Ensure we are in admin and required functions exist
    if (!function_exists('is_admin') || !is_admin() || !function_exists('wp_enqueue_style') || !function_exists('wp_enqueue_script') || !function_exists('get_option') || !function_exists('get_template_directory_uri')) {
        return;
    }

    if ($hook != 'toplevel_page_modernnews_theme_options') {
        return;
    }

    // Enqueue Google Fonts (Inter) for modern typography
    wp_enqueue_style('modernnews-admin-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', array(), null);

    $css_ver = file_exists(get_template_directory() . '/assets/css/admin.css') ? filemtime(get_template_directory() . '/assets/css/admin.css') : '1.0.0';
    $js_ver = file_exists(get_template_directory() . '/assets/js/admin.js') ? filemtime(get_template_directory() . '/assets/js/admin.js') : '1.0.0';

    wp_enqueue_style('modernnews-admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), $css_ver);
    wp_enqueue_style('wp-color-picker'); // Enqueue Color Picker
    wp_enqueue_script('modernnews-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array('jquery', 'wp-color-picker'), $js_ver, true);
}
add_action('admin_enqueue_scripts', 'modernnews_admin_scripts');

// 2. Callbacks
function modernnews_theme_section_social_cb()
{
    echo '<p class="description">Enter your social media profile URLs.</p>';
}
function modernnews_theme_section_api_cb()
{
    echo '<p class="description">Configure external API keys for widget integrations.</p>';
}
function modernnews_theme_section_analytics_cb()
{
    echo '<p class="description">Insert tracking codes (Google Analytics, GTM) or custom JavaScript here.</p>';
}
function modernnews_theme_section_features_cb()
{
    echo '<p class="description">Toggle special theme features and manage their links.</p>';
}
function modernnews_theme_section_contact_cb()
{
    echo '<p class="description">Details for the Contact page and Header/Footer.</p>';
}
function modernnews_theme_section_footer_cb()
{
    echo '<p class="description">Customize your footer content.</p>';
}
function modernnews_theme_section_general_cb()
{
    echo '<p class="description">General styling and behavior options.</p>';
}
function modernnews_theme_section_style_cb()
{
    echo '<p class="description">Customize the visual appearance of your theme.</p>';
}
function modernnews_theme_section_ticker_cb()
{
    echo '<p class="description">Configure the Breaking News ticker in the header.</p>';
}
function modernnews_theme_section_seo_cb()
{
    echo '<p class="description">Global settings for SEO and social sharing fallbacks.</p>';
}
function modernnews_theme_section_mobile_cb()
{
    echo '<p class="description">Manage how the site appears on mobile devices.</p>';
}
function modernnews_theme_section_trending_cb()
{
    echo '<p class="description">Select the category to use for trending links.</p>';
}
function modernnews_theme_section_single_cb()
{
    echo '<p class="description">Control elements visible on single article pages.</p>';
}
function modernnews_theme_section_archive_cb()
{
    echo '<p class="description">Global settings for category and tag archive pages.</p>';
}
function modernnews_theme_section_update_cb()
{
    echo '<p class="description">Configure GitHub repository for automatic theme updates.</p>';
}

// Field Callbacks
function modernnews_theme_field_social_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<input type="url" name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="regular-text" placeholder="https://...">';
}
function modernnews_theme_field_text_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<input type="text" name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="regular-text">';
}
function modernnews_theme_field_textarea_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<textarea name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']" rows="5" cols="50" class="large-text">' . esc_textarea($val) . '</textarea>';
}
function modernnews_theme_field_textarea_code_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<textarea name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']" rows="8" cols="50" class="large-text code" placeholder="<script>...</script>">' . esc_textarea($val) . '</textarea>';
    echo '<p class="description">Code will be output exactly as entered.</p>';
}
function modernnews_theme_field_checkbox_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : false;
    echo '<input type="checkbox" name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']" value="1" ' . checked(1, $val, false) . '>';
}
function modernnews_theme_field_number_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '5';
    echo '<input type="number" name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="small-text" min="1" max="20">';
}
function modernnews_theme_field_category_cb($args)
{
    if (!function_exists('get_option') || !function_exists('get_categories')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    $cats = get_categories();
    echo '<select name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']">';
    echo '<option value="">-- All Categories --</option>';
    foreach ($cats as $cat) {
        echo '<option value="' . esc_attr($cat->term_id) . '" ' . selected($val, $cat->term_id, false) . '>' . esc_html($cat->name) . '</option>';
    }
    echo '</select>';
}
function modernnews_theme_field_color_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '#168098';
    echo '<input type="text" name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="modernnews-color-picker" data-default-color="#168098">';
}
function modernnews_theme_field_font_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : 'Epilogue';
    $fonts = ['Epilogue', 'Inter', 'Noto Sans', 'Lora', 'Roboto', 'Open Sans', 'Merriweather'];
    echo '<select name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']">';
    foreach ($fonts as $font) {
        echo '<option value="' . esc_attr($font) . '" ' . selected($val, $font, false) . '>' . esc_html($font) . '</option>';
    }
    echo '</select>';
}
function modernnews_theme_field_select_layout_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : 'list';
    echo '<select name="modernnews_theme_options[' . esc_attr($args['label_for']) . ']">';
    echo '<option value="list" ' . selected($val, 'list', false) . '>List View</option>';
    echo '<option value="grid" ' . selected($val, 'grid', false) . '>Grid View</option>';
    echo '</select>';
}

// 3. Admin Menu
function modernnews_theme_options_page()
{
    if (!function_exists('add_menu_page')) {
        return;
    }
    add_menu_page('Modern News', 'Modern News', 'manage_options', 'modernnews_theme_options', 'modernnews_theme_options_page_html', 'dashicons-layout', 2);
    add_submenu_page('modernnews_theme_options', 'General Settings', 'General Settings', 'manage_options', 'modernnews_theme_options', 'modernnews_theme_options_page_html');
}
add_action('admin_menu', 'modernnews_theme_options_page');

// 4. Render Page (Tabbed Interface)
function modernnews_theme_options_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Defensive check: Ensure Settings API functions are available
    if (!function_exists('settings_fields') || !function_exists('do_settings_sections')) {
        return;
    }
    ?>
    <div class="wrap modernnews-admin-wrap">
        <?php settings_errors(); ?>
        <div class="modernnews-admin-header">
            <h1><?php echo esc_html__('Modern News Settings', 'modernnews'); ?></h1>
            <span class="version">v1.3.0</span>
        </div>

        <div class="modernnews-admin-main">
            <div class="modernnews-admin-sidebar">
                <div class="modernnews-admin-tabs">
                    <button type="button" class="modernnews-tab-link active" data-tab="general"><span class="dashicons dashicons-admin-generic"></span> General</button>
                    <button type="button" class="modernnews-tab-link" data-tab="style"><span class="dashicons dashicons-admin-appearance"></span> Style</button>
                    <button type="button" class="modernnews-tab-link" data-tab="seo"><span class="dashicons dashicons-search"></span> SEO</button>
                    <button type="button" class="modernnews-tab-link" data-tab="single"><span class="dashicons dashicons-media-text"></span> Single Post</button>
                    <button type="button" class="modernnews-tab-link" data-tab="archive"><span class="dashicons dashicons-layout"></span> Archive</button>
                    <button type="button" class="modernnews-tab-link" data-tab="mobile"><span class="dashicons dashicons-smartphone"></span> Mobile</button>
                    <button type="button" class="modernnews-tab-link" data-tab="trending"><span class="dashicons dashicons-chart-line"></span> Trending</button>
                    <button type="button" class="modernnews-tab-link" data-tab="ads"><span class="dashicons dashicons-megaphone"></span> Ads</button>
                    <button type="button" class="modernnews-tab-link" data-tab="ticker"><span class="dashicons dashicons-sos"></span> Ticker</button>
                    <button type="button" class="modernnews-tab-link" data-tab="features"><span class="dashicons dashicons-star-filled"></span> Features</button>
                    <button type="button" class="modernnews-tab-link" data-tab="social"><span class="dashicons dashicons-share"></span> Social</button>
                    <button type="button" class="modernnews-tab-link" data-tab="contact"><span class="dashicons dashicons-email"></span> Contact</button>
                    <button type="button" class="modernnews-tab-link" data-tab="footer"><span class="dashicons dashicons-editor-insertmore"></span> Footer</button>
                    <button type="button" class="modernnews-tab-link" data-tab="api"><span class="dashicons dashicons-rest-api"></span> API</button>
                    <button type="button" class="modernnews-tab-link" data-tab="analytics"><span class="dashicons dashicons-chart-area"></span> Analytics</button>
                    <button type="button" class="modernnews-tab-link" data-tab="update"><span class="dashicons dashicons-update"></span> Update</button>
                </div>
            </div>

            <div class="modernnews-admin-content">

        <!-- Main Settings Form -->
        <form action="options.php" method="post" id="modernnews-theme-form">
            <?php settings_fields('modernnews_theme_options'); ?>

            <!-- General Tab -->
            <div id="general" class="modernnews-tab-content active">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_general'); ?>
            </div>

            <!-- Visual Style Tab -->
            <div id="style" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_style'); ?>
            </div>

            <!-- SEO Tab -->
            <div id="seo" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_seo'); ?>
            </div>

            <!-- Single Post Tab -->
            <div id="single" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_single'); ?>
            </div>

            <!-- Archive Layout Tab -->
            <div id="archive" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_archive'); ?>
            </div>

            <!-- Mobile Layout Tab -->
            <div id="mobile" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_mobile'); ?>
            </div>

            <!-- Trending Tab -->
            <div id="trending" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_trending'); ?>
            </div>

            <!-- News Ticker Tab -->
            <div id="ticker" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_ticker'); ?>
            </div>

            <!-- Features Tab -->
            <div id="features" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_features'); ?>
            </div>

            <!-- Social Media Tab -->
            <div id="social" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_social'); ?>
            </div>

            <!-- Contact Tab -->
            <div id="contact" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_contact'); ?>
            </div>

            <!-- Footer Tab -->
            <div id="footer" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_footer'); ?>
            </div>

            <!-- API Tab -->
            <div id="api" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_api'); ?>
            </div>

            <!-- Analytics Tab -->
            <div id="analytics" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_analytics'); ?>
            </div>

            <!-- Update Tab -->
            <div id="update" class="modernnews-tab-content">
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_update'); ?>
            </div>
        </form>

        <!-- Ads Manager Tab (Separate Form) -->
        <div id="ads" class="modernnews-tab-content">
            <form action="options.php" method="post">
                <?php settings_fields('modernnews_ads'); ?>
                <?php do_settings_sections('modernnews_ads'); ?>
                <?php submit_button('Save Ad Settings'); ?>
            </form>
        </div>

        <!-- SEO Tab -->
        <div id="seo" class="modernnews-tab-content">
            <form action="options.php" method="post">
                <?php settings_fields('modernnews_theme_options'); ?>
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_seo'); ?>
                <?php submit_button('Save SEO Settings'); ?>
            </form>
        </div>

        <!-- Single Post Tab -->
        <div id="single" class="modernnews-tab-content">
            <form action="options.php" method="post">
                <?php settings_fields('modernnews_theme_options'); ?>
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_single'); ?>
                <?php submit_button('Save Single Post Settings'); ?>
            </form>
        </div>

        <!-- Archive Layout Tab -->
        <div id="archive" class="modernnews-tab-content">
            <form action="options.php" method="post">
                <?php settings_fields('modernnews_theme_options'); ?>
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_archive'); ?>
                <?php submit_button('Save Archive Settings'); ?>
            </form>
        </div>

        <!-- Mobile Layout Tab -->
        <div id="mobile" class="modernnews-tab-content">
            <form action="options.php" method="post">
                <?php settings_fields('modernnews_theme_options'); ?>
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_mobile'); ?>
                <?php submit_button('Save Mobile Settings'); ?>
            </form>
        </div>

        <!-- Trending Tab -->
        <div id="trending" class="modernnews-tab-content">
            <form action="options.php" method="post">
                <?php settings_fields('modernnews_theme_options'); ?>
                <?php modernnews_do_settings_section('modernnews_theme_options', 'modernnews_theme_section_trending'); ?>
                <?php submit_button('Save Trending Settings'); ?>
            </form>
        </div>

        </div>
    </div>

    <div class="modernnews-admin-save-bar">
        <div class="save-bar-info">
            <span class="dashicons dashicons-info"></span>
            <p><?php echo esc_html__('Remember to save your changes after modifying settings.', 'modernnews'); ?></p>
        </div>
        <div class="save-bar-actions">
            <button type="submit" form="modernnews-theme-form" class="button button-primary button-large"><?php echo esc_html__('Save Theme Settings', 'modernnews'); ?></button>
        </div>
    </div>
            </div>
        </div>

        <div class="modernnews-admin-save-bar">
            <div class="save-bar-info">
                <span class="dashicons dashicons-info"></span>
                <p><?php echo esc_html__('Remember to save your changes after modifying settings.', 'modernnews'); ?></p>
            </div>
            <div class="save-bar-actions">
                <button type="submit" form="modernnews-options-form" class="button button-primary button-large"><?php echo esc_html__('Save Theme Settings', 'modernnews'); ?></button>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Custom Helper to render a specific settings section
 */
function modernnews_do_settings_section($page, $section_id)
{
    global $wp_settings_sections, $wp_settings_fields;

    if (!isset($wp_settings_sections[$page][$section_id]))
        return;

    $section = $wp_settings_sections[$page][$section_id];

    if ($section['title'])
        echo "<h2>{$section['title']}</h2>\n";

    if ($section['callback'])
        call_user_func($section['callback'], $section);

    if (!isset($wp_settings_fields[$page][$section_id]))
        return;

    echo '<table class="form-table" role="presentation">';
    do_settings_fields($page, $section['id']);
    echo '</table>';
}

// 5. Helper Function
function modernnews_get_option($key, $default = '')
{
    if (!function_exists('get_option')) {
        return $default;
    }
    $options = get_option('modernnews_theme_options');
    $val = isset($options[$key]) ? $options[$key] : '';

    // Fallback to get_theme_mod for certain keys if modernnews_theme_options is empty
    if (empty($val) && function_exists('get_theme_mod')) {
        $val = get_theme_mod('modernnews_' . $key, '');
        if (empty($val)) {
            $val = get_theme_mod($key, '');
        }
    }

    return !empty($val) ? $val : $default;
}


