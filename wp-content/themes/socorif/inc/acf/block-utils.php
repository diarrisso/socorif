<?php
/**
 * Utilitaires pour les blocs ACF
 *
 * Fonctions centralisees pour les blocs ACF
 */

if (!defined('ABSPATH')) exit;

/**
 * Note: socorif_get_field() est defini dans inc/helpers/data-helpers.php
 */

/**
 * Recuperer les attributs du wrapper de bloc
 */
function socorif_get_block_wrapper_attributes($block, $extra_classes = '') {
    $classes = ['acf-block'];

    // Ajouter le nom du bloc comme classe
    if (!empty($block['name'])) {
        $classes[] = 'block-' . str_replace('acf/', '', $block['name']);
    }

    // Ajouter la classe d'alignement
    if (!empty($block['align'])) {
        $classes[] = 'align' . $block['align'];
    }

    // Ajouter les classes personnalisees
    if (!empty($block['className'])) {
        $classes[] = $block['className'];
    }

    // Ajouter les classes supplementaires
    if (!empty($extra_classes)) {
        $classes[] = $extra_classes;
    }

    // Recuperer l'ID du bloc
    $id = !empty($block['anchor']) ? $block['anchor'] : 'block-' . $block['id'];

    return sprintf(
        'id="%s" class="%s"',
        esc_attr($id),
        esc_attr(implode(' ', $classes))
    );
}

/**
 * Recuperer les classes d'espacement depuis les champs ACF
 */
function socorif_get_acf_spacing_classes($prefix = '') {
    $classes = [];

    // Marge interieure
    $padding_top = get_field($prefix . 'padding_top');
    $padding_bottom = get_field($prefix . 'padding_bottom');

    if ($padding_top) {
        $classes[] = 'pt-' . $padding_top;
    }

    if ($padding_bottom) {
        $classes[] = 'pb-' . $padding_bottom;
    }

    // Marge exterieure
    $margin_top = get_field($prefix . 'margin_top');
    $margin_bottom = get_field($prefix . 'margin_bottom');

    if ($margin_top) {
        $classes[] = 'mt-' . $margin_top;
    }

    if ($margin_bottom) {
        $classes[] = 'mb-' . $margin_bottom;
    }

    return implode(' ', $classes);
}

/**
 * Recuperer les classes et styles d'arriere-plan
 */
function socorif_get_background_attrs($field_prefix = '') {
    $bg_type = get_field($field_prefix . 'background_type');
    $classes = [];
    $styles = [];

    switch ($bg_type) {
        case 'color':
            $color = get_field($field_prefix . 'background_color');
            if ($color) {
                $classes[] = 'bg-' . $color;
            }
            break;

        case 'image':
            $image = get_field($field_prefix . 'background_image');
            if ($image) {
                $styles[] = "background-image: url('" . esc_url($image['url']) . "')";
                $classes[] = 'bg-cover bg-center bg-no-repeat';
            }
            break;

        case 'gradient':
            $gradient = get_field($field_prefix . 'background_gradient');
            if ($gradient) {
                $styles[] = "background: " . $gradient;
            }
            break;
    }

    return [
        'classes' => implode(' ', $classes),
        'styles' => implode('; ', $styles)
    ];
}

/**
 * Enregistrer un bloc ACF
 */
function socorif_register_block($name, $args = []) {
    $defaults = [
        'name' => $name,
        'title' => ucwords(str_replace('-', ' ', $name)),
        'description' => '',
        'render_template' => 'template-parts/blocks/' . $name . '/' . $name . '.php',
        'category' => 'socorif-blocks',
        'icon' => 'layout',
        'keywords' => [],
        'supports' => [
            'align' => ['wide', 'full'],
            'anchor' => true,
            'customClassName' => true,
            'jsx' => true,
        ],
        'mode' => 'preview',
    ];

    $block_args = wp_parse_args($args, $defaults);

    acf_register_block_type($block_args);
}

/**
 * Definition des champs d'espacement
 *
 * Retourne les champs d'espacement standard pour les blocs
 */
