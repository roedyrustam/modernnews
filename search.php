<?php
/**
 * The template for displaying search results pages
 */

get_header();
?>

<main id="main-content" class="max-w-[1280px] mx-auto w-full px-6 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 mb-10 text-sm">
        <a class="text-gray-500 hover:text-primary transition-colors flex items-center gap-1"
            href="<?php echo esc_url(home_url('/')); ?>">
            <i class="ri-home-4-line"></i> Beranda
        </a>
        <i class="ri-arrow-right-s-line text-gray-300"></i>
        <span class="text-gray-900 dark:text-white font-bold">Hasil Pencarian</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left Content Area -->
        <div class="lg:col-span-8">
            <header class="mb-12">
                <span
                    class="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full mb-4 uppercase tracking-widest">Pencarian</span>
                <h1 class="text-4xl md:text-5xl font-black leading-tight tracking-tight">
                    <?php
                    printf(
                        /* translators: %s: search query. */
                        esc_html__('Hasil untuk: %s', 'modernnews'),
                        '<span class="text-primary italic">"' . get_search_query() . '"</span>'
                    );
                    ?>
                </h1>
                <p class="text-gray-500 mt-4">
                    Ditemukan <?php echo $wp_query->found_posts; ?> berita yang relevan.
                </p>
            </header>

            <?php if (have_posts()): ?>
                <div class="space-y-10">
                    <?php
                    while (have_posts()):
                        the_post();
                        get_template_part('template-parts/content', 'card');
                    endwhile;
                    ?>
                </div>

                <!-- Pagination -->
                <?php if ($wp_query->max_num_pages > 1): ?>
                    <div class="mt-16 pt-10 border-t border-gray-100 dark:border-gray-800">
                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => '<i class="ri-arrow-left-s-line"></i>',
                            'next_text' => '<i class="ri-arrow-right-s-line"></i>',
                        ));
                        ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div
                    class="text-center py-24 bg-gray-50 dark:bg-gray-900 rounded-3xl border-2 border-dashed border-gray-100 dark:border-gray-800">
                    <div
                        class="size-24 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <i class="ri-search-2-line text-4xl text-gray-300"></i>
                    </div>
                    <h2 class="text-2xl font-black mb-4">Tidak Menemukan Apapun</h2>
                    <p class="text-gray-500 max-w-md mx-auto mb-8">
                        Maaf, kami tidak menemukan berita yang cocok dengan kata kunci tersebut. Coba gunakan kata kunci
                        lain.
                    </p>
                    <div class="max-w-md mx-auto">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 space-y-10">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>

<?php get_footer(); ?>