<?php
/**
 * Template Name: Regional News
 *
 * The template for displaying the Regional News page (Tailwind Redesign)
 */

get_header();
?>

<main class="max-w-[1280px] mx-auto px-6 py-8">

    <!-- Geo-Targeting Section -->
    <section class="mb-12">
        <div
            class="bg-surface-light dark:bg-regional-surface-dark rounded-3xl p-8 border border-gray-100 dark:border-gray-800 flex flex-col md:flex-row gap-12 items-center">
            <div class="flex-1 space-y-6">
                <div>
                    <span
                        class="inline-block bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold mb-4">GEO-TARGETING</span>
                    <h1 class="text-4xl md:text-5xl font-black leading-tight tracking-tight">Eksplorasi
                        Berita<br /><span class="text-primary">Berdasarkan Wilayah</span></h1>
                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg leading-relaxed">Dapatkan informasi terkini
                        yang relevan dengan lokasi Anda. Pilih provinsi melalui peta atau daftar drop-down.</p>
                </div>
                <!-- Province Selector Form -->
                <form action="<?php echo esc_url(get_permalink()); ?>" method="get"
                    class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[240px]">
                        <p class="text-sm font-bold mb-2">Pilih Provinsi</p>
                        <div class="relative">
                            <?php
                            $selected_region = isset($_GET['region']) ? sanitize_text_field($_GET['region']) : '';
                            $regions = ['Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Bali', 'Sumatera Utara', 'Sulawesi Selatan', 'Kalimantan Timur'];
                            ?>
                            <select name="region"
                                class="w-full bg-white dark:bg-regional-bg-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 appearance-none focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                <option value="" <?php selected($selected_region, ''); ?>>Semua Wilayah</option>
                                <?php foreach ($regions as $region): ?>
                                    <option value="<?php echo esc_attr($region); ?>" <?php selected($selected_region, $region); ?>><?php echo esc_html($region); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">expand_more</span>
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-primary text-white h-[50px] px-8 rounded-xl font-bold flex items-center gap-2 hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[20px]">filter_list</span>
                        Filter Wilayah
                    </button>
                    <button type="button" onclick="if(typeof getUserLocation === 'function') getUserLocation();"
                        class="bg-gray-100 dark:bg-gray-800 text-text-dark dark:text-white h-[50px] px-6 rounded-xl font-bold flex items-center gap-2 hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[20px]">near_me</span>
                    </button>
                </form>
            </div>

            <!-- Interactive Map Placeholder -->
            <div class="flex-1 w-full max-w-[500px]">
                <div class="relative group cursor-crosshair">
                    <div
                        class="w-full aspect-square bg-white dark:bg-regional-bg-dark rounded-2xl border border-gray-200 dark:border-gray-700 p-4 shadow-xl overflow-hidden">
                        <!-- Map Image Placeholder -->
                        <div class="w-full h-full bg-cover bg-center rounded-lg grayscale group-hover:grayscale-0 transition-all duration-700 opacity-80 group-hover:opacity-100"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBgN97GBSMb7HDFnwokVpdwSvuMTo9NwixsvmnGK0Y9OULO-eFblZ-bym3VsF4FMBRaw7SFGYVa_2Fig7fFH2v1oW8Z-QeWmgAyOC0CRbTTtF4DbWUbczwJDAyM6Hyzw_6E7rqxZ8h4-4-5VCJwBK4SLcnLCcRcUBT9AWn3jZqOdHD90IgvbT3lRmWbiYxX7rbVotDv8sQy3ZmmC6v-3WgIogsLCDzm98E3CF9XAXGWObHFvM5IY8uxJygOSwLF6kux-_GSXiwBWe8');">
                        </div>
                        <!-- Overlay Pin (Static for visual) -->
                        <div
                            class="absolute top-1/2 left-1/3 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                            <div class="bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-lg mb-1">
                                INDONESIA</div>
                            <div class="w-3 h-3 bg-primary border-2 border-white rounded-full animate-bounce"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- News Feed -->
        <div class="lg:col-span-8 space-y-10">
            <!-- Region Headline -->
            <div class="flex flex-wrap items-center justify-between border-b-4 border-primary pb-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-3xl">location_on</span>
                    <h2 class="text-3xl font-black tracking-tight">
                        <?php echo $selected_region ? 'Berita: ' . esc_html($selected_region) : 'Berita Regional Terkini'; ?>
                    </h2>
                </div>
                <a href="<?php echo esc_url(home_url('/category/regional')); ?>"
                    class="text-sm font-bold text-primary flex items-center gap-1 hover:underline">
                    Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <?php
            // Custom Query for Regional News
            $args = array(
                'posts_per_page' => 10, // Increased to 10 for better listing
                'post_status' => 'publish'
            );

            if (!empty($selected_region)) {
                // Assuming regions are used as Tags or Search Terms
                // Try searching by Tag Slug first
                $tag_slug = sanitize_title($selected_region); // e.g. Jawa Barat -> jawa-barat
                $args['tag'] = $tag_slug;

                // Optional: Fallback to s (search) if tagging isn't strict? 
                // For now, let's assume strictly tags for cleaner filtering.
            } else {
                // Default: Show 'regional' category or just latest posts if not using that category
                $args['category_name'] = 'regional';
            }

            $regional_query = new WP_Query($args);

            // Fallback: If no posts found in 'regional' category (or specific region), show latest global posts but warn?
            // Or just show latest posts to populate the page.
            if (!$regional_query->have_posts()) {
                // If specific region yielded no results
                if (!empty($selected_region)) {
                    echo '<div class="p-4 bg-yellow-50 text-yellow-800 rounded-lg mb-6">Belum ada berita spesifik untuk wilayah ini. Berikut adalah berita terkini lainnya.</div>';
                }

                // Fallback Query
                $args = array('posts_per_page' => 10);
                unset($args['tag']);
                unset($args['category_name']);
                $regional_query = new WP_Query($args);
            }

            if ($regional_query->have_posts()):
                $post_count = 0;
                while ($regional_query->have_posts()):
                    $regional_query->the_post();
                    $post_count++;

                    // First post as "Featured Story"
                    if ($post_count === 1):
                        ?>
                        <!-- Featured Story -->
                        <article class="relative group overflow-hidden rounded-3xl">
                            <div class="aspect-[16/9] w-full bg-gray-200 overflow-hidden">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url('large'); ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                        alt="<?php the_title_attribute(); ?>" />
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-300"></div>
                                <?php endif; ?>
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent flex flex-col justify-end p-8 text-white">
                                <div class="flex gap-3 mb-4">
                                    <span
                                        class="bg-primary px-3 py-1 rounded text-[10px] font-black tracking-widest uppercase">TERKINI</span>
                                    <span
                                        class="bg-white/20 backdrop-blur-md px-3 py-1 rounded text-[10px] font-bold"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' lalu'; ?></span>
                                </div>
                                <h3
                                    class="text-3xl md:text-4xl font-black mb-4 leading-tight group-hover:text-accent-yellow transition-colors">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="text-gray-200 line-clamp-2 max-w-2xl mb-6 font-medium">
                                    <?php echo get_the_excerpt(); ?>
                                </p>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full border border-white/20 overflow-hidden">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                                    </div>
                                    <span class="text-sm font-medium">Oleh <span
                                            class="font-bold underline"><?php the_author(); ?></span></span>
                                </div>
                            </div>
                        </article>

                        <!-- Grid Stories Container Start -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <?php else: // Grid Stories ?>

                            <article class="space-y-4 group">
                                <div class="aspect-video rounded-2xl overflow-hidden bg-gray-100">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            alt="<?php the_title_attribute(); ?>" />
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gray-200"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-[10px] font-bold text-primary uppercase">
                                        <span><?php $cat = get_the_category();
                                        echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?></span>
                                        <span class="text-gray-300 dark:text-gray-600">&bull;</span>
                                        <span
                                            class="text-gray-500"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' lalu'; ?></span>
                                    </div>
                                    <h4 class="text-xl font-bold leading-snug group-hover:text-primary transition-colors">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2">
                                        <?php echo get_the_excerpt(); ?>
                                    </p>
                                </div>
                            </article>

                        <?php endif; endwhile; ?>
                </div> <!-- Grid Stories Container End -->

            <?php else: ?>
                <p class="text-lg">Belum ada berita regional saat ini.</p>
            <?php endif;
            wp_reset_postdata(); ?>

            <!-- Newsletter Banner -->
            <div
                class="bg-primary/5 rounded-3xl p-8 border border-primary/20 flex flex-col md:flex-row items-center justify-between gap-6 dark:bg-primary/10 dark:border-primary/30">
                <div class="space-y-1 text-center md:text-left">
                    <h4 class="text-2xl font-black">Ikuti Berita Regional</h4>
                    <p class="text-gray-600 dark:text-gray-300">Dapatkan update mingguan langsung ke email Anda.</p>
                </div>
                <div class="flex w-full md:w-auto gap-2">
                    <input
                        class="flex-1 md:w-64 bg-white dark:bg-regional-bg-dark border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary outline-none"
                        placeholder="Email Anda" type="email" />
                    <button
                        class="bg-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-primary/90 transition-colors">Langganan</button>
                </div>
            </div>

        </div>

        <!-- Sidebar -->
        <?php get_sidebar(); ?>

    </div>

</main>

<?php get_footer(); ?>