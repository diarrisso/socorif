<?php
/**
 * Gestionnaire de formulaires pour les demandes de devis
 *
 * Traite les soumissions de formulaires et envoie les emails
 *
 * @package Socorif
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Traite les demandes de devis
 */
function socorif_handle_quote_form(): void {
    // Verification du nonce
    if (!isset($_POST['quote_nonce']) || !wp_verify_nonce($_POST['quote_nonce'], 'socorif_quote_form_nonce')) {
        wp_die('Verification de securite echouee. Veuillez reessayer.');
    }

    // Collecter et nettoyer les donnees
    $service_name = sanitize_text_field($_POST['service_name'] ?? '');
    $service_slug = sanitize_text_field($_POST['service_slug'] ?? '');
    $prenom = sanitize_text_field($_POST['vorname'] ?? '');
    $nom = sanitize_text_field($_POST['nachname'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $telephone = sanitize_text_field($_POST['telefon'] ?? '');
    $adresse = sanitize_text_field($_POST['adresse'] ?? '');
    $code_postal = sanitize_text_field($_POST['plz'] ?? '');
    $ville = sanitize_text_field($_POST['ort'] ?? '');
    $description_projet = sanitize_textarea_field($_POST['projektbeschreibung'] ?? '');
    $delai = sanitize_text_field($_POST['zeitrahmen'] ?? 'Non specifie');

    // Validation
    if (empty($prenom) || empty($nom) || empty($email) || empty($telephone) || empty($description_projet)) {
        wp_die('Veuillez remplir tous les champs obligatoires.');
    }

    if (!is_email($email)) {
        wp_die('Veuillez entrer une adresse email valide.');
    }

    // Email a l'administrateur
    $admin_email = get_option('admin_email');
    $subject_admin = 'Nouvelle demande de devis: ' . $service_name;

    $message_admin = "Nouvelle demande de devis pour {$service_name}\n\n";
    $message_admin .= "Coordonnees:\n";
    $message_admin .= "Nom: {$prenom} {$nom}\n";
    $message_admin .= "Email: {$email}\n";
    $message_admin .= "Telephone: {$telephone}\n\n";
    $message_admin .= "Localisation du projet:\n";
    $message_admin .= "Adresse: {$adresse}\n";
    $message_admin .= "Code postal: {$code_postal}\n";
    $message_admin .= "Ville: {$ville}\n\n";
    $message_admin .= "Description du projet:\n";
    $message_admin .= $description_projet . "\n\n";
    $message_admin .= "Delai souhaite: {$delai}\n\n";
    $message_admin .= "---\n";
    $message_admin .= "Envoye le: " . date('d/m/Y H:i') . "\n";

    $headers_admin = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>',
        'Reply-To: ' . $email
    ];

    wp_mail($admin_email, $subject_admin, $message_admin, $headers_admin);

    // Email de confirmation au client
    $subject_client = 'Votre demande chez ' . get_bloginfo('name') . ' - ' . $service_name;

    $message_client = "Bonjour {$prenom} {$nom},\n\n";
    $message_client .= "Merci pour votre demande concernant notre service \"{$service_name}\".\n\n";
    $message_client .= "Nous avons bien recu votre demande et vous recontacterons sous 24 heures.\n\n";
    $message_client .= "Vos informations:\n";
    $message_client .= "Service: {$service_name}\n";
    $message_client .= "Localisation: {$adresse}, {$code_postal} {$ville}\n";
    $message_client .= "Delai: {$delai}\n\n";
    $message_client .= "Cordialement,\n";
    $message_client .= "L'equipe " . get_bloginfo('name') . "\n\n";
    $message_client .= "---\n";
    $message_client .= get_bloginfo('name') . "\n";
    $message_client .= get_bloginfo('url') . "\n";

    $headers_client = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>'
    ];

    wp_mail($email, $subject_client, $message_client, $headers_client);

    // Redirection vers la page de remerciement
    $redirect_url = add_query_arg('anfrage', 'success', home_url('/merci/'));
    wp_safe_redirect($redirect_url);
    exit;
}

// Hook pour le traitement du formulaire de devis
add_action('admin_post_socorif_quote_form', 'socorif_handle_quote_form');
add_action('admin_post_nopriv_socorif_quote_form', 'socorif_handle_quote_form');

/**
 * Traite le formulaire de contact
 */
function socorif_handle_contact_form(): void {
    // Verification du nonce
    if (!isset($_POST['socorif_nonce']) || !wp_verify_nonce($_POST['socorif_nonce'], 'socorif_contact_form')) {
        wp_die('Verification de securite echouee. Veuillez reessayer.');
    }

    // Collecter et nettoyer les donnees
    $first_name = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name = sanitize_text_field($_POST['last_name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($subject) || empty($message)) {
        wp_die('Veuillez remplir tous les champs obligatoires.');
    }

    if (!is_email($email)) {
        wp_die('Veuillez entrer une adresse email valide.');
    }

    // Email a l'administrateur
    $admin_email = get_option('admin_email');
    $subject_admin = '[' . get_bloginfo('name') . '] ' . $subject;

    $message_admin = "Nouveau message de contact\n\n";
    $message_admin .= "De: {$first_name} {$last_name}\n";
    $message_admin .= "Email: {$email}\n";
    $message_admin .= "Telephone: " . ($phone ?: 'Non fourni') . "\n";
    $message_admin .= "Sujet: {$subject}\n\n";
    $message_admin .= "Message:\n";
    $message_admin .= "----------------------------------------\n";
    $message_admin .= $message . "\n";
    $message_admin .= "----------------------------------------\n\n";
    $message_admin .= "Envoye le: " . date('d/m/Y H:i') . "\n";

    $headers_admin = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <noreply@' . wp_parse_url(home_url(), PHP_URL_HOST) . '>',
        'Reply-To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>'
    ];

    $sent = wp_mail($admin_email, $subject_admin, $message_admin, $headers_admin);

    // Email de confirmation au client
    $subject_client = 'Confirmation de votre message - ' . get_bloginfo('name');

    $message_client = "Bonjour {$first_name} {$last_name},\n\n";
    $message_client .= "Nous avons bien recu votre message et vous remercions de nous avoir contactes.\n\n";
    $message_client .= "Notre equipe vous repondra dans les plus brefs delais.\n\n";
    $message_client .= "Recapitulatif de votre message:\n";
    $message_client .= "Sujet: {$subject}\n";
    $message_client .= "Message: {$message}\n\n";
    $message_client .= "Cordialement,\n";
    $message_client .= "L'equipe " . get_bloginfo('name') . "\n\n";
    $message_client .= "---\n";
    $message_client .= get_bloginfo('name') . "\n";
    $message_client .= get_bloginfo('url') . "\n";

    $headers_client = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <noreply@' . wp_parse_url(home_url(), PHP_URL_HOST) . '>'
    ];

    wp_mail($email, $subject_client, $message_client, $headers_client);

    // Redirection vers la page de remerciement
    $redirect_url = add_query_arg('contact', 'success', home_url('/merci/'));
    wp_safe_redirect($redirect_url);
    exit;
}

// Hook pour le formulaire de contact
add_action('admin_post_socorif_contact_form', 'socorif_handle_contact_form');
add_action('admin_post_nopriv_socorif_contact_form', 'socorif_handle_contact_form');
