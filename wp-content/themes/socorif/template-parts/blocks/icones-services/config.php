<?php
/**
 * Configuration du bloc Icones Services
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'services-icons',
        'title' => __('Icones Services', 'socorif'),
        'description' => __('Grille de services avec icones', 'socorif'),
        'render_template' => 'template-parts/blocks/icones-services/icones-services.php',
        'category' => 'socorif-blocks',
        'icon' => 'screenoptions',
        'keywords' => ['services', 'icons', 'features', 'icones'],
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
        'key' => 'group_services_icons_block',
        'title' => 'Bloc Icones Services',
        'fields' => [
            // En-tete
            [
                'key' => 'field_sicons_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',
                'placeholder' => 'Ex: NOS SERVICES',
            ],
            [
                'key' => 'field_sicons_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
                'placeholder' => 'Ex: Notre specialisation',
            ],
            // Services
            [
                'key' => 'field_sicons_items',
                'label' => 'Services',
                'name' => 'services',
                'type' => 'repeater',
                'min' => 1,
                'max' => 8,
                'layout' => 'block',
                'button_label' => 'Ajouter un service',
                'sub_fields' => [
                    [
                        'key' => 'field_sicon_icon',
                        'label' => 'Icone',
                        'name' => 'icon',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'instructions' => 'SVG ou PNG avec fond transparent',
                    ],
                    [
                        'key' => 'field_sicon_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_sicon_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                    [
                        'key' => 'field_sicon_link',
                        'label' => 'Lien',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                    ],
                ],
            ],
            // Mise en page
            [
                'key' => 'field_sicons_columns',
                'label' => 'Colonnes',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '2 colonnes',
                    '3' => '3 colonnes',
                    '4' => '4 colonnes',
                ],
                'default_value' => '4',
            ],
            // Arriere-plan
            [
                'key' => 'field_sicons_bg_color',
                'label' => 'Couleur de fond',
                'name' => 'bg_color',
                'type' => 'select',
                'choices' => [
                    'white' => 'Blanc',
                    'gray-50' => 'Gris clair',
                ],
                'default_value' => 'gray-50',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/services-icons',
                ],
            ],
        ],
    ]);
});
