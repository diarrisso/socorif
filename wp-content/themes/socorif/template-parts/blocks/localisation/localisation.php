<?php
/**
 * Standort/Karte Block Template - Nur Google Map (Full Width)
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('location');

// Felder abrufen
$title = socorif_get_field('title');
$description = socorif_get_field('description');
$map_embed = socorif_get_field('map_embed');
$bg_color = socorif_get_field('bg_color', 'white');

// Textfarbe basierend auf Hintergrund (mit Dark Mode Support)
$is_dark_bg = $bg_color === 'secondary-dark';
$text_color = $is_dark_bg ? 'text-white' : 'text-gray-900 dark:text-white';
$text_muted = $is_dark_bg ? 'text-gray-300' : 'text-gray-600 dark:text-gray-300';

// Dark mode background mapping
$dark_bg_classes = [
    'white' => 'dark:bg-gray-900',
    'gray-50' => 'dark:bg-gray-800',
    'secondary-dark' => '', // Already dark
];

// Section-Klassen erstellen
$section_classes = socorif_merge_classes(
    'location-block section',
    'bg-' . $bg_color,
    $dark_bg_classes[$bg_color] ?? 'dark:bg-gray-900'
);

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    echo '<section ' . $wrapper_attrs . '>';
} else {
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>

    <?php if ($title || $description) : ?>
        <!-- Text centered in container -->
        <div class="container text-center mb-12 md:mb-16">
            <?php if ($title) : ?>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold <?php echo esc_attr($text_color); ?> mb-6">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($description) : ?>
                <p class="text-lg md:text-xl lg:text-2xl <?php echo esc_attr($text_muted); ?> max-w-4xl mx-auto leading-relaxed">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($map_embed) : ?>
        <!-- Karte - Full width with side padding -->
        <div class="px-4 md:px-8 lg:px-12">
            <div class="location-map-container rounded-3xl overflow-hidden shadow-xl dark:shadow-black/40 h-[450px] md:h-[550px] lg:h-[700px] xl:h-[750px]">
                <style>
                    .location-map-container iframe {
                        width: 100% !important;
                        height: 100% !important;
                        display: block !important;
                        border: 0 !important;
                    }
                </style>
                <?php
                // Sicherstellen, dass der Embed-Code nur iframes enthält
                $allowed_html = [
                    'iframe' => [
                        'src' => [],
                        'width' => [],
                        'height' => [],
                        'style' => [],
                        'frameborder' => [],
                        'allowfullscreen' => [],
                        'loading' => [],
                        'referrerpolicy' => [],
                    ]
                ];
                echo wp_kses($map_embed, $allowed_html);
                ?>
            </div>
        </div>
    <?php elseif (current_user_can('edit_posts')) : ?>
        <!-- Placeholder for admins - Full width -->
        <div class="px-4 md:px-8 lg:px-12">
            <div class="rounded-3xl bg-secondary-dark h-[450px] md:h-[550px] lg:h-[700px] xl:h-[750px] flex items-center justify-center">
                <div class="text-center p-8">
                    <svg class="w-16 h-16 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-gray-400 mb-2 font-medium">Carte Google Maps non configuree</p>
                    <p class="text-gray-500 text-sm">Ajoutez le code iframe depuis Google Maps dans les parametres du bloc.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('location');
