<?php
/**
 * Slider Block Template
 *
 * Ein flexibler Slider/Karussell-Block mit vollständiger Anpassungsoption
 * Modernes Design mit verbesserten Bildeffekten und Animationen
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('slider');


// Block-Daten abrufen
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$slides = socorif_get_field('slides', []);
$bg_color = socorif_get_field('bg_color', 'white');

// Slider-Einstellungen
$slides_per_view_desktop = socorif_get_field('slides_per_view_desktop', 3);
$slides_per_view_tablet = socorif_get_field('slides_per_view_tablet', 2);
$slides_per_view_mobile = socorif_get_field('slides_per_view_mobile', 1);
$space_between = socorif_get_field('space_between', 30);
$autoplay = socorif_get_field('enable_autoplay', false);
$autoplay_delay = socorif_get_field('autoplay_delay', 5000);
$loop = socorif_get_field('enable_loop', true);
$pagination = socorif_get_field('show_pagination', true);
$navigation = socorif_get_field('show_navigation', true);
$speed = socorif_get_field('animation_speed', 600);
$effect = socorif_get_field('transition_effect', 'slide');

// Eindeutige ID für diese Slider-Instanz generieren
$slider_id = 'slider-' . uniqid();

// Hintergrundfarbe
$is_dark_bg = $bg_color === 'secondary-dark';
$text_color = $is_dark_bg ? 'text-white' : '';
$text_muted = $is_dark_bg ? 'text-gray-300' : 'text-gray-600';

// Section-Klassen
$section_classes = socorif_merge_classes(
    'slider-block',
    'section',
    'relative',
    'overflow-hidden',
    'bg-' . $bg_color,
    'dark:bg-gray-900'
);

// Swiper-Konfiguration als JSON erstellen - Une seule image à la fois
$swiper_config = [
    'slidesPerView' => 1,
    'spaceBetween' => 0,
    'speed' => 600,
    'loop' => (bool)$loop,
    'allowTouchMove' => true,
    'grabCursor' => true,
];

if ($autoplay) {
    $swiper_config['autoplay'] = [
        'delay' => (int)$autoplay_delay,
        'disableOnInteraction' => false,
        'pauseOnMouseEnter' => true,
        'waitForTransition' => true,
    ];
}

if ($pagination) {
    $swiper_config['pagination'] = [
        'el' => '#' . $slider_id . ' .swiper-pagination',
        'clickable' => true,
        'dynamicBullets' => true,
    ];
}

if ($navigation) {
    $swiper_config['navigation'] = [
        'nextEl' => '#' . $slider_id . ' .swiper-button-next',
        'prevEl' => '#' . $slider_id . ' .swiper-button-prev',
    ];
}

if (isset($block)) {
    $wrapper_attrs = socorif_get_block_wrapper_attributes($block, $section_classes);
    echo '<section ' . $wrapper_attrs . '>';
} else {
    echo '<section class="' . esc_attr($section_classes) . '">';
}
?>

    <div class="container relative z-10">

        <?php if (!empty($slides)) : ?>
            <div
                id="<?php echo esc_attr($slider_id); ?>"
                class="slider-container relative"
            >

                <div class="swiper pb-4 md:pb-8 h-auto min-h-[300px] md:min-h-[400px]">
                    <div class="swiper-wrapper">
                        <?php foreach ($slides as $slide) :
                            $image = $slide['image'] ?? null;

                            if (!$image) continue;
                        ?>
                            <div class="swiper-slide">
                                <div class="relative overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-900 aspect-[16/9]">
                                    <?php
                                    echo socorif_image(
                                        $image,
                                        'large',
                                        [
                                            'class' => 'w-full h-full object-cover',
                                            'loading' => 'lazy'
                                        ]
                                    );
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($navigation) : ?>
                        <!-- Navigation Buttons -->
                        <div class="swiper-button-prev !w-12 !h-12 md:!w-14 md:!h-14 !left-2 md:!left-4 rounded-full !bg-white !text-primary shadow-lg hover:shadow-xl transition-all after:!text-lg md:after:!text-xl !border-2 !border-gray-200 dark:!bg-gray-800 dark:!text-primary dark:!border-gray-700"></div>
                        <div class="swiper-button-next !w-12 !h-12 md:!w-14 md:!h-14 !right-2 md:!right-4 rounded-full !bg-white !text-primary shadow-lg hover:shadow-xl transition-all after:!text-lg md:after:!text-xl !border-2 !border-gray-200 dark:!bg-gray-800 dark:!text-primary dark:!border-gray-700"></div>
                    <?php endif; ?>

                    <?php if ($pagination) : ?>
                        <!-- Pagination -->
                        <div class="swiper-pagination !relative !mt-8 md:!mt-12"></div>
                    <?php endif; ?>
                </div>

            </div>

            <script>
                (function() {
                    function initSlider() {
                        if (typeof Swiper !== 'undefined') {
                            const config = <?php echo wp_json_encode($swiper_config); ?>;
                            new Swiper('#<?php echo esc_attr($slider_id); ?> .swiper', config);
                        } else {
                            setTimeout(initSlider, 100);
                        }
                    }

                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initSlider);
                    } else {
                        initSlider();
                    }
                })();
            </script>

        <?php else : ?>
            <div class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="<?php echo esc_attr($text_muted); ?> text-lg font-medium">
                    Aucune diapositive configuree. Ajoutez des diapositives dans les parametres du bloc.
                </p>
            </div>
        <?php endif; ?>

    </div>

    <!-- Dekorative Hintergrund-Elemente -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -z-10 opacity-50"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary/5 rounded-full blur-3xl -z-10 opacity-50"></div>

</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('slider');
