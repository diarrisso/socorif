<?php
/**
 * Configuration du bloc Grille Blog
 *
 * Systeme complet de grille blog avec integration WordPress, filtres, pagination, etc.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enregistrer le bloc Grille Blog
 */
function socorif_register_blog_grid_block(): void {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type([
            'name'              => 'blog-grid',
            'title'             => __('Grille Blog', 'socorif'),
            'description'       => __('Systeme complet de grille blog avec filtres, pagination et plusieurs vues', 'socorif'),
            'category'          => 'socorif-blocks',
            'icon'              => 'grid-view',
            'keywords'          => ['blog', 'grid', 'articles', 'news', 'posts'],
            'mode'              => 'preview',
            'supports'          => [
                'align' => false,
                'mode'  => true,
                'jsx'   => true,
            ],
            'render_template'   => get_template_directory() . '/template-parts/blocks/grille-blog/grille-blog.php',
            'enqueue_assets'    => function() {
                wp_enqueue_script(
                    'socorif-blog-grid',
                    get_template_directory_uri() . '/assets/dist/blog-grid.js',
                    ['alpine'],
                    filemtime(get_template_directory() . '/assets/dist/blog-grid.js'),
                    true
                );
            },
        ]);
    }
}
add_action('acf/init', 'socorif_register_blog_grid_block');

/**
 * Groupe de champs du bloc Grille Blog
 */
