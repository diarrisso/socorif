<?php
/**
 * Configuration du bloc Certifications
 */

if (!defined('ABSPATH')) exit;

acf_register_block_type([
    'name'              => 'certifications',
    'title'             => __('Certifications', 'socorif'),
    'description'       => __('Affiche les certifications et distinctions avec images', 'socorif'),
    'render_template'   => 'template-parts/blocks/certifications/certifications.php',
    'category'          => 'socorif-blocks',
    'icon'              => 'awards',
    'keywords'          => ['certification', 'award', 'iso', 'distinction'],
    'supports'          => [
        'align'         => ['wide', 'full'],
        'anchor'        => true,
        'mode'          => true,
    ],
]);
