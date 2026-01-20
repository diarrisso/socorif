<?php
/**
 * Services Icons Block Template
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('services-icons');


// Felder abrufen
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$services = socorif_get_field('services', []);
$columns = socorif_get_field('columns', '4');
$bg_color = socorif_get_field('bg_color', 'gray-50');

// Spalten-Klassen - Mobile-first responsive
$grid_cols = [
    '2' => 'grid-cols-1 md:grid-cols-2',
    '3' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    '4' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
];

$section_classes = socorif_merge_classes(
    'services-icons-block section',
    'bg-' . $bg_color,
    'dark:bg-gray-900'
);

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    echo '<section ' . $wrapper_attrs . '>';
} else {
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>
    <div class="container">

        <?php if ($subtitle || $title) : ?>
            <div class="text-center mb-8 md:mb-12">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm inline-flex items-center gap-2">
                        <span class="w-3 h-3 bg-primary"></span>
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 class="section-title">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($services) : ?>
            <div class="grid <?php echo esc_attr($grid_cols[$columns]); ?> gap-6 md:gap-8">
                <?php foreach ($services as $service) : ?>
                    <div class="group bg-gradient-to-br from-white via-white to-gray-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 p-8 md:p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-transparent hover:border-primary/20 cursor-pointer">
                        <?php if (!empty($service['icon'])) : ?>
                            <div class="mb-6 w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-primary/10 to-primary/20 dark:from-primary/20 dark:to-primary/30 rounded-3xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-primary/10">
                                <?php echo socorif_image($service['icon'], 'thumbnail', ['class' => 'w-10 h-10 md:w-12 md:h-12 object-contain']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($service['title'])) : ?>
                            <h3 class="section-subtitle mb-3">
                                <?php echo esc_html($service['title']); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if (!empty($service['description'])) : ?>
                            <p class="text-sm md:text-base text-gray-600 mb-4 leading-relaxed dark:text-gray-300">
                                <?php echo esc_html($service['description']); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($service['link'])) : ?>
                            <a href="<?php echo esc_url($service['link']['url']); ?>"
                               class="text-primary font-semibold uppercase text-xs md:text-sm tracking-wider hover:text-primary-dark transition-colors cursor-pointer"
                               <?php echo !empty($service['link']['target']) ? 'target="' . esc_attr($service['link']['target']) . '"' : ''; ?>>
                                <?php echo esc_html($service['link']['title'] ?: 'Voir les projets'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('services-icons');
