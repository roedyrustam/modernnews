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

<!-- Mobile Bottom Navigation -->
<!-- Mobile Bottom Navigation (Premium) -->
<nav id="mobile-bottom-nav"
    class="fixed bottom-0 left-0 right-0 z-[60] xl:hidden bg-white/90 dark:bg-zinc-900/90 backdrop-blur-lg border-t border-gray-100 dark:border-zinc-800 pb-safe shadow-[0_-4px_20px_rgba(0,0,0,0.05)] transition-transform duration-300">
    <div class="grid grid-cols-5 items-end <?php echo (modernnews_get_option('mobile_compact_mode', true)) ? 'h-12' : 'h-16'; ?> w-full">

        <!-- 1. Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>"
            class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-colors group <?php echo is_front_page() ? 'active text-primary dark:text-primary' : ''; ?>"
            aria-label="Beranda">
            <span class="material-symbols-outlined text-[24px] mb-0.5 group-[.active]:filled">home</span>
            <span class="text-[10px] font-medium">Beranda</span>
        </a>

        <!-- 2. Trending -->
        <?php
        $trending_cat_id = modernnews_get_option('trending_category_id');
        $trending_url = !empty($trending_cat_id) ? get_category_link($trending_cat_id) : home_url('/?orderby=comment_count');
        $is_trending_active = !empty($trending_cat_id) ? is_category($trending_cat_id) : (isset($_GET['orderby']) && $_GET['orderby'] == 'comment_count');
        ?>
        <a href="<?php echo esc_url($trending_url); ?>"
            class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-colors group <?php echo $is_trending_active ? 'active text-primary dark:text-primary' : ''; ?>"
            aria-label="Trending">
            <span class="material-symbols-outlined text-[24px] mb-0.5 group-[.active]:filled">trending_up</span>
            <span class="text-[10px] font-medium">Trending</span>
        </a>

        <!-- 3. Central FAB (Menu) -->
        <div class="relative w-full h-full flex justify-center items-end">
            <div class="absolute -top-5 flex flex-col items-center">
                <button id="mobile-menu-trigger-bottom"
                    class="flex flex-col items-center justify-center w-12 h-12 bg-primary text-white rounded-full shadow-[0_8px_20px_rgba(var(--color-primary),0.4)] hover:scale-105 active:scale-95 transition-all duration-300 ring-4 ring-gray-50 dark:ring-zinc-900 border-4 border-transparent"
                    aria-label="Menu">
                    <span class="material-symbols-outlined text-[26px]">grid_view</span>
                </button>
                <span class="text-[10px] font-medium text-gray-400 mt-1">Menu</span>
            </div>
        </div>

        <!-- 4. Search -->
        <button
            class="modernnews-search-trigger flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-colors group"
            aria-label="Cari">
            <span class="material-symbols-outlined text-[24px] mb-0.5">search</span>
            <span class="text-[10px] font-medium">Cari</span>
        </button>

        <!-- 5. User / Account -->
        <?php if (is_user_logged_in()): ?>
            <a href="<?php echo esc_url(get_edit_profile_url()); ?>"
                class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-colors group"
                aria-label="Akun">
                <?php echo get_avatar(get_current_user_id(), 22, '', '', array('class' => 'rounded-full mb-0.5 border border-gray-200 dark:border-zinc-700')); ?>
                <span class="text-[10px] font-medium">Akun</span>
            </a>
        <?php else: ?>
            <a href="<?php echo esc_url(get_post_type_archive_link('post') . '?orderby=comment_count'); ?>"
                class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-colors group"
                aria-label="Trending">
                <span class="material-symbols-outlined text-[24px] mb-0.5">trending_up</span>
                <span class="text-[10px] font-medium">Trending</span>
            </a>
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