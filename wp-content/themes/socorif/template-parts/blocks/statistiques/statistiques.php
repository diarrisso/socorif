<?php
/**
 * Statistiken/Zahlen Block Template
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('stats');


// Felder abrufen
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$stats = socorif_get_field('statistiques', []);
$columns = socorif_get_field('columns', '4');
$bg_color = socorif_get_field('bg_color', 'gray-50');

// Spalten-Klassen - Mobile-first responsive
$grid_cols = [
    '2' => 'grid-cols-1 md:grid-cols-2',
    '3' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
    '4' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
];

// Textfarbe basierend auf Hintergrund
$is_dark_bg = $bg_color === 'secondary-dark';
$text_color = $is_dark_bg ? 'text-white' : '';
$text_muted = $is_dark_bg ? 'text-gray-300' : 'text-gray-600';
$card_bg = $is_dark_bg ? 'bg-white/10' : 'bg-white';

// Section-Klassen erstellen mit Dark-Mode Support
$section_classes = socorif_merge_classes(
    'stats-block section',
    'bg-' . $bg_color,
    $is_dark_bg ? '' : 'dark:bg-gray-900'
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
            <!-- Sektion Kopfbereich -->
            <div class="text-center max-w-3xl mx-auto mb-8 md:mb-12">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 class="section-title <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?>">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($stats) : ?>
            <!-- Statistiken Grid -->
            <div class="grid <?php echo esc_attr($grid_cols[$columns]); ?> gap-6 md:gap-8">
                <?php foreach ($stats as $index => $stat) : ?>
                    <div class="group relative bg-gradient-to-br from-white via-gray-50 to-white dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 p-8 md:p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 text-center border-2 border-transparent hover:border-primary/20 overflow-hidden"
                         x-data="{
                             count: 0,
                             target: <?php echo absint($stat['number'] ?? 0); ?>,
                             duration: 2000,
                             animated: false
                         }"
                         x-intersect.once="
                             if (!animated) {
                                 animated = true;
                                 let start = 0;
                                 let increment = target / (duration / 16);
                                 let timer = setInterval(() => {
                                     start += increment;
                                     if (start >= target) {
                                         count = target;
                                         clearInterval(timer);
                                     } else {
                                         count = Math.floor(start);
                                     }
                                 }, 16);
                             }
                         ">

                        <!-- Decorative background -->
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>

                        <div class="relative z-10">
                            <?php if (!empty($stat['icon'])) : ?>
                                <!-- Icon -->
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-primary/10 to-primary/20 dark:from-primary/20 dark:to-primary/30 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/10 group-hover:scale-110 transition-transform duration-300">
                                    <span class="text-2xl md:text-3xl"><?php echo esc_html($stat['icon']); ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Zahl mit Animation -->
                            <div class="text-4xl md:text-5xl lg:text-6xl font-bold text-primary mb-3 group-hover:scale-105 transition-transform duration-300">
                                <span x-text="count.toLocaleString('de-DE')"></span><?php echo esc_html($stat['suffix'] ?? ''); ?>
                            </div>

                            <?php if (!empty($stat['label'])) : ?>
                                <!-- Label -->
                                <p class="text-base md:text-lg lg:text-xl font-semibold <?php echo esc_attr($text_color); ?>">
                                    <?php echo esc_html($stat['label']); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('stats');
