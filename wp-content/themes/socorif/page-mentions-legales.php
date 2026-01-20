<?php
/**
 * Template Name: Mentions Legales
 * Template Post Type: page
 *
 * Template pour la page des mentions legales
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

get_header();

while (have_posts()) : the_post();
?>

<article class="min-h-screen bg-white dark:bg-gray-900">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-secondary via-secondary/90 to-primary/70 py-16 md:py-24">
        <div class="container">
            <div class="max-w-3xl">
                <h1 class="page-title text-white mb-4">
                    <?php the_title(); ?>
                </h1>
                <p class="text-gray-200 text-lg">
                    Derniere mise a jour: <?php echo get_the_modified_date('d F Y'); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Contenu -->
    <section class="section bg-white dark:bg-gray-900">
        <div class="container">
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none dark:prose-invert prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-a:text-primary hover:prose-a:text-primary/80">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </section>
</article>

<?php
endwhile;

get_footer();
