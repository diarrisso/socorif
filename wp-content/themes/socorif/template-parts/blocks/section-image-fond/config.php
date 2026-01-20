<?php
/**
 * Background Image Section Block Configuration
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'background-image-section',
        'title' => __('Section Image de Fond', 'beka'),
        'description' => __('Grande section avec image de fond et coins arrondis optionnels', 'beka'),
        'render_template' => 'template-parts/blocks/background-image-section/background-image-section.php',
        'category' => 'beka-blocks',
        'icon' => 'format-image',
        'keywords' => ['image', 'background', 'hero', 'fond'],
        'supports' => [
            'align' => ['wide', 'full'],
            'anchor' => true,
        ],
        'mode' => 'preview',
    ]);
}

add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_background_image_section',
        'title' => 'Section Image de Fond',
        'fields' => [
            [
                'key' => 'field_bg_image',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'required' => 1,
                'return_format' => 'array',
                'preview_size' => 'large',
                'library' => 'all',
                'instructions' => 'Selectionnez une grande image (largeur minimale de 2000px recommandee)',
            ],
            [
                'key' => 'field_bg_image_alt',
                'label' => 'Texte alternatif',
                'name' => 'alt_text',
                'type' => 'text',
                'instructions' => 'Texte alternatif pour l\'accessibilite',
            ],
            [
                'key' => 'field_bg_rounded',
                'label' => 'Coins arrondis',
                'name' => 'rounded',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'instructions' => 'Affiche des coins arrondis sur ordinateur',
            ],
            [
                'key' => 'field_bg_aspect_ratio',
                'label' => 'Ratio d\'aspect',
                'name' => 'aspect_ratio',
                'type' => 'select',
                'choices' => [
                    'aspect-video' => '16:9 (Video)',
                    'aspect-[5/2]' => '5:2 (Large)',
                    'aspect-[21/9]' => '21:9 (Ultra-large)',
                    'aspect-[3/1]' => '3:1 (Banniere)',
                    'aspect-square' => '1:1 (Carre)',
                ],
                'default_value' => 'aspect-[5/2]',
                'instructions' => 'Selectionnez le ratio d\'aspect de l\'image',
            ],
            [
                'key' => 'field_bg_spacing_top',
                'label' => 'Espacement haut',
                'name' => 'spacing_top',
                'type' => 'select',
                'choices' => [
                    'mt-16 sm:mt-20' => 'Normal',
                    'mt-24 sm:mt-32' => 'Grand',
                    'mt-32 sm:mt-40' => 'Tres grand',
                    'mt-0' => 'Aucun espacement',
                ],
                'default_value' => 'mt-32 sm:mt-40',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/background-image-section',
                ],
            ],
        ],
    ]);
});
