<?php
/**
 * Fonctions admin pour les offres d'emploi
 *
 * Utilitaires admin pour la gestion des offres d'emploi
 *
 * @package Socorif
 * @since 1.0.0
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ajouter le menu admin pour les utilitaires des offres d'emploi
 */
function socorif_emplois_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=emplois',
        'Creer des exemples',
        'Creer des exemples',
        'manage_options',
        'emplois-examples',
        'socorif_emplois_examples_page'
    );
}
add_action('admin_menu', 'socorif_emplois_admin_menu');

/**
 * Page admin pour creer des exemples d'offres d'emploi
 */
function socorif_emplois_examples_page() {
    // Verifier les permissions
    if (!current_user_can('manage_options')) {
        wp_die(__('Vous n\'avez pas les permissions pour acceder a cette page.', 'socorif'));
    }

    // Gerer la soumission du formulaire
    if (isset($_POST['create_examples']) && check_admin_referer('socorif_create_examples', 'socorif_examples_nonce')) {
        // Charger le fichier d'aide
        $helper_file = SOCORIF_DIR . '/inc/helpers/create-emplois-examples.php';
        if (file_exists($helper_file)) {
            require_once $helper_file;
        }

        // Reinitialiser l'option pour permettre la recreation
        if (isset($_POST['reset_examples'])) {
            delete_option('socorif_emplois_examples_created');
        }

        // Creer les exemples
        if (function_exists('socorif_create_emplois_examples')) {
            socorif_create_emplois_examples();
        }

        echo '<div class="notice notice-success is-dismissible"><p>Les exemples d\'offres d\'emploi ont ete crees avec succes !</p></div>';
    }

    $examples_created = get_option('socorif_emplois_examples_created');

    ?>
    <div class="wrap">
        <h1>Creer des exemples d'offres d'emploi</h1>

        <?php if ($examples_created): ?>
            <div class="notice notice-info">
                <p>Des exemples ont deja ete crees. Activez "Reinitialiser les exemples" pour les recreer.</p>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('socorif_create_examples', 'socorif_examples_nonce'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">Action</th>
                    <td>
                        <p>Cette fonction cree 3 exemples d'offres d'emploi :</p>
                        <ul style="list-style: disc; margin-left: 20px;">
                            <li>Chef de projet (H/F) - CDI</li>
                            <li>Technicien (H/F) - CDI</li>
                            <li>Stagiaire (H/F) - Stage</li>
                        </ul>
                    </td>
                </tr>

                <?php if ($examples_created): ?>
                <tr>
                    <th scope="row">Reinitialiser les exemples</th>
                    <td>
                        <label>
                            <input type="checkbox" name="reset_examples" value="1">
                            Supprimer et recreer les exemples
                        </label>
                    </td>
                </tr>
                <?php endif; ?>
            </table>

            <?php submit_button('Creer les exemples', 'primary', 'create_examples'); ?>
        </form>

        <hr>

        <h2>Offres d'emploi actuelles</h2>
        <?php
        $jobs = new WP_Query(array(
            'post_type' => 'emplois',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        if ($jobs->have_posts()): ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Categorie</th>
                        <th>Type de contrat</th>
                        <th>Debut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($jobs->have_posts()): $jobs->the_post();
                        $post_id = get_the_ID();
                        $categories = get_the_terms($post_id, 'emplois_category');
                        $contract_types = get_the_terms($post_id, 'emplois_contract_type');
                        $start_date = get_field('start_date', $post_id);
                    ?>
                        <tr>
                            <td>
                                <strong>
                                    <a href="<?php echo esc_url(get_edit_post_link($post_id)); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </strong>
                            </td>
                            <td>
                                <?php
                                if ($categories && !is_wp_error($categories)) {
                                    echo esc_html(implode(', ', wp_list_pluck($categories, 'name')));
                                } else {
                                    echo '—';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($contract_types && !is_wp_error($contract_types)) {
                                    echo esc_html(implode(', ', wp_list_pluck($contract_types, 'name')));
                                } else {
                                    echo '—';
                                }
                                ?>
                            </td>
                            <td><?php echo esc_html($start_date ?: '—'); ?></td>
                            <td><?php echo esc_html(get_the_date()); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune offre d'emploi trouvee.</p>
        <?php endif;

        wp_reset_postdata();
        ?>
    </div>
    <?php
}

/**
 * Action rapide pour supprimer les exemples d'offres
 */
function socorif_emplois_delete_examples() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['action']) && $_GET['action'] === 'delete_emplois_examples' &&
        isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'delete_examples')) {

        // Recuperer toutes les offres d'emploi
        $jobs = get_posts(array(
            'post_type' => 'emplois',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids'
        ));

        // Supprimer chaque offre
        foreach ($jobs as $job_id) {
            wp_delete_post($job_id, true);
        }

        // Reinitialiser l'option
        delete_option('socorif_emplois_examples_created');

        wp_redirect(admin_url('edit.php?post_type=emplois&examples_deleted=1'));
        exit;
    }
}
add_action('admin_init', 'socorif_emplois_delete_examples');

/**
 * Afficher les notifications admin
 */
function socorif_emplois_admin_notices() {
    if (isset($_GET['examples_deleted']) && $_GET['examples_deleted'] === '1') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>Toutes les offres d'emploi ont ete supprimees.</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'socorif_emplois_admin_notices');
