<?php
/**
 * Before After Block Configuration
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'before-after',
        'title' => __('Avant/Apres', 'beka'),
        'description' => __('Comparaison avant/apres avec curseur', 'beka'),
        'render_template' => 'template-parts/blocks/before-after/before-after.php',
        'category' => 'beka-blocks',
        'icon' => 'image-flip-horizontal',
        'keywords' => ['before', 'after', 'compare', 'slider'],
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
        'key' => 'group_before_after_block',
        'title' => 'Bloc Avant Apres',
        'fields' => [
            // Header
            [
                'key' => 'field_ba_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_ba_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
            ],
            // Images
            [
                'key' => 'field_ba_before_image',
                'label' => 'Image Avant',
                'name' => 'before_image',
                'type' => 'image',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_ba_after_image',
                'label' => 'Image Apres',
                'name' => 'after_image',
                'type' => 'image',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            // Labels
            [
                'key' => 'field_ba_before_label',
                'label' => 'Libelle Avant',
                'name' => 'before_label',
                'type' => 'text',
                'default_value' => 'Avant',
            ],
            [
                'key' => 'field_ba_after_label',
                'label' => 'Libelle Apres',
                'name' => 'after_label',
                'type' => 'text',
                'default_value' => 'Apres',
            ],
            // Description
            [
                'key' => 'field_ba_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 3,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/before-after',
                ],
            ],
        ],
    ]);
});
