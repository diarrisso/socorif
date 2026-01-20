<?php
/**
 * Configuration du bloc Actualites
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'news',
        'title' => __('Actualites', 'socorif'),
        'description' => __('Grille d\'articles/actualites', 'socorif'),
        'render_template' => 'template-parts/blocks/actualites/actualites.php',
        'category' => 'socorif-blocks',
        'icon' => 'admin-post',
        'keywords' => ['news', 'blog', 'articles', 'actualites'],
        'supports' => [
            'align' => ['wide', 'full'],
            'anchor' => true,
        ],
        'mode' => 'preview',
    ]);
}

add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_news_block',
        'title' => 'Bloc Actualites',
        'fields' => [
            [
                'key' => 'field_news_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_news_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_news_articles',
                'label' => 'Articles',
                'name' => 'articles',
                'type' => 'repeater',
                'min' => 1,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Ajouter un article',
                'sub_fields' => [
                    [
                        'key' => 'field_article_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                    ],
                    [
                        'key' => 'field_article_category',
                        'label' => 'Categorie',
                        'name' => 'category',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_article_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_article_excerpt',
                        'label' => 'Extrait',
                        'name' => 'excerpt',
                        'type' => 'textarea',
                        'rows' => 2,
                    ],
                    [
                        'key' => 'field_article_link',
                        'label' => 'Lien',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/news',
                ],
            ],
        ],
    ]);
});