function socorif_get_spacing_fields() {
    return [
        [
            'key' => 'spacing_padding_top',
            'label' => 'Marge interieure haute',
            'name' => 'padding_top',
            'type' => 'select',
            'choices' => [
                '0' => 'Aucune',
                '4' => 'Petite (1rem)',
                '8' => 'Moyenne (2rem)',
                '12' => 'Grande (3rem)',
                '16' => 'Tres grande (4rem)',
                '24' => 'Extra grande (6rem)',
            ],
            'default_value' => '16',
            'wrapper' => ['width' => '50'],
        ],
        [
            'key' => 'spacing_padding_bottom',
            'label' => 'Marge interieure basse',
            'name' => 'padding_bottom',
            'type' => 'select',
            'choices' => [
                '0' => 'Aucune',
                '4' => 'Petite (1rem)',
                '8' => 'Moyenne (2rem)',
                '12' => 'Grande (3rem)',
                '16' => 'Tres grande (4rem)',
                '24' => 'Extra grande (6rem)',
            ],
            'default_value' => '16',
            'wrapper' => ['width' => '50'],
        ],
    ];
}

/**
 * Definition des champs d'arriere-plan decoratif
 *
 * Retourne les champs pour les arriere-plans decoratifs
 */
function socorif_get_decorative_background_fields() {
    return [
        [
            'key' => 'bg_enabled',
            'label' => 'Activer l\'arriere-plan',
            'name' => 'enabled',
            'type' => 'true_false',
            'default_value' => 0,
            'ui' => 1,
        ],
        [
            'key' => 'bg_type',
            'label' => 'Type d\'arriere-plan',
            'name' => 'type',
            'type' => 'select',
            'choices' => [
                'pattern' => 'Motif',
                'shape' => 'Forme',
                'gradient' => 'Degrade',
            ],
            'default_value' => 'pattern',
            'conditional_logic' => [[
                ['field' => 'bg_enabled', 'operator' => '==', 'value' => '1']
            ]],
        ],
        [
            'key' => 'bg_color',
            'label' => 'Couleur de fond',
            'name' => 'color',
            'type' => 'color_picker',
            'default_value' => '#f3f4f6',
            'conditional_logic' => [[
                ['field' => 'bg_enabled', 'operator' => '==', 'value' => '1']
            ]],
        ],
    ];
}

/**
 * Definition des champs d'animation
 *
 * Retourne les champs pour les animations
 */
function socorif_get_animation_fields() {
    return [
        [
            'key' => 'animation_enabled',
            'label' => 'Activer l\'animation',
            'name' => 'enabled',
            'type' => 'true_false',
            'default_value' => 0,
            'ui' => 1,
        ],
        [
            'key' => 'animation_type',
            'label' => 'Type d\'animation',
            'name' => 'type',
            'type' => 'select',
            'choices' => [
                'fade-up' => 'Fondu vers le haut',
                'fade-in' => 'Fondu',
                'slide-up' => 'Glissement vers le haut',
                'slide-left' => 'Glissement depuis la gauche',
                'slide-right' => 'Glissement depuis la droite',
                'zoom-in' => 'Zoom avant',
            ],
            'default_value' => 'fade-up',
            'conditional_logic' => [[
                ['field' => 'animation_enabled', 'operator' => '==', 'value' => '1']
            ]],
        ],
        [
            'key' => 'animation_duration',
            'label' => 'Duree de l\'animation',
            'name' => 'duration',
            'type' => 'select',
            'choices' => [
                '300' => 'Rapide (0.3s)',
                '500' => 'Moyenne (0.5s)',
                '700' => 'Lente (0.7s)',
                '1000' => 'Tres lente (1s)',
            ],
            'default_value' => '500',
            'conditional_logic' => [[
                ['field' => 'animation_enabled', 'operator' => '==', 'value' => '1']
            ]],
        ],
    ];
}

/**
 * Construire les classes d'espacement depuis les donnees
 */
function socorif_build_spacing_classes($spacing) {
    $classes = [];

    if (!empty($spacing['padding_top'])) {
        $classes[] = 'pt-' . $spacing['padding_top'];
    }

    if (!empty($spacing['padding_bottom'])) {
        $classes[] = 'pb-' . $spacing['padding_bottom'];
    }

    return implode(' ', $classes);
}

/**
 * Afficher le commentaire HTML de debut de bloc
 *
 * Affiche un commentaire HTML identifiant le nom du bloc dans le code source
 *
 * @param string $block_name Le nom du bloc (ex: 'hero', 'services-cards')
 * @return void
 */
function socorif_block_comment_start($block_name) {
    echo sprintf("\n<!-- START: %s Block -->\n", esc_html(ucfirst(str_replace('-', ' ', $block_name))));
}

/**
 * Afficher le commentaire HTML de fin de bloc
 *
 * Affiche un commentaire HTML marquant la fin du bloc
 *
 * @param string $block_name Le nom du bloc (ex: 'hero', 'services-cards')
 * @return void
 */
