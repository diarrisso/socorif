<?php
/**
 * Configuration du bloc Equipe
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'team',
        'title' => __('Equipe', 'socorif'),
        'description' => __('Grille des membres de l\'equipe', 'socorif'),
        'render_template' => 'template-parts/blocks/equipe/equipe.php',
        'category' => 'socorif-blocks',
        'icon' => 'groups',
        'keywords' => ['team', 'members', 'staff', 'equipe'],
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
        'key' => 'group_team_block',
        'title' => 'Bloc Equipe',
        'fields' => [
            // En-tete
            [
                'key' => 'field_team_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
                'default_value' => 'Notre equipe',
                'wrapper' => ['width' => '100'],
            ],
            [
                'key' => 'field_team_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Nous sommes une equipe dynamique de professionnels passionnes par leur travail et dedies a offrir le meilleur service a nos clients.',
                'wrapper' => ['width' => '100'],
            ],

            // Membres
            [
                'key' => 'field_team_members',
                'label' => 'Membres',
                'name' => 'members',
                'type' => 'repeater',
                'min' => 1,
                'max' => 12,
                'layout' => 'block',
                'button_label' => 'Ajouter un membre',
                'sub_fields' => [
                    [
                        'key' => 'field_member_photo',
                        'label' => 'Photo',
                        'name' => 'photo',
                        'type' => 'image',
                        'required' => 0,
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'wrapper' => ['width' => '30'],
                    ],
                    [
                        'key' => 'field_member_name',
                        'label' => 'Nom',
                        'name' => 'name',
                        'type' => 'text',
                        'required' => 0,
                        'default_value' => 'Jean Dupont',
                        'wrapper' => ['width' => '35'],
                    ],
                    [
                        'key' => 'field_member_department',
                        'label' => 'Departement',
                        'name' => 'department',
                        'type' => 'select',
                        'required' => 1,
                        'choices' => [
                            'management' => 'Direction',
                            'administration' => 'Administration / Secretariat',
                            'training' => 'Formation',
                            'finance' => 'Finances',
                            'operations' => 'Operations',
                            'sales' => 'Commercial',
                            'technical' => 'Technique',
                        ],
                        'default_value' => 'management',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_member_role',
                        'label' => 'Poste',
                        'name' => 'role',
                        'type' => 'text',
                        'default_value' => 'Directeur General',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_member_location',
                        'label' => 'Localisation',
                        'name' => 'location',
                        'type' => 'text',
                        'default_value' => 'Dakar, Senegal',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_member_email',
                        'label' => 'E-mail (optionnel)',
                        'name' => 'email',
                        'type' => 'email',
                        'required' => 0,
                        'wrapper' => ['width' => '50'],
                    ],
                ],
            ],

            // Parametres de mise en page
            [
                'key' => 'field_team_columns',
                'label' => 'Colonnes (Desktop)',
                'name' => 'columns',
                'type' => 'select',
                'choices' => [
                    '2' => '2 colonnes',
                    '3' => '3 colonnes',
                    '4' => '4 colonnes',
                ],
                'default_value' => '4',
                'wrapper' => ['width' => '50'],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/team',
                ],
            ],
        ],
    ]);
});