<?php
/**
 * ACF Options Pages
 */

if (!defined('ABSPATH')) exit;

/**
 * Register Options Pages
 */
add_action('acf/init', function() {
    if (!function_exists('acf_add_options_page')) return;

    // Main Options Page
    acf_add_options_page([
        'page_title' => 'Options du theme',
        'menu_title' => 'Options du theme',
        'menu_slug' => 'theme-options',
        'capability' => 'edit_posts',
        'redirect' => true,
        'icon_url' => 'dashicons-admin-generic',
        'position' => 2,
    ]);

    // Header Options
    acf_add_options_sub_page([
        'page_title' => 'Options Header',
        'menu_title' => 'Header',
        'parent_slug' => 'theme-options',
    ]);

    // Footer Options
    acf_add_options_sub_page([
        'page_title' => 'Options Footer',
        'menu_title' => 'Footer',
        'parent_slug' => 'theme-options',
    ]);

    // General Options
    acf_add_options_sub_page([
        'page_title' => 'Options generales',
        'menu_title' => 'General',
        'parent_slug' => 'theme-options',
    ]);

    // Archive Options
    acf_add_options_sub_page([
        'page_title' => 'Options des archives',
        'menu_title' => 'Archives',
        'parent_slug' => 'theme-options',
    ]);
});

/**
 * Header Fields
 */
