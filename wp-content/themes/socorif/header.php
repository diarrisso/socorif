<?php
/**
 * Header Template - Modern Navbar
 */

if (!defined('ABSPATH')) exit;

// Get header options
$header_logo = get_field('header_logo', 'option');
$header_logo_dark = get_field('header_logo_dark', 'option');
$header_phone = get_field('header_phone', 'option');
$header_cta = get_field('header_cta', 'option');
$header_sticky = get_field('header_sticky', 'option') ?: 'mobile';
$header_logo_height = get_field('header_logo_height', 'option') ?: 80;

// Banner options
$banner_enabled = get_field('header_banner_enabled', 'option');
$banner_text = get_field('header_banner_text', 'option');
$banner_highlight = get_field('header_banner_highlight', 'option');
$banner_link = get_field('header_banner_link', 'option');
$banner_dismissable = get_field('header_banner_dismissable', 'option');

// Build sticky classes based on option
$sticky_classes = 'relative';
if ($header_sticky === 'mobile') {
    $sticky_classes = 'fixed lg:relative';
} elseif ($header_sticky === 'desktop') {
    $sticky_classes = 'relative lg:fixed';
} elseif ($header_sticky === 'all') {
    $sticky_classes = 'fixed';
}

// Logo height style
$logo_style = 'height: ' . intval($header_logo_height) . 'px; width: auto;';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script>
        // Apply dark mode immediately to prevent flash of unstyled content
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            if (theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

    <!-- Google Fonts - Montserrat & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white dark:bg-gray-900 text-gray-900 dark:text-white'); ?> x-data="{ mobileMenuOpen: false }">

<?php if ($banner_enabled && ($banner_text || $banner_highlight)) : ?>
<!-- BANNER -->
<div class="relative isolate flex items-center gap-x-6 overflow-hidden bg-gray-800 px-6 py-2.5 sm:px-3.5 sm:before:flex-1"
     x-data="{ dismissed: localStorage.getItem('banner_dismissed') === 'true' }"
     x-show="!dismissed"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <!-- Decorative blurs -->
    <div aria-hidden="true" class="absolute top-1/2 left-[max(-7rem,calc(50%-52rem))] -z-10 -translate-y-1/2 transform-gpu blur-2xl">
        <div style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)" class="aspect-[577/310] w-[36rem] bg-gradient-to-r from-primary to-accent opacity-30"></div>
    </div>
    <div aria-hidden="true" class="absolute top-1/2 left-[max(45rem,calc(50%+8rem))] -z-10 -translate-y-1/2 transform-gpu blur-2xl">
        <div style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)" class="aspect-[577/310] w-[36rem] bg-gradient-to-r from-primary to-accent opacity-30"></div>
    </div>

    <!-- Content -->
    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
        <p class="text-sm/6 text-gray-100">
            <?php if ($banner_highlight) : ?>
                <strong class="font-semibold"><?php echo esc_html($banner_highlight); ?></strong>
                <svg viewBox="0 0 2 2" aria-hidden="true" class="mx-2 inline size-0.5 fill-current"><circle r="1" cx="1" cy="1" /></svg>
            <?php endif; ?>
            <?php echo esc_html($banner_text); ?>
        </p>
        <?php if ($banner_link) : ?>
            <a href="<?php echo esc_url($banner_link['url']); ?>"
               class="flex-none rounded-3xl bg-white/10 px-3.5 py-1 text-sm font-semibold text-white hover:bg-white/20 transition-all duration-200 hover:scale-105 active:scale-95 cursor-pointer"
               <?php echo $banner_link['target'] ? 'target="' . esc_attr($banner_link['target']) . '"' : ''; ?>>
                <?php echo esc_html($banner_link['title']); ?> <span aria-hidden="true">&rarr;</span>
            </a>
        <?php endif; ?>
    </div>

    <!-- Dismiss button -->
    <?php if ($banner_dismissable) : ?>
    <div class="flex flex-1 justify-end">
        <button type="button"
                class="-m-3 p-3 focus-visible:outline-offset-[-4px] hover:bg-white/10 rounded-3xl transition-all duration-200 hover:scale-110 active:scale-95 cursor-pointer"
                @click="dismissed = true; localStorage.setItem('banner_dismissed', 'true')">
            <span class="sr-only">Fermer</span>
            <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5 text-gray-100">
                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
            </svg>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- HEADER -->
