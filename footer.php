<!-- Footer -->
<footer class="site-footer bg-gray-900 border-t border-gray-800 pt-16 pb-8">
    <div class="max-w-[1200px] mx-auto w-full px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Branding & About (Static/Dynamic Mix) -->
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 mb-6">
                    <?php
                    $footer_logo = get_theme_mod('modernnews_footer_logo');
                    if (empty($footer_logo) && function_exists('modernnews_get_option')) {
                        $footer_logo = modernnews_get_option('footer_logo_url');
                    }

                    if (!empty($footer_logo)): ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo esc_url($footer_logo); ?>" alt="<?php bloginfo('name'); ?>"
                                class="max-h-12 w-auto object-contain">
                        </a>
                    <?php else: ?>
                        <div class="size-10 bg-primary/20 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-2xl">newspaper</span>
                        </div>
                        <span class="text-xl font-black tracking-tighter text-white">MODERN<span
                                class="text-primary">NEWS</span></span>
                    <?php endif; ?>
                </div>
                <?php
                if (is_active_sidebar('footer-1')) {
                    dynamic_sidebar('footer-1');
                } else {
                    // Fallback content if widget is empty
                    $about_text = function_exists('modernnews_get_option') ? modernnews_get_option('footer_about', 'Portal berita terpercaya dengan sajian informasi terkini, tajam, dan berimbang.') : 'Portal berita terpercaya...';
                    ?>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        <?php echo esc_html($about_text); ?>
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <?php
                        if (function_exists('modernnews_get_option')):
                            $socials = array(
                                'facebook' => 'ri-facebook-fill',
                                'twitter' => 'ri-twitter-x-fill',
                                'instagram' => 'ri-instagram-fill',
                                'youtube' => 'ri-youtube-fill',
                                'tiktok' => 'ri-tiktok-fill',
                                'whatsapp' => 'ri-whatsapp-line'
                            );
                            foreach ($socials as $key => $icon):
                                $link = modernnews_get_option('social_' . $key);
                                if (!empty($link)):
                                    ?>
                                    <a href="<?php echo esc_url($link); ?>" target="_blank"
                                        class="size-9 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-primary hover:text-white hover:scale-110 transition-all duration-300"
                                        aria-label="<?php echo esc_attr(ucfirst($key)); ?>">
                                        <i class="<?php echo esc_attr($icon); ?> text-lg"></i>
                                    </a>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Footer Menu 1 (Dynamic Widget Slot 2) -->
            <div>
                <?php if (is_active_sidebar('footer-2')): ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else: ?>
                    <h4 class="text-white font-bold mb-6">Kategori</h4>
                    <?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'menu_class' => 'space-y-3', 'depth' => 1, 'fallback_cb' => false)); ?>
                <?php endif; ?>
            </div>

            <!-- Footer Menu 2 / Company (Dynamic Widget Slot 3) -->
            <div class="col-span-1 md:col-span-2"> <!-- Span 2 for the last widgets if needed, or split -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <?php if (is_active_sidebar('footer-3')): ?>
                            <?php dynamic_sidebar('footer-3'); ?>
                        <?php else: ?>
                            <h4 class="text-white font-bold mb-6">Perusahaan</h4>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-gray-400 hover:text-primary text-sm transition-colors">Tentang
                                        Kami</a></li>
                                <li><a href="#"
                                        class="text-gray-400 hover:text-primary text-sm transition-colors">Redaksi</a></li>
                                <li><a href="#"
                                        class="text-gray-400 hover:text-primary text-sm transition-colors">Kontak</a></li>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Contact Info (Hardcoded fallback or Widget) -->
                    <div>
                        <h4 class="text-white font-bold mb-6">Hubungi Kami</h4>
                        <div class="space-y-4">
                            <?php if (function_exists('modernnews_get_option')):
                                $address = modernnews_get_option('contact_address');
                                $email = modernnews_get_option('contact_email');
                                $phone = modernnews_get_option('contact_phone');
                                ?>
                                <?php if ($address): ?>
                                    <div class="flex gap-3"><span
                                            class="material-symbols-outlined text-gray-500 shrink-0">location_on</span>
                                        <p class="text-gray-400 text-sm leading-relaxed">
                                            <?php echo nl2br(esc_html($address)); ?>
                                        </p>
                                    </div><?php endif; ?>
                                <?php if ($email): ?>
                                    <div class="flex gap-3 items-center"><span
                                            class="material-symbols-outlined text-gray-500 shrink-0">mail</span><a
                                            href="mailto:<?php echo esc_attr($email); ?>"
                                            class="text-gray-400 text-sm hover:text-primary"><?php echo esc_html($email); ?></a>
                                    </div><?php endif; ?>
                                <?php if ($phone): ?>
                                    <div class="flex gap-3 items-center"><span
                                            class="material-symbols-outlined text-gray-500 shrink-0">call</span><a
                                            href="tel:<?php echo esc_attr($phone); ?>"
                                            class="text-gray-400 text-sm hover:text-primary"><?php echo esc_html($phone); ?></a>
                                    </div><?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <?php
            $copyright_default = '&copy; ' . date('Y') . ' Modern News. All rights reserved.';
            $copyright = get_theme_mod('modernnews_copyright_text', $copyright_default);
            ?>
            <p class="text-gray-500 text-xs text-center md:text-left"><?php echo wp_kses_post($copyright); ?></p>
            <div class="flex gap-6">
                <?php
                $priv_url = function_exists('modernnews_get_option') ? modernnews_get_option('privacy_policy_url', '#') : '#';
                $terms_url = function_exists('modernnews_get_option') ? modernnews_get_option('terms_url', '#') : '#';
                ?>
                <a href="<?php echo esc_url($priv_url); ?>" class="text-gray-500 hover:text-white text-xs">Privacy
                    Policy</a>
                <a href="<?php echo esc_url($terms_url); ?>" class="text-gray-500 hover:text-white text-xs">Terms of
                    Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Mobile Bottom Navigation (Premium) -->
