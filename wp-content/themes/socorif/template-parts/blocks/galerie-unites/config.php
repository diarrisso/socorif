<?php
/**
 * Configuration du bloc Galerie avec Unites
 *
 * Ce bloc est principalement utilise via le flexible content
 * mais peut aussi etre enregistre comme bloc ACF independant
 */

if (!defined('ABSPATH')) exit;

// Configuration du bloc (utilise par le blocks-loader si necessaire)
return [
    'name' => 'galerie-unites',
    'title' => 'Galerie avec Unites',
    'description' => 'Galerie d\'images avec accordeon d\'unites/lots',
    'category' => 'socorif-blocks',
    'icon' => 'images-alt2',
    'keywords' => ['galerie', 'unites', 'lots', 'immeuble', 'residence', 'accordeon'],
    'mode' => 'preview',
    'supports' => [
        'align' => false,
        'mode' => true,
    ],
];
