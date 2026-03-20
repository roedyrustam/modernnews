<?php
/**
 * Template Name: Live Streaming
 */

// Basic WP Query for Ticker
$ticker_query = new WP_Query(array(
    'posts_per_page' => 5,
    'ignore_sticky_posts' => 1
));

// Basic WP Query for Recommended
$recommended_query = new WP_Query(array(
    'posts_per_page' => 3,
    'orderby' => 'rand', // Randomize for "Discovery" feel
    'ignore_sticky_posts' => 1
));

?><!DOCTYPE html>
    <!-- Performance Hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Tailwind Configuration -->
    <script id="tailwind-config">
        <?php
        $primary_color = '#1481b8';
        $heading_font = 'Epilogue';
        $body_font = 'Noto Sans';

        if (function_exists('modernnews_get_option')) {
            $primary_color = modernnews_get_option('primary_color', '#1481b8');
            $heading_font = modernnews_get_option('heading_font', 'Epilogue');
            $body_font = modernnews_get_option('body_font', 'Noto Sans');
        }
        ?>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "<?php echo esc_js($primary_color); ?>",
                        "background-light": "#f1f2f4",
                        "background-dark": "#121416",
                        "surface-dark": "#1c1f23",
                        "border-dark": "#2d3439",
                    },
                    fontFamily: {
                        "display": ["var(--font-heading)", "sans-serif"],
                        "body": ["var(--font-body)", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        :root {
            --color-primary: <?php echo esc_html($primary_color); ?>;
            --font-heading: '<?php echo esc_html($heading_font); ?>', sans-serif;
            --font-body: '<?php echo esc_html($body_font); ?>', sans-serif;
        }
        body {
            font-family: var(--font-body);
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
        }

        .ticker-scroll {
            display: inline-block;
            white-space: nowrap;
            animation: ticker 30s linear infinite;
        }

        @keyframes ticker {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #2d3439;
            border-radius: 10px;
        }
    </style>
    <?php wp_head(); ?>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white transition-colors duration-300">
    <!-- Top Navigation -->
    <header
        class="sticky top-0 z-50 w-full border-b border-border-dark bg-background-dark/80 backdrop-blur-md px-6 py-3">
        <div class="flex items-center justify-between max-w-[1600px] mx-auto">
            <div class="flex items-center gap-10">
                <a href="<?php echo home_url(); ?>" class="flex items-center gap-3 decoration-0">
                    <div
                        class="size-8 bg-primary rounded-lg flex items-center justify-center text-white shadow-[0_0_15px_rgba(var(--primary-rgb),0.4)]">
                        <i class="ri-broadcast-line text-xl"></i>
                    </div>
                    <h1 class="text-xl font-bold tracking-tight text-white uppercase italic">News<span
                            class="text-primary">Hub</span></h1>
                </a>
                <nav class="hidden lg:flex items-center gap-6">
                    <?php
                    $categories = get_categories(['number' => 4, 'orderby' => 'count', 'order' => 'DESC']);
                    foreach ($categories as $cat) {
                        echo '<a class="text-sm font-medium hover:text-primary transition-colors text-white" href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a>';
                    }
                    ?>
                </nav>
            </div>
            <div class="flex items-center gap-4 flex-1 justify-end">
                <form action="<?php echo home_url('/'); ?>" method="get"
                    class="relative w-full max-w-md hidden md:block">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input name="s"
                        class="w-full bg-surface-dark border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-1 focus:ring-primary text-white"
                        placeholder="Search news, topics, or events..." type="text" />
                </form>
                <div class="flex items-center gap-2 bg-surface-dark px-3 py-2 rounded-lg border border-border-dark">
                    <i class="ri-map-pin-line text-primary"></i>
                    <span class="text-xs font-bold uppercase tracking-wider text-white">Jakarta, ID</span>
                </div>
                <?php if (is_user_logged_in()): ?>
                    <a href="<?php echo admin_url(); ?>"
                        class="bg-primary text-white px-5 py-2 rounded-lg text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-primary/20">Dashboard</a>
                <?php else: ?>
                    <?php
                    $sub_url = '#';
                    if (function_exists('modernnews_get_option')) {
                        $sub_url = modernnews_get_option('subscribe_url', '#');
                    }
                    ?>
                    <a href="<?php echo esc_url($sub_url); ?>"
                        class="bg-primary text-white px-5 py-2 rounded-lg text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-primary/20">Akses Premium</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <!-- Breaking News Ticker -->
    <div class="w-full bg-primary/10 border-y border-primary/20 py-2 overflow-hidden flex items-center">
        <div
            class="bg-primary text-white text-[10px] font-black px-3 py-1 ml-4 rounded uppercase flex items-center gap-1 shrink-0 z-10">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
            </span>
            Breaking
        </div>
        <div class="ticker-scroll text-sm font-medium px-4 text-primary">
            <?php
            if ($ticker_query->have_posts()) {
                $titles = [];
                while ($ticker_query->have_posts()) {
                    $ticker_query->the_post();
                    $titles[] = get_the_title() . ' •';
                }
                wp_reset_postdata();
                echo implode(' ', $titles);
            } else {
                echo "Welcome to NewsHub Live Streaming • Stay tuned for the latest updates •";
            }
            ?>
        </div>
    </div>
    <main class="max-w-[1600px] mx-auto flex gap-6 p-6">
        <!-- Side Navigation -->
        <aside class="hidden xl:flex flex-col w-64 shrink-0 gap-6">
            <div class="bg-surface-dark border border-border-dark rounded-xl p-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Main Menu</h3>
                <nav class="flex flex-col gap-1">
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 text-primary font-semibold"
                        href="<?php echo home_url(); ?>">
                        <span class="material-symbols-outlined">home</span> Home
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 transition-colors text-slate-300"
                        href="#">
                        <span class="material-symbols-outlined">explore</span> Regional
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 transition-colors text-slate-300"
                        href="#">
                        <i class="ri-history-line"></i> Archives
                    </a>
                </nav>
            </div>
            <div class="bg-surface-dark border border-border-dark rounded-xl p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Live Now</h3>
                    <span class="flex size-2 bg-red-500 rounded-full animate-pulse"></span>
                </div>
                <div class="flex flex-col gap-4">
                    <!-- Static Mockups for "Live Channels" -->
                    <div class="flex gap-3 items-center group cursor-pointer">
                        <div
                            class="size-10 rounded-lg bg-gray-700 shrink-0 border border-white/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white">tv</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold truncate group-hover:text-primary text-white">Metro TV Live</p>
                            <p class="text-[10px] text-slate-400">2.1k watching</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-center group cursor-pointer">
                        <div
                            class="size-10 rounded-lg bg-gray-700 shrink-0 border border-white/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white">ssid_chart</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold truncate group-hover:text-primary text-white">CNBC Indonesia</p>
                            <p class="text-[10px] text-slate-400">854 watching</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <!-- Central Content -->
        <div class="flex-1 min-w-0">
            <!-- Hero Video Player -->
            <div
                class="relative group rounded-xl overflow-hidden bg-black border border-border-dark aspect-video shadow-2xl">
                <!-- Placeholder Background -->
                <div
                    class="absolute inset-0 bg-cover bg-center opacity-60 group-hover:scale-105 transition-transform duration-700 bg-gray-800">
                </div>
                <!-- Player Overlays -->
                <div class="absolute top-4 left-4 flex gap-2">
                    <span
                        class="bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded flex items-center gap-1 shadow-lg">
                        <span class="size-1.5 bg-white rounded-full animate-pulse"></span> LIVE
                    </span>
                    <span
                        class="bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2 py-0.5 rounded border border-white/10">
                        1080p HD
                    </span>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <button
                        class="size-20 bg-primary/90 text-white rounded-full flex items-center justify-center transition-transform hover:scale-110 shadow-2xl shadow-primary/40 backdrop-blur-sm">
                        <span class="material-symbols-outlined text-4xl fill-1">play_arrow</span>
                    </button>
                </div>
                <!-- Custom Controls -->
                <div
                    class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/90 to-transparent p-6 opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-full h-1 bg-white/20 rounded-full mb-4 relative overflow-hidden">
                        <div class="absolute top-0 left-0 h-full w-[65%] bg-primary"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <button class="text-white hover:text-primary transition-colors"><span
                                    class="material-symbols-outlined">pause</span></button>
                            <button class="text-white hover:text-primary transition-colors"><span
                                    class="material-symbols-outlined">volume_up</span></button>
                            <span class="text-xs font-medium text-slate-300">00:45:12 / LIVE</span>
                        </div>
                        <div class="flex items-center gap-6">
                            <button class="text-white hover:text-primary transition-colors"><span
                                    class="material-symbols-outlined">closed_caption</span></button>
                            <button class="text-white hover:text-primary transition-colors"><span
                                    class="material-symbols-outlined">settings</span></button>
                            <button class="text-white hover:text-primary transition-colors"><span
                                    class="material-symbols-outlined">fullscreen</span></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Video Info -->
            <div class="mt-6 flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <h2 class="text-3xl font-bold leading-tight text-white">Indonesia Malam: National Wrap-up</h2>
                    <p class="text-slate-400 mt-1 flex items-center gap-3">
                        <span class="flex items-center gap-1"><span
                                class="material-symbols-outlined text-sm">visibility</span> 15,432 viewers</span>
                        <span class="size-1 bg-slate-600 rounded-full"></span>
                        <span class="flex items-center gap-1"><span
                                class="material-symbols-outlined text-sm">schedule</span> Started 45 mins ago</span>
                    </p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="flex items-center gap-2 bg-surface-dark px-4 py-2 rounded-lg border border-border-dark hover:bg-border-dark transition-colors text-white">
                        <span class="material-symbols-outlined text-lg">share</span> Share
                    </button>
                    <button
                        class="flex items-center gap-2 bg-surface-dark px-4 py-2 rounded-lg border border-border-dark hover:bg-border-dark transition-colors text-white">
                        <span class="material-symbols-outlined text-lg">add_circle</span> Follow
                    </button>
                </div>
            </div>
            <!-- Related Content Grid -->
            <div class="mt-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Recommended for You</h3>
                    <a class="text-primary text-sm font-bold flex items-center gap-1 hover:underline" href="#">View All
                        <i class="ri-arrow-right-line text-sm"></i></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while ($recommended_query->have_posts()):
                        $recommended_query->the_post(); ?>
                        <div class="group cursor-pointer">
                            <div class="aspect-video rounded-xl overflow-hidden relative mb-3 border border-border-dark">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>"
                                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="absolute inset-0 bg-gray-800 flex items-center justify-center"><span
                                            class="material-symbols-outlined text-4xl text-gray-600">image</span></div>
                                <?php endif; ?>

                                <div
                                    class="absolute bottom-2 right-2 bg-black/80 text-[10px] font-bold px-1.5 py-0.5 rounded text-white">
                                    <?php echo get_the_time('H:i'); ?>
                                </div>
                            </div>
                            <h4
                                class="font-bold line-clamp-2 group-hover:text-primary transition-colors leading-snug text-white">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a></h4>
                            <p class="text-xs text-slate-500 mt-1">
                                <?php echo get_the_date(); ?>
                            </p>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
        <!-- Right Sidebar (Engagement & Schedule) -->
        <aside class="hidden lg:flex flex-col w-80 shrink-0 gap-6">
            <!-- Live Chat -->
            <div class="bg-surface-dark border border-border-dark rounded-xl flex flex-col h-[500px] shadow-xl">
                <div class="p-4 border-b border-border-dark flex items-center justify-between">
                    <h3 class="font-bold flex items-center gap-2 text-white">
                        <i class="ri-chat-3-line text-primary"></i> Live Chat
                    </h3>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Moderated</span>
                </div>
                <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-4 custom-scrollbar">
                    <!-- Static Chat Items -->
                    <div class="flex gap-3">
                        <div
                            class="size-8 rounded-full bg-primary/20 shrink-0 flex items-center justify-center text-primary text-xs font-bold">
                            AS</div>
                        <div>
                            <p class="text-xs font-bold text-slate-400">Agus Salim <span
                                    class="text-[10px] font-normal ml-1">Just Now</span></p>
                            <p class="text-sm text-white">Great coverage!</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div
                            class="size-8 rounded-full bg-slate-700 shrink-0 flex items-center justify-center text-xs font-bold text-white">
                            RK</div>
                        <div>
                            <p class="text-xs font-bold text-slate-400">Rizky</p>
                            <p class="text-sm text-white">Waiting for sports segment.</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t border-border-dark">
                    <div class="relative">
                        <input
                            class="w-full bg-background-dark border-none rounded-lg py-2.5 pl-4 pr-10 text-sm focus:ring-1 focus:ring-primary text-white"
                            placeholder="Say something..." type="text" />
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 text-primary">
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Coming Up Next -->
            <div class="bg-surface-dark border border-border-dark rounded-xl p-5">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Program Schedule</h3>
                <div class="flex flex-col gap-6 relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-[15px] top-2 bottom-2 w-px bg-border-dark"></div>
                    <!-- Schedule Items Static -->
                    <div class="flex gap-4 relative z-10">
                        <div
                            class="size-8 rounded-full bg-primary border-4 border-surface-dark shrink-0 flex items-center justify-center shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined text-white text-[14px]">play_arrow</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-primary uppercase tracking-tight">Now Playing</h4>
                                <span class="text-[10px] font-bold text-slate-500">
                                    <?php echo date('H:00'); ?> -
                                    <?php echo date('H:00', strtotime('+1 hour')); ?>
                                </span>
                            </div>
                            <p class="text-sm font-semibold text-white">Indonesia Malam</p>
                            <div class="w-full h-1 bg-border-dark rounded-full mt-2 overflow-hidden">
                                <div class="h-full w-3/4 bg-primary"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </main>
    <!-- Footer Meta -->
    <footer
        class="max-w-[1600px] mx-auto border-t border-border-dark mt-12 p-10 flex flex-col md:flex-row justify-between gap-10 opacity-60 hover:opacity-100 transition-opacity">
        <div class="max-w-xs">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-6 bg-primary/20 rounded-md flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-lg">broadcast_on_home</span>
                </div>
                <h2 class="text-lg font-bold tracking-tight text-white uppercase italic">NewsHub</h2>
            </div>
            <p class="text-xs leading-relaxed text-slate-400">The leading destination for live national news in
                Indonesia.</p>
        </div>
        <div class="flex flex-col items-end">
            <p class="text-xs font-bold mb-4 text-white">Download Our App</p>
            <div class="flex gap-2">
                <div
                    class="h-10 w-32 bg-surface-dark border border-border-dark rounded-lg flex items-center justify-center cursor-pointer hover:border-primary transition-colors">
                    <span class="text-[10px] font-bold uppercase text-white">App Store</span>
                </div>
                <div
                    class="h-10 w-32 bg-surface-dark border border-border-dark rounded-lg flex items-center justify-center cursor-pointer hover:border-primary transition-colors">
                    <span class="text-[10px] font-bold uppercase text-white">Google Play</span>
                </div>
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>

</html>