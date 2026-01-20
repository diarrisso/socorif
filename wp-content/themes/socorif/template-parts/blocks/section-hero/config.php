<?php
/**
 * Hero Section Block Configuration
 *
 * Bloc Hero pour pages de detail avec image de fond et informations
 */

if (!defined('ABSPATH')) exit;

/**
 * Register Hero Section Block
 */
if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'hero-section',
        'title' => __('Hero Section', 'beka'),
        'description' => __('Section Hero pour pages de detail avec image de fond et points forts', 'beka'),
        'render_template' => 'template-parts/blocks/hero-section/hero-section.php',
        'category' => 'beka-blocks',
        'icon' => 'welcome-view-site',
        'keywords' => ['hero', 'service', 'header', 'detail'],
        'supports' => [
            'align' => ['full'],
            'anchor' => true,
        ],
        'mode' => 'preview',
    ]);
}

/**
 * Register Hero Section Fields
 */
add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_hero_section_block',
        'title' => 'Bloc Hero Section',
        'fields' => [
            [
                'key' => 'field_hero_section_background_image',
                'label' => 'Image de fond',
                'name' => 'background_image',
                'type' => 'image',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Taille recommandee: 1920x1080px',
            ],
            [
                'key' => 'field_hero_section_overlay_opacity',
                'label' => 'Opacite du calque',
                'name' => 'overlay_opacity',
                'type' => 'range',
                'default_value' => 60,
                'min' => 0,
                'max' => 100,
                'step' => 10,
                'instructions' => 'Calque sombre sur l\'image de fond',
            ],
            [
                'key' => 'field_hero_section_breadcrumb',
                'label' => 'Navigation fil d\'Ariane',
                'name' => 'breadcrumb',
                'type' => 'repeater',
                'min' => 1,
                'max' => 5,
                'layout' => 'table',
                'button_label' => 'Ajouter un element',
                'instructions' => 'Chemin de navigation (ex: "Accueil > Services > Peinture")',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_section_breadcrumb_label',
                        'label' => 'Libelle',
                        'name' => 'label',
                        'type' => 'text',
                        'required' => 0,
                        'default_value' => 'Accueil',
                    ],
                    [
                        'key' => 'field_hero_section_breadcrumb_link',
                        'label' => 'Lien',
                        'name' => 'link',
                        'type' => 'url',
                        'instructions' => 'Laisser vide pour le dernier element (page actuelle)',
                    ],
                ],
            ],
            [
                'key' => 'field_hero_section_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
                'default_value' => 'Travaux de peinture professionnels',
            ],
            [
                'key' => 'field_hero_section_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',
                'default_value' => 'Qualite et precision depuis plus de 20 ans',
            ],
            [
                'key' => 'field_hero_section_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => 'Nous vous proposons des travaux de peinture de premiere qualite pour l\'interieur et l\'exterieur. Avec des techniques modernes et des materiaux de haute qualite, nous realisons vos projets.',
            ],
            [
                'key' => 'field_hero_section_key_features',
                'label' => 'Points forts',
                'name' => 'key_features',
                'type' => 'repeater',
                'min' => 0,
                'max' => 6,
                'layout' => 'table',
                'button_label' => 'Ajouter un point fort',
                'instructions' => 'Jusqu\'a 6 caracteristiques ou avantages importants',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_section_feature_icon',
                        'label' => 'Icone',
                        'name' => 'icon',
                        'type' => 'select',
                        'choices' => [
                            'check' => 'Coche',
                            'star' => 'Etoile',
                            'shield' => 'Bouclier',
                            'clock' => 'Horloge',
                            'users' => 'Personnes',
                            'award' => 'Recompense',
                        ],
                        'default_value' => 'check',
                    ],
                    [
                        'key' => 'field_hero_section_feature_text',
                        'label' => 'Texte',
                        'name' => 'text',
                        'type' => 'text',
                        'required' => 0,
                        'default_value' => 'Plus de 20 ans d\'experience',
                    ],
                ],
            ],
            [
                'key' => 'field_hero_section_cta_button',
                'label' => 'Bouton CTA',
                'name' => 'cta_button',
                'type' => 'link',
                'return_format' => 'array',
                'instructions' => 'Optionnel: Bouton d\'appel a l\'action',
            ],
            [
                'key' => 'field_hero_section_height',
                'label' => 'Hauteur',
                'name' => 'height',
                'type' => 'select',
                'choices' => [
                    'medium' => 'Moyenne (60vh)',
                    'large' => 'Grande (75vh)',
                    'xlarge' => 'Tres grande (90vh)',
                ],
                'default_value' => 'large',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/hero-section',
                ],
            ],
        ],
    ]);
});
