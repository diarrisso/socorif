<?php
/**
 * Contact Link Component
 * Reusable contact link for header (desktop and mobile)
 *
 * @package Ossenberg_Engels
 *
 * Variables available:
 * - $args['contact_link']: URL for contact link
 * - $args['contact_text']: Text for contact link
 * - $args['is_mobile']: Boolean to determine if mobile version (default: false)
 */

if (!defined('ABSPATH')) exit;

// Extract args passed from get_template_part()
$contact_link = $args['contact_link'] ?? get_field('header_topbar_contact_link', 'option') ?? home_url('/kontakt');
$contact_text = $args['contact_text'] ?? (function_exists('pll__') ? pll__('Kontaktieren Sie uns') : 'Kontaktieren Sie uns');
$is_mobile = $args['is_mobile'] ?? false;

if ($is_mobile) :
    // Mobile version - Icon only
    ?>
    <a href="<?php echo esc_url($contact_link); ?>"
       class="flex items-center gap-1 text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors text-sm"
       aria-label="<?php echo esc_attr($contact_text); ?>">
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
            <path d="M18 4H2C0.9 4 0.01 4.9 0.01 6L0 14C0 15.1 0.9 16 2 16H18C19.1 16 20 15.1 20 14V6C20 4.9 19.1 4 18 4ZM18 8L10 11.5L2 8V6L10 9.5L18 6V8Z" fill="currentColor"/>
        </svg>
    </a>
<?php else : ?>
    <!-- Desktop version - Full text with animated arrow -->
    <div x-data="{ contactHover: false }">
        <a href="<?php echo esc_url($contact_link); ?>"
           class="font-light text-[16px] leading-[19px] inline-flex items-center gap-2 text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors"
           @mouseenter="contactHover = true"
           @mouseleave="contactHover = false">
            <span><?php echo esc_html($contact_text); ?></span>
            <span class="relative w-8 h-4 inline-block transition-transform duration-300 ease-in-out overflow-visible"
                  :class="{ 'translate-x-3': contactHover }">
                <!-- Normal Arrow SVG -->
                <svg
                    class="absolute inset-0 w-full h-full transition-opacity duration-300 ease-in-out"
                    :class="{ 'opacity-0': contactHover, 'opacity-100': !contactHover }"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 21.91317 15.70572"
                    aria-hidden="true">
                    <path stroke="currentColor" fill="none" d="M.00017,5.8837h14.307l-2.282-2.283c-.70941-.70913-.70963-1.85909-.0005-2.5685.70913-.70941,1.85909-.70963,2.5685-.0005l6.819,6.819-6.821,6.822c-.71024.70941-1.86109.70874-2.5705-.0015s-.70874-1.86109.0015-2.5705l2.278-2.278L.00017,9.8277"/>
                </svg>
                <!-- Hover Arrow SVG -->
                <svg
                    class="absolute inset-0 w-full h-full transition-opacity duration-300 ease-in-out"
                    :class="{ 'opacity-100': contactHover, 'opacity-0': !contactHover }"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 32.9121 15.70432"
                    aria-hidden="true">
                    <path stroke="currentColor" fill="none" d="M.0001,5.8837h25.3l-2.275-2.283c-.70941-.70913-.70963-1.85909-.0005-2.5685.70913-.70941,1.85909-.70963,2.5685-.0005l6.819,6.819-6.821,6.822c-.71024.70941-1.86109-.70874-2.5705-.0015-.70941-.71024-.70874-1.86109.0015-2.5705l2.278-2.278L.0001,9.8277"/>
                </svg>
            </span>
        </a>
    </div>
<?php endif; ?>
