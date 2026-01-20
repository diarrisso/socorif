<?php
/**
 * Offres d'emploi Custom Post Type
 *
 * Gere les offres d'emploi avec taxonomies et fonctions de securite
 *
 * @package Socorif
 * @since 1.0.0
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enregistrer le Custom Post Type Offres d'emploi
 */
function socorif_register_emplois_post_type(): void
{
    $labels = array(
        'name'                  => _x('Offres d\'emploi', 'Post Type General Name', 'socorif'),
        'singular_name'         => _x('Offre d\'emploi', 'Post Type Singular Name', 'socorif'),
        'menu_name'             => __('Offres d\'emploi', 'socorif'),
        'name_admin_bar'        => __('Offre d\'emploi', 'socorif'),
        'archives'              => __('Archives des offres', 'socorif'),
        'attributes'            => __('Attributs de l\'offre', 'socorif'),
        'parent_item_colon'     => __('Offre parente:', 'socorif'),
        'all_items'             => __('Toutes les offres', 'socorif'),
        'add_new_item'          => __('Ajouter une nouvelle offre', 'socorif'),
        'add_new'               => __('Ajouter', 'socorif'),
        'new_item'              => __('Nouvelle offre', 'socorif'),
        'edit_item'             => __('Modifier l\'offre', 'socorif'),
        'update_item'           => __('Mettre a jour l\'offre', 'socorif'),
        'view_item'             => __('Voir l\'offre', 'socorif'),
        'view_items'            => __('Voir les offres', 'socorif'),
        'search_items'          => __('Rechercher une offre', 'socorif'),
        'not_found'             => __('Aucune offre trouvee', 'socorif'),
        'not_found_in_trash'    => __('Aucune offre dans la corbeille', 'socorif'),
        'featured_image'        => __('Image a la une', 'socorif'),
        'set_featured_image'    => __('Definir l\'image a la une', 'socorif'),
        'remove_featured_image' => __('Supprimer l\'image a la une', 'socorif'),
        'use_featured_image'    => __('Utiliser comme image a la une', 'socorif'),
        'insert_into_item'      => __('Inserer dans l\'offre', 'socorif'),
        'uploaded_to_this_item' => __('Telecharge pour cette offre', 'socorif'),
        'items_list'            => __('Liste des offres', 'socorif'),
        'items_list_navigation' => __('Navigation de la liste des offres', 'socorif'),
        'filter_items_list'     => __('Filtrer la liste des offres', 'socorif'),
    );

    $args = array(
        'label'                 => __('Offre d\'emploi', 'socorif'),
        'description'           => __('Offres d\'emploi et opportunites de carriere', 'socorif'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'revisions', 'custom-fields'),
        'taxonomies'            => array('emplois_category', 'emplois_contract_type'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-id-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array(
            'slug'       => 'carrieres/offre',
            'with_front' => false,
        ),
    );

    register_post_type('emplois', $args);
}
add_action('init', 'socorif_register_emplois_post_type', 0);

/**
 * Enregistrer la taxonomie Categories d'offres
 */
function socorif_register_emplois_category_taxonomy(): void
{
    $labels = array(
        'name'                       => _x('Categories', 'Taxonomy General Name', 'socorif'),
        'singular_name'              => _x('Categorie', 'Taxonomy Singular Name', 'socorif'),
        'menu_name'                  => __('Categories', 'socorif'),
        'all_items'                  => __('Toutes les categories', 'socorif'),
        'parent_item'                => __('Categorie parente', 'socorif'),
        'parent_item_colon'          => __('Categorie parente:', 'socorif'),
        'new_item_name'              => __('Nom de la nouvelle categorie', 'socorif'),
        'add_new_item'               => __('Ajouter une nouvelle categorie', 'socorif'),
        'edit_item'                  => __('Modifier la categorie', 'socorif'),
        'update_item'                => __('Mettre a jour la categorie', 'socorif'),
        'view_item'                  => __('Voir la categorie', 'socorif'),
        'separate_items_with_commas' => __('Separer les categories par des virgules', 'socorif'),
        'add_or_remove_items'        => __('Ajouter ou supprimer des categories', 'socorif'),
        'choose_from_most_used'      => __('Choisir parmi les plus utilisees', 'socorif'),
        'popular_items'              => __('Categories populaires', 'socorif'),
        'search_items'               => __('Rechercher des categories', 'socorif'),
        'not_found'                  => __('Non trouve', 'socorif'),
        'no_terms'                   => __('Aucune categorie', 'socorif'),
        'items_list'                 => __('Liste des categories', 'socorif'),
        'items_list_navigation'      => __('Navigation de la liste des categories', 'socorif'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array(
            'slug' => 'categorie-emploi',
        ),
    );

    register_taxonomy('emplois_category', array('emplois'), $args);
}
add_action('init', 'socorif_register_emplois_category_taxonomy', 0);

/**
 * Enregistrer la taxonomie Types de contrat
 */
function socorif_register_emplois_contract_type_taxonomy(): void
{
    $labels = array(
        'name'                       => _x('Types de contrat', 'Taxonomy General Name', 'socorif'),
        'singular_name'              => _x('Type de contrat', 'Taxonomy Singular Name', 'socorif'),
        'menu_name'                  => __('Types de contrat', 'socorif'),
        'all_items'                  => __('Tous les types', 'socorif'),
        'parent_item'                => __('Type parent', 'socorif'),
        'parent_item_colon'          => __('Type parent:', 'socorif'),
        'new_item_name'              => __('Nom du nouveau type', 'socorif'),
        'add_new_item'               => __('Ajouter un nouveau type', 'socorif'),
        'edit_item'                  => __('Modifier le type', 'socorif'),
        'update_item'                => __('Mettre a jour le type', 'socorif'),
        'view_item'                  => __('Voir le type', 'socorif'),
        'separate_items_with_commas' => __('Separer les types par des virgules', 'socorif'),
        'add_or_remove_items'        => __('Ajouter ou supprimer des types', 'socorif'),
        'choose_from_most_used'      => __('Choisir parmi les plus utilises', 'socorif'),
        'popular_items'              => __('Types populaires', 'socorif'),
        'search_items'               => __('Rechercher des types', 'socorif'),
        'not_found'                  => __('Non trouve', 'socorif'),
        'no_terms'                   => __('Aucun type', 'socorif'),
        'items_list'                 => __('Liste des types', 'socorif'),
        'items_list_navigation'      => __('Navigation de la liste des types', 'socorif'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array(
            'slug' => 'type-contrat',
        ),
    );

    register_taxonomy('emplois_contract_type', array('emplois'), $args);
}
add_action('init', 'socorif_register_emplois_contract_type_taxonomy', 0);

/**
 * Inserer les taxonomies par defaut a l'activation
 */
function socorif_emplois_insert_default_taxonomies() {
    // Verifier si deja insere
    if (get_option('socorif_emplois_taxonomies_inserted')) {
        return;
    }

    // Categories par defaut
    $default_categories = array(
        'Administration',
        'Commercial',
        'Technique',
        'Stage',
    );

    foreach ($default_categories as $category) {
        if (!term_exists($category, 'emplois_category')) {
            wp_insert_term($category, 'emplois_category');
        }
    }

    // Types de contrat par defaut
    $default_contract_types = array(
        array('name' => 'CDI', 'slug' => 'cdi'),
        array('name' => 'CDD', 'slug' => 'cdd'),
        array('name' => 'Stage', 'slug' => 'stage'),
        array('name' => 'Alternance', 'slug' => 'alternance'),
    );

    foreach ($default_contract_types as $contract_type) {
        if (!term_exists($contract_type['slug'], 'emplois_contract_type')) {
            wp_insert_term(
                $contract_type['name'],
                'emplois_contract_type',
                array('slug' => $contract_type['slug'])
            );
        }
    }

    // Marquer comme insere
    update_option('socorif_emplois_taxonomies_inserted', true);
}
add_action('init', 'socorif_emplois_insert_default_taxonomies');

/**
 * Ajouter des colonnes personnalisees a la liste admin
 */
function socorif_emplois_custom_columns($columns): array
{
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['category'] = __('Categorie', 'socorif');
    $new_columns['contract_type'] = __('Type de contrat', 'socorif');
    $new_columns['start_date'] = __('Date de debut', 'socorif');
    $new_columns['date'] = $columns['date'];

    return $new_columns;
}
add_filter('manage_emplois_posts_columns', 'socorif_emplois_custom_columns');

/**
 * Remplir les colonnes personnalisees
 */
function socorif_emplois_custom_columns_content($column, $post_id): void
{
    switch ($column) {
        case 'category':
            $terms = get_the_terms($post_id, 'emplois_category');
            if ($terms && !is_wp_error($terms)) {
                $category_names = array_map(function($term) {
                    return esc_html($term->name);
                }, $terms);
                echo implode(', ', $category_names);
            } else {
                echo '—';
            }
            break;

        case 'contract_type':
            $terms = get_the_terms($post_id, 'emplois_contract_type');
            if ($terms && !is_wp_error($terms)) {
                $type_names = array_map(function($term) {
                    return esc_html($term->name);
                }, $terms);
                echo implode(', ', $type_names);
            } else {
                echo '—';
            }
            break;

        case 'start_date':
            $start_date = get_field('start_date', $post_id);
            echo $start_date ? esc_html($start_date) : '—';
            break;
    }
}
add_action('manage_emplois_posts_custom_column', 'socorif_emplois_custom_columns_content', 10, 2);

/**
 * Rendre les colonnes personnalisees triables
 */
function socorif_emplois_sortable_columns($columns) {
    $columns['start_date'] = 'start_date';
    $columns['category'] = 'category';
    $columns['contract_type'] = 'contract_type';
    return $columns;
}
add_filter('manage_edit-emplois_sortable_columns', 'socorif_emplois_sortable_columns');

/**
 * Securite: Nettoyer et valider les donnees des offres d'emploi
 *
 * @param mixed $post_id ID du post ou 'options' pour les pages d'options ACF
 */
function socorif_emplois_sanitize_data($post_id): void
{
    // Verifier le type de post (EN PREMIER - sortie rapide pour les autres types)
    if (!is_numeric($post_id) || get_post_type($post_id) !== 'emplois') {
        return;
    }

    // Verifier si c'est une sauvegarde automatique
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Verifier les permissions de l'utilisateur
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Nettoyer l'email si present
    $email = get_field('application_email', $post_id);
    if ($email && !is_email($email)) {
        update_field('application_email', '', $post_id);
    }

    // Nettoyer l'URL si presente
    $link = get_field('application_link', $post_id);
    if ($link && is_array($link) && isset($link['url'])) {
        $sanitized_url = esc_url_raw($link['url']);
        if ($sanitized_url !== $link['url']) {
            $link['url'] = $sanitized_url;
            update_field('application_link', $link, $post_id);
        }
    }
}
add_action('acf/save_post', 'socorif_emplois_sanitize_data', 20);

/**
 * Actualiser les regles de reecriture a l'activation
 */
function socorif_emplois_flush_rewrites(): void
{
    // Verifier si deja flush apres l'activation du theme
    if (get_option('socorif_emplois_rewrite_flushed')) {
        return;
    }

    socorif_register_emplois_post_type();
    socorif_register_emplois_category_taxonomy();
    socorif_register_emplois_contract_type_taxonomy();
    flush_rewrite_rules();

    // Definir l'option pour ne pas executer a chaque chargement de page
    update_option('socorif_emplois_rewrite_flushed', true);
}
add_action('after_switch_theme', 'socorif_emplois_flush_rewrites');
