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
                    <div class="relative aspect-video overflow-hidden rounded-2xl mb-4 shadow-sm group-hover:shadow-xl transition-shadow duration-500">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="absolute inset-0 z-0">
                                <?php the_post_thumbnail('full', array(
                                    'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.03]',
                                    'fetchpriority' => 'high',
                                    'loading' => 'eager'
                                )); ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>
                            </div>
                        <?php endif; ?>

                        <div class="absolute bottom-6 left-6 right-6 p-8 rounded-2xl bg-black/20 backdrop-blur-md border border-white/10 shadow-2xl transform transition-transform duration-500 group-hover:-translate-y-2">
                            <span
                                class="bg-primary text-white text-[10px] font-bold uppercase px-3 py-1 rounded-full mb-4 inline-block tracking-widest shadow-lg">
                                <?php $cat = get_the_category();
                                echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                            </span>
                            <h2 class="text-white text-3xl xl:text-4xl font-extrabold leading-tight mb-4 group-hover:text-primary transition-colors">
                                <a href="<?php the_permalink(); ?>" class="hover:underline decoration-white/30">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <p class="text-gray-200 line-clamp-2 max-w-2xl text-sm font-medium opacity-90">
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
                        <div class="relative aspect-[16/9] overflow-hidden rounded-2xl mb-3 shadow-sm group-hover:shadow-md transition-shadow duration-500">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title_attribute(); ?>"
                                    class="w-full h-full object-cover group-hover:scale-[1.05] transition-transform duration-700" />
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-500"></div>
                            <?php else: ?>
                                <div class="w-full h-full bg-gray-100 dark:bg-zinc-800"></div>
                            <?php endif; ?>

                            <div class="absolute top-3 left-3">
                                <span class="bg-accent-yellow text-black text-[9px] font-black uppercase px-2 py-1 rounded-lg shadow-sm">
                                    <?php $cat = get_the_category();
                                    echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold leading-tight group-hover:text-primary transition-colors line-clamp-2">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="size-5 rounded-full bg-gray-200 dark:bg-zinc-800 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[12px] text-gray-400">person</span>
                            </div>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">
                                <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' lalu'; ?> • 
                                <span class="text-gray-400"><?php the_author(); ?></span>
                            </p>
                        </div>
                    </div>
                <?php endif;
        endwhile;

        // Close Side Hero Container
        echo '</div>';
        wp_reset_postdata();
    endif;
    ?>
</section>