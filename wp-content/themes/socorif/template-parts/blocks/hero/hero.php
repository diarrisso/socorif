<?php
/**
 * Hero Block Template
 * Zeigt einen Hero-Bereich mit Hintergrundbild, Titel und CTA-Button
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('hero');

// Felder abrufen (funktioniert mit ACF Blocks und Flexible Content)
$background_image = socorif_get_field('background_image');
$overlay_opacity = socorif_get_field('overlay_opacity', 50);
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$description = socorif_get_field('description');
$height = socorif_get_field('height', 'large');
$text_align = socorif_get_field('text_align', 'center');

// Höhen-Klassen - Mobile-First Responsive
$height_classes = [
    'auto' => 'py-16 md:py-24 lg:py-32',
    'screen' => 'min-h-[60vh] md:min-h-[80vh] lg:min-h-screen',
    'large' => 'min-h-[50vh] md:min-h-[70vh] lg:min-h-[80vh]',
    'medium' => 'min-h-[40vh] md:min-h-[50vh] lg:min-h-[60vh]',
];

// Ausrichtungs-Klassen
$align_classes = [
    'left' => 'text-left items-start',
    'center' => 'text-center items-center',
];

// Section-Klassen zusammenstellen
$section_classes = socorif_merge_classes(
    'hero-block relative flex flex-col justify-center overflow-hidden',
    $height_classes[$height] ?? $height_classes['large'],
    $align_classes[$text_align] ?? $align_classes['center']
);
?>

<section class="<?php echo esc_attr($section_classes); ?>">

    <?php if ($background_image) : ?>
        <!-- Hintergrundbild -->
        <div class="absolute inset-0 overflow-hidden">
            <?php echo socorif_image($background_image, 'hero', [
                'class' => 'w-full h-full object-cover object-center scale-105 sm:scale-100',
                'sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 100vw, 1920px'
            ]); ?>
        </div>

        <!-- Overlay mit Farbverlauf -->
        <div class="absolute inset-0 bg-gradient-to-br from-secondary-dark/<?php echo esc_attr($overlay_opacity); ?> via-secondary-dark/<?php echo esc_attr(max(30, $overlay_opacity - 20)); ?> to-black/<?php echo esc_attr($overlay_opacity); ?>"></div>
    <?php else : ?>
        <!-- Fallback: Gradient ohne Bild - Light/Dark Mode -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-100 via-gray-50 to-white dark:from-secondary-dark dark:via-secondary dark:to-secondary-dark"></div>
    <?php endif; ?>

    <!-- Inhalt -->
    <div class="container relative z-10 px-4 py-12 md:py-16 lg:py-20">
        <div class="max-w-3xl <?php echo $text_align === 'center' ? 'mx-auto' : ''; ?>">

            <?php if ($subtitle) : ?>
                <p class="text-primary font-semibold uppercase tracking-wider text-xs md:text-sm mb-4 md:mb-6">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h1 class="section-title <?php echo $background_image ? 'text-white' : ''; ?> mb-4 md:mb-6 leading-tight">
                    <?php echo esc_html($title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($description) : ?>
                <p class="section-description <?php echo $background_image ? 'text-gray-200' : ''; ?> mb-6 md:mb-8 max-w-2xl <?php echo $text_align === 'center' ? 'mx-auto' : ''; ?>">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>


        </div>
    </div>

</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('hero');
