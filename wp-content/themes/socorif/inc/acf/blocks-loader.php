<?php
/**
 * ACF Blocks Auto-Loader
 *
 * Charge automatiquement tous les fichiers config.php des blocs depuis template-parts/blocks/
 */

if (!defined('ABSPATH')) exit;

/**
 * Charger toutes les configurations de blocs
 */
function socorif_load_acf_blocks() {
    // Verifier si ACF est actif
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // Recuperer le repertoire des blocs
    $blocks_dir = BEKA_DIR . '/template-parts/blocks';

    if (!is_dir($blocks_dir)) {
        return;
    }

    // Rechercher les dossiers de blocs
    $block_folders = array_filter(glob($blocks_dir . '/*'), 'is_dir');

    foreach ($block_folders as $block_folder) {
        $config_file = $block_folder . '/config.php';

        // Charger config.php si present
        if (file_exists($config_file)) {
            require_once $config_file;
        }
    }
}

// Charger les blocs a init (apres le chargement d'ACF)
// TEMPORAIREMENT DESACTIVE: Conflit avec Flexible Content
// add_action('acf/init', 'socorif_load_acf_blocks', 5);
