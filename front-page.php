<?php
/**
 * The template for displaying the front page
 * 
 * Contains logic to switch between Page Builder content and Dynamic News Layout
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    // Logic: 
    // 1. If 'Your homepage displays' is set to 'A static page' AND that page has content, show the content (Page Builder support).
    // 2. Otherwise (empty content or 'Your latest posts'), show the Custom Dynamic News Layout.
    
    $show_dynamic_layout = true;

    if ('page' === get_option('show_on_front') && have_posts()) {
        while (have_posts()) {
            the_post();
            // Check if content is not empty (ignoring whitespace)
            if (!empty(get_the_content())) {
                $show_dynamic_layout = false;
                ?>
                <div class="page-builder-content">
                    <?php the_content(); ?>
                </div>
                <?php
            }
        }
    }

    if ($show_dynamic_layout) {
        get_template_part('template-parts/home/content', 'dynamic');
    }
    ?>

</main><!-- #main -->

<?php
get_footer();
