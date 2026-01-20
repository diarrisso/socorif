<?php
/**
 * Template Name: Projets / Realisations
 * Template Post Type: page
 *
 * Page template for Projects listing with filtering
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
            // Fallback: Display projects grid
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
                                Nos realisations et projets immobiliers
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Projects Grid -->
                <section class="section bg-gray-50 dark:bg-gray-800">
                    <div class="container">
                        <?php
                        // Query projects
                        $projects = new WP_Query([
                            'post_type' => 'projekte',
                            'posts_per_page' => 12,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ]);

                        if ($projects->have_posts()) :
                        ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                <?php while ($projects->have_posts()) : $projects->the_post(); ?>
                                    <article class="group bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="relative aspect-[4/3] overflow-hidden">
                                                <?php the_post_thumbnail('card', [
                                                    'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500',
                                                ]); ?>
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>

                                            <?php if (has_excerpt()) : ?>
                                                <p class="text-gray-600 dark:text-gray-400 line-clamp-2">
                                                    <?php echo get_the_excerpt(); ?>
                                                </p>
                                            <?php endif; ?>

                                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center mt-4 text-primary font-medium hover:text-primary/80 transition-colors">
                                                Voir le projet
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
                            echo '<p class="text-center text-gray-600 dark:text-gray-400">Aucun projet disponible pour le moment.</p>';
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
            </article>
            <?php
        endif;

    endwhile;
    ?>
</main>

<?php get_footer(); ?>
