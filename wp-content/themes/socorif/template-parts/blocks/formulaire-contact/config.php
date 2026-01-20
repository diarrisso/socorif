<?php
/**
 * Formulaire de Contact Block - Configuration ACF
 */

if (!defined('ABSPATH')) exit;

acf_add_local_field_group([
    'key' => 'group_contact_form_block',
    'title' => 'Bloc Formulaire de Contact',
    'fields' => [
        // Titre principal
        [
            'key' => 'field_contact_form_heading',
            'label' => 'Titre',
            'name' => 'heading',
            'type' => 'text',
            'default_value' => 'Contactez-nous',
            'wrapper' => ['width' => '100'],
        ],
        // Description
        [
            'key' => 'field_contact_form_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 3,
            'default_value' => 'Nous nous rejouissons de recevoir votre message et vous repondrons dans les plus brefs delais.',
            'wrapper' => ['width' => '100'],
        ],

        // Tab: Parametres du formulaire
        [
            'key' => 'field_contact_form_tab_form',
            'label' => 'Parametres du formulaire',
            'type' => 'tab',
            'placement' => 'top',
        ],
        // Selection Contact Form 7
        [
            'key' => 'field_contact_form_cf7',
            'label' => 'Formulaire Contact Form 7',
            'name' => 'cf7_form',
            'type' => 'post_object',
            'instructions' => 'Selectionnez un formulaire Contact Form 7',
            'post_type' => ['wpcf7_contact_form'],
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'id',
            'ui' => 1,
            'wrapper' => ['width' => '100'],
        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/contact-form',
            ],
        ],
    ],
    'style' => 'seamless',
]);