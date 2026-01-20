<?php
/**
 * Fonctions utilitaires HTML
 */

if (!defined('ABSPATH')) exit;

/**
 * Creer une chaine d'attributs HTML a partir d'un tableau
 */
function socorif_build_attrs($attrs) {
    $result = [];

    foreach ($attrs as $key => $value) {
        if ($value === true) {
            $result[] = esc_attr($key);
        } elseif ($value !== false && $value !== null && $value !== '') {
            $result[] = esc_attr($key) . '="' . esc_attr($value) . '"';
        }
    }

    return implode(' ', $result);
}

/**
 * Afficher une image avec chargement paresseux
 */
function socorif_image($image, $size = 'large', $attrs = []) {
    if (empty($image)) return '';

    // ACF retourne soit 'ID' (majuscule) soit 'id' (minuscule)
    if (is_array($image)) {
        $image_id = $image['ID'] ?? $image['id'] ?? 0;
    } else {
        $image_id = $image;
    }

    // Si pas d'ID valide, retourner une chaine vide
    if (empty($image_id)) return '';

    $default_attrs = [
        'loading' => 'lazy',
        'decoding' => 'async',
    ];

    $attrs = array_merge($default_attrs, $attrs);

    return wp_get_attachment_image($image_id, $size, false, $attrs);
}

/**
 * Recuperer le srcset d'une image responsive
 */
function socorif_get_srcset($image_id, $sizes = []) {
    if (empty($sizes)) {
        $sizes = ['thumbnail', 'medium', 'large', 'full'];
    }

    $srcset = [];

    foreach ($sizes as $size) {
        $img = wp_get_attachment_image_src($image_id, $size);
        if ($img) {
            $srcset[] = $img[0] . ' ' . $img[1] . 'w';
        }
    }

    return implode(', ', $srcset);
}

/**
 * Fonction utilitaire pour les icones SVG
 */
function socorif_icon($name, $class = '') {
    $icons_path = get_template_directory() . '/assets/icons/' . $name . '.svg';

    if (file_exists($icons_path)) {
        $svg = file_get_contents($icons_path);

        if ($class) {
            $svg = str_replace('<svg', '<svg class="' . esc_attr($class) . '"', $svg);
        }

        return $svg;
    }

    return '';
}

/**
 * Affichage securise avec valeur par defaut
 */
function socorif_output($value, $default = '') {
    return !empty($value) ? esc_html($value) : esc_html($default);
}

/**
 * Afficher un lien avec attributs
 */
function socorif_link($link, $class = '', $extra_attrs = []) {
    if (empty($link)) return '';

    $attrs = [
        'href' => $link['url'] ?? '#',
        'target' => $link['target'] ?? '_self',
        'class' => $class,
    ];

    if (!empty($link['target']) && $link['target'] === '_blank') {
        $attrs['rel'] = 'noopener noreferrer';
    }

    $attrs = array_merge($attrs, $extra_attrs);

    $text = $link['title'] ?? __('En savoir plus', 'socorif');

    return sprintf(
        '<a %s>%s</a>',
        socorif_build_attrs($attrs),
        esc_html($text)
    );
}
