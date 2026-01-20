<?php
/**
 * Hero Split Block Configuration
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'hero-split',
        'title' => __('Hero Divise', 'beka'),
        'description' => __('Section Hero avec mise en page divisee: texte a gauche, image a droite', 'beka'),
        'render_template' => 'template-parts/blocks/hero-split/hero-split.php',
        'category' => 'beka-blocks',
        'icon' => 'align-pull-left',
        'keywords' => ['hero', 'split', 'image', 'banner'],
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
        'key' => 'group_hero_split',
        'title' => 'Hero Divise',
        'fields' => [
            [
                'key' => 'field_hero_split_badge_text',
                'label' => 'Texte du badge',
                'name' => 'badge_text',
                'type' => 'text',
                'instructions' => 'Texte de badge optionnel au-dessus du titre',
            ],
            [
                'key' => 'field_hero_split_badge_link',
                'label' => 'Lien du badge',
                'name' => 'badge_link',
                'type' => 'url',
                'instructions' => 'Lien optionnel pour le badge',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_hero_split_badge_text',
                            'operator' => '!=empty',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_hero_split_heading',
                'label' => 'Titre',
                'name' => 'heading',
                'type' => 'text',
                'required' => 1,
                'default_value' => 'Votre entreprise en vedette',
                'instructions' => 'Grand titre principal',
            ],
            [
                'key' => 'field_hero_split_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => 'Texte descriptif sous le titre',
            ],
            [
                'key' => 'field_hero_split_primary_button_text',
                'label' => 'Texte bouton principal',
                'name' => 'primary_button_text',
                'type' => 'text',
                'instructions' => 'Texte du bouton principal',
            ],
            [
                'key' => 'field_hero_split_primary_button_link',
                'label' => 'Lien bouton principal',
                'name' => 'primary_button_link',
                'type' => 'url',
                'instructions' => 'Lien du bouton principal',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_hero_split_primary_button_text',
                            'operator' => '!=empty',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_hero_split_secondary_button_text',
                'label' => 'Texte bouton secondaire',
                'name' => 'secondary_button_text',
                'type' => 'text',
                'instructions' => 'Texte du bouton secondaire (lien texte)',
            ],
            [
                'key' => 'field_hero_split_secondary_button_link',
                'label' => 'Lien bouton secondaire',
                'name' => 'secondary_button_link',
                'type' => 'url',
                'instructions' => 'Lien du bouton secondaire',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_hero_split_secondary_button_text',
                            'operator' => '!=empty',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_hero_split_image',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'required' => 1,
                'return_format' => 'array',
                'preview_size' => 'large',
                'library' => 'all',
                'instructions' => 'Grande image Hero (largeur minimale de 1200px recommandee)',
            ],
            [
                'key' => 'field_hero_split_show_decorative_svg',
                'label' => 'Afficher le polygone decoratif',
                'name' => 'show_decorative_svg',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'instructions' => 'Affiche la transition SVG diagonale entre le texte et l\'image',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/hero-split',
                ],
            ],
        ],
    ]);
});
