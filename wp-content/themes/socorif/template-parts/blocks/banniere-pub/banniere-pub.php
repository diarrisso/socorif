<?php
/**
 * Block: Banniere Publicitaire
 *
 * Promotional banner with image, text and CTA button
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

// Get field values
$subtitle = get_sub_field('subtitle') ?: '';
$title = get_sub_field('title') ?: '';
$image = get_sub_field('image');
$button = get_sub_field('button');
$bg_color = get_sub_field('bg_color') ?: 'primary';
$layout = get_sub_field('layout') ?: 'vertical';

// Background color classes
$bg_classes = [
    'primary' => 'bg-primary',
    'secondary' => 'bg-secondary',
    'dark' => 'bg-gray-900',
];
$bg_class = $bg_classes[$bg_color] ?? 'bg-primary';
?>

<section class="banniere-pub py-12 lg:py-16 <?php echo esc_attr($bg_class); ?>">
    <div class="container mx-auto px-4">
        <?php if ($layout === 'horizontal') : ?>
            <!-- Horizontal Layout -->
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
                <!-- Text Content -->
                <div class="flex-1 text-center lg:text-left">
                    <?php if ($subtitle) : ?>
                        <p class="text-white/80 text-sm lg:text-base mb-4 font-light">
                            <?php echo esc_html($subtitle); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($title) : ?>
                        <h2 class="text-white text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold leading-tight mb-6 uppercase">
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($button && !empty($button['url'])) : ?>
                        <a href="<?php echo esc_url($button['url']); ?>"
                           class="inline-block bg-white text-primary hover:bg-gray-100 px-8 py-4 font-semibold uppercase tracking-wide transition-colors duration-300"
                           <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                            <?php echo esc_html($button['title'] ?: 'Contactez-nous'); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Image -->
                <?php if ($image) : ?>
                    <div class="flex-1 w-full lg:w-auto">
                        <img src="<?php echo esc_url($image['url']); ?>"
                             alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
                             class="w-full h-auto rounded-lg shadow-2xl"
                             loading="lazy">
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <!-- Vertical Layout (default - like mockup) -->
            <div class="max-w-md mx-auto text-center">
                <?php if ($subtitle) : ?>
                    <p class="text-white/80 text-sm mb-4 font-light">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 class="text-white text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight mb-6 uppercase">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($image) : ?>
                    <div class="mb-8">
                        <img src="<?php echo esc_url($image['url']); ?>"
                             alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
                             class="w-full h-auto rounded-lg shadow-xl"
                             loading="lazy">
                    </div>
                <?php endif; ?>

                <?php if ($button && !empty($button['url'])) : ?>
                    <a href="<?php echo esc_url($button['url']); ?>"
                       class="inline-block w-full bg-white text-primary hover:bg-gray-100 px-8 py-4 font-semibold uppercase tracking-wide transition-colors duration-300"
                       <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                        <?php echo esc_html($button['title'] ?: 'Contactez-moi'); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
