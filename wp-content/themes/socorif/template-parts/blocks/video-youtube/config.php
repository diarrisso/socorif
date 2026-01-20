<?php
/**
 * Configuration du bloc Video YouTube
 */

if (!defined('ABSPATH')) exit;

if (function_exists('acf_register_block_type')) {
    acf_register_block_type([
        'name' => 'socorif-youtube-video',
        'title' => __('Video YouTube', 'socorif'),
        'description' => __('Integration de video YouTube', 'socorif'),
        'render_template' => 'template-parts/blocks/video-youtube/video-youtube.php',
        'category' => 'socorif-blocks',
        'icon' => 'video-alt3',
        'keywords' => ['youtube', 'video', 'embed'],
        'supports' => [
            'align' => ['wide', 'full'],
            'mode' => true,
            'jsx' => true,
        ],
    ]);
}

add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_youtube_video_block',
        'title' => 'Video YouTube',
        'fields' => [
            [
                'key' => 'field_youtube_display_style',
                'label' => 'Style d\'affichage',
                'name' => 'display_style',
                'type' => 'select',
                'choices' => [
                    'custom' => 'Personnalise (avec vignette et bouton play)',
                    'native' => 'YouTube natif (integration directe)',
                ],
                'default_value' => 'custom',
                'ui' => 1,
                'instructions' => 'Choisissez comment la video doit etre affichee',
            ],
            [
                'key' => 'field_youtube_video_id',
                'label' => 'ID de la video YouTube',
                'name' => 'video_id',
                'type' => 'text',
                'required' => 0,
                'instructions' => 'Entrez l\'ID de la video YouTube (ex: "dQw4w9WgXcQ") - OU utilisez le champ URL ci-dessous',
                'placeholder' => 'dQw4w9WgXcQ',
            ],
            [
                'key' => 'field_youtube_url',
                'label' => 'URL YouTube (Alternative)',
                'name' => 'youtube_url',
                'type' => 'url',
                'required' => 0,
                'instructions' => 'OU: Collez l\'URL YouTube complete (ex: https://www.youtube.com/watch?v=...)',
                'placeholder' => 'https://www.youtube.com/watch?v=',
            ],
            [
                'key' => 'field_youtube_title',
                'label' => 'Titre',
                'name' => 'video_title',
                'type' => 'text',
            ],
            [
                'key' => 'field_youtube_description',
                'label' => 'Description',
                'name' => 'video_description',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_youtube_thumbnail',
                'label' => 'Vignette personnalisee',
                'name' => 'custom_thumbnail',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Optionnel - sinon la vignette YouTube sera utilisee',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_youtube_display_style',
                            'operator' => '==',
                            'value' => 'custom',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_youtube_aspect_ratio',
                'label' => 'Format',
                'name' => 'aspect_ratio',
                'type' => 'select',
                'choices' => [
                    '16/9' => '16:9 (Standard)',
                    '4/3' => '4:3',
                    '1/1' => '1:1 (Carre)',
                ],
                'default_value' => '16/9',
            ],
            [
                'key' => 'field_youtube_use_bg',
                'label' => 'Utiliser la vignette comme arriere-plan',
                'name' => 'use_thumbnail_background',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 0,
                'instructions' => 'Utiliser la vignette video comme image de fond de toute la section',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_youtube_display_style',
                            'operator' => '==',
                            'value' => 'custom',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_youtube_overlay_opacity',
                'label' => 'Opacite de l\'overlay',
                'name' => 'overlay_opacity',
                'type' => 'range',
                'min' => 0,
                'max' => 100,
                'step' => 5,
                'default_value' => 50,
                'append' => '%',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_youtube_use_bg',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/socorif-youtube-video',
                ],
            ],
        ],
    ]);
});
