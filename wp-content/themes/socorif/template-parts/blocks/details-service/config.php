<?php
/**
 * Service Details Block - Configuration ACF
 *
 * Bloc pour pages de detail avec Hero, avantages, elements de confiance et FAQ
 * Base sur la structure de page-angebot.php
 *
 * @package Beka
 */

if (!defined('ABSPATH')) {
    exit;
}

return [
    'name' => 'service-details',
    'title' => 'Details Service',
    'description' => 'Page de service detaillee avec Hero, avantages, elements de confiance et FAQ',
    'category' => 'beka-blocks',
    'icon' => 'format-aside',
    'keywords' => ['service', 'details', 'faq', 'avantages', 'hero'],
    'mode' => 'preview',
    'supports' => [
        'align' => false,
        'mode' => true,
        'jsx' => false,
    ],
    'fields' => [
        // Onglet Hero
        [
            'key' => 'field_sd_hero_tab',
            'label' => 'Section Hero',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_sd_hero_bg_color',
            'label' => 'Couleur de fond',
            'name' => 'hero_bg_color',
            'type' => 'select',
            'choices' => [
                'gradient-to-br from-secondary to-secondary-dark' => 'Degrade Bleu',
                'gradient-to-br from-primary to-orange-600' => 'Degrade Orange',
                'bg-secondary-dark' => 'Bleu fonce',
                'bg-gray-900' => 'Gris fonce',
            ],
            'default_value' => 'gradient-to-br from-secondary to-secondary-dark',
        ],
        [
            'key' => 'field_sd_hero_title',
            'label' => 'Titre',
            'name' => 'hero_title',
            'type' => 'text',
            'default_value' => 'Demander un devis',
        ],
        [
            'key' => 'field_sd_hero_content',
            'label' => 'Description',
            'name' => 'hero_content',
            'type' => 'textarea',
            'rows' => 3,
            'default_value' => 'Demandez maintenant un devis sans engagement. Nous vous conseillons volontiers et trouvons la meilleure solution pour votre projet.',
        ],
        [
            'key' => 'field_sd_hero_show_benefits',
            'label' => 'Afficher les avantages',
            'name' => 'hero_show_benefits',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
        ],

        // Avantages Hero (3 cartes comme dans page-angebot.php)
        [
            'key' => 'field_sd_hero_benefits',
            'label' => 'Avantages',
            'name' => 'hero_benefits',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Ajouter un avantage',
            'min' => 0,
            'max' => 4,
            'conditional_logic' => [
                [
                    ['field' => 'field_sd_hero_show_benefits', 'operator' => '==', 'value' => '1']
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_sd_hero_b_icon',
                    'label' => 'Icone SVG',
                    'name' => 'icon',
                    'type' => 'select',
                    'choices' => [
                        'lightning' => 'Eclair (Rapide)',
                        'check-circle' => 'Check Circle (Confirmation)',
                        'shield' => 'Bouclier (Securite)',
                        'clock' => 'Horloge (Temps)',
                    ],
                    'default_value' => 'lightning',
                ],
                [
                    'key' => 'field_sd_hero_b_title',
                    'label' => 'Titre',
                    'name' => 'title',
                    'type' => 'text',
                    'default_value' => 'Reponse rapide',
                ],
                [
                    'key' => 'field_sd_hero_b_desc',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'text',
                    'default_value' => 'Reponse sous 24 heures',
                ],
            ],
            'default_value' => [
                [
                    'icon' => 'lightning',
                    'title' => 'Reponse rapide',
                    'description' => 'Reponse sous 24 heures',
                ],
                [
                    'icon' => 'check-circle',
                    'title' => 'Sans engagement',
                    'description' => 'Consultation initiale gratuite',
                ],
                [
                    'icon' => 'shield',
                    'title' => 'Confidentiel',
                    'description' => 'Vos donnees sont en securite',
                ],
            ],
        ],

        // Onglet Formulaire
        [
            'key' => 'field_sd_form_tab',
            'label' => 'Formulaire',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_sd_form_show',
            'label' => 'Afficher le formulaire',
            'name' => 'form_show',
            'type' => 'true_false',
            'default_value' => 0,
            'ui' => 1,
            'instructions' => 'Afficher le formulaire de devis multi-etapes',
        ],
        [
            'key' => 'field_sd_form_cf7_id',
            'label' => 'ID Contact Form 7',
            'name' => 'form_cf7_id',
            'type' => 'text',
            'default_value' => '123',
            'instructions' => 'ID du formulaire Contact Form 7',
            'conditional_logic' => [
                [
                    ['field' => 'field_sd_form_show', 'operator' => '==', 'value' => '1']
                ]
            ],
        ],

        // Onglet Elements de confiance
        [
            'key' => 'field_sd_trust_tab',
            'label' => 'Elements de confiance',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_sd_trust_show',
            'label' => 'Afficher les elements de confiance',
            'name' => 'trust_show',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
        ],
        [
            'key' => 'field_sd_trust_title',
            'label' => 'Titre',
            'name' => 'trust_title',
            'type' => 'text',
            'default_value' => 'Pourquoi nous choisir?',
            'conditional_logic' => [
                [
                    ['field' => 'field_sd_trust_show', 'operator' => '==', 'value' => '1']
                ]
            ],
        ],
        [
            'key' => 'field_sd_trust_items',
            'label' => 'Elements',
            'name' => 'trust_items',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Ajouter un element',
            'min' => 0,
            'max' => 6,
            'conditional_logic' => [
                [
                    ['field' => 'field_sd_trust_show', 'operator' => '==', 'value' => '1']
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_sd_trust_i_icon',
                    'label' => 'Icone',
                    'name' => 'icon',
                    'type' => 'select',
                    'choices' => [
                        'check' => 'Check',
                        'users' => 'Utilisateurs',
                        'shield' => 'Bouclier',
                        'badge' => 'Badge',
                        'currency' => 'Devise',
                        'award' => 'Recompense',
                    ],
                    'default_value' => 'check',
                ],
                [
                    'key' => 'field_sd_trust_i_title',
                    'label' => 'Titre',
                    'name' => 'title',
                    'type' => 'text',
                    'default_value' => 'Plus de 25 ans d\'experience',
                ],
                [
                    'key' => 'field_sd_trust_i_desc',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'default_value' => 'Beneficiez de notre savoir-faire de longue date dans le batiment.',
                ],
            ],
            'default_value' => [
                [
                    'icon' => 'check',
                    'title' => 'Plus de 25 ans d\'experience',
                    'description' => 'Beneficiez de notre savoir-faire de longue date dans le batiment.',
                ],
                [
                    'icon' => 'users',
                    'title' => 'Personnel qualifie',
                    'description' => 'Notre equipe est composee de professionnels experimentes et certifies.',
                ],
                [
                    'icon' => 'badge',
                    'title' => 'Qualite garantie',
                    'description' => 'Nous garantissons les plus hauts standards de qualite pour tous les projets.',
                ],
                [
                    'icon' => 'currency',
                    'title' => 'Prix justes',
                    'description' => 'Calcul transparent et sans frais caches.',
                ],
            ],
        ],

        // Onglet FAQ
        [
            'key' => 'field_sd_faq_tab',
            'label' => 'FAQ',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_sd_faq_show',
            'label' => 'Afficher la FAQ',
            'name' => 'faq_show',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
        ],
        [
            'key' => 'field_sd_faq_title',
            'label' => 'Titre',
            'name' => 'faq_title',
            'type' => 'text',
            'default_value' => 'Questions frequentes',
            'conditional_logic' => [
                [
                    ['field' => 'field_sd_faq_show', 'operator' => '==', 'value' => '1']
                ]
            ],
        ],
        [
            'key' => 'field_sd_faq_items',
            'label' => 'Questions',
            'name' => 'faq_items',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Ajouter une question',
            'min' => 0,
            'conditional_logic' => [
                [
                    ['field' => 'field_sd_faq_show', 'operator' => '==', 'value' => '1']
                ]
            ],
            'sub_fields' => [
                [
                    'key' => 'field_sd_faq_i_question',
                    'label' => 'Question',
                    'name' => 'question',
                    'type' => 'text',
                    'default_value' => 'Combien de temps pour recevoir un devis?',
                ],
                [
                    'key' => 'field_sd_faq_i_answer',
                    'label' => 'Reponse',
                    'name' => 'answer',
                    'type' => 'textarea',
                    'rows' => 3,
                    'default_value' => 'En general, vous recevez une premiere reponse sous 24 heures. Un devis detaille suit apres une visite sur place sous 2-3 jours ouvrables.',
                ],
            ],
            'default_value' => [
                [
                    'question' => 'Combien de temps pour recevoir un devis?',
                    'answer' => 'En general, vous recevez une premiere reponse sous 24 heures. Un devis detaille suit apres une visite sur place sous 2-3 jours ouvrables.',
                ],
                [
                    'question' => 'La demande de devis est-elle payante?',
                    'answer' => 'Non, la demande de devis et la consultation initiale sont totalement gratuites et sans engagement.',
                ],
                [
                    'question' => 'Que deviennent mes donnees?',
                    'answer' => 'Vos donnees sont traitees de maniere confidentielle et utilisees uniquement pour le traitement de votre demande. Plus d\'informations dans notre politique de confidentialite.',
                ],
            ],
        ],

        // Onglet Style & Espacement
        [
            'key' => 'field_sd_style_tab',
            'label' => 'Style',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_sd_spacing_top',
            'label' => 'Espacement haut',
            'name' => 'spacing_top',
            'type' => 'select',
            'choices' => [
                'none' => 'Aucun',
                'small' => 'Petit',
                'medium' => 'Moyen',
                'large' => 'Grand',
            ],
            'default_value' => 'none',
        ],
        [
            'key' => 'field_sd_spacing_bottom',
            'label' => 'Espacement bas',
            'name' => 'spacing_bottom',
            'type' => 'select',
            'choices' => [
                'none' => 'Aucun',
                'small' => 'Petit',
                'medium' => 'Moyen',
                'large' => 'Grand',
            ],
            'default_value' => 'none',
        ],
    ],
];
