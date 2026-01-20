<?php
/**
 * Services Cards Block Template
 * Zeigt Dienstleistungskarten in einem responsiven Grid-Layout
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('services-cards');

// Felder abrufen
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$description = socorif_get_field('description');
$cards = socorif_get_field('cards', []);
$columns = socorif_get_field('columns', '3');
$bg_color = socorif_get_field('bg_color', 'white');

// Spalten-Klassen - Mobile-First Responsive
$grid_cols = [
    '2' => 'grid-cols-1 md:grid-cols-2',
    '3' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    '4' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
];

// Textfarbe basierend auf Hintergrund
$is_dark_bg = $bg_color === 'secondary-dark';
$text_color = $is_dark_bg ? 'text-white' : '';
$text_muted = $is_dark_bg ? 'text-gray-300' : 'text-gray-600';

// Section-Klassen zusammenstellen
$section_classes = socorif_merge_classes(
    'services-cards-block section',
    'bg-' . $bg_color,
    $is_dark_bg ? '' : 'dark:bg-gray-900'
);
?>

<section class="<?php echo esc_attr($section_classes); ?>">
    <div class="container">

        <?php if ($subtitle || $title || $description) : ?>
            <!-- Sektion Kopfbereich -->
            <div class="text-center max-w-3xl mx-auto mb-8 md:mb-12">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-sm md:text-base">
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

        <?php if ($cards) : ?>
            <!-- Karten-Raster -->
            <div class="grid <?php echo esc_attr($grid_cols[$columns]); ?> gap-6 md:gap-8 lg:gap-10">
                <?php foreach ($cards as $card) :
                    // Recuperer le service selectionne
                    $service_id = $card['service'] ?? null;
                    if (!$service_id) continue;

                    // Donnees du service
                    $service_title = get_the_title($service_id);
                    $service_link = get_permalink($service_id);
                    $service_excerpt = get_the_excerpt($service_id);
                    $service_thumbnail = get_post_thumbnail_id($service_id);

                    // Utiliser les valeurs personnalisees ou celles du service
                    $card_image = !empty($card['custom_image']) ? $card['custom_image'] : $service_thumbnail;
                    $card_description = !empty($card['custom_description']) ? $card['custom_description'] : $service_excerpt;
                ?>
                    <div class="group bg-gradient-to-br from-white via-white to-gray-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-primary/30 cursor-pointer">
                        <?php if ($card_image) : ?>
                            <div class="relative overflow-hidden rounded-3xl m-4 mb-0 aspect-[4/3] shadow-lg">
                                <?php echo socorif_image($card_image, 'card', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110']); ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        <?php endif; ?>

                        <div class="p-6 md:p-8">
                            <h3 class="section-subtitle <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-3 border-l-4 border-primary pl-4 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-300">
                                <a href="<?php echo esc_url($service_link); ?>"
                                   class="hover:text-primary transition-colors duration-300 cursor-pointer">
                                    <?php echo esc_html($service_title); ?>
                                </a>
                            </h3>

                            <?php if ($card_description) : ?>
                                <p class="section-text <?php echo esc_attr($text_muted); ?> <?php echo $is_dark_bg ? '' : 'dark:text-gray-300'; ?> leading-relaxed mb-4">
                                    <?php echo esc_html($card_description); ?>
                                </p>
                            <?php endif; ?>

                            <div x-data="{ linkHover: false }">
                                <a href="<?php echo esc_url($service_link); ?>"
                                   class="inline-flex items-center gap-2 text-primary font-semibold text-sm cursor-pointer"
                                   @mouseenter="linkHover = true"
                                   @mouseleave="linkHover = false">
                                    <span>En savoir plus</span>
                                    <?php get_template_part('template-parts/components/cta-arrow', null, array('hover_state' => 'linkHover')); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
<?php
// Block-Ende markieren
socorif_block_comment_end('services-cards');
