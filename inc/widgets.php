<?php
/**
 * Custom Widgets for Modern News Theme
 *
 * @package ModernNews
 */

// Block direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Weather Widget
 */
class ModernNews_Weather_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'modernnews_weather_widget',
            __('Modern News: Weather', 'modernnews'),
            array('description' => __('Displays current weather information based on user location or default city.', 'modernnews'))
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        ?>
        <div id="weather-widget" class="modernnews-weather-widget-container bg-gradient-to-br from-white to-gray-50 dark:from-zinc-800 dark:to-zinc-900 p-6 rounded-2xl border border-gray-100 dark:border-zinc-700/50 shadow-inner min-h-[120px] flex flex-col items-center justify-center transition-all duration-500 hover:shadow-lg group">
            <div class="weather-loading-state flex flex-col items-center gap-3">
                <div class="size-10 rounded-full border-4 border-primary/20 border-t-primary animate-spin"></div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest animate-pulse"><?php echo esc_html__('Menghitung Cuaca...', 'modernnews'); ?></span>
            </div>
        </div>
        <?php

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : __('Weather', 'modernnews');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'modernnews'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                value="<?php echo esc_attr($title); ?>">
        </p>
        <p class="description">
            <?php esc_html_e('Configurations like API Key and Default Location are managed in Theme Options.', 'modernnews'); ?>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Trending News Widget (Most Commented)
 */
class ModernNews_Trending_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'modernnews_trending_widget',
            __('Modern News: Trending Posts', 'modernnews'),
            array('description' => __('Displays most commented posts with a numbered list design.', 'modernnews'))
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        $title = !empty($instance['title']) ? $instance['title'] : __('Trending', 'modernnews');
        $count = !empty($instance['count']) ? absint($instance['count']) : 5;

        echo $args['before_title'];
        echo '<span class="material-symbols-outlined text-primary mr-2" style="font-size:1.2em; vertical-align:text-bottom;">trending_up</span>';
        echo apply_filters('widget_title', $title);
        echo $args['after_title'];

        // Fallback to global trending category if none set in widget
        if (empty($category) && function_exists('modernnews_get_option')) {
            $category = modernnews_get_option('trending_category_id');
        }

        $trending_query = new WP_Query(array(
            'posts_per_page' => $count,
            'orderby' => 'comment_count',
            'order' => 'DESC',
            'cat' => $category,
            'ignore_sticky_posts' => 1
        ));

        if ($trending_query->have_posts()):
            echo '<div class="space-y-6">';
            $rank = 1;
            while ($trending_query->have_posts()):
                $trending_query->the_post();
                ?>
                <div class="flex gap-4 group cursor-pointer items-start">
                    <span
                        class="text-3xl font-black text-gray-200 dark:text-gray-700 group-hover:text-primary transition-colors leading-none select-none">
                        <?php echo str_pad($rank, 2, '0', STR_PAD_LEFT); ?>
                    </span>
                    <div>
                        <h6 class="font-bold text-sm leading-snug mb-1 group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h6>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">
                            <?php
                            $cats = get_the_category();
                            if (!empty($cats))
                                echo esc_html($cats[0]->name) . ' • ';
                            comments_number('0 Komentar', '1 Komentar', '% Komentar');
                            ?>
                        </p>
                    </div>
                </div>
                <?php
                $rank++;
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else:
            echo '<p>' . __('No trending posts found.', 'modernnews') . '</p>';
        endif;

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : __('Trending', 'modernnews');
        $count = !empty($instance['count']) ? absint($instance['count']) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'modernnews'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
                <?php esc_html_e('Number of posts to show:', 'modernnews'); ?>
            </label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number" step="1" min="1"
                value="<?php echo esc_attr($count); ?>" size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? absint($new_instance['count']) : 5;
        return $instance;
    }
}

/**
 * Modern News List Widget (Recent/Category with Thumbnails)
 */
