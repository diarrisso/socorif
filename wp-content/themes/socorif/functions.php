<?php
/**
 * Fonctions du theme Socorif
 *
 * @package Socorif
 * @version 1.0.0
 */

if (!defined('ABSPATH')) exit;

// Constantes du theme
define('SOCORIF_VERSION', '1.0.0');
define('SOCORIF_DIR', get_template_directory());
define('SOCORIF_URI', get_template_directory_uri());

// Alias pour compatibilite avec l'ancien code
define('BEKA_VERSION', SOCORIF_VERSION);
define('BEKA_DIR', SOCORIF_DIR);
define('BEKA_URI', SOCORIF_URI);

/**
 * Charger les fonctions utilitaires en premier
 */
require_once SOCORIF_DIR . '/inc/helpers/html-helpers.php';
require_once SOCORIF_DIR . '/inc/helpers/class-helpers.php';
require_once SOCORIF_DIR . '/inc/helpers/data-helpers.php';
require_once SOCORIF_DIR . '/inc/helpers/placeholder-images.php';
require_once SOCORIF_DIR . '/inc/helpers/create-example-content.php';

/**
 * Charger la configuration du theme
 */
require_once SOCORIF_DIR . '/inc/setup.php';

/**
 * Charger les Nav Walkers
 */
require_once SOCORIF_DIR . '/inc/class-beka-nav-walker.php';
require_once SOCORIF_DIR . '/inc/class-beka-footer-walker.php';

/**
 * Charger les styles dynamiques
 */
require_once SOCORIF_DIR . '/inc/dynamic-styles.php';

/**
 * Charger les utilitaires ACF
 */
if (class_exists('ACF')) {
    require_once SOCORIF_DIR . '/inc/acf/block-utils.php';
    require_once SOCORIF_DIR . '/inc/acf/options-pages.php';
    require_once SOCORIF_DIR . '/inc/acf/blocks-loader.php';
    require_once SOCORIF_DIR . '/inc/acf/flexible-content.php';
}

/**
 * Charger le gestionnaire de formulaires
 */
require_once SOCORIF_DIR . '/inc/form-handler.php';

/**
 * Charger les Custom Post Types
 */
require_once SOCORIF_DIR . '/inc/post-types/emplois.php';
require_once SOCORIF_DIR . '/inc/post-types/projekte.php';
require_once SOCORIF_DIR . '/inc/post-types/leistungen.php';
require_once SOCORIF_DIR . '/inc/post-types/property.php';

/**
 * Charger les groupes de champs ACF
 */
if (function_exists('acf_add_local_field_group')) {
    require_once SOCORIF_DIR . '/inc/acf-fields/emplois-fields.php';
    require_once SOCORIF_DIR . '/inc/acf-fields/projekte-fields.php';
    require_once SOCORIF_DIR . '/inc/acf-fields/leistungen-fields.php';
    require_once SOCORIF_DIR . '/inc/acf-fields/property-fields.php';
    require_once SOCORIF_DIR . '/inc/acf-fields/page-karriere-fields.php';
    require_once SOCORIF_DIR . '/inc/acf-fields/page-kontakt-fields.php';
}

/**
 * Charger les utilitaires admin
 */
if (is_admin()) {
    require_once SOCORIF_DIR . '/inc/admin/emplois-admin.php';
}

/**
 * Charger un composant
 */
function socorif_component($name, $args = []) {
    $file = SOCORIF_DIR . '/template-parts/components/' . $name . '.php';

    if (file_exists($file)) {
        include $file;
    }
}

/**
 * Charger un template de bloc
 */
function socorif_block($name, $args = []) {
    $file = SOCORIF_DIR . '/template-parts/blocks/' . $name . '/' . $name . '.php';

    if (file_exists($file)) {
        include $file;
    }
}

/**
 * Retourne true si le blog a plus d'une categorie.
 *
 * @return bool
 */
