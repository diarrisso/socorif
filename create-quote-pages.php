<?php
/**
 * Script pour créer les pages de formulaires de devis
 *
 * USAGE:
 * 1. Télécharger ce fichier à la racine de WordPress
 * 2. Accéder via navigateur: https://votresite.com/create-quote-pages.php
 * 3. Supprimer ce fichier après utilisation pour des raisons de sécurité
 *
 * @package Beka
 */

// Charger WordPress
require_once __DIR__ . '/wp-load.php';

// Vérifier les permissions (admin seulement)
if (!current_user_can('manage_options')) {
    wp_die('Vous devez être administrateur pour exécuter ce script.');
}

// Définir les pages à créer
$pages = [
    [
        'post_title'    => 'Balkonsanierung Angebot',
        'post_name'     => 'balkonsanierung-angebot',
        'page_template' => 'page-angebot-balkonsanierung.php',
    ],
    [
        'post_title'    => 'Bauwerksabdichtung Angebot',
        'post_name'     => 'bauwerksabdichtung-angebot',
        'page_template' => 'page-angebot-bauwerksabdichtung.php',
    ],
    [
        'post_title'    => 'Beschichtung Angebot',
        'post_name'     => 'beschichtung-angebot',
        'page_template' => 'page-angebot-beschichtung.php',
    ],
    [
        'post_title'    => 'Betonsanierung Angebot',
        'post_name'     => 'betonsanierung-angebot',
        'page_template' => 'page-angebot-betonsanierung.php',
    ],
    [
        'post_title'    => 'Sachverständigung Angebot',
        'post_name'     => 'sachverstaendigung-angebot',
        'page_template' => 'page-angebot-sachverstaendigung.php',
    ],
    [
        'post_title'    => 'Schimmelpilzsanierung Angebot',
        'post_name'     => 'schimmelpilzsanierung-angebot',
        'page_template' => 'page-angebot-schimmelpilzsanierung.php',
    ],
    [
        'post_title'    => 'Vielen Dank',
        'post_name'     => 'danke',
        'page_template' => 'page-danke.php',
    ],
];

echo '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création des pages de formulaires</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #f97316;
            padding-bottom: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin: 10px 0;
            border-left: 4px solid #dc3545;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 12px;
            border-radius: 4px;
            margin: 10px 0;
            border-left: 4px solid #17a2b8;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .page-link {
            color: #f97316;
            text-decoration: none;
            font-weight: 500;
        }
        .page-link:hover {
            text-decoration: underline;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 12px;
            border-radius: 4px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Création des pages de formulaires de devis</h1>';

$created_pages = [];
$errors = [];

// Créer chaque page
foreach ($pages as $page_data) {
    // Vérifier si la page existe déjà
    $existing_page = get_page_by_path($page_data['post_name']);

    if ($existing_page) {
        $errors[] = "La page '{$page_data['post_title']}' existe déjà (ID: {$existing_page->ID})";
        continue;
    }

    // Créer la page
    $page_id = wp_insert_post([
        'post_type'      => 'page',
        'post_title'     => $page_data['post_title'],
        'post_name'      => $page_data['post_name'],
        'post_status'    => 'publish',
        'post_content'   => '',
        'comment_status' => 'closed',
        'ping_status'    => 'closed',
    ]);

    if (is_wp_error($page_id)) {
        $errors[] = "Erreur lors de la création de '{$page_data['post_title']}': " . $page_id->get_error_message();
        continue;
    }

    // Définir le template
    update_post_meta($page_id, '_wp_page_template', $page_data['page_template']);

    $created_pages[] = [
        'id'    => $page_id,
        'title' => $page_data['post_title'],
        'url'   => get_permalink($page_id),
        'slug'  => $page_data['post_name'],
    ];
}

// Afficher les résultats
if (!empty($created_pages)) {
    echo '<div class="success">';
    echo '<strong>✓ ' . count($created_pages) . ' page(s) créée(s) avec succès!</strong>';
    echo '</div>';

    echo '<h2>Pages créées:</h2>';
    echo '<ul>';
    foreach ($created_pages as $page) {
        echo '<li>';
        echo '<strong>' . esc_html($page['title']) . '</strong><br>';
        echo 'ID: ' . $page['id'] . ' | ';
        echo '<a href="' . esc_url($page['url']) . '" class="page-link" target="_blank">Voir la page</a> | ';
        echo '<a href="' . admin_url('post.php?post=' . $page['id'] . '&action=edit') . '" class="page-link" target="_blank">Modifier</a>';
        echo '</li>';
    }
    echo '</ul>';
}

if (!empty($errors)) {
    echo '<h2>Erreurs:</h2>';
    foreach ($errors as $error) {
        echo '<div class="error">' . esc_html($error) . '</div>';
    }
}

if (empty($created_pages) && empty($errors)) {
    echo '<div class="info">Aucune page à créer. Toutes les pages existent déjà.</div>';
}

echo '
        <div class="info" style="margin-top: 30px;">
            <strong>Prochaines étapes:</strong>
            <ol style="margin-left: 20px; margin-top: 10px;">
                <li>Vérifier les pages dans <a href="' . admin_url('edit.php?post_type=page') . '" class="page-link">WordPress Admin → Pages</a></li>
                <li>Ajouter les liens dans votre menu "Leistungen"</li>
                <li>Tester chaque formulaire</li>
            </ol>
        </div>

        <div class="warning">
            <strong>⚠️ IMPORTANT:</strong> Pour des raisons de sécurité, supprimez ce fichier (create-quote-pages.php) après utilisation.
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <a href="' . admin_url() . '" style="display: inline-block; padding: 12px 24px; background: #f97316; color: white; text-decoration: none; border-radius: 4px; font-weight: 500;">
                Aller au tableau de bord WordPress
            </a>
        </div>
    </div>
</body>
</html>';
