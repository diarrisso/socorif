<?php
/**
 * Template Bloc Page Details
 * Section hero avec transition diagonale entre texte et image
 */

if (!defined('ABSPATH')) exit;

// Identification du bloc dans le code HTML
socorif_block_comment_start('details-page');


// Charger la configuration
require_once __DIR__ . '/config.php';

// Recuperer les champs
$badge_text = socorif_get_field('badge_text');
$badge_link = socorif_get_field('badge_link');
$heading = socorif_get_field('heading', 'Des donnees pour enrichir votre activite');
$description = socorif_get_field('description');
$primary_button = socorif_get_field('primary_button');
$secondary_button = socorif_get_field('secondary_button');
$image = socorif_get_field('image');
$show_decorative_svg = socorif_get_field('show_decorative_svg', true);

// Attributs du bloc pour le wrapper
$block_attrs = isset($block) ? get_block_wrapper_attributes(['class' => 'details-page-block']) : 'class="details-page-block"';
?>

<div <?php echo $block_attrs; ?>>

    <!-- Mobile Version (Hintergrundbild mit Overlay) -->
    <section class="lg:hidden relative bg-gray-900 min-h-[500px] md:min-h-[600px] flex items-center">
        <!-- Hintergrundbild -->
        <?php if ($image && isset($image['url'])) : ?>
            <div class="absolute inset-0 z-0">
                <img src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>"
                     alt="<?php echo esc_attr($image['alt'] ?? $heading); ?>"
                     class="w-full h-full object-cover"
                     loading="eager">
                <!-- Dunkles Overlay für bessere Lesbarkeit -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/40"></div>
            </div>
        <?php else : ?>
            <!-- Fallback Gradient -->
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-secondary via-secondary/80 to-primary/60"></div>
        <?php endif; ?>

        <!-- Inhalt -->
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

                    <!-- Titel -->
                    <h1 class="section-title text-white mb-6">
                        <?php echo esc_html($heading); ?>
                    </h1>

                    <!-- Description -->
                    <?php if ($description) : ?>
                        <p class="section-description text-gray-200">
                            <?php echo esc_html($description); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Buttons -->
                    <?php if ($primary_button || $secondary_button) : ?>
                        <div class="mt-10 flex flex-wrap items-center gap-4">
                            <?php if ($primary_button && !empty($primary_button['url'])) : ?>
                                <a href="<?php echo esc_url($primary_button['url']); ?>"
                                   <?php if (!empty($primary_button['target'])) : ?>target="<?php echo esc_attr($primary_button['target']); ?>"<?php endif; ?>
                                   class="inline-flex items-center rounded-md bg-primary px-4 py-3 text-sm font-semibold text-white shadow-lg hover:bg-primary/90 transition-all duration-300">
                                    <?php echo esc_html($primary_button['title'] ?: 'Commencer'); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($secondary_button && !empty($secondary_button['url'])) : ?>
                                <a href="<?php echo esc_url($secondary_button['url']); ?>"
                                   <?php if (!empty($secondary_button['target'])) : ?>target="<?php echo esc_attr($secondary_button['target']); ?>"<?php endif; ?>
                                   class="text-sm font-semibold text-white hover:text-primary-light transition-colors">
                                    <?php echo esc_html($secondary_button['title'] ?: 'En savoir plus'); ?>
                                    <span aria-hidden="true" class="ml-2">→</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Desktop Version (Polygon Diagonal Split) -->
    <section class="hidden lg:block relative bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 lg:px-8 flex flex-row">
            <div class="relative z-10 pt-14 w-full max-w-2xl order-1">

                <?php if ($show_decorative_svg) : ?>
                    <!-- SVG decoratif - Transition diagonale -->
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" class="absolute inset-y-0 right-0 h-full w-24 translate-x-1/4 sm:w-32 sm:translate-x-1/3 md:w-48 md:translate-x-1/2 lg:w-96 xl:w-[28rem] 2xl:w-[32rem] transform fill-white dark:fill-gray-900">
                        <polygon points="0,0 90,0 50,100 0,100" />
                    </svg>
                <?php endif; ?>

                <!-- Contenu texte -->
                <div class="relative px-6 py-32 sm:py-40 lg:px-8 lg:py-56 lg:pr-0">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">

                        <!-- Badge -->
                        <?php if ($badge_text) : ?>
                            <div class="hidden sm:mb-10 sm:flex">
                                <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 dark:text-gray-400 ring-1 ring-gray-900/10 dark:ring-gray-100/10">
                                    <span><?php echo esc_html($badge_text); ?></span>
                                    <?php if ($badge_link && !empty($badge_link['url'])) : ?>
                                        <a href="<?php echo esc_url($badge_link['url']); ?>"
                                           <?php if (!empty($badge_link['target'])) : ?>target="<?php echo esc_attr($badge_link['target']); ?>"<?php endif; ?>
                                           class="ml-2 font-semibold text-primary hover:text-primary/90">
                                            <?php echo esc_html($badge_link['title'] ?: 'En savoir plus'); ?>
                                            <span aria-hidden="true" class="ml-1">&rarr;</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Titre -->
                        <h1 class="section-title">
                            <?php echo esc_html($heading); ?>
                        </h1>

                        <!-- Description -->
                        <?php if ($description) : ?>
                            <p class="section-description mt-8">
                                <?php echo esc_html($description); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Buttons -->
                        <?php if ($primary_button || $secondary_button) : ?>
                            <div class="mt-10 flex items-center gap-x-6">
                                <?php if ($primary_button && !empty($primary_button['url'])) : ?>
                                    <a href="<?php echo esc_url($primary_button['url']); ?>"
                                       <?php if (!empty($primary_button['target'])) : ?>target="<?php echo esc_attr($primary_button['target']); ?>"<?php endif; ?>
                                       class="rounded-md bg-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                                        <?php echo esc_html($primary_button['title'] ?: 'Commencer'); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($secondary_button && !empty($secondary_button['url'])) : ?>
                                    <a href="<?php echo esc_url($secondary_button['url']); ?>"
                                       <?php if (!empty($secondary_button['target'])) : ?>target="<?php echo esc_attr($secondary_button['target']); ?>"<?php endif; ?>
                                       class="text-sm font-semibold text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary">
                                        <?php echo esc_html($secondary_button['title'] ?: 'En savoir plus'); ?>
                                        <span aria-hidden="true" class="ml-2">→</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- Bild rechts -->
            <div class="bg-gray-50 dark:bg-gray-800 absolute inset-y-0 right-0 w-2/5 md:w-[45%] lg:w-1/2">
                <?php if ($image && isset($image['url'])) : ?>
                    <img class="w-full h-full object-cover"
                         src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>"
                         alt="<?php echo esc_attr($image['alt'] ?? $heading); ?>"
                         loading="eager" />
                <?php else : ?>
                    <!-- Fallback gradient -->
                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20"></div>
                <?php endif; ?>
            </div>
        </div>
    </section>

</div>

<?php
// Block-Ende markieren
socorif_block_comment_end('details-page');
