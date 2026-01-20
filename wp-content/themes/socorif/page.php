<?php
/**
 * Default Page Template
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
            // Fallback to Gutenberg/classic content
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('py-16'); ?>>
                <div class="container">
                    <header class="mb-8">
                        <h1 class="page-title">
                            <?php the_title(); ?>
                        </h1>
                    </header>

                    <div class="prose prose-lg max-w-none dark:prose-invert">
                        <?php the_content(); ?>
                    </div>
                </div>
            </article>
            <?php
        endif;

    endwhile;
    ?>
</main>

<?php get_footer(); ?>
