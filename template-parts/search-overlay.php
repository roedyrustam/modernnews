<?php
/**
 * Modern Search Overlay Template
 */
?>
<!-- Search Overlay Container (Hidden by default) -->
<div id="modernnews-search-overlay"
    class="fixed inset-0 z-[100] bg-white dark:bg-[#1f2b2e] hidden flex-col overflow-y-auto overflow-x-hidden transition-opacity duration-300 opacity-0">

    <!-- Header / Top Navigation -->
    <header
        class="sticky top-0 z-50 bg-white/90 dark:bg-[#1f2b2e]/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 px-6 lg:px-20 py-4 shrink-0">
        <div class="max-w-[1200px] mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3 text-primary">
                <div class="size-8 flex items-center justify-center bg-primary rounded-lg text-white">
                    <span class="material-symbols-outlined text-2xl">newspaper</span>
                </div>
                <h2 class="text-gray-900 dark:text-white text-xl font-bold tracking-tight">
                    <?php bloginfo('name'); ?>
                </h2>
            </div>
            <button id="modernnews-search-close"
                class="group flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white transition-all duration-200">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>
    </header>

    <!-- Search Content Area -->
    <main class="flex-1 flex justify-center py-8 lg:py-16 px-6">
        <div class="w-full max-w-[960px] flex flex-col gap-10">

            <!-- Large Search Input Section -->
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="flex flex-col gap-4">
                <h1 class="text-gray-900 dark:text-white text-3xl lg:text-4xl font-bold text-center mb-2">Apa yang ingin
                    Anda baca hari ini?</h1>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-primary">
                        <span class="material-symbols-outlined text-3xl">search</span>
                    </div>
                    <input name="s" id="modernnews-search-input"
                        class="w-full h-20 pl-16 pr-6 bg-gray-50 dark:bg-gray-800/50 border-2 border-transparent focus:border-primary/50 focus:ring-0 rounded-2xl text-2xl text-gray-900 dark:text-white placeholder:text-gray-400 transition-all shadow-sm"
                        placeholder="Cari berita, topik, atau tren terbaru..." type="text" autocomplete="off" />
                    <div
                        class="absolute right-6 top-1/2 -translate-y-1/2 hidden lg:flex items-center gap-2 text-gray-400 text-xs font-medium uppercase tracking-widest">
                        <span>Tekan</span>
                        <span
                            class="px-2 py-1 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded">Enter</span>
                    </div>
                </div>
            </form>

            <!-- Trending & Filtered Results -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Left Column: Trending & Categories -->
                <div class="lg:col-span-4 flex flex-col gap-10">

                    <!-- Trending Section -->
                    <section>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-primary text-xl">trending_up</span>
                            <h3 class="text-gray-900 dark:text-white text-sm font-bold uppercase tracking-widest">Sedang
                                Populer</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 6));
                            if ($tags) {
                                foreach ($tags as $tag) {
                                    echo '<a class="px-4 py-2 bg-primary/10 hover:bg-primary hover:text-white text-primary text-sm font-semibold rounded-lg transition-colors" href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a>';
                                }
                            } else {
                                echo '<span class="text-sm text-gray-500">Belum ada topik populer.</span>';
                            }
                            ?>
                        </div>
                    </section>

                    <!-- Categories Section -->
                    <section>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-primary text-xl">grid_view</span>
                            <h3 class="text-gray-900 dark:text-white text-sm font-bold uppercase tracking-widest">
                                Kategori Utama</h3>
                        </div>
                        <ul class="flex flex-col gap-1">
                            <?php
                            $categories = get_categories(array('number' => 5, 'orderby' => 'count', 'order' => 'DESC'));
                            foreach ($categories as $category) {
                                ?>
                                <li>
                                    <a class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 group transition-colors"
                                        href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                        <span class="text-gray-700 dark:text-gray-300 group-hover:text-primary font-medium">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                        <span
                                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform">chevron_right</span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </section>

                    <!-- Geo-targeting Hint (Static for now, could be dynamic later) -->
                    <div class="p-4 bg-primary/5 border border-primary/20 rounded-xl hidden md:block">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary">location_on</span>
                            <div>
                                <p class="text-xs font-bold text-primary uppercase">Lokal</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Temukan berita terkini dari
                                    wilayah sekitar Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Results Categorized (Initial State: Recent News) -->
                <div class="lg:col-span-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-xl">article</span>
                            <h3 class="text-gray-900 dark:text-white text-sm font-bold uppercase tracking-widest">Berita
                                Terbaru</h3>
                        </div>
                    </div>

                    <div class="flex flex-col gap-6">
                        <?php
                        $recent_query = new WP_Query(array('posts_per_page' => 3, 'ignore_sticky_posts' => 1));
                        if ($recent_query->have_posts()):
                            while ($recent_query->have_posts()):
                                $recent_query->the_post();
                                ?>
                                <article class="group cursor-pointer">
                                    <a href="<?php the_permalink(); ?>" class="flex gap-5">
                                        <div
                                            class="w-32 h-24 shrink-0 overflow-hidden rounded-xl bg-gray-200 dark:bg-gray-700 relative">
                                            <?php if (has_post_thumbnail()): ?>
                                                <img src="<?php the_post_thumbnail_url('thumbnail'); ?>"
                                                    alt="<?php the_title_attribute(); ?>"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <span class="material-symbols-outlined">image</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex flex-col justify-center gap-1">
                                            <div class="flex items-center gap-2 text-[10px] font-bold text-primary uppercase">
                                                <span>
                                                    <?php
                                                    $cat = get_the_category();
                                                    echo !empty($cat) ? esc_html($cat[0]->name) : 'News';
                                                    ?>
                                                </span>
                                                <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                                                <span class="text-gray-500">
                                                    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' lalu'; ?>
                                                </span>
                                            </div>
                                            <h4
                                                class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                                <?php the_title(); ?>
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1 block">
                                                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                            </p>
                                        </div>
                                    </a>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            echo '<p>Belum ada berita terbaru.</p>';
                        endif;
                        ?>
                    </div>

                    <!-- See All Results CTA -->
                    <!-- <div class="mt-10 pt-6 border-t border-gray-100 dark:border-gray-800">
                        <a href="<?php // echo get_post_type_archive_link('post'); ?>" class="w-full py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                            Lihat Arsip Berita
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Overlay Info -->
    <footer class="py-6 px-10 text-center shrink-0">
        <p class="text-xs text-gray-400 font-medium">&copy;
            <?php echo date('Y'); ?>
            <?php bloginfo('name'); ?>. Menampilkan konten berita terverifikasi dari seluruh penjuru Nusantara.
        </p>
    </footer>
</div>