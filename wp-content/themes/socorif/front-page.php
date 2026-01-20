<?php
/**
 * Front Page Template
 *
 * @package Socorif
 */

get_header(); ?>

<main class="bg-white dark:bg-gray-900 transition-colors" role="main">
    <?php
    while (have_posts()) :
        the_post();

        // Check if ACF Flexible Content exists
        if (function_exists('have_rows') && have_rows('flexible_content')) :
            while (have_rows('flexible_content')) : the_row();
                $layout = get_row_layout();
                $block_file = SOCORIF_DIR . '/template-parts/blocks/' . $layout . '/' . $layout . '.php';

                if (file_exists($block_file)) {
                    include $block_file;
                }
            endwhile;
        else :
            // Fallback to Gutenberg content
            the_content();
        endif;

    endwhile;
    ?>
</main>

<?php get_footer(); ?>
