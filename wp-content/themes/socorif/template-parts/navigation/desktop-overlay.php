<?php
/**
 * Desktop Navigation Overlay
 * Full-screen overlay with multi-level menu navigation
 *
 * @package Ossenberg_Engels
 */

// Get ACF Options
$logo = get_field('header_logo', 'option');
$logo_dark = get_field('header_logo_dark', 'option');
$topbar_contact_link = get_field('header_topbar_contact_link', 'option');
$topbar_contact_text = function_exists('pll__') ? pll__('Kontaktieren Sie uns') : 'Kontaktieren Sie uns';
$show_language_switcher = get_field('header_show_language_switcher', 'option');
?>

<!-- Desktop Navigation Overlay -->
<div
    x-cloak
    x-show="menuOpen && activeOverlay === 'desktop'"
    x-transition:enter="transition ease-out duration-400"
    x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-[-20px]"
    class="fixed inset-x-0 top-0 desktop-overlay-nav overflow-hidden"
    :class="menuOpen && activeOverlay === 'desktop' ? 'z-1' : 'z-50'"
    @click.away="menuOpen = false; activeOverlay = null"
    style="height: 84vh; width: 100%; display: none;"
>
    <!-- Red content section with a fixed height -->
    <div class="desktop-overlay-content-wrapper dark:bg-[#1a1a1a]">
        <!-- Decorative bottom shape divider -->

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <!-- Header Section with Logo, Contact, Language, and Close Button -->
        <div>
            <div class="flex items-center justify-between py-6">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
                        <!-- White Logo SVG for red background overlay -->
                        <img
                            src="<?php echo esc_url(get_template_directory_uri() . '/assets/SVGs/OE_Logo_white.svg'); ?>"
                            alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                            class="h-16 w-auto"
                        >
                    </a>
                </div>

                <!-- Desktop Navigation -->

                <div class="flex items-center justify-between hidden lg:block text-white">
                    <div class="">
                        <div class="max-w-7xl mx-auto">
                            <div class="flex lg:justify-start xl:justify-between items-center h-12">
                                <!-- Contact CTA -->
                                <div x-data="{ contactHoverOverlay: false }">
                                    <a href="<?php echo esc_url($topbar_contact_link ?: home_url('/kontakt')); ?>"
                                       class="nav-link inline-flex items-center gap-2 text-white hover:text-gray-200 transition-colors"
                                       @mouseenter="contactHoverOverlay = true"
                                       @mouseleave="contactHoverOverlay = false">
                                        <span><?php echo esc_html($topbar_contact_text); ?></span>
                                        <span class="relative w-8 h-4 inline-block transition-transform duration-300 ease-in-out overflow-visible"
                                              :class="{ 'translate-x-3': contactHoverOverlay }">
                                            <!-- Normal Arrow SVG (white) -->
                                            <svg class="absolute inset-0 w-full h-full transition-opacity duration-300 ease-in-out"
                                                 :class="{ 'opacity-0': contactHoverOverlay, 'opacity-100': !contactHoverOverlay }"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.91317 15.70572" aria-hidden="true">
                                                <path stroke="#fff" fill="none" d="M.00017,5.8837h14.307l-2.282-2.283c-.70941-.70913-.70963-1.85909-.0005-2.5685.70913-.70941,1.85909-.70963,2.5685-.0005l6.819,6.819-6.821,6.822c-.71024.70941-1.86109.70874-2.5705-.0015s-.70874-1.86109.0015-2.5705l2.278-2.278L.00017,9.8277"/>
                                            </svg>
                                            <!-- Hover Arrow SVG (white) -->
                                            <svg class="absolute inset-0 w-full h-full transition-opacity duration-300 ease-in-out"
                                                 :class="{ 'opacity-100': contactHoverOverlay, 'opacity-0': !contactHoverOverlay }"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.9121 15.70432" aria-hidden="true">
                                                <path stroke="#fff" fill="none" d="M.0001,5.8837h25.3l-2.275-2.283c-.70941-.70913-.70963-1.85909-.0005-2.5685.70913-.70941,1.85909-.70963,2.5685-.0005l6.819,6.819-6.821,6.822c-.71024.70941-1.86109.70874-2.5705-.0015-.70941-.71024-.70874-1.86109.0015-2.5705l2.278-2.278L.0001,9.8277"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>

                                <!-- Dark Mode Selector and Language -->
                                <div class="flex items-center space-x-4">
                                    <?php
                                    // Dark Mode Selector
                                    get_template_part('template-parts/components/dark-mode-selector-overlay', null, array(
                                        'selector_id' => 'dark-mode-selector-desktop-overlay'
                                    ));
                                    ?>

                                    <?php
                                    // Check if a multilingual plugin is active
                                    if ((function_exists('pll_the_languages') || function_exists('icl_get_languages'))) :
                                        $show_switcher = true;
                                        // If show_language_switcher is explicitly set to false, don't show
                                        if ($show_language_switcher === false || $show_language_switcher === 0) {
                                            $show_switcher = false;
                                        }

                                        if ($show_switcher) :
                                            ?>
                                            <div class="relative" x-data="{ langOpenOverlay: false }" @click.away="langOpenOverlay = false">
                                                <?php
                                                // Polylang support
                                                if (function_exists('pll_the_languages')) {
                                                    $languages = pll_the_languages(array('raw' => 1));
                                                    $current_lang = null;

                                                    if ($languages) {
                                                        // Sort languages: Deutsch (DE) always first
                                                        usort($languages, function($a, $b) {
                                                            if ($a['slug'] === 'de') return -1;
                                                            if ($b['slug'] === 'de') return 1;
                                                            return 0;
                                                        });

                                                        // Get current language
                                                        foreach ($languages as $lang) {
                                                            if ($lang['current_lang']) {
                                                                $current_lang = $lang;
                                                                break;
                                                            }
                                                        }

                                                        if ($current_lang) :
                                                            ?>
                                                            <!-- Language Button -->
                                                            <button
                                                                @click="langOpenOverlay = !langOpenOverlay"
                                                                class="flex items-center space-x-2 cursor-pointer bg-white/10 hover:bg-white/20 rounded-full px-4 py-2 nav-link text-white transition-all duration-200"
                                                                aria-expanded="false"
                                                                :aria-expanded="langOpenOverlay.toString()"
                                                            >
                                                                <?php if (!empty($current_lang['flag'])) : ?>
                                                                    <img src="<?php echo esc_url($current_lang['flag']); ?>"
                                                                         alt="<?php echo esc_attr($current_lang['name']); ?>"
                                                                         class="w-5 h-3 rounded-sm">
                                                                <?php endif; ?>
                                                                <span class="font-medium cursor-pointer "><?php echo esc_html($current_lang['name']); ?></span>
                                                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': langOpenOverlay }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                </svg>
                                                            </button>

                                                            <!-- Dropdown Menu -->
                                                            <div
                                                                x-show="langOpenOverlay"
                                                                x-transition:enter="transition ease-out duration-200"
                                                                x-transition:enter-start="opacity-0 transform scale-95"
                                                                x-transition:enter-end="opacity-100 transform scale-100"
                                                                x-transition:leave="transition ease-in duration-150"
                                                                x-transition:leave-start="opacity-100 transform scale-100"
                                                                x-transition:leave-end="opacity-0 transform scale-95"
                                                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#2d2d2d] rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50"
                                                                style="display: none;"
                                                            >
                                                                <?php foreach ($languages as $lang) : ?>
                                                                    <a
                                                                        href="<?php echo esc_url($lang['url']); ?>"
                                                                        class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors <?php echo $lang['current_lang'] ? 'bg-gray-50 dark:bg-gray-700' : ''; ?>"
                                                                        hreflang="<?php echo esc_attr($lang['slug']); ?>"
                                                                    >
                                                                        <?php if (!empty($lang['flag'])) : ?>
                                                                            <img src="<?php echo esc_url($lang['flag']); ?>"
                                                                                 alt="<?php echo esc_attr($lang['name']); ?>"
                                                                                 class="w-5 h-3 rounded-sm">
                                                                        <?php endif; ?>
                                                                        <span class="nav-link uppercase"><?php echo esc_html($lang['slug']); ?></span>
                                                                        <?php if ($lang['current_lang']) : ?>
                                                                            <svg class="w-4 h-4 ml-auto text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                        <?php endif; ?>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif;
                                                    }
                                                }
                                                // WPML support
                                                elseif (function_exists('icl_get_languages')) {
                                                    $languages = icl_get_languages('skip_missing=0');
                                                    $current_lang = null;

                                                    if ($languages) {
                                                        foreach ($languages as $lang) {
                                                            if ($lang['active']) {
                                                                $current_lang = $lang;
                                                                break;
                                                            }
                                                        }

                                                        if ($current_lang) :
                                                            ?>
                                                            <!-- Language Button (WPML) -->
                                                            <button
                                                                @click="langOpenOverlay = !langOpenOverlay"
                                                                class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 rounded-full px-4 py-2 nav-link text-white transition-all duration-200"
                                                            >
                                                                <?php if (!empty($current_lang['country_flag_url'])) : ?>
                                                                    <img src="<?php echo esc_url($current_lang['country_flag_url']); ?>"
                                                                         alt="<?php echo esc_attr($current_lang['native_name']); ?>"
                                                                         class="w-5 h-3 rounded-sm">
                                                                <?php endif; ?>
                                                                <span class="font-medium"><?php echo esc_html($current_lang['native_name']); ?></span>
                                                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': langOpenOverlay }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                </svg>
                                                            </button>

                                                            <!-- Dropdown Menu (WPML) -->
                                                            <div
                                                                x-show="langOpenOverlay"
                                                                x-transition
                                                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#2d2d2d] rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50"
                                                                style="display: none;"
                                                            >
                                                                <?php foreach ($languages as $lang) : ?>
                                                                    <a
                                                                        href="<?php echo esc_url($lang['url']); ?>"
                                                                        class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors <?php echo $lang['active'] ? 'bg-gray-50 dark:bg-gray-700' : ''; ?>"
                                                                    >
                                                                        <?php if (!empty($lang['country_flag_url'])) : ?>
                                                                            <img src="<?php echo esc_url($lang['country_flag_url']); ?>"
                                                                                 alt="<?php echo esc_attr($lang['native_name']); ?>"
                                                                                 class="w-5 h-3 rounded-sm">
                                                                        <?php endif; ?>
                                                                        <span class="nav-link uppercase"><?php echo esc_html($lang['code']); ?></span>
                                                                        <?php if ($lang['active']) : ?>
                                                                            <svg class="w-4 h-4 ml-auto text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                        <?php endif; ?>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        endif;
                                    else :
                                        // Fallback: show Deutsch if no multilingual plugin
                                        ?>
                                        <div class="relative">
                                            <button class="flex items-center space-x-2 bg-white/10 rounded-full px-4 py-2 nav-link text-white cursor-not-allowed opacity-75">
                                                <svg class="w-5 h-3" viewBox="0 0 5 3" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="5" height="3" fill="#000"/>
                                                    <rect width="5" height="2" y="1" fill="#D00"/>
                                                    <rect width="5" height="1" y="2" fill="#FFCE00"/>
                                                </svg>
                                                <span class="uppercase font-medium">DE</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav class="hidden lg:block mt-8">
                        <?php
                        wp_nav_menu(array(
                                'theme_location'  => 'primary',
                                'container'       => false,
                                'menu_class'      => 'flex items-center space-x-12 !text-white ',
                                'walker'          => new Ossenberg_Engels_Header_Walker(),
                                'depth'           => 1, // Only show top-level items (hide submenus)
                                'fallback_cb'     => false // No fallback - display nothing if menu doesn't exist
                        ));
                        ?>


                    </nav>
                </div>

            </div>

            <!-- Close Button -->
            <button
                    @click="menuOpen = false; activeOverlay = null"
                    class="bg-black hover:bg-gray-900 text-white transition-colors rounded-full p-4 cursor-pointer fixed top-4 xl:top-18 right-4 z-50"
                    aria-label="Close navigation menu">
                <svg class="w-6 h-6 cursor-pointer" viewBox="0 0 18.5229 18.17217" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path d="M14.27055,7.05806l2.60852-2.60852c.79428-.82991.7654-2.14657-.06451-2.94086-.80428-.76976-2.07206-.76976-2.87635,0l-4.74751,4.74751L4.04225,1.10775c-.81034-.81034-2.12416-.81034-2.93449,0s-.81034,2.12416,0,2.93449l5.09824,5.09824L1.64516,13.72112c-.7871.83748-.74625,2.15447.09123,2.94156.80099.7528,2.04934.7528,2.85033,0l4.7461-4.7461,5.14845,5.14845c.81068.81,2.12449.80945,2.93449-.00123.80952-.8102.80952-2.12307,0-2.93326l-5.58261-5.58261"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="1"
                              stroke-linejoin="round"/>
                    </g>
                </svg>
            </button>
        </div>
        <!-- Navigation Content -->
        <nav class="relative z-10 flex flex-col items-start justify-between">
            <!-- Dynamic Menu Title -->
            <h1 class="text-white text-[72px] font-light" x-cloak x-text="activeMenuTitle" x-show="activeMenuTitle"></h1>

            <?php
            // Display submenu of clicked menu item using custom overlay walker
            if (has_nav_menu('primary')) :
                ?>
                <div x-data="{ menuId: activeMenuId }" class="w-full relative" :style="activeSubmenu ? 'min-height: 200px;' : ''">
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'primary',
                        'container'       => false,
                        'menu_class'      => 'text-white text-lg text-white  ',
                        'walker'          => new Ossenberg_Engels_Overlay_Walker(),
                        'fallback_cb'     => false
                    ));
                    ?>
                </div>
                <?php
            else :
                // Fallback if no menu is assigned
                echo '<p class="text-white text-lg">Bitte erstellen Sie ein Menü unter "Design" > "Menüs" und weisen Sie es dem Standort "Primary Menu" zu.</p>';
            endif;
            ?>
        </nav>
        </div>
    </div>
    <!-- End desktop-overlay-content-wrapper -->
</div>
