<?php
/**
 * Modern News Ads Manager
 * Registers settings and fields for ad management.
 */

function modernnews_ads_settings_init()
{
    // Check if Settings API is available
    if (!function_exists('is_admin') || !is_admin() || !function_exists('add_settings_section') || !function_exists('register_setting') || !function_exists('add_settings_field') || !function_exists('get_option')) {
        return;
    }

    register_setting('modernnews_ads', 'modernnews_ads_options');

    add_settings_section(
        'modernnews_ads_section_header',
        'Header Ad (728x90)',
        'modernnews_ads_section_header_cb',
        'modernnews_ads'
    );

    add_settings_section(
        'modernnews_ads_section_sidebar',
        'Sidebar Ad (300x250 or Responsive)',
        'modernnews_ads_section_sidebar_cb',
        'modernnews_ads'
    );

    add_settings_section(
        'modernnews_ads_section_single',
        'Single Post Ads',
        'modernnews_ads_section_single_cb',
        'modernnews_ads'
    );

    add_settings_section(
        'modernnews_ads_section_sticky',
        'Sticky Mobile Footer',
        'modernnews_ads_section_sticky_cb',
        'modernnews_ads'
    );

    // --- Header Fields ---
    add_settings_field(
        'header_ad_type',
        'Ad Type',
        'modernnews_ads_field_type_cb',
        'modernnews_ads',
        'modernnews_ads_section_header',
        ['label_for' => 'header_ad_type']
    );
    add_settings_field(
        'header_ad_image',
        'Image URL',
        'modernnews_ads_field_image_cb',
        'modernnews_ads',
        'modernnews_ads_section_header',
        ['label_for' => 'header_ad_image']
    );
    add_settings_field(
        'header_ad_link',
        'Target URL',
        'modernnews_ads_field_link_cb',
        'modernnews_ads',
        'modernnews_ads_section_header',
        ['label_for' => 'header_ad_link']
    );
    add_settings_field(
        'header_ad_code',
        'Custom Code (HTML/JS)',
        'modernnews_ads_field_code_cb',
        'modernnews_ads',
        'modernnews_ads_section_header',
        ['label_for' => 'header_ad_code']
    );

    // --- Sidebar Fields ---
    add_settings_field(
        'sidebar_ad_type',
        'Ad Type',
        'modernnews_ads_field_type_cb',
        'modernnews_ads',
        'modernnews_ads_section_sidebar',
        ['label_for' => 'sidebar_ad_type']
    );
    add_settings_field(
        'sidebar_ad_image',
        'Image URL',
        'modernnews_ads_field_image_cb',
        'modernnews_ads',
        'modernnews_ads_section_sidebar',
        ['label_for' => 'sidebar_ad_image']
    );
    add_settings_field(
        'sidebar_ad_link',
        'Target URL',
        'modernnews_ads_field_link_cb',
        'modernnews_ads',
        'modernnews_ads_section_sidebar',
        ['label_for' => 'sidebar_ad_link']
    );
    add_settings_field(
        'sidebar_ad_code',
        'Custom Code (HTML/JS)',
        'modernnews_ads_field_code_cb',
        'modernnews_ads',
        'modernnews_ads_section_sidebar',
        ['label_for' => 'sidebar_ad_code']
    );

    // --- Single Post Before Content Fields ---
    add_settings_field(
        'single_before_ad_type',
        'Before Content: Ad Type',
        'modernnews_ads_field_type_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_before_ad_type']
    );
    add_settings_field(
        'single_before_ad_image',
        'Before Content: Image',
        'modernnews_ads_field_image_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_before_ad_image']
    );
    add_settings_field(
        'single_before_ad_link',
        'Before Content: Link',
        'modernnews_ads_field_link_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_before_ad_link']
    );
    add_settings_field(
        'single_before_ad_code',
        'Before Content: Code',
        'modernnews_ads_field_code_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_before_ad_code']
    );

    // --- Single Post In-Article Fields ---
    add_settings_field(
        'single_in_article_ad_paragraph',
        'In-Article: Paragraph Position',
        'modernnews_ads_field_number_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_in_article_ad_paragraph']
    );
    add_settings_field(
        'single_in_article_ad_type',
        'In-Article: Ad Type',
        'modernnews_ads_field_type_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_in_article_ad_type']
    );
    add_settings_field(
        'single_in_article_ad_image',
        'In-Article: Image',
        'modernnews_ads_field_image_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_in_article_ad_image']
    );
    add_settings_field(
        'single_in_article_ad_link',
        'In-Article: Link',
        'modernnews_ads_field_link_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_in_article_ad_link']
    );
    add_settings_field(
        'single_in_article_ad_code',
        'In-Article: Code',
        'modernnews_ads_field_code_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_in_article_ad_code']
    );

    // --- Single Post After Content Fields ---
    add_settings_field(
        'single_after_ad_type',
        'After Content: Ad Type',
        'modernnews_ads_field_type_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_after_ad_type']
    );
    add_settings_field(
        'single_after_ad_image',
        'After Content: Image',
        'modernnews_ads_field_image_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_after_ad_image']
    );
    add_settings_field(
        'single_after_ad_link',
        'After Content: Link',
        'modernnews_ads_field_link_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_after_ad_link']
    );
    add_settings_field(
        'single_after_ad_code',
        'After Content: Code',
        'modernnews_ads_field_code_cb',
        'modernnews_ads',
        'modernnews_ads_section_single',
        ['label_for' => 'single_after_ad_code']
    );

    // --- Sticky Mobile Footer Fields ---
    add_settings_field(
        'sticky_footer_ad_type',
        'Sticky Footer: Ad Type',
        'modernnews_ads_field_type_cb',
        'modernnews_ads',
        'modernnews_ads_section_sticky',
        ['label_for' => 'sticky_footer_ad_type']
    );
    add_settings_field(
        'sticky_footer_ad_image',
        'Sticky Footer: Image',
        'modernnews_ads_field_image_cb',
        'modernnews_ads',
        'modernnews_ads_section_sticky',
        ['label_for' => 'sticky_footer_ad_image']
    );
    add_settings_field(
        'sticky_footer_ad_link',
        'Sticky Footer: Link',
        'modernnews_ads_field_link_cb',
        'modernnews_ads',
        'modernnews_ads_section_sticky',
        ['label_for' => 'sticky_footer_ad_link']
    );
    add_settings_field(
        'sticky_footer_ad_code',
        'Sticky Footer: Code',
        'modernnews_ads_field_code_cb',
        'modernnews_ads',
        'modernnews_ads_section_sticky',
        ['label_for' => 'sticky_footer_ad_code']
    );
}
add_action('admin_init', 'modernnews_ads_settings_init');

