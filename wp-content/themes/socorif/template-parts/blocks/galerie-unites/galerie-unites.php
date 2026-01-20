<?php
/**
 * Block: Galerie avec Unites
 *
 * Affiche une galerie d'images a gauche et un accordeon d'unites a droite
 * Utilise le composant reutilisable property-gallery-units
 */

if (!defined('ABSPATH')) exit;

// Get fields from flexible content
$title = get_sub_field('title') ?: '';
$gallery = get_sub_field('gallery') ?: [];
$units = get_sub_field('units') ?: [];
$bg_color = get_sub_field('bg_color') ?: 'white';

// Skip if no content
if (empty($gallery) && empty($units)) {
    return;
}

// Load the reusable component
get_template_part('template-parts/components/property-gallery-units', null, [
    'title' => $title,
    'gallery' => $gallery,
    'units' => $units,
    'bg_color' => $bg_color,
]);
