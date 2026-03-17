<?php
/**
 * AJAX Handler for Archive Filtering
 */

function modernnews_ajax_filter_archive()
{
    // 1. Verify Nonce (Optional but recommended, though for public read-only it's less critical, good practice)
    // check_ajax_referer('modernnews_archive_nonce', 'nonce');

    // 2. Get Params
    $cat_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $tag_id = isset($_POST['tag_id']) ? sanitize_text_field($_POST['tag_id']) : '';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    // 3. Query Args
    $args = array(
        'post_status' => 'publish',
        'paged' => $paged,
        'posts_per_page' => get_option('posts_per_page'),
    );

    if ($cat_id > 0) {
        $args['cat'] = $cat_id;
    }

    // Handle Tag Filter
    if (!empty($tag_id) && $tag_id !== 'all') {
        $args['tag_id'] = intval($tag_id);
    }

    $query = new WP_Query($args);

    // 4. Output
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'card');
        }
    } else {
        echo '<p class="text-center text-text-muted mt-8">Tidak ada berita ditemukan untuk filter ini.</p>';
    }

    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_modernnews_filter_archive', 'modernnews_ajax_filter_archive');
add_action('wp_ajax_nopriv_modernnews_filter_archive', 'modernnews_ajax_filter_archive');
