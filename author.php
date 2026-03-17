<?php
// Get Current Author
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
$author_id = $curauth->ID;
$user_avatar_url = get_avatar_url($author_id, ['size' => 256]);
$post_count = count_user_posts($author_id);

// Dummy Static Stats for now (could be meta fields later)
$followers = '45k';
$awards = '12';

// Featured Stories Query (Get 2 random posts from this author to "Showcase")
$featured_args = array(
    'author' => $author_id,
    'posts_per_page' => 2,
    'orderby' => 'rand', // Randomise for variety in "Award Winning" section
    'ignore_sticky_posts' => 1
);
$featured_query = new WP_Query($featured_args);

?>
<!DOCTYPE html>
<html class="light" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        <?php echo esc_html($curauth->display_name); ?> - Author Profile |
        <?php bloginfo('name'); ?>
    </title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&amp;family=Noto+Sans:wght@400;500;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1c394a",
                        "accent": "#AA7F52",
                        "background-light": "#f9f9fa",
                        "background-dark": "#191e24",
                    },
                    fontFamily: {
                        "display": ["Noto Serif", "serif"],
                        "sans": ["Noto Sans", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        .font-serif {
            font-family: 'Noto Serif', serif;
        }

        .award-gradient {
            background: linear-gradient(135deg, #AA7F52 0%, #8c623d 100%);
        }
    </style>
    <?php wp_head(); ?>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-[#111518] dark:text-gray-100 transition-colors duration-200">
    <!-- Top Navigation Bar (Custom for Author Page as per design) -->
    <header
        class="sticky top-0 z-50 w-full border-b border-solid border-[#eaeef0] dark:border-gray-700 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md">
        <div class="max-w-[1200px] mx-auto px-4 lg:px-10 py-3 flex items-center justify-between whitespace-nowrap">
            <div class="flex items-center gap-8">
                <a href="<?php echo home_url(); ?>"
                    class="flex items-center gap-3 text-primary dark:text-blue-400 decoration-0">
                    <div class="size-6">
                        <span class="material-symbols-outlined">newspaper</span>
                    </div>
                    <h2 class="text-lg font-bold tracking-tight">National News</h2>
                </a>
                <nav class="hidden md:flex items-center gap-6">
                    <?php
                    $categories = get_categories(['number' => 4, 'orderby' => 'count', 'order' => 'DESC']);
                    foreach ($categories as $cat) {
                        echo '<a class="text-sm font-medium hover:text-primary transition-colors" href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a>';
                    }
                    ?>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                <form action="<?php echo home_url('/'); ?>" method="get"
                    class="hidden lg:flex border-none bg-[#eaeef0] dark:bg-gray-800 rounded-lg px-3 py-1.5 items-center gap-2">
                    <span class="material-symbols-outlined text-gray-500 text-lg">search</span>
                    <input name="s" class="bg-transparent border-none focus:ring-0 text-sm w-48"
                        placeholder="Search articles..." />
                </form>
                <button
                    class="bg-primary text-white text-sm font-bold px-5 py-2 rounded-lg hover:bg-opacity-90 transition-all">
                    Subscribe
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-[1200px] mx-auto px-4 lg:px-10 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Sidebar (Metadata) -->
            <aside class="lg:col-span-4 order-2 lg:order-1 flex flex-col gap-8">
                <!-- Profile Card Summary -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-[#eaeef0] dark:border-gray-700 shadow-sm">
                    <div class="flex flex-col items-center text-center">
                        <?php if ($user_avatar_url): ?>
                            <div class="size-32 rounded-full border-4 border-white dark:border-gray-700 shadow-lg bg-cover bg-center mb-4"
                                style='background-image: url("<?php echo esc_url($user_avatar_url); ?>");'></div>
                        <?php else: ?>
                            <div
                                class="size-32 rounded-full border-4 border-white dark:border-gray-700 shadow-lg bg-gray-200 flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-4xl text-gray-400">person</span>
                            </div>
                        <?php endif; ?>

                        <h1 class="text-2xl font-bold font-serif mb-1">
                            <?php echo esc_html($curauth->display_name); ?>
                        </h1>
                        <p class="text-accent font-bold text-sm uppercase tracking-widest mb-4">Author / Contributor</p>

                        <div class="flex gap-4 mb-6">
                            <div class="text-center">
                                <p class="text-xl font-bold">
                                    <?php echo number_format($post_count); ?>
                                </p>
                                <p class="text-xs text-gray-500 uppercase">Articles</p>
                            </div>
                            <div class="w-px h-8 bg-gray-200 dark:bg-gray-700 self-center"></div>
                            <div class="text-center">
                                <p class="text-xl font-bold">
                                    <?php echo $followers; ?>
                                </p>
                                <p class="text-xs text-gray-500 uppercase">Followers</p>
                            </div>
                            <div class="w-px h-8 bg-gray-200 dark:bg-gray-700 self-center"></div>
                            <div class="text-center">
                                <p class="text-xl font-bold">
                                    <?php echo $awards; ?>
                                </p>
                                <p class="text-xs text-gray-500 uppercase">Awards</p>
                            </div>
                        </div>

                        <div class="flex w-full gap-2">
                            <button
                                class="flex-1 bg-primary text-white py-2.5 rounded-lg font-bold text-sm flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">person_add</span> Follow
                            </button>
                            <button
                                class="px-3 bg-[#eaeef0] dark:bg-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                <span class="material-symbols-outlined text-primary dark:text-gray-300">share</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Geo-Targeting & Expertise -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-[#eaeef0] dark:border-gray-700">
                    <h3 class="font-serif font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-accent">location_on</span>
                        Regional Focus
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <span
                            class="bg-background-light dark:bg-gray-700 px-3 py-1 rounded-full text-xs font-semibold">Jakarta
                            Raya</span>
                        <span
                            class="bg-background-light dark:bg-gray-700 px-3 py-1 rounded-full text-xs font-semibold">Surabaya</span>
                        <span
                            class="bg-background-light dark:bg-gray-700 px-3 py-1 rounded-full text-xs font-semibold">South
                            Sulawesi</span>
                        <span
                            class="bg-background-light dark:bg-gray-700 px-3 py-1 rounded-full text-xs font-semibold">Ibu
                            Kota Nusantara (IKN)</span>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="flex justify-between px-2">
                    <?php if (get_the_author_meta('user_url', $author_id)): ?>
                        <a class="p-3 bg-white dark:bg-gray-800 rounded-full border border-gray-100 dark:border-gray-700 shadow-sm hover:scale-110 transition-transform"
                            href="<?php echo esc_url(get_the_author_meta('user_url', $author_id)); ?>">
                            <span class="material-symbols-outlined text-primary dark:text-blue-400">link</span>
                        </a>
                    <?php endif; ?>
                    <!-- Placeholders for other socials as standard WP doesn't have them by default without plugins -->
                    <a class="p-3 bg-white dark:bg-gray-800 rounded-full border border-gray-100 dark:border-gray-700 shadow-sm hover:scale-110 transition-transform"
                        href="#">
                        <span class="material-symbols-outlined text-primary dark:text-blue-400">mail</span>
                    </a>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="lg:col-span-8 order-1 lg:order-2">
                <!-- About Section -->
                <section class="mb-12">
                    <h2 class="text-3xl font-bold font-serif mb-6 border-b-2 border-primary w-fit pb-2">Biography</h2>
                    <div
                        class="prose dark:prose-invert max-w-none text-lg leading-relaxed text-[#5e7887] dark:text-gray-300">
                        <?php
                        $description = get_the_author_meta('description', $author_id);
                        if ($description) {
                            echo wpautop($description);
                        } else {
                            echo '<p>This author has not added a biography yet.</p>';
                        }
                        ?>
                    </div>
                </section>

                <!-- Credentials Ribbon (Static for now) -->
                <section class="mb-12">
                    <h2 class="text-xl font-bold font-serif mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-accent">verified</span> Credentials
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center gap-2 bg-[#eaeef0] dark:bg-gray-800 px-4 py-2 rounded-lg">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            <span class="text-sm font-medium">Verified Journalist</span>
                        </div>
                        <div class="flex items-center gap-2 bg-[#eaeef0] dark:bg-gray-800 px-4 py-2 rounded-lg">
                            <span class="material-symbols-outlined text-primary text-sm">groups</span>
                            <span class="text-sm font-medium">Staff Writer</span>
                        </div>
                    </div>
                </section>

                <!-- Featured Stories Highlight -->
                <?php if ($featured_query->have_posts()): ?>
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold font-serif mb-6">Featured Stories</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php while ($featured_query->have_posts()):
                                $featured_query->the_post(); ?>
                                <div class="group relative overflow-hidden rounded-xl h-64 shadow-lg cursor-pointer"
                                    onclick="window.location='<?php the_permalink(); ?>'">
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                                            style='background-image: url("<?php the_post_thumbnail_url('medium_large'); ?>");'>
                                        </div>
                                    <?php else: ?>
                                        <div class="absolute inset-0 bg-primary/20"></div>
                                    <?php endif; ?>

                                    <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/40 to-transparent">
                                    </div>
                                    <div class="absolute bottom-0 p-6">
                                        <span
                                            class="bg-accent text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase mb-2 inline-block">
                                            <?php echo get_the_category()[0]->name; ?>
                                        </span>
                                        <h3 class="text-white text-xl font-serif font-bold leading-tight group-hover:underline">
                                            <?php the_title(); ?>
                                        </h3>
                                        <p class="text-white/80 text-xs mt-2">
                                            <?php echo get_the_date(); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Article Feed -->
                <section>
                    <div
                        class="flex items-center justify-between mb-8 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h2 class="text-2xl font-bold font-serif">Latest Articles</h2>
                    </div>
                    <div class="flex flex-col gap-8">
                        <?php if (have_posts()):
                            while (have_posts()):
                                the_post(); ?>
                                <!-- Article Item -->
                                <article class="flex flex-col md:flex-row gap-6 group">
                                    <div
                                        class="md:w-1/3 aspect-[16/10] bg-cover bg-center rounded-lg shadow-sm bg-gray-200 overflow-hidden relative">
                                        <?php if (has_post_thumbnail()): ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>"
                                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <?php else: ?>
                                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                                <span class="material-symbols-outlined text-4xl">article</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="md:w-2/3 flex flex-col justify-center">
                                        <div
                                            class="flex items-center gap-3 text-xs text-gray-500 mb-2 uppercase font-bold tracking-tighter">
                                            <span class="text-primary">
                                                <?php echo get_the_category()[0]->name; ?>
                                            </span>
                                            <span>•</span>
                                            <span>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                        </div>
                                        <h3
                                            class="text-xl font-bold font-serif mb-2 group-hover:text-primary transition-colors">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                            <?php echo get_the_excerpt(); ?>
                                        </p>
                                    </div>
                                </article>
                            <?php endwhile; ?>

                            <!-- Output Pagination -->
                            <div class="py-8">
                                <?php
                                the_posts_pagination(array(
                                    'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
                                    'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
                                    'class' => ''
                                ));
                                ?>
                            </div>

                        <?php else: ?>
                            <p>No articles found.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-gray-200 dark:border-gray-700 py-12 bg-white dark:bg-background-dark">
        <div class="max-w-[1200px] mx-auto px-10 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 text-primary dark:text-blue-400 mb-4">
                    <span class="material-symbols-outlined">newspaper</span>
                    <span class="text-xl font-bold">National News</span>
                </div>
                <p class="text-sm text-gray-500 leading-relaxed">Dedicated to truthful, regional reporting across the
                    17,000 islands of Indonesia.</p>
            </div>
            <div class="flex flex-col items-end col-span-1 md:col-span-3">
                <p class="text-xs text-gray-400">©
                    <?php echo date('Y'); ?> National News Indonesia. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>

</html>