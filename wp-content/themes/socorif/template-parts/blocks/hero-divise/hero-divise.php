<?php
/**
 * Bloc Hero Divise
 * Section hero avec mise en page divisee: texte a gauche, image a droite avec separateur diagonal
 */

if (!defined('ABSPATH')) exit;

// Identification du bloc dans le code HTML
socorif_block_comment_start('hero-split');

// Charger la configuration
require_once __DIR__ . '/config.php';

// Recuperer les champs
$badge_text = socorif_get_field('badge_text');
$badge_link = socorif_get_field('badge_link');
$heading = socorif_get_field('heading', 'Votre entreprise en vedette');
$description = socorif_get_field('description');
$primary_button_text = socorif_get_field('primary_button_text');
$primary_button_link = socorif_get_field('primary_button_link');
$secondary_button_text = socorif_get_field('secondary_button_text');
$secondary_button_link = socorif_get_field('secondary_button_link');
$image = socorif_get_field('image');
$show_decorative_svg = socorif_get_field('show_decorative_svg', true);

// Attributs du bloc pour le wrapper
$block_attrs = isset($block) ? get_block_wrapper_attributes(['class' => 'hero-split-block']) : 'class="hero-split-block"';
?>

<div <?php echo $block_attrs; ?>>

    <!-- Version Mobile (Image de fond avec superposition) -->
    <section class="lg:hidden relative bg-gray-900 min-h-[500px] md:min-h-[600px] flex items-center overflow-hidden">
        <!-- Image de fond -->
        <?php if ($image) : ?>
            <div class="absolute inset-0 z-0">
                <?php
                echo socorif_image(
                    $image,
                    'hero',
                    [
                        'class' => 'w-full h-full object-cover',
                        'alt' => $image['alt'] ?? $heading,
                        'loading' => 'eager'
                    ]
                );
                ?>
                <!-- Superposition sombre pour une meilleure lisibilite -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/40"></div>
            </div>
        <?php else : ?>
            <!-- Degrade de secours -->
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-secondary via-secondary/80 to-primary/60"></div>
        <?php endif; ?>

        <!-- Contenu -->
        <div class="relative z-10 w-full">
            <div class="container py-16">
                <div class="max-w-3xl">
                    <!-- Badge -->
                    <?php if ($badge_text) : ?>
                        <div class="mb-6">
                            <div class="inline-block rounded-full px-4 py-2 text-sm bg-primary/20 text-primary-light ring-1 ring-primary/30">
                                <?php echo esc_html($badge_text); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Titre -->
                    <h1 class="section-title text-white mb-6 tracking-tight text-pretty">
                        <?php echo esc_html($heading); ?>
                    </h1>

                    <!-- Description -->
                    <?php if ($description) : ?>
                        <p class="section-description text-gray-200 text-pretty">
                            <?php echo esc_html($description); ?>
                        </p>
                    <?php endif; ?>

                    <!-- CTA Buttons -->
                    <?php if ($primary_button_text || $secondary_button_text) : ?>
                        <div class="mt-10 flex flex-wrap items-center gap-4">
                            <?php if ($primary_button_text && $primary_button_link) : ?>
                                <div x-data="{ btnHover: false }">
                                    <a href="<?php echo esc_url($primary_button_link); ?>"
                                       class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-primary/90 transition-all duration-300"
                                       @mouseenter="btnHover = true"
                                       @mouseleave="btnHover = false">
                                        <span><?php echo esc_html($primary_button_text); ?></span>
                                        <?php get_template_part('template-parts/components/cta-arrow', null, array('hover_state' => 'btnHover', 'arrow_color' => 'white')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($secondary_button_text && $secondary_button_link) : ?>
                                <a href="<?php echo esc_url($secondary_button_link); ?>"
                                   class="text-sm font-semibold text-white hover:text-primary-light transition-colors">
                                    <?php echo esc_html($secondary_button_text); ?>
                                    <span aria-hidden="true" class="ml-2">→</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Version Desktop (Polygone diagonal divise) -->
    <section class="hidden lg:block relative bg-white dark:bg-gray-900 overflow-hidden">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="relative z-10 pt-14 lg:w-full lg:max-w-2xl">

                <?php if ($show_decorative_svg) : ?>
                    <!-- Separateur SVG diagonal -->
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" class="absolute inset-y-0 right-0 h-full w-24 translate-x-1/4 sm:w-32 sm:translate-x-1/3 md:w-48 md:translate-x-1/2 lg:w-96 xl:w-[28rem] 2xl:w-[32rem] transform fill-white dark:fill-gray-900">
                        <polygon points="0,0 90,0 50,100 0,100" />
                    </svg>
                <?php endif; ?>

                <div class="relative px-4 py-20 sm:px-6 sm:py-32 md:py-40 lg:px-8 lg:py-56 lg:pr-0">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">

                        <!-- Badge (optional) -->
                        <?php if ($badge_text) : ?>
                            <div class="hidden sm:mb-10 sm:flex">
                                <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 dark:text-gray-300 ring-1 ring-gray-900/10 dark:ring-white/10 hover:ring-gray-900/20 dark:hover:ring-white/20 transition-all duration-300">
                                    <?php echo esc_html($badge_text); ?>
                                    <?php if ($badge_link) : ?>
                                        <a href="<?php echo esc_url($badge_link); ?>" class="font-semibold whitespace-nowrap text-primary hover:text-primary-dark dark:text-primary dark:hover:text-primary-light transition-colors">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            En savoir plus <span aria-hidden="true">&rarr;</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Titre -->
                        <h1 class="section-title tracking-tight text-pretty">
                            <?php echo esc_html($heading); ?>
                        </h1>

                        <!-- Description -->
                        <?php if ($description) : ?>
                            <p class="section-description mt-8 text-pretty">
                                <?php echo esc_html($description); ?>
                            </p>
                        <?php endif; ?>

                        <!-- CTA Buttons -->
                        <?php if ($primary_button_text || $secondary_button_text) : ?>
                            <div class="mt-10 flex items-center gap-x-6">
                                <?php if ($primary_button_text && $primary_button_link) : ?>
                                    <div x-data="{ btnHover: false }">
                                        <a href="<?php echo esc_url($primary_button_link); ?>"
                                           class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all duration-300 hover:scale-105 active:scale-95"
                                           @mouseenter="btnHover = true"
                                           @mouseleave="btnHover = false">
                                            <span><?php echo esc_html($primary_button_text); ?></span>
                                            <?php get_template_part('template-parts/components/cta-arrow', null, array('hover_state' => 'btnHover', 'arrow_color' => 'white')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if ($secondary_button_text && $secondary_button_link) : ?>
                                    <a href="<?php echo esc_url($secondary_button_link); ?>"
                                       class="text-sm/6 font-semibold text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary transition-colors">
                                        <?php echo esc_html($secondary_button_text); ?>
                                        <span aria-hidden="true">→</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Zone image a droite -->
        <div class="bg-gray-50 dark:bg-gray-800 absolute inset-y-0 right-0 w-2/5 md:w-[45%] lg:w-1/2 overflow-hidden">
            <?php if ($image) : ?>
                <?php
                echo socorif_image(
                    $image,
                    'hero',
                    [
                        'class' => 'w-full h-full object-cover object-center',
                        'alt' => $image['alt'] ?? $heading,
                        'loading' => 'eager',
                        'sizes' => '(max-width: 1024px) 45vw, 50vw'
                    ]
                );
                ?>
            <?php else : ?>
                <!-- Etat vide pour l'editeur -->
                <?php if (is_admin()) : ?>
                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                        <div class="text-center p-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">
                                Veuillez selectionner une image
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </section>

</div>

<?php
// Marquer la fin du bloc
socorif_block_comment_end('hero-split');
