<?php
/**
 * Modern News Theme Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require get_template_directory() . '/inc/class-modernnews-mega-menu-walker.php';
require get_template_directory() . '/inc/class-modernnews-mobile-walker.php';
require_once get_template_directory() . '/inc/performance.php';
require_once get_template_directory() . '/inc/schema.php';

function modernnews_setup()
{
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Title tag support
    add_theme_support('title-tag');

    // Post thumbnails
    add_theme_support('post-thumbnails');

    // Custom logo
    add_theme_support('custom-logo', array(
        'height' => 50,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // Block Editor Styles
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style(array('assets/css/main.css', 'assets/css/blocks.css')); // Load main and block styles in editor


    // HTML5 Support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'modernnews'),
        'footer' => __('Footer Menu', 'modernnews'),
        'mobile' => __('Mobile Menu', 'modernnews'),
    ));
}
add_action('after_setup_theme', 'modernnews_setup');

// Include Custom Widgets
require get_template_directory() . '/inc/widgets.php';

/**
 * Register widget area and custom widgets.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function modernnews_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Main Sidebar', 'modernnews'),
            'id' => 'main-sidebar',
            'description' => esc_html__('Add widgets here.', 'modernnews'),
            'before_widget' => '<div id="%1$s" class="widget %2$s mb-8 bg-white dark:bg-zinc-900 dark:text-white p-6 rounded-2xl border border-gray-100 dark:border-zinc-800 shadow-sm">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title text-xl font-black mb-6 flex items-center gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(array(
        'name' => esc_html__('Footer Column 1', 'modernnews'),
        'id' => 'footer-1',
        'description' => esc_html__('Widgets for the first footer column (Branding/About).', 'modernnews'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="font-bold text-lg mb-4 text-white">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Column 2', 'modernnews'),
        'id' => 'footer-2',
        'description' => esc_html__('Widgets for the second footer column (Categories).', 'modernnews'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="font-bold text-lg mb-4 text-white">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Column 3', 'modernnews'),
        'id' => 'footer-3',
        'description' => esc_html__('Widgets for the third footer column (Company/Info).', 'modernnews'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="font-bold text-lg mb-4 text-white">',
        'after_title' => '</h4>',
    ));

    // Register Custom Widgets
    register_widget('ModernNews_Weather_Widget');
    register_widget('ModernNews_Trending_Widget');
    register_widget('ModernNews_Post_List_Widget');
    register_widget('ModernNews_Author_Widget');
    register_widget('ModernNews_Newsletter_Widget');
    register_widget('ModernNews_Social_Follow_Widget');
}
add_action('widgets_init', 'modernnews_widgets_init');


/**
 * Enqueue scripts and styles.
 */
function modernnews_scripts()
{
    // Google Fonts
    // Google Fonts: Epilogue, Noto Sans, Material Symbols
    wp_enqueue_style('modernnews-fonts', 'https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700&display=swap', array(), null);
    wp_enqueue_style('modernnews-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null);
    wp_enqueue_style('remix-icon', 'https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css', array(), '4.2.0');

    // Main Stylesheet
    wp_enqueue_style('modernnews-style', get_stylesheet_uri());

    // Custom Main CSS
    wp_enqueue_style('modernnews-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');

    // Block Styles
    wp_enqueue_style('modernnews-blocks', get_template_directory_uri() . '/assets/css/blocks.css', array(), '1.0.0');

    // Main JS
    wp_enqueue_script('modernnews-main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);

    // Pass AJAX URL and Settings to script
    wp_localize_script('modernnews-main-js', 'modernnews_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('modernnews_nonce'),
        'weather_api_key' => modernnews_get_option('weather_api_key')
    ));

    // Inline Custom Styles from Customizer (Live Preview)
    $primary_color = get_theme_mod('modernnews_primary_color', '#3b82f6');
    $secondary_color = get_theme_mod('modernnews_secondary_color', '#1e293b');
    $header_bg = get_theme_mod('modernnews_header_bg', '#ffffff');
    $body_bg = get_theme_mod('modernnews_body_bg', '#f3f4f6');
    $heading_font = get_theme_mod('modernnews_heading_font', 'Epilogue');
    $body_font = get_theme_mod('modernnews_body_font', 'Noto Sans');
    $border_radius = get_theme_mod('modernnews_border_radius', '0.4');
    $site_width = get_theme_mod('modernnews_site_width', '1280');

    // Dynamic Font Loading
    $fonts_to_load = array_unique([$heading_font, $body_font]);
    foreach ($fonts_to_load as $font_name) {
        $font_id = 'modernnews-font-' . strtolower(str_replace(' ', '-', $font_name));
        wp_enqueue_style($font_id, 'https://fonts.googleapis.com/css2?family=' . urlencode($font_name) . ':wght@400;500;700;800&display=swap', array(), null);
    }
    // Add logic for other fonts if selected, but for now we keep the premium default.

    $custom_css = "
        :root {
            --color-primary: {$primary_color};
            --color-secondary: {$secondary_color};
            --bg-header: {$header_bg};
            --bg-light: {$body_bg};
            --font-heading: '{$heading_font}', sans-serif;
            --font-body: '{$body_font}', sans-serif;
            --radius-md: {$border_radius}rem;
            --site-max-width: {$site_width}px;
        }
        body {
            background-color: var(--bg-light);
            font-family: var(--font-body);
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: var(--font-heading);
        }
        .site-header {
            background-color: var(--bg-header);
        }
        .container, .max-w-\\[1200px\\] {
            max-width: var(--site-max-width) !important;
        }
        .rounded-xl, .rounded-2xl {
             border-radius: var(--radius-md);
        }
    ";

    wp_add_inline_style('modernnews-main', $custom_css);
}
add_action('wp_enqueue_scripts', 'modernnews_scripts');

/**
 * Handle Local News AJAX
 */
function modernnews_get_local_news()
{
    check_ajax_referer('modernnews_nonce', 'nonce');

    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';

    // Automatic GEO Detection if no city provided
    if (empty($city)) {
        $user_ip = $_SERVER['REMOTE_ADDR'];
        // Basic GEO API (ip-api.com) - In production, use a more robust or paid service if needed
        $response = wp_remote_get("http://ip-api.com/json/" . $user_ip);
        if (!is_wp_error($response)) {
            $data = json_decode(wp_remote_retrieve_body($response));
            if ($data && isset($data->status) && $data->status === 'success') {
                $city = $data->city ?? '';
            }
        }
    }

    // If city is provided, try to find posts with that tag or category
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'post_status' => 'publish',
    );

    if (!empty($city)) {
        // Try to match tag slug or name
        $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'post_tag',
                'field' => 'name',
                'terms' => $city, // e.g., "Jakarta"
            ),
            array(
                'taxonomy' => 'category',
                'field' => 'name',
                'terms' => $city,
            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'card');
        }
        wp_reset_postdata();
    } else {
        echo '<p class="no-local-news">Belum ada berita spesifik untuk wilayah ' . esc_html($city) . '. Menampilkan berita nasional terkini.</p>';
        // Fallback to latest news
        $fallback_args = array(
            'post_type' => 'post',
            'posts_per_page' => 4,
            'ignore_sticky_posts' => 1
        );
        $fallback_query = new WP_Query($fallback_args);
        if ($fallback_query->have_posts()) {
            while ($fallback_query->have_posts()) {
                $fallback_query->the_post();
                get_template_part('template-parts/content', 'card');
            }
        }
        wp_reset_postdata();
    }

    wp_die();
}
add_action('wp_ajax_get_local_news', 'modernnews_get_local_news');
add_action('wp_ajax_nopriv_get_local_news', 'modernnews_get_local_news');

