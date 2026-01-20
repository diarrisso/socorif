<?php
/**
 * Template Name: Proprietes / Opportunites Foncieres
 * Template Post Type: page
 *
 * Page template for Properties and Land Opportunities
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

get_header(); ?>

<main class="bg-white dark:bg-gray-900 transition-colors" role="main">
    <?php
    while (have_posts()) :
        the_post();

        // ACF Flexible Content blocks
        if (function_exists('have_rows') && have_rows('flexible_content')) :
            while (have_rows('flexible_content')) : the_row();
                $layout = get_row_layout();
                $block_file = get_template_directory() . '/template-parts/blocks/' . $layout . '/' . $layout . '.php';

                if (file_exists($block_file)) {
                    include $block_file;
                }
            endwhile;
        else :
            // Fallback: Display properties
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Hero Section -->
                <section class="bg-gradient-to-br from-secondary via-secondary/90 to-primary/70 py-16 md:py-24">
                    <div class="container">
                        <div class="max-w-3xl">
                            <h1 class="page-title text-white mb-4">
                                <?php the_title(); ?>
                            </h1>
                            <p class="text-gray-200 text-lg">
                                Decouvrez nos opportunites foncieres et biens disponibles
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Properties Grid -->
                <section class="section bg-gray-50 dark:bg-gray-800">
                    <div class="container">
                        <?php
                        // Query properties (custom post type)
                        $properties = new WP_Query([
                            'post_type' => 'property',
                            'posts_per_page' => 12,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ]);

                        if ($properties->have_posts()) :
                        ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                <?php while ($properties->have_posts()) : $properties->the_post(); ?>
                                    <article class="group bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="relative aspect-[4/3] overflow-hidden">
                                                <?php the_post_thumbnail('card', [
                                                    'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500',
                                                ]); ?>
                                                <?php
                                                $status = get_field('property_status');
                                                if ($status) :
                                                ?>
                                                    <span class="absolute top-4 left-4 px-3 py-1 bg-primary text-white text-sm font-medium rounded-full">
                                                        <?php echo esc_html($status); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>

                                            <?php
                                            $location = get_field('property_location');
                                            if ($location) :
                                            ?>
                                                <p class="flex items-center text-gray-500 dark:text-gray-400 mb-2">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    <?php echo esc_html($location); ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php
                                            $surface = get_field('property_surface');
                                            $price = get_field('property_price');
                                            ?>
                                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                <?php if ($surface) : ?>
                                                    <span class="text-gray-600 dark:text-gray-400">
                                                        <?php echo esc_html($surface); ?> m²
                                                    </span>
                                                <?php endif; ?>

                                                <?php if ($price) : ?>
                                                    <span class="text-lg font-bold text-primary">
                                                        <?php echo esc_html(number_format($price, 0, ',', ' ')); ?> FCFA
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center mt-4 text-primary font-medium hover:text-primary/80 transition-colors">
                                                Voir les details
                                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                        <?php
                        else :
                        ?>
                            <div class="text-center py-12">
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Aucune propriete disponible pour le moment.</p>
                                <p class="text-gray-500 dark:text-gray-500">Contactez-nous pour connaitre nos opportunites foncieres.</p>
                            </div>
                        <?php
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>

                <!-- CTA Section -->
                <section class="section bg-secondary">
                    <div class="container text-center">
                        <h2 class="text-3xl font-bold text-white mb-4">
                            Vous cherchez un terrain ou une propriete ?
                        </h2>
                        <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                            Notre equipe est a votre disposition pour vous accompagner dans votre projet immobilier.
                        </p>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
                            Nous contacter
                        </a>
                    </div>
                </section>
            </article>
            <?php
        endif;

    endwhile;
    ?>
</main>

<?php get_footer(); ?>
