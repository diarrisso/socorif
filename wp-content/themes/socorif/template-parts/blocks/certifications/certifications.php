<?php
/**
 * Zertifizierungen/Auszeichnungen Block Template
 * Minimalistisches Logo-Grid Design
 */

if (!defined('ABSPATH')) exit;

// Felder abrufen
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$description = socorif_get_field('description');
$certifications = socorif_get_field('certifications', []);
$bg_color = socorif_get_field('bg_color', 'white');

// Textfarbe basierend auf Hintergrund
$is_dark_bg = $bg_color === 'secondary-dark';
$text_color = $is_dark_bg ? 'text-white' : 'text-gray-900';
$text_muted = $is_dark_bg ? 'text-gray-300' : 'text-gray-600';

// Section-Klassen erstellen
$section_classes = socorif_merge_classes(
    'certifications-block py-24 sm:py-32',
    'bg-' . $bg_color,
    $is_dark_bg ? '' : 'dark:bg-gray-900'
);

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    socorif_block_comment_start('certifications');
    echo '<section ' . $wrapper_attrs . '>';
} else {
    socorif_block_comment_start('certifications');
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>
    <div class="container mx-auto px-4 lg:px-8">

        <?php if ($subtitle || $title || $description) : ?>
            <!-- Sektion Kopfbereich -->
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 class="section-title <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-3 md:mb-4">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <p class="section-description <?php echo esc_attr($text_muted); ?> <?php echo $is_dark_bg ? '' : 'dark:text-gray-300'; ?>">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($certifications) : ?>
            <!-- Zertifizierungen Logo Grid -->
            <div class="mx-auto grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-12 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 sm:gap-y-14 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                <?php foreach ($certifications as $index => $cert) : ?>
                    <?php if (!empty($cert['logo'])) :
                        // Bestimme col-span basierend auf Position im Grid
                        $col_span = 'col-span-2 lg:col-span-1';

                        // Spezielle col-start Regeln für die letzten beiden Elemente
                        $total = count($certifications);
                        if ($index === $total - 2) {
                            $col_span .= ' sm:col-start-2';
                        } elseif ($index === $total - 1) {
                            $col_span .= ' col-start-2 sm:col-start-auto';
                        }
                    ?>
                        <img
                            src="<?php echo esc_url($cert['logo']['url'] ?? ''); ?>"
                            alt="<?php echo esc_attr($cert['title'] ?? $cert['logo']['alt'] ?? ''); ?>"
                            width="158"
                            height="48"
                            class="<?php echo esc_attr($col_span); ?> max-h-12 w-full object-contain <?php echo $is_dark_bg ? 'brightness-0 invert' : 'dark:brightness-0 dark:invert'; ?>"
                        />
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php socorif_block_comment_end('certifications'); ?>
