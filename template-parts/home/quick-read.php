<?php
/**
 * Template part for displaying Quick Read section on the homepage
 */
?>
<div class="mb-12 bg-white dark:bg-zinc-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6">
    <h2 class="text-xl font-extrabold mb-6 flex items-center gap-2">
        <span class="material-symbols-outlined text-accent-yellow">flash_on</span>
        Sekilas Info
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
        <?php
        $quick_query = new WP_Query(array(
            'posts_per_page' => 6,
            'ignore_sticky_posts' => 1,
            'offset' => 10
        ));

        if ($quick_query->have_posts()):
            while ($quick_query->have_posts()):
                $quick_query->the_post();
                ?>
                <article
                    class="flex items-start gap-3 group cursor-pointer border-b border-gray-100 dark:border-gray-800 pb-3 last:border-0 last:pb-0">
                    <span class="material-symbols-outlined text-gray-300 text-sm mt-0.5">rss_feed</span>
                    <div>
                        <h3 class="font-bold text-sm leading-snug group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <span class="text-[10px] text-gray-400">
                            <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' yang lalu'; ?>
                        </span>
                    </div>
                </article>
            <?php endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</div>