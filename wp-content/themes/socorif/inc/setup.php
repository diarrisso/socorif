<?php
/**
 * Theme Setup
 */

if (!defined('ABSPATH')) exit;

/**
 * Configuration du theme
 */
function socorif_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo');
    add_theme_support('editor-styles');
    add_theme_support('responsive-embeds');

    // Support Site Icon (Favicon)
    add_theme_support('site-icon');

    register_nav_menus([
        'primary' => __('Menu Principal', 'socorif'),
        'footer' => __('Menu Footer', 'socorif'),
        'footer-legal' => __('Menu Legal Footer', 'socorif'),
    ]);

    add_image_size('hero', 1920, 1080, true);
    add_image_size('card', 600, 400, true);
}
add_action('after_setup_theme', 'socorif_setup');


/**
 * Charger les scripts et styles
 */
function socorif_scripts() {
    wp_enqueue_style('socorif-style', get_template_directory_uri() . '/assets/dist/style.css', [], filemtime(get_template_directory() . '/assets/dist/style.css'));

    // Charger Swiper CSS
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0.5');

    // Charger Swiper JS (dans le footer avec defer)
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.5', true);
    wp_script_add_data('swiper', 'defer', true);

    // Charger Alpine.js Collapse Plugin (dans le footer avec defer)
    wp_enqueue_script('alpinejs-collapse', 'https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.1/dist/cdn.min.js', ['swiper'], '3.14.1', true);
    wp_script_add_data('alpinejs-collapse', 'defer', true);

    // Charger Alpine.js (dans le footer avec defer)
    wp_enqueue_script('alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js', ['swiper', 'alpinejs-collapse'], '3.14.1', true);
    wp_script_add_data('alpinejs', 'defer', true);

    // CF7 Stepper - Formulaires multi-etapes pour Contact Form 7
    wp_enqueue_script('cf7-stepper', get_template_directory_uri() . '/assets/src/js/cf7-stepper.js', ['alpinejs'], '1.0.0', true);
    wp_script_add_data('cf7-stepper', 'defer', true);
}
add_action('wp_enqueue_scripts', 'socorif_scripts');


/**
 * Integration des favicons
 * Genere par https://realfavicongenerator.net/
 */
function socorif_favicons(): void {
    $favicon_path = get_template_directory_uri() . '/assets/favicons';
    ?>
    <link rel="icon" type="image/png" href="<?php echo esc_url($favicon_path); ?>/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url($favicon_path); ?>/favicon.svg" />
    <link rel="shortcut icon" href="<?php echo esc_url($favicon_path); ?>/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url($favicon_path); ?>/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="SOCORIF" />
    <link rel="manifest" href="<?php echo esc_url($favicon_path); ?>/site.webmanifest" />
    <?php
}
add_action('wp_head', 'socorif_favicons');

/**
 * Nettoyage WordPress
 */
function socorif_cleanup() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
}
add_action('init', 'socorif_cleanup');

/**
 * Create default navigation menu with mega-menu support
 * Run once on theme activation
 */
function socorif_create_default_menu(): void {
    // Check if already created
    if (get_option('socorif_default_menu_created')) {
        return;
    }

    $menu_name = 'Menu Principal Socorif';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if ($menu_exists) {
        update_option('socorif_default_menu_created', true);
        return;
    }

    // Create the menu
    $menu_id = wp_create_nav_menu($menu_name);

    if (is_wp_error($menu_id)) {
        return;
    }

    // Get page IDs
    $pages = [
        'accueil' => get_option('page_on_front'),
        'a-propos' => get_page_by_path('a-propos'),
        'services' => get_page_by_path('services'),
        'proprietes' => get_page_by_path('proprietes'),
        'opportunites' => get_page_by_path('opportunites-foncieres'),
        'projets' => get_page_by_path('projets'),
        'actualites' => get_page_by_path('actualites'),
        'contact' => get_page_by_path('contact'),
    ];

    // 1. Accueil
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => 'Accueil',
        'menu-item-url' => home_url('/'),
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
    ]);

    // 2. A propos
    if ($pages['a-propos']) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'A propos',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $pages['a-propos']->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
        ]);
    }

    // 3. Services
    if ($pages['services']) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Services',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $pages['services']->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
        ]);
    }

    // 4. Biens Immobiliers (Parent with mega-menu class)
    $biens_id = wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title' => 'Biens Immobiliers',
        'menu-item-url' => '#',
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom',
        'menu-item-classes' => 'mega-menu',
    ]);

    // 4.1 Proprietes (sub-item)
    if ($pages['proprietes']) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Proprietes',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $pages['proprietes']->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-parent-id' => $biens_id,
            'menu-item-description' => 'Maisons, appartements et villas',
        ]);
    }

    // 4.2 Opportunites Foncieres (sub-item)
    if ($pages['opportunites']) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Opportunites Foncieres',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $pages['opportunites']->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-parent-id' => $biens_id,
            'menu-item-description' => 'Terrains et lotissements',
        ]);
    }

    // 4.3 Projets (sub-item)
    if ($pages['projets']) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Projets',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $pages['projets']->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-parent-id' => $biens_id,
            'menu-item-description' => 'Nos realisations',
        ]);
    }

    // 5. Actualites
    if ($pages['actualites']) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Actualites',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $pages['actualites']->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
        ]);
    }

    // 6. Contact
    if ($pages['contact']) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title' => 'Contact',
            'menu-item-object' => 'page',
            'menu-item-object-id' => $pages['contact']->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
        ]);
    }

    // Assign menu to primary location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    // Mark as created
    update_option('socorif_default_menu_created', true);
}
add_action('after_switch_theme', 'socorif_create_default_menu');

