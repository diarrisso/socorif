<?php
/**
 * Vorteil-Karte Komponente
 *
 * @param array $args {
 *     @type string $icon        Icon-Name
 *     @type string $title       Vorteilstitel
 *     @type string $description Vorteilsbeschreibung
 *     @type array  $classes     Zusätzliche Klassen
 * }
 */

if (!defined('ABSPATH')) exit;

$defaults = [
    'icon' => 'check',
    'title' => '',
    'description' => '',
    'classes' => [],
];

$args = wp_parse_args($args ?? [], $defaults);

if (empty($args['title'])) return;

$base_classes = 'bg-white dark:bg-gray-900 rounded-3xl p-5 md:p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 hover:scale-105 active:scale-95 min-h-[180px] flex flex-col cursor-pointer';
$custom_classes = is_array($args['classes']) ? implode(' ', $args['classes']) : $args['classes'];

$classes = trim("$base_classes $custom_classes");

?>

<div class="<?php echo esc_attr($classes); ?>">
    <div class="text-primary mb-3 md:mb-4 flex-shrink-0 transition-transform duration-300 hover:scale-110 hover:rotate-6">
        <?php get_template_part('template-parts/components/icon', null, [
            'name' => $args['icon'],
            'size' => 'md',
        ]); ?>
    </div>

    <h3 class="text-lg md:text-xl font-bold dark:text-white mb-2 md:mb-3 flex-shrink-0">
        <?php echo esc_html($args['title']); ?>
    </h3>

    <?php if ($args['description']): ?>
        <p class="text-sm md:text-base text-gray-600 dark:text-gray-300 flex-grow">
            <?php echo esc_html($args['description']); ?>
        </p>
    <?php endif; ?>
</div>
