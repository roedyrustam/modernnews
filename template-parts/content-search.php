<?php
/**
 * Template part for displaying results in search pages
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('flex flex-col md:flex-row gap-6 group'); ?>>
    <!-- Thumbnail -->
    <?php if (has_post_thumbnail()): ?>
        <a href="<?php the_permalink(); ?>"
            class="shrink-0 w-full md:w-[240px] aspect-video md:aspect-[4/3] rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 relative">
            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
    <?php else: ?>
        <a href="<?php the_permalink(); ?>"
            class="shrink-0 w-full md:w-[240px] aspect-video md:aspect-[4/3] rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-300">
            <span class="material-symbols-outlined text-4xl">image</span>
        </a>
    <?php endif; ?>

    <!-- Content -->
    <div class="flex-1 flex flex-col justify-center">
        <header class="mb-3">
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="font-bold text-primary hover:underline">' . esc_html($categories[0]->name) . '</a>';
                    echo '<span class="text-gray-300">•</span>';
                }
                ?>
                <span>
                    <?php
                    // Use standard date if time diff is weird or for archives
                    echo get_the_date();
                    ?>
                </span>
            </div>
            <h2 class="text-xl font-bold leading-tight mb-2 group-hover:text-primary transition-colors">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>
        </header>
        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 md:line-clamp-3 mb-4">
            <?php echo get_the_excerpt(); ?>
        </p>
    </div>
</article>