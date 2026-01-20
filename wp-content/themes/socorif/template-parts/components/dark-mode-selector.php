<?php
/**
 * Dark Mode Selector Component
 * 3 options: Light, Dark, Auto
 *
 * @package Beka
 */

if (!defined('ABSPATH')) exit;

$selector_id = $args['selector_id'] ?? 'dark-mode-selector';
$show_selector = $args['show_selector'] ?? get_field('header_show_dark_mode_toggle', 'option');
$is_mobile = $args['mobile'] ?? false;

if ($show_selector === null || $show_selector === '') {
    $show_selector = true;
}

if (!$show_selector) return;

// Mobile-spezifisches Styling
$mobile_classes = $is_mobile ? 'bg-white/20 dark:bg-white/10 backdrop-blur-sm' : 'bg-gray-100 dark:bg-gray-800';
$button_mobile_classes = $is_mobile ? 'text-white/80 hover:text-white' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200';
$active_mobile_classes = $is_mobile ? 'bg-white/30 text-white shadow-md' : 'bg-white dark:bg-gray-700 text-primary shadow-sm';
?>

<div class="flex items-center gap-1 p-1 <?php echo esc_attr($mobile_classes); ?> rounded-3xl"
     x-data="{
        mode: localStorage.getItem('theme') || 'auto',
        init() {
            this.applyTheme(this.mode);
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (this.mode === 'auto') this.applyTheme('auto');
            });
        },
        setMode(newMode) {
            this.mode = newMode;
            localStorage.setItem('theme', newMode);
            this.applyTheme(newMode);
        },
        applyTheme(mode) {
            if (mode === 'dark' || (mode === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
     }">

    <!-- Light -->
    <button
        @click="setMode('light')"
        class="flex items-center justify-center w-9 h-9 rounded-3xl transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer"
        :class="mode === 'light' ? '<?php echo esc_attr($active_mobile_classes); ?>' : '<?php echo esc_attr($button_mobile_classes); ?>'"
        aria-label="Light Mode">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
    </button>

    <!-- Auto -->
    <button
        @click="setMode('auto')"
        class="flex items-center justify-center w-9 h-9 rounded-3xl transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer"
        :class="mode === 'auto' ? '<?php echo esc_attr($active_mobile_classes); ?>' : '<?php echo esc_attr($button_mobile_classes); ?>'"
        aria-label="Auto Mode">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </button>

    <!-- Dark -->
    <button
        @click="setMode('dark')"
        class="flex items-center justify-center w-9 h-9 rounded-3xl transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer"
        :class="mode === 'dark' ? '<?php echo esc_attr($active_mobile_classes); ?>' : '<?php echo esc_attr($button_mobile_classes); ?>'"
        aria-label="Dark Mode">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
        </svg>
    </button>
</div>
