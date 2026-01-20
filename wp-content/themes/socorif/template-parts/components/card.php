<?php
/**
 * Reusable Card Component
 *
 * @param array $args {
 *     @type array  $image       Image data array from ACF
 *     @type string $title       Card title
 *     @type string $description Card description/content
 *     @type array  $link        Link array from ACF (url, title, target)
 *     @type string $variant     Card style variant (default|bordered|elevated)
 *     @type string $size        Card size (sm|md|lg)
 *     @type array  $classes     Additional CSS classes
 * }
 */

if (!defined('ABSPATH')) exit;

$defaults = [
    'image' => null,
    'title' => '',
    'description' => '',
    'link' => null,
    'variant' => 'default',
    'size' => 'md',
    'classes' => [],
];

$args = wp_parse_args($args ?? [], $defaults);

// Variant classes
$variant_classes = [
    'default' => 'bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-xl hover:shadow-2xl hover:shadow-primary/10 border-2 border-gray-200 dark:border-gray-700',
    'bordered' => 'bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 border-2 border-gray-200 dark:border-gray-700 hover:border-primary shadow-lg hover:shadow-xl',
    'elevated' => 'bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-xl hover:shadow-2xl hover:shadow-primary/20 border-2 border-transparent hover:border-primary/20',
];

// Size classes
$size_classes = [
    'sm' => 'p-4 md:p-5',
    'md' => 'p-6 md:p-8',
    'lg' => 'p-8 md:p-10',
];

// Build card classes
$card_classes = socorif_merge_classes(
    'card',
    'group',
    'rounded-3xl',
    'transition-all',
    'duration-300',
    'overflow-hidden',
    'hover:scale-[1.02]',
    'active:scale-95',
    'hover:-translate-y-2',
    $variant_classes[$args['variant']] ?? $variant_classes['default'],
    $args['classes']
);

// Check if card should be wrapped in a link
$is_linked = !empty($args['link']) && !empty($args['link']['url']);
$card_tag = $is_linked ? 'a' : 'div';
$card_attrs = '';

if ($is_linked) {
    $card_attrs = sprintf(
        'href="%s" target="%s"',
        esc_url($args['link']['url']),
        esc_attr($args['link']['target'] ?? '_self')
    );
}

?>

<<?php echo $card_tag; ?> class="<?php echo esc_attr($card_classes); ?>" <?php echo $card_attrs; ?>>

    <?php if ($args['image']) : ?>
        <div class="card-image relative overflow-hidden rounded-3xl mb-5">
            <?php
            echo socorif_image(
                $args['image'],
                'large',
                [
                    'class' => 'w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110',
                    'loading' => 'lazy'
                ]
            );
            ?>
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
    <?php endif; ?>

    <div class="card-content <?php echo esc_attr($size_classes[$args['size']] ?? $size_classes['md']); ?>">

        <?php if ($args['title']) : ?>
            <h3 class="card-title text-xl font-bold dark:text-white mb-3 border-l-4 border-primary pl-4 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-300">
                <?php echo esc_html($args['title']); ?>
            </h3>
        <?php endif; ?>

        <?php if ($args['description']) : ?>
            <div class="card-description text-gray-600 dark:text-gray-300 leading-relaxed">
                <?php echo wp_kses_post($args['description']); ?>
            </div>
        <?php endif; ?>

        <?php if ($is_linked && !empty($args['link']['title'])) : ?>
            <div class="card-link mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white font-semibold rounded-3xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all duration-300 hover:scale-105 active:scale-95">
                <span><?php echo esc_html($args['link']['title']); ?></span>
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </div>
        <?php endif; ?>

    </div>

</<?php echo $card_tag; ?>>
