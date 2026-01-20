<?php
/**
 * Galerie-Element Komponente (Vorher/Nachher)
 *
 * @param array $args {
 *     @type array  $before_image  Vorher-Bilddaten
 *     @type array  $after_image   Nachher-Bilddaten
 *     @type string $title         Projekttitel
 *     @type string $location      Projektstandort
 *     @type string $style         Anzeigestil (comparison|slider|side-by-side)
 *     @type array  $classes       Zusätzliche Klassen
 * }
 */

if (!defined('ABSPATH')) exit;

$defaults = [
    'before_image' => null,
    'after_image' => null,
    'title' => '',
    'location' => '',
    'style' => 'comparison',
    'classes' => [],
];

$args = wp_parse_args($args ?? [], $defaults);

if (empty($args['before_image']) && empty($args['after_image'])) return;

$base_classes = 'bg-white dark:bg-gray-900 rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer';
$custom_classes = is_array($args['classes']) ? implode(' ', $args['classes']) : $args['classes'];

$classes = trim("$base_classes $custom_classes");

?>

<div class="<?php echo esc_attr($classes); ?>" data-animate="fade-up">

    <?php if ($args['style'] === 'comparison' && $args['before_image'] && $args['after_image']): ?>
        <!-- Vorher/Nachher Vergleich -->

        <!-- Mobile: Gestapeltes Layout -->
        <div class="sm:hidden">
            <div class="relative">
                <img
                    src="<?php echo esc_url($args['before_image']['url']); ?>"
                    alt="Vorher"
                    class="w-full h-48 object-cover"
                    loading="lazy"
                >
                <div class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 rounded-3xl text-xs font-semibold shadow-md">
                    Vorher
                </div>
            </div>
            <div class="relative">
                <img
                    src="<?php echo esc_url($args['after_image']['url']); ?>"
                    alt="Nachher"
                    class="w-full h-48 object-cover"
                    loading="lazy"
                >
                <div class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-3xl text-xs font-semibold shadow-md">
                    Nachher
                </div>
            </div>
        </div>

        <!-- Tablet/Desktop: Nebeneinander -->
        <div class="hidden sm:grid sm:grid-cols-2">
            <div class="relative group">
                <img
                    src="<?php echo esc_url($args['before_image']['url']); ?>"
                    alt="Vorher"
                    class="w-full h-56 md:h-64 lg:h-72 object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                >
                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-3xl text-sm font-semibold shadow-md">
                    Vorher
                </div>
            </div>
            <div class="relative group">
                <img
                    src="<?php echo esc_url($args['after_image']['url']); ?>"
                    alt="Nachher"
                    class="w-full h-56 md:h-64 lg:h-72 object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                >
                <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-3xl text-sm font-semibold shadow-md">
                    Nachher
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($args['title'] || $args['location']): ?>
        <div class="p-4 md:p-6">
            <?php if ($args['title']): ?>
                <h3 class="font-bold text-base md:text-lg dark:text-white mb-2">
                    <?php echo esc_html($args['title']); ?>
                </h3>
            <?php endif; ?>

            <?php if ($args['location']): ?>
                <p class="text-sm md:text-base text-gray-600 dark:text-gray-300 flex items-center gap-2">
                    <?php get_template_part('template-parts/components/icon', null, [
                        'name' => 'location',
                        'size' => 'sm',
                    ]); ?>
                    <?php echo esc_html($args['location']); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>
