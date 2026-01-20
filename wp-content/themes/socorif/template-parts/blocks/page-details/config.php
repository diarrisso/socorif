<?php
/**
 * Configuration du bloc Details Page
 */

if (!defined('ABSPATH')) exit;

acf_add_local_field_group([
    'key' => 'group_details_page_block',
    'title' => 'Bloc Details Page',
    'fields' => [
        [
            'key' => 'field_details_badge_text',
            'label' => 'Texte du badge',
            'name' => 'badge_text',
            'type' => 'text',
            'instructions' => 'Texte du badge en haut (optionnel)',
            'default_value' => '',
        ],
        [
            'key' => 'field_details_badge_link',
            'label' => 'Lien du badge',
            'name' => 'badge_link',
            'type' => 'link',
            'instructions' => 'Lien "En savoir plus" (optionnel)',
            'return_format' => 'array',
        ],
        [
            'key' => 'field_details_heading',
            'label' => 'Titre',
            'name' => 'heading',
            'type' => 'text',
            'required' => 0,
            'default_value' => 'Des donnees pour enrichir votre activite',
        ],
        [
            'key' => 'field_details_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'default_value' => '',
        ],
        [
            'key' => 'field_details_primary_button',
            'label' => 'Bouton principal',
            'name' => 'primary_button',
            'type' => 'link',
            'instructions' => 'Bouton d\'appel a l\'action principal',
            'return_format' => 'array',
        ],
        [
            'key' => 'field_details_secondary_button',
            'label' => 'Bouton secondaire',
            'name' => 'secondary_button',
            'type' => 'link',
            'instructions' => 'Deuxieme lien/bouton',
            'return_format' => 'array',
        ],
        [
            'key' => 'field_details_image',
            'label' => 'Image',
            'name' => 'image',
            'type' => 'image',
            'required' => 0,
            'return_format' => 'array',
            'preview_size' => 'large',
            'library' => 'all',
        ],
        [
            'key' => 'field_details_show_decorative_svg',
            'label' => 'Afficher le SVG decoratif',
            'name' => 'show_decorative_svg',
            'type' => 'true_false',
            'instructions' => 'Affiche l\'element SVG decoratif entre le texte et l\'image',
            'default_value' => 1,
            'ui' => 1,
        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/details-page',
            ],
        ],
    ],
]);
