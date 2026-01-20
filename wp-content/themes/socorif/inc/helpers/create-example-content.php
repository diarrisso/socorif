<?php
/**
 * Creation d'exemples de contenu pour les CPT
 *
 * Ce fichier peut etre execute via WP-CLI ou en ajoutant temporairement
 * l'appel de la fonction dans functions.php
 *
 * Usage WP-CLI: wp eval "require get_template_directory() . '/inc/helpers/create-example-content.php'; socorif_create_all_examples();"
 *
 * IMPORTANT: Supprimer ou desactiver apres utilisation
 */

if (!defined('ABSPATH')) exit;

// Prevent redeclaration
if (function_exists('socorif_create_all_examples')) {
    return;
}

/**
 * Creer tous les exemples de contenu
 */
function socorif_create_all_examples(): void {
    // Verifier si deja execute
    if (get_option('socorif_examples_created')) {
        echo "Les exemples ont deja ete crees. Supprimez l'option 'socorif_examples_created' pour recreer.\n";
        return;
    }

    echo "Creation des exemples de contenu pour Socorif (Guinee)...\n\n";

    socorif_create_main_pages();
    socorif_create_service_examples();
    socorif_create_cf7_forms_for_services();
    socorif_create_project_examples();
    socorif_create_property_examples();
    socorif_create_emplois_examples();
    socorif_create_default_menu_items();

    update_option('socorif_examples_created', true);

    echo "\n--- Tous les exemples ont ete crees avec succes! ---\n";
}

/**
 * Creer les pages principales du site
 */
function socorif_create_main_pages(): void {
    echo "--- Creation des Pages Principales ---\n";

    $pages = [
        [
            'title' => 'Accueil',
            'slug' => 'accueil',
            'template' => '',
            'content' => '',
            'is_front' => true,
        ],
        [
            'title' => 'A propos',
            'slug' => 'a-propos',
            'template' => 'page-a-propos.php',
            'content' => '<p>SOCORIF est une entreprise guineenne specialisee dans l\'immobilier et les services fonciers. Depuis notre creation, nous accompagnons particuliers et professionnels dans tous leurs projets immobiliers.</p>',
        ],
        [
            'title' => 'Services',
            'slug' => 'services',
            'template' => 'page-services.php',
            'content' => '<p>Decouvrez notre gamme complete de services immobiliers et fonciers adaptes a vos besoins.</p>',
        ],
        [
            'title' => 'Proprietes',
            'slug' => 'proprietes',
            'template' => 'page-proprietes.php',
            'content' => '<p>Parcourez notre catalogue de biens immobiliers disponibles a la vente et a la location.</p>',
        ],
        [
            'title' => 'Opportunites Foncieres',
            'slug' => 'opportunites-foncieres',
            'template' => 'page-opportunites-foncieres.php',
            'content' => '<p>Decouvrez nos terrains disponibles pour vos projets de construction ou d\'investissement.</p>',
        ],
        [
            'title' => 'Projets',
            'slug' => 'projets',
            'template' => 'page-projets.php',
            'content' => '<p>Explorez nos realisations et projets en cours.</p>',
        ],
        [
            'title' => 'Actualites',
            'slug' => 'actualites',
            'template' => 'page-actualites.php',
            'content' => '<p>Suivez les dernieres nouvelles et tendances du marche immobilier guineen.</p>',
        ],
        [
            'title' => 'Contact',
            'slug' => 'contact',
            'template' => 'page-contact.php',
            'content' => '<p>Contactez-nous pour toute question ou demande de renseignement.</p>',
        ],
        [
            'title' => 'Carrieres',
            'slug' => 'carrieres',
            'template' => 'page-carrieres.php',
            'content' => '<p>Rejoignez notre equipe et participez au developpement immobilier de la Guinee.</p>',
        ],
        [
            'title' => 'Demande de devis',
            'slug' => 'devis',
            'template' => 'page-devis.php',
            'content' => '<p>Remplissez notre formulaire pour obtenir un devis personnalise.</p>',
        ],
        [
            'title' => 'Merci',
            'slug' => 'merci',
            'template' => 'page-merci.php',
            'content' => '<p>Merci pour votre message. Nous vous repondrons dans les plus brefs delais.</p>',
        ],
        [
            'title' => 'Mentions legales',
            'slug' => 'mentions-legales',
            'template' => 'page-mentions-legales.php',
            'content' => '',
        ],
        [
            'title' => 'Politique de confidentialite',
            'slug' => 'politique-confidentialite',
            'template' => 'page-politique-confidentialite.php',
            'content' => '',
        ],
        [
            'title' => 'Conditions generales',
            'slug' => 'conditions-generales',
            'template' => 'page-conditions-generales.php',
            'content' => '',
        ],
    ];

    foreach ($pages as $page_data) {
        // Verifier si la page existe deja
        $existing = get_page_by_path($page_data['slug']);
        if ($existing) {
            echo "  - Page '{$page_data['title']}' existe deja (ID: {$existing->ID})\n";

            // Mettre la page d'accueil comme page d'accueil du site
            if (!empty($page_data['is_front'])) {
                update_option('page_on_front', $existing->ID);
                update_option('show_on_front', 'page');
            }
            continue;
        }

        // Creer la page
        $post_id = wp_insert_post([
            'post_title' => $page_data['title'],
            'post_name' => $page_data['slug'],
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_content' => $page_data['content'],
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Assigner le template si specifie
            if (!empty($page_data['template'])) {
                update_post_meta($post_id, '_wp_page_template', $page_data['template']);
            }

            // Definir comme page d'accueil
            if (!empty($page_data['is_front'])) {
                update_option('page_on_front', $post_id);
                update_option('show_on_front', 'page');
            }

            echo "  + Page '{$page_data['title']}' creee (ID: {$post_id})\n";
        }
    }

    echo "\n";
}

/**
 * Creer le menu principal avec mega-menu
 */
function socorif_create_default_menu_items(): void {
    echo "--- Creation du Menu Principal ---\n";

    $menu_name = 'Menu Principal Socorif';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ($menu_exists) {
        echo "  - Menu '{$menu_name}' existe deja.\n\n";
        return;
    }

    // Creer le menu
    $menu_id = wp_create_nav_menu($menu_name);

    if (is_wp_error($menu_id)) {
        echo "  ! Erreur lors de la creation du menu.\n\n";
        return;
    }

    // Recuperer les pages
    $accueil = get_page_by_path('accueil');
    $apropos = get_page_by_path('a-propos');
    $services = get_page_by_path('services');
    $proprietes = get_page_by_path('proprietes');
    $opportunites = get_page_by_path('opportunites-foncieres');
    $projets = get_page_by_path('projets');
    $actualites = get_page_by_path('actualites');
    $contact = get_page_by_path('contact');

    // 1. Accueil
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => 'Accueil',
        'menu-item-url' => home_url('/'),
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
        'menu-item-position' => 1,
    ]);
    echo "  + Accueil ajoute\n";

    // 2. A propos
    if ($apropos) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'A propos',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $apropos->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-position' => 2,
        ]);
        echo "  + A propos ajoute\n";
    }

    // 3. Services
    if ($services) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Services',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $services->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-position' => 3,
        ]);
        echo "  + Services ajoute\n";
    }

    // 4. Biens Immobiliers (Parent avec mega-menu)
    $biens_id = wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => 'Biens Immobiliers',
        'menu-item-url' => '#',
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
        'menu-item-classes' => 'mega-menu',
        'menu-item-position' => 4,
    ]);
    echo "  + Biens Immobiliers ajoute (mega-menu)\n";

    // 4.1 Proprietes (sous-item)
    if ($proprietes && $biens_id) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Proprietes',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $proprietes->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-parent-id' => $biens_id,
            'menu-item-description' => 'Maisons, villas et appartements',
        ]);
        echo "    -> Proprietes (sous-menu)\n";
    }

    // 4.2 Opportunites Foncieres (sous-item)
    if ($opportunites && $biens_id) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Opportunites Foncieres',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $opportunites->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-parent-id' => $biens_id,
            'menu-item-description' => 'Terrains et lotissements',
        ]);
        echo "    -> Opportunites Foncieres (sous-menu)\n";
    }

    // 4.3 Projets (sous-item)
    if ($projets && $biens_id) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Projets',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $projets->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-parent-id' => $biens_id,
            'menu-item-description' => 'Nos realisations',
        ]);
        echo "    -> Projets (sous-menu)\n";
    }

    // 5. Actualites
    if ($actualites) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Actualites',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $actualites->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-position' => 5,
        ]);
        echo "  + Actualites ajoute\n";
    }

    // 6. Contact
    if ($contact) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Contact',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $contact->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-position' => 6,
        ]);
        echo "  + Contact ajoute\n";
    }

    // Assigner le menu a l'emplacement primary
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    echo "  = Menu assigne a l'emplacement 'primary'\n\n";
}

