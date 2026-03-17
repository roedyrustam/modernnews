<?php
/**
 * Performance Optimizations
 * Removes unnecessary WordPress bloat.
 */

// 1. Disable Emojis (JS/CSS)
if (!function_exists('modernnews_disable_emojis')) {
    function modernnews_disable_emojis()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', 'modernnews_disable_emojis_tinymce');
        add_filter('wp_resource_hints', 'modernnews_disable_emojis_remove_dns_prefetch', 10, 2);
    }
    add_action('init', 'modernnews_disable_emojis');
}

if (!function_exists('modernnews_disable_emojis_tinymce')) {
    function modernnews_disable_emojis_tinymce($plugins)
    {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        } else {
            return array();
        }
    }
}

if (!function_exists('modernnews_disable_emojis_remove_dns_prefetch')) {
    function modernnews_disable_emojis_remove_dns_prefetch($urls, $relation_type)
    {
        if ('dns-prefetch' == $relation_type) {
            $emoji_svg_url = 'https://s.w.org/images/core/emoji/2/svg/';
            $urls = array_diff($urls, array($emoji_svg_url));
        }
        return $urls;
    }
}

// 2. Clean up Head
if (!function_exists('modernnews_cleanup_head')) {
    function modernnews_cleanup_head()
    {
        // Remove WP Version
        remove_action('wp_head', 'wp_generator');

        // Remove RSD link
        remove_action('wp_head', 'rsd_link');

        // Remove WLW Manifest
        remove_action('wp_head', 'wlwmanifest_link');

        // Remove Shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head');

        // Remove Feed Links (Optional - keeping simplified)
        // remove_action('wp_head', 'feed_links', 2);
        // remove_action('wp_head', 'feed_links_extra', 3);
    }
    add_action('after_setup_theme', 'modernnews_cleanup_head');
}

// 3. Disable XML-RPC (Security & Performance)
add_filter('xmlrpc_enabled', '__return_false');

// 4. Remove jQuery Migrate (Optional - only if not needed by plugins)
// function modernnews_remove_jquery_migrate($scripts) {
//     if (!is_admin() && isset($scripts->registered['jquery'])) {
//         $script = $scripts->registered['jquery'];
//         if ($script->deps) { // Check for dependencies
//             $script->deps = array_diff($script->deps, array('jquery-migrate'));
//         }
//     }
// }
// add_action('wp_default_scripts', 'modernnews_remove_jquery_migrate');
