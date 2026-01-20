<?php
/**
 * Component: CPT Banniere Publicitaire (Sidebar)
 *
 * Display promotional banner from CPT details fields
 * Designed for sidebar placement
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

// Check if banner is activated
$banniere_activer = get_field('banniere_activer');
if (!$banniere_activer) return;

// Get field values
$subtitle = get_field('banniere_subtitle') ?: '';
$title = get_field('banniere_title') ?: '';
$image = get_field('banniere_image');
$button = get_field('banniere_button');
$bg_color = get_field('banniere_bg_color') ?: 'secondary';

// Background color classes
$bg_classes = [
    'primary' => 'bg-gradient-to-br from-primary to-primary-dark',
    'secondary' => 'bg-gradient-to-br from-secondary to-secondary-dark',
    'dark' => 'bg-gradient-to-br from-gray-800 to-gray-900',
];
$bg_class = $bg_classes[$bg_color] ?? $bg_classes['secondary'];

// Exit if no content
if (!$title && !$image) return;
?>

<aside class="cpt-banniere-pub rounded-3xl overflow-hidden shadow-xl mt-6 <?php echo esc_attr($bg_class); ?>">
    <div class="p-6 text-center">
        <?php if ($subtitle) : ?>
            <p class="text-white/80 text-xs mb-3 font-medium uppercase tracking-wider">
                <?php echo esc_html($subtitle); ?>
            </p>
        <?php endif; ?>

        <?php if ($title) : ?>
            <h3 class="text-white text-lg font-bold leading-tight mb-4 uppercase">
                <?php echo esc_html($title); ?>
            </h3>
        <?php endif; ?>

        <?php if ($image) : ?>
            <div class="mb-4 -mx-6">
                <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
                     alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
                     class="w-full h-auto"
                     loading="lazy">
            </div>
        <?php endif; ?>

        <?php if ($button && !empty($button['url'])) : ?>
            <a href="<?php echo esc_url($button['url']); ?>"
               class="inline-block w-full bg-white text-gray-900 hover:bg-gray-100 px-6 py-3 font-semibold text-sm uppercase tracking-wide transition-all duration-300 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5"
               <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                <?php echo esc_html($button['title'] ?: 'Contactez-moi'); ?>
            </a>
        <?php endif; ?>
    </div>
</aside>