/**
 * Creer les formulaires Contact Form 7 personnalises pour chaque service
 */
function socorif_create_cf7_forms_for_services(): void {
    echo "--- Creation des Formulaires CF7 ---\n";

    // Verifier si Contact Form 7 est actif
    if (!class_exists('WPCF7_ContactForm')) {
        echo "  ! Contact Form 7 n'est pas installe ou active. Formulaires ignores.\n\n";
        return;
    }

    // Definir les formulaires pour chaque service
    $service_forms = [
        'gestion-promotion-immobiliere' => [
            'title' => 'Demande Gestion Immobiliere',
            'form' => socorif_get_cf7_form_gestion(),
            'mail' => socorif_get_cf7_mail_template('Gestion Immobiliere'),
        ],
        'amenagement-domaines' => [
            'title' => 'Demande Amenagement Domaine',
            'form' => socorif_get_cf7_form_amenagement(),
            'mail' => socorif_get_cf7_mail_template('Amenagement de Domaine'),
        ],
        'levee-topographique' => [
            'title' => 'Demande Levee Topographique',
            'form' => socorif_get_cf7_form_topographie(),
            'mail' => socorif_get_cf7_mail_template('Levee Topographique'),
        ],
        'dressage-plans' => [
            'title' => 'Demande Dressage de Plans',
            'form' => socorif_get_cf7_form_plans(),
            'mail' => socorif_get_cf7_mail_template('Dressage de Plans'),
        ],
        'vente-terrains' => [
            'title' => 'Demande Information Terrain',
            'form' => socorif_get_cf7_form_terrain(),
            'mail' => socorif_get_cf7_mail_template('Vente de Terrains'),
        ],
        'vente-achat-maisons' => [
            'title' => 'Demande Vente/Achat Maison',
            'form' => socorif_get_cf7_form_maison(),
            'mail' => socorif_get_cf7_mail_template('Vente/Achat de Maisons'),
        ],
    ];

    foreach ($service_forms as $service_slug => $form_data) {
        // Verifier si le formulaire existe deja
        $existing = get_page_by_title($form_data['title'], OBJECT, 'wpcf7_contact_form');
        if ($existing) {
            echo "  - Formulaire '{$form_data['title']}' existe deja.\n";
            $form_id = $existing->ID;
        } else {
            // Creer le formulaire CF7
            $form_id = socorif_create_cf7_form($form_data);
            if ($form_id) {
                echo "  + Formulaire '{$form_data['title']}' cree (ID: {$form_id})\n";
            }
        }

        // Associer le formulaire au service
        if ($form_id) {
            $service = get_page_by_path($service_slug, OBJECT, 'leistungen');
            if ($service && function_exists('update_field')) {
                update_field('contact_form', $form_id, $service->ID);
                echo "    -> Associe au service '{$service->post_title}'\n";
            }
        }
    }

    echo "\n";
}

/**
 * Creer un formulaire Contact Form 7
 */
function socorif_create_cf7_form(array $form_data): ?int {
    if (!class_exists('WPCF7_ContactForm')) {
        return null;
    }

    $contact_form = WPCF7_ContactForm::get_template();
    $contact_form->set_title($form_data['title']);
    $contact_form->set_locale('fr_FR');

    // Definir le contenu du formulaire
    $properties = [
        'form' => $form_data['form'],
        'mail' => [
            'subject' => '[Socorif] ' . $form_data['title'] . ' - [your-name]',
            'sender' => '[your-name] <[your-email]>',
            'recipient' => get_option('admin_email'),
            'body' => $form_data['mail'],
            'additional_headers' => "Reply-To: [your-email]",
            'attachments' => '',
            'use_html' => false,
            'exclude_blank' => false,
        ],
        'mail_2' => [
            'active' => true,
            'subject' => 'Confirmation de votre demande - Socorif',
            'sender' => 'Socorif <' . get_option('admin_email') . '>',
            'recipient' => '[your-email]',
            'body' => socorif_get_cf7_confirmation_mail($form_data['title']),
            'additional_headers' => '',
            'attachments' => '',
            'use_html' => false,
            'exclude_blank' => false,
        ],
        'messages' => [
            'mail_sent_ok' => 'Merci pour votre demande. Nous vous contacterons dans les plus brefs delais.',
            'mail_sent_ng' => 'Une erreur est survenue. Veuillez reessayer ou nous contacter directement.',
            'validation_error' => 'Veuillez verifier les champs en rouge.',
            'spam' => 'Une erreur de securite a ete detectee.',
            'accept_terms' => 'Veuillez accepter les conditions.',
            'invalid_required' => 'Ce champ est obligatoire.',
            'invalid_email' => 'Veuillez entrer une adresse email valide.',
            'invalid_tel' => 'Veuillez entrer un numero de telephone valide.',
        ],
    ];

    $contact_form->set_properties($properties);
    $contact_form->save();

    return $contact_form->id();
}

/**
 * Template de formulaire pour Gestion Immobiliere
 */