<nav id="mobile-bottom-nav"
    class="fixed bottom-0 left-0 right-0 z-[60] xl:hidden bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xl border-t border-gray-100 dark:border-zinc-800 pb-safe shadow-[0_-8px_30px_rgba(0,0,0,0.08)] transition-transform duration-300">
    <div class="grid grid-cols-5 items-center <?php echo (modernnews_get_option('mobile_compact_mode', true)) ? 'h-14' : 'h-16'; ?> w-full max-w-md mx-auto px-2">

        <!-- 1. Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>"
            class="flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all duration-300 group <?php echo is_front_page() ? 'active text-primary dark:text-primary' : ''; ?>"
            aria-label="Beranda">
            <div class="relative flex flex-col items-center">
                <span class="material-symbols-outlined text-[24px] mb-0.5 group-[.active]:filled group-active:scale-90 transition-transform">home</span>
                <span class="text-[10px] font-bold tracking-tight">Beranda</span>
                <?php if (is_front_page()): ?><span class="absolute -bottom-1.5 size-1 bg-primary rounded-full"></span><?php endif; ?>
            </div>
        </a>

        <!-- 2. Explore / Topics -->
        <button id="mobile-explore-trigger"
            class="mobile-menu-toggle flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all duration-300 group"
            aria-label="Jelajah">
            <div class="relative flex flex-col items-center">
                <span class="material-symbols-outlined text-[24px] mb-0.5 group-active:scale-90 transition-transform">explore</span>
                <span class="text-[10px] font-bold tracking-tight">Topik</span>
            </div>
        </button>

        <!-- 3. Central FAB (Menu) -->
        <div class="relative w-full h-full flex justify-center items-center">
            <div class="absolute -top-6 flex flex-col items-center">
                <button id="mobile-menu-trigger-bottom"
                    class="flex items-center justify-center w-14 h-14 bg-primary text-white rounded-2xl shadow-[0_8px_25px_rgba(var(--color-primary),0.4)] hover:scale-105 active:scale-95 transition-all duration-300 ring-4 ring-white dark:ring-zinc-900 overflow-hidden group"
                    aria-label="Menu">
                    <div class="absolute inset-0 bg-gradient-to-tr from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="material-symbols-outlined text-[28px] relative z-10">grid_view</span>
                </button>
            </div>
        </div>

        <!-- 4. Trending / Live -->
        <?php
        $show_live = modernnews_get_option('enable_live_streaming', false);
        $live_url = modernnews_get_option('live_streaming_url');
        
        if ($show_live && !empty($live_url)): ?>
            <a href="<?php echo esc_url($live_url); ?>"
                class="flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-500 transition-all duration-300 group <?php echo is_page_template('page-live-streaming.php') ? 'active text-red-500' : ''; ?>"
                aria-label="Live">
                <div class="relative flex flex-col items-center">
                    <span class="material-symbols-outlined text-[24px] mb-0.5 group-[.active]:filled animate-pulse">live_tv</span>
                    <span class="text-[10px] font-bold tracking-tight">Live</span>
                    <?php if (is_page_template('page-live-streaming.php')): ?><span class="absolute -bottom-1.5 size-1 bg-red-500 rounded-full"></span><?php endif; ?>
                </div>
            </a>
        <?php else: 
            $trending_cat_id = modernnews_get_option('trending_category_id');
            $trending_url = !empty($trending_cat_id) ? get_category_link($trending_cat_id) : home_url('/?sort=popular');
            $is_trending_active = !empty($trending_cat_id) ? is_category($trending_cat_id) : (isset($_GET['sort']) && $_GET['sort'] == 'popular');
            ?>
            <a href="<?php echo esc_url($trending_url); ?>"
                class="flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all duration-300 group <?php echo $is_trending_active ? 'active text-primary dark:text-primary' : ''; ?>"
                aria-label="Populer">
                <div class="relative flex flex-col items-center">
                    <span class="material-symbols-outlined text-[24px] mb-0.5 group-[.active]:filled">local_fire_department</span>
                    <span class="text-[10px] font-bold tracking-tight">Populer</span>
                    <?php if ($is_trending_active): ?><span class="absolute -bottom-1.5 size-1 bg-primary rounded-full"></span><?php endif; ?>
                </div>
            </a>
        <?php endif; ?>

        <!-- 5. User / Account -->
        <?php if (is_user_logged_in()): ?>
            <a href="<?php echo esc_url(get_edit_profile_url()); ?>"
                class="flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all duration-300 group"
                aria-label="Profil">
                <div class="relative flex flex-col items-center">
                    <div class="size-6 rounded-full mb-0.5 border-2 border-transparent group-hover:border-primary transition-colors overflow-hidden">
                        <?php echo get_avatar(get_current_user_id(), 24, '', '', array('class' => 'w-full h-full object-cover')); ?>
                    </div>
                    <span class="text-[10px] font-bold tracking-tight">Profil</span>
                </div>
            </a>
        <?php else: 
            $citizen_news_enabled = modernnews_get_option('enable_citizen_news', false);
            $citizen_news_url = modernnews_get_option('citizen_news_url');
            if ($citizen_news_enabled && !empty($citizen_news_url)): ?>
                <a href="<?php echo esc_url($citizen_news_url); ?>"
                    class="flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all duration-300 group <?php echo is_page_template('page-submit-news.php') ? 'active text-primary' : ''; ?>"
                    aria-label="Kirim Berita">
                    <div class="relative flex flex-col items-center">
                        <span class="material-symbols-outlined text-[24px] mb-0.5 group-[.active]:filled">edit_note</span>
                        <span class="text-[10px] font-bold tracking-tight">Lapor</span>
                        <?php if (is_page_template('page-submit-news.php')): ?><span class="absolute -bottom-1.5 size-1 bg-primary rounded-full"></span><?php endif; ?>
                    </div>
                </a>
            <?php else: ?>
                <button
                    class="modernnews-search-trigger flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all duration-300 group"
                    aria-label="Cari">
                    <div class="relative flex flex-col items-center">
                        <span class="material-symbols-outlined text-[24px] mb-0.5">search</span>
                        <span class="text-[10px] font-bold tracking-tight">Cari</span>
                    </div>
                </button>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</nav>

