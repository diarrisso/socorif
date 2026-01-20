<?php
/**
 * Template pour l'archive des projets
 */

if (!defined('ABSPATH')) exit;

get_header();

// Filtres taxonomiques actuels
$current_kategorie = get_query_var('projekt_kategorie');
$current_typ = get_query_var('projekt_typ');

// Recuperer toutes les categories et types
$kategorien = get_terms(['taxonomy' => 'projekt_kategorie', 'hide_empty' => true]);
$typen = get_terms(['taxonomy' => 'projekt_typ', 'hide_empty' => true]);

// Recuperer le contenu hero depuis les options
$subtitle = get_field('archive_projekte_subtitle', 'option') ?: 'Projets';
$title = get_field('archive_projekte_title', 'option') ?: 'Nos projets de reference';
$description = get_field('archive_projekte_description', 'option') ?: 'Decouvrez nos projets immobiliers realises avec succes et convainquez-vous de notre qualite et de notre experience.';
$bg_image = get_field('archive_projekte_bg', 'option');
$overlay_opacity = get_field('archive_projekte_overlay', 'option') ?? 60;
?>

<!-- Hero Section - Version Mobile (Image de fond avec overlay) -->
<section class="lg:hidden relative bg-gray-900 min-h-[500px] md:min-h-[600px] flex items-center">
    <!-- Image de fond -->
    <?php if ($bg_image) : ?>
        <div class="absolute inset-0 z-0">
            <?php echo wp_get_attachment_image($bg_image['ID'], 'hero', false, [
                'class' => 'w-full h-full object-cover',
                'loading' => 'eager'
            ]); ?>
            <!-- Overlay sombre pour meilleure lisibilite -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/40"></div>
        </div>
    <?php else : ?>
        <!-- Gradient de secours si pas d'image -->
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-secondary via-secondary/80 to-primary/60"></div>
    <?php endif; ?>

    <!-- Contenu -->
    <div class="relative z-10 w-full">
        <div class="container py-16">
            <div class="max-w-3xl">
                <?php if ($subtitle) : ?>
                    <!-- Badge/Sous-titre -->
                    <div class="mb-6">
                        <div class="inline-block rounded-full px-4 py-2 text-sm bg-primary/20 text-primary-light ring-1 ring-primary/30">
                            <?php echo esc_html($subtitle); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Titre -->
                <h1 class="page-title text-white mb-6">
                    <?php echo esc_html($title); ?>
                </h1>

                <?php if ($description) : ?>
                    <!-- Description -->
                    <p class="section-description text-gray-200">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>

                <!-- Bouton CTA -->
                <div class="mt-10">
                    <a href="#projekte-grid" class="inline-flex items-center rounded-md bg-primary px-4 py-3 text-sm font-semibold text-white shadow-lg hover:bg-primary/90 transition-all duration-300">
                        Voir les projets
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hero Section - Version Desktop (Polygon Diagonal Split) -->
<section class="hidden lg:block relative bg-white dark:bg-gray-900">
    <div class="mx-auto max-w-7xl flex flex-row">
        <div class="relative z-10 pt-14 w-full max-w-2xl order-1">
            <!-- SVG diagonal - Transition vers l'image -->
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" class="absolute inset-y-0 right-0 h-full w-24 translate-x-1/4 sm:w-32 sm:translate-x-1/3 md:w-48 md:translate-x-1/2 lg:w-96 xl:w-[28rem] 2xl:w-[32rem] transform fill-white dark:fill-gray-900">
                <polygon points="0,0 90,0 50,100 0,100" />
            </svg>

            <!-- Contenu texte -->
            <div class="relative px-6 py-32 sm:py-40 lg:px-8 lg:py-56 lg:pr-0">
                <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">

                    <?php if ($subtitle) : ?>
                        <!-- Badge/Sous-titre -->
                        <div class="hidden sm:mb-10 sm:flex">
                            <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 dark:text-gray-400 ring-1 ring-gray-900/10 dark:ring-gray-100/10">
                                <?php echo esc_html($subtitle); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Titre -->
                    <h1 class="page-title">
                        <?php echo esc_html($title); ?>
                    </h1>

                    <?php if ($description) : ?>
                        <!-- Description -->
                        <p class="section-description mt-8">
                            <?php echo esc_html($description); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Bouton CTA -->
                    <div class="mt-10 flex items-center gap-x-6">
                        <a href="#projekte-grid" class="rounded-md bg-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                            Voir les projets
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image a droite -->
        <div class="bg-gray-50 dark:bg-gray-800 absolute inset-y-0 right-0 w-2/5 md:w-[45%] lg:w-1/2">
            <?php if ($bg_image) : ?>
                <?php echo wp_get_attachment_image($bg_image['ID'], 'hero', false, [
                    'class' => 'w-full h-full object-cover',
                    'loading' => 'eager'
                ]); ?>
            <?php else : ?>
                <!-- Gradient de secours si pas d'image -->
                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20"></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Section Filtres -->
