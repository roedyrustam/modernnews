<?php
/**
 * Template part for displaying the Hero Grid on the homepage
 */
?>
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-12">
    <?php
    // Fetch 3 posts for Hero
    $hero_query = new WP_Query(array(
        'posts_per_page' => 3,
        'ignore_sticky_posts' => 1,
    ));

    if ($hero_query->have_posts()):
        $post_count = 0;
        while ($hero_query->have_posts()):
            $hero_query->the_post();
            $post_count++;

            // Main Hero (First Post)
            if ($post_count === 1):
                ?>
                <div class="lg:col-span-8 group cursor-pointer">
                    <div class="relative aspect-video overflow-hidden rounded-xl mb-4">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="absolute inset-0 z-0">
                                <?php the_post_thumbnail('full', array(
                                    'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105',
                                    'fetchpriority' => 'high',
                                    'loading' => 'eager'
                                )); ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                            </div>
                        <?php endif; ?>

                        <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/90 to-transparent">
                            <span
                                class="bg-primary text-white text-[10px] font-bold uppercase px-2 py-1 rounded mb-3 inline-block tracking-wider">
                                <?php $cat = get_the_category();
                                echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                            </span>
                            <h2 class="text-white text-3xl xl:text-4xl font-extrabold leading-tight mb-3">
                                <a href="<?php the_permalink(); ?>" class="hover:underline decoration-white/50">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <p class="text-gray-300 line-clamp-2 max-w-2xl text-sm font-medium">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Open Side Hero Container -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                <?php else: ?>
                    <!-- Side Hero Items (2 & 3) -->
                    <div class="group cursor-pointer">
                        <div class="relative aspect-[16/9] overflow-hidden rounded-xl mb-3">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title_attribute(); ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <?php else: ?>
                                <div class="w-full h-full bg-gray-200"></div>
                            <?php endif; ?>

                            <div class="absolute top-2 left-2">
                                <span class="bg-accent-yellow text-black text-[10px] font-bold uppercase px-2 py-1 rounded">
                                    <?php $cat = get_the_category();
                                    echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold leading-snug group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="text-xs text-gray-500 mt-2 font-medium">
                            <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' yang lalu'; ?> • Oleh
                            <?php the_author(); ?>
                        </p>
                    </div>
                <?php endif;
        endwhile;

        // Close Side Hero Container
        echo '</div>';
        wp_reset_postdata();
    endif;
    ?>
</section>