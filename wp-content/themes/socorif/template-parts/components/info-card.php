<?php
/**
 * Composant Info-Card
 * Pour les informations techniques, certificats, etc.
 *
 * @param array $args {
 *     @type string $icon        Nom de l'icone
 *     @type string $title       Titre de la carte
 *     @type string $value       Valeur/Description de la carte
 *     @type string $variant     Style (default|primary|secondary)
 *     @type array  $classes     Classes additionnelles
 * }
 */

if (!defined('ABSPATH')) exit;

$defaults = [
    'icon' => 'check',
    'title' => '',
    'value' => '',
    'variant' => 'default',
    'classes' => [],
];

$args = wp_parse_args($args ?? [], $defaults);

if (empty($args['value']) && empty($args['title'])) return;

$variant_classes = [
    'default' => 'bg-gray-50 dark:bg-gray-800',
    'primary' => 'bg-primary/10 dark:bg-primary/20',
    'secondary' => 'bg-secondary/10 dark:bg-secondary/20',
];

$base_classes = 'rounded-3xl p-6 text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:scale-105 active:scale-95 cursor-pointer';
$variant_class = $variant_classes[$args['variant']] ?? $variant_classes['default'];
$custom_classes = is_array($args['classes']) ? implode(' ', $args['classes']) : $args['classes'];

$classes = trim("$base_classes $variant_class $custom_classes");

?>

<div class="<?php echo esc_attr($classes); ?>">
    <div class="text-primary mb-3 transition-transform duration-300 hover:scale-110">
        <?php get_template_part('template-parts/components/icon', null, [
            'name' => $args['icon'],
            'size' => 'lg',
            'classes' => ['mx-auto'],
        ]); ?>
    </div>

    <?php if ($args['title']): ?>
        <h3 class="font-bold text-base md:text-lg dark:text-white mb-2">
            <?php echo esc_html($args['title']); ?>
        </h3>
    <?php endif; ?>

    <?php if ($args['value']): ?>
        <p class="text-sm md:text-base text-gray-600 dark:text-gray-300">
            <?php echo esc_html($args['value']); ?>
        </p>
    <?php endif; ?>
</div>
