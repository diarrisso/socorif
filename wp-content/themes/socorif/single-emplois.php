<?php
/**
 * Template pour les offres d'emploi individuelles
 *
 * Affichage d'une offre d'emploi unique
 *
 * @package Socorif
 */

get_header(); ?>

<?php
$post_id = get_the_ID();
?>

<main class="site-main-single bg-white dark:bg-gray-900 transition-colors">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

                <div class="flex flex-col">

                    <?php
                    $back_text = 'Retour aux offres d\'emploi';
                    $karriere_page = get_page_by_path('carrieres');
                    $back_url = $karriere_page ? get_permalink($karriere_page->ID) : home_url('/carrieres/');
                    ?>
                    <?php if (!empty($back_url)) : ?>
                        <div class="mb-8">
                            <a href="<?php echo esc_url($back_url); ?>"
                               class="group inline-flex items-center gap-3 px-6 py-3.5 rounded-3xl bg-gradient-to-r from-gray-100 to-gray-200 hover:from-primary hover:to-primary-dark dark:from-gray-800 dark:to-gray-700 dark:hover:from-primary dark:hover:to-primary-dark text-gray-700 hover:text-white dark:text-gray-300 dark:hover:text-white transition-all duration-300 ease-out hover:shadow-xl hover:scale-105 active:scale-95 cursor-pointer font-semibold shadow-md transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                <span><?php echo esc_html($back_text); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- En-tete avec design moderne -->
                    <div class="entry-header mb-12 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-3xl p-8 md:p-10 border-2 border-gray-200 dark:border-gray-700 shadow-xl">
                        <?php
                        $categories = get_the_terms($post_id, 'emplois_category');
                        $contract_types = get_the_terms($post_id, 'emplois_contract_type');
                        if ($categories || $contract_types):
                            ?>
                            <div class="flex flex-wrap gap-3 mb-6">
                                <?php
                                if ($categories && !is_wp_error($categories)):
                                    foreach ($categories as $category): ?>
                                        <span class="inline-flex items-center px-5 py-2.5 rounded-3xl text-sm font-bold dark:bg-secondary text-white shadow-lg cursor-default hover:scale-105 transition-transform duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                    <?php endforeach;
                                endif;

                                if ($contract_types && !is_wp_error($contract_types)):
                                    foreach ($contract_types as $type): ?>
                                        <span class="inline-flex items-center px-5 py-2.5 rounded-3xl text-sm font-bold bg-primary dark:bg-primary text-white shadow-lg cursor-default hover:scale-105 transition-transform duration-200">
                                            <?php echo esc_html($type->name); ?>
                                        </span>
                                    <?php endforeach;
                                endif;
                                ?>
                            </div>
                        <?php endif; ?>

                        <h1 class="page-title mb-6">
                            <?php the_title(); ?>
                        </h1>

                        <?php
                        $start_date = get_field('start_date', $post_id);
                        if ($start_date): ?>
                            <div class="inline-flex items-center gap-3 px-5 py-3 bg-primary/10 dark:bg-primary/20 rounded-3xl cursor-default">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-semibold dark:text-white"><?php echo esc_html($start_date); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php
                $ausbildung_title = get_field('ausbildung_title', $post_id);
                $ausbildung_content = get_field('ausbildung_content', $post_id);
                $tasks_title = get_field('tasks_title', $post_id);
                $tasks = get_field('tasks', $post_id);
                $profile_title = get_field('profile_title', $post_id);
                $profile = get_field('profile', $post_id);
                $perspectives_title = get_field('perspectives_title', $post_id);
                $perspectives_content = get_field('perspectives_content', $post_id);
                $additional_sections = get_field('additional_sections', $post_id);

                $contract_types = get_the_terms($post_id, 'emplois_contract_type');
                $contract_type = 'fulltime';
                if ($contract_types && !is_wp_error($contract_types)) {
                    $contract_type = $contract_types[0]->slug;
                }
                $is_ausbildung = in_array($contract_type, array('stage', 'alternance'));

                $has_content = get_the_content() || $ausbildung_content || !empty($tasks) || !empty($profile) || $perspectives_content || !empty($additional_sections);
                ?>

                <?php if ($has_content): ?>
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-3xl border-2 border-gray-200 dark:border-gray-700 shadow-xl overflow-hidden">
                    <div class="p-8 md:p-10" x-data="{ open: true }">
                        <div class="flex items-start justify-between gap-x-4 sm:gap-x-6 mb-6">
                            <div class="flex-auto">
                                <h3 class="text-3xl md:text-4xl font-bold dark:text-white flex items-center gap-4">
                                    <span class="flex-shrink-0 w-2 h-12 bg-primary rounded-full"></span>
                                    Details du poste
                                </h3>
                            </div>

                            <button
                                @click="open = !open"
                                type="button"
                                class="flex-shrink-0 bg-primary hover:bg-primary-dark text-white p-4 transition-all duration-300 ease-in-out hover:scale-110 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800 border-0 rounded-3xl shadow-lg hover:shadow-xl cursor-pointer transform hover:-translate-y-0.5 active:scale-95"
                                aria-label="Afficher les details"
                            >
                                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" x-transition>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" x-transition>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                                </svg>
                            </button>
                        </div>

                        <div x-show="open"
                             x-collapse
                             class="space-y-8">

                            <?php if (get_the_content()): ?>
                                <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                                    <?php the_content(); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($is_ausbildung && !empty($ausbildung_content)): ?>
                                <div class="space-y-4">
                                    <h4 class="text-2xl md:text-3xl font-bold dark:text-white flex items-center gap-3">
                                        <span class="flex-shrink-0 w-2 h-8 bg-primary rounded"></span>
                                        <?php echo esc_html($ausbildung_title); ?>
                                    </h4>
                                    <div class="ausbildung-content prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 ml-5">
                                        <?php echo wp_kses_post($ausbildung_content); ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php if (!empty($tasks) && is_array($tasks)): ?>
                                    <div class="space-y-4">
                                        <h4 class="text-2xl md:text-3xl font-bold dark:text-white flex items-center gap-3">
                                            <span class="flex-shrink-0 w-2 h-8 bg-primary rounded"></span>
                                            <?php echo esc_html($tasks_title); ?>
                                        </h4>
                                        <ul class="ml-5 space-y-3">
                                            <?php foreach ($tasks as $t):
                                                $txt = is_array($t) ? ($t['item'] ?? '') : $t;
                                                if (!$txt) continue; ?>
                                                <li class="flex items-start gap-3 text-base md:text-lg text-gray-700 dark:text-gray-300 cursor-default hover:text-primary dark:hover:text-primary transition-colors duration-200">
                                                    <svg class="w-6 h-6 flex-shrink-0 text-primary mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <?php echo esc_html($txt); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($profile) && is_array($profile)): ?>
                                    <div class="space-y-4">
                                        <h4 class="text-2xl md:text-3xl font-bold dark:text-white flex items-center gap-3">
                                            <span class="flex-shrink-0 w-2 h-8 bg-primary rounded"></span>
                                            <?php echo esc_html($profile_title); ?>
                                        </h4>
                                        <ul class="ml-5 space-y-3">
                                            <?php foreach ($profile as $p):
                                                $pt = is_array($p) ? ($p['item'] ?? '') : $p;
                                                if (!$pt) continue; ?>
                                                <li class="flex items-start gap-3 text-base md:text-lg text-gray-700 dark:text-gray-300 cursor-default hover:text-primary dark:hover:text-primary transition-colors duration-200">
                                                    <svg class="w-6 h-6 flex-shrink-0 text-primary mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <?php echo esc_html($pt); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (!empty($perspectives_content)): ?>
                                <div class="space-y-4">
                                    <h4 class="text-2xl md:text-3xl font-bold dark:text-white flex items-center gap-3">
                                        <span class="flex-shrink-0 w-2 h-8 bg-primary rounded"></span>
                                        <?php echo esc_html($perspectives_title); ?>
                                    </h4>
                                    <div class="perspectives-content prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 ml-5">
                                        <?php echo wp_kses_post($perspectives_content); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($additional_sections) && is_array($additional_sections)): ?>
                                <?php foreach ($additional_sections as $section):
                                    $section_title = $section['section_title'] ?? '';
                                    $section_content = $section['section_content'] ?? '';
                                    if (empty($section_title) || empty($section_content)) continue;
                                ?>
                                    <div class="space-y-4">
                                        <h4 class="text-2xl md:text-3xl font-bold dark:text-white flex items-center gap-3">
                                            <span class="flex-shrink-0 w-2 h-8 bg-primary rounded"></span>
                                            <?php echo esc_html($section_title); ?>
                                        </h4>
                                        <div class="additional-section-content prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 ml-5">
                                            <?php echo wp_kses_post($section_content); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <?php endif;

                $application_postal_title = get_field('application_postal_title', $post_id);
                $application_postal = get_field('application_postal', $post_id);
                $application_is_email = get_field('application_is_email', $post_id);
                $application_email = get_field('application_email', $post_id);
                $application_email_subject = get_field('application_email_subject', $post_id);
                $application_link = get_field('application_link', $post_id);

                if ($application_postal || $application_is_email || $application_link):
                    ?>
                    <div class="mt-8 rounded-3xl border-2 border-primary/30 dark:border-primary/40 bg-gradient-to-br from-white to-primary/5 dark:from-gray-800 dark:to-primary/10 p-8 md:p-10 shadow-xl">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-primary rounded-3xl flex items-center justify-center shadow-lg transform hover:scale-110 hover:rotate-6 transition-all duration-300 cursor-default">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <?php if ($application_postal_title): ?>
                                    <h4 class="text-2xl md:text-3xl font-bold dark:text-white mb-4">
                                        <?php echo esc_html($application_postal_title); ?>
                                    </h4>
                                <?php endif; ?>

                                <?php if ($application_postal): ?>
                                    <p class="whitespace-pre-line text-base md:text-lg text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                                        <?php echo esc_html($application_postal); ?>
                                    </p>
                                <?php endif; ?>

                                <?php
                                $use_email = isset($application_is_email) && (bool)$application_is_email;
                                $cta_href = '';
                                $cta_target = '';
                                $cta_text = '';

                                if ($use_email && !empty($application_email)) {
                                    $cta_href = 'mailto:' . antispambot(sanitize_email($application_email));
                                    if (!empty($application_email_subject)) {
                                        $cta_href .= '?subject=' . rawurlencode($application_email_subject);
                                    }
                                    $cta_text = 'Postuler maintenant';
                                } elseif (is_array($application_link) && !empty($application_link['url'])) {
                                    $cta_href = $application_link['url'];
                                    $cta_target = !empty($application_link['target']) ? $application_link['target'] : '';
                                    $cta_text = !empty($application_link['title']) ? $application_link['title'] : 'Postuler maintenant';
                                }
                                ?>

                                <?php if (!empty($cta_href)) : ?>
                                    <div class="mt-6">
                                        <a
                                            href="<?php echo esc_url($cta_href); ?>"
                                            <?php if (!empty($cta_target)) : ?> target="<?php echo esc_attr($cta_target); ?>" <?php endif; ?>
                                            class="group/btn inline-flex items-center gap-3 bg-primary hover:bg-primary-dark text-white font-bold px-8 py-4 rounded-3xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer"
                                        >
                                            <span class="text-lg"><?php echo esc_html($cta_text); ?></span>
                                            <svg class="w-5 h-5 transform group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                // Promotional banner
                get_template_part('template-parts/components/cpt-banniere-pub');
                ?>
                </div>

            </div>

            <!-- Flexible Content -->
            <?php if (have_rows('flexible_content')) : ?>
                <?php while (have_rows('flexible_content')) : the_row(); ?>
                    <?php
                    $layout = get_row_layout();
                    $block_file = get_template_directory() . '/template-parts/blocks/' . $layout . '/' . $layout . '.php';

                    if (file_exists($block_file)) {
                        include $block_file;
                    }
                    ?>
                <?php endwhile; ?>
            <?php endif; ?>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
