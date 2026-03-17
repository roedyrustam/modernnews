<?php
/**
 * Modern News Ad Injection
 */

if (!defined('ABSPATH')) {
    exit;
}

function modernnews_inject_in_feed_ads($content)
{
    if (is_single() && !is_admin() && is_main_query()) {
        $ad_code = modernnews_get_ad('single_in_article_ad'); // Use existing setting key
        $options = get_option('modernnews_ads_options');
        $frequency = isset($options['single_in_article_ad_paragraph']) ? (int) $options['single_in_article_ad_paragraph'] : 3;

        if ($ad_code) {
            $paragraphs = explode('</p>', $content);
            $new_content = '';
            $count = 0;

            foreach ($paragraphs as $index => $paragraph) {
                if (trim($paragraph)) {
                    $new_content .= $paragraph . '</p>';
                    $count++;

                    if ($count > 0 && $count % $frequency === 0) {
                        $new_content .= '<div class="modernnews-in-feed-ad my-8 text-center flex justify-center container mx-auto">';
                        $new_content .= $ad_code;
                        $new_content .= '</div>';
                    }
                }
            }
            return $new_content;
        }
    }
    return $content;
}
add_filter('the_content', 'modernnews_inject_in_feed_ads');
