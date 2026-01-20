<?php
/**
 * Section CTA Block Template
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('section-cta');


// Felder abrufen
$image = socorif_get_field('image');
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$content = socorif_get_field('content');
$button = socorif_get_field('button');
$image_position = socorif_get_field('image_position', 'left');
$bg_color = socorif_get_field('bg_color', 'gray-50');

// Text color based on background
$is_dark_bg = $bg_color === 'secondary-dark';
$text_color = $is_dark_bg ? 'text-white' : '';
$text_muted = $is_dark_bg ? 'text-gray-300' : 'text-gray-600';

// Section-Klassen erstellen
$section_classes = socorif_merge_classes(
    'section-cta-block section',
    'bg-' . $bg_color,
    $is_dark_bg ? '' : 'dark:bg-gray-900'
);

// Order classes for image position
$image_order = $image_position === 'right' ? 'lg:order-2' : '';
$content_order = $image_position === 'right' ? 'lg:order-1' : '';
?>

<section class="<?php echo esc_attr($section_classes); ?>">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">

            <!-- Image -->
            <div class="<?php echo esc_attr($image_order); ?>">
                <?php if ($image) : ?>
                    <div class="rounded-3xl overflow-hidden shadow-2xl hover:shadow-primary/20 transition-all duration-300 group">
                        <?php echo socorif_image($image, 'large', ['class' => 'w-full h-auto group-hover:scale-105 transition-transform duration-500']); ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl"></div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Inhalt -->
            <div class="<?php echo esc_attr($content_order); ?>">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 class="section-title <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-3 md:mb-4">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($content) : ?>
                    <div class="section-description <?php echo esc_attr($text_muted); ?> <?php echo $is_dark_bg ? '' : 'dark:text-gray-300'; ?> mb-4 md:mb-6">
                        <?php echo wp_kses_post($content); ?>
                    </div>
                <?php endif; ?>

                <?php if ($button) : ?>
                    <div x-data="{ btnHover: false }">
                        <a href="<?php echo esc_url($button['url']); ?>"
                           class="mt-10 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all duration-300 hover:scale-105 active:scale-95 inline-flex items-center gap-2"
                           @mouseenter="btnHover = true"
                           @mouseleave="btnHover = false"
                           <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                            <span><?php echo esc_html($button['title']); ?></span>
                            <?php get_template_part('template-parts/components/cta-arrow', null, array('hover_state' => 'btnHover', 'arrow_color' => 'white')); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('section-cta');
