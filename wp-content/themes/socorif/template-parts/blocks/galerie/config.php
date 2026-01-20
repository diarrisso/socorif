<?php
/**
 * Configuration du bloc Galerie
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'gallery',
        'title' => __('Galerie', 'socorif'),
        'description' => __('Galerie d\'images avec lightbox', 'socorif'),
        'render_template' => 'template-parts/blocks/galerie/galerie.php',
        'category' => 'socorif-blocks',
        'icon' => 'format-gallery',
        'keywords' => ['gallery', 'images', 'photos', 'galerie'],
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
        'key' => 'group_gallery_block',
        'title' => 'Bloc Galerie',
        'fields' => [
            [
                'key' => 'field_gallery_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_gallery_images',
                'label' => 'Images',
                'name' => 'images',
                'type' => 'repeater',
                'min' => 1,
                'max' => 12,
                'layout' => 'block',
                'button_label' => 'Ajouter une image',
                'sub_fields' => [
                    [
                        'key' => 'field_gallery_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'required' => 0,
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                    ],
                    [
                        'key' => 'field_gallery_caption',
                        'label' => 'Legende',
                        'name' => 'caption',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'key' => 'field_gallery_columns',
                'label' => 'Colonnes',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '2 colonnes',
                    '3' => '3 colonnes',
                    '4' => '4 colonnes',
                ],
                'default_value' => '2',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/gallery',
                ],
            ],
        ],
    ]);
});
