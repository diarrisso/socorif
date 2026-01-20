<?php
/**
 * Template Name: Nos Services
 * Template Post Type: page
 *
 * Page template for Services listing
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
            // Fallback content with options (uses same settings as archive-leistungen)
            $subtitle = get_field('archive_leistungen_subtitle', 'option') ?: 'Nos services';
            $title = get_field('archive_leistungen_title', 'option') ?: get_the_title();
            $description = get_field('archive_leistungen_description', 'option') ?: 'Des prestations professionnelles pour votre projet';
            $bg_image = get_field('archive_leistungen_bg', 'option');
            $overlay = get_field('archive_leistungen_overlay', 'option') ?: 60;
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Hero Section -->
                <section class="relative min-h-[50vh] md:min-h-[60vh] flex items-center overflow-hidden">
                    <?php if ($bg_image) : ?>
                        <!-- Background Image -->
                        <div class="absolute inset-0">
                            <?php echo wp_get_attachment_image($bg_image['ID'], 'hero', false, [
                                'class' => 'w-full h-full object-cover object-center'
                            ]); ?>
                        </div>
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-secondary-dark/<?php echo esc_attr($overlay); ?> via-secondary-dark/<?php echo esc_attr(max(40, $overlay - 20)); ?> to-black/<?php echo esc_attr($overlay); ?>"></div>
                    <?php else : ?>
                        <!-- Fallback Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-br from-secondary-dark via-secondary to-secondary-dark"></div>
                    <?php endif; ?>

                    <div class="container relative z-10 py-16 md:py-20">
                        <div class="max-w-3xl">
                            <?php if ($subtitle) : ?>
                                <p class="text-primary font-semibold uppercase tracking-wider text-sm mb-4">
                                    <?php echo esc_html($subtitle); ?>
                                </p>
                            <?php endif; ?>
                            <h1 class="page-title text-white mb-4">
                                <?php echo esc_html($title); ?>
                            </h1>
                            <?php if ($description) : ?>
                                <p class="text-gray-200 text-lg max-w-2xl">
                                    <?php echo esc_html($description); ?>
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
