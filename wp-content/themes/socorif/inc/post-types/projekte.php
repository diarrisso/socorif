<?php
/**
 * Projets (Projets) Custom Post Type
 *
 * Enregistre le Custom Post Type pour les projets/references (Projets)
 */

if (!defined('ABSPATH')) exit;

/**
 * Enregistrer le Custom Post Type Projets
 */
function socorif_register_projekte_post_type(): void {
    $labels = [
        'name'                  => 'Projets',
        'singular_name'         => 'Projet',
        'menu_name'             => 'Projets',
        'name_admin_bar'        => 'Projet',
        'add_new'               => 'Nouveau projet',
        'add_new_item'          => 'Ajouter un nouveau projet',
        'new_item'              => 'Nouveau projet',
        'edit_item'             => 'Modifier le projet',
        'view_item'             => 'Voir le projet',
        'all_items'             => 'Tout le portfolio',
        'search_items'          => 'Rechercher dans le portfolio',
        'parent_item_colon'     => 'Projet parent:',
        'not_found'             => 'Aucun projet trouve.',
        'not_found_in_trash'    => 'Aucun projet dans la corbeille.',
        'featured_image'        => 'Image principale du projet',
        'set_featured_image'    => 'Definir l\'image principale',
        'remove_featured_image' => 'Supprimer l\'image principale',
        'use_featured_image'    => 'Utiliser comme image principale',
        'archives'              => 'Archives du portfolio',
        'insert_into_item'      => 'Inserer dans le projet',
        'uploaded_to_this_item' => 'Telecharge pour ce projet',
        'filter_items_list'     => 'Filtrer le portfolio',
        'items_list_navigation' => 'Navigation du portfolio',
        'items_list'            => 'Projets',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'projets', 'with_front' => false],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-building',
        'show_in_rest'        => true,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies'          => ['projekt_kategorie', 'projekt_typ'],
    ];

    register_post_type('projekte', $args);
}
add_action('init', 'socorif_register_projekte_post_type');


/**
 * Enregistrer la taxonomie Categories de projets
 */
function socorif_register_projekt_kategorie_taxonomy(): void {
    $labels = [
        'name'              => 'Categories de projets',
        'singular_name'     => 'Categorie de projet',
        'search_items'      => 'Rechercher des categories',
        'all_items'         => 'Toutes les categories',
        'parent_item'       => 'Categorie parente',
        'parent_item_colon' => 'Categorie parente:',
        'edit_item'         => 'Modifier la categorie',
        'update_item'       => 'Mettre a jour la categorie',
        'add_new_item'      => 'Ajouter une nouvelle categorie',
        'new_item_name'     => 'Nom de la nouvelle categorie',
        'menu_name'         => 'Categories',
    ];

    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'categorie-projet'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('projekt_kategorie', ['projekte'], $args);
}
add_action('init', 'socorif_register_projekt_kategorie_taxonomy');


/**
 * Enregistrer la taxonomie Types de projets (Neuf, Renovation, etc.)
 */
function socorif_register_projekt_typ_taxonomy(): void {
    $labels = [
        'name'              => 'Types de projets',
        'singular_name'     => 'Type de projet',
        'search_items'      => 'Rechercher des types',
        'all_items'         => 'Tous les types',
        'parent_item'       => 'Type parent',
        'parent_item_colon' => 'Type parent:',
        'edit_item'         => 'Modifier le type',
        'update_item'       => 'Mettre a jour le type',
        'add_new_item'      => 'Ajouter un nouveau type',
        'new_item_name'     => 'Nom du nouveau type',
        'menu_name'         => 'Types',
    ];

    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'type-projet'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('projekt_typ', ['projekte'], $args);
}
add_action('init', 'socorif_register_projekt_typ_taxonomy');


/**
 * Inserer les taxonomies par defaut (une seule fois a l'activation)
 */
function socorif_insert_default_projekt_taxonomies(): void {
    // Verifier si deja insere
    if (get_option('socorif_projekt_taxonomies_inserted')) {
        return;
    }

    // Categories par defaut
    $default_categories = [
        'Residentiel' => 'Projets residentiels, maisons, appartements',
        'Commercial' => 'Bureaux, commerces, batiments industriels',
        'Terrains' => 'Terrains a batir, lotissements',
        'Infrastructures' => 'Voiries, reseaux, amenagements',
    ];

    foreach ($default_categories as $name => $description) {
        if (!term_exists($name, 'projekt_kategorie')) {
            wp_insert_term($name, 'projekt_kategorie', [
                'description' => $description,
            ]);
        }
    }

    // Types par defaut
    $default_types = [
        'Construction neuve' => 'Construction de nouveaux batiments',
        'Renovation' => 'Renovation et rehabilitation de biens existants',
        'Amenagement' => 'Amenagement de terrains et espaces',
        'Lotissement' => 'Creation de lotissements',
    ];

    foreach ($default_types as $name => $description) {
        if (!term_exists($name, 'projekt_typ')) {
            wp_insert_term($name, 'projekt_typ', [
                'description' => $description,
            ]);
        }
    }

    // Definir l'option pour ne pas re-executer
    update_option('socorif_projekt_taxonomies_inserted', true);
}
add_action('init', 'socorif_insert_default_projekt_taxonomies');


/**
 * Personnaliser les colonnes admin pour les projets
 */
