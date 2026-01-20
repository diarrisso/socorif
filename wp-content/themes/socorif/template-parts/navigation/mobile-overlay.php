<?php
/**
 * Navigation Overlay Template Part
 * Mobile Vollbild-Menü mit Alpine.js
 *
 * @package Beka
 */

// Sicherheitsprüfung gegen direkten Zugriff
if (!defined('ABSPATH')) {
    exit;
}

// Navigation-Menü abrufen
$locations = get_nav_menu_locations();
$menu_id = $locations['primary'] ?? 0;
$menu_items = $menu_id ? wp_get_nav_menu_items($menu_id) : array();

// Logo abrufen
$header_logo = get_field('header_logo', 'option');
$header_logo_dark = get_field('header_logo_dark', 'option');

// Standard-Animation
$overlay_animation = 'slide-top';

// Animations-Klassen festlegen
$animation_classes = array(
    'slide-top' => array(
        'enter-start' => 'opacity-0 transform translate-y-[-100%]',
        'enter-end' => 'opacity-100 transform translate-y-0',
        'leave-start' => 'opacity-100 transform translate-y-0',
        'leave-end' => 'opacity-0 transform translate-y-[-100%]',
    ),
    'slide-bottom' => array(
        'enter-start' => 'opacity-0 transform translate-y-[100%]',
        'enter-end' => 'opacity-100 transform translate-y-0',
        'leave-start' => 'opacity-100 transform translate-y-0',
        'leave-end' => 'opacity-0 transform translate-y-[100%]',
    ),
);

$current_animation = $animation_classes[$overlay_animation];
?>

<!-- Mobile Navigation Overlay -->
<div class="mobile-overlay fixed inset-0 bg-primary z-50 overflow-hidden min-h-screen w-full h-full lg:hidden"
     id="mobileOverlay"
     x-show="mobileMenuOpen"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="<?php echo esc_attr($current_animation['enter-start']); ?>"
     x-transition:enter-end="<?php echo esc_attr($current_animation['enter-end']); ?>"
     x-transition:leave="transition ease-in duration-400"
     x-transition:leave-start="<?php echo esc_attr($current_animation['leave-start']); ?>"
     x-transition:leave-end="<?php echo esc_attr($current_animation['leave-end']); ?>"
     style="display: none;"
     @click.self="mobileMenuOpen = false">

    <div class="w-full h-full relative">

        <!-- Header mit Logo, Dark Mode und Close-Button -->
        <div class="absolute top-0 left-0 right-0 flex justify-between items-center z-20 px-6 py-6">
            <!-- Logo -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-500 delay-100"
                 x-transition:enter-start="opacity-0 transform scale-75"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="flex-shrink-0">
                <a href="<?php echo esc_url(home_url('/')); ?>" @click="mobileMenuOpen = false">
                    <?php if ($header_logo) : ?>
                        <img src="<?php echo esc_url($header_logo['url']); ?>"
                             alt="<?php echo esc_attr($header_logo['alt'] ?: get_bloginfo('name')); ?>"
                             class="h-14 w-auto brightness-0 invert">
                    <?php else : ?>
                        <span class="text-white font-display font-bold text-2xl"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Close-Button -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-500 delay-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm transition-all duration-300 rounded-full p-3 hover:scale-110 active:scale-95 cursor-pointer"
                        @click="mobileMenuOpen = false"
                        aria-label="Navigation schließen">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex flex-col h-full relative pt-32 pb-16">
            <div class="flex-1 flex flex-col px-8 md:px-12 w-full h-full overflow-auto">

                <!-- Hauptnavigation -->
                <nav class="flex items-center justify-center w-full mb-16"
                     x-show="mobileMenuOpen"
                     x-transition:enter="transition ease-out duration-700 delay-200"
                     x-transition:enter-start="opacity-0 transform translate-x-[-50px]"
                     x-transition:enter-end="opacity-100 transform translate-x-0">

                    <?php if (!empty($menu_items)): ?>
                        <ul class="space-y-6 md:space-y-8 text-center w-full max-w-4xl">
                            <?php foreach ($menu_items as $index => $item): ?>
                                <?php if ($item->menu_item_parent == 0): ?>
                                    <?php
                                    // Untermenüs prüfen
                                    $submenu_items = array_filter($menu_items, function($submenu) use ($item) {
                                        return $submenu->menu_item_parent == $item->ID;
                                    });
                                    $has_submenu = !empty($submenu_items);
                                    ?>
                                    <li x-data="{ submenuOpen: false }"
                                        x-show="mobileMenuOpen"
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 transform translate-y-8"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        style="transition-delay: <?php echo ($index * 150) + 400; ?>ms; display: none;">
                                        <?php if ($has_submenu): ?>
                                            <button type="button"
                                               class="block text-white hover:text-secondary transition-all duration-500 ease-in-out text-3xl md:text-4xl font-display font-bold hover:scale-105 transform w-full text-center"
                                               :class="{ 'underline': submenuOpen }"
                                               @click="submenuOpen = !submenuOpen">
                                                <?php echo esc_html($item->title); ?>
                                            </button>
                                        <?php else: ?>
                                            <a href="<?php echo esc_url($item->url); ?>"
                                               class="block text-white hover:text-secondary transition-all duration-500 ease-in-out text-3xl md:text-4xl font-display font-bold hover:scale-105 transform"
                                               @click="mobileMenuOpen = false">
                                                <?php echo esc_html($item->title); ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($has_submenu): ?>
                                            <ul class="mt-5 space-y-3 overflow-hidden transition-all duration-500 ease-in-out max-w-md mx-auto"
                                                x-show="submenuOpen"
                                                x-transition:enter="transition ease-out duration-400"
                                                x-transition:enter-start="opacity-0 max-h-0 transform -translate-y-4"
                                                x-transition:enter-end="opacity-100 max-h-[500px] transform translate-y-0"
                                                x-transition:leave="transition ease-in duration-300"
                                                x-transition:leave-start="opacity-100 max-h-[500px] transform translate-y-0"
                                                x-transition:leave-end="opacity-0 max-h-0 transform -translate-y-4"
                                                style="display: none;">
                                                <?php foreach ($submenu_items as $submenu_item): ?>
                                                    <li>
                                                        <a href="<?php echo esc_url($submenu_item->url); ?>"
                                                           class="block text-xl text-white/90 hover:text-secondary transition-all duration-400 ease-in-out hover:scale-105 transform text-center font-medium"
                                                           @click="mobileMenuOpen = false">
                                                            <?php echo esc_html($submenu_item->title); ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </nav>

                <!-- Phone Button -->
                <?php $header_phone = get_field('header_phone', 'option'); ?>
                <?php if ($header_phone) : ?>
                <div class="mt-auto flex flex-col gap-4 max-w-md mx-auto w-full"
                     x-show="mobileMenuOpen"
                     x-transition:enter="transition ease-out duration-700 delay-400"
                     x-transition:enter-start="opacity-0 transform translate-y-8"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    <a href="tel:<?php echo esc_attr(socorif_format_phone($header_phone)); ?>"
                       class="px-6 py-3 bg-secondary hover:bg-secondary-dark text-white font-display font-bold text-sm rounded-lg transition-colors inline-flex items-center justify-center gap-2 mx-auto"
                       @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span><?php echo esc_html($header_phone); ?></span>
                    </a>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
