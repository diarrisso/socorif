<?php
/**
 * Walkers pour les menus du footer
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

/**
 * Walker pour le menu de navigation du footer (style colonne)
 */
class Socorif_Footer_Nav_Walker extends Walker_Nav_Menu {

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<li>';

        $atts = array();
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = 'text-base font-normal leading-[22px] hover:underline transition-all duration-200';
        $atts['target'] = !empty($item->target) ? $item->target : '';

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $output .= '<a' . $attributes . '>' . esc_html($title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Walker pour les liens legaux du footer (style inline - haut du footer)
 */
class Socorif_Footer_Legal_Inline_Walker extends Walker_Nav_Menu {

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $atts = array();
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = 'text-sm text-gray-400 hover:text-white transition-all duration-200';
        $atts['target'] = !empty($item->target) ? $item->target : '';

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $output .= '<a' . $attributes . '>' . esc_html($title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        // Pas de balise de fermeture car pas de <li>
    }
}

// Alias pour compatibilite avec l'ancien code
class Beka_Footer_Walker extends Socorif_Footer_Nav_Walker {}
class Beka_Footer_Legal_Walker extends Socorif_Footer_Legal_Inline_Walker {}
