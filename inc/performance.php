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

// 4. Optimize Image Loading for LCP
if (!function_exists('modernnews_optimize_lcp_images')) {
    function modernnews_optimize_lcp_images($attr, $attachment, $size)
    {
        if (is_singular() || is_front_page()) {
            global $wp_query;
            // If it's the first image in the loop or the main featured image
            if ($wp_query->current_post <= 0) {
                $attr['fetchpriority'] = 'high';
                $attr['loading'] = 'eager';
            }
        }
        return $attr;
    }
    // High priority to ensure it runs late
    add_filter('wp_get_attachment_image_attributes', 'modernnews_optimize_lcp_images', 10, 3);
}

// 5. Add Resource Hints (Preconnect)
if (!function_exists('modernnews_resource_hints')) {
    function modernnews_resource_hints($urls, $relation_type)
    {
        if ('preconnect' === $relation_type) {
            $urls[] = array('href' => 'https://fonts.googleapis.com', 'crossorigin');
            $urls[] = array('href' => 'https://fonts.gstatic.com', 'crossorigin');
            $urls[] = array('href' => 'https://cdn.jsdelivr.net', 'crossorigin');
        }
        return $urls;
    }
    add_filter('wp_resource_hints', 'modernnews_resource_hints', 10, 2);
}

// 6. Remove jQuery Migrate (Optional - only if not needed by plugins)
if (!function_exists('modernnews_remove_jquery_migrate')) {
    function modernnews_remove_jquery_migrate($scripts)
    {
        if (!is_admin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];
            if ($script->deps) { // Check for dependencies
                $script->deps = array_diff($script->deps, array('jquery-migrate'));
            }
        }
    }
    add_action('wp_default_scripts', 'modernnews_remove_jquery_migrate');
}

// 7. Dynamic Meta Descriptions (SEO)
if (!function_exists('modernnews_add_meta_description')) {
    function modernnews_add_meta_description()
    {
        $description = '';

        if (is_singular()) {
            global $post;
            if (!empty($post->post_excerpt)) {
                $description = $post->post_excerpt;
            } else {
                $description = wp_trim_words($post->post_content, 25, '...');
            }
        } elseif (is_category() || is_tag() || is_tax()) {
            $description = strip_tags(term_description());
        } elseif (is_front_page() || is_home()) {
            $description = get_bloginfo('description');
        }

        if (!empty($description)) {
            $description = esc_attr(trim($description));
            echo '<meta name="description" content="' . $description . '" />' . "\n";
        }
    }
    add_action('wp_head', 'modernnews_add_meta_description', 2);
}