/**
 * Handle Custom Query Vars for Sorting
 */
function modernnews_add_query_vars($vars)
{
    $vars[] = 'sort';
    return $vars;
}
add_filter('query_vars', 'modernnews_add_query_vars');

/**
 * Modify Main Query based on Sort parameter
 */
function modernnews_pre_get_posts($query)
{
    if (!is_admin() && $query->is_main_query() && ($query->is_archive() || $query->is_home())) {
        $sort = get_query_var('sort');

        if ('oldest' === $sort) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'date');
        } elseif ('popular' === $sort) {
            // Assuming sorting by comment count as a proxy for popularity for now
            // For true view count, a plugin or custom field is needed.
            $query->set('orderby', 'comment_count');
        } else {
            // Default to latest
            $query->set('order', 'DESC');
            $query->set('orderby', 'date');
        }
    }
}
add_action('pre_get_posts', 'modernnews_pre_get_posts');


/**
 * Estimated Reading Time
 */
function modernnews_estimated_reading_time()
{
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average 200 words per minute

    // If less than 1 minute, show '1 min read'
    if ($reading_time < 1) {
        return '1 min baca';
    }

    return $reading_time . ' min baca';
}


/**
 * Load Custom Ads Manager
 */
require get_template_directory() . '/inc/ads-manager.php';


/**
 * Load RSS Import Feature
 */
require get_template_directory() . '/inc/rss-import.php';

/**
 * Load AJAX Archive Handler
 */
require get_template_directory() . '/inc/ajax-archive.php';

/**
 * Load Theme Options
 */
require get_template_directory() . '/inc/theme-options.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/seo.php';
require get_template_directory() . '/inc/block-styles.php';
require get_template_directory() . '/inc/ad-injection.php';
require get_template_directory() . '/inc/paywall.php';


/**
 * Handle Citizen News Submission
 */
function modernnews_handle_citizen_submission()
{
    // 1. Verify Nonce & Permissions
    if (!isset($_POST['citizen_news_nonce']) || !wp_verify_nonce($_POST['citizen_news_nonce'], 'citizen_news_submission')) {
        wp_die('Security check failed');
    }

    // 2. Sanitize Input
    $title = sanitize_text_field($_POST['news_title']);
    $content = sanitize_textarea_field($_POST['news_content']);
    $category_name = sanitize_text_field($_POST['news_category']);
    $location = sanitize_text_field($_POST['news_location']);
    $tags = sanitize_text_field($_POST['news_tags']);
    $anonymous = isset($_POST['post_anonymous']);

    // 3. Prepare Post Data
    $post_data = array(
        'post_title' => $title,
        'post_content' => $content . "\n\n<!-- Location: " . $location . " -->",
        'post_status' => 'draft', // Always draft for review
        'post_type' => 'post',
        'post_author' => $anonymous ? 0 : get_current_user_id()
    );

    // 4. Insert Post
    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        // Set Category
        $cat = get_term_by('name', $category_name, 'category');
        if ($cat) {
            wp_set_post_categories($post_id, array($cat->term_id));
        }

        // Set Tags
        if (!empty($tags)) {
            wp_set_post_tags($post_id, $tags);
        }

        // Handle File Upload (Simple version)
        if (!empty($_FILES['news_image']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $attachment_id = media_handle_upload('news_image', $post_id);
            if (!is_wp_error($attachment_id)) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }

        // Redirect back with success message
        wp_redirect(add_query_arg('submission', 'success', wp_get_referer()));
        exit;
    } else {
        wp_die('Error creating post.');
    }
}
add_action('admin_post_submit_citizen_news', 'modernnews_handle_citizen_submission');
add_action('admin_post_nopriv_submit_citizen_news', 'modernnews_handle_citizen_submission'); // Allow non-logged-in users
