<?php
/**
 * 404 Error Page Template
 */

if (!defined('ABSPATH')) exit;

get_header();

// Get ACF options
$image_light = get_field('404_image_light', 'option');
$image_dark = get_field('404_image_dark', 'option');
$title = get_field('404_title', 'option') ?: 'Seite nicht gefunden';
$description = get_field('404_description', 'option') ?: 'Entschuldigung, wir konnten die von Ihnen gesuchte Seite nicht finden.';
$button_text = get_field('404_button_text', 'option') ?: 'Zurück zur Startseite';

// Fallback images si les champs ne sont pas remplis
$default_image_light = 'https://images.unsplash.com/photo-1545972154-9bb223aac798?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=3050&q=80&exp=8&con=-15&sat=-75';
$default_image_dark = 'https://images.unsplash.com/photo-1545972154-9bb223aac798?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=3050&q=80&exp=-20&con=-15&sat=-75';

$image_light_url = $image_light ? $image_light['url'] : $default_image_light;
$image_dark_url = $image_dark ? $image_dark['url'] : $default_image_dark;
?>

<main class="relative isolate min-h-screen">
    <!-- Background Image - Light Mode -->
    <img src="<?php echo esc_url($image_light_url); ?>"
         alt="<?php echo esc_attr($title); ?>"
         class="absolute inset-0 -z-10 size-full object-cover object-top dark:hidden" />

    <!-- Background Image - Dark Mode -->
    <img src="<?php echo esc_url($image_dark_url); ?>"
         alt="<?php echo esc_attr($title); ?>"
         class="absolute inset-0 -z-10 size-full object-cover object-top not-dark:hidden" />

    <!-- Content -->
    <div class="mx-auto max-w-7xl px-6 py-32 text-center sm:py-40 lg:px-8">
        <p class="text-base/8 font-semibold text-white">404</p>
        <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-white sm:text-7xl">
            <?php echo esc_html($title); ?>
        </h1>
        <p class="mt-6 text-lg font-medium text-pretty text-white/70 sm:text-xl/8">
            <?php echo esc_html($description); ?>
        </p>
        <div class="mt-10 flex justify-center">
            <a href="<?php echo esc_url(home_url('/')); ?>"
               class="text-sm/7 font-semibold text-white hover:text-white/90">
                <span aria-hidden="true">&larr;</span> <?php echo esc_html($button_text); ?>
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
