<?php
/**
 * Background Image Section Block
 * Große Hintergrundbildsektion mit optionaler Rundung
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('background-image-section');

// Konfiguration laden
require_once __DIR__ . '/config.php';

// Felder abrufen
$image = socorif_get_field('image');
$alt_text = socorif_get_field('alt_text', '');
$rounded = socorif_get_field('rounded', true);
$aspect_ratio = socorif_get_field('aspect_ratio', 'aspect-[5/2]');
$spacing_top = socorif_get_field('spacing_top', 'mt-32 sm:mt-40');

// Block-Attribute für Wrapper
$block_attrs = isset($block) ? get_block_wrapper_attributes(['class' => 'background-image-section-block']) : 'class="background-image-section-block"';

// Container-Klassen
$container_classes = [
    $spacing_top,
    'container',
    'mx-auto',
    'px-4',
    'lg:px-8',
];

// Bild-Klassen
$image_classes = [
    $aspect_ratio,
    'w-full',
    'object-cover',
    'outline-1',
    '-outline-offset-1',
    'outline-black/5',
    'dark:outline-white/10',
];

if ($rounded) {
    $image_classes[] = 'xl:rounded-3xl';
}
?>

<div <?php echo $block_attrs; ?>>
    <?php if ($image) : ?>
        <div class="<?php echo esc_attr(implode(' ', $container_classes)); ?>">
            <?php
            // Utiliser la fonction helper pour l'image avec lazy loading
            echo socorif_image(
                $image,
                'hero', // Taille d'image
                [
                    'class' => implode(' ', $image_classes),
                    'alt' => $alt_text ?: ($image['alt'] ?? ''),
                    'loading' => 'lazy',
                ]
            );
            ?>
        </div>
    <?php else : ?>
        <!-- Empty state pour l'éditeur -->
        <?php if (is_admin()) : ?>
            <div class="<?php echo esc_attr(implode(' ', $container_classes)); ?>">
                <div class="<?php echo esc_attr(implode(' ', $image_classes)); ?> bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    <div class="text-center p-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">
                            Veuillez selectionner une image
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
// Block-Ende markieren
socorif_block_comment_end('background-image-section');
