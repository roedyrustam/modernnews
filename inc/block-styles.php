<?php
/**
 * Modern News Block Styles
 */

if (!defined('ABSPATH')) {
    exit;
}

function modernnews_register_block_styles()
{
    register_block_style(
        'core/group',
        array(
            'name' => 'highlight-box',
            'label' => __('Highlight Box', 'modernnews'),
        )
    );

    register_block_style(
        'core/quote',
        array(
            'name' => 'news-quote',
            'label' => __('News Quote', 'modernnews'),
        )
    );
}
add_action('init', 'modernnews_register_block_styles');