add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    // Header Fields
    acf_add_local_field_group([
        'key' => 'group_header_options',
        'title' => 'Options Header',
        'fields' => [
            [
                'key' => 'field_header_logo',
                'label' => 'Logo',
                'name' => 'header_logo',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_header_logo_dark',
                'label' => 'Logo (version sombre)',
                'name' => 'header_logo_dark',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Pour les fonds clairs',
            ],
            [
                'key' => 'field_header_phone',
                'label' => 'Telephone',
                'name' => 'header_phone',
                'type' => 'text',
            ],
            [
                'key' => 'field_header_cta',
                'label' => 'Bouton CTA',
                'name' => 'header_cta',
                'type' => 'link',
                'return_format' => 'array',
            ],
            [
                'key' => 'field_header_logo_height',
                'label' => 'Hauteur du logo (px)',
                'name' => 'header_logo_height',
                'type' => 'number',
                'default_value' => 48,
                'min' => 24,
                'max' => 120,
                'step' => 4,
                'prepend' => '',
                'append' => 'px',
                'instructions' => 'Hauteur du logo en pixels (par defaut: 48px)',
            ],
            [
                'key' => 'field_header_sticky',
                'label' => 'Header fixe',
                'name' => 'header_sticky',
                'type' => 'select',
                'choices' => [
                    'none' => 'Desactive',
                    'mobile' => 'Mobile uniquement',
                    'desktop' => 'Desktop uniquement',
                    'all' => 'Tous les ecrans',
                ],
                'default_value' => 'mobile',
                'ui' => 1,
            ],
            [
                'key' => 'field_header_show_dark_mode_toggle',
                'label' => 'Afficher selecteur de mode',
                'name' => 'header_show_dark_mode_toggle',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'instructions' => 'Afficher le selecteur Light/Dark/Auto dans le header',
            ],
            // Banner settings
            [
                'key' => 'field_header_banner_tab',
                'label' => 'Bandeau',
                'type' => 'tab',
            ],
            [
                'key' => 'field_header_banner_enabled',
                'label' => 'Activer le bandeau',
                'name' => 'header_banner_enabled',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ],
            [
                'key' => 'field_header_banner_text',
                'label' => 'Texte du bandeau',
                'name' => 'header_banner_text',
                'type' => 'text',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_header_banner_enabled',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_header_banner_highlight',
                'label' => 'Texte en gras',
                'name' => 'header_banner_highlight',
                'type' => 'text',
                'instructions' => 'Texte affiche en gras avant le texte principal',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_header_banner_enabled',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_header_banner_link',
                'label' => 'Lien du bandeau',
                'name' => 'header_banner_link',
                'type' => 'link',
                'return_format' => 'array',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_header_banner_enabled',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_header_banner_dismissable',
                'label' => 'Peut etre ferme',
                'name' => 'header_banner_dismissable',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_header_banner_enabled',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-header',
                ],
            ],
        ],
    ]);

    // Footer Fields
    acf_add_local_field_group([
        'key' => 'group_footer_options',
        'title' => 'Options Footer',
        'fields' => [
            [
                'key' => 'field_footer_logo',
                'label' => 'Logo Footer',
                'name' => 'footer_logo',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_footer_description',
                'label' => 'Description',
                'name' => 'footer_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            // Contact Info
            [
                'key' => 'field_footer_contact_tab',
                'label' => 'Contact',
                'type' => 'tab',
            ],
            [
                'key' => 'field_footer_phone',
                'label' => 'Telephone',
                'name' => 'footer_phone',
                'type' => 'text',
            ],
            [
                'key' => 'field_footer_email',
                'label' => 'Email',
                'name' => 'footer_email',
                'type' => 'email',
            ],
            [
                'key' => 'field_footer_address',
                'label' => 'Adresse',
                'name' => 'footer_address',
                'type' => 'textarea',
                'rows' => 2,
            ],
            // Social Links
            [
                'key' => 'field_footer_social_tab',
                'label' => 'Reseaux sociaux',
                'type' => 'tab',
            ],
            [
                'key' => 'field_footer_facebook',
                'label' => 'Facebook',
                'name' => 'footer_facebook',
                'type' => 'url',
            ],
            [
                'key' => 'field_footer_instagram',
                'label' => 'Instagram',
                'name' => 'footer_instagram',
                'type' => 'url',
            ],
            [
                'key' => 'field_footer_linkedin',
                'label' => 'LinkedIn',
                'name' => 'footer_linkedin',
                'type' => 'url',
            ],
            [
                'key' => 'field_footer_twitter',
                'label' => 'Twitter/X',
                'name' => 'footer_twitter',
                'type' => 'url',
            ],
            [
                'key' => 'field_footer_youtube',
                'label' => 'YouTube',
                'name' => 'footer_youtube',
                'type' => 'url',
            ],
            [
                'key' => 'field_footer_xing',
                'label' => 'Xing',
                'name' => 'footer_xing',
                'type' => 'url',
            ],
            // Copyright
            [
                'key' => 'field_footer_legal_tab',
                'label' => 'Mentions legales',
                'type' => 'tab',
            ],
            [
                'key' => 'field_footer_copyright',
                'label' => 'Copyright',
                'name' => 'footer_copyright',
                'type' => 'text',
                'placeholder' => 'Socorif. Tous droits reserves.',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-footer',
                ],
            ],
        ],
    ]);

    // General Options
    acf_add_local_field_group([
        'key' => 'group_general_options',
        'title' => 'Options generales',
        'fields' => [
            // Light Mode Colors
            [
                'key' => 'field_colors_light_tab',
                'label' => 'Couleurs mode clair',
                'type' => 'tab',
            ],
            [
                'key' => 'field_general_primary_color',
                'label' => 'Couleur primaire',
                'name' => 'primary_color',
                'type' => 'color_picker',
                'default_value' => '#f97316',
                'instructions' => 'Orange - Energie, dynamisme (boutons, liens, accents)',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_general_primary_hover',
                'label' => 'Couleur primaire survol',
                'name' => 'primary_color_hover',
                'type' => 'color_picker',
                'default_value' => '#ea580c',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_general_secondary_color',
                'label' => 'Couleur secondaire',
                'name' => 'secondary_color',
                'type' => 'color_picker',
                'default_value' => '#1e3a5f',
                'instructions' => 'Bleu fonce - Confiance, professionnalisme (titres, elements)',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_general_secondary_hover',
                'label' => 'Couleur secondaire survol',
                'name' => 'secondary_color_hover',
                'type' => 'color_picker',
                'default_value' => '#152a47',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_general_accent_color',
                'label' => 'Couleur d\'accent',
                'name' => 'accent_color',
                'type' => 'color_picker',
                'default_value' => '#fbbf24',
                'instructions' => 'Jaune - Pour badges, alertes, elements speciaux',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_general_text_color',
                'label' => 'Couleur du texte',
                'name' => 'text_color',
                'type' => 'color_picker',
                'default_value' => '#1f2937',
                'wrapper' => ['width' => '50'],
            ],
            // Dark Mode Colors
            [
                'key' => 'field_colors_dark_tab',
                'label' => 'Couleurs mode sombre',
                'type' => 'tab',
            ],
            [
                'key' => 'field_dark_primary_color',
                'label' => 'Couleur primaire (sombre)',
                'name' => 'dark_primary_color',
                'type' => 'color_picker',
                'default_value' => '#fb923c',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_dark_primary_hover',
                'label' => 'Couleur primaire survol (sombre)',
                'name' => 'dark_primary_color_hover',
                'type' => 'color_picker',
                'default_value' => '#fdba74',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_dark_secondary_color',
                'label' => 'Couleur secondaire (sombre)',
                'name' => 'dark_secondary_color',
                'type' => 'color_picker',
                'default_value' => '#3b82f6',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_dark_secondary_hover',
                'label' => 'Couleur secondaire survol (sombre)',
                'name' => 'dark_secondary_color_hover',
                'type' => 'color_picker',
                'default_value' => '#60a5fa',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_dark_accent_color',
                'label' => 'Couleur d\'accent (sombre)',
                'name' => 'dark_accent_color',
                'type' => 'color_picker',
                'default_value' => '#fcd34d',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_dark_bg_color',
                'label' => 'Couleur de fond (sombre)',
                'name' => 'dark_bg_color',
                'type' => 'color_picker',
                'default_value' => '#111827',
                'wrapper' => ['width' => '50'],
            ],
            // 404 Page Settings
            [
                'key' => 'field_404_tab',
                'label' => 'Page 404',
                'type' => 'tab',
            ],
            [
                'key' => 'field_404_image_light',
                'label' => 'Image de fond (mode clair)',
                'name' => '404_image_light',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
                'instructions' => 'Image pour la page 404 en mode clair',
            ],
            [
                'key' => 'field_404_image_dark',
                'label' => 'Image de fond (mode sombre)',
                'name' => '404_image_dark',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
                'instructions' => 'Image pour la page 404 en mode sombre',
            ],
            [
                'key' => 'field_404_title',
                'label' => 'Titre',
                'name' => '404_title',
                'type' => 'text',
                'default_value' => 'Page non trouvee',
            ],
            [
                'key' => 'field_404_description',
                'label' => 'Description',
                'name' => '404_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Desole, nous n\'avons pas pu trouver la page que vous recherchez.',
            ],
            [
                'key' => 'field_404_button_text',
                'label' => 'Texte du bouton',
                'name' => '404_button_text',
                'type' => 'text',
                'default_value' => 'Retour a l\'accueil',
            ],
            // Other Settings
            [
                'key' => 'field_other_settings_tab',
                'label' => 'Autres parametres',
                'type' => 'tab',
            ],
            [
                'key' => 'field_general_gtm',
                'label' => 'Google Tag Manager ID',
                'name' => 'gtm_id',
                'type' => 'text',
                'placeholder' => 'GTM-XXXXXX',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-general',
                ],
            ],
        ],
    ]);

    // Archive Options
    acf_add_local_field_group([
        'key' => 'group_archive_options',
        'title' => 'Options des archives',
        'fields' => [
            // Leistungen Archive
            [
                'key' => 'field_archive_leistungen_tab',
                'label' => 'Services',
                'type' => 'tab',
            ],
            [
                'key' => 'field_archive_leistungen_subtitle',
                'label' => 'Sous-titre',
                'name' => 'archive_leistungen_subtitle',
                'type' => 'text',
                'default_value' => 'Nos services',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_archive_leistungen_title',
                'label' => 'Titre',
                'name' => 'archive_leistungen_title',
                'type' => 'text',
                'default_value' => 'Nos prestations',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_archive_leistungen_description',
                'label' => 'Description',
                'name' => 'archive_leistungen_description',
                'type' => 'textarea',
                'default_value' => 'Des prestations professionnelles pour votre projet - du conseil a la realisation.',
                'rows' => 3,
            ],
            [
                'key' => 'field_archive_leistungen_bg',
                'label' => 'Image de fond',
                'name' => 'archive_leistungen_bg',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
                'instructions' => 'Image de fond pour la page Services',
            ],
            [
                'key' => 'field_archive_leistungen_overlay',
                'label' => 'Opacite overlay',
                'name' => 'archive_leistungen_overlay',
                'type' => 'range',
                'default_value' => 60,
                'min' => 0,
                'max' => 100,
                'step' => 5,
                'append' => '%',
                'instructions' => 'Opacite du voile sombre (0% = transparent, 100% = completement sombre)',
            ],
            // Property Archive
            [
                'key' => 'field_archive_property_tab',
                'label' => 'Proprietes',
                'type' => 'tab',
            ],
            [
                'key' => 'field_archive_property_subtitle',
                'label' => 'Sous-titre',
                'name' => 'archive_property_subtitle',
                'type' => 'text',
                'default_value' => 'Nos biens',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_archive_property_title',
                'label' => 'Titre',
                'name' => 'archive_property_title',
                'type' => 'text',
                'default_value' => 'Proprietes disponibles',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_archive_property_description',
                'label' => 'Description',
                'name' => 'archive_property_description',
                'type' => 'textarea',
                'default_value' => 'Decouvrez notre selection de biens immobiliers - terrains, maisons et locaux commerciaux.',
                'rows' => 3,
            ],
            [
                'key' => 'field_archive_property_bg',
                'label' => 'Image de fond',
                'name' => 'archive_property_bg',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
                'instructions' => 'Image de fond pour la page Proprietes',
            ],
            [
                'key' => 'field_archive_property_overlay',
                'label' => 'Opacite overlay',
                'name' => 'archive_property_overlay',
                'type' => 'range',
                'default_value' => 60,
                'min' => 0,
                'max' => 100,
                'step' => 5,
                'append' => '%',
                'instructions' => 'Opacite du voile sombre',
            ],
            // Projekte Archive
            [
                'key' => 'field_archive_projekte_tab',
                'label' => 'Projets',
                'type' => 'tab',
            ],
            [
                'key' => 'field_archive_projekte_subtitle',
                'label' => 'Sous-titre',
                'name' => 'archive_projekte_subtitle',
                'type' => 'text',
                'default_value' => 'Nos realisations',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_archive_projekte_title',
                'label' => 'Titre',
                'name' => 'archive_projekte_title',
                'type' => 'text',
                'default_value' => 'Nos projets de reference',
                'wrapper' => ['width' => '50'],
            ],
            [
                'key' => 'field_archive_projekte_description',
                'label' => 'Description',
                'name' => 'archive_projekte_description',
                'type' => 'textarea',
                'default_value' => 'Decouvrez nos projets realises avec succes et constatez notre qualite et notre expertise.',
                'rows' => 3,
            ],
            [
                'key' => 'field_archive_projekte_bg',
                'label' => 'Image de fond',
                'name' => 'archive_projekte_bg',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
                'instructions' => 'Image de fond pour la page Projets',
            ],
            [
                'key' => 'field_archive_projekte_overlay',
                'label' => 'Opacite overlay',
                'name' => 'archive_projekte_overlay',
                'type' => 'range',
                'default_value' => 60,
                'min' => 0,
                'max' => 100,
                'step' => 5,
                'append' => '%',
                'instructions' => 'Opacite du voile sombre',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-archives',
                ],
            ],
        ],
    ]);
});
