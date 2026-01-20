<?php
/**
 * Custom Nav Walker for Socorif Theme
 * Supports dropdown menus and mega-menus with hover functionality
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

class Beka_Nav_Walker extends Walker_Nav_Menu {

    /**
     * Track if current item is a mega-menu
     */
    private $is_mega_menu = false;

    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);

        if ($depth === 0 && $this->is_mega_menu) {
            // Mega-menu container - positioned fixed to avoid overflow issues
            $output .= "\n$indent<div class=\"mega-menu-dropdown absolute top-full left-1/2 -translate-x-1/2 mt-2 w-[600px] origin-top rounded-xl bg-white dark:bg-gray-800 shadow-2xl border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[100] p-6\">\n";
            $output .= "$indent\t<ul class=\"grid grid-cols-1 gap-1\">\n";
        } else {
            // Standard dropdown
            $output .= "\n$indent<ul class=\"absolute top-full left-0 mt-2 w-auto min-w-[14rem] origin-top-left rounded-lg bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-[100] py-2\">\n";
        }
    }

    /**
     * Ends the list after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);

        if ($depth === 0 && $this->is_mega_menu) {
            $output .= "$indent\t</ul>\n";
            $output .= "$indent</div>\n";
            // Reset mega-menu state after closing
            $this->is_mega_menu = false;
        } else {
            $output .= "$indent</ul>\n";
        }
    }

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Check if item has children
        $has_children = in_array('menu-item-has-children', $classes);

        // Check if this is a mega-menu item (add "mega-menu" CSS class in WordPress menu)
        $is_mega = in_array('mega-menu', $classes);

        // Store mega-menu state for start_lvl/end_lvl
        if ($depth === 0 && $has_children) {
            $this->is_mega_menu = $is_mega;
        }

        // Check if current item is active
        $is_active = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);

        // Build li classes
        $li_classes = array();

        if ($depth === 0) {
            $li_classes[] = 'relative';
            if ($has_children) {
                $li_classes[] = 'group';
            }
        } elseif ($depth === 1 && $this->is_mega_menu) {
            // Mega-menu child items
            $li_classes[] = 'mega-menu-item';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($li_classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        // Build link attributes
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';

        // Disable link for items with sub-menus at depth 0
        if ($has_children && $depth === 0) {
            $atts['href'] = '#';
            $atts['role'] = 'button';
            $atts['aria-expanded'] = 'false';
        } else {
            $atts['href'] = !empty($item->url) ? $item->url : '';
        }

        // Link classes based on depth
        if ($depth === 0) {
            $base_classes = 'nav-item relative text-base font-medium text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors duration-300 inline-flex items-center gap-1 py-3 px-4 cursor-pointer';

            if ($is_active) {
                $base_classes .= ' text-primary dark:text-primary';
            }

            $atts['class'] = $base_classes;
        } elseif ($depth === 1 && $this->is_mega_menu) {
            // Mega-menu item styles
            $mega_classes = 'group/item flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 cursor-pointer';

            if ($is_active) {
                $mega_classes .= ' bg-primary/5 dark:bg-primary/10';
            }

            $atts['class'] = $mega_classes;
        } else {
            // Standard dropdown item
            $dropdown_classes = 'block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-all duration-200 cursor-pointer';

            if ($is_active) {
                $dropdown_classes .= ' bg-gray-50 dark:bg-gray-700 text-primary';
            }

            $atts['class'] = $dropdown_classes;
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';

        // Mega-menu items with icon
        if ($depth === 1 && $this->is_mega_menu) {
            // Icon container
            $item_output .= '<span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-primary/10 dark:bg-primary/20 text-primary group-hover/item:bg-primary group-hover/item:text-white transition-colors duration-200">';
            $item_output .= $this->get_menu_icon($item->title);
            $item_output .= '</span>';
            $item_output .= '<span class="flex flex-col">';
            $item_output .= '<span class="text-sm font-semibold text-gray-900 dark:text-white group-hover/item:text-primary dark:group-hover/item:text-primary transition-colors">' . apply_filters('the_title', $item->title, $item->ID) . '</span>';

            // Add description if available
            if (!empty($item->description)) {
                $item_output .= '<span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">' . esc_html($item->description) . '</span>';
            }
            $item_output .= '</span>';
        } else {
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        }

        // Add dropdown arrow for parent items at depth 0
        if ($has_children && $depth === 0) {
            $item_output .= '<svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Ends the element output.
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }

    /**
     * Get icon SVG based on menu item title
     */
    private function get_menu_icon(string $title): string {
        $title_lower = strtolower($title);

        // Property-related icons
        if (strpos($title_lower, 'propriet') !== false || strpos($title_lower, 'bien') !== false || strpos($title_lower, 'vente') !== false) {
            return '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>';
        }

        // Land/terrain icons
        if (strpos($title_lower, 'terrain') !== false || strpos($title_lower, 'foncier') !== false || strpos($title_lower, 'opportunit') !== false) {
            return '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>';
        }

        // Project icons
        if (strpos($title_lower, 'projet') !== false || strpos($title_lower, 'realisation') !== false) {
            return '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
        }

        // Service icons
        if (strpos($title_lower, 'service') !== false || strpos($title_lower, 'gestion') !== false) {
            return '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>';
        }

        // Location icons
        if (strpos($title_lower, 'location') !== false || strpos($title_lower, 'louer') !== false) {
            return '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>';
        }

        // Default icon
        return '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>';
    }
}