<?php
/**
 * Before After Block Template
 */

if (!defined('ABSPATH')) exit;

// Felder abrufen
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$before_image = socorif_get_field('before_image');
$after_image = socorif_get_field('after_image');
$before_label = socorif_get_field('before_label', 'Vorher');
$after_label = socorif_get_field('after_label', 'Nachher');
$description = socorif_get_field('description');

$section_classes = 'before-after-block section bg-gray-50 dark:bg-gray-900';

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    socorif_block_comment_start('before-after');
    echo '<section ' . $wrapper_attrs . '>';
} else {
    socorif_block_comment_start('before-after');
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>
    <div class="container">

        <?php if ($subtitle || $title) : ?>
            <div class="text-center mb-12">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm">
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

        <?php if ($before_image && $after_image) : ?>
            <!-- Vorher/Nachher Slider -->
            <div class="max-w-4xl mx-auto"
                 x-data="{ position: 50 }"
                 x-on:mousemove="if ($event.buttons === 1) { position = Math.max(0, Math.min(100, ($event.clientX - $el.getBoundingClientRect().left) / $el.offsetWidth * 100)) }"
                 x-on:touchmove="position = Math.max(0, Math.min(100, ($event.touches[0].clientX - $el.getBoundingClientRect().left) / $el.offsetWidth * 100))">

                <div class="relative overflow-hidden rounded-3xl shadow-2xl hover:shadow-primary/20 aspect-[16/10] cursor-ew-resize select-none border-4 border-transparent hover:border-primary/20 transition-all duration-300">
                    <!-- Nachher-Bild (Hintergrund) -->
                    <div class="absolute inset-0">
                        <?php echo socorif_image($after_image, 'large', ['class' => 'w-full h-full object-cover']); ?>
                        <span class="absolute top-6 right-6 bg-gradient-to-r from-primary to-primary-dark text-white px-5 py-3 rounded-3xl text-sm md:text-base font-bold shadow-xl shadow-primary/30 uppercase tracking-wider">
                            <?php echo esc_html($after_label); ?>
                        </span>
                    </div>

                    <!-- Vorher-Bild (Beschnitten) -->
                    <div class="absolute inset-0 overflow-hidden"
                         :style="'clip-path: inset(0 ' + (100 - position) + '% 0 0)'">
                        <?php echo socorif_image($before_image, 'large', ['class' => 'w-full h-full object-cover']); ?>
                        <span class="absolute top-6 left-6 bg-gradient-to-r from-gray-900 to-gray-800 text-white px-5 py-3 rounded-3xl text-sm md:text-base font-bold shadow-xl uppercase tracking-wider">
                            <?php echo esc_html($before_label); ?>
                        </span>
                    </div>

                    <!-- Slider-Griff -->
                    <div class="absolute top-0 bottom-0 w-1 bg-gradient-to-b from-primary via-white to-primary shadow-2xl cursor-ew-resize"
                         :style="'left: ' + position + '%'"
                         @mousedown.prevent>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 bg-gradient-to-br from-primary to-primary-dark rounded-full shadow-2xl shadow-primary/40 flex items-center justify-center border-4 border-white hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Anleitung -->
                <p class="text-center text-sm text-gray-500 mt-4">
                    Zum Vergleichen ziehen
                </p>
            </div>
        <?php endif; ?>

        <?php if ($description) : ?>
            <div class="max-w-2xl mx-auto text-center mt-8">
                <p class="section-description">
                    <?php echo esc_html($description); ?>
                </p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php socorif_block_comment_end('before-after'); ?>
