<?php
/**
 * CTA Split Block Template
 *
 * Moderner Call-to-Action mit 3 Layout-Optionen
 */

if (!defined('ABSPATH')) {
    exit;
}

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('cta-split');

// ============================================
// Block Daten abrufen
// ============================================

// Inhalt
$image = socorif_get_field('image');
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$description = socorif_get_field('description');
$button = socorif_get_field('button');
$button_secondary = socorif_get_field('button_secondary');

// Layout
$layout_type = socorif_get_field('layout_type') ?: 'split';
$image_position = socorif_get_field('image_position') ?: 'left';
$image_width = socorif_get_field('image_width') ?: '1/3';
$content_alignment = socorif_get_field('content_alignment') ?: 'left';
$container_width = socorif_get_field('container_width') ?: 'default';
$show_svg_circle = socorif_get_field('show_svg_circle') !== false;

// Styling
$accent_color = socorif_get_field('accent_color') ?: 'primary';
$custom_accent = socorif_get_field('custom_accent');
$bg_color = socorif_get_field('bg_color') ?: 'white';
$overlay_opacity = socorif_get_field('overlay_opacity') ?: 60;
$show_blur = socorif_get_field('show_blur') !== false;

// Standard-Felder
$spacing = socorif_get_field('spacing') ?: [];
$background = socorif_get_field('background') ?: [];
$animation = socorif_get_field('animation') ?: [];

// ============================================
// Classes und Styles erstellen
// ============================================

$spacing_classes = socorif_build_spacing_classes($spacing);

// Accent Color Classes
$accent_classes = match($accent_color) {
    'primary' => 'text-primary',
    'secondary' => 'text-secondary',
    'indigo' => 'text-yellow-500 dark:text-yellow-400',
    'blue' => 'text-blue-600 dark:text-blue-400',
    'purple' => 'text-purple-600 dark:text-purple-400',
    'pink' => 'text-pink-600 dark:text-pink-400',
    'red' => 'text-red-600 dark:text-red-400',
    'custom' => '',
};

$accent_style = ($accent_color === 'custom' && $custom_accent) ? 'color: ' . esc_attr($custom_accent) : '';

// Background Color Classes
$bg_classes = match($bg_color) {
    'white' => 'bg-white dark:bg-gray-900',
    'gray-50' => 'bg-gray-50 dark:bg-gray-900',
    'gray-100' => 'bg-gray-100 dark:bg-gray-800',
    'secondary' => 'bg-secondary dark:bg-secondary-dark',
    default => 'bg-white dark:bg-gray-900',
};

$is_dark_bg = $bg_color === 'secondary';

// Container Width Classes
$container_classes = match($container_width) {
    'wide' => 'container',
    'full' => 'max-w-none',
    default => 'container',
};

// Section Classes
$section_classes = [
    'cta-split-block',
    'relative',
    'isolate',
    $bg_classes,
    $spacing_classes,
];

if ($layout_type === 'background') {
    $section_classes[] = 'overflow-hidden';
}

if (!empty($animation['enabled'])) {
    $section_classes[] = 'animate-on-scroll';
    $section_classes[] = 'animation-' . ($animation['type'] ?? 'fade-up');
}

