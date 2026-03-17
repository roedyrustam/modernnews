<?php
/**
 * Template part for displaying Editor's Picks on the homepage
 */
?>
<section class="mb-14 border-b border-gray-100 dark:border-gray-800 pb-10">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-black border-l-4 border-primary pl-4">Pilihan Redaksi</h2>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-8">
        <?php
        // Try to get 'Pilihan Redaksi' or 'Editor's Picks' category
        $editors_query = new WP_Query(array(
            'category_name' => 'pilihan-redaksi',
            'posts_per_page' => 4,
            'ignore_sticky_posts' => 1
        ));

        // Fallback: Latest Posts offset after Hero (3)
        if (!$editors_query->have_posts()) {
            $editors_query = new WP_Query(array(
                'posts_per_page' => 4,
                'ignore_sticky_posts' => 1,
                'offset' => 3
            ));
        }

        if ($editors_query->have_posts()):
            while ($editors_query->have_posts()):
                $editors_query->the_post();
                ?>
                <div class="group cursor-pointer">
                    <div class="aspect-[4/3] rounded-xl overflow-hidden mb-4 relative bg-gray-100 dark:bg-gray-800">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                        <?php endif; ?>
                        <span
                            class="absolute top-2 left-2 bg-black/80 text-white text-[9px] font-bold uppercase px-2 py-1 rounded backdrop-blur-sm">
                            <?php $cat = get_the_category();
                            echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                        </span>
                    </div>
                    <h3 class="font-bold text-base leading-snug group-hover:text-primary transition-colors mb-2">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <p class="text-xs text-gray-500">
                        <?php echo get_the_date(); ?>
                    </p>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>