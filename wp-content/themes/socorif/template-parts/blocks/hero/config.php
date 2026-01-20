<?php
/**
 * Configuration du bloc Hero
 */

if (!defined('ABSPATH')) exit;

/**
 * Enregistrer le bloc Hero
 */
if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'hero',
        'title' => __('Hero', 'socorif'),
        'description' => __('Section hero avec image de fond, titre et CTA', 'socorif'),
        'render_template' => 'template-parts/blocks/hero/hero.php',
        'category' => 'socorif-blocks',
        'icon' => 'cover-image',
        'keywords' => ['hero', 'banner', 'header'],
        'supports' => [
            'align' => ['full'],
            'anchor' => true,
        ],
        'mode' => 'preview',
    ]);
}

/**
 * Enregistrer les champs Hero
 */
add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_hero_block',
        'title' => 'Bloc Hero',
        'fields' => [
            [
                'key' => 'field_hero_background_image',
                'label' => 'Image de fond',
                'name' => 'background_image',
                'type' => 'image',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_hero_overlay_opacity',
                'label' => 'Opacite de l\'overlay',
                'name' => 'overlay_opacity',
                'type' => 'range',
                'default_value' => 50,
                'min' => 0,
                'max' => 100,
                'step' => 10,
            ],
            [
                'key' => 'field_hero_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_hero_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
                'required' => false,
            ],
            [
                'key' => 'field_hero_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_hero_height',
                'label' => 'Hauteur',
                'name' => 'height',
                'type' => 'select',
                'choices' => [
                    'auto' => 'Automatique',
                    'screen' => 'Plein ecran',
                    'large' => 'Grande (80vh)',
                    'medium' => 'Moyenne (60vh)',
                ],
                'default_value' => 'large',
            ],
            [
                'key' => 'field_hero_text_align',
                'label' => 'Alignement du texte',
                'name' => 'text_align',
                'type' => 'select',
                'choices' => [
                    'left' => 'Gauche',
                    'center' => 'Centre',
                ],
                'default_value' => 'center',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/hero',
                ],
            ],
        ],
    ]);
});
