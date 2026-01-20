<?php
/**
 * Hero Section Block Template
 *
 * Service-Detail Hero mit Hintergrundbild, Titel und Highlights
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('hero-section');


// Felder abrufen
$background_image = socorif_get_field('background_image');
$overlay_opacity = socorif_get_field('overlay_opacity', 60);
$breadcrumb = socorif_get_field('breadcrumb');
$title = socorif_get_field('title');
$subtitle = socorif_get_field('subtitle');
$description = socorif_get_field('description');
$key_features = socorif_get_field('key_features');
$cta_button = socorif_get_field('cta_button');
$height = socorif_get_field('height', 'large');

// Automatisches Breadcrumb generieren, wenn nicht manuell gesetzt
if (empty($breadcrumb) || !is_array($breadcrumb)) {
    $breadcrumb = socorif_generate_breadcrumb();
}

// Höhen-Klassen - Mobile-first responsive
$height_classes = [
    'medium' => 'min-h-[50vh] md:min-h-[55vh] lg:min-h-[60vh]',
    'large' => 'min-h-[60vh] md:min-h-[70vh] lg:min-h-[75vh]',
    'xlarge' => 'min-h-[70vh] md:min-h-[80vh] lg:min-h-[90vh]',
];

// Icon SVG paths
$icon_paths = [
    'check' => 'M5 13l4 4L19 7',
    'star' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
    'shield' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
    'clock' => 'M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z',
    'users' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm14 10v-2a4 4 0 0 0-3-3.87m-4-12a4 4 0 0 1 0 7.75',
    'award' => 'M12 15l-3.5 2 1-4-3-2.5 4-.5L12 6l1.5 4 4 .5-3 2.5 1 4z',
];

// Section-Klassen erstellen
$section_classes = socorif_merge_classes(
    'hero-section-block relative flex flex-col justify-center overflow-hidden',
    $height_classes[$height] ?? $height_classes['large']
);

// Block-Wrapper
if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    echo '<section ' . $wrapper_attrs . '>';
} else {
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>

    <?php if ($background_image) : ?>
        <!-- Hintergrundbild -->
        <div class="absolute inset-0 overflow-hidden">
            <?php echo socorif_image($background_image, 'hero', [
                'class' => 'w-full h-full object-cover object-center scale-105 sm:scale-100',
                'sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 100vw, 1920px'
            ]); ?>
        </div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-secondary-dark/<?php echo esc_attr($overlay_opacity); ?> via-secondary-dark/<?php echo esc_attr(max(40, $overlay_opacity - 20)); ?> to-black/<?php echo esc_attr(min(100, $overlay_opacity + 10)); ?>"></div>
    <?php else : ?>
        <!-- Fallback: Gradient ohne Bild -->
        <div class="absolute inset-0 bg-gradient-to-br from-secondary-dark via-secondary to-secondary-dark"></div>
    <?php endif; ?>

    <!-- Inhalt -->
    <div class="container relative z-10 px-4 py-16 md:py-20 lg:py-24">
        <div class="max-w-4xl">

            <?php if ($breadcrumb && is_array($breadcrumb)) : ?>
                <!-- Breadcrumb Navigation -->
                <nav class="mb-4 md:mb-6" aria-label="Breadcrumb">
                    <ol class="flex flex-wrap items-center gap-2 text-sm md:text-base">
                        <?php
                        $breadcrumb_count = count($breadcrumb);
                        foreach ($breadcrumb as $index => $item) :
                            $is_last = ($index === $breadcrumb_count - 1);
                            $label = $item['label'] ?? '';
                            $link = $item['link'] ?? '';

                            if (!$label) continue;
                        ?>
                            <li class="flex items-center gap-2">
                                <?php if ($link && !$is_last) : ?>
                                    <a href="<?php echo esc_url($link); ?>"
                                       class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium cursor-pointer">
                                        <?php echo esc_html($label); ?>
                                    </a>
                                <?php else : ?>
                                    <span class="<?php echo $is_last ? 'text-primary font-semibold' : 'text-gray-300'; ?>">
                                        <?php echo esc_html($label); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (!$is_last) : ?>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h1 class="page-title text-white mb-3 md:mb-4">
                    <?php echo esc_html($title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($subtitle) : ?>
                <p class="text-lg md:text-xl lg:text-2xl text-primary font-semibold mb-4 md:mb-6">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <?php if ($description) : ?>
                <p class="section-description text-gray-200 mb-6 md:mb-8 max-w-2xl leading-relaxed">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>

            <?php if ($key_features && is_array($key_features)) : ?>
                <!-- Key Features Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-6 md:mb-8">
                    <?php foreach ($key_features as $feature) :
                        $icon = $feature['icon'] ?? 'check';
                        $text = $feature['text'] ?? '';
                        if (!$text) continue;
                    ?>
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md rounded-lg px-4 py-3 border border-white/20 hover:bg-white/15 transition-all duration-300 group">
                            <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center shadow-lg shadow-primary/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <?php if (isset($icon_paths[$icon])) : ?>
                                        <path d="<?php echo esc_attr($icon_paths[$icon]); ?>"/>
                                    <?php endif; ?>
                                </svg>
                            </div>
                            <span class="text-white font-medium text-sm md:text-base">
                                <?php echo esc_html($text); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($cta_button && !empty($cta_button['url'])) : ?>
                <div class="flex flex-wrap gap-4">
                    <a href="<?php echo esc_url($cta_button['url']); ?>"
                       class="btn btn-primary rounded-full text-base md:text-lg px-6 py-3 md:px-8 md:py-4 inline-flex items-center gap-3 shadow-xl shadow-primary/40 hover:shadow-2xl hover:shadow-primary/50 hover:scale-105 active:scale-95 transition-all duration-300 bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary border-2 border-white/20 backdrop-blur-sm group cursor-pointer"
                       <?php echo !empty($cta_button['target']) ? 'target="' . esc_attr($cta_button['target']) . '"' : ''; ?>>
                        <span class="font-semibold"><?php echo esc_html($cta_button['title']); ?></span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('hero-section');
