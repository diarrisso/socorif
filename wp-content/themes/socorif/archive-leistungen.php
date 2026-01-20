<?php
/**
 * Template pour l'archive des services
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

get_header();

// Filtre de taxonomie actuel
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

<!-- Hero Section -->
<section class="hero-section relative min-h-[50vh] md:min-h-[60vh] flex flex-col justify-center overflow-hidden">

    <?php if ($bg_image) : ?>
        <!-- Image de fond -->
        <div class="absolute inset-0 z-0">
            <?php echo wp_get_attachment_image($bg_image['ID'], 'hero', false, [
                'class' => 'w-full h-full object-cover',
                'loading' => 'eager'
            ]); ?>
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-secondary-dark/<?php echo esc_attr($overlay_opacity); ?> via-secondary/<?php echo esc_attr($overlay_opacity); ?> to-secondary-dark/<?php echo esc_attr($overlay_opacity); ?> z-[1]"></div>
    <?php else : ?>
        <!-- Gradient de secours -->
        <div class="absolute inset-0 bg-gradient-to-br from-secondary-dark via-secondary to-secondary-dark z-0"></div>
    <?php endif; ?>

    <div class="container relative z-10 px-4 py-16 md:py-20">
        <div class="max-w-4xl mx-auto text-center">
            <?php if ($subtitle) : ?>
                <p class="text-primary font-semibold uppercase tracking-wider mb-4 text-sm md:text-base">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                <?php echo esc_html($title); ?>
            </h1>

            <?php if ($description) : ?>
                <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">
                    <?php echo esc_html($description); ?>
                </p>
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

<!-- Grille des services -->
<section class="section bg-gray-50 dark:bg-gray-800">
    <div class="container">

        <?php if (have_posts()) : ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php while (have_posts()) : the_post();
                    $kategorien = get_the_terms(get_the_ID(), 'leistung_kategorie');
                ?>

                    <article class="group bg-white dark:bg-gray-800 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-primary/30">

                        <!-- Image du service -->
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="block relative overflow-hidden aspect-[4/3] cursor-pointer">
                                <?php the_post_thumbnail('card', [
                                    'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110'
                                ]); ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        <?php endif; ?>

                        <!-- Informations du service -->
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

            <!-- Aucun service trouve -->
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Aucun service trouve
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Il n'y a actuellement aucun service dans cette categorie.
                </p>
                <a href="<?php echo esc_url(get_post_type_archive_link('leistungen')); ?>"
                   class="btn btn-primary cursor-pointer">
                    Voir tous les services
                </a>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
