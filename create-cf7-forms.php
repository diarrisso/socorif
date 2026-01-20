<?php
/**
 * Script pour créer les formulaires Contact Form 7 pour tous les services BEKA
 *
 * Usage: wp eval-file create-cf7-forms.php
 */

if (!defined('ABSPATH')) {
    // Charger WordPress si exécuté directement
    require_once(__DIR__ . '/wp-load.php');
}

// Services BEKA
$services = [
    [
        'name' => 'Balkonsanierung',
        'slug' => 'balkonsanierung',
        'title' => 'Angebotsanfrage: Balkonsanierung',
        'description' => 'Professionelle Balkonsanierung - von der Beratung bis zur fachgerechten Ausführung.'
    ],
    [
        'name' => 'Betonsanierung',
        'slug' => 'betonsanierung',
        'title' => 'Angebotsanfrage: Betonsanierung',
        'description' => 'Professionelle Betoninstandsetzung für dauerhafte Stabilität und Sicherheit.'
    ],
    [
        'name' => 'Bauwerksabdichtung',
        'slug' => 'bauwerksabdichtung',
        'title' => 'Angebotsanfrage: Bauwerksabdichtung',
        'description' => 'Fachgerechte Abdichtung für Ihr Bauwerk - Schutz vor Feuchtigkeit und Wasserschäden.'
    ],
    [
        'name' => 'Beschichtung',
        'slug' => 'beschichtung',
        'title' => 'Angebotsanfrage: Beschichtung',
        'description' => 'Hochwertige Beschichtungen für Langlebigkeit und Schutz Ihrer Oberflächen.'
    ],
    [
        'name' => 'Sachverständigung',
        'slug' => 'sachverstaendigung',
        'title' => 'Angebotsanfrage: Sachverständigung',
        'description' => 'Unabhängige Begutachtung und Expertise von qualifizierten Sachverständigen.'
    ],
    [
        'name' => 'Schimmelpilzsanierung',
        'slug' => 'schimmelpilzsanierung',
        'title' => 'Angebotsanfrage: Schimmelpilzsanierung',
        'description' => 'Professionelle Schimmelpilzbeseitigung für gesundes Raumklima und Wohlfühlen.'
    ]
];

// Template du formulaire CF7
$form_template = '<div class="cf7-service-form">
    <div class="form-section">
        <h3>Ihre Kontaktdaten</h3>
        <div class="form-row">
            <div class="form-col">
                <label>Vorname *
                    [text* vorname class:form-control placeholder "z.B. Max"]
                </label>
            </div>
            <div class="form-col">
                <label>Nachname *
                    [text* nachname class:form-control placeholder "z.B. Mustermann"]
                </label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-col">
                <label>E-Mail-Adresse *
                    [email* email class:form-control placeholder "z.B. max@example.com"]
                </label>
            </div>
            <div class="form-col">
                <label>Telefonnummer *
                    [tel* telefon class:form-control placeholder "z.B. 0123 456789"]
                </label>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h3>Projektstandort</h3>
        <div class="form-row">
            <div class="form-col-full">
                <label>Adresse (Straße, Hausnummer) *
                    [text* adresse class:form-control placeholder "z.B. Musterstraße 123"]
                </label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-col">
                <label>PLZ *
                    [text* plz class:form-control placeholder "z.B. 12345"]
                </label>
            </div>
            <div class="form-col">
                <label>Ort *
                    [text* ort class:form-control placeholder "z.B. München"]
                </label>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h3>Projektbeschreibung</h3>
        <div class="form-row">
            <div class="form-col-full">
                <label>Beschreiben Sie Ihr Projekt *
                    [textarea* projektbeschreibung class:form-control placeholder "Bitte beschreiben Sie möglichst detailliert, was gemacht werden soll..."]
                </label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-col-full">
                <label>Gewünschter Zeitrahmen
                    [select zeitrahmen class:form-control "Bitte wählen" "Sofort" "1-2 Wochen" "1 Monat" "2-3 Monate" "Nach Absprache"]
                </label>
            </div>
        </div>
    </div>

    <div class="form-section">
        <label class="datenschutz-label">
            [acceptance datenschutz class:form-check]
            Ich habe die <a href="' . home_url('/datenschutz/') . '" target="_blank" class="text-primary">Datenschutzerklärung</a> gelesen und akzeptiert. *
        </label>
    </div>

    <div class="form-submit">
        [submit class:btn-primary "Kostenloses Angebot anfordern"]
    </div>

    <p class="form-hint">* Pflichtfelder | Wir melden uns innerhalb von 24 Stunden bei Ihnen</p>
</div>';

$created_forms = [];

