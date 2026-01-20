<?php
/**
 * Property Custom Post Type
 *
 * Enregistre le Custom Post Type pour les biens immobiliers
 */

if (!defined('ABSPATH')) exit;

/**
 * Enregistrer le Custom Post Type Property
 */
function socorif_register_property_post_type(): void {
    $labels = [
        'name'                  => 'Biens',
        'singular_name'         => 'Bien',
        'menu_name'             => 'Biens Immobiliers',
        'name_admin_bar'        => 'Bien',
        'add_new'               => 'Ajouter',
        'add_new_item'          => 'Ajouter un nouveau bien',
        'new_item'              => 'Nouveau bien',
        'edit_item'             => 'Modifier le bien',
        'view_item'             => 'Voir le bien',
        'all_items'             => 'Tous les biens',
        'search_items'          => 'Rechercher un bien',
        'parent_item_colon'     => 'Bien parent:',
        'not_found'             => 'Aucun bien trouve.',
        'not_found_in_trash'    => 'Aucun bien dans la corbeille.',
        'featured_image'        => 'Image principale',
        'set_featured_image'    => 'Definir l\'image principale',
        'remove_featured_image' => 'Retirer l\'image principale',
        'use_featured_image'    => 'Utiliser comme image principale',
        'archives'              => 'Archives des biens',
        'insert_into_item'      => 'Inserer dans le bien',
        'uploaded_to_this_item' => 'Televerse vers ce bien',
        'filter_items_list'     => 'Filtrer la liste des biens',
        'items_list_navigation' => 'Navigation de la liste des biens',
        'items_list'            => 'Liste des biens',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'biens', 'with_front' => false],
        'capability_type'     => 'post',
        'has_archive'         => 'biens',
        'hierarchical'        => false,
        'menu_position'       => 22,
        'menu_icon'           => 'dashicons-admin-home',
        'show_in_rest'        => true,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies'          => ['property_category', 'property_type'],
    ];

    register_post_type('property', $args);
}
add_action('init', 'socorif_register_property_post_type');

/**
 * Enregistrer la taxonomie Categories de biens
 */
function socorif_register_property_category_taxonomy(): void {
    $labels = [
        'name'              => 'Categories de Biens',
        'singular_name'     => 'Categorie de Bien',
        'search_items'      => 'Rechercher une categorie',
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
        'rewrite'           => ['slug' => 'categorie-bien'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('property_category', ['property'], $args);
}
add_action('init', 'socorif_register_property_category_taxonomy');

/**
 * Enregistrer la taxonomie Types de biens
 */
function socorif_register_property_type_taxonomy(): void {
    $labels = [
        'name'              => 'Types de Transaction',
        'singular_name'     => 'Type de Transaction',
        'search_items'      => 'Rechercher un type',
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
        'rewrite'           => ['slug' => 'type-bien'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('property_type', ['property'], $args);
}
add_action('init', 'socorif_register_property_type_taxonomy');

/**
 * Inserer les categories par defaut (une seule fois)
 */
function socorif_insert_default_property_taxonomies(): void {
    // Verifier si deja insere
    if (get_option('socorif_property_taxonomies_inserted')) {
        return;
    }

    // Categories par defaut
    $default_categories = [
        'Terrains' => 'Terrains a batir et parcelles',
        'Maisons' => 'Maisons individuelles et villas',
        'Appartements' => 'Appartements et studios',
        'Locaux commerciaux' => 'Bureaux et locaux professionnels',
    ];

    foreach ($default_categories as $name => $description) {
        if (!term_exists($name, 'property_category')) {
            wp_insert_term($name, 'property_category', [
                'description' => $description,
            ]);
        }
    }

    // Types par defaut
    $default_types = [
        'Vente' => 'Biens a vendre',
        'Location' => 'Biens a louer',
        'Gestion' => 'Biens en gestion',
    ];

    foreach ($default_types as $name => $description) {
        if (!term_exists($name, 'property_type')) {
            wp_insert_term($name, 'property_type', [
                'description' => $description,
            ]);
        }
    }

    // Definir l'option
    update_option('socorif_property_taxonomies_inserted', true);
}
add_action('init', 'socorif_insert_default_property_taxonomies');

/**
 * Personnaliser les colonnes admin
 */
function socorif_property_admin_columns(array $columns): array {
    $new_columns = [];

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        // Ajouter des colonnes apres le titre
        if ($key === 'title') {
            $new_columns['property_category'] = 'Categorie';
            $new_columns['property_type'] = 'Type';
            $new_columns['property_price'] = 'Prix';
            $new_columns['property_surface'] = 'Surface';
        }
    }

    return $new_columns;
}
add_filter('manage_property_posts_columns', 'socorif_property_admin_columns');

/**
 * Afficher le contenu des colonnes personnalisees
 */
function socorif_property_admin_column_content(string $column, int $post_id): void {
    switch ($column) {
        case 'property_category':
            $terms = get_the_terms($post_id, 'property_category');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array_map(fn($term) => $term->name, $terms);
                echo esc_html(implode(', ', $term_names));
            } else {
                echo '—';
            }
            break;

        case 'property_type':
            $terms = get_the_terms($post_id, 'property_type');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array_map(fn($term) => $term->name, $terms);
                echo esc_html(implode(', ', $term_names));
            } else {
                echo '—';
            }
            break;

        case 'property_price':
            $price = get_field('property_price', $post_id);
            if ($price) {
                echo esc_html(number_format($price, 0, ',', ' ') . ' GNF');
            } else {
                echo '—';
            }
            break;

        case 'property_surface':
            $surface = get_field('property_surface', $post_id);
            if ($surface) {
                echo esc_html($surface . ' m²');
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_property_posts_custom_column', 'socorif_property_admin_column_content', 10, 2);

/**
 * Definir les colonnes triables
 */
function socorif_property_sortable_columns(array $columns): array {
    $columns['property_category'] = 'property_category';
    $columns['property_type'] = 'property_type';

    return $columns;
}
add_filter('manage_edit-property_sortable_columns', 'socorif_property_sortable_columns');

/**
 * Flush rewrite rules lors de l'activation du theme
 */
function socorif_property_flush_rewrite_rules(): void {
    socorif_register_property_post_type();
    socorif_register_property_category_taxonomy();
    socorif_register_property_type_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'socorif_property_flush_rewrite_rules');