/**
 * Admin notice to create default menu
 */
function socorif_admin_menu_notice(): void {
    if (get_option('socorif_default_menu_created')) {
        return;
    }

    $screen = get_current_screen();
    if ($screen->id !== 'nav-menus') {
        return;
    }
    ?>
    <div class="notice notice-info is-dismissible">
        <p>
            <strong>Socorif:</strong>
            <a href="<?php echo esc_url(admin_url('admin-post.php?action=socorif_create_menu')); ?>">
                Cliquez ici pour creer le menu par defaut avec mega-menu
            </a>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'socorif_admin_menu_notice');

/**
 * Handle admin action to create menu
 */
function socorif_handle_create_menu(): void {
    if (!current_user_can('edit_theme_options')) {
        wp_die('Unauthorized');
    }

    // Remove the flag to allow recreation
    delete_option('socorif_default_menu_created');

    // Create the menu
    socorif_create_default_menu();

    // Redirect back to menus page
    wp_redirect(admin_url('nav-menus.php?menu_created=1'));
    exit;
}
add_action('admin_post_socorif_create_menu', 'socorif_handle_create_menu');

/**
 * Ajouter les balises meta SEO
 * Ajoute Open Graph, Twitter Cards et URL canonique
 */
function socorif_seo_meta_tags(): void {
    // Determiner le titre et la description
    $title = '';
    $description = '';
    $image = '';
    $url = '';

    if (is_singular()) {
        global $post;
        $title = get_the_title();

        // Description: extrait ou contenu raccourci
        if (has_excerpt()) {
            $description = get_the_excerpt();
        } else {
            $description = wp_trim_words(strip_tags($post->post_content), 30, '...');
        }

        // Image: image mise en avant ou image par defaut
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        if (!$image) {
            $image = get_template_directory_uri() . '/assets/images/default-og.jpg';
        }

        $url = get_permalink();
    } elseif (is_home() || is_front_page()) {
        $title = get_bloginfo('name');
        $description = get_bloginfo('description');
        $image = get_template_directory_uri() . '/assets/images/default-og.jpg';
        $url = home_url('/');
    } elseif (is_archive()) {
        $title = get_the_archive_title();
        $description = get_the_archive_description();
        $image = get_template_directory_uri() . '/assets/images/default-og.jpg';
        $url = get_post_type_archive_link(get_post_type());
    }

    if (!$title) return;

    // Meta Description
    if ($description) {
        echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";
    }

    // Open Graph Tags
    echo '<meta property="og:type" content="' . (is_single() ? 'article' : 'website') . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";

    if ($description) {
        echo '<meta property="og:description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";
    }

    echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    echo '<meta property="og:locale" content="fr_FR">' . "\n";

    // Twitter Cards
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";

    if ($description) {
        echo '<meta name="twitter:description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";
    }

    echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";

    // Canonical URL
    echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
}
add_action('wp_head', 'socorif_seo_meta_tags', 1);

/**
 * Ajouter le balisage Schema.org JSON-LD
 * Ajoute des donnees structurees pour les moteurs de recherche
 */