foreach ($services as $service) {
    // Vérifier si le formulaire existe déjà
    $existing = get_posts([
        'post_type' => 'wpcf7_contact_form',
        'title' => $service['title'],
        'posts_per_page' => 1
    ]);

    if (!empty($existing)) {
        echo "✓ Formulaire '{$service['title']}' existe déjà (ID: {$existing[0]->ID})\n";
        $created_forms[$service['slug']] = $existing[0]->ID;
        continue;
    }

    // Créer le formulaire
    $post_id = wp_insert_post([
        'post_type' => 'wpcf7_contact_form',
        'post_title' => $service['title'],
        'post_status' => 'publish',
        'post_content' => ''
    ]);

    if (is_wp_error($post_id)) {
        echo "✗ Erreur lors de la création du formulaire '{$service['title']}': " . $post_id->get_error_message() . "\n";
        continue;
    }

    // Ajouter le contenu du formulaire
    update_post_meta($post_id, '_form', $form_template);

    // Configuration de l'email à l'admin
    $mail_template = 'Subject: Nouvelle demande de devis: ' . $service['name'] . "\n\n";
    $mail_template .= "From: [vorname] [nachname] <[email]>\n";
    $mail_template .= "Reply-To: [email]\n\n";
    $mail_template .= "Nouvelle demande de devis pour: " . $service['name'] . "\n\n";
    $mail_template .= "Kontaktdaten:\n";
    $mail_template .= "Name: [vorname] [nachname]\n";
    $mail_template .= "E-Mail: [email]\n";
    $mail_template .= "Telefon: [telefon]\n\n";
    $mail_template .= "Projektstandort:\n";
    $mail_template .= "Adresse: [adresse]\n";
    $mail_template .= "PLZ: [plz]\n";
    $mail_template .= "Ort: [ort]\n\n";
    $mail_template .= "Projektbeschreibung:\n";
    $mail_template .= "[projektbeschreibung]\n\n";
    $mail_template .= "Zeitrahmen: [zeitrahmen]\n\n";
    $mail_template .= "-- \n";
    $mail_template .= "Gesendet über " . get_bloginfo('name');

    update_post_meta($post_id, '_mail', [
        'subject' => 'Neue Angebotsanfrage: ' . $service['name'] . ' - [vorname] [nachname]',
        'sender' => get_bloginfo('name') . ' <wordpress@' . str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST)) . '>',
        'body' => $mail_template,
        'recipient' => get_option('admin_email'),
        'additional_headers' => 'Reply-To: [email]',
        'attachments' => '',
        'use_html' => 0,
        'exclude_blank' => 0
    ]);

    // Configuration de l'email de confirmation au client
    $mail2_template = "Sehr geehrte/r [vorname] [nachname],\n\n";
    $mail2_template .= "vielen Dank für Ihre Anfrage zu unserem Service \"" . $service['name'] . "\".\n\n";
    $mail2_template .= "Wir haben Ihre Anfrage erhalten und werden uns innerhalb von 24 Stunden bei Ihnen melden.\n\n";
    $mail2_template .= "Ihre Angaben:\n";
    $mail2_template .= "Service: " . $service['name'] . "\n";
    $mail2_template .= "Projektstandort: [adresse], [plz] [ort]\n";
    $mail2_template .= "Zeitrahmen: [zeitrahmen]\n\n";
    $mail2_template .= "Mit freundlichen Grüßen\n";
    $mail2_template .= "Ihr " . get_bloginfo('name') . " Team\n\n";
    $mail2_template .= "---\n";
    $mail2_template .= get_bloginfo('name') . "\n";
    $mail2_template .= home_url();

    update_post_meta($post_id, '_mail_2', [
        'active' => 1,
        'subject' => 'Ihre Anfrage bei ' . get_bloginfo('name') . ' - ' . $service['name'],
        'sender' => get_bloginfo('name') . ' <noreply@' . str_replace('www.', '', parse_url(home_url(), PHP_URL_HOST)) . '>',
        'body' => $mail2_template,
        'recipient' => '[email]',
        'additional_headers' => '',
        'attachments' => '',
        'use_html' => 0,
        'exclude_blank' => 0
    ]);

    // Messages de succès/erreur
    update_post_meta($post_id, '_messages', [
        'mail_sent_ok' => 'Vielen Dank für Ihre Anfrage! Wir melden uns innerhalb von 24 Stunden bei Ihnen.',
        'mail_sent_ng' => 'Es gab ein Problem beim Versenden Ihrer Nachricht. Bitte versuchen Sie es erneut oder kontaktieren Sie uns telefonisch.',
        'validation_error' => 'Ein oder mehrere Felder enthalten fehlerhafte Eingaben. Bitte überprüfen Sie Ihre Angaben.',
        'spam' => 'Es gab ein Problem beim Versenden Ihrer Nachricht. Bitte versuchen Sie es erneut.',
        'accept_terms' => 'Bitte akzeptieren Sie die Datenschutzerklärung.',
        'invalid_required' => 'Dieses Feld ist erforderlich.',
        'invalid_too_long' => 'Die Eingabe ist zu lang.',
        'invalid_too_short' => 'Die Eingabe ist zu kurz.',
        'invalid_email' => 'Die E-Mail-Adresse ist ungültig.',
        'invalid_tel' => 'Die Telefonnummer ist ungültig.'
    ]);

    // Paramètres additionnels
    update_post_meta($post_id, '_additional_settings', '');

    $created_forms[$service['slug']] = $post_id;
    echo "✓ Formulaire '{$service['title']}' créé avec succès (ID: {$post_id})\n";
}

echo "\n=== Résumé ===\n";
echo "Formulaires Contact Form 7 créés:\n\n";
foreach ($created_forms as $slug => $form_id) {
    echo "Service: {$slug}\n";
    echo "Form ID: {$form_id}\n";
    echo "Shortcode: [contact-form-7 id=\"{$form_id}\"]\n\n";
}

echo "\nProchaine étape: Mettre à jour les pages templates pour utiliser ces shortcodes.\n";
