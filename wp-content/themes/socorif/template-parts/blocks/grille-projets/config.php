<?php
/**
 * Configuration du bloc Grille de Projets
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'projects-grid',
        'title' => __('Grille de Projets', 'socorif'),
        'description' => __('Grille responsive de projets', 'socorif'),
        'render_template' => 'template-parts/blocks/grille-projets/grille-projets.php',
        'category' => 'socorif-blocks',
        'icon' => 'grid-view',
        'keywords' => ['projects', 'portfolio', 'grid', 'projets', 'grille'],
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
        'key' => 'group_projects_grid_block',
        'title' => 'Bloc Grille de Projets',
        'fields' => [
            // En-tete
            [
                'key' => 'field_projects_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_projects_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
            ],
            // Selection du mode
            [
                'key' => 'field_projects_mode',
                'label' => 'Mode',
                'name' => 'projects_mode',
                'type' => 'radio',
                'choices' => [
                    'auto' => 'Automatique (charger depuis le CPT)',
                    'manual' => 'Manuel (Repeteur)',
                ],
                'default_value' => 'auto',
                'layout' => 'horizontal',
                'instructions' => 'Choisissez si les projets doivent etre charges automatiquement depuis le Custom Post Type ou saisis manuellement.',
            ],
            // Parametres mode automatique
            [
                'key' => 'field_projects_count',
                'label' => 'Nombre de projets',
                'name' => 'projects_count',
                'type' => 'number',
                'default_value' => 6,
                'min' => 1,
                'max' => 12,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_projects_mode',
                            'operator' => '==',
                            'value' => 'auto',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_projects_category',
                'label' => 'Filtre par categorie',
                'name' => 'projects_category',
                'type' => 'taxonomy',
                'taxonomy' => 'projekt_kategorie',
                'field_type' => 'select',
                'allow_null' => 1,
                'return_format' => 'id',
                'instructions' => 'Laisser vide pour toutes les categories',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_projects_mode',
                            'operator' => '==',
                            'value' => 'auto',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_projects_type',
                'label' => 'Filtre par type',
                'name' => 'projects_type',
                'type' => 'taxonomy',
                'taxonomy' => 'projekt_typ',
                'field_type' => 'select',
                'allow_null' => 1,
                'return_format' => 'id',
                'instructions' => 'Laisser vide pour tous les types',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_projects_mode',
                            'operator' => '==',
                            'value' => 'auto',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_projects_featured_only',
                'label' => 'Projets mis en avant uniquement',
                'name' => 'projects_featured_only',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_projects_mode',
                            'operator' => '==',
                            'value' => 'auto',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_projects_orderby',
                'label' => 'Trier par',
                'name' => 'projects_orderby',
                'type' => 'select',
                'choices' => [
                    'date' => 'Date (plus recents en premier)',
                    'title' => 'Titre (A-Z)',
                    'menu_order' => 'Ordre manuel',
                    'rand' => 'Aleatoire',
                ],
                'default_value' => 'date',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_projects_mode',
                            'operator' => '==',
                            'value' => 'auto',
                        ],
                    ],
                ],
            ],
            // Mode manuel - Repeteur
            [
                'key' => 'field_projects_items',
                'label' => 'Projets',
                'name' => 'projects',
                'type' => 'repeater',
                'min' => 1,
                'max' => 12,
                'layout' => 'block',
                'button_label' => 'Ajouter un projet',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_projects_mode',
                            'operator' => '==',
                            'value' => 'manual',
                        ],
                    ],
                ],
                'sub_fields' => [
                    [
                        'key' => 'field_project_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'required' => 0,
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                    ],
                    [
                        'key' => 'field_project_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_project_category',
                        'label' => 'Categorie',
                        'name' => 'category',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_project_link',
                        'label' => 'Lien',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                    ],
                ],
            ],
            // Arriere-plan
            [
                'key' => 'field_projects_bg_color',
                'label' => 'Couleur de fond',
                'name' => 'bg_color',
                'type' => 'select',
                'choices' => [
                    'white' => 'Blanc',
                    'gray-50' => 'Gris clair',
                ],
                'default_value' => 'white',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/projects-grid',
                ],
            ],
        ],
    ]);
});
