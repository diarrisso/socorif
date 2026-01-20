<?php
/**
 * Configuration du bloc A propos
 * Mise en page moderne avec mission, mosaique d'images et statistiques
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'about',
        'title' => __('A propos', 'socorif'),
        'description' => __('Section A propos avec mission, mosaique d\'images et statistiques', 'socorif'),
        'render_template' => 'template-parts/blocks/a-propos/a-propos.php',
        'category' => 'socorif-blocks',
        'icon' => 'info-outline',
        'keywords' => ['about', 'mission', 'company', 'statistics'],
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
        'key' => 'group_about_block',
        'title' => 'Bloc A propos',
        'fields' => [
            // Section Introduction
            [
                'key' => 'field_about_intro_label',
                'label' => 'Label d\'introduction',
                'name' => 'intro_label',
                'type' => 'text',
                'instructions' => 'Petit texte au-dessus du titre (ex: "A propos")',
                'placeholder' => 'A propos',
            ],
            [
                'key' => 'field_about_title',
                'label' => 'Titre principal',
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
                'instructions' => 'Grand titre H1 de la section',
                'placeholder' => 'Notre mission est d\'accompagner vos projets immobiliers',
            ],
            [
                'key' => 'field_about_intro_text',
                'label' => 'Texte d\'introduction',
                'name' => 'intro_text',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => 'Court texte d\'introduction sous le titre',
            ],

            // Section Mission
            [
                'key' => 'field_about_mission_title',
                'label' => 'Titre mission',
                'name' => 'mission_title',
                'type' => 'text',
                'instructions' => 'Titre de la section mission',
                'placeholder' => 'Notre mission',
            ],
            [
                'key' => 'field_about_mission_text_1',
                'label' => 'Texte mission 1',
                'name' => 'mission_text_1',
                'type' => 'textarea',
                'rows' => 4,
                'instructions' => 'Premier paragraphe de la description de la mission',
            ],
            [
                'key' => 'field_about_mission_text_2',
                'label' => 'Texte mission 2',
                'name' => 'mission_text_2',
                'type' => 'textarea',
                'rows' => 4,
                'instructions' => 'Deuxieme paragraphe de la description de la mission',
            ],

            // Mosaique d'images
            [
                'key' => 'field_about_image_1',
                'label' => 'Image 1 (haut gauche)',
                'name' => 'image_1',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Premiere image de la mosaique (haut gauche)',
            ],
            [
                'key' => 'field_about_image_2',
                'label' => 'Image 2 (haut droite, decalee)',
                'name' => 'image_2',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Deuxieme image de la mosaique (haut droite, decalee vers le bas)',
            ],
            [
                'key' => 'field_about_image_3',
                'label' => 'Image 3 (bas gauche)',
                'name' => 'image_3',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Troisieme image de la mosaique (bas gauche)',
            ],
            [
                'key' => 'field_about_image_4',
                'label' => 'Image 4 (bas droite, decalee)',
                'name' => 'image_4',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Quatrieme image de la mosaique (bas droite, decalee vers le bas)',
            ],

            // Section Statistiques
            [
                'key' => 'field_about_stats_title',
                'label' => 'Titre statistiques',
                'name' => 'stats_title',
                'type' => 'text',
                'instructions' => 'Titre au-dessus des statistiques',
                'placeholder' => 'Nos chiffres',
            ],
            [
                'key' => 'field_about_stats',
                'label' => 'Statistiques',
                'name' => 'stats',
                'type' => 'repeater',
                'min' => 3,
                'max' => 5,
                'layout' => 'table',
                'button_label' => 'Ajouter une statistique',
                'instructions' => 'Ajoutez 3-4 statistiques: Projets realises, Clients satisfaits, Employes, Annees d\'experience',
                'sub_fields' => [
                    [
                        'key' => 'field_stat_label',
                        'label' => 'Libelle',
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => 'Breve description de la statistique',
                        'placeholder' => 'Projets realises',
                    ],
                    [
                        'key' => 'field_stat_value',
                        'label' => 'Valeur',
                        'name' => 'value',
                        'type' => 'text',
                        'instructions' => 'La valeur a afficher (ex: "250+", "150+", "50+", "25")',
                        'placeholder' => '250+',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/about',
                ],
            ],
        ],
    ]);
});
