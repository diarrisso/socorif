<?php
/**
 * Template Name: A Propos
 * Template Post Type: page
 *
 * Page template for About Us / Qui sommes-nous
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
            // Fallback content
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Hero Section -->
                <section class="bg-gradient-to-br from-secondary via-secondary/90 to-primary/70 py-16 md:py-24">
                    <div class="container">
                        <div class="max-w-3xl">
                            <h1 class="page-title text-white mb-4">
                                <?php the_title(); ?>
                            </h1>
                            <?php if (has_excerpt()) : ?>
                                <p class="text-gray-200 text-lg">
                                    <?php the_excerpt(); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <!-- Content -->
                <section class="section bg-white dark:bg-gray-900">
                    <div class="container">
                        <div class="prose prose-lg max-w-none dark:prose-invert">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
            </article>
            <?php
        endif;

    endwhile;
    ?>
</main>

<?php get_footer(); ?>
