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
                <div id="local-news-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Skeleton Loader -->
                    <?php for ($i = 0; $i < 2; $i++): ?>
                    <div class="animate-pulse flex flex-col gap-4 bg-white/50 dark:bg-white/5 p-4 rounded-2xl">
                        <div class="aspect-video bg-gray-200 dark:bg-gray-800 rounded-xl w-full"></div>
                        <div class="space-y-3">
                            <div class="h-2 bg-gray-200 dark:bg-gray-800 rounded-full w-1/4"></div>
                            <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded-full w-full"></div>
                            <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded-full w-2/3"></div>
                        </div>
                    </div>
                    <?php endfor; ?>
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
                class="mb-12 relative overflow-hidden bg-gradient-to-br from-primary to-[#0f5a6b] rounded-[2rem] p-8 md:p-12 shadow-2xl shadow-primary/20">
                <!-- Decorative circles -->
                <div class="absolute -right-20 -top-20 size-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 size-64 bg-black/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
                    <div class="text-center lg:text-left max-w-xl">
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-white text-[10px] font-black uppercase tracking-widest mb-4">
                            <span class="size-2 bg-accent-yellow rounded-full animate-ping"></span>
                            Exclusive Access
                        </div>
                        <h3 class="text-3xl md:text-4xl font-black text-white mb-4 leading-tight">Morning Briefing</h3>
                        <p class="text-white/80 font-medium text-lg">Dapatkan ringkasan berita terpenting setiap pagi langsung di email Anda.</p>
                    </div>
                    <div class="w-full lg:w-auto">
                        <form class="flex flex-col sm:flex-row w-full lg:w-[450px] gap-3 bg-white/10 backdrop-blur-xl p-2 rounded-2xl border border-white/20">
                            <input class="bg-transparent border-none text-white placeholder-white/60 focus:ring-0 px-4 py-3 flex-1 text-sm font-bold"
                                placeholder="Alamat email Anda..." type="email" required />
                            <button
                                class="bg-white text-primary font-black px-8 py-3 rounded-xl hover:scale-105 active:scale-95 transition-all shadow-xl">Daftar</button>
                        </form>
                        <p class="text-[10px] text-white/50 mt-4 text-center lg:text-left font-medium">Bebas spam. Berhenti berlangganan kapan saja.</p>
                    </div>
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
                            <div class="flex gap-4 items-start group cursor-pointer border-b border-gray-50 dark:border-zinc-800/50 pb-4 last:border-0 last:pb-0">
                                <div class="relative shrink-0">
                                    <span
                                        class="text-4xl font-black text-gray-100 dark:text-zinc-800 leading-none group-hover:text-primary transition-colors select-none">
                                        <?php echo str_pad($t_count, 2, '0', STR_PAD_LEFT); ?>
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <h4
                                        class="font-bold text-sm leading-snug mb-2 group-hover:text-primary transition-colors line-clamp-2">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] bg-gray-100 dark:bg-zinc-800 text-gray-500 dark:text-gray-400 font-black uppercase tracking-widest px-1.5 py-0.5 rounded">
                                            <?php $cat = get_the_category();
                                            echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                                        </span>
                                    </div>
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