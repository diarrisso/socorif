<?php
/**
 * Component: Property Gallery with Units Accordion
 *
 * Displays a property gallery on the left and units accordion on the right
 *
 * @param array $args {
 *     @type string $title       Property/project title
 *     @type array  $gallery     Array of image IDs or image arrays
 *     @type array  $units       Array of units with features
 *     @type string $bg_color    Background color (white, gray-50)
 * }
 */

if (!defined('ABSPATH')) exit;

// Get component args
$title = $args['title'] ?? '';
$gallery = $args['gallery'] ?? [];
$units = $args['units'] ?? [];
$bg_color = $args['bg_color'] ?? 'white';

if (empty($gallery) && empty($units)) {
    return;
}

// Background classes
$bg_classes = [
    'white' => 'bg-white dark:bg-gray-900',
    'gray-50' => 'bg-gray-50 dark:bg-gray-800',
];

$section_bg = $bg_classes[$bg_color] ?? $bg_classes['white'];

// Unique ID for Alpine.js
$component_id = 'pgu-' . uniqid();

// Icon SVGs
$icons = [
    'check' => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
    'bed' => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v11m0-6h18m-9-5v5m-6 0V6a2 2 0 012-2h8a2 2 0 012 2v6m-6 0h6m0 0v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5"/></svg>',
    'bath' => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
    'kitchen' => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
    'living' => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
    'balcony' => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/></svg>',
    'parking' => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>',
    'garden' => '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
];

// Status colors
$status_colors = [
    'disponible' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    'reserve' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
    'vendu' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    'loue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
];
$status_labels = [
    'disponible' => 'Disponible',
    'reserve' => 'Reserve',
    'vendu' => 'Vendu',
    'loue' => 'Loue',
];
?>

<div class="property-gallery-units <?php echo esc_attr($section_bg); ?> py-12 lg:py-16"
     id="<?php echo esc_attr($component_id); ?>"
     x-data="{
        activeImage: 0,
        activeUnit: 0,
        images: <?php echo count($gallery); ?>,
        setImage(index) {
            this.activeImage = index;
        }
     }">

    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            <!-- Left: Gallery -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800 shadow-xl">
                    <?php foreach ($gallery as $index => $image) :
                        $img_id = is_array($image) ? ($image['ID'] ?? $image['id'] ?? 0) : $image;
                        if (!$img_id) continue;
                    ?>
                        <div class="absolute inset-0 transition-opacity duration-300"
                             x-show="activeImage === <?php echo $index; ?>"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100">
                            <?php echo wp_get_attachment_image($img_id, 'large', false, ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php endforeach; ?>

                    <!-- Navigation arrows -->
                    <?php if (count($gallery) > 1) : ?>
                        <button @click="activeImage = (activeImage - 1 + images) % images"
                                class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 dark:bg-gray-800/90 rounded-full shadow-lg flex items-center justify-center hover:bg-white dark:hover:bg-gray-700 transition-colors z-10">
                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button @click="activeImage = (activeImage + 1) % images"
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 dark:bg-gray-800/90 rounded-full shadow-lg flex items-center justify-center hover:bg-white dark:hover:bg-gray-700 transition-colors z-10">
                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Thumbnails -->
                <?php if (count($gallery) > 1) : ?>
                    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-thin">
                        <?php foreach ($gallery as $index => $image) :
                            $img_id = is_array($image) ? ($image['ID'] ?? $image['id'] ?? 0) : $image;
                            if (!$img_id) continue;
                        ?>
                            <button @click="setImage(<?php echo $index; ?>)"
                                    class="flex-shrink-0 w-20 h-16 lg:w-24 lg:h-20 rounded-lg overflow-hidden border-2 transition-all duration-200"
                                    :class="activeImage === <?php echo $index; ?> ? 'border-primary ring-2 ring-primary/30' : 'border-transparent opacity-70 hover:opacity-100'">
                                <?php echo wp_get_attachment_image($img_id, 'thumbnail', false, ['class' => 'w-full h-full object-cover']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Title + Units Accordion -->
            <div class="space-y-6">
                <!-- Title -->
                <?php if ($title) : ?>
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <!-- Units Accordion -->
                <?php if (!empty($units)) : ?>
                    <div class="space-y-3">
                        <?php foreach ($units as $index => $unit) :
                            $unit_name = $unit['unit_name'] ?? 'Unite ' . ($index + 1);
                            $unit_status = $unit['unit_status'] ?? 'disponible';
                            $unit_features = $unit['unit_features'] ?? [];
                            $unit_surface = $unit['unit_surface'] ?? '';
                            $unit_bedrooms = $unit['unit_bedrooms'] ?? '';
                            $unit_price = $unit['unit_price'] ?? '';
                        ?>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden"
                                 x-data="{ open: <?php echo $index === 0 ? 'true' : 'false'; ?> }">

                                <!-- Accordion Header -->
                                <button @click="open = !open; activeUnit = <?php echo $index; ?>"
                                        class="w-full flex items-center justify-between p-4 text-left transition-colors"
                                        :class="open ? 'bg-primary/10 dark:bg-primary/20' : 'bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700'">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold"
                                              :class="open ? 'bg-primary text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300'">
                                            <?php echo $index + 1; ?>
                                        </span>
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            <?php echo esc_html($unit_name); ?>
                                        </span>
                                        <?php if ($unit_status !== 'disponible') : ?>
                                            <span class="text-xs px-2 py-1 rounded-full <?php echo esc_attr($status_colors[$unit_status] ?? ''); ?>">
                                                <?php echo esc_html($status_labels[$unit_status] ?? $unit_status); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-200"
                                         :class="open ? 'rotate-180' : ''"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Accordion Content -->
                                <div x-show="open"
                                     x-collapse
                                     class="border-t border-gray-200 dark:border-gray-700">
                                    <div class="p-4 space-y-4 bg-white dark:bg-gray-900">

                                        <!-- Quick stats -->
                                        <?php if ($unit_surface || $unit_bedrooms || $unit_price) : ?>
                                            <div class="flex flex-wrap gap-4 text-sm">
                                                <?php if ($unit_surface) : ?>
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                                        </svg>
                                                        <?php echo esc_html($unit_surface); ?> m²
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($unit_bedrooms) : ?>
                                                    <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                        </svg>
                                                        <?php echo esc_html($unit_bedrooms); ?> ch.
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($unit_price) : ?>
                                                    <span class="font-semibold text-primary">
                                                        <?php echo number_format($unit_price, 0, ',', ' '); ?> GNF
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Features list -->
                                        <?php if (!empty($unit_features)) : ?>
                                            <ul class="space-y-2">
                                                <?php foreach ($unit_features as $feature) :
                                                    $icon_key = $feature['icon'] ?? 'check';
                                                    $feature_text = $feature['text'] ?? '';
                                                    if (!$feature_text) continue;
                                                ?>
                                                    <li class="flex items-start gap-3">
                                                        <span class="flex-shrink-0 mt-0.5">
                                                            <?php echo $icons[$icon_key] ?? $icons['check']; ?>
                                                        </span>
                                                        <span class="text-gray-700 dark:text-gray-300">
                                                            <?php echo esc_html($feature_text); ?>
                                                        </span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