<header class="<?php echo esc_attr($sticky_classes); ?> top-0 left-0 right-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 transition-all duration-300"
        x-data="{
            scrolled: false,
            init() {
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 20;
                });
            }
        }"
        :class="{ 'shadow-lg bg-white/95 dark:bg-gray-900/95 backdrop-blur-md': scrolled }">

    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-20 lg:h-24">

            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex-shrink-0 transition-transform duration-300 hover:scale-105 cursor-pointer">
                <?php if ($header_logo) : ?>
                    <img src="<?php echo esc_url($header_logo['url']); ?>"
                         alt="<?php echo esc_attr($header_logo['alt'] ?: get_bloginfo('name')); ?>"
                         class=" h-20 lg:h-28 w-auto dark:brightness-0 dark:invert" />
                <?php else : ?>
                    <span class="text-2xl lg:text-3xl font-bold text-primary"><?php bloginfo('name'); ?></span>
                <?php endif; ?>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center relative">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex items-center space-x-1',
                    'fallback_cb' => false,
                    'link_before' => '',
                    'link_after' => '',
                    'walker' => class_exists('Beka_Nav_Walker') ? new Beka_Nav_Walker() : null,
                ]);
                ?>
            </nav>

            <!-- Right side: Phone + Dark Mode (Desktop only pour phone) -->
            <div class="hidden lg:flex items-center gap-4">
                <?php if ($header_phone) : ?>
                    <a href="tel:<?php echo esc_attr(socorif_format_phone($header_phone)); ?>"
                       class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors duration-300 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="font-medium"><?php echo esc_html($header_phone); ?></span>
                    </a>
                <?php endif; ?>

                <?php socorif_component('dark-mode-selector'); ?>
            </div>

            <!-- Mobile: Dark Mode + Hamburger -->
            <div class="flex lg:hidden items-center gap-3">
                <?php socorif_component('dark-mode-selector'); ?>

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="relative w-11 h-11 flex flex-col items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer group"
                        aria-label="Menu">
                    <span class="sr-only">Menu</span>

                    <!-- Hamburger icon mit Animation -->
                    <div class="relative w-6 h-5 flex flex-col justify-center gap-1.5">
                        <span class="block h-0.5 w-6 bg-primary eka  group-hover:bg-primary-dark dark:group-hover:bg-primary rounded-sm transition-all duration-300 ease-in-out"
                              :class="{ 'rotate-45 translate-y-2': mobileMenuOpen, 'rotate-0 translate-y-0': !mobileMenuOpen }"></span>
                        <span class="block h-0.5 w-6 bg-primary dark:bg-white group-hover:bg-primary-dark dark:group-hover:bg-primary rounded-sm transition-all duration-200"
                              :class="{ 'opacity-0': mobileMenuOpen, 'opacity-100': !mobileMenuOpen }"></span>
                        <span class="block h-0.5 w-6 bg-primary dark:bg-white group-hover:bg-primary-dark dark:group-hover:bg-primary rounded-sm transition-all duration-300 ease-in-out"
                              :class="{ '-rotate-45 -translate-y-2': mobileMenuOpen, 'rotate-0 translate-y-0': !mobileMenuOpen }"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

</header>

<?php get_template_part('template-parts/navigation/mobile-overlay'); ?>

<?php if ($header_sticky !== 'none') : ?>
<!-- Spacer for fixed header -->
<?php if ($header_sticky === 'mobile') : ?>
<div class="h-20 lg:h-0"></div>
<?php elseif ($header_sticky === 'desktop') : ?>
<div class="h-0"></div>
<?php elseif ($header_sticky === 'all') : ?>
<div class="h-0"></div>
<?php endif; ?>
<?php endif; ?>
