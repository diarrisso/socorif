<?php
/**
 * Champs ACF pour les Projets
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    // Groupe de champs Details du projet
    acf_add_local_field_group([
        'key' => 'group_projekt_details',
        'title' => 'Details du projet',
        'fields' => [
            // Message d'information sur les blocs par defaut
            [
                'key' => 'field_projekt_info_blocks',
                'label' => '',
                'name' => '',
                'type' => 'message',
                'message' => '<div style="background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%); color: white; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px;">
                    <strong style="font-size: 14px; display: block; margin-bottom: 8px;">Blocs flexibles par defaut pour ce projet :</strong>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; font-size: 13px;">
                        <span>1. Temoignages clients</span>
                        <span>2. CTA divise</span>
                    </div>
                    <p style="margin-top: 10px; font-size: 12px; opacity: 0.9;">Ces blocs apparaissent automatiquement dans "Contenu de la page" pour les nouveaux projets.</p>
                </div>',
                'new_lines' => '',
                'esc_html' => 0,
            ],
            // Onglet Informations du projet
            [
                'key' => 'field_projekt_tab_info',
                'label' => 'Informations du projet',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_projekt_kunde',
                'label' => 'Client / Maitre d\'ouvrage',
                'name' => 'projekt_kunde',
                'type' => 'text',
                'instructions' => 'Nom du client ou du maitre d\'ouvrage',
                'default_value' => '',
            ],
            [
                'key' => 'field_projekt_standort',
                'label' => 'Localisation',
                'name' => 'projekt_standort',
                'type' => 'text',
                'instructions' => 'Ville ou region du projet',
                'default_value' => '',
            ],
            [
                'key' => 'field_projekt_groesse',
                'label' => 'Taille du projet',
                'name' => 'projekt_groesse',
                'type' => 'text',
                'instructions' => 'Ex: "2 500 m2" ou "150 lots"',
                'default_value' => '',
            ],
            [
                'key' => 'field_projekt_dauer',
                'label' => 'Duree du projet',
                'name' => 'projekt_dauer',
                'type' => 'text',
                'instructions' => 'Ex: "12 mois" ou "6 semaines"',
                'default_value' => '',
            ],
            [
                'key' => 'field_projekt_fertigstellung',
                'label' => 'Date d\'achevement',
                'name' => 'projekt_fertigstellung',
                'type' => 'date_picker',
                'instructions' => 'Date de fin du projet',
                'display_format' => 'F Y',
                'return_format' => 'Y-m-d',
                'first_day' => 1,
            ],
            [
                'key' => 'field_projekt_status',
                'label' => 'Statut du projet',
                'name' => 'projekt_status',
                'type' => 'select',
                'choices' => [
                    'termine' => 'Termine',
                    'en_cours' => 'En cours',
                    'planifie' => 'Planifie',
                ],
                'default_value' => 'termine',
                'allow_null' => 0,
            ],
            [
                'key' => 'field_projekt_beschreibung_kurz',
                'label' => 'Description courte',
                'name' => 'projekt_beschreibung_kurz',
                'type' => 'textarea',
                'instructions' => 'Resume du projet (pour les aperçus)',
                'rows' => 3,
                'maxlength' => 250,
                'default_value' => '',
            ],

            // Onglet Medias
            [
                'key' => 'field_projekt_tab_medien',
                'label' => 'Medias',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_projekt_galerie',
                'label' => 'Galerie du projet',
                'name' => 'projekt_galerie',
                'type' => 'gallery',
                'instructions' => 'Images du projet termine',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'insert' => 'append',
                'library' => 'all',
                'min' => 0,
                'max' => 20,
            ],
            [
                'key' => 'field_projekt_vorher_bild',
                'label' => 'Image Avant',
                'name' => 'projekt_vorher_bild',
                'type' => 'image',
                'instructions' => 'Image avant les travaux (pour comparaison Avant/Apres)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_projekt_nachher_bild',
                'label' => 'Image Apres',
                'name' => 'projekt_nachher_bild',
                'type' => 'image',
                'instructions' => 'Image apres les travaux (pour comparaison Avant/Apres)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_projekt_video_id',
                'label' => 'Code Video',
                'name' => 'projekt_video_id',
                'type' => 'text',
                'instructions' => 'Entrez l\'ID YouTube (ex: "dQw4w9WgXcQ") ou l\'URL complete',
                'placeholder' => 'dQw4w9WgXcQ ou https://www.youtube.com/watch?v=...',
                'default_value' => '',
            ],

            // Onglet Prestations
            [
                'key' => 'field_projekt_tab_leistungen',
                'label' => 'Prestations',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_projekt_leistungen',
                'label' => 'Prestations realisees',
                'name' => 'projekt_leistungen',
                'type' => 'checkbox',
                'instructions' => 'Quelles prestations ont ete realisees dans ce projet ?',
                'choices' => [
                    'gestion' => 'Gestion immobiliere',
                    'promotion' => 'Promotion immobiliere',
                    'amenagement' => 'Amenagement de domaines',
                    'topographie' => 'Levee topographique',
                    'plans' => 'Dressage de plans',
                    'lotissement' => 'Lotissement',
                    'vente_terrain' => 'Vente de terrains',
                    'vente_maison' => 'Vente de maisons',
                    'construction' => 'Construction',
                    'renovation' => 'Renovation',
                ],
                'default_value' => [],
                'layout' => 'vertical',
            ],
            [
                'key' => 'field_projekt_herausforderungen',
                'label' => 'Defis particuliers',
                'name' => 'projekt_herausforderungen',
                'type' => 'textarea',
                'instructions' => 'Quels defis particuliers ont ete releves dans ce projet ?',
                'rows' => 4,
                'default_value' => '',
            ],

            // Onglet Temoignage client
            [
                'key' => 'field_projekt_tab_feedback',
                'label' => 'Temoignage client',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_projekt_testimonial',
                'label' => 'Temoignage',
                'name' => 'projekt_testimonial',
                'type' => 'textarea',
                'instructions' => 'Citation ou retour du client',
                'rows' => 5,
                'default_value' => '',
            ],
            [
                'key' => 'field_projekt_testimonial_autor',
                'label' => 'Nom du client',
                'name' => 'projekt_testimonial_autor',
                'type' => 'text',
                'instructions' => 'Nom de la personne qui a donne le temoignage',
                'default_value' => '',
            ],
            [
                'key' => 'field_projekt_testimonial_position',
                'label' => 'Position / Fonction',
                'name' => 'projekt_testimonial_position',
                'type' => 'text',
                'instructions' => 'Ex: "Directeur" ou "Proprietaire"',
                'default_value' => '',
            ],
            [
                'key' => 'field_projekt_testimonial_bild',
                'label' => 'Photo du client',
                'name' => 'projekt_testimonial_bild',
                'type' => 'image',
                'instructions' => 'Photo de profil du client (optionnel)',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ],

            // Onglet Phases du projet
            [
                'key' => 'field_projekt_tab_phasen',
                'label' => 'Phases du projet',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_projekt_phasen',
                'label' => 'Phases du projet',
                'name' => 'projekt_phasen',
                'type' => 'repeater',
                'instructions' => 'Definissez les differentes phases du projet',
                'layout' => 'block',
                'button_label' => 'Ajouter une phase',
                'min' => 0,
                'max' => 10,
                'sub_fields' => [
                    [
                        'key' => 'field_projekt_phase_titel',
                        'label' => 'Phase',
                        'name' => 'titel',
                        'type' => 'text',
                        'default_value' => '',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_projekt_phase_beschreibung',
                        'label' => 'Description',
                        'name' => 'beschreibung',
                        'type' => 'textarea',
                        'rows' => 3,
                        'default_value' => '',
                    ],
                    [
                        'key' => 'field_projekt_phase_datum',
                        'label' => 'Periode',
                        'name' => 'datum',
                        'type' => 'text',
                        'instructions' => 'Ex: "Janvier - Mars 2024"',
                        'default_value' => '',
                    ],
                ],
            ],

            // Onglet SEO
            [
                'key' => 'field_projekt_tab_seo',
                'label' => 'SEO',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_projekt_featured',
                'label' => 'Mettre en avant comme projet reference',
                'name' => 'projekt_featured',
                'type' => 'true_false',
                'instructions' => 'Mettre ce projet en avant sur la page d\'accueil ou dans les aperçus',
                'default_value' => 0,
                'ui' => 1,
            ],
            [
                'key' => 'field_projekt_reihenfolge',
                'label' => 'Ordre d\'affichage',
                'name' => 'projekt_reihenfolge',
                'type' => 'number',
                'instructions' => 'Determine l\'ordre dans les listes de projets (plus bas = plus haut)',
                'default_value' => 0,
                'min' => 0,
                'max' => 999,
            ],

            // Onglet Banniere Pub
            [
                'key' => 'field_projekt_tab_banniere',
                'label' => 'Banniere Pub',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_projekt_banniere_activer',
                'label' => 'Activer la banniere publicitaire',
                'name' => 'banniere_activer',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ],
            [
                'key' => 'field_projekt_banniere_subtitle',
                'label' => 'Sous-titre',
                'name' => 'banniere_subtitle',
                'type' => 'text',
                'default_value' => 'Expert en gestion de patrimoine internationale',
                'conditional_logic' => [[['field' => 'field_projekt_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_projekt_banniere_title',
                'label' => 'Titre',
                'name' => 'banniere_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'VOUS AVEZ UN PROJET IMMOBILIER A L\'ETRANGER ?',
                'conditional_logic' => [[['field' => 'field_projekt_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_projekt_banniere_image',
                'label' => 'Image',
                'name' => 'banniere_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'conditional_logic' => [[['field' => 'field_projekt_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_projekt_banniere_button',
                'label' => 'Bouton',
                'name' => 'banniere_button',
                'type' => 'link',
                'return_format' => 'array',
                'conditional_logic' => [[['field' => 'field_projekt_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_projekt_banniere_bg_color',
                'label' => 'Couleur de fond',
                'name' => 'banniere_bg_color',
                'type' => 'select',
                'choices' => ['primary' => 'Orange', 'secondary' => 'Bleu', 'dark' => 'Sombre'],
                'default_value' => 'secondary',
                'conditional_logic' => [[['field' => 'field_projekt_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'projekte',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    // Note: Le Flexible Content est charge automatiquement depuis inc/acf/flexible-content.php
    // et est active pour le post type 'projekte'
});