// Wrapper Attributes - funktioniert für beide Kontexte
if (isset($block)) {
    $wrapper_attributes = socorif_get_block_wrapper_attributes($block, implode(' ', $section_classes));
    echo '<div ' . $wrapper_attributes . '>';
} else {
    echo '<div class="' . esc_attr(implode(' ', $section_classes)) . '">';
}
?>

    <?php if (!empty($background['enabled'])): ?>
        <?php get_template_part('template-parts/components/background', null, $background); ?>
    <?php endif; ?>

    <?php if ($layout_type === 'split'): ?>
        <!-- ============================================ -->
        <!-- SPLIT LAYOUT -->
        <!-- ============================================ -->

        <?php
        // Image Width Classes
        $image_width_class = match($image_width) {
            '1/3' => 'md:w-1/3 lg:w-1/3',
            '1/2' => 'md:w-1/2 lg:w-1/2',
            '2/3' => 'md:w-2/3 lg:w-2/3',
            default => 'md:w-1/3 lg:w-1/2',
        };

        $content_width_class = match($image_width) {
            '1/3' => 'md:w-2/3 lg:w-2/3',
            '1/2' => 'md:w-1/2 lg:w-1/2',
            '2/3' => 'md:w-1/3 lg:w-1/3',
            default => 'md:w-2/3 lg:w-1/2',
        };
        ?>

        <div class="relative">
            <!-- Image Section -->
            <div class="relative h-80 overflow-hidden <?php echo esc_attr($accent_color === 'custom' ? 'bg-gray-600' : 'bg-' . $accent_color . '-600'); ?> md:absolute <?php echo $image_position === 'right' ? 'md:right-0' : 'md:left-0'; ?> md:h-full <?php echo esc_attr($image_width_class); ?>">
                <?php if ($image && isset($image['url'])): ?>
                    <img
                        src="<?php echo esc_url($image['url']); ?>"
                        alt="<?php echo esc_attr($image['alt'] ?? $title); ?>"
                        class="size-full object-cover"
                        style="mix-blend-mode: multiply; filter: saturate(0); opacity: <?php echo esc_attr($overlay_opacity / 100); ?>;"
                        loading="lazy"
                    />
                <?php endif; ?>

                <?php if ($show_blur): ?>
                    <!-- Blur Effect SVG -->
                    <svg viewBox="0 0 926 676" aria-hidden="true" class="absolute -bottom-24 left-24 w-231.5 transform-gpu blur-[118px]">
                        <path d="m254.325 516.708-90.89 158.331L0 436.427l254.325 80.281 163.691-285.15c1.048 131.759 36.144 345.144 168.149 144.613C751.171 125.508 707.17-93.823 826.603 41.15c95.546 107.978 104.766 294.048 97.432 373.585L685.481 297.694l16.974 360.474-448.13-141.46Z" fill="url(#blur-gradient-<?php echo uniqid(); ?>)" fill-opacity=".4" />
                        <defs>
                            <linearGradient id="blur-gradient-<?php echo uniqid(); ?>" x1="926.392" x2="-109.635" y1=".176" y2="321.024" gradientUnits="userSpaceOnUse">
                                <stop stop-color="<?php echo $accent_color === 'custom' ? esc_attr($custom_accent) : '#776FFF'; ?>" />
                                <stop offset="1" stop-color="#FF4694" />
                            </linearGradient>
                        </defs>
                    </svg>
                <?php endif; ?>
            </div>

            <!-- Content Section -->
            <div class="relative mx-auto <?php echo esc_attr($container_classes); ?> py-24 sm:py-32 lg:px-8 lg:py-40">
                <div class="pr-6 pl-6 <?php echo $image_position === 'right' ? 'md:mr-auto' : 'md:ml-auto'; ?> <?php echo esc_attr($content_width_class); ?> md:pl-16 lg:pr-0 lg:pl-24 xl:pl-32">

                    <?php if ($subtitle): ?>
                        <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm <?php echo esc_attr($accent_classes); ?>" <?php if ($accent_style) echo 'style="' . $accent_style . '"'; ?>>
                            <?php echo esc_html($subtitle); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($title): ?>
                        <h2 class="section-title <?php echo $is_dark_bg ? 'text-white' : ''; ?>">
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($description): ?>
                        <p class="section-description mt-6 <?php echo $is_dark_bg ? 'text-gray-300' : ''; ?>">
                            <?php echo nl2br(esc_html($description)); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($button || $button_secondary): ?>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <?php if ($button): ?>
                                <a
                                    href="<?php echo esc_url($button['url']); ?>"
                                    class="inline-flex rounded-md px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs transition-all duration-200 cursor-pointer <?php echo $accent_color === 'custom' ? 'hover:opacity-90' : 'bg-' . $accent_color . '-600 hover:bg-' . $accent_color . '-500 focus-visible:outline-' . $accent_color . '-600'; ?>"
                                    <?php if (!empty($button['target'])): ?>target="<?php echo esc_attr($button['target']); ?>"<?php endif; ?>
                                    <?php if ($accent_color === 'custom' && $custom_accent): ?>style="background-color: <?php echo esc_attr($custom_accent); ?>;"<?php endif; ?>
                                >
                                    <?php echo esc_html($button['title']); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($button_secondary): ?>
                                <a
                                    href="<?php echo esc_url($button_secondary['url']); ?>"
                                    class="inline-flex rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-xs transition-all duration-200 cursor-pointer <?php echo $is_dark_bg ? 'text-white bg-white/10 hover:bg-white/20 border border-white/30' : 'text-gray-900 bg-white/10 dark:bg-white/10 hover:bg-white/20 dark:hover:bg-white/20 border border-gray-900/30 dark:border-white/30'; ?>"
                                    <?php if (!empty($button_secondary['target'])): ?>target="<?php echo esc_attr($button_secondary['target']); ?>"<?php endif; ?>
                                >
                                    <?php echo esc_html($button_secondary['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    <?php elseif ($layout_type === 'centered'): ?>
        <!-- ============================================ -->
        <!-- CENTERED LAYOUT -->
        <!-- ============================================ -->

        <div class="px-6 py-24 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">

                <?php if ($subtitle): ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm <?php echo esc_attr($accent_classes); ?>" <?php if ($accent_style) echo 'style="' . $accent_style . '"'; ?>>
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 class="section-title <?php echo $is_dark_bg ? 'text-white' : ''; ?> <?php echo $subtitle ? 'mt-2' : ''; ?>">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="section-description mx-auto mt-6 max-w-xl <?php echo $is_dark_bg ? 'text-gray-300' : ''; ?>">
                        <?php echo nl2br(esc_html($description)); ?>
                    </p>
                <?php endif; ?>

                <?php if ($button || $button_secondary): ?>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <?php if ($button): ?>
                            <a
                                href="<?php echo esc_url($button['url']); ?>"
                                class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-100 transition-all duration-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white dark:bg-white/15 dark:text-white dark:shadow-none dark:ring-1 dark:ring-inset dark:ring-white/5 dark:hover:bg-white/20 dark:focus-visible:outline-white cursor-pointer"
                                <?php if (!empty($button['target'])): ?>target="<?php echo esc_attr($button['target']); ?>"<?php endif; ?>
                            >
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($button_secondary): ?>
                            <a
                                href="<?php echo esc_url($button_secondary['url']); ?>"
                                class="text-sm/6 font-semibold text-gray-900 hover:text-gray-600 transition-colors dark:text-white dark:hover:text-gray-300 cursor-pointer"
                                <?php if (!empty($button_secondary['target'])): ?>target="<?php echo esc_attr($button_secondary['target']); ?>"<?php endif; ?>
                            >
                                <?php echo esc_html($button_secondary['title']); ?> <span aria-hidden="true">→</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php if ($show_svg_circle): ?>
            <!-- SVG Circle Decoration -->
            <svg viewBox="0 0 1024 1024" aria-hidden="true" class="absolute top-1/2 left-1/2 -z-10 size-256 -translate-x-1/2 mask-[radial-gradient(closest-side,white,transparent)]">
                <circle r="512" cx="512" cy="512" fill="url(#svg-gradient-<?php echo uniqid(); ?>)" fill-opacity="0.7" />
                <defs>
                    <radialGradient id="svg-gradient-<?php echo uniqid(); ?>">
                        <stop stop-color="<?php echo $accent_color === 'custom' ? esc_attr($custom_accent) : '#7775D6'; ?>" />
                        <stop offset="1" stop-color="#E935C1" />
                    </radialGradient>
                </defs>
            </svg>
        <?php endif; ?>

    <?php else: ?>
        <!-- ============================================ -->
        <!-- BACKGROUND LAYOUT -->
        <!-- ============================================ -->

        <?php if ($image && isset($image['url'])): ?>
            <!-- Hintergrundbild -->
            <div class="absolute inset-0 -z-10">
                <img
                    src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt'] ?? $title); ?>"
                    class="size-full object-cover"
                    loading="lazy"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/50 to-gray-900/30"></div>
            </div>
        <?php endif; ?>

        <div class="relative px-6 py-24 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">

                <?php if ($subtitle): ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm <?php echo esc_attr($accent_classes); ?> text-white" <?php if ($accent_style) echo 'style="' . $accent_style . '"'; ?>>
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 class="section-title text-white <?php echo $subtitle ? 'mt-2' : ''; ?>">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="section-description mx-auto mt-6 max-w-xl text-gray-200">
                        <?php echo nl2br(esc_html($description)); ?>
                    </p>
                <?php endif; ?>

                <?php if ($button || $button_secondary): ?>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <?php if ($button): ?>
                            <a
                                href="<?php echo esc_url($button['url']); ?>"
                                class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-100 transition-all duration-200 cursor-pointer"
                                <?php if (!empty($button['target'])): ?>target="<?php echo esc_attr($button['target']); ?>"<?php endif; ?>
                            >
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($button_secondary): ?>
                            <a
                                href="<?php echo esc_url($button_secondary['url']); ?>"
                                class="text-sm/6 font-semibold text-white hover:text-gray-200 transition-colors cursor-pointer"
                                <?php if (!empty($button_secondary['target'])): ?>target="<?php echo esc_attr($button_secondary['target']); ?>"<?php endif; ?>
                            >
                                <?php echo esc_html($button_secondary['title']); ?> <span aria-hidden="true">→</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    <?php endif; ?>

</div>

<?php
// Block-Ende markieren
socorif_block_comment_end('cta-split');
