<?php
/**
 * The template for displaying archive pages (Tailwind Redesign)
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
        <span class="text-gray-900 dark:text-white font-bold"><?php the_archive_title(); ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left Content Area -->
        <div class="lg:col-span-8">
            <!-- Page Heading Container -->
            <div class="relative mb-12 p-8 md:p-12 rounded-3xl bg-gray-50 dark:bg-gray-800/50 overflow-hidden">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 size-64 bg-primary/10 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-xl">
                        <span
                            class="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full mb-4 uppercase tracking-widest">Arsip
                            Berita</span>
                        <h1 class="text-4xl md:text-5xl font-black mb-4 leading-tight tracking-tight">
                            <?php the_archive_title(); ?>
                        </h1>
                        <?php if (get_the_archive_description()): ?>
                            <div class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
                                <?php the_archive_description(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (have_posts()): ?>
                <input type="hidden" id="current-archive-cat" value="<?php echo get_query_var('cat'); ?>">
                <?php 
                $archive_layout = modernnews_get_option('archive_layout', 'list');
                $container_class = ($archive_layout === 'grid') ? 'grid grid-cols-1 md:grid-cols-2 gap-8' : 'space-y-10';
                ?>
                <div id="modernnews-archive-posts-container" class="<?php echo esc_attr($container_class); ?>">
                    <?php
                    while (have_posts()):
                        the_post();
                        // For grid layout, we might want to pass a flag or use a different template part if needed,
                        // but here we'll assume content-card can handle both or we adjust its classes.
                        get_template_part('template-parts/content', 'card', ['layout' => $archive_layout]);
                    endwhile;
                    ?>
                </div>

                <!-- Load More / Pagination -->
                <?php if ($wp_query->max_num_pages > 1): ?>
                    <div class="mt-16 flex justify-center">
                        <button id="modernnews-load-more" data-page="1" data-max-page="<?php echo $wp_query->max_num_pages; ?>"
                            class="group relative inline-flex items-center gap-3 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white px-10 py-4 rounded-2xl font-bold transition-all hover:border-primary hover:shadow-xl hover:shadow-primary/5 active:scale-95">
                            <span>Muat Berita Lainnya</span>
                            <i class="ri-refresh-line text-lg group-hover:rotate-180 transition-transform duration-500"
                                id="load-more-spinner"></i>
                        </button>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="text-center py-20 bg-gray-50 dark:bg-gray-900 rounded-3xl">
                    <i class="ri-article-line text-6xl text-gray-200 mb-4 block"></i>
                    <p class="text-gray-500 text-xl font-medium">Belum ada berita dalam kategori ini.</p>
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