function socorif_register_blog_grid_fields(): void {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group([
            'key'       => 'group_blog_grid_block',
            'title'     => 'Bloc Grille Blog',
            'fields'    => [

                // ============================================
                // ONGLET: Contenu
                // ============================================
                [
                    'key'   => 'field_blog_grid_content_tab',
                    'label' => 'Contenu',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],

                // En-tete de section
                [
                    'key'   => 'field_blog_grid_section_title',
                    'label' => 'Titre de la section',
                    'name'  => 'section_title',
                    'type'  => 'text',
                    'default_value' => 'Du Blog',
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_section_description',
                    'label' => 'Description de la section',
                    'name'  => 'section_description',
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'default_value' => 'Decouvrez comment developper votre entreprise avec nos conseils d\'experts.',
                    'wrapper' => ['width' => '50'],
                ],

                // Source du contenu
                [
                    'key'   => 'field_blog_grid_content_source',
                    'label' => 'Source du contenu',
                    'name'  => 'content_source',
                    'type'  => 'select',
                    'choices' => [
                        'wordpress' => 'Articles WordPress (automatique)',
                        'manual'    => 'Articles manuels',
                    ],
                    'default_value' => 'wordpress',
                    'ui' => 1,
                ],

                // Parametres des articles WordPress
                [
                    'key'   => 'field_blog_grid_post_type',
                    'label' => 'Type de publication',
                    'name'  => 'post_type',
                    'type'  => 'select',
                    'choices' => [
                        'post' => 'Articles',
                        'any'  => 'Tous les types',
                    ],
                    'default_value' => 'post',
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_content_source', 'operator' => '==', 'value' => 'wordpress']
                    ]],
                    'wrapper' => ['width' => '33.33'],
                ],
                [
                    'key'   => 'field_blog_grid_posts_per_page',
                    'label' => 'Nombre d\'articles',
                    'name'  => 'posts_per_page',
                    'type'  => 'number',
                    'default_value' => 6,
                    'min'   => 1,
                    'max'   => 24,
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_content_source', 'operator' => '==', 'value' => 'wordpress']
                    ]],
                    'wrapper' => ['width' => '33.33'],
                ],
                [
                    'key'   => 'field_blog_grid_orderby',
                    'label' => 'Trier par',
                    'name'  => 'orderby',
                    'type'  => 'select',
                    'choices' => [
                        'date'          => 'Date',
                        'title'         => 'Titre',
                        'modified'      => 'Derniere modification',
                        'rand'          => 'Aleatoire',
                        'comment_count' => 'Commentaires',
                    ],
                    'default_value' => 'date',
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_content_source', 'operator' => '==', 'value' => 'wordpress']
                    ]],
                    'wrapper' => ['width' => '33.33'],
                ],
                [
                    'key'   => 'field_blog_grid_categories',
                    'label' => 'Filtrer par categories',
                    'name'  => 'categories',
                    'type'  => 'taxonomy',
                    'taxonomy' => 'category',
                    'field_type' => 'multi_select',
                    'return_format' => 'id',
                    'instructions' => 'Laisser vide pour toutes les categories',
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_content_source', 'operator' => '==', 'value' => 'wordpress']
                    ]],
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_tags',
                    'label' => 'Filtrer par tags',
                    'name'  => 'tags',
                    'type'  => 'taxonomy',
                    'taxonomy' => 'post_tag',
                    'field_type' => 'multi_select',
                    'return_format' => 'id',
                    'instructions' => 'Laisser vide pour tous les tags',
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_content_source', 'operator' => '==', 'value' => 'wordpress']
                    ]],
                    'wrapper' => ['width' => '50'],
                ],

                // Articles manuels
                [
                    'key'   => 'field_blog_grid_articles',
                    'label' => 'Articles manuels',
                    'name'  => 'articles',
                    'type'  => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Ajouter un article',
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_content_source', 'operator' => '==', 'value' => 'manual']
                    ]],
                    'sub_fields' => [
                        [
                            'key'   => 'field_blog_grid_article_image',
                            'label' => 'Image de fond',
                            'name'  => 'image',
                            'type'  => 'image',
                            'required' => 0,
                            'return_format' => 'array',
                            'wrapper' => ['width' => '50'],
                        ],
                        [
                            'key'   => 'field_blog_grid_article_title',
                            'label' => 'Titre',
                            'name'  => 'title',
                            'type'  => 'text',
                            'required' => 0,
                            'wrapper' => ['width' => '50'],
                        ],
                        [
                            'key'   => 'field_blog_grid_article_excerpt',
                            'label' => 'Extrait',
                            'name'  => 'excerpt',
                            'type'  => 'textarea',
                            'rows'  => 3,
                        ],
                        [
                            'key'   => 'field_blog_grid_article_link',
                            'label' => 'Lien',
                            'name'  => 'link',
                            'type'  => 'link',
                            'required' => 0,
                            'return_format' => 'array',
                        ],
                        [
                            'key'   => 'field_blog_grid_article_date',
                            'label' => 'Date',
                            'name'  => 'date',
                            'type'  => 'date_picker',
                            'display_format' => 'd M Y',
                            'return_format' => 'Y-m-d',
                            'wrapper' => ['width' => '33.33'],
                        ],
                        [
                            'key'   => 'field_blog_grid_article_author_name',
                            'label' => 'Nom de l\'auteur',
                            'name'  => 'author_name',
                            'type'  => 'text',
                            'wrapper' => ['width' => '33.33'],
                        ],
                        [
                            'key'   => 'field_blog_grid_article_author_avatar',
                            'label' => 'Avatar de l\'auteur',
                            'name'  => 'author_avatar',
                            'type'  => 'image',
                            'return_format' => 'array',
                            'wrapper' => ['width' => '33.33'],
                        ],
                    ],
                ],

                // ============================================
                // ONGLET: Filtres & Recherche
                // ============================================
                [
                    'key'   => 'field_blog_grid_filters_tab',
                    'label' => 'Filtres & Recherche',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key'   => 'field_blog_grid_enable_filters',
                    'label' => 'Activer les filtres',
                    'name'  => 'enable_filters',
                    'type'  => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                ],
                [
                    'key'   => 'field_blog_grid_show_category_filter',
                    'label' => 'Afficher le filtre par categorie',
                    'name'  => 'show_category_filter',
                    'type'  => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_enable_filters', 'operator' => '==', 'value' => '1']
                    ]],
                    'wrapper' => ['width' => '33.33'],
                ],
                [
                    'key'   => 'field_blog_grid_show_tag_filter',
                    'label' => 'Afficher le filtre par tag',
                    'name'  => 'show_tag_filter',
                    'type'  => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_enable_filters', 'operator' => '==', 'value' => '1']
                    ]],
                    'wrapper' => ['width' => '33.33'],
                ],
                [
                    'key'   => 'field_blog_grid_show_search',
                    'label' => 'Afficher le champ de recherche',
                    'name'  => 'show_search',
                    'type'  => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_enable_filters', 'operator' => '==', 'value' => '1']
                    ]],
                    'wrapper' => ['width' => '33.33'],
                ],
                [
                    'key'   => 'field_blog_grid_show_sort',
                    'label' => 'Afficher le tri',
                    'name'  => 'show_sort',
                    'type'  => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_enable_filters', 'operator' => '==', 'value' => '1']
                    ]],
                ],

                // ============================================
                // ONGLET: Pagination
                // ============================================
                [
                    'key'   => 'field_blog_grid_pagination_tab',
                    'label' => 'Pagination',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key'   => 'field_blog_grid_pagination_type',
                    'label' => 'Type de pagination',
                    'name'  => 'pagination_type',
                    'type'  => 'select',
                    'choices' => [
                        'none'     => 'Aucune',
                        'standard' => 'Standard (1, 2, 3...)',
                        'loadmore' => 'Bouton "Charger plus"',
                        'infinite' => 'Defilement infini',
                    ],
                    'default_value' => 'loadmore',
                    'ui' => 1,
                ],

                // ============================================
                // ONGLET: Mise en page & Vue
                // ============================================
                [
                    'key'   => 'field_blog_grid_layout_tab',
                    'label' => 'Mise en page & Vue',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key'   => 'field_blog_grid_view_mode',
                    'label' => 'Vue par defaut',
                    'name'  => 'view_mode',
                    'type'  => 'select',
                    'choices' => [
                        'grid'   => 'Grille',
                        'list'   => 'Liste',
                        'slider' => 'Slider',
                    ],
                    'default_value' => 'grid',
                    'ui' => 1,
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_allow_view_switch',
                    'label' => 'Afficher le selecteur de vue',
                    'name'  => 'allow_view_switch',
                    'type'  => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                    'instructions' => 'Les utilisateurs peuvent basculer entre Grille, Liste et Slider',
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_columns',
                    'label' => 'Nombre de colonnes (Desktop)',
                    'name'  => 'columns',
                    'type'  => 'select',
                    'choices' => [
                        '2' => '2 colonnes',
                        '3' => '3 colonnes',
                        '4' => '4 colonnes',
                    ],
                    'default_value' => '3',
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_gap',
                    'label' => 'Espacement entre les cartes',
                    'name'  => 'gap',
                    'type'  => 'select',
                    'choices' => [
                        '4' => 'Petit (1rem)',
                        '6' => 'Moyen (1.5rem)',
                        '8' => 'Grand (2rem)',
                        '12' => 'Tres grand (3rem)',
                    ],
                    'default_value' => '8',
                    'wrapper' => ['width' => '50'],
                ],

                // ============================================
                // ONGLET: Options d'affichage
                // ============================================
                [
                    'key'   => 'field_blog_grid_display_tab',
                    'label' => 'Options d\'affichage',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key'   => 'field_blog_grid_show_date',
                    'label' => 'Afficher la date',
                    'name'  => 'show_date',
                    'type'  => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => ['width' => '25'],
                ],
                [
                    'key'   => 'field_blog_grid_show_author',
                    'label' => 'Afficher l\'auteur',
                    'name'  => 'show_author',
                    'type'  => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => ['width' => '25'],
                ],
                [
                    'key'   => 'field_blog_grid_show_excerpt',
                    'label' => 'Afficher l\'extrait',
                    'name'  => 'show_excerpt',
                    'type'  => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                    'wrapper' => ['width' => '25'],
                ],
                [
                    'key'   => 'field_blog_grid_show_categories',
                    'label' => 'Afficher les categories',
                    'name'  => 'show_categories',
                    'type'  => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                    'wrapper' => ['width' => '25'],
                ],
                [
                    'key'   => 'field_blog_grid_excerpt_length',
                    'label' => 'Longueur de l\'extrait (mots)',
                    'name'  => 'excerpt_length',
                    'type'  => 'number',
                    'default_value' => 20,
                    'min'   => 10,
                    'max'   => 100,
                    'conditional_logic' => [[
                        ['field' => 'field_blog_grid_show_excerpt', 'operator' => '==', 'value' => '1']
                    ]],
                ],

                // ============================================
                // ONGLET: Style
                // ============================================
                [
                    'key'   => 'field_blog_grid_styling_tab',
                    'label' => 'Style',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key'   => 'field_blog_grid_card_style',
                    'label' => 'Style de carte',
                    'name'  => 'card_style',
                    'type'  => 'select',
                    'choices' => [
                        'overlay'  => 'Overlay (Image avec texte par-dessus)',
                        'classic'  => 'Classique (Image en haut, texte en bas)',
                        'modern'   => 'Moderne (Effet hover avec zoom)',
                    ],
                    'default_value' => 'overlay',
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_image_ratio',
                    'label' => 'Ratio d\'image',
                    'name'  => 'image_ratio',
                    'type'  => 'select',
                    'choices' => [
                        'auto'   => 'Automatique',
                        '1:1'    => 'Carre (1:1)',
                        '4:3'    => 'Classique (4:3)',
                        '16:9'   => 'Panoramique (16:9)',
                        '21:9'   => 'Ultra-panoramique (21:9)',
                    ],
                    'default_value' => 'auto',
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_overlay_color',
                    'label' => 'Couleur de l\'overlay',
                    'name'  => 'overlay_color',
                    'type'  => 'select',
                    'choices' => [
                        'dark'    => 'Sombre (Noir)',
                        'primary' => 'Couleur primaire',
                        'custom'  => 'Personnalise',
                    ],
                    'default_value' => 'dark',
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_overlay_intensity',
                    'label' => 'Intensite de l\'overlay',
                    'name'  => 'overlay_intensity',
                    'type'  => 'range',
                    'default_value' => 60,
                    'min'   => 0,
                    'max'   => 100,
                    'step'  => 10,
                    'append' => '%',
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_border_radius',
                    'label' => 'Rayon des coins',
                    'name'  => 'border_radius',
                    'type'  => 'select',
                    'choices' => [
                        'none' => 'Aucun (0)',
                        'sm'   => 'Petit (0.5rem)',
                        'md'   => 'Moyen (1rem)',
                        'lg'   => 'Grand (1.5rem)',
                        'xl'   => 'Tres grand (2rem)',
                    ],
                    'default_value' => 'xl',
                    'wrapper' => ['width' => '50'],
                ],
                [
                    'key'   => 'field_blog_grid_hover_effect',
                    'label' => 'Effet au survol',
                    'name'  => 'hover_effect',
                    'type'  => 'select',
                    'choices' => [
                        'none'      => 'Aucun',
                        'scale'     => 'Zoom',
                        'lift'      => 'Elevation',
                        'tilt'      => 'Inclinaison',
                        'brightness' => 'Luminosite',
                    ],
                    'default_value' => 'scale',
                    'wrapper' => ['width' => '50'],
                ],

                // ============================================
                // ONGLET: Espacement & Arriere-plan
                // ============================================
                [
                    'key'   => 'field_blog_grid_spacing_tab',
                    'label' => 'Espacement & Arriere-plan',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key'   => 'field_blog_grid_spacing',
                    'label' => 'Espacement',
                    'name'  => 'spacing',
                    'type'  => 'group',
                    'layout' => 'block',
                    'sub_fields' => socorif_get_spacing_fields(),
                ],
                [
                    'key'   => 'field_blog_grid_background',
                    'label' => 'Arriere-plan decoratif',
                    'name'  => 'background',
                    'type'  => 'group',
                    'layout' => 'block',
                    'sub_fields' => socorif_get_decorative_background_fields(),
                ],

                // ============================================
                // ONGLET: Animation
                // ============================================
                [
                    'key'   => 'field_blog_grid_animation_tab',
                    'label' => 'Animation',
                    'type'  => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key'   => 'field_blog_grid_animation',
                    'label' => 'Animation',
                    'name'  => 'animation',
                    'type'  => 'group',
                    'layout' => 'block',
                    'sub_fields' => socorif_get_animation_fields(),
                ],
                [
                    'key'   => 'field_blog_grid_stagger_animation',
                    'label' => 'Animation decalee pour les cartes',
                    'name'  => 'stagger_animation',
                    'type'  => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'instructions' => 'Les cartes apparaissent les unes apres les autres avec un delai',
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'block',
                        'operator' => '==',
                        'value'    => 'acf/blog-grid',
                    ],
                ],
            ],
        ]);
    }
}
add_action('acf/init', 'socorif_register_blog_grid_fields');