class ModernNews_Post_List_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'modernnews_post_list_widget',
            __('Modern News: Post List', 'modernnews'),
            array('description' => __('Displays a list of posts with thumbnails. Useful for Recent News or Category specific lists.', 'modernnews'))
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        $title = !empty($instance['title']) ? $instance['title'] : __('Recent News', 'modernnews');
        $count = !empty($instance['count']) ? absint($instance['count']) : 5;
        $category = !empty($instance['category']) ? absint($instance['category']) : 0;

        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }

        $query_args = array(
            'posts_per_page' => $count,
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish'
        );

        if ($category > 0) {
            $query_args['cat'] = $category;
        }

        $list_query = new WP_Query($query_args);

        if ($list_query->have_posts()):
            echo '<div class="space-y-4">';
            while ($list_query->have_posts()):
                $list_query->the_post();
                ?>
                <div class="flex gap-4 group cursor-pointer items-start">
                    <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100 dark:bg-gray-700 relative">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500')); ?>
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <span class="material-symbols-outlined text-2xl">image</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold text-primary uppercase">
                                <?php
                                $cats = get_the_category();
                                echo !empty($cats) ? esc_html($cats[0]->name) : '';
                                ?>
                            </span>
                        </div>
                        <h6 class="font-bold text-sm leading-snug group-hover:text-primary transition-colors line-clamp-2">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h6>
                        <span class="text-[10px] text-gray-400 mt-1 block">
                            <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('ago', 'modernnews'); ?>
                        </span>
                    </div>
                </div>
                <?php
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else:
            echo '<p>' . __('No posts found.', 'modernnews') . '</p>';
        endif;

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent News', 'modernnews');
        $count = !empty($instance['count']) ? absint($instance['count']) : 5;
        $category = !empty($instance['category']) ? absint($instance['category']) : 0;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'modernnews'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
                <?php esc_html_e('Number of posts:', 'modernnews'); ?>
            </label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number" step="1" min="1"
                value="<?php echo esc_attr($count); ?>" size="3">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>">
                <?php esc_html_e('Filter by Category (Optional):', 'modernnews'); ?>
            </label>
            <?php
            wp_dropdown_categories(array(
                'show_option_all' => __('All Categories', 'modernnews'),
                'name' => $this->get_field_name('category'),
                'id' => $this->get_field_id('category'),
                'selected' => $category,
                'class' => 'widefat',
                'hierarchical' => 1
            ));
            ?>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? absint($new_instance['count']) : 5;
        $instance['category'] = (!empty($new_instance['category'])) ? absint($new_instance['category']) : 0;
        return $instance;
    }
}

/**
 * Modern News: Author Bio Widget
 */
class ModernNews_Author_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'modernnews_author_widget',
            __('Modern News: Author Bio', 'modernnews'),
            array('description' => __('Displays the post author bio with social links.', 'modernnews'))
        );
    }

    public function widget($args, $instance)
    {
        if (!is_single()) return;

        echo $args['before_widget'];
        $author_id = get_the_author_meta('ID');
        ?>
        <div class="author-widget-premium flex flex-col items-center text-center">
            <div class="relative mb-6">
                <div class="size-24 rounded-2xl overflow-hidden ring-4 ring-primary/10 shadow-xl">
                    <?php echo get_avatar($author_id, 160, '', '', array('class' => 'w-full h-full object-cover')); ?>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-primary text-white size-8 rounded-lg flex items-center justify-center border-4 border-white dark:border-zinc-900 shadow-lg">
                    <i class="ri-quill-pen-line"></i>
                </div>
            </div>
            <h4 class="text-xl font-black mb-1"><?php the_author(); ?></h4>
            <p class="text-[10px] text-primary font-black uppercase tracking-[0.2em] mb-4"><?php echo esc_html__('Verified Author', 'modernnews'); ?></p>
            <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400 mb-6">
                <?php echo get_the_author_meta('description'); ?>
            </p>
            <div class="flex gap-2">
                <a href="#" class="size-10 rounded-xl bg-gray-100 dark:bg-zinc-800 flex items-center justify-center hover:bg-primary hover:text-white hover:-translate-y-1 transition-all">
                    <i class="ri-twitter-x-fill text-lg"></i>
                </a>
                <a href="#" class="size-10 rounded-xl bg-gray-100 dark:bg-zinc-800 flex items-center justify-center hover:bg-primary hover:text-white hover:-translate-y-1 transition-all">
                    <i class="ri-instagram-line text-lg"></i>
                </a>
                <a href="#" class="size-10 rounded-xl bg-gray-100 dark:bg-zinc-800 flex items-center justify-center hover:bg-primary hover:text-white hover:-translate-y-1 transition-all">
                    <i class="ri-global-line text-lg"></i>
                </a>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) { }
}

