<?php
/**
 * The template for displaying all single posts (Tailwind "Clean Article" Redesign)
 */

get_header();
?>

<!-- Reading Progress Bar (Sticky Top) -->
<?php if (modernnews_get_option('single_show_progress_bar', true)): ?>
<div id="reading-progress-container"
    class="fixed top-0 left-0 w-full h-1 z-[60] bg-[#d1e2e6] dark:bg-gray-800 transition-all duration-300">
    <div id="reading-progress-bar" class="h-full bg-primary" style="width: 0%;"></div>
</div>
<?php endif; ?>

<main id="main-content" class="max-w-[1200px] mx-auto px-4 lg:px-10 py-8">

    <?php while (have_posts()):
        the_post();

        // Social Share Buttons (Floating/Fixed)
        get_template_part('template-parts/social-share');
        ?>

        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 mb-6 text-sm">
            <a class="text-primary font-medium hover:underline" href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
            <span class="text-gray-400 material-symbols-outlined text-xs">chevron_right</span>
            <?php
            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<a class="text-primary font-medium hover:underline" href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                echo '<span class="text-gray-400 material-symbols-outlined text-xs">chevron_right</span>';
            }
            ?>
            <span class="text-gray-500 dark:text-gray-400 line-clamp-1"><?php the_title(); ?></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Main Content -->
            <article id="post-<?php the_ID(); ?>" class="lg:col-span-8">

                <!-- Category Label -->
                <span
                    class="inline-block bg-accent-yellow text-black text-[10px] font-black uppercase px-2 py-0.5 rounded-sm mb-4">
                    <?php $cat = get_the_category();
                    echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                </span>

                <h1 class="text-4xl md:text-5xl font-extrabold leading-[1.1] tracking-tight mb-6">
                    <?php the_title(); ?>
                </h1>

                <!-- Author & Meta -->
                <div class="flex items-center justify-between border-y border-gray-100 dark:border-gray-800 py-6 mb-8">
                    <div class="flex items-center gap-4">
                        <?php if (modernnews_get_option('single_show_author_meta', true)): ?>
                        <div class="size-12 rounded-full overflow-hidden bg-gray-200">
                            <?php echo get_avatar(get_the_author_meta('ID'), 96, '', '', array('class' => 'w-full h-full object-cover')); ?>
                        </div>
                        <?php endif; ?>
                        <div>
                            <?php if (modernnews_get_option('single_show_author_meta', true)): ?>
                            <p class="font-bold text-base"><?php the_author(); ?></p>
                            <?php endif; ?>
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                <span><?php echo get_the_date(); ?></span>
                                <?php if (get_the_modified_time('U') > get_the_time('U') + 86400): ?>
                                    <span class="text-xs text-gray-400">• Diperbarui:
                                        <?php echo get_the_modified_date(); ?></span>
                                <?php endif; ?>
                                <?php if (modernnews_get_option('single_show_reading_time', true)): ?>
                                <span>•</span>
                                <?php if (function_exists('modernnews_estimated_reading_time')) {
                                    echo modernnews_estimated_reading_time();
                                } ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <button
                        class="border border-primary text-primary px-4 py-1.5 rounded-lg text-sm font-bold hover:bg-primary hover:text-white transition-all">
                        Ikuti
                    </button>
                </div>

                <!-- Hero Image -->
                <?php if (has_post_thumbnail()): ?>
                    <figure class="mb-10">
                        <div class="aspect-[16/9] w-full bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden mb-3">
                            <?php the_post_thumbnail('full', array(
                                'class' => 'w-full h-full object-cover',
                                'fetchpriority' => 'high',
                                'loading' => 'eager'
                            )); ?>
                        </div>
                        <?php if (get_the_post_thumbnail_caption()): ?>
                            <figcaption class="text-sm text-gray-500 italic leading-relaxed">
                                <?php the_post_thumbnail_caption(); ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>

                <!-- Mobile Share Buttons (handled by template-parts/social-share.php) -->

                <!-- Article Body -->
                <div
                    class="entry-content prose prose-lg dark:prose-invert max-w-none leading-relaxed text-gray-800 dark:text-gray-200">
                    <?php
                    // Top Ad (Before Content)
                    if (function_exists('modernnews_get_ad')) {
                        $ad_top = modernnews_get_ad('single_before_ad');
                        if (!empty($ad_top)) {
                            echo '<div class="modernnews-ad-single-top my-8 flex justify-center">';
                            echo $ad_top;
                            echo '</div>';
                        }
                    }
                    ?>

                    <?php the_content(); ?>

                    <?php
                    // Bottom Ad (After Content)
                    if (function_exists('modernnews_get_ad')) {
                        $ad_bottom = modernnews_get_ad('single_after_ad');
                        if (!empty($ad_bottom)) {
                            echo '<div class="modernnews-ad-single-bottom my-8 flex justify-center">';
                            echo $ad_bottom;
                            echo '</div>';
                        }
                    }
                    ?>

                    <!-- Tags & Engagement -->
                    <div class="flex flex-wrap gap-2 mt-12 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <?php
                        $tags = get_the_tags();
                        if ($tags) {
                            foreach ($tags as $tag) {
                                echo '<a class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full text-xs font-semibold hover:bg-primary hover:text-white transition-all" href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . esc_html($tag->name) . '</a>';
                            }
                        }
                        ?>
                    </div>

                    <!-- Newsletter -->
                    <div class="mt-12 bg-primary p-8 rounded-2xl text-white flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-bold mb-2">Jangan Lewatkan Berita Penting</h3>
                            <p class="text-white/80">Dapatkan ringkasan berita terbaik langsung di inbox Anda setiap pagi.
                            </p>
                        </div>
                        <div class="w-full md:w-auto flex gap-2">
                            <input
                                class="rounded-lg border-none text-black px-4 py-2.5 w-full md:w-64 focus:ring-2 focus:ring-accent-yellow"
                                placeholder="Email Anda" type="email" />
                            <button
                                class="bg-accent-yellow text-black font-bold px-6 py-2.5 rounded-lg hover:opacity-90 transition-opacity whitespace-nowrap">Daftar</button>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <?php
                    if (comments_open() || get_comments_number()):
                        comments_template();
                    endif;
                    ?>


            </article>

            <!-- Sidebar Right (Trending) -->
            <?php get_sidebar(); ?>
        </div>

        <!-- Related News Section -->
        <?php if (modernnews_get_option('single_show_related_posts', true)): 
            $related_count = (int) modernnews_get_option('single_related_posts_count', 3);
            ?>
        <section class="mt-20 border-t border-gray-100 dark:border-gray-800 pt-16 pb-20">
            <h3 class="text-2xl font-black mb-10 flex items-center gap-3">
                <span class="w-8 h-1 bg-primary rounded-full"></span>
                Berita Terkait
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $orig_post = $post;
                global $post;

                // Logic: 1. Try Tags first (more relevant)
                $tags = get_the_tags($post->ID);
                $tag_ids = array();
                $rel_query = false;

                if ($tags) {
                    foreach ($tags as $tag)
                        $tag_ids[] = $tag->term_id;
                    $args = array(
                        'tag__in' => $tag_ids,
                        'post__not_in' => array($post->ID),
                        'posts_per_page' => $related_count,
                        'ignore_sticky_posts' => 1
                    );
                    $rel_query = new WP_Query($args);
                }

                // Logic: 2. Fallback to Categories if no tag matches
                if (!$rel_query || !$rel_query->have_posts()) {
                    $cats = get_the_category($post->ID);
                    if ($cats) {
                        $c_ids = array();
                        foreach ($cats as $i)
                            $c_ids[] = $i->term_id;
                        $args = array(
                            'category__in' => $c_ids,
                            'post__not_in' => array($post->ID),
                            'posts_per_page' => $related_count,
                            'ignore_sticky_posts' => 1
                        );
                        $rel_query = new WP_Query($args);
                    }
                }

                // Output Loop
                if ($rel_query && $rel_query->have_posts()) {
                    while ($rel_query->have_posts()):
                        $rel_query->the_post(); ?>
                        <div class="group cursor-pointer">
                            <div class="aspect-video w-full rounded-xl overflow-hidden mb-4 relative">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <span class="material-symbols-outlined text-4xl">image</span>
                                    </div>
                                <?php endif; ?>
                                <span
                                    class="absolute top-3 left-3 bg-white/90 dark:bg-black/90 px-2 py-1 rounded text-[10px] font-black uppercase shadow-sm">
                                    <?php $cat = get_the_category();
                                    echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                                </span>
                            </div>
                            <h4 class="font-bold text-lg leading-tight group-hover:text-primary transition-colors">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <p class="text-xs text-gray-500 mt-2 font-medium">
                                <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' yang lalu'; ?>
                            </p>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                } else {
                    echo '<p class="col-span-full text-center text-gray-500 italic">Tidak ada berita terkait saat ini.</p>';
                }
                $post = $orig_post;
                ?>
            </div>
        </section>
        <?php endif; ?>

    <?php endwhile; // End of the loop. ?>

</main>

<?php
// JSON-LD Schema for NewsArticle
if (is_single() && have_posts()):
    while (have_posts()):
        the_post();
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => get_the_title(),
            'image' => has_post_thumbnail() ? [get_the_post_thumbnail_url(null, 'full')] : [],
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => get_the_author()
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => get_template_directory_uri() . '/assets/images/logo.png' // Placeholder or dynamic if option exists
                ]
            ],
            'description' => get_the_excerpt()
        ];
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    endwhile;
endif;
?>

<?php get_footer(); ?>