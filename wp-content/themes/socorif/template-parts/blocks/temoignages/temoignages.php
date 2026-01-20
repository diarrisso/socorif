<?php
/**
 * Testimonials Block Template
 *
 * Testimonial-Slider mit mehreren Kundenstimmen
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('testimonials');


// ACF-Felder abrufen
$section_title = socorif_get_field('section_title', '');
$testimonials = socorif_get_field('testimonials', []);

// Wenn keine Testimonials vorhanden sind, Block nicht anzeigen
if (empty($testimonials)) {
    return;
}

// Slider-Einstellungen
$autoplay = socorif_get_field('enable_autoplay', true);
$autoplay_delay = socorif_get_field('autoplay_delay', 6000);
$loop = socorif_get_field('enable_loop', true);
$pagination = socorif_get_field('show_pagination', true);
$navigation = socorif_get_field('show_navigation', true);

// Eindeutige ID für diese Slider-Instanz generieren
$slider_id = 'testimonials-' . uniqid();

// Section-Klassen
$section_classes = 'testimonials-block isolate overflow-hidden bg-white px-4 sm:px-6 lg:px-8 dark:bg-gray-900';

// Swiper-Konfiguration als JSON (Mobile-First)
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
        'dynamicBullets' => false,
    ];
}

if ($navigation) {
    $swiper_config['navigation'] = [
        'nextEl' => '#' . $slider_id . ' .swiper-button-next',
        'prevEl' => '#' . $slider_id . ' .swiper-button-prev',
    ];
}

?>

<section class="<?php echo esc_attr($section_classes); ?>">

    <div class="container mx-auto px-4 lg:px-8 py-12 sm:py-20 lg:py-32">

        <!-- Section Title -->
        <?php if ($section_title) : ?>
            <h2 class="section-title text-center text-primary mb-12 sm:mb-16 lg:mb-20 tracking-wider">
                <?php echo esc_html($section_title); ?>
            </h2>
        <?php endif; ?>

        <!-- Slider Container -->
        <div
            id="<?php echo esc_attr($slider_id); ?>"
            class="testimonials-slider-container relative px-8 sm:px-12 lg:px-16"
        >
            <div class="swiper h-auto min-h-[400px]">
                <div class="swiper-wrapper">
                    <?php foreach ($testimonials as $testimonial) : ?>
                        <?php
                        $quote = $testimonial['quote'] ?? '';
                        $person_name = $testimonial['person_name'] ?? '';
                        $person_title = $testimonial['person_title'] ?? '';

                        if (!$quote) continue;
                        ?>

                        <div class="swiper-slide h-auto flex items-center justify-center">
                            <figure class="flex flex-col items-center text-center max-w-2xl mx-auto px-4 py-8">

                                <!-- Quote -->
                                <div class="relative w-full mb-6">
                                    <blockquote class="section-description text-gray-800 dark:text-gray-200">
                                        <p><?php echo esc_html($quote); ?></p>
                                    </blockquote>
                                </div>

                                <!-- Person Info -->
                                <?php if ($person_name || $person_title) : ?>
                                    <figcaption class="section-text text-gray-600 dark:text-gray-400 mt-4">
                                        <?php
                                        $citation_parts = array_filter([$person_name, $person_title]);
                                        if (!empty($citation_parts)) {
                                            echo esc_html(implode(', ', $citation_parts));
                                        }
                                        ?>
                                    </figcaption>
                                <?php endif; ?>

                            </figure>
                        </div>

                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($pagination) : ?>
                    <div class="swiper-pagination !relative !mt-8 sm:!mt-10 lg:!mt-12"></div>
                <?php endif; ?>
            </div>

            <!-- Navigation Arrows -->
            <?php if ($navigation) : ?>
                <div class="swiper-button-prev !w-10 !h-10 sm:!w-11 sm:!h-11 md:!w-12 md:!h-12 !-left-2 sm:!-left-4 rounded-full !bg-white !text-primary shadow-md hover:shadow-lg transition-all after:!text-base sm:after:!text-lg !border-2 !border-gray-200 dark:!bg-gray-800 dark:!text-primary dark:!border-gray-700" aria-label="Temoignage precedent"></div>
                <div class="swiper-button-next !w-10 !h-10 sm:!w-11 sm:!h-11 md:!w-12 md:!h-12 !-right-2 sm:!-right-4 rounded-full !bg-white !text-primary shadow-md hover:shadow-lg transition-all after:!text-base sm:after:!text-lg !border-2 !border-gray-200 dark:!bg-gray-800 dark:!text-primary dark:!border-gray-700" aria-label="Temoignage suivant"></div>
            <?php endif; ?>
        </div>

        <script>
            (function() {
                function initTestimonialsSlider() {
                    if (typeof Swiper !== 'undefined') {
                        const config = <?php echo wp_json_encode($swiper_config); ?>;
                        new Swiper('#<?php echo esc_attr($slider_id); ?> .swiper', config);
                    } else {
                        setTimeout(initTestimonialsSlider, 100);
                    }
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initTestimonialsSlider);
                } else {
                    initTestimonialsSlider();
                }
            })();
        </script>

    </div>

</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('testimonials');