function socorif_projekte_admin_columns(array $columns): array {
    $new_columns = [];

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        // Inserer des colonnes supplementaires apres le titre
        if ($key === 'title') {
            $new_columns['projekt_kategorie'] = 'Categorie';
            $new_columns['projekt_typ'] = 'Type';
            $new_columns['projekt_standort'] = 'Localisation';
            $new_columns['projekt_fertigstellung'] = 'Date de livraison';
        }
    }

    // Supprimer la colonne date car on a Date de livraison
    unset($new_columns['date']);

    return $new_columns;
}
add_filter('manage_projekte_posts_columns', 'socorif_projekte_admin_columns');


/**
 * Afficher le contenu des colonnes admin personnalisees
 */
function socorif_projekte_admin_column_content(string $column, int $post_id): void {
    switch ($column) {
        case 'projekt_kategorie':
            $terms = get_the_terms($post_id, 'projekt_kategorie');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array_map(fn($term) => $term->name, $terms);
                echo esc_html(implode(', ', $term_names));
            } else {
                echo '—';
            }
            break;

        case 'projekt_typ':
            $terms = get_the_terms($post_id, 'projekt_typ');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array_map(fn($term) => $term->name, $terms);
                echo esc_html(implode(', ', $term_names));
            } else {
                echo '—';
            }
            break;

        case 'projekt_standort':
            $standort = get_field('projekt_standort', $post_id);
            echo $standort ? esc_html($standort) : '—';
            break;

        case 'projekt_fertigstellung':
            $fertigstellung = get_field('projekt_fertigstellung', $post_id);
            if ($fertigstellung) {
                echo esc_html(date_i18n('F Y', strtotime($fertigstellung)));
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_projekte_posts_custom_column', 'socorif_projekte_admin_column_content', 10, 2);


/**
 * Definir les colonnes triables
 */
function socorif_projekte_sortable_columns(array $columns): array {
    $columns['projekt_kategorie'] = 'projekt_kategorie';
    $columns['projekt_typ'] = 'projekt_typ';
    $columns['projekt_fertigstellung'] = 'projekt_fertigstellung';

    return $columns;
}
add_filter('manage_edit-projekte_sortable_columns', 'socorif_projekte_sortable_columns');


/**
 * Ajouter automatiquement les blocs par defaut pour les nouveaux projets
 * Pour que le redacteur n'ait qu'a remplir le contenu
 */
function socorif_projekte_add_default_blocks(int $post_id, $post, bool $update): void {
    // Uniquement pour les nouveaux posts
    if ($update || $post->post_type !== 'projekte' || $post->post_status === 'auto-draft') {
        return;
    }

    // Verifier si des blocs existent deja
    if (get_field('flexible_content', $post_id)) {
        return;
    }

    // Blocs par defaut pour les nouveaux projets
    $default_blocks = [
        [
            'acf_fc_layout' => 'details-page',
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'image' => '',
            'features' => '',
        ],
        [
            'acf_fc_layout' => 'before-after',
            'title' => 'Avant-Apres',
            'before_image' => '',
            'after_image' => '',
        ],
        [
            'acf_fc_layout' => 'gallery',
            'title' => 'Galerie du projet',
            'images' => '',
        ],
        [
            'acf_fc_layout' => 'testimonials',
            'title' => 'Temoignage client',
            'testimonials' => '',
        ],
    ];

    // Ajouter les blocs
    update_field('flexible_content', $default_blocks, $post_id);
}
add_action('save_post', 'socorif_projekte_add_default_blocks', 20, 3);


/**
 * Sanitisation des donnees de projet lors de la sauvegarde
 *
 * @param mixed $value La valeur a sauvegarder
 * @param int|string $post_id L'ID du post
 * @param array $field Le tableau du champ ACF
 * @return mixed La valeur sanitisee
 */
function socorif_projekte_sanitize_data($value, $post_id, array $field) {
    // Uniquement pour le Post Type projets
    if (is_numeric($post_id) && get_post_type($post_id) !== 'projekte') {
        return $value;
    }

    // Sanitiser les champs email
    if ($field['type'] === 'email' && !empty($value)) {
        return sanitize_email($value);
    }

    // Sanitiser les champs URL
    if ($field['type'] === 'url' && !empty($value)) {
        return esc_url_raw($value);
    }

    // Sanitiser les champs texte
    if ($field['type'] === 'text' && is_string($value) && !empty($value)) {
        return sanitize_text_field($value);
    }

    return $value;
}
add_filter('acf/update_value', 'socorif_projekte_sanitize_data', 10, 3);


/**
 * Ajuster la structure d'URL (Flush rewrite rules a l'activation du theme)
 *
 * Note: register_activation_hook ne fonctionne pas dans les themes, uniquement dans les plugins.
 * On utilise donc after_switch_theme pour les themes.
 */
function socorif_projekte_flush_rewrite_rules(): void {
    // Verifier si deja flush apres l'activation du theme
    if (get_option('socorif_projekte_rewrite_flushed')) {
        return;
    }

    socorif_register_projekte_post_type();
    socorif_register_projekt_kategorie_taxonomy();
    socorif_register_projekt_typ_taxonomy();
    flush_rewrite_rules();

    // Definir l'option pour ne pas executer a chaque chargement de page
    update_option('socorif_projekte_rewrite_flushed', true);
}
add_action('after_switch_theme', 'socorif_projekte_flush_rewrite_rules');

