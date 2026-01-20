<?php
/**
 * Services Custom Post Type
 *
 * Enregistre le Custom Post Type pour les services
 */

if (!defined('ABSPATH')) exit;

/**
 * Enregistrer le Custom Post Type Services
 */
function socorif_register_leistungen_post_type(): void {
    $labels = [
        'name'                  => 'Services',
        'singular_name'         => 'Service',
        'menu_name'             => 'Services',
        'name_admin_bar'        => 'Service',
        'add_new'               => 'Nouveau service',
        'add_new_item'          => 'Ajouter un nouveau service',
        'new_item'              => 'Nouveau service',
        'edit_item'             => 'Modifier le service',
        'view_item'             => 'Voir le service',
        'all_items'             => 'Tous les services',
        'search_items'          => 'Rechercher des services',
        'parent_item_colon'     => 'Service parent:',
        'not_found'             => 'Aucun service trouve.',
        'not_found_in_trash'    => 'Aucun service dans la corbeille.',
        'featured_image'        => 'Image principale du service',
        'set_featured_image'    => 'Definir l\'image principale',
        'remove_featured_image' => 'Supprimer l\'image principale',
        'use_featured_image'    => 'Utiliser comme image principale',
        'archives'              => 'Archives des services',
        'insert_into_item'      => 'Inserer dans le service',
        'uploaded_to_this_item' => 'Telecharge pour ce service',
        'filter_items_list'     => 'Filtrer la liste des services',
        'items_list_navigation' => 'Navigation de la liste des services',
        'items_list'            => 'Liste des services',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => false, // Desactive car on utilise des regles de reecriture personnalisees
        'capability_type'     => 'post',
        'has_archive'         => 'services',
        'hierarchical'        => false,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-admin-tools',
        'show_in_rest'        => true,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies'          => ['leistung_kategorie'],
    ];

    register_post_type('leistungen', $args);
}
add_action('init', 'socorif_register_leistungen_post_type');


/**
 * Regles de reecriture personnalisees pour les services au niveau racine
 */
function socorif_leistungen_rewrite_rules(): void {
    // Recuperer tous les services publies
    $leistungen = get_posts([
        'post_type' => 'leistungen',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'fields' => 'ids'
    ]);

    // Ajouter une regle de reecriture pour chaque service
    foreach ($leistungen as $leistung_id) {
        $slug = get_post_field('post_name', $leistung_id);

        // URL principale
        add_rewrite_rule(
            '^' . $slug . '/?$',
            'index.php?leistungen=' . $slug,
            'top'
        );

        // Pagination
        add_rewrite_rule(
            '^' . $slug . '/page/?([0-9]{1,})/?$',
            'index.php?leistungen=' . $slug . '&paged=$matches[1]',
            'top'
        );
    }

    // Page d'archive
    add_rewrite_rule(
        '^services/?$',
        'index.php?post_type=leistungen',
        'top'
    );

    add_rewrite_rule(
        '^services/page/?([0-9]{1,})/?$',
        'index.php?post_type=leistungen&paged=$matches[1]',
        'top'
    );
}
add_action('init', 'socorif_leistungen_rewrite_rules', 20);


/**
 * Enregistrer la taxonomie Categories de services
 */
