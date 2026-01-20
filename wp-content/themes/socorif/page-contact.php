<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Page de contact - utilise les blocs flexible content
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main class="contact-page">

    <?php
    // Afficher tous les blocs flexible content
    if (have_rows('flexible_content')) :
        while (have_rows('flexible_content')) : the_row();
            $layout = get_row_layout();
            socorif_block($layout);
        endwhile;
    else :
        // Message si aucun bloc n'est configure
        ?>
        <section class="py-20">
            <div class="container text-center">
                <p class="text-gray-500 dark:text-gray-400">
                    Ajoutez des blocs flexible content pour construire cette page.
                </p>
            </div>
        </section>
        <?php
    endif;
    ?>

</main>

<?php get_footer(); ?>