<a href="#" id="scroll-to-top"
    class="fixed bottom-20 right-4 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg z-[100] hover:-translate-y-1 transition-all duration-300 opacity-0 invisible translate-y-10"
    title="Kembali ke atas">
    <span class="material-symbols-outlined">arrow_upward</span>
</a>

<?php get_template_part('template-parts/search-overlay'); ?>

<?php
// Sticky Footer Ad Logic
if (function_exists('modernnews_get_ad')):
    $sticky_ad = modernnews_get_ad('sticky_footer_ad');
    if (!empty($sticky_ad)):
        ?>
        <div id="modernnews-sticky-ad"
            class="fixed bottom-[60px] xl:bottom-0 left-0 right-0 z-50 bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-800 shadow-xl transition-transform duration-300 transform translate-y-0 text-center lg:hidden">
            <button id="close-sticky-ad"
                class="absolute -top-6 right-2 bg-gray-200 dark:bg-zinc-700 text-gray-600 dark:text-gray-300 rounded-lg p-1 text-xs shadow-sm flex items-center gap-1 px-2 hover:bg-red-100 hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined text-[14px]">close</span> Tutup
            </button>
            <div class="p-2 flex justify-center sticky-ad-content">
                <?php echo $sticky_ad; ?>
            </div>
        </div>
        <script>
            document.getElementById('close-sticky-ad')?.addEventListener('click', function () {
                document.getElementById('modernnews-sticky-ad').style.transform = 'translateY(150%)';
            });
        </script>
        <?php
    endif;
endif;
?>

<?php wp_footer(); ?>

<script>
    // Simple script to toggle dark mode or other UI interactions if needed
    // Tailwind Dark Mode relies on 'dark' class on HTML tag.
</script>

</body>

</html>