<?php
if (!defined('ABSPATH')) {
    exit;
}

class ModernNews_Mega_Menu_Walker extends Walker_Nav_Menu
{
    /**
     * Start Level.
     */
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"mega-menu-dropdown absolute left-0 top-full w-full bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50\">\n";
        $output .= "<div class=\"max-w-[1280px] mx-auto px-6 py-6\">\n";
        // We might want a grid wrapper here via CSS, usually we output UL normally but for Mega Menu we want a DIV structure if we are injecting posts.
        // However, standard WP menu structure expects UL. 
        // Let's modify: If this is depth 0, we open the mega wrapper. 
        // Inside, we might have standard submenus OR posts.
        // For simplicity, we'll keep standard UL for links, but inject posts BEFORE the UL if logic matches.
        $output .= "<ul class=\"grid grid-cols-4 gap-6\">\n";
    }

    /**
     * End Level.
     */
    function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
        $output .= "</div>\n"; // Close inner container
        $output .= "</div>\n"; // Close dropdown wrapper
    }

    /**
     * Start Element.
     */
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Add 'group' class to top level items for hover effects
        if ($depth === 0) {
            $classes[] = 'group h-full flex items-center relative';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        // Attributes
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        // Styling for links
        $link_class = 'block px-4 py-2 text-sm font-bold text-gray-700 dark:text-gray-300 hover:text-primary transition-colors';
        if ($depth === 0) {
            $link_class = 'h-full flex items-center gap-1 text-sm font-bold text-gray-900 dark:text-gray-100 hover:text-primary px-3 transition-colors';
        }

        $atts['class'] = $link_class;

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;

        // Add dropdown arrow if has children
        if ($args->walker->has_children && $depth === 0) {
            $item_output .= '<span class="material-symbols-outlined text-[18px]">keyboard_arrow_down</span>';
        }

        $item_output .= '</a>';

        // MEGA MENU CONTENT Injection
        // If it's top level, has object_type 'category', and we want to show posts.
        if ($depth === 0 && $item->object === 'category') {
            // We can check if settings enable mega menu for this category, or just default to yes.
            // We'll inject a div that mimics the start_lvl output but with POSTS.
            // Note: start_lvl is called AFTER this if it has children.
            // If it has NO children (no sub-categories), start_lvl won't be called, so we can't rely on it for ONLY posts.
            // However, mixing Walker logic with custom queries is tricky.
            // Strategy: We will ONLY inject posts if it has NO sub-menu items (no children), 
            // OR we treat it as a special "Mega" item via a class.

            // Simplest "News" Mega Menu:
            // If item is Category, we append a div with recent posts from that category.
            // We perform the query here.

            $cat_id = $item->object_id;
            $mega_query = new WP_Query(array(
                'cat' => $cat_id,
                'posts_per_page' => 4,
                'no_found_rows' => true,
                'post_status' => 'publish'
            ));

            if ($mega_query->have_posts()) {
                $item_output .= '<div class="mega-menu-posts absolute left-0 top-full w-screen -ml-[calc((100vw-1280px)/2+20px)] bg-white dark:bg-gray-900 border-t border-primary border-t-4 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">';
                $item_output .= '<div class="max-w-[1280px] mx-auto px-6 py-6 grid grid-cols-4 gap-6">';

                while ($mega_query->have_posts()):
                    $mega_query->the_post();
                    $img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    $item_output .= '<div class="mega-post-card group/card">';
                    if ($img) {
                        $item_output .= '<a href="' . get_permalink() . '" class="block aspect-video mb-3 overflow-hidden rounded-lg">';
                        $item_output .= '<img src="' . esc_url($img) . '" class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-105" alt="' . esc_attr(get_the_title()) . '">';
                        $item_output .= '</a>';
                    }
                    $item_output .= '<h4 class="font-bold text-sm leading-snug mb-1 text-gray-900 dark:text-gray-100"><a href="' . get_permalink() . '" class="hover:text-primary transition-colors">' . get_the_title() . '</a></h4>';
                    $item_output .= '<span class="text-xs text-gray-500">' . get_the_date() . '</span>';
                    $item_output .= '</div>';
                endwhile;
                wp_reset_postdata();

                $item_output .= '</div>'; // End container
                $item_output .= '</div>'; // End dropdown
            }
        }

        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