function socorif_block_comment_end($block_name) {
    echo sprintf("\n<!-- END: %s Block -->\n", esc_html(ucfirst(str_replace('-', ' ', $block_name))));
}
/**
 * Definition des champs de couleur d'arriere-plan
 *
 * Champs standardises pour les couleurs d'arriere-plan des blocs
 * Supporte les modes clair et sombre avec valeurs par defaut
 *
 * @return array Champs ACF pour les couleurs d'arriere-plan
 */
function socorif_get_background_color_fields() {
    return [
        [
            'key' => 'field_bg_color_tab',
            'label' => 'Arriere-plan',
            'type' => 'tab',
            'placement' => 'top',
        ],
        [
            'key' => 'field_bg_color_light',
            'label' => 'Couleur d\'arriere-plan (Mode clair)',
            'name' => 'bg_color_light',
            'type' => 'select',
            'instructions' => 'Selectionnez la couleur d\'arriere-plan pour le mode clair',
            'choices' => [
                'white' => 'Blanc (Par defaut)',
                'gray-50' => 'Gris tres clair',
                'gray-100' => 'Gris clair',
                'gray-200' => 'Gris',
                'primary' => 'Couleur primaire',
                'secondary' => 'Couleur secondaire',
                'secondary-dark' => 'Couleur secondaire foncee',
                'transparent' => 'Transparent',
            ],
            'default_value' => 'white',
            'ui' => 1,
            'wrapper' => ['width' => '50'],
        ],
        [
            'key' => 'field_bg_color_dark',
            'label' => 'Couleur d\'arriere-plan (Mode sombre)',
            'name' => 'bg_color_dark',
            'type' => 'select',
            'instructions' => 'Selectionnez la couleur d\'arriere-plan pour le mode sombre',
            'choices' => [
                'gray-900' => 'Gris fonce (Par defaut)',
                'gray-800' => 'Gris moyen fonce',
                'gray-700' => 'Gris moins fonce',
                'black' => 'Noir',
                'primary' => 'Couleur primaire',
                'secondary' => 'Couleur secondaire',
                'secondary-dark' => 'Couleur secondaire foncee',
                'transparent' => 'Transparent',
            ],
            'default_value' => 'gray-900',
            'ui' => 1,
            'wrapper' => ['width' => '50'],
        ],
    ];
}

/**
 * Recuperer les classes de couleur d'arriere-plan
 *
 * Recupere les classes de couleur d'arriere-plan depuis les champs ACF
 * Utilise les valeurs par defaut si aucune valeur n'est definie
 *
 * @param string $field_prefix Prefixe optionnel pour les noms de champs
 * @return string Classes CSS pour les couleurs d'arriere-plan
 */
function socorif_get_background_color_classes($field_prefix = '') {
    // Valeurs par defaut
    $default_light = 'white';
    $default_dark = 'gray-900';

    // Recuperer les valeurs depuis ACF
    $light_color = get_field($field_prefix . 'bg_color_light') ?: $default_light;
    $dark_color = get_field($field_prefix . 'bg_color_dark') ?: $default_dark;

    $classes = [];

    // Classe mode clair
    if ($light_color && $light_color !== 'transparent') {
        $classes[] = 'bg-' . $light_color;
    }

    // Classe mode sombre
    if ($dark_color && $dark_color !== 'transparent') {
        $classes[] = 'dark:bg-' . $dark_color;
    }

    return implode(' ', $classes);
}

/**
 * Recuperer les classes de couleur de texte selon l'arriere-plan
 *
 * Determine automatiquement la couleur du texte selon l'arriere-plan
 *
 * @param string $bg_color Couleur d'arriere-plan
 * @return string Classes CSS pour la couleur du texte
 */
function socorif_get_text_color_for_background($bg_color = 'white') {
    $dark_backgrounds = ['gray-900', 'gray-800', 'black', 'secondary', 'secondary-dark', 'primary'];

    if (in_array($bg_color, $dark_backgrounds)) {
        return 'text-white dark:text-white';
    }

    return 'text-gray-900 dark:text-white';
}

/**
 * Enregistrer la categorie de bloc
 */
add_filter('block_categories_all', function($categories) {
    return array_merge([
        [
            'slug' => 'beka-blocks',
            'title' => 'Beka Blocks',
            'icon' => 'layout',
        ]
    ], $categories);
});
