<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>

<main id="main-content" class="max-w-[1280px] mx-auto px-6 py-16 md:py-24">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16">
            <div class="relative inline-block mb-8">
                <span
                    class="text-[12rem] font-black text-gray-100 dark:text-gray-800/50 leading-none select-none">404</span>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="ri-error-warning-fill text-6xl text-primary animate-pulse"></i>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-black mb-6">Oops! Halaman Tidak Ditemukan</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto">
                Maaf, halaman yang Anda cari mungkin telah dihapus atau dipindahkan.
                Gunakan pencarian di bawah atau lihat berita populer kami.
            </p>

            <!-- Search Form -->
            <div class="max-w-md mx-auto mb-12">
                <div
                    class="p-1 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                    <?php get_search_form(); ?>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                    class="inline-flex items-center gap-2 bg-primary text-white font-bold py-4 px-8 rounded-xl hover:bg-opacity-90 transition-all shadow-lg shadow-primary/20">
                    <i class="ri-home-4-line"></i>
                    Kembali ke Beranda
                </a>
                <button onclick="history.back()"
                    class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-bold py-4 px-8 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                    <i class="ri-arrow-left-line"></i>
                    Halaman Sebelumnya
                </button>
            </div>
        </div>

        <!-- Latest News as Fallback -->
        <div class="mt-24">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-black">Berita Terkini Untuk Anda</h2>
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"
                    class="text-primary font-bold hover:underline flex items-center gap-1">
                    Lihat Semua <i class="ri-arrow-right-s-line"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $latest_posts = new WP_Query(array(
                    'posts_per_page' => 3,
                    'post_status' => 'publish'
                ));

                if ($latest_posts->have_posts()):
                    while ($latest_posts->have_posts()):
                        $latest_posts->the_post();
                        get_template_part('template-parts/content', 'card');
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
