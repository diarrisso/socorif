<?php
/**
 * Configuration du bloc Partenaires
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'partners',
        'title' => __('Partenaires', 'socorif'),
        'description' => __('Logos partenaires avec support mode sombre', 'socorif'),
        'render_template' => 'template-parts/blocks/partenaires/partenaires.php',
        'category' => 'socorif-blocks',
        'icon' => 'groups',
        'keywords' => ['partners', 'logos', 'companies', 'clients', 'partenaires'],
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
        'key' => 'group_partners_block',
        'title' => 'Bloc Partenaires',
        'fields' => [
            [
                'key' => 'field_partners_logos',
                'label' => 'Logos partenaires',
                'name' => 'partners',
                'type' => 'repeater',
                'min' => 1,
                'max' => 10,
                'layout' => 'block',
                'button_label' => 'Ajouter un partenaire',
                'sub_fields' => [
                    [
                        'key' => 'field_partner_logo_light',
                        'label' => 'Logo (Clair)',
                        'name' => 'logo_light',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'instructions' => 'Logo pour mode clair (logo sombre sur fond clair)',
                        'required' => false,
                    ],
                    [
                        'key' => 'field_partner_logo_dark',
                        'label' => 'Logo (Sombre)',
                        'name' => 'logo_dark',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'instructions' => 'Logo pour mode sombre (logo clair sur fond sombre)',
                        'required' => false,
                    ],
                    [
                        'key' => 'field_partner_alt',
                        'label' => 'Texte alternatif',
                        'name' => 'alt_text',
                        'type' => 'text',
                        'instructions' => 'Nom de l\'entreprise pour l\'accessibilite',
                        'default_value' => 'Logo partenaire',
                    ],
                ],
            ],
            [
                'key' => 'field_partners_badge_section',
                'label' => 'Section badge',
                'name' => 'badge_section',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_partners_show_badge',
                        'label' => 'Afficher le badge',
                        'name' => 'show_badge',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                    ],
                    [
                        'key' => 'field_partners_badge_text',
                        'label' => 'Texte du badge',
                        'name' => 'badge_text',
                        'type' => 'text',
                        'default_value' => 'Plus de 2500 entreprises font confiance a nos services.',
                        'conditional_logic' => [
                            [
                                [
                                    'field' => 'field_partners_show_badge',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_partners_badge_link_text',
                        'label' => 'Texte du lien',
                        'name' => 'badge_link_text',
                        'type' => 'text',
                        'default_value' => 'Lire les temoignages',
                        'conditional_logic' => [
                            [
                                [
                                    'field' => 'field_partners_show_badge',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_partners_badge_link',
                        'label' => 'Lien',
                        'name' => 'badge_link',
                        'type' => 'link',
                        'return_format' => 'array',
                        'conditional_logic' => [
                            [
                                [
                                    'field' => 'field_partners_show_badge',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/partners',
                ],
            ],
        ],
    ]);
});
