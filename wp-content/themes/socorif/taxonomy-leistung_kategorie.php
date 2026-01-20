<?php
/**
 * Template pour la taxonomie Categories de services
 * Affiche les services filtres par categorie
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

get_header();

// Categorie actuelle depuis l'URL
$current_kategorie = get_query_var('leistung_kategorie');

// Recuperer toutes les categories
$kategorien = get_terms(['taxonomy' => 'leistung_kategorie', 'hide_empty' => true]);

// Contenu du hero depuis les options
$subtitle = get_field('archive_leistungen_subtitle', 'option') ?: 'Nos services';
$title = get_field('archive_leistungen_title', 'option') ?: 'Nos prestations';
$description = get_field('archive_leistungen_description', 'option') ?: 'Des prestations professionnelles pour votre projet - du conseil a la realisation.';
$bg_image = get_field('archive_leistungen_bg', 'option');
$overlay_opacity = get_field('archive_leistungen_overlay', 'option') ?? 60;
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
                <h1 class="section-title text-white mb-6">
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
                    <a href="#leistungen-grid" class="inline-flex items-center rounded-md bg-primary px-4 py-3 text-sm font-semibold text-white shadow-lg hover:bg-primary/90 transition-all duration-300">
                        Voir les prestations
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hero Section - Version Desktop (Division diagonale polygonale) -->
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
                    <h1 class="section-title">
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
                        <a href="#leistungen-grid" class="rounded-md bg-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                            Voir les prestations
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
<?php if ($kategorien && !is_wp_error($kategorien)) : ?>
<section class="bg-white dark:bg-gray-900 py-8 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40 shadow-md">
    <div class="container">
        <div class="flex flex-wrap gap-4 items-center justify-center">
            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Categorie :</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('leistungen')); ?>"
               class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 cursor-pointer <?php echo !$current_kategorie ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'; ?>">
                Toutes
            </a>
            <?php foreach ($kategorien as $kategorie) : ?>
                <a href="<?php echo esc_url(get_term_link($kategorie)); ?>"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 cursor-pointer <?php echo $current_kategorie === $kategorie->slug ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'; ?>">
                    <?php echo esc_html($kategorie->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Grille des prestations -->
<section id="leistungen-grid" class="section bg-gray-50 dark:bg-gray-800">
    <div class="container">

        <?php if (have_posts()) : ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php while (have_posts()) : the_post();
                    $kategorien = get_the_terms(get_the_ID(), 'leistung_kategorie');
                ?>

                    <article class="group bg-white dark:bg-gray-800 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-primary/30">

                        <!-- Image de la prestation -->
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="block relative overflow-hidden aspect-[4/3] cursor-pointer">
                                <?php the_post_thumbnail('card', [
                                    'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110'
                                ]); ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        <?php endif; ?>

                        <!-- Informations de la prestation -->
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
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors duration-300 cursor-pointer">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <!-- Description courte -->
                            <?php if (has_excerpt()) : ?>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                    <?php echo get_the_excerpt(); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Lien -->
                            <div x-data="{ linkHover: false }">
                                <a href="<?php the_permalink(); ?>"
                                   class="inline-flex items-center gap-2 text-primary font-semibold text-sm cursor-pointer"
                                   @mouseenter="linkHover = true"
                                   @mouseleave="linkHover = false">
                                    <span>En savoir plus</span>
                                    <?php get_template_part('template-parts/components/cta-arrow', null, array('hover_state' => 'linkHover')); ?>
                                </a>
                            </div>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

        <?php else : ?>

            <!-- Aucune prestation trouvee -->
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Aucune prestation trouvee
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Il n'y a actuellement aucune prestation dans cette categorie.
                </p>
                <a href="<?php echo esc_url(get_post_type_archive_link('leistungen')); ?>"
                   class="btn btn-primary cursor-pointer">
                    Voir toutes les prestations
                </a>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
