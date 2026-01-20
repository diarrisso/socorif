<?php
/**
 * Configuration du bloc Localisation
 */

if (!defined('ABSPATH')) exit;

acf_register_block_type([
    'name'              => 'location',
    'title'             => __('Localisation / Contact', 'socorif'),
    'description'       => __('Affiche les informations de contact et la localisation', 'socorif'),
    'render_template'   => 'template-parts/blocks/localisation/localisation.php',
    'category'          => 'socorif-blocks',
    'icon'              => 'location-alt',
    'keywords'          => ['location', 'localisation', 'contact', 'adresse', 'map', 'carte'],
    'supports'          => [
        'align'         => ['wide', 'full'],
        'anchor'        => true,
        'mode'          => true,
    ],
]);
