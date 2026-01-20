<?php
/**
 * Configuration du bloc Accordeon
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'socorif-accordion',
        'title' => __('Accordeon', 'socorif'),
        'description' => __('Accordeon avec questions/reponses', 'socorif'),
        'render_template' => 'template-parts/blocks/accordeon/accordeon.php',
        'category' => 'socorif-blocks',
        'icon' => 'list-view',
        'keywords' => ['accordion', 'faq', 'toggle', 'accordeon'],
        'supports' => [
            'align' => ['wide', 'full'],
            'mode' => true,
            'jsx' => true,
        ],
    ]);
}

add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_accordion_block',
        'title' => 'Accordeon',
        'fields' => [
            [
                'key' => 'field_accordion_title',
                'label' => 'Titre de section',
                'name' => 'accordion_title',
                'type' => 'text',
            ],
            [
                'key' => 'field_accordion_items',
                'label' => 'Elements',
                'name' => 'accordion_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Ajouter un element',
                'sub_fields' => [
                    [
                        'key' => 'field_accordion_item_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 0,
                    ],
                    [
                        'key' => 'field_accordion_item_content',
                        'label' => 'Contenu',
                        'name' => 'content',
                        'type' => 'wysiwyg',
                        'tabs' => 'all',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                    ],
                ],
            ],
            [
                'key' => 'field_accordion_allow_multiple',
                'label' => 'Ouvrir plusieurs en meme temps',
                'name' => 'allow_multiple',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/socorif-accordion',
                ],
            ],
        ],
    ]);
});
