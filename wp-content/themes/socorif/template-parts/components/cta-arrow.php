<?php
/**
 * CTA Arrow Component
 *
 * Composant reutilisable pour afficher les fleches SVG avec animation hover
 * Utilise dans les liens CTA (En savoir plus, etc.)
 *
 * @package Socorif
 *
 * Usage:
 * get_template_part('template-parts/components/cta-arrow', null, array(
 *     'hover_state' => 'linkHover',  // Variable Alpine.js pour le hover
 * ));
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get parameters
$hover_state = $args['hover_state'] ?? 'linkHover';
$arrow_color = $args['arrow_color'] ?? 'currentColor';
?>

<span class="relative w-8 h-4 inline-block transition-transform duration-300 ease-in-out overflow-visible"
      :class="{ 'translate-x-3': <?php echo esc_attr($hover_state); ?> }">

    <!-- Normal Arrow SVG (short version) -->
    <svg
        class="arrow-svg absolute inset-0 w-full h-full transition-opacity duration-300 ease-in-out"
        :class="{ 'opacity-0': <?php echo esc_attr($hover_state); ?>, 'opacity-100': !<?php echo esc_attr($hover_state); ?> }"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 21.91317 15.70572"
        aria-hidden="true"
    >
        <path stroke="<?php echo esc_attr($arrow_color); ?>"
              fill="none"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M.00017,5.8837h14.307l-2.282-2.283c-.70941-.70913-.70963-1.85909-.0005-2.5685.70913-.70941,1.85909-.70963,2.5685-.0005h0l6.819,6.819-6.821,6.822c-.71024.70941-1.86109.70874-2.5705-.0015-.70941-.71024-.70874-1.86109.0015-2.5705h0l2.278-2.278L.00017,9.8277"/>
    </svg>

    <!-- Hover Arrow SVG (long version) -->
    <svg
        class="arrow-svg absolute inset-0 w-full h-full transition-opacity duration-300 ease-in-out"
        :class="{ 'opacity-100': <?php echo esc_attr($hover_state); ?>, 'opacity-0': !<?php echo esc_attr($hover_state); ?> }"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 32.9121 15.70432"
        aria-hidden="true"
    >
        <path stroke="<?php echo esc_attr($arrow_color); ?>"
              fill="none"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M.0001,5.8837h25.3l-2.275-2.283c-.70941-.70913-.70963-1.85909-.0005-2.5685.70913-.70941,1.85909-.70963,2.5685-.0005h0l6.819,6.819-6.821,6.822c-.71024.70941-1.86109.70874-2.5705-.0015-.70941-.71024-.70874-1.86109.0015-2.5705h0l2.278-2.278L.0001,9.8277"/>
    </svg>
</span>
