<?php
/**
 * Decorative Background Component
 *
 * Professional UX/UI decorative background with SVG patterns
 * Supports multiple variants for different block types
 *
 * @package Ossenberg_Engels
 *
 * @param array $args {
 *     Optional. Configuration arguments.
 *     @type string $variant     Pattern variant: 'dots', 'grid', 'waves', 'radial'. Default 'grid'.
 *     @type string $color       Color scheme: 'primary', 'secondary', 'neutral'. Default 'neutral'.
 *     @type string $opacity     Opacity level: 'light', 'medium', 'strong'. Default 'light'.
 *     @type string $position    Position: 'top', 'center', 'bottom'. Default 'top'.
 *     @type bool   $animated    Enable subtle animation. Default false.
 *     @type string $class       Additional CSS classes. Default ''.
 * }
 */

$args = wp_parse_args($args ?? [], [
    'variant'  => 'grid',
    'color'    => 'neutral',
    'opacity'  => 'light',
    'position' => 'top',
    'animated' => false,
    'class'    => '',
]);

$pattern_id = 'pattern-' . uniqid();
$gradient_id = 'gradient-' . uniqid();

$color_schemes = [
    'primary' => [
        'stroke' => 'stroke-red-200 dark:stroke-red-800',
        'fill'   => 'fill-red-50 dark:fill-red-900/30',
    ],
    'secondary' => [
        'stroke' => 'stroke-blue-200 dark:stroke-blue-800',
        'fill'   => 'fill-blue-50 dark:fill-blue-900/30',
    ],
    'neutral' => [
        'stroke' => 'stroke-gray-200 dark:stroke-gray-800',
        'fill'   => 'fill-gray-50 dark:fill-gray-800/50',
    ],
];

$opacity_levels = [
    'light'  => 'opacity-30',
    'medium' => 'opacity-50',
    'strong' => 'opacity-70',
];

$position_classes = [
    'top'    => 'top-0',
    'center' => 'top-1/2 -translate-y-1/2',
    'bottom' => 'bottom-0',
];

$colors = $color_schemes[$args['color']] ?? $color_schemes['neutral'];
$opacity_class = $opacity_levels[$args['opacity']] ?? $opacity_levels['light'];
$position_class = $position_classes[$args['position']] ?? $position_classes['top'];
$animation_class = $args['animated'] ? 'animate-pulse-slow' : '';

?>

<div class="absolute inset-0 -z-10 overflow-hidden <?php echo esc_attr($args['class']); ?>" aria-hidden="true">

    <?php if ($args['variant'] === 'grid') : ?>
        <!-- Grid Pattern -->
        <svg class="absolute <?php echo esc_attr($position_class); ?> left-[max(50%,25rem)] h-[64rem] w-[128rem] -translate-x-1/2 mask-[radial-gradient(64rem_64rem_at_top,white,transparent)] <?php echo esc_attr($colors['stroke']); ?> <?php echo esc_attr($animation_class); ?>">
            <defs>
                <pattern id="<?php echo esc_attr($pattern_id); ?>" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                    <path d="M100 200V.5M.5 .5H200" fill="none" />
                </pattern>
            </defs>
            <svg x="50%" y="-1" class="overflow-visible <?php echo esc_attr($colors['fill']); ?>">
                <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z" stroke-width="0" />
            </svg>
            <rect width="100%" height="100%" fill="url(#<?php echo esc_attr($pattern_id); ?>)" stroke-width="0" />
        </svg>

    <?php elseif ($args['variant'] === 'dots') : ?>
        <!-- Dot Pattern -->
        <svg class="absolute <?php echo esc_attr($position_class); ?> left-1/2 -translate-x-1/2 h-full w-full <?php echo esc_attr($opacity_class); ?> <?php echo esc_attr($animation_class); ?>">
            <defs>
                <pattern id="<?php echo esc_attr($pattern_id); ?>" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                    <circle cx="20" cy="20" r="2" class="<?php echo esc_attr($colors['fill']); ?>" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#<?php echo esc_attr($pattern_id); ?>)" />
        </svg>

    <?php elseif ($args['variant'] === 'waves') : ?>
        <!-- Wave Pattern -->
        <svg class="absolute <?php echo esc_attr($position_class); ?> left-0 w-full h-64 <?php echo esc_attr($opacity_class); ?> <?php echo esc_attr($animation_class); ?>" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="<?php echo esc_attr($colors['fill']); ?>" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
        </svg>

    <?php elseif ($args['variant'] === 'radial') : ?>
        <!-- Radial Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-gray-100 dark:to-gray-900 <?php echo esc_attr($opacity_class); ?> <?php echo esc_attr($animation_class); ?>"></div>
        <svg class="absolute <?php echo esc_attr($position_class); ?> left-1/2 -translate-x-1/2 h-full w-full">
            <defs>
                <radialGradient id="<?php echo esc_attr($gradient_id); ?>">
                    <stop offset="0%" class="stop-color-gray-200 dark:stop-color-gray-800" stop-opacity="0.3" />
                    <stop offset="100%" stop-opacity="0" />
                </radialGradient>
            </defs>
            <circle cx="50%" cy="30%" r="40%" fill="url(#<?php echo esc_attr($gradient_id); ?>)" />
        </svg>

    <?php endif; ?>

</div>
