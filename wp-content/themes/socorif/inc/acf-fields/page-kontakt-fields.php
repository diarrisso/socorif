<?php
/**
 * Champs ACF - Page Contact
 *
 * Champs pour la page de contact
 */

if (!defined('ABSPATH')) exit;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_page_kontakt',
    'title' => 'Parametres page Contact',
    'fields' => [
        // Titre
        [
            'key' => 'field_contact_heading',
            'label' => 'Titre',
            'name' => 'contact_heading',
            'type' => 'text',
            'default_value' => 'Contactez-nous',
            'wrapper' => ['width' => '50'],
        ],
        // Description
        [
            'key' => 'field_contact_description',
            'label' => 'Description',
            'name' => 'contact_description',
            'type' => 'textarea',
            'rows' => 3,
            'default_value' => 'Nous sommes a votre ecoute et vous repondrons dans les plus brefs delais.',
            'wrapper' => ['width' => '50'],
        ],
        // Texte du bouton
        [
            'key' => 'field_contact_button_text',
            'label' => 'Texte du bouton',
            'name' => 'contact_button_text',
            'type' => 'text',
            'default_value' => 'Envoyer le message',
            'wrapper' => ['width' => '50'],
        ],
        // Contact Form 7 Shortcode (optionnel)
        [
            'key' => 'field_contact_form_shortcode',
            'label' => 'Shortcode Contact Form 7',
            'name' => 'contact_form_shortcode',
            'type' => 'text',
            'instructions' => 'Optionnel: Inserez un shortcode Contact Form 7 (ex: [contact-form-7 id="123"]). Laisser vide pour le formulaire par defaut.',
            'wrapper' => ['width' => '50'],
        ],

        // Onglet: Informations de contact (si non defini dans Options)
        [
            'key' => 'field_contact_info_tab',
            'label' => 'Informations de contact',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_contact_use_footer_info',
            'label' => 'Utiliser les informations du footer',
            'name' => 'contact_use_footer_info',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
            'instructions' => 'Si active, les informations de contact du footer seront utilisees',
        ],
        // Adresse
        [
            'key' => 'field_contact_address',
            'label' => 'Adresse',
            'name' => 'contact_address',
            'type' => 'textarea',
            'rows' => 3,
            'instructions' => 'A remplir uniquement si "Utiliser les informations du footer" est desactive',
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_contact_use_footer_info',
                        'operator' => '!=',
                        'value' => '1',
                    ],
                ],
            ],
        ],
        // Telephone
        [
            'key' => 'field_contact_phone',
            'label' => 'Numero de telephone',
            'name' => 'contact_phone',
            'type' => 'text',
            'instructions' => 'A remplir uniquement si "Utiliser les informations du footer" est desactive',
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_contact_use_footer_info',
                        'operator' => '!=',
                        'value' => '1',
                    ],
                ],
            ],
        ],
        // E-Mail
        [
            'key' => 'field_contact_email',
            'label' => 'E-mail',
            'name' => 'contact_email',
            'type' => 'email',
            'instructions' => 'A remplir uniquement si "Utiliser les informations du footer" est desactive',
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_contact_use_footer_info',
                        'operator' => '!=',
                        'value' => '1',
                    ],
                ],
            ],
        ],
    ],
    'location' => [
        [
            [
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-contact.php',
            ],
        ],
    ],
    'menu_order' => 0,
    'position' => 'acf_after_title',
    'style' => 'default',
]);