function socorif_register_leistung_kategorie_taxonomy(): void {
    $labels = [
        'name'              => 'Categories de services',
        'singular_name'     => 'Categorie de service',
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
        'rewrite'           => ['slug' => 'categorie-service'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('leistung_kategorie', ['leistungen'], $args);
}
add_action('init', 'socorif_register_leistung_kategorie_taxonomy');


/**
 * Inserer les categories par defaut (une seule fois a l'activation)
 */
function socorif_insert_default_leistung_taxonomies(): void {
    // Verifier si deja insere
    if (get_option('socorif_leistung_taxonomies_inserted')) {
        return;
    }

    // Categories par defaut basees sur le secteur immobilier
    $default_categories = [
        'Gestion Immobiliere' => 'Gestion et promotion immobiliere',
        'Amenagement' => 'Amenagement des domaines',
        'Topographie' => 'Levee topographique et dressage de plans',
        'Transaction' => 'Vente et achat de terrains et maisons',
    ];

    foreach ($default_categories as $name => $description) {
        if (!term_exists($name, 'leistung_kategorie')) {
            wp_insert_term($name, 'leistung_kategorie', [
                'description' => $description,
            ]);
        }
    }

    // Definir l'option
    update_option('socorif_leistung_taxonomies_inserted', true);
}
add_action('init', 'socorif_insert_default_leistung_taxonomies');


/**
 * Personnaliser les colonnes admin pour les services
 */
function socorif_leistungen_admin_columns(array $columns): array {
    $new_columns = [];

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        // Inserer des colonnes supplementaires apres le titre
        if ($key === 'title') {
            $new_columns['leistung_kategorie'] = 'Categorie';
            $new_columns['leistung_icon'] = 'Icone';
        }
    }

    return $new_columns;
}
add_filter('manage_leistungen_posts_columns', 'socorif_leistungen_admin_columns');


/**
 * Afficher le contenu des colonnes admin personnalisees
 */
function socorif_leistungen_admin_column_content(string $column, int $post_id): void {
    switch ($column) {
        case 'leistung_kategorie':
            $terms = get_the_terms($post_id, 'leistung_kategorie');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array_map(fn($term) => $term->name, $terms);
                echo esc_html(implode(', ', $term_names));
            } else {
                echo '—';
            }
            break;

        case 'leistung_icon':
            $icon = get_field('leistung_icon', $post_id);
            if ($icon) {
                echo '<span class="dashicons ' . esc_attr($icon) . '"></span>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_leistungen_posts_custom_column', 'socorif_leistungen_admin_column_content', 10, 2);


/**
 * Definir les colonnes triables
 */
function socorif_leistungen_sortable_columns(array $columns): array {
    $columns['leistung_kategorie'] = 'leistung_kategorie';

    return $columns;
}
add_filter('manage_edit-leistungen_sortable_columns', 'socorif_leistungen_sortable_columns');


/**
 * Recharger les regles de reecriture quand un service est sauvegarde
 */
function socorif_leistungen_flush_on_save(int $post_id, $post, bool $update): void {
    if ($post->post_type === 'leistungen' && $post->post_status === 'publish') {
        // Uniquement pour les nouveaux posts ou les changements de slug
        if (!$update || get_post_meta($post_id, '_slug_changed', true)) {
            flush_rewrite_rules();
            delete_post_meta($post_id, '_slug_changed');
        }
    }
}
add_action('save_post', 'socorif_leistungen_flush_on_save', 10, 3);


/**
 * Ajouter automatiquement les blocs par defaut pour les nouveaux services
 * Pour que le redacteur n'ait qu'a remplir le contenu
 */
function socorif_leistungen_add_default_blocks(int $post_id, $post, bool $update): void {
    // Uniquement pour les nouveaux posts
    if ($update || $post->post_type !== 'leistungen' || $post->post_status === 'auto-draft') {
        return;
    }

    // Verifier si des blocs existent deja
    if (get_field('flexible_content', $post_id)) {
        return;
    }

    // Blocs par defaut pour les nouveaux services
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
            'acf_fc_layout' => 'youtube-video',
            'video_url' => '',
            'title' => '',
        ],
        [
            'acf_fc_layout' => 'accordion',
            'title' => 'Questions frequentes',
            'accordion_items' => '',
        ],
        [
            'acf_fc_layout' => 'gallery',
            'title' => 'Galerie de projets',
            'images' => '',
        ],
        [
            'acf_fc_layout' => 'timeline',
            'title' => 'Notre processus',
            'timeline_items' => '',
        ],
        [
            'acf_fc_layout' => 'contact-form',
            'title' => 'Demander un devis',
            'subtitle' => '',
            'form_id' => '',
        ],
    ];

    // Ajouter les blocs
    update_field('flexible_content', $default_blocks, $post_id);
}
add_action('save_post', 'socorif_leistungen_add_default_blocks', 20, 3);


/**
 * Ajuster la structure d'URL (Flush rewrite rules a l'activation du theme)
 */
function socorif_leistungen_flush_rewrite_rules(): void {
    socorif_register_leistungen_post_type();
    socorif_register_leistung_kategorie_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'socorif_leistungen_flush_rewrite_rules');

