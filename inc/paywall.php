<?php
/**
 * Modern News Paywall / Premium Content
 */

if (!defined('ABSPATH')) {
    exit;
}

// 1. Add Custom Checkbox to Post Editor
function modernnews_add_premium_meta_box()
{
    add_meta_box(
        'modernnews_premium_meta',
        __('Premium Content', 'modernnews'),
        'modernnews_render_premium_meta_box',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'modernnews_add_premium_meta_box');

function modernnews_render_premium_meta_box($post)
{
    $is_premium = get_post_meta($post->ID, '_modernnews_is_premium', true);
    wp_nonce_field('modernnews_save_premium_meta', 'modernnews_premium_nonce');
    ?>
    <label for="modernnews_is_premium">
        <input type="checkbox" id="modernnews_is_premium" name="modernnews_is_premium" value="1" <?php checked($is_premium, 1); ?> />
        <?php _e('Mark as Premium (Subscribers Only)', 'modernnews'); ?>
    </label>
    <?php
}

function modernnews_save_premium_meta($post_id)
{
    if (!isset($_POST['modernnews_premium_nonce']) || !wp_verify_nonce($_POST['modernnews_premium_nonce'], 'modernnews_save_premium_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;

    if (isset($_POST['modernnews_is_premium'])) {
        update_post_meta($post_id, '_modernnews_is_premium', 1);
    } else {
        delete_post_meta($post_id, '_modernnews_is_premium');
    }
}
add_action('save_post', 'modernnews_save_premium_meta');

// 2. Restrict Content
function modernnews_restrict_premium_content($content)
{
    if (is_single() && is_main_query()) {
        $is_premium = get_post_meta(get_the_ID(), '_modernnews_is_premium', true);

        if ($is_premium && !is_user_logged_in()) {
            // Get first paragraph only as teaser
            $paragraphs = explode('</p>', $content);
            $teaser = $paragraphs[0] . '</p>';

            $cta = '<div class="modernnews-paywall-notice bg-gray-100 dark:bg-zinc-800 p-8 rounded-xl text-center my-8 border border-gray-200 dark:border-zinc-700">';
            $cta .= '<h3 class="text-xl font-bold mb-4">' . __('Konten Premium', 'modernnews') . '</h3>';
            $cta .= '<p class="mb-6">' . __('Artikel ini khusus untuk pelanggan premium. Silakan berlangganan untuk membaca selengkapnya.', 'modernnews') . '</p>';

            $sub_url = '#';
            if (function_exists('modernnews_get_option')) {
                $sub_url = modernnews_get_option('subscribe_url', '#');
            }
            $cta .= '<a href="' . esc_url($sub_url) . '" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition-colors">' . __('Berlangganan Sekarang', 'modernnews') . '</a>';
            $cta .= '</div>';

            return $teaser . $cta;
        }
    }
    return $content;
}
add_filter('the_content', 'modernnews_restrict_premium_content', 20); // Priority 20 to run after ad injection hopefully, but typically filters run in order added.
