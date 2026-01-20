<?php
/**
 * Navigation Overlay Template Part
 * Dynamic overlay with Alpine.js integration
 *
 * @package OssenbergEngels
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$logo = get_field('header_logo', 'option');
$logo_dark = get_field('header_logo_dark', 'option');
$logo_width = get_field('header_logo_width', 'option') ?: 150;
$topbar_contact_link = get_field('header_topbar_contact_link', 'option');
$topbar_contact_text = get_field('header_topbar_contact_text', 'option');
$show_dark_mode_toggle = get_field('header_show_dark_mode_toggle', 'option');
// If field returns null/false and hasn't been saved yet, default to true
if ($show_dark_mode_toggle === null || $show_dark_mode_toggle === '') {
    $show_dark_mode_toggle = true;
}
$show_language_switcher = get_field('header_show_language_switcher', 'option');

// Get navigation menu
$locations = get_nav_menu_locations();
$menu_id = $locations['primary'] ?? 0;
$menu_items = $menu_id ? wp_get_nav_menu_items($menu_id) : array();

// Get logo
$logo_url = get_template_directory_uri() . '/assets/SVGs/OE_Logo.svg';
$close_icon = get_template_directory_uri() . '/assets/SVGs/OE_Icon_Close.svg';
?>

<header class="bg-white dark:bg-[#212121] transition-colors overflow-hidden ">

    <!-- Main Header with Logo and Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-6">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
                    <?php if ($logo_url && isset($logo['url'])) : ?>
                        <!-- Light Mode Logo -->
                        <img
                                src="<?php echo esc_url($logo['url']); ?>"
                                alt="<?php echo esc_attr($logo['alt'] ?: 'Ossenberg-Engels GmbH'); ?>"
                                class="h-16 w-auto block dark:hidden"
                        >
                        <!-- Dark Mode Logo -->
                        <?php if ($logo_dark && isset($logo_dark['url'])) : ?>
                            <img
                                    src="<?php echo esc_url($logo_dark['url']); ?>"
                                    alt="<?php echo esc_attr($logo_dark['alt'] ?: 'Ossenberg-Engels GmbH'); ?>"
                                    class="h-16 w-auto hidden dark:block"
                            >
                        <?php else : ?>
                            <img
                                    src="<?php echo esc_url($logo['url']); ?>"
                                    alt="<?php echo esc_attr($logo['alt'] ?: 'Ossenberg-Engels GmbH'); ?>"
                                    class="h-16 w-auto hidden dark:block"
                            >
                        <?php endif; ?>
                    <?php else : ?>
                        <!-- Fallback Logo SVG -->
                        <img
                                src="<?php echo esc_url(get_template_directory_uri() . '/assets/SVGs/OE_Logo.svg'); ?>"
                                alt="Ossenberg-Engels GmbH"
                                class="h-16 w-auto"
                        >
                    <?php endif; ?>
                </a>
            </div>

            <!-- Desktop Navigation -->

            <div class="hidden lg:flex items-center justify-between">
                <div class="">
                    <div class="max-w-7xl mx-auto">
                        <div class="flex justify-between items-center h-12">
                            <!-- Contact CTA -->
                            <?php if ($topbar_contact_link && $topbar_contact_text) : ?>
                                <a href="<?php echo esc_url($topbar_contact_link); ?>" class="flex items-center space-x-2 text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors">
                                    <svg id="Ebene_2" data-name="Ebene 2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 21.91317 15.70572">
                                        <defs>
                                            <style>
                                                .cls-1, .cls-2 {
                                                    fill: none;
                                                }

                                                .cls-2 {
                                                    stroke: #e1191e;
                                                    stroke-linejoin: round;
                                                }

                                                .cls-3 {
                                                    clip-path: url(#clippath);
                                                }
                                            </style>
                                            <clipPath id="clippath">
                                                <rect class="cls-1" x=".00017" y=".0007" width="21.91299" height="15.70502"/>
                                            </clipPath>
                                        </defs>
                                        <g id="Ebene_1-2" data-name="Ebene 1">
                                            <g class="cls-3">
                                                <g id="Gruppe_13" data-name="Gruppe 13">
                                                    <path id="Pfad_35" data-name="Pfad 35" class="cls-2" d="M.00017,5.8837h14.307l-2.282-2.283c-.70941-.70913-.70963-1.85909-.0005-2.5685.70913-.70941,1.85909-.70963,2.5685-.0005l6.819,6.819-6.821,6.822c-.71024.70941-1.86109.70874-2.5705-.0015s-.70874-1.86109.0015-2.5705l2.278-2.278L.00017,9.8277"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="flex items-center space-x-2 text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors">
                                    <span class="text-sm font-medium">Kontaktieren Sie unsg</span>
                                    <svg id="Ebene_2" class="h-6 w-6 ml-3 " data-name="Ebene 2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 21.91317 15.70572">
                                        <defs>
                                            <style>
                                                .cls-1, .cls-2 {
                                                    fill: none;
                                                }

                                                .cls-2 {
                                                    stroke: #e1191e;
                                                    stroke-linejoin: round;
                                                }

                                                .cls-3 {
                                                    clip-path: url(#clippath);
                                                }
                                            </style>
                                            <clipPath id="clippath">
                                                <rect class="cls-1" x=".00017" y=".0007" width="21.91299" height="15.70502"/>
                                            </clipPath>
                                        </defs>
                                        <g id="Ebene_1-2" data-name="Ebene 1">
                                            <g class="cls-3">
                                                <g id="Gruppe_13" data-name="Gruppe 13">
                                                    <path id="Pfad_35" data-name="Pfad 35" class="cls-2" d="M.00017,5.8837h14.307l-2.282-2.283c-.70941-.70913-.70963-1.85909-.0005-2.5685.70913-.70941,1.85909-.70963,2.5685-.0005l6.819,6.819-6.821,6.822c-.71024.70941-1.86109.70874-2.5705-.0015s-.70874-1.86109.0015-2.5705l2.278-2.278L.00017,9.8277"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <!-- Language and Dark Mode -->
                            <div class="flex items-center space-x-4">
                                <?php if ($show_dark_mode_toggle) : ?>
                                    <!-- Dark Mode Toggle -->
                                    <button
                                            id="dark-mode-toggle"
                                            class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#2d2d2d] transition-colors"
                                            aria-label="<?php esc_attr_e('Toggle dark mode', 'ossenberg-engels'); ?>"
                                    >
                                        <!-- Sun Icon (visible in dark mode) -->
                                        <svg class="w-5 h-5 hidden dark:block" style="fill:none;stroke:currentColor;" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                            <circle cx="12" cy="12" r="5"></circle>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"></path>
                                        </svg>
                                        <!-- Moon Icon (visible in light mode) -->
                                        <svg class="w-5 h-5 block dark:hidden" style="fill:none;stroke:currentColor;" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                                        </svg>
                                    </button>
                                <?php endif; ?>

                                <!-- Language Selector -->
                                <?php
                                // Check if multilingual plugin is active
                                if ((function_exists('pll_the_languages') || function_exists('icl_get_languages'))) :
                                    $show_switcher = true;
                                    // If show_language_switcher is explicitly set to false, don't show
                                    if ($show_language_switcher === false || $show_language_switcher === 0) {
                                        $show_switcher = false;
                                    }

                                    if ($show_switcher) :
                                        ?>
                                        <div class="relative group">
                                            <?php
                                            // Polylang support
                                            if (function_exists('pll_the_languages')) {
                                                $languages = pll_the_languages(array('raw' => 1));
                                                if ($languages) {
                                                    foreach ($languages as $lang) {
                                                        if ($lang['current_lang']) {
                                                            // Bouton langue : ajout d'un fond gris et coins arrondis
                                                            echo '<button class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white bg-gray-200 dark:bg-[#212121] rounded-full px-3 py-1">';
                                                            if (!empty($lang['flag'])) {
                                                                echo '<img src="' . esc_url($lang['flag']) . '" alt="' . esc_attr($lang['name']) . '" class="w-5 h-3">';
                                                            }
                                                            echo '<span>' . esc_html($lang['name']) . '</span>';
                                                            echo '</button>';
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                            // WPML support
                                            elseif (function_exists('icl_get_languages')) {
                                                $languages = icl_get_languages('skip_missing=0');
                                                if ($languages) {
                                                    foreach ($languages as $lang) {
                                                        if ($lang['active']) {
                                                            // Bouton langue : ajout d'un fond gris et coins arrondis
                                                            echo '<button class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white bg-gray-200 dark:bg-[#212121] rounded-full px-3 py-1">';
                                                            if (!empty($lang['country_flag_url'])) {
                                                                echo '<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang['native_name']) . '" class="w-5 h-3">';
                                                            }
                                                            echo '<span>' . esc_html($lang['native_name']) . '</span>';
                                                            echo '</button>';
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php
                                    endif;
                                else :
                                    // Fallback: show Deutsch if no multilingual plugin
                                    ?>
                                    <div class="relative group">
                                        <!-- Fallback bouton langue : fond gris + coins arrondis -->
                                        <button class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white bg-gray-200 dark:bg-[#212121] rounded-full px-3 py-1">
                                            <svg class="w-5 h-3" viewBox="0 0 5 3" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                                <rect width="5" height="3" fill="#000"/>
                                                <rect width="5" height="2" y="1" fill="#D00"/>
                                                <rect width="5" height="1" y="2" fill="#FFCE00"/>
                                            </svg>
                                            <span>Deutsch</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="hidden lg:block">
                    <?php
                    wp_nav_menu(array(
                            'theme_location'  => 'primary',
                            'container'       => false,
                            'menu_class'      => 'flex items-center space-x-12',
                            'walker'          => new Ossenberg_Engels_Header_Walker(),
                            'fallback_cb'     => false // No fallback - display nothing if menu doesn't exist
                    ));
                    ?>


                </nav>
            </div>
            <!-- Menu Button (Desktop & Mobile) -->
            <button
                    @click="menuOpen = !menuOpen"
                    :aria-expanded="menuOpen ? 'true' : 'false'"
                    class="relative w-11 h-11 flex flex-col items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer group lg:hidden"
                    :aria-label="menuOpen ? 'Close navigation menu' : 'Open navigation menu'">
                <span class="sr-only">Menu</span>

                <!-- Hamburger icon mit Animation -->
                <div class="relative w-6 h-5 flex flex-col justify-center gap-1.5">
                    <span class="block h-0.5 w-6 bg-primary dark:bg-white group-hover:bg-primary-dark dark:group-hover:bg-primary rounded-sm transition-all duration-300 ease-in-out"
                          :class="{ 'rotate-45 translate-y-2': menuOpen, 'rotate-0 translate-y-0': !menuOpen }"></span>
                    <span class="block h-0.5 w-6 bg-primary dark:bg-white group-hover:bg-primary-dark dark:group-hover:bg-primary rounded-sm transition-all duration-200"
                          :class="{ 'opacity-0': menuOpen, 'opacity-100': !menuOpen }"></span>
                    <span class="block h-0.5 w-6 bg-primary dark:bg-white group-hover:bg-primary-dark dark:group-hover:bg-primary rounded-sm transition-all duration-300 ease-in-out"
                          :class="{ '-rotate-45 -translate-y-2': menuOpen, 'rotate-0 translate-y-0': !menuOpen }"></span>
                </div>
            </button>
        </div>
    </div>

</header>


<div x-show="menuOpen" x-transition class="relative min-h-screen bg-gray-200 overflow-hidden" x-cloak @click.self="menuOpen = false">
    <!-- Close button is now integrated in the main menu button -->

    <!-- Overlay content (e.g., mobile menu) -->
    <div class="flex flex-col items-center justify-center min-h-screen py-12" role="dialog" aria-modal="true" tabindex="-1">
        <!-- Logo (centered in the overlay) -->
        <div class="mb-8">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
                <?php if ($logo_url && isset($logo['url'])) : ?>
                    <!-- Light Mode Logo -->
                    <img
                            src="<?php echo esc_url($logo['url']); ?>"
                            alt="<?php echo esc_attr($logo['alt'] ?: 'Ossenberg-Engels GmbH'); ?>"
                            class="h-16 w-auto block dark:hidden"
                    >
                    <!-- Dark Mode Logo -->
                    <?php if ($logo_dark && isset($logo_dark['url'])) : ?>
                        <img
                                src="<?php echo esc_url($logo_dark['url']); ?>"
                                alt="<?php echo esc_attr($logo_dark['alt'] ?: 'Ossenberg-Engels GmbH'); ?>"
                                class="h-16 w-auto hidden dark:block"
                        >
                    <?php else : ?>
                        <img
                                src="<?php echo esc_url($logo['url']); ?>"
                                alt="<?php echo esc_attr($logo['alt'] ?: 'Ossenberg-Engels GmbH'); ?>"
                                class="h-16 w-auto hidden dark:block"
                        >
                    <?php endif; ?>
                <?php else : ?>
                    <!-- Fallback Logo SVG -->
                    <img
                            src="<?php echo esc_url(get_template_directory_uri() . '/assets/SVGs/OE_Logo.svg'); ?>"
                            alt="Ossenberg-Engels GmbH"
                            class="h-16 w-auto"
                    >
                <?php endif; ?>
            </a>
        </div>

        <!-- Mobile Navigation Menu -->
        <nav class="flex-1 w-full max-w-md px-4">
            <?php
            wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'container'       => false,
                    'menu_class'      => 'flex flex-col space-y-4',
                    'walker'          => new Ossenberg_Engels_Header_Walker(),
                    'fallback_cb'     => false // No fallback - display nothing if menu doesn't exist
            ));
            ?>
        </nav>

        <!-- Optional: Add any additional content for the overlay here -->
    </div>
</div>