function socorif_schema_markup(): void {
    $schema_data = [];

    // Schema Organization (sur toutes les pages)
    $organization = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        '@id' => home_url('/#organization'),
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'logo' => [
            '@type' => 'ImageObject',
            'url' => get_template_directory_uri() . '/assets/images/logo.svg',
        ],
        'description' => get_bloginfo('description'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Rue Example',
            'addressLocality' => 'Dakar',
            'postalCode' => 'BP 12345',
            'addressCountry' => 'SN'
        ],
        'telephone' => '+221 33 123 45 67',
        'email' => 'contact@socorif.sn',
        'sameAs' => [
            // Inserer les URLs des reseaux sociaux ici
            // 'https://www.facebook.com/socorif',
            // 'https://www.linkedin.com/company/socorif',
        ]
    ];

    $schema_data[] = $organization;

    // Schema WebSite (uniquement sur la page d'accueil)
    if (is_front_page() || is_home()) {
        $website = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => home_url('/#website'),
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
            'publisher' => [
                '@id' => home_url('/#organization')
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => home_url('/?s={search_term_string}')
                ],
                'query-input' => 'required name=search_term_string'
            ]
        ];
        $schema_data[] = $website;
    }

    // Schema JobPosting pour les offres d'emploi
    if (is_singular('emplois')) {
        global $post;

        // Recuperer les champs ACF
        $stellenbezeichnung = get_field('stellenbezeichnung');
        $kategorie = get_field('kategorie');
        $vertragsart = get_field('vertragsart');
        $beschreibung = get_field('beschreibung');
        $anforderungen = get_field('anforderungen');
        $benefits = get_field('benefits');
        $start_date = get_field('start_date');

        // Composer la description complete
        $full_description = '';
        if ($beschreibung) {
            $full_description .= $beschreibung . "\n\n";
        }
        if ($anforderungen) {
            $full_description .= "Exigences:\n" . $anforderungen . "\n\n";
        }
        if ($benefits) {
            $full_description .= "Avantages:\n" . $benefits;
        }

        $job = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => $stellenbezeichnung ?: get_the_title(),
            'description' => wp_strip_all_tags($full_description) ?: get_the_excerpt(),
            'datePosted' => get_the_date('c'),
            'validThrough' => date('c', strtotime('+90 days')), // Valide pendant 90 jours
            'employmentType' => $vertragsart ?: 'FULL_TIME',
            'hiringOrganization' => [
                '@type' => 'Organization',
                '@id' => home_url('/#organization')
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Rue Example',
                    'addressLocality' => 'Dakar',
                    'postalCode' => 'BP 12345',
                    'addressCountry' => 'SN'
                ]
            ],
            'identifier' => [
                '@type' => 'PropertyValue',
                'name' => get_bloginfo('name'),
                'value' => 'JOB-' . get_the_ID()
            ]
        ];

        // Ajouter les champs optionnels
        if ($kategorie) {
            $job['occupationalCategory'] = $kategorie;
        }

        if ($start_date) {
            $job['jobStartDate'] = $start_date;
        }

        $schema_data[] = $job;
    }

    // Schema Article/BlogPosting pour les articles de blog
    if (is_single() && get_post_type() === 'post') {
        $article = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => get_the_title(),
            'description' => get_the_excerpt(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => get_the_author()
            ],
            'publisher' => [
                '@id' => home_url('/#organization')
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => get_permalink()
            ]
        ];

        // Ajouter l'image mise en avant si disponible
        if (has_post_thumbnail()) {
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $article['image'] = [
                '@type' => 'ImageObject',
                'url' => $image_url
            ];
        }

        $schema_data[] = $article;
    }

    // Afficher le balisage Schema
    if (!empty($schema_data)) {
        echo '<script type="application/ld+json">';
        echo wp_json_encode($schema_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo '</script>' . "\n";
    }
}
add_action('wp_head', 'socorif_schema_markup', 5);

/**
 * Ajouter la classe current-menu-item aux elements du menu
 * Ce filtre s'execute AVANT le Walker pour que les classes soient detectees
 *
 * @param array $items Elements du menu
 * @param object $args Arguments du menu
 * @return array Elements modifies
 */
function socorif_nav_menu_objects(array $items, object $args): array {
    // URL actuelle
    $current_url = trailingslashit(home_url(add_query_arg([], false)));

    // Detecter le contexte actuel
    $current_slug = '';

    if (is_page()) {
        $current_slug = get_post_field('post_name', get_queried_object_id());
    } elseif (is_post_type_archive()) {
        // Archive de CPT - recuperer le slug de l'archive
        $post_type = get_query_var('post_type');
        if ($post_type) {
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj && $post_type_obj->has_archive) {
                $current_slug = is_string($post_type_obj->has_archive)
                    ? $post_type_obj->has_archive
                    : $post_type;
            }
        }
    }

    foreach ($items as $item) {
        // Deja marque comme actif, on passe
        if (in_array('current-menu-item', (array) $item->classes)) {
            continue;
        }

        $is_match = false;

        // Verifier par URL exacte
        $menu_url = trailingslashit($item->url);
        if ($current_url === $menu_url) {
            $is_match = true;
        }

        // Verifier par slug
        if (!$is_match && $current_slug) {
            $item_slug = '';

            if ($item->type === 'post_type' && $item->object === 'page') {
                $item_slug = get_post_field('post_name', $item->object_id);
            } elseif ($item->type === 'custom') {
                $parsed_url = wp_parse_url($item->url);
                if (isset($parsed_url['path'])) {
                    $item_slug = trim($parsed_url['path'], '/');
                }
            }

            if ($item_slug && $current_slug === $item_slug) {
                $is_match = true;
            }
        }

        // Ajouter la classe si match
        if ($is_match) {
            $item->classes[] = 'current-menu-item';
        }
    }

    return $items;
}
add_filter('wp_nav_menu_objects', 'socorif_nav_menu_objects', 10, 2);
