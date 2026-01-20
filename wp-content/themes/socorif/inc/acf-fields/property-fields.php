<?php
/**
 * Champs ACF pour le Custom Post Type Property
 *
 * Definit les champs personnalises pour les biens immobiliers
 */

if (!defined('ABSPATH')) {
    exit;
}

if (function_exists('acf_add_local_field_group')):

    // Groupe de champs pour les details du bien
    acf_add_local_field_group([
        'key' => 'group_property_details',
        'title' => 'Details du Bien',
        'fields' => [
            // Message d'information sur les blocs par defaut
            [
                'key' => 'field_property_info_blocks',
                'label' => '',
                'name' => '',
                'type' => 'message',
                'message' => '<div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px;">
                    <strong style="font-size: 14px; display: block; margin-bottom: 8px;">Blocs flexibles par defaut pour ce bien :</strong>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; font-size: 13px;">
                        <span>1. Accordeon (Informations)</span>
                        <span>2. Galerie d\'unites</span>
                    </div>
                    <p style="margin-top: 10px; font-size: 12px; opacity: 0.9;">Ces blocs apparaissent automatiquement dans "Contenu de la page" pour les nouveaux biens.</p>
                </div>',
                'new_lines' => '',
                'esc_html' => 0,
            ],
            // Onglet Informations generales
            [
                'key' => 'field_property_info_tab',
                'label' => 'Informations Generales',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_reference',
                'label' => 'Reference',
                'name' => 'property_reference',
                'type' => 'text',
                'instructions' => 'Numero de reference unique du bien',
            ],
            [
                'key' => 'field_property_type',
                'label' => 'Type de Bien',
                'name' => 'property_type_field',
                'type' => 'select',
                'choices' => [
                    'terrain' => 'Terrain',
                    'maison' => 'Maison',
                    'villa' => 'Villa',
                    'appartement' => 'Appartement',
                    'immeuble' => 'Immeuble',
                    'local_commercial' => 'Local Commercial',
                    'bureau' => 'Bureau',
                    'entrepot' => 'Entrepot',
                ],
                'default_value' => 'terrain',
            ],
            [
                'key' => 'field_property_transaction',
                'label' => 'Type de Transaction',
                'name' => 'property_transaction',
                'type' => 'select',
                'choices' => [
                    'vente' => 'Vente',
                    'location' => 'Location',
                    'gestion' => 'Gestion',
                ],
                'default_value' => 'vente',
            ],
            [
                'key' => 'field_property_status',
                'label' => 'Statut',
                'name' => 'property_status',
                'type' => 'select',
                'choices' => [
                    'disponible' => 'Disponible',
                    'reserve' => 'Reserve',
                    'vendu' => 'Vendu',
                    'loue' => 'Loue',
                ],
                'default_value' => 'disponible',
            ],

            // Onglet Prix
            [
                'key' => 'field_property_price_tab',
                'label' => 'Prix',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_price',
                'label' => 'Prix',
                'name' => 'property_price',
                'type' => 'number',
                'instructions' => 'Prix de vente ou loyer mensuel',
                'append' => 'GNF',
            ],
            [
                'key' => 'field_property_price_per_sqm',
                'label' => 'Prix au m²',
                'name' => 'property_price_per_sqm',
                'type' => 'number',
                'instructions' => 'Prix par metre carre (optionnel)',
                'append' => 'FCFA/m²',
            ],
            [
                'key' => 'field_property_negotiable',
                'label' => 'Prix negociable',
                'name' => 'property_negotiable',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ],

            // Onglet Caracteristiques
            [
                'key' => 'field_property_specs_tab',
                'label' => 'Caracteristiques',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_surface',
                'label' => 'Surface Habitable',
                'name' => 'property_surface',
                'type' => 'number',
                'append' => 'm²',
            ],
            [
                'key' => 'field_property_land_surface',
                'label' => 'Surface du Terrain',
                'name' => 'property_land_surface',
                'type' => 'number',
                'append' => 'm²',
            ],
            [
                'key' => 'field_property_rooms',
                'label' => 'Nombre de Pieces',
                'name' => 'property_rooms',
                'type' => 'number',
            ],
            [
                'key' => 'field_property_bedrooms',
                'label' => 'Nombre de Chambres',
                'name' => 'property_bedrooms',
                'type' => 'number',
            ],
            [
                'key' => 'field_property_bathrooms',
                'label' => 'Nombre de Salles de Bain',
                'name' => 'property_bathrooms',
                'type' => 'number',
            ],
            [
                'key' => 'field_property_year_built',
                'label' => 'Annee de Construction',
                'name' => 'property_year_built',
                'type' => 'number',
                'min' => 1900,
                'max' => 2100,
            ],

            // Onglet Equipements
            [
                'key' => 'field_property_features_tab',
                'label' => 'Equipements',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_features',
                'label' => 'Equipements et Prestations',
                'name' => 'property_features',
                'type' => 'checkbox',
                'choices' => [
                    'eau' => 'Eau courante',
                    'electricite' => 'Electricite',
                    'cloture' => 'Cloture',
                    'titre_foncier' => 'Titre foncier',
                    'parking' => 'Parking',
                    'garage' => 'Garage',
                    'jardin' => 'Jardin',
                    'piscine' => 'Piscine',
                    'terrasse' => 'Terrasse',
                    'balcon' => 'Balcon',
                    'climatisation' => 'Climatisation',
                    'cuisine_equipee' => 'Cuisine Equipee',
                    'meuble' => 'Meuble',
                    'gardiennage' => 'Gardiennage',
                    'groupe_electrogene' => 'Groupe Electrogene',
                    'forage' => 'Forage',
                ],
                'layout' => 'vertical',
            ],

            // Onglet Localisation
            [
                'key' => 'field_property_location_tab',
                'label' => 'Localisation',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_commune',
                'label' => 'Commune',
                'name' => 'property_commune',
                'type' => 'select',
                'instructions' => 'Commune de Conakry',
                'choices' => [
                    'kaloum' => 'Kaloum',
                    'dixinn' => 'Dixinn',
                    'matam' => 'Matam',
                    'matoto' => 'Matoto',
                    'ratoma' => 'Ratoma',
                ],
                'default_value' => 'ratoma',
                'allow_null' => 0,
            ],
            [
                'key' => 'field_property_quarter',
                'label' => 'Quartier',
                'name' => 'property_quarter',
                'type' => 'text',
                'instructions' => 'Ex: Kipe, Cosa, Nongo, Hamdallaye, Taouyah...',
                'default_value' => '',
            ],
            [
                'key' => 'field_property_address',
                'label' => 'Adresse complete',
                'name' => 'property_address',
                'type' => 'textarea',
                'rows' => 2,
                'instructions' => 'Adresse detaillee (optionnel)',
            ],
            [
                'key' => 'field_property_city',
                'label' => 'Ville',
                'name' => 'property_city',
                'type' => 'text',
                'default_value' => 'Conakry',
            ],
            [
                'key' => 'field_property_coordinates',
                'label' => 'Coordonnees GPS',
                'name' => 'property_coordinates',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'key' => 'field_property_lat',
                        'label' => 'Latitude',
                        'name' => 'lat',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_property_lng',
                        'label' => 'Longitude',
                        'name' => 'lng',
                        'type' => 'text',
                    ],
                ],
            ],

            // Onglet Galerie
            [
                'key' => 'field_property_gallery_tab',
                'label' => 'Galerie',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_gallery',
                'label' => 'Photos du Bien',
                'name' => 'property_gallery',
                'type' => 'gallery',
                'instructions' => 'Ajoutez des photos du bien',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_property_video',
                'label' => 'Video',
                'name' => 'property_video',
                'type' => 'url',
                'instructions' => 'Lien vers une video YouTube ou Vimeo',
            ],

            // Onglet Documents
            [
                'key' => 'field_property_documents_tab',
                'label' => 'Documents',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_documents',
                'label' => 'Documents',
                'name' => 'property_documents',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Ajouter un document',
                'sub_fields' => [
                    [
                        'key' => 'field_property_doc_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_property_doc_file',
                        'label' => 'Fichier',
                        'name' => 'file',
                        'type' => 'file',
                        'return_format' => 'array',
                    ],
                ],
            ],

            // Onglet Unites (pour immeubles, residences)
            [
                'key' => 'field_property_units_tab',
                'label' => 'Unites / Lots',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_has_units',
                'label' => 'Ce bien contient plusieurs unites',
                'name' => 'property_has_units',
                'type' => 'true_false',
                'instructions' => 'Activer pour les immeubles, residences ou biens avec plusieurs lots',
                'default_value' => 0,
                'ui' => 1,
            ],
            [
                'key' => 'field_property_units',
                'label' => 'Unites',
                'name' => 'property_units',
                'type' => 'repeater',
                'instructions' => 'Ajoutez les differentes unites/lots du bien',
                'layout' => 'block',
                'button_label' => 'Ajouter une unite',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_property_has_units',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
                'sub_fields' => [
                    [
                        'key' => 'field_property_unit_name',
                        'label' => 'Nom de l\'unite',
                        'name' => 'unit_name',
                        'type' => 'text',
                        'instructions' => 'Ex: Appartement A1, Unite 2, Lot 3...',
                        'required' => 1,
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_property_unit_status',
                        'label' => 'Statut',
                        'name' => 'unit_status',
                        'type' => 'select',
                        'choices' => [
                            'disponible' => 'Disponible',
                            'reserve' => 'Reserve',
                            'vendu' => 'Vendu',
                            'loue' => 'Loue',
                        ],
                        'default_value' => 'disponible',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_property_unit_price',
                        'label' => 'Prix',
                        'name' => 'unit_price',
                        'type' => 'number',
                        'append' => 'GNF',
                        'wrapper' => ['width' => '25'],
                    ],
                    [
                        'key' => 'field_property_unit_surface',
                        'label' => 'Surface',
                        'name' => 'unit_surface',
                        'type' => 'number',
                        'append' => 'm²',
                        'wrapper' => ['width' => '33'],
                    ],
                    [
                        'key' => 'field_property_unit_bedrooms',
                        'label' => 'Chambres',
                        'name' => 'unit_bedrooms',
                        'type' => 'number',
                        'wrapper' => ['width' => '33'],
                    ],
                    [
                        'key' => 'field_property_unit_bathrooms',
                        'label' => 'Salles de bain',
                        'name' => 'unit_bathrooms',
                        'type' => 'number',
                        'wrapper' => ['width' => '34'],
                    ],
                    [
                        'key' => 'field_property_unit_features',
                        'label' => 'Caracteristiques',
                        'name' => 'unit_features',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'button_label' => 'Ajouter une caracteristique',
                        'sub_fields' => [
                            [
                                'key' => 'field_property_unit_feature_icon',
                                'label' => 'Icone',
                                'name' => 'icon',
                                'type' => 'select',
                                'choices' => [
                                    'check' => 'Check',
                                    'bed' => 'Chambre',
                                    'bath' => 'Salle de bain',
                                    'kitchen' => 'Cuisine',
                                    'living' => 'Salon',
                                    'balcony' => 'Balcon',
                                    'parking' => 'Parking',
                                    'garden' => 'Jardin',
                                ],
                                'default_value' => 'check',
                                'wrapper' => ['width' => '30'],
                            ],
                            [
                                'key' => 'field_property_unit_feature_text',
                                'label' => 'Description',
                                'name' => 'text',
                                'type' => 'text',
                                'wrapper' => ['width' => '70'],
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_property_unit_gallery',
                        'label' => 'Photos de l\'unite',
                        'name' => 'unit_gallery',
                        'type' => 'gallery',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'instructions' => 'Photos specifiques a cette unite (optionnel)',
                    ],
                ],
            ],

            // Onglet: Banniere Pub
            [
                'key' => 'field_property_tab_banniere',
                'label' => 'Banniere Pub',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_property_banniere_activer',
                'label' => 'Activer la banniere publicitaire',
                'name' => 'banniere_activer',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ],
            [
                'key' => 'field_property_banniere_subtitle',
                'label' => 'Sous-titre',
                'name' => 'banniere_subtitle',
                'type' => 'text',
                'default_value' => 'Expert en gestion de patrimoine internationale',
                'conditional_logic' => [[['field' => 'field_property_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_property_banniere_title',
                'label' => 'Titre',
                'name' => 'banniere_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'VOUS AVEZ UN PROJET IMMOBILIER A L\'ETRANGER ?',
                'conditional_logic' => [[['field' => 'field_property_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_property_banniere_image',
                'label' => 'Image',
                'name' => 'banniere_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'conditional_logic' => [[['field' => 'field_property_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_property_banniere_button',
                'label' => 'Bouton',
                'name' => 'banniere_button',
                'type' => 'link',
                'return_format' => 'array',
                'conditional_logic' => [[['field' => 'field_property_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_property_banniere_bg_color',
                'label' => 'Couleur de fond',
                'name' => 'banniere_bg_color',
                'type' => 'select',
                'choices' => ['primary' => 'Orange', 'secondary' => 'Bleu', 'dark' => 'Sombre'],
                'default_value' => 'secondary',
                'conditional_logic' => [[['field' => 'field_property_banniere_activer', 'operator' => '==', 'value' => '1']]],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'property',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ]);

endif;
