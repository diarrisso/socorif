<?php
/**
 * Configuration du bloc Section CTA
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'section-cta',
        'title' => __('Section CTA', 'socorif'),
        'description' => __('Section avec image et texte cote a cote', 'socorif'),
        'render_template' => 'template-parts/blocks/cta-divise/cta-divise.php',
        'category' => 'socorif-blocks',
        'icon' => 'columns',
        'keywords' => ['cta', 'image', 'text', 'columns'],
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
        'key' => 'group_section_cta_block',
        'title' => 'Bloc Section CTA',
        'fields' => [
            // Image
            [
                'key' => 'field_cta_image',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            // Contenu
            [
                'key' => 'field_cta_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_cta_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'key' => 'field_cta_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 4,
            ],
            [
                'key' => 'field_cta_button',
                'label' => 'Bouton',
                'name' => 'button',
                'type' => 'link',
                'return_format' => 'array',
            ],
            // Mise en page
            [
                'key' => 'field_cta_image_position',
                'label' => 'Position de l\'image',
                'name' => 'image_position',
                'type' => 'select',
                'choices' => [
                    'left' => 'Gauche',
                    'right' => 'Droite',
                ],
                'default_value' => 'left',
            ],
            // Arriere-plan
            [
                'key' => 'field_cta_bg_color',
                'label' => 'Couleur de fond',
                'name' => 'bg_color',
                'type' => 'select',
                'choices' => [
                    'white' => 'Blanc',
                    'gray-50' => 'Gris clair',
                    'secondary-dark' => 'Bleu fonce',
                ],
                'default_value' => 'gray-50',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/section-cta',
                ],
            ],
        ],
    ]);
});
