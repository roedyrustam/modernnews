<?php
/**
 * Modern News SEO & OpenGraph Implementation
 */

function modernnews_seo_meta_tags()
{
    // Basic SEO
    $site_name = get_bloginfo('name');
    $description = get_bloginfo('description');
    $url = home_url(add_query_arg(NULL, NULL));
    $type = 'website';
    $title = $site_name;
    $image = ''; // Fallback image if needed
    $image_width = '';
    $image_height = '';

    if (is_single() || is_page()) {
        $post = get_queried_object();
        $title = get_the_title($post->ID) . ' | ' . $site_name;
        $description = wp_trim_words($post->post_content, 25, '...');
        $url = get_permalink($post->ID);
        $type = 'article';

        // Use Featured Image for OpenGraph
        if (has_post_thumbnail($post->ID)) {
            $thumbnail_id = get_post_thumbnail_id($post->ID);
            $image_src = wp_get_attachment_image_src($thumbnail_id, 'full');
            if ($image_src) {
                $image = $image_src[0];
                $image_width = $image_src[1];
                $image_height = $image_src[2];
            }
        }
    } elseif (is_category() || is_tag() || is_archive()) {
        $term = get_queried_object();
        $title = single_term_title('', false) . ' | ' . $site_name;
        $description = term_description();
        $url = get_term_link($term);
    }

    // Fallback 1: Custom Theme Option OG Image
    if (empty($image) && function_exists('modernnews_get_option')) {
        $image = modernnews_get_option('default_og_image');
    }

    // Fallback 2: Customizer OG Image
    if (empty($image) && function_exists('get_theme_mod')) {
        $image = get_theme_mod('modernnews_default_og_image');
    }

    // Fallback 2: Site Icon
    if (empty($image) && has_site_icon()) {
        $image = get_site_icon_url();
    }

    // Fallback 3: Theme Option Logo
    if (empty($image) && function_exists('modernnews_get_option')) {
        $image = modernnews_get_option('header_logo_url');
    }

    ?>
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo esc_attr(wp_strip_all_tags($description)); ?>">
    <link rel="canonical" href="<?php echo esc_url($url); ?>">

    <!-- OpenGraph / Facebook -->
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:type" content="<?php echo esc_attr($type); ?>">
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr(wp_strip_all_tags($description)); ?>">
    <?php if ($image): ?>
        <meta property="og:image" content="<?php echo esc_url($image); ?>">
        <meta property="og:image:secure_url" content="<?php echo esc_url($image); ?>">
        <?php if ($image_width && $image_height): ?>
            <meta property="og:image:width" content="<?php echo esc_attr($image_width); ?>">
            <meta property="og:image:height" content="<?php echo esc_attr($image_height); ?>">
        <?php endif; ?>
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo esc_url($url); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr(wp_strip_all_tags($description)); ?>">
    <?php if ($image): ?>
        <meta name="twitter:image" content="<?php echo esc_url($image); ?>">
    <?php endif; ?>
<?php
}
add_action('wp_head', 'modernnews_seo_meta_tags', 1);
