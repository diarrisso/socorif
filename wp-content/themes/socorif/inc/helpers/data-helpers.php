<?php
/**
 * Data Helper Functions
 */

if (!defined('ABSPATH')) exit;

/**
 * Smart field getter - works with both ACF blocks and Flexible Content
 * Uses get_sub_field() when inside a flexible content row, otherwise get_field()
 */
function socorif_get_field($field_name, $default = '', $post_id = false) {
    // Check if we're inside a flexible content row
    global $wp_query;
    if (function_exists('get_row_layout') && get_row_layout()) {
        $value = get_sub_field($field_name);
    } else {
        $value = get_field($field_name, $post_id);
    }

    return ($value !== null && $value !== '' && $value !== false) ? $value : $default;
}

/**
 * Get sub field with default value
 */
function socorif_get_sub_field($field_name, $default = '') {
    $value = get_sub_field($field_name);
    return !empty($value) ? $value : $default;
}

/**
 * Check if field has value
 */
function socorif_has_field($field_name, $post_id = false) {
    $value = get_field($field_name, $post_id);
    return !empty($value);
}

/**
 * Get repeater field as array
 */
function socorif_get_repeater($field_name, $post_id = false) {
    $rows = get_field($field_name, $post_id);
    return is_array($rows) ? $rows : [];
}

/**
 * Get flexible content layouts
 */
function socorif_get_flexible_content($field_name, $post_id = false) {
    $layouts = get_field($field_name, $post_id);
    return is_array($layouts) ? $layouts : [];
}

/**
 * Format phone number for tel: link
 */
function socorif_format_phone($phone) {
    return preg_replace('/[^0-9+]/', '', $phone);
}

/**
 * Truncate text with ellipsis
 */
function socorif_truncate($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . $suffix;
}

/**
 * Get post terms as array
 */
function socorif_get_terms($post_id, $taxonomy) {
    $terms = get_the_terms($post_id, $taxonomy);
    return is_array($terms) ? $terms : [];
}

/**
 * Get ACF options field
 */
function socorif_get_option($field_name, $default = '') {
    $value = get_field($field_name, 'option');
    return !empty($value) ? $value : $default;
}

/**
 * Parse video URL to get embed URL
 */
function socorif_get_video_embed_url($url) {
    // YouTube
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches) ||
        preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    // Vimeo
    if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
        return 'https://player.vimeo.com/video/' . $matches[1];
    }

    return $url;
}

/**
 * Get spacing classes from field values
 *
 * @param string $spacing Spacing value (none|small|normal|large)
 * @return string CSS classes
 */
function socorif_get_spacing_classes($spacing = 'normal') {
    $spacing_map = [
        'none' => 'py-0',
        'small' => 'py-8 md:py-12',
        'normal' => 'py-12 md:py-16 lg:py-24',
        'large' => 'py-16 md:py-24 lg:py-32',
    ];

    return $spacing_map[$spacing] ?? $spacing_map['normal'];
}

/**
 * Generer automatiquement le fil d'Ariane base sur la hierarchie des pages
 *
 * @param int|null $post_id ID du post (defaut: post actuel)
 * @param bool $include_home Inclure la page d'accueil (defaut: true)
 * @return array Elements du fil d'Ariane avec 'label' et 'link'
 */
function socorif_generate_breadcrumb($post_id = null, $include_home = true) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $breadcrumb = [];

    // Ajouter la page d'accueil
    if ($include_home) {
        $breadcrumb[] = [
            'label' => 'Accueil',
            'link' => home_url('/'),
        ];
    }

    // Recuperer la hierarchie des pages
    $post = get_post($post_id);
    if (!$post) {
        return $breadcrumb;
    }

    // Collecter les pages parentes
    $ancestors = array_reverse(get_post_ancestors($post_id));
    foreach ($ancestors as $ancestor_id) {
        $ancestor = get_post($ancestor_id);
        if ($ancestor) {
            $breadcrumb[] = [
                'label' => get_the_title($ancestor_id),
                'link' => get_permalink($ancestor_id),
            ];
        }
    }

    // Ajouter la page actuelle (sans lien)
    $breadcrumb[] = [
        'label' => get_the_title($post_id),
        'link' => '',
    ];

    return $breadcrumb;
}

/**
 * Generer le fil d'Ariane avec taxonomie de Custom Post Type
 *
 * @param int|null $post_id ID du post
 * @param string $taxonomy Nom de la taxonomie (ex: 'category', 'post_tag')
 * @return array Elements du fil d'Ariane
 */
function socorif_generate_breadcrumb_with_taxonomy($post_id = null, $taxonomy = 'category') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $breadcrumb = [];
    $post = get_post($post_id);

    if (!$post) {
        return $breadcrumb;
    }

    // Page d'accueil
    $breadcrumb[] = [
        'label' => 'Accueil',
        'link' => home_url('/'),
    ];

    // Lien vers l'archive du Post Type (si disponible)
    $post_type = get_post_type($post_id);
    $post_type_object = get_post_type_object($post_type);

    if ($post_type !== 'page' && $post_type_object && $post_type_object->has_archive) {
        $breadcrumb[] = [
            'label' => $post_type_object->labels->name,
            'link' => get_post_type_archive_link($post_type),
        ];
    }

    // Ajouter le terme de taxonomie (premier terme trouve)
    if (taxonomy_exists($taxonomy)) {
        $terms = get_the_terms($post_id, $taxonomy);
        if ($terms && !is_wp_error($terms)) {
            $term = reset($terms); // Prendre le premier terme
            $breadcrumb[] = [
                'label' => $term->name,
                'link' => get_term_link($term),
            ];
        }
    }

    // Page actuelle
    $breadcrumb[] = [
        'label' => get_the_title($post_id),
        'link' => '',
    ];

    return $breadcrumb;
}
