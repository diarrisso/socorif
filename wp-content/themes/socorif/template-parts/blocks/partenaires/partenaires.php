<?php
/**
 * Partners Block Template
 *
 * Funktioniert sowohl als eigenständiger ACF Block als auch als Flexible Content Layout
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('partners');


// Daten abrufen (funktioniert für beide: ACF Block & Flexible Content)
$partners = socorif_get_field('partenaires', []);

// Badge-Daten - Unterschiedliche Struktur je nach Kontext
if (function_exists('get_row_layout') && get_row_layout()) {
    // Flexible Content - Felder sind direkt verfügbar
    $show_badge = socorif_get_field('show_badge', true);
    $badge_text = socorif_get_field('badge_text', '');
    $badge_link_text = socorif_get_field('badge_link_text', '');
    $badge_link = socorif_get_field('badge_link', null);
} else {
    // ACF Block - Felder sind in einer Gruppe
    $badge_section = socorif_get_field('badge_section', []);
    $show_badge = $badge_section['show_badge'] ?? true;
    $badge_text = $badge_section['badge_text'] ?? '';
    $badge_link_text = $badge_section['badge_link_text'] ?? '';
    $badge_link = $badge_section['badge_link'] ?? null;
}

// Section-Klassen
$section_classes = 'partners-block bg-white py-24 sm:py-32 dark:bg-gray-900';

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    echo '<section ' . $wrapper_attrs . '>';
} else {
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>
    <div class="container mx-auto px-4 lg:px-8">

        <?php if ($partners) : ?>
            <!-- Partner-Logos Grid -->
            <div class="mx-auto grid max-w-lg grid-cols-2 items-center gap-x-8 gap-y-12 sm:max-w-xl sm:grid-cols-3 sm:gap-x-10 sm:gap-y-14 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                <?php foreach ($partners as $partner) : ?>
                    <?php
                    $logo_light = $partner['logo_light'] ?? null;
                    $logo_dark = $partner['logo_dark'] ?? null;
                    $alt_text = $partner['alt_text'] ?? 'Logo partenaire';

                    // Skip if no logo at all
                    if (!$logo_light && !$logo_dark) continue;

                    // Use available logo as fallback
                    $logo_for_light = $logo_light ?: $logo_dark;
                    $logo_for_dark = $logo_dark ?: $logo_light;
                    ?>

                    <!-- Logo for light mode -->
                    <?php echo socorif_image($logo_for_light, 'medium', [
                        'class' => 'max-h-16 w-full object-contain dark:hidden',
                        'alt' => esc_attr($alt_text),
                        'width' => 158,
                        'height' => 64,
                    ]); ?>

                    <!-- Logo for dark mode (with invert filter if same as light) -->
                    <?php
                    $dark_class = 'max-h-16 w-full object-contain hidden dark:block';
                    if (!$logo_dark && $logo_light) {
                        $dark_class .= ' brightness-0 invert'; // Invert light logo for dark mode
                    }
                    echo socorif_image($logo_for_dark, 'medium', [
                        'class' => $dark_class,
                        'alt' => esc_attr($alt_text),
                        'width' => 158,
                        'height' => 64,
                    ]); ?>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($show_badge && ($badge_text || $badge_link)) : ?>
            <!-- Badge-Bereich mit gelbem Hintergrund -->
            <div class="mt-16 flex justify-center">
                <div class="relative group">
                    <p class=" hover:cursor-pointer relative rounded-full bg-primary/10 dark:bg-primary/20 px-6 py-3 text-sm/6 font-medium text-gray-900 dark:text-white border-2 border-primary/30 dark:border-primary/40 shadow-lg shadow-primary/20 transition-all duration-300 hover:bg-primary/20 dark:hover:bg-primary/30 hover:border-primary hover:shadow-xl hover:shadow-primary/30 hover:scale-105">

                        <?php if ($badge_text) : ?>
                            <span class=" md:inline"><?php echo esc_html($badge_text); ?></span>
                        <?php endif; ?>

                        <?php if ($badge_link && !empty($badge_link['url'])) : ?>
                            <a href="<?php echo esc_url($badge_link['url']); ?>"
                               <?php if (!empty($badge_link['target'])) : ?>
                                   target="<?php echo esc_attr($badge_link['target']); ?>"
                                   <?php if ($badge_link['target'] === '_blank') : ?>
                                       rel="noopener noreferrer"
                                   <?php endif; ?>
                               <?php endif; ?>
                               class="font-bold text-primary hover:text-primary-dark dark:text-primary dark:hover:text-primary transition-colors duration-200 cursor-pointer">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                <?php echo esc_html($badge_link_text ?: $badge_link['title']); ?>
                                <span aria-hidden="true" class="inline-block ml-1 transition-transform duration-200 group-hover:translate-x-1">&rarr;</span>
                            </a>
                        <?php endif; ?>

                    </p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('partners');
