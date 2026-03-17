<?php
/**
 * Template part for displaying Category Spotlight section on the homepage
 */
?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <!-- Column 1: Teknologi -->
    <div>
        <h2
            class="text-xl font-black mb-4 flex items-center gap-2 border-b-2 border-gray-100 dark:border-gray-800 pb-2">
            <span class="text-blue-500 material-symbols-outlined">memory</span>
            Teknologi
        </h2>
        <?php
        $tech_query = new WP_Query(array(
            'category_name' => 'teknologi',
            'posts_per_page' => 3,
            'ignore_sticky_posts' => 1
        ));

        if (!$tech_query->have_posts()) {
            $tech_query = new WP_Query(array('posts_per_page' => 3, 'offset' => 4, 'ignore_sticky_posts' => 1));
        }

        if ($tech_query->have_posts()):
            $c = 0;
            while ($tech_query->have_posts()):
                $tech_query->the_post();
                $c++;
                if ($c === 1): ?>
                    <div class="mb-4 group cursor-pointer">
                        <div class="aspect-video rounded-xl overflow-hidden mb-3 bg-gray-100 dark:bg-gray-800">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <?php endif; ?>
                        </div>
                        <h3 class="font-bold text-lg leading-snug group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                    </div>
                <?php else: ?>
                    <div class="flex items-start gap-3 mb-3 last:mb-0 group cursor-pointer">
                        <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-gray-100 dark:bg-gray-800">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" class="w-full h-full object-cover" />
                            <?php endif; ?>
                        </div>
                        <h4 class="font-bold text-sm leading-snug group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h4>
                    </div>
                <?php endif;
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

    <!-- Column 2: Gaya Hidup -->
    <div>
        <h2
            class="text-xl font-black mb-4 flex items-center gap-2 border-b-2 border-gray-100 dark:border-gray-800 pb-2">
            <span class="text-pink-500 material-symbols-outlined">diamond</span>
            Gaya Hidup
        </h2>
        <?php
        $style_query = new WP_Query(array(
            'category_name' => 'gaya-hidup',
            'posts_per_page' => 3,
            'ignore_sticky_posts' => 1
        ));
        if (!$style_query->have_posts()) {
            $style_query = new WP_Query(array('posts_per_page' => 3, 'offset' => 7, 'ignore_sticky_posts' => 1));
        }

        if ($style_query->have_posts()):
            $c = 0;
            while ($style_query->have_posts()):
                $style_query->the_post();
                $c++;
                if ($c === 1): ?>
                    <div class="mb-4 group cursor-pointer">
                        <div class="aspect-video rounded-xl overflow-hidden mb-3 bg-gray-100 dark:bg-gray-800">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <?php endif; ?>
                        </div>
                        <h3 class="font-bold text-lg leading-snug group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                    </div>
                <?php else: ?>
                    <div class="flex items-start gap-3 mb-3 last:mb-0 group cursor-pointer">
                        <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-gray-100 dark:bg-gray-800">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" class="w-full h-full object-cover" />
                            <?php endif; ?>
                        </div>
                        <h4 class="font-bold text-sm leading-snug group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h4>
                    </div>
                <?php endif;
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</div>