function socorif_categorized_blog() {
    $all_the_cool_cats = get_transient('socorif_categories');

    if (false === $all_the_cool_cats) {
        $all_the_cool_cats = get_categories(array(
            'fields'     => 'ids',
            'hide_empty' => 1,
            'number'     => 2,
        ));

        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('socorif_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        return true;
    }

    return false;
}

/**
 * Supprime les transients utilises dans socorif_categorized_blog.
 */
function socorif_category_transient_flusher() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    delete_transient('socorif_categories');
}
add_action('edit_category', 'socorif_category_transient_flusher');
add_action('save_post', 'socorif_category_transient_flusher');

/**
 * Augmenter les limites d'upload pour les fichiers media
 */
@ini_set('upload_max_filesize', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300');
@ini_set('memory_limit', '256M');

/**
 * Contact Form 7: desactiver wpautop
 * Empeche CF7 d'envelopper les shortcodes dans des balises <p>
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Blocs flexibles par defaut pour les CPT
 * Ajoute des blocs pre-remplis lors de la creation d'un nouveau post
 */
add_filter('acf/load_value/name=flexible_content', 'socorif_default_flexible_content', 10, 3);
function socorif_default_flexible_content($value, $post_id, $field) {
    // Ne pas modifier si des valeurs existent deja
    if (!empty($value)) {
        return $value;
    }

    // Ne pas modifier pour les revisions ou autosaves
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return $value;
    }

    $post_type = get_post_type($post_id);

    // Blocs par defaut pour les Projets (Projekte)
    if ($post_type === 'projekte') {
        $value = [
            [
                'acf_fc_layout' => 'temoignages',
                'section_title' => 'Ce que dit notre client',
                'temoignages' => [
                    [
                        'quote' => 'Socorif a realise notre projet avec professionnalisme et dans les delais.',
                        'person_name' => 'Client satisfait',
                        'person_title' => 'Proprietaire',
                    ],
                ],
            ],
            [
                'acf_fc_layout' => 'cta-divise',
                'layout_type' => 'centered',
                'subtitle' => 'Un projet similaire?',
                'title' => 'Parlons de votre projet',
                'description' => 'Contactez-nous pour discuter de vos besoins.',
                'button' => ['title' => 'Demander un devis', 'url' => home_url('/contact'), 'target' => ''],
            ],
        ];
    }

    // Blocs par defaut pour les Proprietes (Property)
    if ($post_type === 'property') {
        $value = [
            [
                'acf_fc_layout' => 'accordeon',
                'accordion_title' => 'Informations supplementaires',
                'accordion_items' => [
                    ['title' => 'Documents disponibles', 'content' => '<p>Titre foncier, permis de construire, plans...</p>'],
                    ['title' => 'Modalites de paiement', 'content' => '<p>Paiement comptant ou echelonne possible.</p>'],
                    ['title' => 'Visites', 'content' => '<p>Contactez-nous pour organiser une visite.</p>'],
                ],
            ],
            [
                'acf_fc_layout' => 'galerie-unites',
                'section_title' => 'Unites disponibles',
            ],
        ];
    }

    // Blocs par defaut pour les Emplois
    if ($post_type === 'emplois') {
        $value = [
            [
                'acf_fc_layout' => 'accordeon',
                'accordion_title' => 'Questions frequentes',
                'accordion_items' => [
                    ['title' => 'Comment postuler?', 'content' => '<p>Envoyez votre CV et lettre de motivation via le formulaire ci-dessous ou par email.</p>'],
                    ['title' => 'Quels documents fournir?', 'content' => '<p>CV, lettre de motivation, copies des diplomes et references.</p>'],
                    ['title' => 'Quel est le processus de recrutement?', 'content' => '<p>Examen du dossier, entretien telephonique, entretien en personne, decision finale.</p>'],
                ],
            ],
            [
                'acf_fc_layout' => 'cta-divise',
                'layout_type' => 'centered',
                'subtitle' => 'Interesse(e)?',
                'title' => 'Postulez maintenant',
                'description' => 'Rejoignez notre equipe et participez a des projets passionnants.',
                'button' => ['title' => 'Postuler', 'url' => home_url('/carrieres'), 'target' => ''],
            ],
        ];
    }

    return $value;
}
