<?php
/**
 * Modern News Customizer
 *
 * @package ModernNews
 */

function modernnews_customize_register($wp_customize)
{
    // --- Colors Section ---
    // WordPress has a built-in 'colors' section, we will use it.

    // 1. Primary Color
    $wp_customize->add_setting('modernnews_primary_color', array(
        'default' => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh', // or 'postMessage' for JS updates
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'modernnews_primary_color', array(
        'label' => __('Primary Color', 'modernnews'),
        'section' => 'colors',
        'settings' => 'modernnews_primary_color',
    )));

    // 2. Secondary Color
    $wp_customize->add_setting('modernnews_secondary_color', array(
        'default' => '#1e293b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'modernnews_secondary_color', array(
        'label' => __('Secondary Color', 'modernnews'),
        'section' => 'colors',
        'settings' => 'modernnews_secondary_color',
    )));

    // 3. Header Background
    $wp_customize->add_setting('modernnews_header_bg', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'modernnews_header_bg', array(
        'label' => __('Header Background', 'modernnews'),
        'section' => 'colors',
        'settings' => 'modernnews_header_bg',
    )));

    // 4. Body Background
    $wp_customize->add_setting('modernnews_body_bg', array(
        'default' => '#f3f4f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'modernnews_body_bg', array(
        'label' => __('Body Background', 'modernnews'),
        'section' => 'colors',
        'settings' => 'modernnews_body_bg',
    )));

    // --- Header Options ---
    $wp_customize->add_section('modernnews_header_options', array(
        'title' => __('Header Options', 'modernnews'),
        'priority' => 120,
    ));

    // Dark Mode Toggle Logic (Optional Visibility)
    $wp_customize->add_setting('modernnews_show_dark_mode', array(
        'default' => true,
        'sanitize_callback' => 'modernnews_sanitize_checkbox',
    ));

    $wp_customize->add_control('modernnews_show_dark_mode', array(
        'label' => __('Show Dark Mode Toggle', 'modernnews'),
        'section' => 'modernnews_header_options',
        'settings' => 'modernnews_show_dark_mode',
        'type' => 'checkbox',
    ));

    // 2. Header Logo
    $wp_customize->add_setting('modernnews_header_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'modernnews_header_logo', array(
        'label' => __('Header Logo', 'modernnews'),
        'section' => 'modernnews_header_options',
        'settings' => 'modernnews_header_logo',
    )));

    // --- Typography Section ---
    $wp_customize->add_section('modernnews_typography_options', array(
        'title' => __('Typography', 'modernnews'),
        'priority' => 130,
    ));

    // 1. Heading Font Family
    $wp_customize->add_setting('modernnews_heading_font', array(
        'default' => 'Epilogue',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('modernnews_heading_font', array(
        'label' => __('Heading Font Family', 'modernnews'),
        'section' => 'modernnews_typography_options',
        'type' => 'select',
        'choices' => array(
            'Epilogue' => 'Epilogue (Modern)',
            'Inter' => 'Inter (Sans)',
            'Outfit' => 'Outfit (Trendy)',
            'Playfair Display' => 'Playfair Display (Serif)',
        ),
    ));

    // 2. Body Font Family
    $wp_customize->add_setting('modernnews_body_font', array(
        'default' => 'Noto Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('modernnews_body_font', array(
        'label' => __('Body Font Family', 'modernnews'),
        'section' => 'modernnews_typography_options',
        'type' => 'select',
        'choices' => array(
            'Noto Sans' => 'Noto Sans',
            'Inter' => 'Inter',
            'Roboto' => 'Roboto',
            'System' => 'System Stack',
        ),
    ));

    // --- Layout Section ---
    $wp_customize->add_section('modernnews_layout_options', array(
        'title' => __('Layout & Global Styles', 'modernnews'),
        'priority' => 140,
    ));

    // 1. Border Radius Intensity
    $wp_customize->add_setting('modernnews_border_radius', array(
        'default' => '0.4', // 0.4rem
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('modernnews_border_radius', array(
        'label' => __('Border Radius Intensity (rem)', 'modernnews'),
        'section' => 'modernnews_layout_options',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0,
            'max' => 2,
            'step' => 0.1,
        ),
    ));

    // 2. Site Max Width
    $wp_customize->add_setting('modernnews_site_width', array(
        'default' => '1280',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('modernnews_site_width', array(
        'label' => __('Site Max Width (px)', 'modernnews'),
        'section' => 'modernnews_layout_options',
        'type' => 'number',
    ));

    // --- Footer Section ---
    $wp_customize->add_section('modernnews_footer_options', array(
        'title' => __('Footer Settings', 'modernnews'),
        'priority' => 150,
    ));

    // 1. Copyright Text
    $wp_customize->add_setting('modernnews_copyright_text', array(
        'default' => '© 2026 Modern News. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('modernnews_copyright_text', array(
        'label' => __('Copyright Text', 'modernnews'),
        'section' => 'modernnews_footer_options',
        'type' => 'text',
    ));

    // 2. Footer Logo
    $wp_customize->add_setting('modernnews_footer_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'modernnews_footer_logo', array(
        'label' => __('Footer Logo', 'modernnews'),
        'section' => 'modernnews_footer_options',
        'settings' => 'modernnews_footer_logo',
    )));

    // --- SEO & Social Section ---
    $wp_customize->add_section('modernnews_seo_options', array(
        'title' => __('SEO & Social', 'modernnews'),
        'priority' => 160,
    ));

    // 1. Default OpenGraph Image
    $wp_customize->add_setting('modernnews_default_og_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'modernnews_default_og_image', array(
        'label' => __('Default OpenGraph Image', 'modernnews'),
        'section' => 'modernnews_seo_options',
        'settings' => 'modernnews_default_og_image',
    )));

    // 2. Twitter Username
    $wp_customize->add_setting('modernnews_twitter_username', array(
        'default' => '@modernnews',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('modernnews_twitter_username', array(
        'label' => __('Twitter Username', 'modernnews'),
        'section' => 'modernnews_seo_options',
        'type' => 'text',
    ));
}
add_action('customize_register', 'modernnews_customize_register');

/**
 * Sanitize Checkbox
 */
function modernnews_sanitize_checkbox($checked)
{
    return ((isset($checked) && true == $checked) ? true : false);
}
