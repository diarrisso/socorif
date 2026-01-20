<?php
/**
 * Configuration du bloc Temoignages
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'testimonials',
        'title' => __('Temoignages', 'socorif'),
        'description' => __('Avis clients', 'socorif'),
        'render_template' => 'template-parts/blocks/temoignages/temoignages.php',
        'category' => 'socorif-blocks',
        'icon' => 'format-quote',
        'keywords' => ['testimonials', 'reviews', 'quotes', 'temoignages', 'avis'],
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
        'key' => 'group_testimonials_block',
        'title' => 'Bloc Temoignages',
        'fields' => [
            // Titre de section
            [
                'key' => 'field_testimonials_section_title',
                'label' => 'Titre de la section',
                'name' => 'section_title',
                'type' => 'text',
                'required' => 0,
                'default_value' => 'AVIS CLIENTS',
                'instructions' => 'Titre principal de la section temoignages (optionnel)',
            ],

            // Repeteur Temoignages
            [
                'key' => 'field_testimonials_repeater',
                'label' => 'Temoignages',
                'name' => 'testimonials',
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'block',
                'button_label' => 'Ajouter un temoignage',
                'instructions' => 'Ajoutez plusieurs temoignages. Ils seront affiches dans un slider.',
                'sub_fields' => [
                    [
                        'key' => 'field_testimonials_sub_quote',
                        'label' => 'Citation',
                        'name' => 'quote',
                        'type' => 'textarea',
                        'rows' => 5,
                        'required' => 1,
                        'default_value' => 'SOCORIF a realise notre projet de maniere professionnelle et dans les delais. La qualite du travail et le service etaient excellents. Nous recommandons vivement cette equipe.',
                        'instructions' => 'La citation ou l\'avis du client',
                    ],
                    [
                        'key' => 'field_testimonials_sub_person_image',
                        'label' => 'Photo de la personne',
                        'name' => 'person_image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'required' => 0,
                        'instructions' => 'Photo de la personne qui a donne le temoignage',
                    ],
                    [
                        'key' => 'field_testimonials_sub_person_name',
                        'label' => 'Nom',
                        'name' => 'person_name',
                        'type' => 'text',
                        'required' => 0,
                        'default_value' => 'Marie Dupont',
                        'instructions' => 'Nom de la personne',
                    ],
                    [
                        'key' => 'field_testimonials_sub_person_title',
                        'label' => 'Poste/Titre',
                        'name' => 'person_title',
                        'type' => 'text',
                        'required' => 0,
                        'default_value' => 'Directrice, Entreprise Dupont',
                        'instructions' => 'Poste, role ou entreprise de la personne',
                    ],
                ],
            ],

            // Onglet Parametres Slider
            [
                'key' => 'field_testimonials_tab_slider',
                'label' => 'Parametres du slider',
                'name' => 'slider_settings',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_testimonials_autoplay',
                'label' => 'Lecture automatique',
                'name' => 'enable_autoplay',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'instructions' => 'Activer pour faire defiler le slider automatiquement',
            ],
            [
                'key' => 'field_testimonials_autoplay_delay',
                'label' => 'Delai autoplay (ms)',
                'name' => 'autoplay_delay',
                'type' => 'number',
                'default_value' => 6000,
                'min' => 2000,
                'max' => 15000,
                'step' => 1000,
                'instructions' => 'Temps entre les slides en millisecondes',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_testimonials_autoplay',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_testimonials_loop',
                'label' => 'Boucle infinie',
                'name' => 'enable_loop',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'instructions' => 'Revenir au premier slide apres le dernier',
            ],
            [
                'key' => 'field_testimonials_pagination',
                'label' => 'Afficher la pagination',
                'name' => 'show_pagination',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'instructions' => 'Afficher les points de navigation entre les slides',
            ],
            [
                'key' => 'field_testimonials_navigation',
                'label' => 'Afficher les fleches de navigation',
                'name' => 'show_navigation',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'instructions' => 'Afficher les fleches precedent/suivant',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/testimonials',
                ],
            ],
        ],
    ]);
});
