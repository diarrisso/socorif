<?php
/**
 * Text + Bild Block Template
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('text-image');


// Felder abrufen
$image = socorif_get_field('image');
$image_position = socorif_get_field('image_position', 'right');
$title = socorif_get_field('title');
$content = socorif_get_field('content');
$features = socorif_get_field('features', []);
$button = socorif_get_field('button');
$bg_color = socorif_get_field('bg_color', 'white');

// Textfarbe basierend auf Hintergrund
$is_dark_bg = $bg_color === 'secondary-dark';
$text_color = $is_dark_bg ? 'text-white' : '';
$text_muted = $is_dark_bg ? 'text-gray-300' : 'text-gray-600';

// Bild-Position
$image_order = $image_position === 'left' ? 'lg:order-1' : 'lg:order-2';
$content_order = $image_position === 'left' ? 'lg:order-2' : 'lg:order-1';

// Section-Klassen erstellen
$section_classes = socorif_merge_classes(
    'text-image-block section',
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">

            <!-- Bild -->
            <?php if ($image) : ?>
                <div class="<?php echo esc_attr($image_order); ?>">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl hover:shadow-3xl hover:shadow-primary/20 transition-all duration-500 group border-4 border-white dark:border-gray-800 hover:scale-[1.02]">
                        <?php echo socorif_image($image, 'large', ['class' => 'w-full h-auto transition-transform duration-500 group-hover:scale-105']); ?>
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-secondary-dark/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Textinhalt -->
            <div class="<?php echo esc_attr($content_order); ?>">

                <?php if ($title) : ?>
                    <h2 class="section-title <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> mb-4 md:mb-6 border-l-4 border-primary pl-6">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($content) : ?>
                    <div class="section-description <?php echo esc_attr($text_muted); ?> <?php echo $is_dark_bg ? '' : 'dark:text-gray-300'; ?> mb-6 md:mb-8">
                        <?php echo wp_kses_post(wpautop($content)); ?>
                    </div>
                <?php endif; ?>

                <?php if ($features) : ?>
                    <!-- Feature-Liste -->
                    <ul class="space-y-3 md:space-y-4 mb-6 md:mb-8">
                        <?php foreach ($features as $feature) : ?>
                            <?php if (!empty($feature['text'])) : ?>
                                <li class="flex items-start gap-3 md:gap-4 group/item">
                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-primary/10 to-primary/20 dark:from-primary/20 dark:to-primary/30 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover/item:shadow-xl group-hover/item:scale-110 transition-all duration-300 border border-primary/20">
                                        <?php if (!empty($feature['icon'])) : ?>
                                            <span class="text-primary text-lg md:text-xl"><?php echo esc_html($feature['icon']); ?></span>
                                        <?php else : ?>
                                            <svg class="w-5 h-5 md:w-6 md:h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <span class="section-text <?php echo esc_attr($text_color); ?> <?php echo $is_dark_bg ? '' : 'dark:text-white'; ?> flex-1 pt-2">
                                        <?php echo esc_html($feature['text']); ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($button) : ?>
                    <a href="<?php echo esc_url($button['url']); ?>"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-primary to-primary-dark text-white font-semibold rounded-3xl shadow-xl shadow-primary/30 hover:shadow-2xl hover:shadow-primary/40 transition-all duration-300 hover:scale-105 active:scale-95 group cursor-pointer"
                       <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                        <span><?php echo esc_html($button['title']); ?></span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                <?php endif; ?>

            </div>

        </div>

    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('text-image');
