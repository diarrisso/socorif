<?php
/**
 * Configuration du bloc Cartes Services
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'services-cards',
        'title' => __('Cartes Services', 'socorif'),
        'description' => __('Grille de cartes de services', 'socorif'),
        'render_template' => 'template-parts/blocks/cartes-services/cartes-services.php',
        'category' => 'socorif-blocks',
        'icon' => 'grid-view',
        'keywords' => ['services', 'cards', 'grid', 'cartes'],
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
        'key' => 'group_services_cards_block',
        'title' => 'Bloc Cartes Services',
        'fields' => [
            // En-tete de section
            [
                'key' => 'field_services_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_services_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_services_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 2,
            ],
            // Cartes
            [
                'key' => 'field_services_cards',
                'label' => 'Cartes',
                'name' => 'cards',
                'type' => 'repeater',
                'min' => 1,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Ajouter une carte',
                'sub_fields' => [
                    [
                        'key' => 'field_card_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'wrapper' => ['width' => '30'],
                    ],
                    [
                        'key' => 'field_card_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => ['width' => '70'],
                    ],
                    [
                        'key' => 'field_card_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 2,
                    ],
                    [
                        'key' => 'field_card_link',
                        'label' => 'Lien',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                    ],
                ],
            ],
            // Mise en page
            [
                'key' => 'field_services_columns',
                'label' => 'Colonnes',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '2 colonnes',
                    '3' => '3 colonnes',
                    '4' => '4 colonnes',
                ],
                'default_value' => '3',
            ],
            // Arriere-plan
            [
                'key' => 'field_services_bg_color',
                'label' => 'Couleur de fond',
                'name' => 'bg_color',
                'type' => 'select',
                'choices' => [
                    'white' => 'Blanc',
                    'gray-50' => 'Gris clair',
                    'secondary-dark' => 'Bleu fonce',
                ],
                'default_value' => 'white',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/services-cards',
                ],
            ],
        ],
    ]);
});
