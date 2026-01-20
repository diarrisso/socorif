<?php
/**
 * Button Component
 * Wiederverwendbare Button-Komponente mit verschiedenen Varianten
 *
 * @param array $args {
 *     @type string $text        Button-Text
 *     @type string $url         Link-URL
 *     @type string $target      Link-Target (_self, _blank)
 *     @type string $variant     Button-Variante (primary|secondary|outline)
 *     @type string $size        Button-Groesse (sm|md|lg)
 *     @type bool   $icon        Zeige Pfeil-Icon
 *     @type array  $classes     Zusaetzliche CSS-Klassen
 * }
 */

if (!defined('ABSPATH')) exit;

$defaults = [
    'text' => 'Button',
    'url' => '#',
    'target' => '_self',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => true,
    'classes' => [],
];

$args = wp_parse_args($args ?? [], $defaults);

// Varianten-Klassen
$variant_classes = [
    'primary' => 'btn btn-primary',
    'secondary' => 'btn btn-secondary',
    'outline' => 'btn border-2 border-primary text-primary hover:bg-primary hover:text-white dark:border-primary dark:text-primary dark:hover:bg-primary dark:hover:text-white',
];

// Groessen-Klassen
$size_classes = [
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
];

// Button-Klassen zusammenstellen
$button_classes = socorif_merge_classes(
    $variant_classes[$args['variant']] ?? $variant_classes['primary'],
    $size_classes[$args['size']] ?? $size_classes['md'],
    'inline-flex',
    'items-center',
    'gap-2',
    'rounded-3xl',
    'font-semibold',
    'transition-all',
    'duration-300',
    'hover:scale-105',
    'active:scale-95',
    'cursor-pointer',
    'shadow-lg',
    'hover:shadow-xl',
    $args['classes']
);

?>

<a href="<?php echo esc_url($args['url']); ?>"
   target="<?php echo esc_attr($args['target']); ?>"
   class="<?php echo esc_attr($button_classes); ?>">
    <span><?php echo esc_html($args['text']); ?></span>
    <?php if ($args['icon']) : ?>
        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    <?php endif; ?>
</a>
