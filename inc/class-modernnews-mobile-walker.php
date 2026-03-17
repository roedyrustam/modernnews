<?php
if (!defined('ABSPATH')) {
    exit;
}

class ModernNews_Mobile_Walker extends Walker_Nav_Menu
{
    /**
     * Helper to map menu titles to Material Symbols
     */
    private function get_menu_icon($title, $item_id)
    {
        $title = strtolower($title);
        
        // Manual mapping from common news categories
        $mapping = array(
            'beranda' => 'home',
            'home' => 'home',
            'politik' => 'policy',
            'ekonomi' => 'payments',
            'bisnis' => 'business_center',
            'olahraga' => 'sports_soccer',
            'bola' => 'sports_soccer',
            'teknologi' => 'devices',
            'tekno' => 'devices',
            'gaya hidup' => 'lifestyle',
            'hiburan' => 'movie',
            'entertainment' => 'movie',
            'nasional' => 'public',
            'internasional' => 'language',
            'kesehatan' => 'medical_services',
            'edukasi' => 'school',
            'otomotif' => 'directions_car',
            'kuliner' => 'restaurant',
            'wisata' => 'travel_explore',
            'trending' => 'trending_up',
            'viral' => 'bolt',
            'video' => 'play_circle',
            'galeri' => 'photo_library',
        );

        foreach ($mapping as $key => $icon) {
            if (strpos($title, $key) !== false) {
                return $icon;
            }
        }

        return 'article'; // Default icon
    }

    function start_lvl(&$output, $depth = 0, $args = null)
    {
        // Submenu container
        $output .= '<ul class="hidden flex-col gap-1 border-l-2 border-dashed border-gray-100 dark:border-zinc-800 ml-8 mb-2">';
    }

    function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</ul>';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Base Output
        $output .= $indent . '<li class="' . implode(' ', $classes) . '">';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        // Native List Item Style
        $atts['class'] = 'flex items-center justify-between w-full p-2.5 rounded-xl transition-all group';

        // Check for children
        $has_children = in_array('menu-item-has-children', $classes) || !empty($item->has_children);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $icon = $this->get_menu_icon($title, $item->ID);

        // Content
        $item_output = isset($args->before) ? $args->before : '';

        $item_output .= '<div class="flex items-center justify-between w-full gap-2">';
        $item_output .= '<a' . $attributes . ' class="flex-1 flex items-center gap-3.5">';
        
        // Icon Container
        if ($depth === 0) {
            $item_output .= '<div class="size-10 rounded-xl bg-gray-50 dark:bg-zinc-800/50 flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">';
            $item_output .= '<span class="material-symbols-outlined text-[20px]">' . $icon . '</span>';
            $item_output .= '</div>';
            $item_output .= '<span class="font-bold text-[15px] text-gray-700 dark:text-gray-200 group-hover:text-primary">' . $title . '</span>';
        } else {
            $item_output .= '<span class="font-medium text-[14px] text-gray-600 dark:text-gray-400 group-hover:text-primary py-1.5">' . $title . '</span>';
        }
        
        $item_output .= '</a>';

        if ($has_children) {
            // Toggle Button
            $item_output .= '<button class="mobile-menu-toggle size-10 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none">';
            $item_output .= '<span class="material-symbols-outlined text-[20px] transition-transform duration-300">expand_more</span>';
            $item_output .= '</button>';
        }
        $item_output .= '</div>'; // End flex wrapper

        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