<section class="bg-white dark:bg-gray-900 py-8 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40 shadow-md">
    <div class="container">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-center">

            <!-- Filtre par categorie -->
            <?php if ($kategorien && !is_wp_error($kategorien)) : ?>
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Categorie :</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('projekte')); ?>"
                       class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 <?php echo !$current_kategorie ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'; ?>">
                        Tous
                    </a>
                    <?php foreach ($kategorien as $kategorie) : ?>
                        <a href="<?php echo esc_url(get_term_link($kategorie)); ?>"
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 <?php echo $current_kategorie === $kategorie->slug ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'; ?>">
                            <?php echo esc_html($kategorie->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Filtre par type -->
            <?php if ($typen && !is_wp_error($typen)) : ?>
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Type :</span>
                    <?php foreach ($typen as $typ) : ?>
                        <a href="<?php echo esc_url(get_term_link($typ)); ?>"
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 <?php echo $current_typ === $typ->slug ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'; ?>">
                            <?php echo esc_html($typ->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Grille Projets -->
<section class="section bg-gray-50 dark:bg-gray-800">
    <div class="container">

        <?php if (have_posts()) : ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php while (have_posts()) : the_post();
                    $kunde = get_field('projekt_kunde');
                    $standort = get_field('projekt_standort');
                    $fertigstellung = get_field('projekt_fertigstellung');
                    $beschreibung_kurz = get_field('projekt_beschreibung_kurz');
                    $kategorien = get_the_terms(get_the_ID(), 'projekt_kategorie');
                    $typen = get_the_terms(get_the_ID(), 'projekt_typ');
                    $featured = get_field('projekt_featured');
                ?>

                    <article class="group bg-gradient-to-br from-white via-white to-gray-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-primary/30 <?php echo $featured ? 'ring-2 ring-primary' : ''; ?>">

                        <!-- Badge projet vedette -->
                        <?php if ($featured) : ?>
                            <div class="absolute top-4 right-4 z-10 bg-primary text-white px-3 py-1 rounded-full text-xs font-bold">
                                Projet de reference
                            </div>
                        <?php endif; ?>

                        <!-- Image du projet -->
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="block relative overflow-hidden aspect-[4/3]">
                                <?php the_post_thumbnail('card', [
                                    'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110'
                                ]); ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        <?php endif; ?>

                        <!-- Infos du projet -->
                        <div class="p-6">

                            <!-- Categories -->
                            <?php if ($kategorien) : ?>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <?php foreach ($kategorien as $kategorie) : ?>
                                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full">
                                            <?php echo esc_html($kategorie->name); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Titre -->
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 border-l-4 border-primary pl-4 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-300">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors duration-300">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <!-- Description courte -->
                            <?php if ($beschreibung_kurz) : ?>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                    <?php echo esc_html($beschreibung_kurz); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Meta-infos -->
                            <div class="flex flex-wrap gap-3 text-xs text-gray-500 dark:text-gray-400 mb-4">
                                <?php if ($standort) : ?>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        <?php echo esc_html($standort); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ($fertigstellung) : ?>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <?php echo esc_html(date_i18n('F Y', strtotime($fertigstellung))); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Lien -->
                            <a href="<?php the_permalink(); ?>"
                               class="inline-flex items-center gap-2 text-primary font-semibold text-sm group/link cursor-pointer">
                                <span>Voir le projet</span>
                                <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

            <!-- Pagination -->
            <?php
            $total_pages = $wp_query->max_num_pages;
            if ($total_pages > 1) :
            ?>
                <div class="mt-12 flex justify-center">
                    <nav class="inline-flex gap-2">
                        <?php
                        echo paginate_links([
                            'total' => $total_pages,
                            'current' => max(1, get_query_var('paged')),
                            'prev_text' => '&larr; Precedent',
                            'next_text' => 'Suivant &rarr;',
                            'type' => 'list',
                            'before_page_number' => '<span class="px-4 py-2 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-primary hover:text-white transition-colors duration-200">',
                            'after_page_number' => '</span>',
                        ]);
                        ?>
                    </nav>
                </div>
            <?php endif; ?>

        <?php else : ?>

            <!-- Aucun projet trouve -->
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Aucun projet trouve
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Il n'y a actuellement aucun projet dans cette categorie.
                </p>
                <a href="<?php echo esc_url(get_post_type_archive_link('projekte')); ?>"
                   class="btn btn-primary">
                    Voir tous les projets
                </a>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
