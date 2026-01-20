<?php
/**
 * Template Name: Carrieres / Offres d'emploi
 *
 * Affiche automatiquement les offres d'emploi du CPT Emplois
 *
 * @package Socorif
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main" class="site-main" role="main">
    <?php
    while (have_posts()) :
        the_post();

        // Rendre d'abord les blocs Flexible Content (Hero, etc.)
        if (function_exists('have_rows') && have_rows('flexible_content')) :
            while (have_rows('flexible_content')) : the_row();
                $layout = get_row_layout();
                $block_file = SOCORIF_DIR . '/template-parts/blocks/' . $layout . '/' . $layout . '.php';

                if (file_exists($block_file)) {
                    include $block_file;
                }
            endwhile;
        endif;
    endwhile;

    // Jetzt automatisch Stellenangebote aus CPT rendern
    $enable_search = true;
    $filter_options = array('search', 'category', 'contract');
    $subtext = '';
    $title = '';
    $subtitle = '';
    $recruitment_cta = '';

    // Diese Werte aus ACF abrufen, falls auf der Seite gesetzt
    if (function_exists('get_field')) {
        $page_subtext = get_field('emplois_subtext');
        $page_title = get_field('emplois_title');
        $page_subtitle = get_field('emplois_subtitle');
        $page_recruitment_cta = get_field('emplois_recruitment_cta');
        $page_enable_search = get_field('emplois_enable_search');
        $page_filter_options = get_field('emplois_filter_options');

        if ($page_subtext) $subtext = $page_subtext;
        if ($page_title) $title = $page_title;
        if ($page_subtitle) $subtitle = $page_subtitle;
        if ($page_recruitment_cta) $recruitment_cta = $page_recruitment_cta;
        if ($page_enable_search !== null) $enable_search = $page_enable_search;
        if ($page_filter_options) $filter_options = $page_filter_options;
    }

    // Stellenangebote-Daten aus CPT vorbereiten
    $jobs = array();

    $args = array(
        'post_type' => 'emplois',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    // Filter aus URL anwenden, falls Suche aktiviert ist
    if ($enable_search) {
        $tax_query = array('relation' => 'AND');

        // Kategoriefilter
        if (isset($_GET['job_category']) && !empty($_GET['job_category'])) {
            $tax_query[] = array(
                'taxonomy' => 'emplois_category',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['job_category']),
            );
        }

        // Filtre par type de contrat
        if (isset($_GET['job_contract']) && !empty($_GET['job_contract'])) {
            $tax_query[] = array(
                'taxonomy' => 'emplois_contract_type',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['job_contract']),
            );
        }

        if (count($tax_query) > 1) {
            $args['tax_query'] = $tax_query;
        }

        // Filtre de recherche
        if (isset($_GET['job_search']) && !empty($_GET['job_search'])) {
            $args['s'] = sanitize_text_field($_GET['job_search']);
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Recuperer les categories
            $categories = get_the_terms($post_id, 'emplois_category');
            $category = !empty($categories) && !is_wp_error($categories) ? $categories[0]->name : '';

            // Recuperer les types de contrat
            $contract_types = get_the_terms($post_id, 'emplois_contract_type');
            $contract_type_obj = !empty($contract_types) && !is_wp_error($contract_types) ? $contract_types[0] : null;
            $contract_type = $contract_type_obj ? $contract_type_obj->slug : 'fulltime';

            $jobs[] = array(
                'job_title' => get_the_title(),
                'category' => $category,
                'contract_type' => $contract_type,
                'start_date' => get_field('start_date', $post_id) ?: 'Des que possible',
                'ausbildung_title' => get_field('ausbildung_title', $post_id) ?: 'Contenu de la formation :',
                'ausbildung_content' => get_field('ausbildung_content', $post_id) ?: '',
                'tasks_title' => get_field('tasks_title', $post_id) ?: 'Vos missions :',
                'tasks' => get_field('tasks', $post_id) ?: array(),
                'profile_title' => get_field('profile_title', $post_id) ?: 'Votre profil :',
                'profile' => get_field('profile', $post_id) ?: array(),
                'perspectives_title' => get_field('perspectives_title', $post_id) ?: 'Ce que nous offrons :',
                'perspectives_content' => get_field('perspectives_content', $post_id) ?: '',
                'additional_sections' => get_field('additional_sections', $post_id) ?: array(),
                'application_postal_title' => get_field('application_postal_title', $post_id) ?: 'Postulez a cette adresse :',
                'application_postal' => get_field('application_postal', $post_id) ?: '',
                'application_is_email' => get_field('application_is_email', $post_id),
                'application_email' => get_field('application_email', $post_id) ?: '',
                'application_email_subject' => get_field('application_email_subject', $post_id) ?: '',
                'application_link' => get_field('application_link', $post_id) ?: '',
            );
        }
        wp_reset_postdata();
    }

    $classes = [
        'emplois-block',
        'bg-white dark:bg-gray-900',
    ];
    $block_classes = implode(' ', $classes);
    ?>

    <section class="<?php echo esc_attr($block_classes); ?> relative isolate overflow-hidden py-16 sm:py-20 lg:py-24">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="text-left mb-12">
                <?php if ($subtext): ?>
                    <span class="inline-block font-semibold text-sm sm:text-base uppercase tracking-wider text-primary dark:text-primary mb-3 sm:mb-4 px-4 py-2 bg-primary/10 dark:bg-primary/20 rounded-full">
                        <?php echo esc_html($subtext); ?>
                    </span>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h1 class="page-title mt-4">
                        <?php echo esc_html($title); ?>
                    </h1>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <p class="mt-6 text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-3xl">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php
            // Suche/Filter anzeigen falls aktiviert
            if ($enable_search):
                $show_search = in_array('search', $filter_options);
                $show_category = in_array('category', $filter_options);
                $show_contract = in_array('contract', $filter_options);

                get_template_part('template-parts/components/job-search-filter', null, array(
                    'show_search' => $show_search,
                    'show_category_filter' => $show_category,
                    'show_contract_filter' => $show_contract,
                ));
            endif;
            ?>

            <?php if (!empty($jobs) && is_array($jobs)): ?>
                <div id="emplois-list" class="mt-10 sm:mt-12 lg:mt-16 grid gap-6">

                    <?php foreach ($jobs as $index => $job):
                        $job_title = $job['job_title'] ?? '';
                        $category = $job['category'] ?? '';
                        $contract_type = $job['contract_type'] ?? '';
                        $start_date = $job['start_date'] ?? 'Des que possible';
                        $application_link = $job['application_link'] ?? '';

                        $contract_badges = array(
                            'cdi' => array('text' => 'CDI', 'color' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300'),
                            'cdd' => array('text' => 'CDD', 'color' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300'),
                            'stage' => array('text' => 'Stage', 'color' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300'),
                            'alternance' => array('text' => 'Alternance', 'color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'),
                        );

                        $badge_info = $contract_badges[$contract_type] ?? array('text' => $contract_type, 'color' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300');
                    ?>

                        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-lg hover:shadow-xl border border-transparent transition-all duration-300 overflow-hidden cursor-pointer"
                             :class="{ 'border-primary/20 shadow-primary/10': open }"
                             x-data="{ open: false }"
                             @click="open = !open">
                            <!-- Accent border gauche (jaune chantier) -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-primary via-primary-dark to-primary transition-all duration-300 group-hover:w-2"></div>

                            <div class="p-4 sm:p-5 lg:p-6">
                                <div class="flex items-start justify-between gap-x-4 sm:gap-x-6">
                                    <div class="flex-auto">
                                        <div class="flex flex-col gap-2">
                                            <h3 class="text-xl sm:text-2xl lg:text-2xl font-bold  dark:text-white group-hover:text-primary dark:group-hover:text-primary transition-colors duration-300">
                                                <?php echo esc_html($job_title); ?>
                                            </h3>
                                        </div>

                                        <div class="mt-4 flex flex-wrap items-center gap-2 sm:gap-3">
                                            <?php if ($category): ?>
                                                <span class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-semibold bg-secondary-dark dark:bg-secondary text-white shadow-sm">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    <?php echo esc_html($category); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($contract_type): ?>
                                                <span class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-semibold <?php echo esc_attr($badge_info['color']); ?> shadow-sm">
                                                    <?php echo esc_html($badge_info['text']); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($start_date): ?>
                                                <span class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <?php echo esc_html($start_date); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                         :class="open ? '' : ''">
                                        <button
                                            @click.stop="open = !open"
                                            type="button"
                                            class="w-full h-full flex items-center justify-center cursor-pointer focus:outline-none"
                                            aria-label="Afficher les details"
                                        >
                                            <svg class="w-5 h-5 transition-all duration-300"
                                                 :class="open ? 'text-primary rotate-180' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary'"
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            <?php
                            // Determine if this is an Ausbildung/Praktikum or regular job
                            $is_ausbildung = in_array($contract_type, array('stage', 'alternance'));

                            $ausbildung_title = $job['ausbildung_title'] ?? 'Contenu de la formation :';
                            $ausbildung_content = $job['ausbildung_content'] ?? '';
                            $tasks_title = $job['tasks_title'] ?? 'Vos missions :';
                            $tasks = isset($job['tasks']) && is_array($job['tasks']) ? $job['tasks'] : array();
                            $profile_title = $job['profile_title'] ?? 'Votre profil :';
                            $profile = isset($job['profile']) && is_array($job['profile']) ? $job['profile'] : array();
                            $perspectives_title = $job['perspectives_title'] ?? 'Ce que nous offrons :';
                            $perspectives_content = $job['perspectives_content'] ?? '';
                            $additional_sections = isset($job['additional_sections']) && is_array($job['additional_sections']) ? $job['additional_sections'] : array();
                            $application_postal_title = $job['application_postal_title'] ?? 'Postulez a cette adresse :';
                            $application_postal = $job['application_postal'] ?? '';

                            $has_structured = !empty($ausbildung_content) || !empty($tasks) || !empty($profile) || !empty($perspectives_content) || !empty($additional_sections);
                            ?>

                            <?php if ($has_structured): ?>
                                <div x-cloak
                                     x-show="open"
                                     x-collapse
                                     class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">

                                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-4 sm:p-5 lg:p-6 space-y-6">

                                        <?php if ($is_ausbildung && !empty($ausbildung_content)): ?>
                                            <!-- Ausbildungsinhalte Bereich (für Ausbildung/Praktikum) -->
                                            <div class="space-y-3">
                                                <h4 class="text-lg md:text-xl font-bold  dark:text-white flex items-center gap-2">
                                                    <span class="flex-shrink-0 w-1.5 h-6 bg-primary rounded"></span>
                                                    <?php echo esc_html($ausbildung_title); ?>
                                                </h4>
                                                <div class="ausbildung-content prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 ml-5">
                                                    <?php echo wp_kses_post($ausbildung_content); ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- Regulärer Job: Aufgaben und Profil -->
                                            <?php if (!empty($tasks)): ?>
                                                <div class="space-y-3">
                                                    <h4 class="text-lg md:text-xl font-bold  dark:text-white flex items-center gap-2">
                                                        <span class="flex-shrink-0 w-1.5 h-6 bg-primary rounded"></span>
                                                        <?php echo esc_html($tasks_title); ?>
                                                    </h4>
                                                    <ul class="ml-5 space-y-2 list-disc list-inside">
                                                        <?php foreach ($tasks as $t): $txt = is_array($t) ? ($t['item'] ?? '') : $t; if (!$txt) continue; ?>
                                                            <li class="text-base md:text-lg text-gray-700 dark:text-gray-300">
                                                                <?php echo esc_html($txt); ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($profile)): ?>
                                                <div class="space-y-3">
                                                    <h4 class="text-lg md:text-xl font-bold  dark:text-white flex items-center gap-2">
                                                        <span class="flex-shrink-0 w-1.5 h-6 bg-primary rounded"></span>
                                                        <?php echo esc_html($profile_title); ?>
                                                    </h4>
                                                    <ul class="ml-5 space-y-2 list-disc list-inside">
                                                        <?php foreach ($profile as $p): $pt = is_array($p) ? ($p['item'] ?? '') : $p; if (!$pt) continue; ?>
                                                            <li class="text-base md:text-lg text-gray-700 dark:text-gray-300">
                                                                <?php echo esc_html($pt); ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if (!empty($perspectives_content)): ?>
                                            <div class="space-y-3">
                                                <h4 class="text-lg md:text-xl font-bold  dark:text-white flex items-center gap-2">
                                                    <span class="flex-shrink-0 w-1.5 h-6 bg-primary rounded"></span>
                                                    <?php echo esc_html($perspectives_title); ?>
                                                </h4>
                                                <div class="perspectives-content prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 ml-5">
                                                    <?php echo wp_kses_post($perspectives_content); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($additional_sections)): ?>
                                            <!-- Zusätzliche benutzerdefinierte Bereiche -->
                                            <?php foreach ($additional_sections as $section):
                                                $section_title = $section['section_title'] ?? '';
                                                $section_content = $section['section_content'] ?? '';
                                                if (empty($section_title) || empty($section_content)) continue;
                                            ?>
                                                <div class="space-y-3">
                                                    <h4 class="text-lg md:text-xl font-bold  dark:text-white flex items-center gap-2">
                                                        <span class="flex-shrink-0 w-1.5 h-6 bg-primary rounded"></span>
                                                        <?php echo esc_html($section_title); ?>
                                                    </h4>
                                                    <div class="additional-section-content prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 ml-5">
                                                        <?php echo wp_kses_post($section_content); ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <?php
                                        $use_email = isset($job['application_is_email']) && (bool)$job['application_is_email'];
                                        $app_email = $job['application_email'] ?? '';
                                        $app_subject = $job['application_email_subject'] ?? '';
                                        $application_link = $job['application_link'] ?? '';

                                        $cta_href = '';
                                        $cta_target = '';
                                        $cta_text = '';

                                        if ($use_email && !empty($app_email)) {
                                            $cta_href = 'mailto:' . antispambot(sanitize_email($app_email));
                                            if (!empty($app_subject)) {
                                                $cta_href .= '?subject=' . rawurlencode($app_subject);
                                            }
                                            $cta_text = 'Postuler maintenant';
                                        } elseif (is_array($application_link) && !empty($application_link['url'])) {
                                            $cta_href = $application_link['url'];
                                            $cta_target = !empty($application_link['target']) ? $application_link['target'] : '';
                                            $cta_text = !empty($application_link['title']) ? $application_link['title'] : 'Postuler maintenant';
                                        }
                                        ?>

                                        <?php if (!empty($cta_href)) : ?>
                                            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                <a
                                                    href="<?php echo esc_url($cta_href); ?>"
                                                    <?php if (!empty($cta_target)) : ?> target="<?php echo esc_attr($cta_target); ?>" <?php endif; ?>
                                                    class="group/btn inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-3xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer"
                                                >
                                                    <span class="text-base"><?php echo esc_html($cta_text); ?></span>
                                                    <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                            </div>

                            <?php if (!empty($application_postal)): ?>
                                <!-- Bewerbungsadresse (immer sichtbar) -->

                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                </div>
            <?php else: ?>
                <div class="mx-auto mt-16 max-w-2xl">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl p-12 text-center shadow-lg">
                        <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold  dark:text-white mb-3">
                            Aucune offre correspondante trouvee
                        </h3>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            Aucune offre d'emploi ne correspond actuellement a ces criteres.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($recruitment_cta)): ?>
                <div class="mt-16 rounded-3xl border-2 border-primary/20 dark:border-primary/30 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-8 md:p-12 shadow-xl">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-primary rounded-3xl flex items-center justify-center shadow-lg transform hover:scale-110 hover:rotate-6 transition-all duration-300 cursor-default">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="prose prose-lg dark:prose-invert max-w-none flex-1">
                            <?php echo wp_kses_post($recruitment_cta); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
