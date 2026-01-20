<?php
/**
 * Statistik-Zähler Komponente
 *
 * @param array $args {
 *     @type string $number     Statistik-Zahl
 *     @type string $suffix     Suffix (+, %, etc.)
 *     @type string $label      Statistik-Label
 *     @type string $variant    Farbvariante (default|white|primary)
 *     @type array  $classes    Zusätzliche Klassen
 * }
 */

if (!defined('ABSPATH')) exit;

$defaults = [
    'number' => '0',
    'suffix' => '',
    'label' => '',
    'variant' => 'default',
    'classes' => [],
];

$args = wp_parse_args($args ?? [], $defaults);

if (empty($args['number'])) return;

$variant_classes = [
    'default' => 'text-white',
    'white' => 'dark:text-white',
    'primary' => 'text-primary',
];

$text_color = $variant_classes[$args['variant']] ?? $variant_classes['default'];

?>

<div class="text-center py-4">
    <div class="text-4xl sm:text-5xl md:text-6xl font-bold mb-2 <?php echo esc_attr($text_color); ?> transition-all duration-300">
        <span class="stat-number" data-count="<?php echo esc_attr($args['number']); ?>">
            <?php echo esc_html($args['number']); ?>
        </span><?php echo esc_html($args['suffix']); ?>
    </div>

    <?php if ($args['label']): ?>
        <div class="text-base md:text-lg opacity-90 <?php echo esc_attr($text_color); ?>">
            <?php echo esc_html($args['label']); ?>
        </div>
    <?php endif; ?>
</div>
