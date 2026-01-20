<?php
/**
 * CTA Split Block Configuration
 *
 * Bloc CTA moderne avec mise en page divisee et plusieurs positions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enregistrer le bloc CTA Split
 */
function socorif_register_cta_split_block(): void {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type([
            'name'              => 'cta-split',
            'title'             => __('CTA Divise', 'socorif'),
            'description'       => __('Appel a l\'action moderne avec mise en page divisee et effets decoratifs', 'socorif'),
            'category'          => 'socorif-blocks',
            'icon'              => 'align-pull-left',
            'keywords'          => ['cta', 'call to action', 'split', 'image'],
            'mode'              => 'preview',
            'supports'          => [
                'align' => false,
                'mode'  => true,
                'jsx'   => true,
            ],
            'render_template'   => get_template_directory() . '/template-parts/blocks/cta-divise/cta-divise.php',
        ]);
    }
}
add_action('acf/init', 'socorif_register_cta_split_block');

/**
 * CTA Split Block Field Group
 */
function socorif_register_cta_split_fields(): void {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group([
            'key'       => 'group_cta_split_block',
            'title'     => 'Bloc CTA Divise',
            'fields'    => [

                // ============================================
                // TAB: Contenu
                // ============================================
                [
                    'key'   => 'field_cta_split_content_tab',
                    'label' => 'Contenu',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],

                // Image
                [
                    'key'   => 'field_cta_split_image',
                    'label' => 'Image',
                    'name'  => 'image',
                    'type'  => 'image',
                    'required' => 0,
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'instructions' => 'Requis uniquement pour les mises en page Split et Arriere-plan',
                ],

                // Subtitle
                [
                    'key'   => 'field_cta_split_subtitle',
                    'label' => 'Sous-titre',
                    'name'  => 'subtitle',
                    'type'  => 'text',
                    'default_value' => 'Support de qualite',
                    'wrapper' => ['width' => '50'],
                ],

                // Title
                [
                    'key'   => 'field_cta_split_title',
                    'label' => 'Titre',
                    'name'  => 'title',
                    'type'  => 'text',
                    'required' => 0,
                    'default_value' => 'Nous sommes a votre service',
                    'wrapper' => ['width' => '50'],
                ],

                // Description
                [
                    'key'   => 'field_cta_split_description',
                    'label' => 'Description',
                    'name'  => 'description',
                    'type'  => 'textarea',
                    'rows'  => 4,
                    'default_value' => 'Notre equipe est a votre disposition a tout moment. Contactez-nous pour des conseils professionnels et un service de premiere qualite.',
                ],

                // Primary Button
                [
                    'key'   => 'field_cta_split_button',
                    'label' => 'Bouton principal',
                    'name'  => 'button',
                    'type'  => 'link',
                    'required' => 0,
                    'return_format' => 'array',
                    'wrapper' => ['width' => '50'],
                ],

                // Secondary Button (optional)
                [
                    'key'   => 'field_cta_split_button_secondary',
                    'label' => 'Bouton secondaire (optionnel)',
                    'name'  => 'button_secondary',
                    'type'  => 'link',
                    'return_format' => 'array',
                    'wrapper' => ['width' => '50'],
                ],

                // ============================================
                // TAB: Mise en page
                // ============================================
                [
                    'key'   => 'field_cta_split_layout_tab',
                    'label' => 'Mise en page',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],

                // Layout Type
                [
                    'key'   => 'field_cta_split_layout_type',
                    'label' => 'Type de mise en page',
                    'name'  => 'layout_type',
                    'type'  => 'select',
                    'choices' => [
                        'split'      => 'Divise (Image + Texte)',
                        'centered'   => 'Centre (Texte uniquement)',
                        'background' => 'Arriere-plan (Image en fond)',
                    ],
                    'default_value' => 'split',
                    'ui' => 1,
                ],

                // Image Position (only for split layout)
                [
                    'key'   => 'field_cta_split_image_position',
                    'label' => 'Position de l\'image',
                    'name'  => 'image_position',
                    'type'  => 'select',
                    'choices' => [
                        'left'  => 'Gauche',
                        'right' => 'Droite',
                    ],
                    'default_value' => 'left',
                    'ui' => 1,
                    'conditional_logic' => [[
                        ['field' => 'field_cta_split_layout_type', 'operator' => '==', 'value' => 'split']
                    ]],
                    'wrapper' => ['width' => '50'],
                ],

                // Image Width (only for split layout)
                [
                    'key'   => 'field_cta_split_image_width',
                    'label' => 'Largeur de l\'image (Desktop)',
                    'name'  => 'image_width',
                    'type'  => 'select',
                    'choices' => [
                        '1/3' => '1/3 de la largeur',
                        '1/2' => '1/2 de la largeur',
                        '2/3' => '2/3 de la largeur',
                    ],
                    'default_value' => '1/3',
                    'conditional_logic' => [[
                        ['field' => 'field_cta_split_layout_type', 'operator' => '==', 'value' => 'split']
                    ]],
                    'wrapper' => ['width' => '50'],
                ],

                // Show SVG Decoration (for centered layout)
                [
                    'key'   => 'field_cta_split_show_svg_circle',
                    'label' => 'Decoration cercle SVG',
                    'name'  => 'show_svg_circle',
                    'type'  => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'instructions' => 'Cercle SVG decoratif en arriere-plan',
                    'conditional_logic' => [[
                        ['field' => 'field_cta_split_layout_type', 'operator' => '==', 'value' => 'centered']
                    ]],
                ],

                // Content Alignment
                [
                    'key'   => 'field_cta_split_content_alignment',
                    'label' => 'Alignement du texte',
                    'name'  => 'content_alignment',
                    'type'  => 'select',
                    'choices' => [
                        'left'   => 'Gauche',
                        'center' => 'Centre',
                        'right'  => 'Droite',
                    ],
                    'default_value' => 'left',
                    'wrapper' => ['width' => '50'],
                ],

                // Container Max Width
                [
                    'key'   => 'field_cta_split_container_width',
                    'label' => 'Largeur du conteneur',
                    'name'  => 'container_width',
                    'type'  => 'select',
                    'choices' => [
                        'default' => 'Standard (1280px)',
                        'wide'    => 'Large (1536px)',
                        'full'    => 'Pleine largeur',
                    ],
                    'default_value' => 'default',
                    'wrapper' => ['width' => '50'],
                ],

                // ============================================
                // TAB: Style
                // ============================================
                [
                    'key'   => 'field_cta_split_styling_tab',
                    'label' => 'Style',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],

                // Accent Color
                [
                    'key'   => 'field_cta_split_accent_color',
                    'label' => 'Couleur d\'accent',
                    'name'  => 'accent_color',
                    'type'  => 'select',
                    'choices' => [
                        'primary'   => 'Couleur primaire (Jaune)',
                        'secondary' => 'Couleur secondaire (Gris)',
                        'indigo'    => 'Indigo',
                        'blue'      => 'Bleu',
                        'purple'    => 'Violet',
                        'pink'      => 'Rose',
                        'red'       => 'Rouge',
                        'custom'    => 'Personnalise',
                    ],
                    'default_value' => 'primary',
                    'wrapper' => ['width' => '50'],
                ],

                // Custom Accent Color
                [
                    'key'   => 'field_cta_split_custom_accent',
                    'label' => 'Couleur personnalisee',
                    'name'  => 'custom_accent',
                    'type'  => 'color_picker',
                    'default_value' => '#6366f1',
                    'conditional_logic' => [[
                        ['field' => 'field_cta_split_accent_color', 'operator' => '==', 'value' => 'custom']
                    ]],
                    'wrapper' => ['width' => '50'],
                ],

                // Background Color
                [
                    'key'   => 'field_cta_split_bg_color',
                    'label' => 'Couleur de fond',
                    'name'  => 'bg_color',
                    'type'  => 'select',
                    'choices' => [
                        'white'     => 'Blanc',
                        'gray-50'   => 'Gris clair',
                        'gray-100'  => 'Gris',
                        'secondary' => 'Couleur secondaire (Fonce)',
                    ],
                    'default_value' => 'white',
                    'wrapper' => ['width' => '50'],
                ],

                // Image Overlay Opacity
                [
                    'key'   => 'field_cta_split_overlay_opacity',
                    'label' => 'Intensite du calque sur l\'image',
                    'name'  => 'overlay_opacity',
                    'type'  => 'range',
                    'default_value' => 60,
                    'min'   => 0,
                    'max'   => 100,
                    'step'  => 10,
                    'append' => '%',
                    'wrapper' => ['width' => '50'],
                ],

                // Show Blur Effect
                [
                    'key'   => 'field_cta_split_show_blur',
                    'label' => 'Afficher l\'effet de flou',
                    'name'  => 'show_blur',
                    'type'  => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'instructions' => 'Effet de flou SVG decoratif sur l\'image',
                ],

                // ============================================
                // TAB: Espacement & Arriere-plan
                // ============================================
                [
                    'key'   => 'field_cta_split_spacing_tab',
                    'label' => 'Espacement & Arriere-plan',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key'   => 'field_cta_split_spacing',
                    'label' => 'Espacement',
                    'name'  => 'spacing',
                    'type'  => 'group',
                    'layout' => 'block',
                    'sub_fields' => socorif_get_spacing_fields(),
                ],

                [
                    'key'   => 'field_cta_split_background',
                    'label' => 'Arriere-plan decoratif',
                    'name'  => 'background',
                    'type'  => 'group',
                    'layout' => 'block',
                    'sub_fields' => socorif_get_decorative_background_fields(),
                ],

                // ============================================
                // TAB: Animation
                // ============================================
                [
                    'key'   => 'field_cta_split_animation_tab',
                    'label' => 'Animation',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key'   => 'field_cta_split_animation',
                    'label' => 'Animation',
                    'name'  => 'animation',
                    'type'  => 'group',
                    'layout' => 'block',
                    'sub_fields' => socorif_get_animation_fields(),
                ],

            ],
            'location' => [
                [
                    [
                        'param'    => 'block',
                        'operator' => '==',
                        'value'    => 'acf/cta-split',
                    ],
                ],
            ],
        ]);
    }
}
add_action('acf/init', 'socorif_register_cta_split_fields');
