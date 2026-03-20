<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Performance Hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/manifest.json">
    <meta name="theme-color" content="#168098">
    <link rel="dns-prefetch" href="https://www.google-analytics.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">

    <!-- Dark Mode Init (Minimize FOUC) -->
    <?php
    $default_appearance = function_exists('modernnews_get_appearance') ? modernnews_get_appearance() : 'system';
    ?>
    <script>
        (function() {
            const defaultAppearance = '<?php echo esc_js($default_appearance); ?>';
            const storageTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            let isDark = false;
            
            if (storageTheme === 'dark') {
                isDark = true;
            } else if (storageTheme === 'light') {
                isDark = false;
            } else if (!storageTheme) {
                if (defaultAppearance === 'dark') {
                    isDark = true;
                } else if (defaultAppearance === 'system') {
                    isDark = systemDark;
                }
            }
            
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Fonts handled by functions.php -->

    <style>
        /* ---- CSS Variables required by Tailwind config & body classes ---- */
        :root {
            --color-primary: #168098;
            --color-secondary: #6c757d;
            --bg-light: #f4f7f8;
            --bg-dark: #09090b;
            --font-heading: 'Epilogue', 'Inter', sans-serif;
            --font-body: 'Noto Sans', 'Lora', sans-serif;
            --radius-md: 8px;
        }

        /* Dark mode: swap background & text variables */
        html.dark {
            --bg-light: #09090b;
            --bg-dark: #000000;
            color-scheme: dark;
        }

        /* Ensure the body background follows dark mode */
        html.dark body {
            background-color: #09090b;
            color: #f4f4f5;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <?php
    if (function_exists('modernnews_get_option')) {
        $header_scripts = modernnews_get_option('header_scripts');
        if (!empty($header_scripts)) {
            echo "<!-- Header Scripts -->\n";
            echo $header_scripts . "\n";
        }
    }
    ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-background-light dark:bg-background-dark text-[#0f181a] dark:text-gray-100 min-h-screen'); ?>>
    <?php wp_body_open(); ?>

    <!-- Skip to Content (A11y) -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 z-[100] bg-primary text-white px-6 py-3 rounded-lg font-bold shadow-lg transition-all">
        Skip to Content
    </a>

    <!-- Reading Progress Bar (Single Posts Only) -->
    <?php if (is_single()): ?>
        <div id="reading-progress-container"
            class="fixed top-0 left-0 w-full h-1 z-[60] bg-transparent pointer-events-none">
            <div id="reading-progress-bar" class="h-full bg-primary w-0 transition-all duration-100 ease-out"></div>
        </div>
    <?php endif; ?>

    <div id="mobile-menu-overlay"
        class="fixed inset-0 bg-black/50 z-[65] opacity-0 pointer-events-none backdrop-blur-sm transition-all duration-300 xl:hidden">
    </div>

    <header
        class="site-header sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 dark:bg-zinc-900/90 dark:border-zinc-800 transition-colors duration-300" role="banner">
        <div
            class="header-container container max-w-[1280px] mx-auto px-4 lg:px-10 <?php echo (modernnews_get_option('mobile_compact_mode', true)) ? 'h-14' : 'h-20'; ?> lg:h-20 flex items-center justify-between xl:justify-between gap-6" role="navigation" aria-label="<?php esc_attr_e('Menu Utama', 'modernnews'); ?>">


            <a class="site-branding flex items-center gap-3 absolute left-1/2 -translate-x-1/2 xl:relative xl:left-0 xl:translate-x-0"
                href="<?php echo esc_url(home_url('/')); ?>">
                <?php
                $header_logo = get_theme_mod('modernnews_header_logo');
                if (empty($header_logo) && function_exists('modernnews_get_option')) {
                    $header_logo = modernnews_get_option('header_logo_url');
                }

                if (!empty($header_logo)): ?>
                    <img src="<?php echo esc_url($header_logo); ?>" alt="<?php bloginfo('name'); ?>"
                        class="max-h-7 md:max-h-12 w-auto object-contain">
                <?php else: ?>
                    <div class="size-8 text-primary">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.57829 8.57829C5.52816 11.6284 3.451 15.5145 2.60947 19.7452C1.76794 23.9758 2.19984 28.361 3.85056 32.3462C5.50128 36.3314 8.29667 39.7376 11.8832 42.134C15.4698 44.5305 19.6865 45.8096 24 45.8096C28.3135 45.8096 32.5302 44.5305 36.1168 42.134C39.7033 39.7375 42.4987 36.3314 44.1494 32.3462C45.8002 28.361 46.2321 23.9758 45.3905 19.7452C44.549 15.5145 42.4718 11.6284 39.4217 8.57829L24 24L8.57829 8.57829Z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                    <h1 class="site-title text-xl font-extrabold tracking-tighter uppercase dark:text-white">
                        <?php bloginfo('name'); ?>
                    </h1>
                <?php endif; ?>
            </a>


            <!-- Desktop Nav -->
            <nav class="main-navigation hidden xl:flex items-center gap-6 h-full">
                <?php
                // Display Primary Menu
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'menu_class' => 'flex gap-6 h-full',
                        'walker' => new ModernNews_Mega_Menu_Walker(),
                        'fallback_cb' => false
                    ));
                } else {
                    // Fallback based on HTML provided
                    ?>
                    <a class="text-sm font-bold hover:text-primary transition-colors" href="#">Politik</a>
                    <a class="text-sm font-bold hover:text-primary transition-colors" href="#">Ekonomi</a>
                    <a class="text-sm font-bold hover:text-primary transition-colors" href="#">Olahraga</a>
                    <a class="text-sm font-bold hover:text-primary transition-colors" href="#">Teknologi</a>
                    <a class="text-sm font-bold hover:text-primary transition-colors" href="#">Gaya Hidup</a>
                    <?php
                }
                ?>

                <?php if (get_option('enable_live_streaming')): ?>
                    <a href="<?php echo esc_url(get_option('live_streaming_url', '#')); ?>"
                        class="flex items-center gap-1 text-red-600 animate-pulse hover:bg-red-50 px-2 py-1 rounded transition-colors">
                        <span class="material-symbols-outlined text-sm">circle</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Live</span>
                    </a>
                <?php endif; ?>
            </nav>

            <div class="flex items-center gap-4">
                <button
                    class="modernnews-search-trigger hidden md:flex items-center bg-[#f0f4f5] dark:bg-gray-800 rounded-lg px-3 py-2 w-48 xl:w-64 text-left group transition-colors hover:bg-gray-200 dark:hover:bg-gray-700" aria-label="<?php esc_attr_e('Cari Berita', 'modernnews'); ?>">
                    <span
                        class="material-symbols-outlined text-gray-400 text-lg group-hover:text-primary transition-colors">search</span>
                    <span
                        class="ml-2 text-sm text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300">Cari
                        berita...</span>
                </button>


                <!-- Theme Toggle -->
                <button id="theme-toggle" class="p-2 text-gray-500 hover:text-primary transition-colors hidden xl:block"
                    title="Toggle Dark Mode">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                </button>

                <?php
                if (function_exists('modernnews_get_option')):
                    $sub_url = modernnews_get_option('subscribe_url', '#');
                    $live_enabled = modernnews_get_option('enable_live_streaming');
                    $live_url = modernnews_get_option('live_streaming_url', '#');

                    if ($live_enabled):
                        ?>
                        <a href="<?php echo esc_url($live_url); ?>"
                            class="hidden xl:flex items-center gap-1 text-red-600 animate-pulse border border-red-200 bg-red-50 px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm">circle</span>
                            <span class="text-xs font-bold uppercase tracking-wider">Live TV</span>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($sub_url); ?>"
                        class="hidden md:flex bg-primary text-white text-xs font-bold uppercase tracking-widest px-6 py-2.5 rounded-lg hover:brightness-110 transition-all items-center">
                        Langganan
                    </a>
                <?php else: ?>
                    <button
                        class="hidden md:flex bg-primary text-white text-xs font-bold uppercase tracking-widest px-6 py-2.5 rounded-lg hover:brightness-110 transition-all">Langganan</button>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Toggle (Right on Mobile) -->
            <button id="mobile-menu-toggle" class="xl:hidden text-gray-700 dark:text-gray-200 p-2 -mr-2 relative z-20" aria-label="<?php esc_attr_e('Buka Menu Mobile', 'modernnews'); ?>" aria-expanded="false" aria-controls="mobile-menu-container">
                <span class="material-symbols-outlined text-2xl lg:text-3xl">menu</span>
            </button>
        </div>
    </header>

    <!-- Mobile Sidebar Drawer -->
    <!-- Mobile Sidebar Drawer (Native App Style) -->
        <div id="mobile-menu-container"
            class="hidden xl:hidden bg-white dark:bg-zinc-900 fixed top-0 left-0 w-80 max-w-[85vw] h-full z-[70] shadow-2xl -translate-x-full border-r border-gray-100 dark:border-zinc-800 flex flex-col transition-transform duration-300">

            <!-- Drawer Header: User Profile -->
            <div class="relative w-full bg-primary overflow-hidden shrink-0">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-gradient-to-br from-black/20 via-transparent to-black/20"></div>
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-black/10 rounded-full"></div>

                <div class="relative z-10 p-6 pt-12 pb-8 flex flex-col gap-5">
                    <div class="flex items-center justify-between">
                        <div class="size-16 rounded-2xl bg-white p-1 shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500">
                            <?php if (is_user_logged_in()): ?>
                                <?php echo get_avatar(get_current_user_id(), 64, '', '', array('class' => 'rounded-xl w-full h-full object-cover')); ?>
                            <?php else: ?>
                                <div class="w-full h-full rounded-xl bg-gray-50 flex items-center justify-center text-primary/30">
                                    <span class="material-symbols-outlined text-3xl">person</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button id="mobile-menu-close"
                            class="size-10 flex items-center justify-center bg-white/10 backdrop-blur-md rounded-xl text-white hover:bg-white/20 active:scale-90 transition-all">
                            <span class="material-symbols-outlined text-2xl">close</span>
                        </button>
                    </div>

                    <div class="text-white">
                        <?php if (is_user_logged_in()):
                            $current_user = wp_get_current_user();
                            ?>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="size-2 rounded-full bg-green-400 animate-pulse"></span>
                                <p class="text-[10px] font-black text-white/70 uppercase tracking-[0.2em]">Online Now</p>
                            </div>
                            <h3 class="text-2xl font-black font-heading leading-tight truncate">
                                <?php echo esc_html($current_user->display_name); ?>
                            </h3>
                            <p class="text-xs text-white/60 font-medium"><?php echo esc_html($current_user->user_email); ?></p>
                        <?php else: ?>
                            <p class="text-[10px] font-black text-white/70 uppercase tracking-[0.2em] mb-1">Berita Premium</p>
                            <h3 class="text-2xl font-black font-heading">Dapatkan Akses</h3>
                            <div class="mt-4 flex gap-2">
                                <?php
                                $sub_url = '#';
                                if (function_exists('modernnews_get_option')) {
                                    $sub_url = modernnews_get_option('subscribe_url', '#');
                                }
                                ?>
                                <a href="<?php echo esc_url($sub_url); ?>"
                                    class="flex-1 text-center text-xs font-bold bg-white text-primary px-4 py-2.5 rounded-xl hover:shadow-lg transition-all active:scale-95">Langganan Sekarang</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Drawer Body: Navigation & Search -->
            <nav class="w-full flex-1 overflow-y-auto overscroll-contain bg-white dark:bg-zinc-900 scrollbar-hide">
                <div class="p-4 space-y-6">
                    
                    <!-- Search Bar inside Drawer -->
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                        </div>
                        <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                            <input type="search" name="s" placeholder="Cari berita apa hari ini?" 
                                class="w-full bg-gray-50 dark:bg-zinc-800/50 border-none rounded-2xl py-3.5 pl-12 pr-4 text-sm font-medium focus:ring-2 focus:ring-primary/20 dark:text-white transition-all">
                        </form>
                    </div>

                    <div>
                        <div class="px-2 mb-3 flex items-center justify-between">
                            <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Navigasi Utama</span>
                            <span class="h-px flex-1 bg-gray-100 dark:bg-zinc-800 ml-4"></span>
                        </div>

                        <ul class="flex flex-col gap-1 w-full">
                            <li>
                                <a href="<?php echo esc_url(home_url('/')); ?>"
                                    class="flex items-center gap-4 p-2.5 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-zinc-800 active:scale-[0.98] transition-all group">
                                    <div class="size-10 rounded-xl bg-gray-50 dark:bg-zinc-800 flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">home</span>
                                    </div>
                                    <span class="font-bold text-[15px]">Beranda</span>
                                </a>
                            </li>

                        <?php
                        // Determine which menu to show
                        $theme_location = '';
                        if (has_nav_menu('mobile')) {
                            $theme_location = 'mobile';
                        } elseif (has_nav_menu('primary')) {
                            $theme_location = 'primary';
                        }

                        if (!empty($theme_location)) {
                            wp_nav_menu(array(
                                'theme_location' => $theme_location,
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'menu_class' => '',
                                'fallback_cb' => false,
                                'walker' => new ModernNews_Mobile_Walker()
                            ));
                        } else {
                            ?>
                            <div class="border-l-2 border-dashed border-gray-200 dark:border-gray-700 ml-4 pl-4 my-4">
                                <li>
                                    <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>"
                                        class="block text-sm text-gray-500 italic hover:text-primary">
                                        Menu "Mobile" atau "Primary" belum diatur.
                                    </a>
                                </li>
                            </div>
                            <?php
                        }
                        ?>

                            <li>
                                <a href="#"
                                    class="flex items-center gap-4 p-2.5 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-zinc-800 active:scale-[0.98] transition-all group">
                                    <div class="size-10 rounded-xl bg-gray-50 dark:bg-zinc-800 flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">trending_up</span>
                                    </div>
                                    <span class="font-bold text-[15px]">Trending</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center gap-4 p-2.5 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-zinc-800 active:scale-[0.98] transition-all group">
                                    <div class="size-10 rounded-xl bg-gray-50 dark:bg-zinc-800 flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">bookmark</span>
                                    </div>
                                    <span class="font-bold text-[15px]">Disimpan</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <div class="px-2 mb-3 flex items-center justify-between">
                            <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Aplikasi & Bantuan</span>
                            <span class="h-px flex-1 bg-gray-100 dark:bg-zinc-800 ml-4"></span>
                        </div>
                        <ul class="flex flex-col gap-1">
                            <li>
                                <a href="#"
                                    class="flex items-center gap-4 p-2.5 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all group">
                                    <div class="size-10 rounded-xl bg-gray-50 dark:bg-zinc-800 flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">settings</span>
                                    </div>
                                    <span class="font-medium text-[15px]">Pengaturan</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center gap-4 p-2.5 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all group">
                                    <div class="size-10 rounded-xl bg-gray-50 dark:bg-zinc-800 flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">help_center</span>
                                    </div>
                                    <span class="font-medium text-[15px]">Bantuan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Drawer Footer: Features & Social -->
            <div class="p-6 border-t border-gray-100 dark:border-zinc-800 bg-gray-50/50 dark:bg-black/20 shrink-0 w-full">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-gray-400 text-lg">dark_mode</span>
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Mode Gelap</span>
                    </div>
                    <button id="drawer-theme-toggle"
                        class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 dark:bg-zinc-700 transition-colors focus:outline-none">
                        <span class="sr-only">Toggle Dark Mode</span>
                        <span
                            class="translate-x-1 inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200 dark:translate-x-6"></span>
                    </button>
                </div>

                <!-- Social Links -->
                <div class="flex items-center justify-center gap-3 mb-6">
                    <?php
                    $socials = array(
                        'facebook' => 'ri-facebook-fill',
                        'twitter' => 'ri-twitter-x-fill',
                        'instagram' => 'ri-instagram-line',
                        'youtube' => 'ri-youtube-fill',
                        'tiktok' => 'ri-tiktok-fill'
                    );

                    foreach ($socials as $key => $icon):
                        $url = modernnews_get_option('social_' . $key);
                        if ($url):
                            ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank"
                                class="size-10 flex items-center justify-center rounded-xl bg-white dark:bg-zinc-800 text-gray-400 hover:text-primary hover:shadow-md transition-all">
                                <i class="<?php echo esc_attr($icon); ?> text-lg"></i>
                            </a>
                        <?php endif;
                    endforeach; ?>
                </div>

                <div class="text-center">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-relaxed">
                        &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?><br>
                        <span class="opacity-50 font-medium">Modern News Premium v1.3.0</span>
                    </p>
                </div>
            </div>
        </div>
    <!-- Header Ad Slot -->
    <?php
    if (function_exists('modernnews_get_ad')) {
        $header_ad = modernnews_get_ad('header_ad');
        if (!empty($header_ad)) {
            echo '<div class="container mx-auto px-4 lg:px-10 py-4 flex justify-center">';
            echo $header_ad;
            echo '</div>';
        }
    }
    ?>

    <!-- Breaking News Ticker -->
    <?php
    if (function_exists('modernnews_get_option') && modernnews_get_option('ticker_enable')):
        $ticker_title = modernnews_get_option('ticker_title', 'Breaking News');
        $ticker_cat = modernnews_get_option('ticker_category');
        $ticker_count = modernnews_get_option('ticker_count', 5);
        $ticker_args = array(
            'posts_per_page' => $ticker_count,
            'ignore_sticky_posts' => 1
        );
        if ($ticker_cat) {
            $ticker_args['cat'] = $ticker_cat;
        }
        $ticker = new WP_Query($ticker_args);

        if ($ticker->have_posts()):
            ?>
            <div class="bg-accent-yellow py-2 px-4 lg:px-10 overflow-hidden">
                <div class="max-w-[1280px] mx-auto flex items-center gap-4">
                    <span
                        class="bg-black text-white text-[10px] font-black uppercase px-2 py-0.5 rounded italic shrink-0"><?php echo esc_html($ticker_title); ?></span>
                    <div class="modernnews-ticker-wrap flex-1 text-black text-sm font-bold">
                        <div class="modernnews-ticker-move">
                            <?php
                            while ($ticker->have_posts()):
                                $ticker->the_post();
                                ?>
                                <a href="<?php the_permalink(); ?>" class="mx-4 hover:underline">
                                    <?php the_title(); ?>
                                </a>
                                <span class="opacity-50">•</span>
                            <?php endwhile;

                            // Duplicate for continuous feel (simple)
                            $ticker->rewind_posts();
                            while ($ticker->have_posts()):
                                $ticker->the_post();
                                ?>
                                <a href="<?php the_permalink(); ?>" class="mx-4 hover:underline">
                                    <?php the_title(); ?>
                                </a>
                                <span class="opacity-50">•</span>
                            <?php endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
    endif;
    ?>