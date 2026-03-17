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
                <div class="group cursor-pointer bg-white dark:bg-zinc-900 rounded-2xl p-4 border border-gray-100 dark:border-zinc-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500">
                    <div class="aspect-[4/3] rounded-xl overflow-hidden mb-4 relative bg-gray-100 dark:bg-zinc-800">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <span
                            class="absolute top-3 left-3 bg-black/70 text-white text-[9px] font-black uppercase px-2.5 py-1 rounded-lg backdrop-blur-md border border-white/10 shadow-lg tracking-wider">
                            <?php $cat = get_the_category();
                            echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                        </span>
                    </div>
                    <h3 class="font-bold text-base leading-snug group-hover:text-primary transition-colors mb-3 line-clamp-2">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-50 dark:border-zinc-800">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                            <?php echo get_the_date('d M Y'); ?>
                        </span>
                        <span class="material-symbols-outlined text-gray-300 text-sm group-hover:text-primary group-hover:translate-x-1 transition-all">arrow_forward</span>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>