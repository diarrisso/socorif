<?php
/**
 * Template Name: Opportunites Foncieres
 * Template Post Type: page
 *
 * Page template for Land Opportunities listing
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
            // Message si aucun bloc n'est configure
            ?>
            <section class="section bg-gray-50 dark:bg-gray-800">
                <div class="container">
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?php the_title(); ?></h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            <?php esc_html_e('Configurez les blocs flexibles dans l\'administration pour afficher le contenu.', 'flavor'); ?>
                        </p>
                    </div>
                </div>
            </section>
            <?php
        endif;

    endwhile;
    ?>
</main>

<?php get_footer(); ?>