/**
 * Modern News: Newsletter Widget
 */
class ModernNews_Newsletter_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'modernnews_newsletter_widget',
            __('Modern News: Newsletter', 'modernnews'),
            array('description' => __('Premium newsletter sign-up form.', 'modernnews'))
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        ?>
        <div class="newsletter-widget-premium bg-zinc-900 dark:bg-black rounded-3xl p-8 text-white relative overflow-hidden border border-white/5 shadow-2xl">
            <div class="absolute top-0 right-0 size-32 bg-primary/20 blur-[60px] rounded-full -mr-16 -mt-16"></div>
            <div class="relative z-10">
                <div class="size-12 rounded-xl bg-primary flex items-center justify-center mb-6 shadow-glow">
                    <i class="ri-mail-send-line text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black leading-tight mb-3">Newsletter <span class="text-primary italic">Eksklusif</span></h3>
                <p class="text-gray-400 text-sm mb-6 leading-relaxed">Dapatkan wawasan berita terdalam langsung ke inbox Anda setiap pagi.</p>
                <?php 
                $sub_url = function_exists('modernnews_get_option') ? modernnews_get_option('subscribe_url', '#') : '#';
                ?>
                <form class="space-y-3" action="<?php echo esc_url($sub_url); ?>" method="get">
                    <div class="relative">
                        <input type="email" name="email" placeholder="Alamat email Anda" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-5 text-sm focus:ring-2 focus:ring-primary outline-none transition-all" required>
                    </div>
                    <?php if ($sub_url !== '#'): ?>
                        <a href="<?php echo esc_url($sub_url); ?>" class="block w-full text-center bg-white text-black font-black py-4 rounded-2xl hover:bg-primary hover:text-white transition-all transform hover:scale-[1.02] active:scale-95 text-xs uppercase tracking-widest">
                            Ikuti Sekarang
                        </a>
                    <?php else: ?>
                        <button type="submit" class="w-full bg-white text-black font-black py-4 rounded-2xl hover:bg-primary hover:text-white transition-all transform hover:scale-[1.02] active:scale-95 text-xs uppercase tracking-widest">
                            Ikuti Sekarang
                        </button>
                    <?php endif; ?>
                </form>
                <p class="text-[10px] text-gray-500 mt-4 text-center">Privasi Anda terjaga. Berhenti berlangganan kapan saja.</p>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) { }
}

/**
 * Modern News: Social Follow Widget
 */
class ModernNews_Social_Follow_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'modernnews_social_follow_widget',
            __('Modern News: Social Follow', 'modernnews'),
            array('description' => __('Elegant social media follow buttons.', 'modernnews'))
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        ?>
        <div class="grid grid-cols-2 gap-3">
            <?php
            $social_platforms = array(
                'facebook'  => array('icon' => 'ri-facebook-box-fill', 'color' => '#1877F2', 'label' => 'Fans'),
                'twitter'   => array('icon' => 'ri-twitter-x-fill', 'color' => 'black', 'label' => 'Followers', 'dark_color' => 'white'),
                'instagram' => array('icon' => 'ri-instagram-line', 'color' => '#E4405F', 'label' => 'Followers'),
                'youtube'   => array('icon' => 'ri-youtube-fill', 'color' => '#FF0000', 'label' => 'Subscribers'),
                'tiktok'    => array('icon' => 'ri-tiktok-fill', 'color' => '#000000', 'label' => 'Followers', 'dark_color' => 'white')
            );

            foreach ($social_platforms as $key => $data):
                $url = function_exists('modernnews_get_option') ? modernnews_get_option('social_' . $key) : '';
                if (empty($url)) continue;
                ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" class="flex flex-col gap-1 p-4 bg-white dark:bg-zinc-800 rounded-2xl border border-gray-100 dark:border-zinc-700 hover:border-primary hover:shadow-xl transition-all group">
                    <i class="<?php echo esc_attr($data['icon']); ?> text-2xl" style="color: <?php echo esc_attr($data['color']); ?>;"></i>
                    <span class="text-xs font-black"><?php echo ('youtube' === $key) ? 'Sub' : 'Follow'; ?></span>
                    <span class="text-[9px] text-gray-400 uppercase font-bold"><?php echo esc_html(ucfirst($key)); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) { }
}
