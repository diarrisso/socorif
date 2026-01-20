<?php
/**
 * Configuration du bloc Clients
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'clients',
        'title' => __('Clients', 'socorif'),
        'description' => __('Logos de clients/partenaires', 'socorif'),
        'render_template' => 'template-parts/blocks/clients/clients.php',
        'category' => 'socorif-blocks',
        'icon' => 'networking',
        'keywords' => ['clients', 'logos', 'partners', 'partenaires'],
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
        'key' => 'group_clients_block',
        'title' => 'Bloc Clients',
        'fields' => [
            [
                'key' => 'field_clients_logos',
                'label' => 'Logos',
                'name' => 'logos',
                'type' => 'repeater',
                'min' => 1,
                'max' => 12,
                'layout' => 'table',
                'button_label' => 'Ajouter un logo',
                'sub_fields' => [
                    [
                        'key' => 'field_client_logo',
                        'label' => 'Logo',
                        'name' => 'logo',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                    ],
                    [
                        'key' => 'field_client_name',
                        'label' => 'Nom',
                        'name' => 'name',
                        'type' => 'text',
                        'instructions' => 'Pour l\'attribut alt',
                    ],
                    [
                        'key' => 'field_client_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ],
                ],
            ],
            [
                'key' => 'field_clients_grayscale',
                'label' => 'Logos en niveaux de gris',
                'name' => 'grayscale',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/clients',
                ],
            ],
        ],
    ]);
});
