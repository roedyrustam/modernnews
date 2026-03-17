<?php
/**
 * Template part for displaying the dynamic homepage layout (Tailwind Redesign)
 */
?>

<div class="max-w-[1280px] mx-auto px-4 lg:px-10 py-8">

    <!-- Hero Grid Section -->
    <?php get_template_part('template-parts/home/hero-grid'); ?>

    <!-- Editor's Picks Section -->
    <?php get_template_part('template-parts/home/editors-picks'); ?>

    <!-- Main Content Area with Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Primary Column -->
        <div class="lg:col-span-8">

            <!-- Category Section: News Near You (AJAX Placeholder) -->
            <div id="local-news-container"
                class="mb-12 bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 border border-gray-100 dark:border-gray-800">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">location_on</span>
                        <h2 class="text-xl font-extrabold tracking-tight local-news-title">Kabar dari <span>...</span>
                            (Sekitarmu)</h2>
                    </div>
                    <!-- <a class="text-primary text-xs font-bold uppercase flex items-center gap-1" href="#">Lainnya <span class="material-symbols-outlined text-sm">chevron_right</span></a> -->
                </div>
                <!-- ID for AJAX content to populate -->
                <div id="local-news-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Content loaded via main.js -->
                    <div class="loading-placeholder w-full col-span-2 text-center py-8 text-gray-400">Loading Local
                        News...</div>
                </div>
            </div>

            <!-- Section: Quick Read (Sekilas Info) -->
            <?php get_template_part('template-parts/home/quick-read'); ?>

            <!-- Section: Category Spotlight (Teknologi & Gaya Hidup) -->
            <?php get_template_part('template-parts/home/category-spotlight'); ?>

            <!-- Latest News Stream -->
            <?php get_template_part('template-parts/home/latest-stream'); ?>

            <!-- Newsletter / Ad Slot -->
            <div
                class="mb-12 bg-primary/10 border border-primary/20 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <h3 class="text-2xl font-extrabold mb-2">Morning Briefing</h3>
                    <p class="text-gray-600 dark:text-gray-400 font-medium">Dapatkan ringkasan berita terpenting setiap
                        pagi langsung di email Anda.</p>
                </div>
                <div class="flex w-full md:w-auto gap-2">
                    <input class="rounded-lg border-gray-200 dark:bg-gray-800 dark:border-gray-700 flex-1 md:w-64"
                        placeholder="Email Anda" type="email" />
                    <button
                        class="bg-primary text-white font-bold px-6 py-2 rounded-lg hover:brightness-110">Daftar</button>
                </div>
            </div>
        </div>

        <!-- Sidebar (Custom for Homepage) -->
        <aside id="secondary" class="widget-area lg:col-span-4 space-y-8">

            <!-- Trending / Terpopuler Section -->
            <div
                class="bg-white dark:bg-zinc-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm sticky top-24">
                <h3
                    class="text-xl font-black mb-6 flex items-center gap-2 border-b-2 border-gray-100 dark:border-gray-800 pb-3">
                    <span class="text-red-500 material-symbols-outlined">trending_up</span>
                    Sedang Hangat
                </h3>
                <div class="flex flex-col gap-6">
                    <?php
                    $trending = new WP_Query(array(
                        'posts_per_page' => 5,
                        'ignore_sticky_posts' => 1,
                        'orderby' => 'comment_count',
                        'order' => 'DESC'
                    ));

                    if (!$trending->have_posts()) {
                        // Fallback to random or latest if no comments
                        $trending = new WP_Query(array(
                            'posts_per_page' => 5,
                            'ignore_sticky_posts' => 1,
                            'orderby' => 'rand'
                        ));
                    }

                    $t_count = 1;
                    if ($trending->have_posts()):
                        while ($trending->have_posts()):
                            $trending->the_post();
                            ?>
                            <div class="flex gap-4 items-start group cursor-pointer">
                                <span
                                    class="text-4xl font-black text-gray-200 dark:text-gray-700 leading-[0.8] group-hover:text-primary transition-colors -mt-1 select-none">
                                    <?php echo str_pad($t_count, 2, '0', STR_PAD_LEFT); ?>
                                </span>
                                <div>
                                    <h4
                                        class="font-bold text-sm leading-snug mb-1 group-hover:text-primary transition-colors line-clamp-2">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                                        <?php $cat = get_the_category();
                                        echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                            $t_count++;
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

            <!-- Standard Widgets -->
            <?php
            if (function_exists('modernnews_get_ad')) {
                echo modernnews_get_ad('sidebar_ad');
            }
            ?>
            <?php dynamic_sidebar('main-sidebar'); ?>
        </aside>
    </div>
</div>