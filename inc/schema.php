<?php
/**
 * Modern News Schema.org Implementation
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output Schema.org JSON-LD in wp_head
 */
function modernnews_output_schema()
{
    if (is_single()) {
        modernnews_single_post_schema();
    }
    modernnews_website_schema();
}
add_action('wp_head', 'modernnews_output_schema');

/**
 * NewsArticle Schema for Single Posts
 */
function modernnews_single_post_schema()
{
    global $post;
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'headline' => get_the_title(),
        'image' => array(
            get_the_post_thumbnail_url($post->ID, 'full')
        ),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'author' => array(
            array(
                '@type' => 'Person',
                'name' => get_the_author(),
                'url' => get_author_posts_url(get_the_author_meta('ID'))
            )
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => wp_get_attachment_url(get_theme_mod('custom_logo'))
            )
        ),
        'description' => wp_strip_all_tags(get_the_excerpt()),
        'articleBody' => wp_strip_all_tags($post->post_content),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id' => get_permalink($post->ID)
        )
    );

    echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
}

/**
 * WebSite and Organization Schema
 */
function modernnews_website_schema()
{
    $website_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url(),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => home_url('?s={search_term_string}'),
            'query-input' => 'required name=search_term_string'
        )
    );

    echo '<script type="application/ld+json">' . json_encode($website_schema) . '</script>' . "\n";

    if (is_single() || is_category() || is_archive()) {
        modernnews_breadcrumb_schema();
    }
}

/**
 * BreadcrumbList Schema
 */
function modernnews_breadcrumb_schema()
{
    $items = array();

    // Home
    $items[] = array(
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => home_url()
    );

    if (is_category() || is_single()) {
        $category = get_the_category();
        if ($category) {
            $cat = $category[0];
            $items[] = array(
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $cat->name,
                'item' => get_category_link($cat->term_id)
            );
        }
    }

    if (is_single()) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => 3,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    } elseif (is_archive() && !is_category()) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => 2,
            'name' => get_the_archive_title(),
            'item' => home_url(add_query_arg(NULL, NULL))
        );
    }

    $breadcrumb_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items
    );

    echo '<script type="application/ld+json">' . json_encode($breadcrumb_schema) . '</script>' . "\n";
}