/**
 * Gestionnaire AJAX pour le filtrage et la pagination de la grille blog
 */
function socorif_blog_grid_ajax_handler(): void {
    // Verification de securite
    check_ajax_referer('socorif_blog_grid_nonce', 'nonce');

    // Recuperation des parametres
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6;
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date';
    $categories = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : [];
    $tags = isset($_POST['tags']) ? array_map('intval', $_POST['tags']) : [];
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    // Arguments de la requete
    $args = [
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'orderby'        => $orderby,
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ];

    // Filtre par categories
    if (!empty($categories)) {
        $args['cat'] = $categories;
    }

    // Filtre par tags
    if (!empty($tags)) {
        $args['tag__in'] = $tags;
    }

    // Recherche
    if (!empty($search)) {
        $args['s'] = $search;
    }

    // Execution de la requete
    $query = new WP_Query($args);

    $response = [
        'success'    => true,
        'posts'      => [],
        'pagination' => [
            'current_page' => $paged,
            'total_pages'  => $query->max_num_pages,
            'total_posts'  => $query->found_posts,
            'has_more'     => $paged < $query->max_num_pages,
        ],
    ];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $thumbnail = get_the_post_thumbnail_url($post_id, 'large');

            $response['posts'][] = [
                'id'         => $post_id,
                'title'      => get_the_title(),
                'excerpt'    => get_the_excerpt(),
                'permalink'  => get_permalink(),
                'date'       => get_the_date('Y-m-d'),
                'date_formatted' => get_the_date('j. M Y'),
                'thumbnail'  => $thumbnail ?: '',
                'author'     => [
                    'name'   => get_the_author(),
                    'avatar' => get_avatar_url(get_the_author_meta('ID')),
                ],
                'categories' => array_map(function($cat) {
                    return ['id' => $cat->term_id, 'name' => $cat->name];
                }, get_the_category()),
            ];
        }
    }

    wp_reset_postdata();

    wp_send_json($response);
}
add_action('wp_ajax_socorif_blog_grid_load', 'socorif_blog_grid_ajax_handler');
add_action('wp_ajax_nopriv_socorif_blog_grid_load', 'socorif_blog_grid_ajax_handler');