function modernnews_ads_section_header_cb($args)
{
    echo '<p>Settings for the main header banner.</p>';
}
function modernnews_ads_section_sidebar_cb($args)
{
    echo '<p>Settings for the sidebar widget area.</p>';
}
function modernnews_ads_section_single_cb($args)
{
    echo '<p>Settings for ads within single articles.</p>';
}
function modernnews_ads_section_sticky_cb($args)
{
    echo '<p>Display a fixed ad at the bottom of the screen (Mobile Only).</p>';
}

// --- Callbacks for Fields ---

function modernnews_ads_field_type_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_ads_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : 'image';
    ?>
    <select name="modernnews_ads_options[<?php echo esc_attr($args['label_for']); ?>]">
        <option value="image" <?php selected($val, 'image'); ?>>Image + Link</option>
        <option value="code" <?php selected($val, 'code'); ?>>Custom Code (AdSense/Script)</option>
    </select>
    <?php
}

function modernnews_ads_field_image_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_ads_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<input type="text" name="modernnews_ads_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="regular-text code" placeholder="https://example.com/banner.jpg">';
}

function modernnews_ads_field_link_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_ads_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<input type="text" name="modernnews_ads_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="regular-text code" placeholder="https://target-site.com">';
}

function modernnews_ads_field_number_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_ads_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '3';
    echo '<input type="number" name="modernnews_ads_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="small-text" min="1">';
    echo '<p class="description">Insert ad after this many paragraphs.</p>';
}

function modernnews_ads_field_code_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('modernnews_ads_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<textarea name="modernnews_ads_options[' . esc_attr($args['label_for']) . ']" rows="5" cols="50" class="large-text code">' . esc_textarea($val) . '</textarea>';
}

// --- Menu Page ---
// Integrated into Theme Options (inc/theme-options.php).

// --- Helper Function ---

function modernnews_get_ad($slot_prefix)
{
    if (!function_exists('get_option')) {
        return '';
    }
    $options = get_option('modernnews_ads_options');
    // $slot_prefix e.g., 'header_ad', 'sidebar_ad', 'single_before_ad'

    $type = isset($options[$slot_prefix . '_type']) ? $options[$slot_prefix . '_type'] : 'image';
    $output = '';

    if ($type === 'image') {
        $img = isset($options[$slot_prefix . '_image']) ? $options[$slot_prefix . '_image'] : '';
        $link = isset($options[$slot_prefix . '_link']) ? $options[$slot_prefix . '_link'] : '#';

        // Dummy Ad Logic
        if (empty($img)) {
            $size = '728x90';
            $text = 'Advertisement';

            switch ($slot_prefix) {
                case 'header_ad':
                    $size = '728x90';
                    $text = 'Header Ad (728x90)';
                    break;
                case 'sidebar_ad':
                    $size = '300x250';
                    $text = 'Sidebar Ad (300x250)';
                    break;
                case 'single_before_ad':
                    $size = '728x90';
                    $text = 'Before Content Ad';
                    break;
                case 'single_in_article_ad':
                    $size = '300x250';
                    $text = 'In-Article Ad';
                    break;
                case 'single_after_ad':
                    $size = '728x90';
                    $text = 'After Content Ad';
                    break;
                case 'sticky_footer_ad':
                    $size = '320x50';
                    $text = 'Sticky Footer';
                    break;
            }
            $img = 'https://placehold.co/' . $size . '?text=' . urlencode($text);
        }

        if (!empty($img)) {
            $output .= '<div class="modernnews-ad-container modernnews-ad-image">';
            $output .= '<a href="' . esc_url($link) . '" target="_blank" rel="nofollow noopener">';
            $output .= '<img src="' . esc_url($img) . '" alt="Advertisement" class="w-full h-auto object-cover rounded-lg mx-auto">';
            $output .= '</a>';
            $output .= '</div>';
        }
    } elseif ($type === 'code') {
        $code = isset($options[$slot_prefix . '_code']) ? $options[$slot_prefix . '_code'] : '';
        if (!empty($code)) {
            $output .= '<div class="modernnews-ad-container modernnews-ad-code">';
            $output .= $code; // Intentionally unescaped for Scripts
            $output .= '</div>';
        }
    }

    return $output;
}

/**
 * Filter Content to Inject Ad
 */
// function modernnews_inject_in_article_ad($content)
// {
//    // Replaced by inc/ad-injection.php
// }
// add_filter('the_content', 'modernnews_inject_in_article_ad');
