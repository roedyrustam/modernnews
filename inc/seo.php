<?php
/**
 * Modern News SEO & Social Media Optimization
 * Handles Open Graph and Twitter Card meta tags.
 */

if (!defined('ABSPATH')) {
    exit;
}

function modernnews_social_meta_tags() {
    $title = get_bloginfo('name');
    $description = get_bloginfo('description');
    $url = home_url();
    $image = '';
    $type = 'website';

    if (is_single() || is_page()) {
        global $post;
        $title = get_the_title($post->ID);
        $description = wp_trim_words($post->post_content, 25);
        $url = get_permalink($post->ID);
        $image = get_the_post_thumbnail_url($post->ID, 'full');
        $type = 'article';
    } elseif (is_category()) {
        $category = get_queried_object();
        $title = $category->name;
        $description = strip_tags(term_description($category->term_id));
        $url = get_category_link($category->term_id);
    }

    // Fallback for image
    if (empty($image)) {
        $image = wp_get_attachment_url(get_theme_mod('custom_logo'));
    }

    ?>
    <!-- Standard SEO -->
    <meta name="description" content="<?php echo esc_attr($description); ?>" />
    <link rel="canonical" href="<?php echo esc_url($url); ?>" />

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo esc_attr($title); ?>" />
    <meta property="og:description" content="<?php echo esc_attr($description); ?>" />
    <meta property="og:url" content="<?php echo esc_url($url); ?>" />
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
    <meta property="og:type" content="<?php echo esc_attr($type); ?>" />
    <?php if ($image): ?>
    <meta property="og:image" content="<?php echo esc_url($image); ?>" />
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>" />
    <meta name="twitter:description" content="<?php echo esc_attr($description); ?>" />
    <?php if ($image): ?>
    <meta name="twitter:image" content="<?php echo esc_url($image); ?>" />
    <?php endif; ?>
    <?php
}
add_action('wp_head', 'modernnews_social_meta_tags', 5);
