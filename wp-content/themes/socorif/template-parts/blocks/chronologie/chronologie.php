<?php
/**
 * Timeline/Prozess Block Template
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('timeline');


// Felder abrufen
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$description = socorif_get_field('description');
$steps = socorif_get_field('steps', []);
$layout = socorif_get_field('layout', 'vertical');
$columns = socorif_get_field('columns', '4');
$bg_color = socorif_get_field('bg_color', 'white');

// Spalten-Klassen für Grid Layout
$grid_cols = [
    '2' => 'grid-cols-1 md:grid-cols-2',
    '3' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    '4' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
];

// Textfarbe basierend auf Hintergrund
$is_dark_bg = $bg_color === 'secondary-dark';
$text_color = $is_dark_bg ? 'text-white' : '';
$text_muted = $is_dark_bg ? 'text-gray-300' : 'text-gray-600';
$connector_color = $is_dark_bg ? 'bg-white/20' : 'bg-gray-300';

// Section-Klassen erstellen
$section_classes = socorif_merge_classes(
    'timeline-block section',
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

        <?php if ($subtitle || $title || $description) : ?>
            <!-- Sektion Kopfbereich -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 class="section-title <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-4">
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

        <?php if ($steps) : ?>
            <?php if ($layout === 'grid') : ?>
                <!-- Grid Layout - Vereinfachte Version für Bauprojekte -->
                <div class="grid <?php echo esc_attr($grid_cols[$columns]); ?> gap-6 md:gap-8">

                    <?php foreach ($steps as $index => $step) : ?>
                        <div class=" hover:cursor-pointer group bg-white dark:bg-gray-800 p-6 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-primary transition-all duration-300 hover:shadow-lg">

                            <!-- Nummer ohne Background -->
                            <div class="mb-4">
                                <span class="text-primary font-bold text-3xl">
                                    <?php echo esc_html($index + 1); ?>
                                </span>
                            </div>

                            <?php if (!empty($step['title'])) : ?>
                                <h3 class="text-lg md:text-xl font-bold <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-3">
                                    <?php echo esc_html($step['title']); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($step['description'])) : ?>
                                <p class="text-sm md:text-base <?php echo esc_attr($text_muted); ?> <?php echo $is_dark_bg ? '' : 'dark:text-gray-300'; ?> leading-relaxed">
                                    <?php echo esc_html($step['description']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($layout === 'horizontal') : ?>
                <!-- Horizontale Timeline -->
                <div class="hidden lg:grid lg:grid-cols-<?php echo min(count($steps), 4); ?> gap-8 relative">
                    <!-- Verbindungslinie -->
                    <div class="absolute top-12 left-0 right-0 h-1 <?php echo esc_attr($connector_color); ?> z-0"
                         style="margin-left: 3rem; margin-right: 3rem;"></div>

                    <?php foreach ($steps as $index => $step) : ?>
                        <div class="relative z-10">
                            <!-- Schritt-Nummer -->
                            <div class="mx-auto mb-6 text-center">
                                <span class="text-primary font-bold text-4xl md:text-5xl">
                                    <?php echo esc_html($index + 1); ?>
                                </span>
                            </div>

                            <?php if (!empty($step['title'])) : ?>
                                <h3 class="text-lg md:text-xl font-bold <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-3 text-center">
                                    <?php echo esc_html($step['title']); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($step['description'])) : ?>
                                <p class="text-sm md:text-base <?php echo esc_attr($text_muted); ?> <?php echo $is_dark_bg ? '' : 'dark:text-gray-300'; ?> text-center leading-relaxed">
                                    <?php echo esc_html($step['description']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Mobile: Vertikale Timeline -->
                <div class="lg:hidden space-y-6">
                    <?php foreach ($steps as $index => $step) : ?>
                        <div class="flex gap-4">
                            <!-- Schritt-Nummer -->
                            <div class="flex flex-col items-center">
                                <div class="flex-shrink-0 text-center">
                                    <span class="text-primary font-bold text-3xl">
                                        <?php echo esc_html($index + 1); ?>
                                    </span>
                                </div>
                                <?php if ($index < count($steps) - 1) : ?>
                                    <div class="w-1 h-full min-h-[80px] bg-gradient-to-b from-primary via-primary/50 to-primary mt-4 rounded-full"></div>
                                <?php endif; ?>
                            </div>

                            <!-- Inhalt -->
                            <div class="flex-1 pb-6 bg-gradient-to-br from-white via-white to-gray-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-3xl p-5 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border-2 border-gray-200 dark:border-gray-700">
                                <?php if (!empty($step['title'])) : ?>
                                    <h3 class="text-lg font-bold <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-2">
                                        <?php echo esc_html($step['title']); ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if (!empty($step['description'])) : ?>
                                    <p class="text-sm <?php echo esc_attr($text_muted); ?> <?php echo $is_dark_bg ? '' : 'dark:text-gray-300'; ?> leading-relaxed">
                                        <?php echo esc_html($step['description']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else : ?>
                <!-- Vertikale Timeline -->
                <div class="max-w-3xl mx-auto space-y-8">
                    <?php foreach ($steps as $index => $step) : ?>
                        <div class="flex gap-6 md:gap-8">
                            <!-- Schritt-Nummer -->
                            <div class="flex flex-col items-center">
                                <div class="flex-shrink-0 text-center">
                                    <span class="text-primary font-bold text-3xl md:text-4xl">
                                        <?php echo esc_html($index + 1); ?>
                                    </span>
                                </div>
                                <?php if ($index < count($steps) - 1) : ?>
                                    <div class="w-1 h-full min-h-[100px] bg-gradient-to-b from-primary via-primary/50 to-primary mt-6"></div>
                                <?php endif; ?>
                            </div>

                            <!-- Inhalt -->
                            <div class="flex-1 pb-10  cursor-pointer bg-gradient-to-br from-white via-white to-gray-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-3xl p-6 md:p-8 shadow-xl hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 hover:-translate-y-2 border-2 border-gray-200 dark:border-gray-700 hover:border-primary/30 group">
                                <?php if (!empty($step['title'])) : ?>
                                    <h3 class="text-lg md:text-xl font-bold <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-3 border-l-4 border-primary pl-4 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-300">
                                        <?php echo esc_html($step['title']); ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if (!empty($step['description'])) : ?>
                                    <p class="text-sm md:text-base <?php echo esc_attr($text_muted); ?> <?php echo $is_dark_bg ? '' : 'dark:text-gray-300'; ?> leading-relaxed">
                                        <?php echo esc_html($step['description']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('timeline');