function socorif_get_cf7_form_gestion(): string {
    return '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom complet *</label>
        [text* your-name class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "Votre nom"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telephone *</label>
        [tel* your-phone class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "+224 XXX XX XX XX"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
    [email* your-email class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "votre@email.com"]
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de bien *</label>
        [select* type-bien class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Maison" "Villa" "Appartement" "Immeuble" "Terrain" "Local commercial"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de service *</label>
        [select* type-service class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Mise en location" "Gestion locative" "Promotion immobiliere" "Conseil en investissement"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localisation du bien</label>
    [text localisation class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary placeholder "Quartier, Ville"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description de votre projet *</label>
    [textarea* your-message class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:h-32 placeholder "Decrivez votre bien et vos attentes..."]
</div>

<div class="mt-8">
    [submit class:w-full class:bg-primary class:text-white class:py-4 class:px-6 class:rounded-lg class:font-semibold class:hover:bg-primary/90 class:transition-colors "Envoyer ma demande"]
</div>';
}

/**
 * Template de formulaire pour Amenagement de Domaines
 */
function socorif_get_cf7_form_amenagement(): string {
    return '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom complet *</label>
        [text* your-name class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "Votre nom"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telephone *</label>
        [tel* your-phone class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "+224 XXX XX XX XX"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
    [email* your-email class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "votre@email.com"]
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Surface du terrain (m²) *</label>
        [number* surface min:100 class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary placeholder "Ex: 5000"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localisation *</label>
        [text* localisation class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary placeholder "Ville, Region"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type d\'amenagement souhaite *</label>
    [checkbox* type-amenagement class:space-y-2 "Lotissement residentiel" "Lotissement commercial" "Zone industrielle" "Voiries et reseaux" "Espaces verts" "Autre"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Avez-vous un titre foncier ?</label>
    [radio titre-foncier default:1 "Oui" "Non" "En cours d\'obtention"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description du projet *</label>
    [textarea* your-message class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:h-32 placeholder "Decrivez votre projet d\'amenagement..."]
</div>

<div class="mt-8">
    [submit class:w-full class:bg-primary class:text-white class:py-4 class:px-6 class:rounded-lg class:font-semibold class:hover:bg-primary/90 class:transition-colors "Demander un devis"]
</div>';
}

/**
 * Template de formulaire pour Levee Topographique
 */
function socorif_get_cf7_form_topographie(): string {
    return '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom complet *</label>
        [text* your-name class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "Votre nom"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telephone *</label>
        [tel* your-phone class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "+224 XXX XX XX XX"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
    [email* your-email class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "votre@email.com"]
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de releve *</label>
        [select* type-releve class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Releve topographique complet" "Bornage de terrain" "Implantation de batiment" "Nivellement" "Plan de masse" "Autre"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Surface approximative (m²) *</label>
        [number* surface min:50 class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary placeholder "Ex: 1000"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Adresse / Localisation du terrain *</label>
    [text* localisation class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary placeholder "Quartier, Commune, Ville"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Objectif de la levee *</label>
    [select* objectif class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Construction de maison" "Construction d\'immeuble" "Lotissement" "Regularisation fonciere" "Vente de terrain" "Autre projet"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Urgence</label>
    [radio urgence default:1 "Standard (7-10 jours)" "Urgent (3-5 jours)" "Tres urgent (24-48h)"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Informations complementaires</label>
    [textarea your-message class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:h-32 placeholder "Precisions sur votre terrain ou votre projet..."]
</div>

<div class="mt-8">
    [submit class:w-full class:bg-primary class:text-white class:py-4 class:px-6 class:rounded-lg class:font-semibold class:hover:bg-primary/90 class:transition-colors "Demander un devis"]
</div>';
}

/**
 * Template de formulaire pour Dressage de Plans
 */
function socorif_get_cf7_form_plans(): string {
    return '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom complet *</label>
        [text* your-name class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "Votre nom"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telephone *</label>
        [tel* your-phone class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "+224 XXX XX XX XX"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
    [email* your-email class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "votre@email.com"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de plan souhaite *</label>
    [checkbox* type-plan class:space-y-2 "Plan cadastral" "Plan de masse" "Plan de situation" "Plan de lotissement" "Plan d\'architecte" "Plan d\'implantation"]
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Surface du terrain (m²)</label>
        [number surface min:50 class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary placeholder "Ex: 500"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Echelle souhaitee</label>
        [select echelle class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "1/100" "1/200" "1/500" "1/1000" "A definir ensemble"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localisation *</label>
    [text* localisation class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary placeholder "Adresse complete du terrain"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Usage prevu</label>
    [select usage class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Demande de permis de construire" "Regularisation fonciere" "Vente/Achat" "Partage successoral" "Autre"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Informations complementaires</label>
    [textarea your-message class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:h-32 placeholder "Details sur votre projet..."]
</div>

<div class="mt-8">
    [submit class:w-full class:bg-primary class:text-white class:py-4 class:px-6 class:rounded-lg class:font-semibold class:hover:bg-primary/90 class:transition-colors "Demander un devis"]
</div>';
}

/**
 * Template de formulaire pour Vente de Terrains
 */
function socorif_get_cf7_form_terrain(): string {
    return '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom complet *</label>
        [text* your-name class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "Votre nom"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telephone *</label>
        [tel* your-phone class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "+224 XXX XX XX XX"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
    [email* your-email class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "votre@email.com"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Je souhaite *</label>
    [radio* intention "Acheter un terrain" "Vendre mon terrain" "Obtenir des informations"]
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Zone souhaitee *</label>
        [select* zone class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Conakry - Ratoma" "Conakry - Matoto" "Conakry - Dixinn" "Conakry - Kaloum" "Conakry - Matam" "Dubreka" "Coyah" "Kindia" "Autre region"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Surface recherchee</label>
        [select surface class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Moins de 500 m²" "500 - 1000 m²" "1000 - 2000 m²" "2000 - 5000 m²" "Plus de 5000 m²"]
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Budget (GNF)</label>
        [select budget class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Moins de 50 millions" "50 - 100 millions" "100 - 200 millions" "200 - 500 millions" "Plus de 500 millions"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Usage prevu</label>
        [select usage class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Construction de maison" "Investissement" "Projet commercial" "Lotissement" "Autre"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Criteres importants</label>
    [checkbox criteres class:space-y-2 "Titre foncier obligatoire" "Viabilise (eau/electricite)" "Proche route goudronnee" "Quartier securise" "Zone calme"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Precisions sur votre recherche</label>
    [textarea your-message class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:h-32 placeholder "Decrivez vos criteres en detail..."]
</div>

<div class="mt-8">
    [submit class:w-full class:bg-primary class:text-white class:py-4 class:px-6 class:rounded-lg class:font-semibold class:hover:bg-primary/90 class:transition-colors "Envoyer ma demande"]
</div>';
}

/**
 * Template de formulaire pour Vente/Achat de Maisons
 */
function socorif_get_cf7_form_maison(): string {
    return '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom complet *</label>
        [text* your-name class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "Votre nom"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telephone *</label>
        [tel* your-phone class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "+224 XXX XX XX XX"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
    [email* your-email class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:focus:border-primary placeholder "votre@email.com"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Je souhaite *</label>
    [radio* intention "Acheter une maison" "Vendre ma maison" "Estimer ma maison" "Obtenir des informations"]
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de bien *</label>
        [select* type-bien class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Maison" "Villa" "Appartement" "Immeuble" "Duplex"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nombre de chambres</label>
        [select chambres class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "1 chambre" "2 chambres" "3 chambres" "4 chambres" "5 chambres et plus"]
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Zone souhaitee *</label>
        [select* zone class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Conakry - Ratoma" "Conakry - Matoto" "Conakry - Dixinn" "Conakry - Kaloum" "Conakry - Matam" "Dubreka" "Coyah" "Kindia" "Autre region"]
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Budget (GNF)</label>
        [select budget class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary "Moins de 200 millions" "200 - 500 millions" "500 - 800 millions" "800 millions - 1 milliard" "Plus de 1 milliard"]
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Equipements souhaites</label>
    [checkbox equipements class:space-y-2 "Piscine" "Jardin" "Garage" "Groupe electrogene" "Forage" "Climatisation" "Gardiennage"]
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Precisions sur votre projet</label>
    [textarea your-message class:w-full class:px-4 class:py-3 class:border class:border-gray-300 class:rounded-lg class:focus:ring-2 class:focus:ring-primary class:h-32 placeholder "Decrivez votre projet en detail..."]
</div>

<div class="mt-8">
    [submit class:w-full class:bg-primary class:text-white class:py-4 class:px-6 class:rounded-lg class:font-semibold class:hover:bg-primary/90 class:transition-colors "Envoyer ma demande"]
</div>';
}

/**
 * Template email pour l'admin
 */
function socorif_get_cf7_mail_template(string $service_name): string {
    return "Nouvelle demande pour: {$service_name}

---
INFORMATIONS DU CONTACT
---
Nom: [your-name]
Email: [your-email]
Telephone: [your-phone]

---
DETAILS DE LA DEMANDE
---
[your-message]

---
INFORMATIONS SUPPLEMENTAIRES
---
" . implode("\n", array_map(function($field) {
        return ucfirst(str_replace('-', ' ', $field)) . ": [{$field}]";
    }, ['type-bien', 'type-service', 'type-releve', 'type-plan', 'type-amenagement', 'surface', 'localisation', 'zone', 'budget', 'intention', 'urgence', 'objectif', 'usage', 'echelle', 'chambres', 'criteres', 'equipements', 'titre-foncier'])) . "

---
Formulaire soumis depuis: [_url]
Date: [_date] [_time]
---";
}

/**
 * Template email de confirmation pour le client
 */
function socorif_get_cf7_confirmation_mail(string $form_title): string {
    return "Bonjour [your-name],

Nous avons bien recu votre demande concernant: {$form_title}

Notre equipe traitera votre demande dans les plus brefs delais. Un conseiller vous contactera prochainement au numero [your-phone] ou par email a l'adresse [your-email].

Recapitulatif de votre demande:
[your-message]

Pour toute question urgente, vous pouvez nous joindre:
- Telephone: +224 XXX XX XX XX
- Email: contact@socorif.gn
- Adresse: Conakry, Guinee

Cordialement,
L'equipe Socorif

---
Ce message est une confirmation automatique. Merci de ne pas y repondre directement.";
}

/**
 * Creer les exemples de Services (Leistungen)
 */
function socorif_create_service_examples(): void {
    echo "--- Creation des Services ---\n";

    $services = [
        [
            'title' => 'Gestion et Promotion Immobiliere',
            'slug' => 'gestion-promotion-immobiliere',
            'excerpt' => 'Service complet de gestion et promotion de vos biens immobiliers en Guinee. Nous assurons la valorisation optimale de votre patrimoine.',
            'category' => 'Gestion Immobiliere',
            'icon' => 'dashicons-building',
            'description' => 'Notre expertise en gestion immobiliere vous garantit une rentabilite optimale de vos investissements. De la recherche de locataires a la maintenance des biens, nous gerons tout pour vous.',
        ],
        [
            'title' => 'Amenagement des Domaines',
            'slug' => 'amenagement-domaines',
            'excerpt' => 'Transformation de terrains bruts en espaces valorises et viabilises. Lotissements, voiries et reseaux divers adaptes aux normes guineennes.',
            'category' => 'Amenagement',
            'icon' => 'dashicons-location',
            'description' => 'Nous transformons vos terrains en domaines viabilises prets a construire. Notre equipe assure la conception et la realisation des infrastructures necessaires.',
        ],
        [
            'title' => 'Levee Topographique',
            'slug' => 'levee-topographique',
            'excerpt' => 'Releves topographiques precis pour vos projets de construction ou d\'amenagement. Equipements modernes et geometres qualifies.',
            'category' => 'Topographie',
            'icon' => 'dashicons-location-alt',
            'description' => 'Nos geometres utilisent des equipements de pointe pour realiser des releves topographiques precis. Indispensable avant tout projet de construction ou d\'amenagement.',
        ],
        [
            'title' => 'Dressage de Plans',
            'slug' => 'dressage-plans',
            'excerpt' => 'Elaboration de plans cadastraux, plans de masse et plans architecturaux conformes aux exigences administratives guineennes.',
            'category' => 'Topographie',
            'icon' => 'dashicons-media-document',
            'description' => 'Du plan cadastral au plan de masse, nous elaborons tous les documents techniques necessaires pour vos demarches administratives et vos projets de construction.',
        ],
        [
            'title' => 'Vente de Terrains',
            'slug' => 'vente-terrains',
            'excerpt' => 'Large selection de terrains a batir a Conakry et en regions. Terrains titres avec accompagnement juridique complet.',
            'category' => 'Transaction',
            'icon' => 'dashicons-admin-multisite',
            'description' => 'Decouvrez notre catalogue de terrains disponibles a la vente. Tous nos terrains sont titres et nous vous accompagnons dans toutes les demarches administratives.',
        ],
        [
            'title' => 'Vente et Achat de Maisons',
            'slug' => 'vente-achat-maisons',
            'excerpt' => 'Accompagnement personnalise pour l\'achat ou la vente de votre maison en Guinee. Estimation gratuite et conseil juridique.',
            'category' => 'Transaction',
            'icon' => 'dashicons-admin-home',
            'description' => 'Que vous souhaitiez acheter ou vendre, notre equipe vous accompagne a chaque etape. Estimation gratuite, conseil juridique et negociation professionnelle.',
        ],
    ];

    foreach ($services as $service) {
        // Verifier si le service existe deja
        $existing = get_page_by_path($service['slug'], OBJECT, 'leistungen');
        if ($existing) {
            echo "  - Service '{$service['title']}' existe deja, ignore.\n";
            continue;
        }

        // Creer le service
        $post_id = wp_insert_post([
            'post_title' => $service['title'],
            'post_name' => $service['slug'],
            'post_type' => 'leistungen',
            'post_status' => 'publish',
            'post_excerpt' => $service['excerpt'],
            'post_content' => $service['description'],
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Assigner la categorie
            $term = get_term_by('name', $service['category'], 'leistung_kategorie');
            if ($term) {
                wp_set_object_terms($post_id, $term->term_id, 'leistung_kategorie');
            }

            // Mettre a jour les champs ACF
            if (function_exists('update_field')) {
                update_field('leistung_icon', $service['icon'], $post_id);
                update_field('short_description', $service['excerpt'], $post_id);
            }

            echo "  + Service '{$service['title']}' cree (ID: {$post_id})\n";
        }
    }

    echo "\n";
}

/**
 * Creer les exemples de Projets (Projekte)
 */
function socorif_create_project_examples(): void {
    echo "--- Creation des Projets ---\n";

    $projects = [
        [
            'title' => 'Lotissement Residence Koloma',
            'slug' => 'lotissement-residence-koloma',
            'excerpt' => 'Amenagement d\'un lotissement de 50 parcelles viabilisees a Koloma, Ratoma.',
            'category' => 'Residentiel',
            'type' => 'Lotissement',
            'location' => 'Koloma, Ratoma - Conakry',
            'client' => 'Promoteur prive',
            'size' => '5 hectares - 50 parcelles',
            'duration' => '18 mois',
            'status' => 'termine',
            'date' => '2024-06-15',
            'description' => 'Realisation complete d\'un lotissement residentiel comprenant la viabilisation, les voiries et les reseaux divers.',
            'services' => ['plans', 'amenagement', 'lotissement'],
        ],
        [
            'title' => 'Villa Moderne Kipé',
            'slug' => 'villa-moderne-kipe',
            'excerpt' => 'Construction d\'une villa contemporaine de 400m² avec piscine a Kipé.',
            'category' => 'Residentiel',
            'type' => 'Construction neuve',
            'location' => 'Kipé, Ratoma - Conakry',
            'client' => 'M. Diallo',
            'size' => '400 m² habitables + 1200 m² terrain',
            'duration' => '14 mois',
            'status' => 'termine',
            'date' => '2024-03-20',
            'description' => 'Villa de standing avec 5 chambres, piscine, garage double et dependances. Architecture moderne adaptee au climat tropical.',
            'services' => ['plans', 'construction', 'amenagement'],
            'testimonial' => 'Socorif a realise notre villa avec un professionnalisme remarquable. Le respect des delais et la qualite des finitions ont depasse nos attentes.',
            'testimonial_author' => 'Mamadou Diallo',
            'testimonial_position' => 'Proprietaire',
        ],
        [
            'title' => 'Immeuble Commercial Kaloum',
            'slug' => 'immeuble-commercial-kaloum',
            'excerpt' => 'Construction d\'un immeuble de bureaux R+5 au coeur du quartier des affaires.',
            'category' => 'Commercial',
            'type' => 'Construction neuve',
            'location' => 'Kaloum - Conakry',
            'client' => 'Societe Alpha Invest',
            'size' => '2500 m² sur 6 niveaux',
            'duration' => '24 mois',
            'status' => 'termine',
            'date' => '2023-11-30',
            'description' => 'Immeuble de bureaux moderne avec parking souterrain, climatisation centrale et ascenseur. Certification aux normes internationales.',
            'services' => ['plans', 'construction', 'amenagement', 'promotion'],
        ],
        [
            'title' => 'Domaine Agricole Kindia',
            'slug' => 'domaine-agricole-kindia',
            'excerpt' => 'Amenagement d\'un domaine agricole de 100 hectares avec infrastructures.',
            'category' => 'Terrains',
            'type' => 'Amenagement',
            'location' => 'Kindia, Region de Kindia',
            'client' => 'Cooperative Agricole de Kindia',
            'size' => '100 hectares',
            'duration' => '12 mois',
            'status' => 'termine',
            'date' => '2024-01-15',
            'description' => 'Amenagement complet avec systeme d\'irrigation, pistes d\'acces et batiments techniques. Levee topographique prealable sur l\'ensemble du domaine.',
            'services' => ['topographie', 'amenagement', 'plans'],
        ],
        [
            'title' => 'Residence Les Palmiers',
            'slug' => 'residence-les-palmiers',
            'excerpt' => 'Ensemble residentiel de 20 villas standing a Nongo.',
            'category' => 'Residentiel',
            'type' => 'Lotissement',
            'location' => 'Nongo, Ratoma - Conakry',
            'client' => 'SCI Les Palmiers',
            'size' => '20 villas sur 3 hectares',
            'duration' => '30 mois',
            'status' => 'en_cours',
            'date' => '2025-12-01',
            'description' => 'Residence securisee avec espace vert central, voiries privees et equipements communs. Chaque villa dispose de 3 a 4 chambres.',
            'services' => ['plans', 'construction', 'lotissement', 'promotion'],
        ],
        [
            'title' => 'Centre Commercial Matoto',
            'slug' => 'centre-commercial-matoto',
            'excerpt' => 'Construction d\'un centre commercial de 5000m² avec parking.',
            'category' => 'Commercial',
            'type' => 'Construction neuve',
            'location' => 'Matoto - Conakry',
            'client' => 'Groupe Matoto Invest',
            'size' => '5000 m² + 150 places parking',
            'duration' => '20 mois',
            'status' => 'planifie',
            'date' => '2026-06-01',
            'description' => 'Centre commercial moderne avec supermarche, boutiques, food court et parking exterieur. Conception bioclimatique pour reduire la consommation energetique.',
            'services' => ['plans', 'construction', 'amenagement', 'promotion'],
        ],
        [
            'title' => 'Lotissement Industriel Kagbelen',
            'slug' => 'lotissement-industriel-kagbelen',
            'excerpt' => 'Zone industrielle viabilisee de 15 hectares avec acces route nationale.',
            'category' => 'Infrastructures',
            'type' => 'Amenagement',
            'location' => 'Kagbelen, Dubreka',
            'client' => 'Chambre de Commerce de Guinee',
            'size' => '15 hectares - 30 lots',
            'duration' => '16 mois',
            'status' => 'termine',
            'date' => '2023-08-20',
            'description' => 'Zone industrielle entierement viabilisee avec voiries lourdes, reseaux eau et electricite haute tension. Acces direct a la route nationale Conakry-Kindia.',
            'services' => ['topographie', 'amenagement', 'lotissement'],
        ],
        [
            'title' => 'Renovation Hotel Camayenne',
            'slug' => 'renovation-hotel-camayenne',
            'excerpt' => 'Renovation complete d\'un hotel 3 etoiles de 40 chambres.',
            'category' => 'Commercial',
            'type' => 'Renovation',
            'location' => 'Camayenne, Dixinn - Conakry',
            'client' => 'Groupe Hotelier Guineen',
            'size' => '40 chambres + espaces communs',
            'duration' => '10 mois',
            'status' => 'termine',
            'date' => '2024-04-10',
            'description' => 'Renovation complete incluant chambres, restaurant, piscine et facade. Mise aux normes electriques et installation de groupes electrogenes.',
            'services' => ['plans', 'renovation', 'amenagement'],
            'testimonial' => 'La renovation a ete realisee dans les temps malgre les contraintes de fonctionnement de l\'hotel. Resultat impeccable.',
            'testimonial_author' => 'Fatoumata Camara',
            'testimonial_position' => 'Directrice Generale',
        ],
    ];

    foreach ($projects as $project) {
        // Verifier si le projet existe deja
        $existing = get_page_by_path($project['slug'], OBJECT, 'projekte');
        if ($existing) {
            echo "  - Projet '{$project['title']}' existe deja, ignore.\n";
            continue;
        }

        // Creer le projet
        $post_id = wp_insert_post([
            'post_title' => $project['title'],
            'post_name' => $project['slug'],
            'post_type' => 'projekte',
            'post_status' => 'publish',
            'post_excerpt' => $project['excerpt'],
            'post_content' => $project['description'],
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Assigner la categorie
            $cat_term = get_term_by('name', $project['category'], 'projekt_kategorie');
            if ($cat_term) {
                wp_set_object_terms($post_id, $cat_term->term_id, 'projekt_kategorie');
            }

            // Assigner le type
            $type_term = get_term_by('name', $project['type'], 'projekt_typ');
            if ($type_term) {
                wp_set_object_terms($post_id, $type_term->term_id, 'projekt_typ');
            }

            // Mettre a jour les champs ACF
            if (function_exists('update_field')) {
                update_field('projekt_kunde', $project['client'], $post_id);
                update_field('projekt_standort', $project['location'], $post_id);
                update_field('projekt_groesse', $project['size'], $post_id);
                update_field('projekt_dauer', $project['duration'], $post_id);
                update_field('projekt_status', $project['status'], $post_id);
                update_field('projekt_fertigstellung', $project['date'], $post_id);
                update_field('projekt_beschreibung_kurz', $project['excerpt'], $post_id);
                update_field('projekt_leistungen', $project['services'], $post_id);

                if (!empty($project['testimonial'])) {
                    update_field('projekt_testimonial', $project['testimonial'], $post_id);
                    update_field('projekt_testimonial_autor', $project['testimonial_author'], $post_id);
                    update_field('projekt_testimonial_position', $project['testimonial_position'], $post_id);
                }
            }

            echo "  + Projet '{$project['title']}' cree (ID: {$post_id})\n";
        }
    }

    echo "\n";
}

/**
 * Creer les exemples de Proprietes (Property)
 */
function socorif_create_property_examples(): void {
    echo "--- Creation des Proprietes ---\n";

    $properties = [
        // Terrains
        [
            'title' => 'Terrain Viabilise Kipé',
            'slug' => 'terrain-viabilise-kipe',
            'excerpt' => 'Beau terrain de 800m² viabilise avec titre foncier dans un quartier residentiel calme.',
            'category' => 'Terrains',
            'type' => 'Vente',
            'property_type' => 'terrain',
            'transaction' => 'vente',
            'status' => 'disponible',
            'reference' => 'TER-001',
            'price' => 150000000,
            'land_surface' => 800,
            'city' => 'Conakry',
            'quarter' => 'Kipé, Ratoma',
            'address' => 'Kipé Centre, a 500m de la route principale',
            'features' => ['eau', 'electricite', 'cloture', 'titre_foncier'],
        ],
        [
            'title' => 'Terrain 1500m² Nongo',
            'slug' => 'terrain-1500m-nongo',
            'excerpt' => 'Grand terrain de 1500m² ideal pour projet immobilier ou villa de standing.',
            'category' => 'Terrains',
            'type' => 'Vente',
            'property_type' => 'terrain',
            'transaction' => 'vente',
            'status' => 'disponible',
            'reference' => 'TER-002',
            'price' => 280000000,
            'land_surface' => 1500,
            'city' => 'Conakry',
            'quarter' => 'Nongo, Ratoma',
            'address' => 'Nongo Taady, zone residentielle',
            'features' => ['eau', 'electricite', 'titre_foncier'],
        ],
        [
            'title' => 'Parcelle Constructible Kindia',
            'slug' => 'parcelle-constructible-kindia',
            'excerpt' => 'Terrain de 600m² avec vue sur la montagne, ideal pour residence secondaire.',
            'category' => 'Terrains',
            'type' => 'Vente',
            'property_type' => 'terrain',
            'transaction' => 'vente',
            'status' => 'disponible',
            'reference' => 'TER-003',
            'price' => 45000000,
            'land_surface' => 600,
            'city' => 'Kindia',
            'quarter' => 'Centre-ville',
            'address' => 'Quartier Diakonia, Kindia',
            'features' => ['eau', 'electricite', 'titre_foncier'],
        ],

        // Maisons
        [
            'title' => 'Villa Moderne 4 Chambres Kipé',
            'slug' => 'villa-moderne-4-chambres-kipe',
            'excerpt' => 'Superbe villa contemporaine de 4 chambres avec piscine et jardin paysager.',
            'category' => 'Maisons',
            'type' => 'Vente',
            'property_type' => 'villa',
            'transaction' => 'vente',
            'status' => 'disponible',
            'reference' => 'VIL-001',
            'price' => 850000000,
            'surface' => 350,
            'land_surface' => 1200,
            'rooms' => 6,
            'bedrooms' => 4,
            'bathrooms' => 4,
            'year_built' => 2022,
            'city' => 'Conakry',
            'quarter' => 'Kipé, Ratoma',
            'address' => 'Kipé Dadia, residence securisee',
            'features' => ['eau', 'electricite', 'cloture', 'titre_foncier', 'parking', 'garage', 'jardin', 'piscine', 'terrasse', 'climatisation', 'cuisine_equipee', 'gardiennage', 'groupe_electrogene', 'forage'],
        ],
        [
            'title' => 'Maison Familiale Matam',
            'slug' => 'maison-familiale-matam',
            'excerpt' => 'Maison familiale de 3 chambres avec dependance, quartier calme et securise.',
            'category' => 'Maisons',
            'type' => 'Vente',
            'property_type' => 'maison',
            'transaction' => 'vente',
            'status' => 'disponible',
            'reference' => 'MAI-001',
            'price' => 320000000,
            'surface' => 180,
            'land_surface' => 500,
            'rooms' => 5,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'year_built' => 2018,
            'city' => 'Conakry',
            'quarter' => 'Matam',
            'address' => 'Cimetiere, proche marche',
            'features' => ['eau', 'electricite', 'cloture', 'titre_foncier', 'parking', 'jardin', 'terrasse', 'cuisine_equipee'],
        ],
        [
            'title' => 'Villa Standing Camayenne',
            'slug' => 'villa-standing-camayenne',
            'excerpt' => 'Villa de haut standing avec vue mer, 5 chambres et piscine a debordement.',
            'category' => 'Maisons',
            'type' => 'Vente',
            'property_type' => 'villa',
            'transaction' => 'vente',
            'status' => 'reserve',
            'reference' => 'VIL-002',
            'price' => 1500000000,
            'surface' => 500,
            'land_surface' => 2000,
            'rooms' => 8,
            'bedrooms' => 5,
            'bathrooms' => 6,
            'year_built' => 2023,
            'city' => 'Conakry',
            'quarter' => 'Camayenne, Dixinn',
            'address' => 'Front de mer, Camayenne',
            'features' => ['eau', 'electricite', 'cloture', 'titre_foncier', 'parking', 'garage', 'jardin', 'piscine', 'terrasse', 'balcon', 'climatisation', 'cuisine_equipee', 'meuble', 'gardiennage', 'groupe_electrogene', 'forage'],
        ],

        // Appartements
        [
            'title' => 'Appartement 3 Pieces Kaloum',
            'slug' => 'appartement-3-pieces-kaloum',
            'excerpt' => 'Bel appartement renove au coeur de Kaloum, ideal pour professionnel.',
            'category' => 'Appartements',
            'type' => 'Location',
            'property_type' => 'appartement',
            'transaction' => 'location',
            'status' => 'disponible',
            'reference' => 'APT-001',
            'price' => 8000000,
            'surface' => 85,
            'rooms' => 3,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'year_built' => 2020,
            'city' => 'Conakry',
            'quarter' => 'Kaloum',
            'address' => 'Centre-ville, proche ministeres',
            'features' => ['eau', 'electricite', 'parking', 'climatisation', 'cuisine_equipee', 'gardiennage', 'groupe_electrogene'],
        ],
        [
            'title' => 'Appartement Meuble Kipé',
            'slug' => 'appartement-meuble-kipe',
            'excerpt' => 'Appartement moderne entierement meuble, 2 chambres avec balcon.',
            'category' => 'Appartements',
            'type' => 'Location',
            'property_type' => 'appartement',
            'transaction' => 'location',
            'status' => 'disponible',
            'reference' => 'APT-002',
            'price' => 12000000,
            'surface' => 120,
            'rooms' => 4,
            'bedrooms' => 2,
            'bathrooms' => 2,
            'year_built' => 2022,
            'city' => 'Conakry',
            'quarter' => 'Kipé, Ratoma',
            'address' => 'Kipé T6, residence Les Balcons',
            'features' => ['eau', 'electricite', 'parking', 'balcon', 'climatisation', 'cuisine_equipee', 'meuble', 'gardiennage', 'groupe_electrogene'],
        ],

        // Locaux commerciaux
        [
            'title' => 'Bureau 150m² Kaloum',
            'slug' => 'bureau-150m-kaloum',
            'excerpt' => 'Plateau de bureaux dans immeuble moderne avec ascenseur et parking.',
            'category' => 'Locaux commerciaux',
            'type' => 'Location',
            'property_type' => 'bureau',
            'transaction' => 'location',
            'status' => 'disponible',
            'reference' => 'BUR-001',
            'price' => 25000000,
            'surface' => 150,
            'rooms' => 5,
            'year_built' => 2021,
            'city' => 'Conakry',
            'quarter' => 'Kaloum',
            'address' => 'Avenue de la Republique, 3eme etage',
            'features' => ['eau', 'electricite', 'parking', 'climatisation', 'gardiennage', 'groupe_electrogene'],
        ],
        [
            'title' => 'Local Commercial Matoto',
            'slug' => 'local-commercial-matoto',
            'excerpt' => 'Local commercial de 200m² sur axe passant, ideal commerce ou showroom.',
            'category' => 'Locaux commerciaux',
            'type' => 'Vente',
            'property_type' => 'local_commercial',
            'transaction' => 'vente',
            'status' => 'disponible',
            'reference' => 'COM-001',
            'price' => 450000000,
            'surface' => 200,
            'year_built' => 2019,
            'city' => 'Conakry',
            'quarter' => 'Matoto',
            'address' => 'Route Le Prince, rez-de-chaussee',
            'features' => ['eau', 'electricite', 'titre_foncier', 'parking', 'climatisation'],
        ],
    ];

    foreach ($properties as $property) {
        // Verifier si la propriete existe deja
        $existing = get_page_by_path($property['slug'], OBJECT, 'property');
        if ($existing) {
            echo "  - Propriete '{$property['title']}' existe deja, ignore.\n";
            continue;
        }

        // Creer la propriete
        $post_id = wp_insert_post([
            'post_title' => $property['title'],
            'post_name' => $property['slug'],
            'post_type' => 'property',
            'post_status' => 'publish',
            'post_excerpt' => $property['excerpt'],
            'post_content' => '',
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Assigner la categorie
            $cat_term = get_term_by('name', $property['category'], 'property_category');
            if ($cat_term) {
                wp_set_object_terms($post_id, $cat_term->term_id, 'property_category');
            }

            // Assigner le type de transaction
            $type_term = get_term_by('name', $property['type'], 'property_type');
            if ($type_term) {
                wp_set_object_terms($post_id, $type_term->term_id, 'property_type');
            }

            // Mettre a jour les champs ACF
            if (function_exists('update_field')) {
                update_field('property_reference', $property['reference'], $post_id);
                update_field('property_type_field', $property['property_type'], $post_id);
                update_field('property_transaction', $property['transaction'], $post_id);
                update_field('property_status', $property['status'], $post_id);
                update_field('property_price', $property['price'], $post_id);
                update_field('property_city', $property['city'], $post_id);
                update_field('property_quarter', $property['quarter'], $post_id);
                update_field('property_address', $property['address'], $post_id);
                update_field('property_features', $property['features'], $post_id);

                if (!empty($property['surface'])) {
                    update_field('property_surface', $property['surface'], $post_id);
                }
                if (!empty($property['land_surface'])) {
                    update_field('property_land_surface', $property['land_surface'], $post_id);
                }
                if (!empty($property['rooms'])) {
                    update_field('property_rooms', $property['rooms'], $post_id);
                }
                if (!empty($property['bedrooms'])) {
                    update_field('property_bedrooms', $property['bedrooms'], $post_id);
                }
                if (!empty($property['bathrooms'])) {
                    update_field('property_bathrooms', $property['bathrooms'], $post_id);
                }
                if (!empty($property['year_built'])) {
                    update_field('property_year_built', $property['year_built'], $post_id);
                }
            }

            echo "  + Propriete '{$property['title']}' creee (ID: {$post_id})\n";
        }
    }

    echo "\n";
}

/**
 * Creer les exemples d'Offres d'emploi (Emplois)
 */
function socorif_create_emplois_examples(): void {
    echo "--- Creation des Offres d'emploi ---\n";

    $emplois = [
        [
            'title' => 'Geometre Topographe (H/F)',
            'slug' => 'geometre-topographe',
            'category' => 'Technique',
            'contract_type' => 'CDI',
            'start_date' => 'Des que possible',
            'tasks' => [
                'Realiser des leves topographiques sur le terrain',
                'Effectuer des bornages et implantations',
                'Dresser des plans cadastraux et de masse',
                'Utiliser les equipements GPS et station totale',
                'Rediger les rapports techniques',
                'Collaborer avec les equipes de projet',
            ],
            'profile' => [
                'Diplome en topographie ou geometre (BTS/DUT minimum)',
                'Experience de 3 ans minimum en topographie',
                'Maitrise des logiciels AutoCAD, Covadis ou similaires',
                'Permis de conduire B obligatoire',
                'Disponibilite pour deplacements frequents',
                'Rigueur et precision dans le travail',
            ],
            'perspectives' => '<ul>
<li>Salaire competitif selon experience</li>
<li>Vehicule de fonction</li>
<li>Formation continue</li>
<li>Possibilite d\'evolution vers un poste de chef d\'equipe</li>
<li>Environnement de travail dynamique</li>
</ul>',
            'postal_address' => "SOCORIF SARL\nService des Ressources Humaines\nKipe, Ratoma\nConakry, Guinee",
            'email' => 'recrutement@socorif.gn',
        ],
        [
            'title' => 'Commercial Immobilier (H/F)',
            'slug' => 'commercial-immobilier',
            'category' => 'Commercial',
            'contract_type' => 'CDI',
            'start_date' => 'A partir du 1er mars 2025',
            'tasks' => [
                'Prospecter de nouveaux clients (particuliers et professionnels)',
                'Presenter et vendre les biens immobiliers du portefeuille',
                'Organiser et conduire les visites de biens',
                'Negocier les conditions de vente ou de location',
                'Assurer le suivi client jusqu\'a la signature',
                'Developper et fideliser un portefeuille clients',
                'Participer aux salons et evenements immobiliers',
            ],
            'profile' => [
                'Formation commerciale (BAC+2 minimum)',
                'Experience reussie de 2 ans en vente immobiliere',
                'Excellent relationnel et sens de la negociation',
                'Maitrise du francais (ecrit et oral)',
                'Permis de conduire et vehicule personnel',
                'Connaissance du marche immobilier guineen appreciee',
                'Dynamisme et autonomie',
            ],
            'perspectives' => '<ul>
<li>Salaire fixe + commissions attractives</li>
<li>Telephone et forfait professionnel</li>
<li>Formation aux techniques de vente immobiliere</li>
<li>Portefeuille de biens premium a commercialiser</li>
<li>Perspectives d\'evolution vers un poste de responsable commercial</li>
</ul>',
            'postal_address' => "SOCORIF SARL\nService des Ressources Humaines\nKipe, Ratoma\nConakry, Guinee",
            'email' => 'recrutement@socorif.gn',
        ],
        [
            'title' => 'Assistant(e) Administratif(ve) (H/F)',
            'slug' => 'assistant-administratif',
            'category' => 'Administration',
            'contract_type' => 'CDD',
            'start_date' => 'Immediat',
            'tasks' => [
                'Accueillir les clients et visiteurs',
                'Gerer le standard telephonique et les courriers',
                'Assurer le suivi administratif des dossiers',
                'Rediger des documents administratifs et commerciaux',
                'Organiser les reunions et deplacements',
                'Gerer l\'archivage et le classement',
                'Assister la direction dans les taches quotidiennes',
            ],
            'profile' => [
                'Formation en secretariat ou gestion (BAC minimum)',
                'Experience de 1 an en poste similaire',
                'Maitrise du Pack Office (Word, Excel, PowerPoint)',
                'Excellente expression ecrite et orale en francais',
                'Sens de l\'organisation et discretion',
                'Capacite a gerer les priorites',
            ],
            'perspectives' => '<ul>
<li>CDD de 6 mois renouvelable, possibilite de CDI</li>
<li>Formation interne aux outils de l\'entreprise</li>
<li>Ambiance de travail agreable</li>
<li>Horaires: 8h-17h du lundi au vendredi</li>
</ul>',
            'postal_address' => "SOCORIF SARL\nService des Ressources Humaines\nKipe, Ratoma\nConakry, Guinee",
            'email' => 'recrutement@socorif.gn',
        ],
        [
            'title' => 'Stage - Assistant(e) Gestion Immobiliere',
            'slug' => 'stage-assistant-gestion-immobiliere',
            'category' => 'Stage',
            'contract_type' => 'Stage',
            'start_date' => 'A partir de septembre 2025',
            'ausbildung_title' => 'Contenu du stage :',
            'ausbildung_content' => '<p>Stage de 6 mois au sein du departement Gestion Immobiliere.</p>
<p><strong>Programme :</strong></p>
<ul>
<li>Mois 1-2 : Decouverte des processus de gestion locative</li>
<li>Mois 3-4 : Participation aux etats des lieux et visites</li>
<li>Mois 5-6 : Gestion autonome d\'un portefeuille de biens</li>
</ul>
<p>Un tuteur vous accompagnera tout au long du stage.</p>',
            'tasks' => [
                'Participer a la gestion locative des biens',
                'Assister aux etats des lieux entree/sortie',
                'Suivre les travaux de maintenance',
                'Gerer la relation avec les locataires',
                'Contribuer au reporting mensuel',
            ],
            'profile' => [
                'Etudiant(e) en gestion, immobilier ou commerce (BAC+3/4)',
                'Interet pour le secteur immobilier',
                'Bonne maitrise des outils bureautiques',
                'Sens du contact et du service client',
                'Dynamisme et esprit d\'initiative',
            ],
            'perspectives' => '<ul>
<li>Indemnite de stage selon convention</li>
<li>Prise en charge des frais de transport</li>
<li>Possibilite d\'embauche a l\'issue du stage</li>
<li>Acquisition d\'une experience concrete en gestion immobiliere</li>
</ul>',
            'postal_address' => "SOCORIF SARL\nService des Ressources Humaines\nKipe, Ratoma\nConakry, Guinee",
            'email' => 'stages@socorif.gn',
        ],
        [
            'title' => 'Chef de Projet Amenagement (H/F)',
            'slug' => 'chef-projet-amenagement',
            'category' => 'Technique',
            'contract_type' => 'CDI',
            'start_date' => 'Des que possible',
            'tasks' => [
                'Piloter les projets d\'amenagement de A a Z',
                'Coordonner les equipes terrain et les sous-traitants',
                'Etablir et suivre les plannings et budgets',
                'Assurer la conformite technique et reglementaire',
                'Gerer la relation avec les clients et administrations',
                'Rediger les rapports d\'avancement',
                'Participer aux reunions de chantier',
            ],
            'profile' => [
                'Diplome d\'ingenieur en genie civil ou amenagement (BAC+5)',
                'Experience de 5 ans minimum en gestion de projets',
                'Connaissance des normes de construction en Guinee',
                'Capacite a manager des equipes pluridisciplinaires',
                'Maitrise des logiciels de gestion de projet (MS Project, etc.)',
                'Leadership et excellentes capacites de communication',
            ],
            'perspectives' => '<ul>
<li>Salaire attractif selon profil et experience</li>
<li>Vehicule de fonction</li>
<li>Prime sur objectifs</li>
<li>Participation aux benefices</li>
<li>Evolution possible vers la direction technique</li>
</ul>',
            'postal_address' => "SOCORIF SARL\nDirection des Ressources Humaines\nKipe, Ratoma\nConakry, Guinee",
            'email' => 'recrutement@socorif.gn',
        ],
        [
            'title' => 'Alternance - Assistant(e) Commercial(e)',
            'slug' => 'alternance-assistant-commercial',
            'category' => 'Commercial',
            'contract_type' => 'Alternance',
            'start_date' => 'Rentree 2025',
            'ausbildung_title' => 'Formation en alternance :',
            'ausbildung_content' => '<p>Contrat d\'alternance de 12 a 24 mois en partenariat avec les ecoles de commerce de Conakry.</p>
<p><strong>Rythme :</strong> 3 jours en entreprise / 2 jours en formation</p>
<p><strong>Objectif :</strong> Vous former aux metiers de la vente immobiliere tout en preparant votre diplome (BTS ou Licence).</p>',
            'tasks' => [
                'Assister l\'equipe commerciale dans ses missions',
                'Participer a la prospection telephonique',
                'Preparer les dossiers de vente',
                'Accompagner les commerciaux lors des visites',
                'Contribuer a la mise a jour du CRM',
                'Participer aux actions marketing',
            ],
            'profile' => [
                'Etudiant(e) preparant un BTS ou Licence Commerce',
                'Premiere experience en vente appreciee',
                'Aisance relationnelle et sens du service',
                'Bonne presentation et elocution',
                'Maitrise du Pack Office',
                'Motivation pour le secteur immobilier',
            ],
            'perspectives' => '<ul>
<li>Remuneration selon grille alternance</li>
<li>Formation commerciale complete</li>
<li>Accompagnement personnalise par un tuteur</li>
<li>Possibilite d\'embauche en CDI a l\'issue de l\'alternance</li>
</ul>',
            'postal_address' => "SOCORIF SARL\nService des Ressources Humaines\nKipe, Ratoma\nConakry, Guinee",
            'email' => 'alternance@socorif.gn',
        ],
    ];

    foreach ($emplois as $emploi) {
        // Verifier si l'offre existe deja
        $existing = get_page_by_path($emploi['slug'], OBJECT, 'emplois');
        if ($existing) {
            echo "  - Offre '{$emploi['title']}' existe deja, ignore.\n";
            continue;
        }

        // Creer l'offre
        $post_id = wp_insert_post([
            'post_title' => $emploi['title'],
            'post_name' => $emploi['slug'],
            'post_type' => 'emplois',
            'post_status' => 'publish',
            'post_content' => '',
        ]);

        if ($post_id && !is_wp_error($post_id)) {
            // Assigner la categorie
            $cat_term = get_term_by('name', $emploi['category'], 'emplois_category');
            if ($cat_term) {
                wp_set_object_terms($post_id, $cat_term->term_id, 'emplois_category');
            }

            // Assigner le type de contrat
            $contract_term = get_term_by('name', $emploi['contract_type'], 'emplois_contract_type');
            if ($contract_term) {
                wp_set_object_terms($post_id, $contract_term->term_id, 'emplois_contract_type');
            }

            // Mettre a jour les champs ACF
            if (function_exists('update_field')) {
                update_field('start_date', $emploi['start_date'], $post_id);

                // Contenu de formation (pour stages/alternance)
                if (!empty($emploi['ausbildung_title'])) {
                    update_field('ausbildung_title', $emploi['ausbildung_title'], $post_id);
                }
                if (!empty($emploi['ausbildung_content'])) {
                    update_field('ausbildung_content', $emploi['ausbildung_content'], $post_id);
                }

                // Missions
                update_field('tasks_title', 'Vos missions :', $post_id);
                $tasks_data = array_map(fn($task) => ['item' => $task], $emploi['tasks']);
                update_field('tasks', $tasks_data, $post_id);

                // Profil
                update_field('profile_title', 'Votre profil :', $post_id);
                $profile_data = array_map(fn($item) => ['item' => $item], $emploi['profile']);
                update_field('profile', $profile_data, $post_id);

                // Avantages
                update_field('perspectives_title', 'Ce que nous offrons :', $post_id);
                update_field('perspectives_content', $emploi['perspectives'], $post_id);

                // Candidature
                update_field('application_postal_title', 'Postulez a cette adresse :', $post_id);
                update_field('application_postal', $emploi['postal_address'], $post_id);
                update_field('application_is_email', 1, $post_id);
                update_field('application_email', $emploi['email'], $post_id);
                update_field('application_email_subject', 'Candidature - ' . $emploi['title'], $post_id);
            }

            echo "  + Offre '{$emploi['title']}' creee (ID: {$post_id})\n";
        }
    }

    echo "\n";
}

/**
 * Supprimer tous les exemples de contenu
 * Utile pour reinitialiser les donnees de test
 */
function socorif_delete_all_examples(): void {
    echo "Suppression des exemples de contenu...\n";

    $post_types = ['leistungen', 'projekte', 'property', 'emplois'];

    foreach ($post_types as $post_type) {
        $posts = get_posts([
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => 'any',
        ]);

        foreach ($posts as $post) {
            wp_delete_post($post->ID, true);
            echo "  - Supprime: {$post->post_title}\n";
        }
    }

    delete_option('socorif_examples_created');
    echo "\nTous les exemples ont ete supprimes.\n";
}

// Decommenter la ligne suivante pour executer automatiquement (a utiliser une seule fois)
// add_action('init', 'socorif_create_all_examples', 999);
